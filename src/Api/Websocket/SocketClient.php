<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api\WebSocket;

use Lin\Bitmex\Api\WebSocket\SocketGlobal;
use Lin\Bitmex\Api\WebSocket\SocketFunction;

use Workerman\Lib\Timer;
use Workerman\Worker;

class SocketClient
{
    use SocketGlobal;
    use SocketFunction;

    private $config=[];
    private $keysecret=[];


    function __construct(array $config=[])
    {
        $this->config=$config;

        $this->client();

        $this->init();
    }

    protected function init(){
        //初始化全局变量
        $this->add('global_key',[]);//保存全局变量key

        $this->add('all_sub',[]);//目前总共订阅的频道

        $this->add('add_sub',[]);//正在订阅的频道

        $this->add('del_sub',[]);//正在删除的频道

        $this->add('keysecret',[]);//目前总共key
    }

    function keysecret(array $keysecret=[]){
        $this->keysecret=$keysecret;
        return $this;
    }

    /**
     * @param array $sub
     */
    public function subscribe(array $sub=[]){
        // 是否又私有频道订阅
        if(!empty($this->keysecret)) {
            $keysecret=$this->get('keysecret');

            if(!isset($keysecret[$this->keysecret['key']]['connection']))
            $this->keysecretInit($this->keysecret,[
                'connection'=>0,
            ]);
        }

        $this->save('add_sub',$this->resub($sub));
    }

    /**
     * @param array $sub
     */
    public function unsubscribe(array $sub=[]){
        $this->save('del_sub',$this->resub($sub));
    }

    /**
     * @param array $sub    默认获取所有public订阅的数据，private数据需要设置keysecret
     * @param null $callback
     * @param bool $daemon
     * @return mixed
     */
    public function getSubscribe(array $sub,$callback=null,$daemon=false){
        if($daemon) $this->daemon($callback,$sub);

        return $this->getData($this,$callback,$sub);
    }

    /**
     * 返回订阅的所有数据
     * @param null $callback
     * @param bool $daemon
     * @return array
     */
    public function getSubscribes($callback=null,$daemon=false){
        if($daemon) $this->daemon($callback);

        return $this->getData($this,$callback);
    }

    protected function daemon($callback=null,$sub=[]){
        $worker = new Worker();
        $worker->onWorkerStart = function() use($callback,$sub) {
            $global = $this->client();

            $time=isset($this->config['data_time']) ? $this->config['data_time'] : 0.5 ;

            Timer::add($time, function() use ($global,$callback,$sub){
                $this->getData($global,$callback,$sub);
            });
        };
        Worker::runAll();
    }

    /**
     * @param $global
     * @param null $callback
     * @param array $sub 返回规定的频道
     * @return array
     */
    protected function getData($global,$callback=null,$sub=[]){
        $all_sub=$global->get('all_sub');
        if(empty($all_sub)) return [];

        $temp=[];

        //默认返回所有数据
        if(empty($sub)){
            foreach ($all_sub as $k=>$v){
                if(is_array($v)) $table=$k;
                else $table=$v;

                $data=$global->get(strtolower($table));
                if(empty($data)) continue;
                $temp[$table]=$data;
            }
        }else{
            //die('hh');
            //返回规定的数据
            if(!empty($this->keysecret)) {
                //是否有私有数据
                $all_sub=$global->get('all_sub');
                if(isset($all_sub[$this->keysecret['key']])) $sub=array_merge($sub,$all_sub[$this->keysecret['key']]);
            }
            //print_r($sub);
            foreach ($sub as $k=>$v){
                $data=$global->get(strtolower($v));
                if(empty($data)) continue;

                $temp[$v]=$data;
            }
        }

        if($callback!==null){
            call_user_func_array($callback, array($temp));
        }

        return $temp;
    }

    function test(){
        print_r($this->client->all_sub);
        print_r($this->client->add_sub);
        print_r($this->client->del_sub);
        print_r($this->client->keysecret);
        print_r($this->client->global_key);
    }

    function test2(){
        //print_r($this->client->global_key);
        $global_key=$this->client->global_key;
        foreach ($global_key as $k=>$v){
            echo count($this->client->$v).$k.PHP_EOL;
        }
    }
}
