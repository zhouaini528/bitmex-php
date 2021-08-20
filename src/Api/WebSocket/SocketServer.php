<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api\WebSocket;

use Lin\Bitmex\Api\WebSocket\SocketGlobal;
use Lin\Bitmex\Api\WebSocket\SocketFunction;
use Lin\Bitmex\Exceptions\Exception;
use Workerman\Lib\Timer;
use Workerman\Worker;
use Workerman\Connection\AsyncTcpConnection;

class SocketServer
{
    use SocketGlobal;
    use SocketFunction;

    private $worker;

    private $connection=[];
    private $connectionIndex=0;
    private $config=[];

    private $public_url=['public','kline'];
    private $local_global=['public'=>[],'private'=>[]];

    function __construct(array $config=[])
    {
        $this->config=$config;
    }

    public function start(){
        $this->worker = new Worker();
        $this->server();

        $this->worker->onWorkerStart = function() {
            $this->addConnection('public');
        };

        Worker::runAll();
    }

    private function addConnection(string $tag,array $keysecret=[]){
        $this->newConnection()($tag,$keysecret);
    }

    private function getBaseUrl($tag,$keysecret){
        if(isset($this->config['baseurl'])) return $this->config['baseurl'];
        return $this->config['baseurl']='ws://www.bitmex.com/realtime';
    }

    private function newConnection(){
        return function($tag,$keysecret){
            $baseurl=$this->getBaseUrl($tag,$keysecret);

            $global=$this->client();

            $this->connection[$this->connectionIndex] = new AsyncTcpConnection($baseurl);
            $this->connection[$this->connectionIndex]->transport = 'ssl';

            $this->log('Connection '.$baseurl);

            //自定义属性
            $this->connection[$this->connectionIndex]->tag=$tag;//标记公共连接还是私有连接
            $this->connection[$this->connectionIndex]->tag_baseurl=$baseurl;
            $this->connection[$this->connectionIndex]->tag_reconnection_num=0;//标记当前已重连次数
            if(!empty($keysecret)) $this->connection[$this->connectionIndex]->tag_keysecret=$keysecret;//标记私有连接

            $this->connection[$this->connectionIndex]->onConnect=$this->onConnect($keysecret);
            $this->connection[$this->connectionIndex]->onMessage=$this->onMessage($global);
            $this->connection[$this->connectionIndex]->onClose=$this->onClose($global);
            $this->connection[$this->connectionIndex]->onError=$this->onError();

            $this->connect($this->connection[$this->connectionIndex]);
            $this->other($this->connection[$this->connectionIndex],$global);
            $this->ping($this->connection[$this->connectionIndex]);

            $this->connectionIndex++;
        };
    }

    private function onConnect(array $keysecret){
        return function($con) use($keysecret){
            if(empty($keysecret)) return;

            $this->keysecretInit($keysecret,[
                'connection'=>1,
                'auth'=>0,
            ]);

            $data=[
                "op"=>"authKeyExpires",
                'args'=>$this->sign($keysecret),
            ];

            $con->send(json_encode($data));

            $this->log($keysecret['key'].' private send sign');
            $this->log($data);
        };
    }

    private function onMessage($global){
        return function($con,$data) use($global){
            if($data=='pong'){
                $this->log($con->tag.' receive pong');
                return;
            }
            $data=json_decode($data,true);

            if($con->tag=='public'){
                if(isset($data['table']) && isset($data['data'][0]['symbol'])) {
                    $table=strtolower($data['table'].':'.$data['data'][0]['symbol']);
                    //$global->save($table,$data);
                    $this->local_global['public'][$table]=$data;

                    /*$debug=$global->get('debug2');
                    if($debug==1){
                        $con->tag_data_time='1619151157';
                        return;
                    }*/

                    //最后数据更新时间
                    $con->tag_data_time=time();
                    //成功接收数据重连次数回归0
                    $con->tag_reconnection_num=0;
                    return;
                }
            }else{
                //private auth login
                if(isset($data['success']) && isset($data['request']['op']) && $data['request']['op']=='authKeyExpires' && $data['success']) {
                    $this->keysecretInit($con->tag_keysecret,[
                        'connection'=>1,
                        'auth'=>1,
                    ]);
                    $this->log($con->tag_keysecret['key'].' auth login '.json_encode($data));
                    return;
                }

                if(isset($data['table']) && isset($data['data'])){
                    $table=$this->userKey($con->tag_keysecret,$data['table']);
                    $global->saveQueue(strtolower($table),$data);
                    return;
                }
            }

            $this->log($data);
        };
    }

    private function onClose($global){
        return function($con) use($global){
            //这里连接失败 会轮询 connect
            if(in_array($con->tag,$this->public_url)) {
                //TODO如果连接失败  应该public  private 都行重新加载
                $this->log($con->tag.' reconnection');

                //Clear public cached data
                foreach ($this->local_global['public'] as $k=>$v) unset($this->local_global['public'][$k]);

                $this->reconnection($global,'public');
            }else{
                $this->log('private connection close,ready to reconnect '.$con->tag_keysecret['key']);

                //更改登录状态
                $this->keysecretInit($con->tag_keysecret,[
                    'connection'=>2,
                    'auth'=>0,
                ]);

                //重新订阅私有频道
                $this->reconnection($global,'private',$con->tag_keysecret);
                //Timer::del($con->timer_other);
            }

            $con->reConnect(10);
        };
    }

    private function onError(){
        return function($con, $code, $msg){
            $this->log('onerror code:'.$code.' msg:'.$msg);
        };
    }

    private function connect($con){
        $con->connect();
    }

    private function other($con,$global){
        $time=isset($this->config['listen_time']) ? $this->config['listen_time'] : 2 ;

        $con->timer_other=Timer::add($time, function() use($con,$global) {
            $this->subscribe($con,$global);

            $this->unsubscribe($con,$global);

            $this->account($con,$global);

            $this->debug($con,$global);

            $this->log('listen '.$con->tag);

            //公共数据如果60秒内无数据更新，则断开连接重新订阅，重试次数不超过10次
            if(in_array($con->tag,$this->public_url)) {
                /*if(isset($con->tag_data_time)){
                    //debug
                    echo time() - $con->tag_data_time;
                    echo PHP_EOL;
                }*/

                //public
                if (isset($con->tag_data_time) && time() - $con->tag_data_time > 60 * ($con->tag_reconnection_num + 1) && $con->tag_reconnection_num <= 10) {
                    $con->close();

                    $con->tag_reconnection_num++;

                    $this->log('listen ' . $con->tag . ' reconnection_num:' . $con->tag_reconnection_num . ' tag_data_time:' . $con->tag_data_time);
                }
            }else{
                //private
            }
        });

        //异步保存数据，不然会有阻塞问题。 0.2秒保存一次
        Timer::add(0.2, function() use($global) {
            $global->save('global_local',$this->local_global);
        });
    }

    /**
     * 调试用
     * @param $con
     * @param $global
     */
    private function debug($con,$global){
        $debug=$global->get('debug');

        if(in_array($con->tag,$this->public_url)) {
            //public

            if(isset($debug['public']) && $debug['public'][$con->tag]=='close'){
                $this->log($con->tag.' debug '.json_encode($debug));

                $debug['public'][$con->tag]='recon';
                $global->save('debug',$debug);

                $con->close();
            }
        }else{
            //private
            if(isset($debug['private'][$con->tag_keysecret['key']]) && $debug['private'][$con->tag_keysecret['key']]=='close'){
                $this->log($con->tag_keysecret['key'].' debug '.json_encode($debug));

                $debug['private'][$con->tag_keysecret['key']]='recon';
                $global->save('debug',$debug);

                //更改登录状态
                $this->keysecretInit($con->tag_keysecret,[
                    'connection'=>2,
                    'auth'=>0,
                ]);

                $con->close();
            }
        }
    }

    private function ping($con){
        $time=isset($this->config['ping_time']) ? $this->config['ping_time'] : 30 ;

        $con->timer_ping=Timer::add($time, function() use ($con) {
            $con->send('ping');

            $this->log($con->tag.' send ping');
        });
    }

    private function subscribe($con,$global){
        $sub=$global->get('add_sub');
        if(empty($sub)) {
            //$this->log($con->tag.' subscribe dont change return');
            return;
        }

        $temp=['public'=>[], 'private'=>[]];
        foreach ($sub as $v){
            if(count($v)>1) array_push($temp['private'],$v);
            else array_push($temp['public'],$v);
        }

        if($con->tag=='public' && !empty($temp['public'])){
            $sub=[];
            foreach ($temp['public'] as $v) $sub[]=$v[0];

            $data=[
                "op"=>'subscribe',
                'args'=>$sub
            ];

            $data=json_encode($data);
            $con->send($data);

            $this->log($data);
            $this->log($con->tag.' subscribe send');

            $global->addSubUpdate($temp['public']);
            $global->allSubUpdate($temp['public'],'add');
        }

        if($con->tag!='public' && !empty($temp['private'])){
            //判断是否鉴权登录
            $keysecret=$global->get('keysecret');
            if($keysecret[$con->tag_keysecret['key']]['auth']!=1 || $keysecret[$con->tag_keysecret['key']]['key']!=$con->tag_keysecret['key']) {
                $this->log($con->tag_keysecret['key'].' subscribe need login ');
                return;
            }

            $sub=[];
            foreach ($temp['private'] as $v) $sub[]=$v[0];

            $data=[
                "op"=>'subscribe',
                'args'=>$sub
            ];

            $data=json_encode($data);
            $con->send($data);

            $this->log($data);
            $this->log($con->tag_keysecret['key'].' subscribe send');

            $global->addSubUpdate($temp['private'] );
            $global->allSubUpdate($temp['private'] ,'add');
        }

        return;
    }

    private function unsubscribe($con,$global){
        $unsub=$this->get('del_sub');
        if(empty($unsub)) {
            //$this->log($con->tag.' unsubscribe dont change return');
            return;
        }

        $temp=['public'=>[], 'private'=>[]];
        foreach ($unsub as $v){
            if(count($v)>1) array_push($temp['private'],$v);
            else array_push($temp['public'],$v);
        }

        if($con->tag=='public' && !empty($temp['public'])){
            $unsub=[];
            foreach ($temp['public'] as $v) $unsub[]=$v[0];

            $data=[
                "op"=>'unsubscribe',
                'args'=>$unsub
            ];
            $data=json_encode($data);
            $con->send($data);

            $this->log($data);
            $this->log($con->tag.' unsubscribe send');

            $global->delSubUpdate($temp['public']);
            $global->allSubUpdate($temp['public'],'del');
        }

        if($con->tag!='public' && !empty($temp['private'])){
            $unsub=[];
            foreach ($temp['private'] as $v) $unsub[]=$v[0];

            $data=[
                "op"=>'unsubscribe',
                'args'=>$unsub
            ];
            $data=json_encode($data);
            $con->send($data);

            $this->log($data);
            $this->log($con->tag.' unsubscribe send');

            $global->delSubUpdate($temp['private']);
            $global->allSubUpdate($temp['private'],'del');
        }

        return;
    }

    private function account($con,$global){
        $keysecret=$global->get('keysecret');
        if(empty($keysecret)) return;

        foreach ($keysecret as $k=>$v){
            //是否取消连接
            if($con->tag!='public' && isset($v['connection_close']) && $v['connection_close']==1){
                $con->close();

                $this->keysecretInit($v,[]);

                $this->log('private connection close '.$v['key']);
                continue;
            }


            //是否有新的连接
            if(isset($v['connection'])){
                switch ($v['connection']){
                    case 0:{
                        $this->keysecretInit($v,[
                            'connection'=>2,
                            'connection_close'=>0,
                            'auth'=>0,
                        ]);

                        $this->log('private order new connection '.$v['key']);

                        $this->addConnection($v['key'],$v);
                        break;
                    }
                    case 1:{
                        //$this->log('login');
                        break;
                    }
                    case 2:{
                        $this->log('private already order return '.$v['key']);
                        break;
                    }
                }
            }

        }
    }


}
