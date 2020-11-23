<?php


/**
 * @author lin <465382251@qq.com>
 *
 * Fill in your key and secret and pass can be directly run
 *
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/okex-php.git
 * */
use \Lin\Bitmex\BitmexWebSocket;

require __DIR__ .'../../../vendor/autoload.php';

$bitmex=new BitmexWebSocket();

$bitmex->config([
    //Do you want to enable local logging,default false
    'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'bitmex'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Heartbeat time,default 30 seconds
    'ping_time'=>30,

    //baseurl host
    //'baseurl'=>'ws://www.bitmex.com/realtime',//default
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);

$bitmex->start();

