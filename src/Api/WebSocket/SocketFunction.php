<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api\WebSocket;


trait SocketFunction
{
    //标记分隔符
    static $USER_DELIMITER='===';

    /**
     * @param array $sub
     * @return array
     */
    protected function resub(array $sub=[]){
        $new_sub=[];

        //私有频道
        $temp1=[
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ];

        foreach ($sub as $v) {
            $temp_tag=false;
            $temp2=[$v];
            foreach ($temp1 as $tv){
                if(strpos($v, $tv) !== false){
                    //order是私有   orderBook是公共  需要区别一下
                    if($tv=='order' && strpos($v, 'orderBook') !== false) {
                        array_push($new_sub,$temp2);
                        $temp_tag=true;
                    }
                    else array_push($temp2,empty($this->keysecret)? [] : $this->keysecret);
                }
            }
            if(!$temp_tag) array_push($new_sub,$temp2);
        }

        return $new_sub;
    }

    protected function log($message){
        if (!is_string($message)) $message=json_encode($message);

        $time=time();
        $tiemdate=date('Y-m-d H:i:s',$time);

        $message=$tiemdate.' '.$message.PHP_EOL;

        if(isset($this->config['log'])){
            if(is_array($this->config['log']) && isset($this->config['log']['filename'])){
                $filename=$this->config['log']['filename'].'-'.date('Y-m-d',$time).'.txt';
            }else{
                $filename=date('Y-m-d',$time).'.txt';
            }

            file_put_contents($filename,$message,FILE_APPEND);
        }

        echo $message;
    }

    /**
     * 设置用户key
     * @param $keysecret
     */
    protected function userKey(array $keysecret,string $sub){
        return $keysecret['key'].self::$USER_DELIMITER.$sub;
    }

    /**
     * 根据Bitmex规则排序
     * */
    protected function sort($param)
    {
        $u = [];
        $sort_rank = [];
        foreach ($param as $k => $v) {
            if(is_array($v)) $v=json_encode($v);
            $u[] = $k . "=" . urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);

        return $u;
    }

    private function sign(array $keysecret){
        //签名是十六进制的 hex(HMAC_SHA256(secret, 'GET/realtime' + expires))
        // expires 必须是一个数字，而不是一个字符串。
        //{"op": "authKeyExpires", "args": ["<APIKey>", <expires>, "<signature>"]}

        //Time delay 10 seconds
        $expires=time()+10;

        $signature=hash_hmac('sha256', 'GET/realtime'.$expires, $keysecret['secret']);

        return [
            $keysecret['key'],
            $expires,
            $signature
        ];
    }


    /**
     * 重新订阅
     */
    private function reconnection($global,$type='public',array $keysecret=[]){
        $all_sub=$global->get('all_sub');
        if(empty($all_sub)) return;

        if($type=='public'){
            $temp=[];
            foreach ($all_sub as $v){
                if(!is_array($v)) $temp[]=$v;
            }
        }else{
            $this->keysecret=$keysecret;

            $sub=$all_sub[$keysecret['key']];
            if(empty($sub)) return;

            foreach ($sub as $v){
                $t=explode(self::$USER_DELIMITER,$v);
                if($t[1]=='privatenotifications') $t[1]='privateNotifications';//该私有频道单独处理，订阅对大小写敏感
                $temp[]=$t[1];
            }
        }

        if(empty($temp)) return;

        $global->save('add_sub',$this->resub($temp));
    }
}
