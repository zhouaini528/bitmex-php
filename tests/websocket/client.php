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

include 'key_secret.php';

$bitmex=new BitmexWebSocket();

$bitmex->config([
    //Do you want to enable local logging,default false
    //'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'future'],

    //Daemons address and port,default 0.0.0.0:2216
    //'global'=>'127.0.0.1:2216',

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Heartbeat time,default 30 seconds
    //'ping_time'=>30,

    //baseurl host
    //'baseurl'=>'ws://www.bitmex.com/realtime',//default
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);

$action=intval($_GET['action'] ?? 0);//http pattern
if(empty($action)) $action=intval($argv[1]);//cli pattern

switch ($action){
    //**************public
    //subscribe
    case 1:{
        $bitmex->subscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',
        ]);
        break;
    }

    //unsubscribe
    case 2:{
        $bitmex->unsubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',
        ]);

        break;
    }

    case 3:{

        $bitmex->subscribe([
            //public
            "quote:XBTUSD",
            "quoteBin1m:XBTUSD",
            "quoteBin5m:XBTUSD",
            "trade:XBTUSD",
            "tradeBin1m:XBTUSD",
            "tradeBin5m:XBTUSD",
        ]);

        break;
    }

    case 4:{
        $bitmex->unsubscribe([
            //public
            "quote:XBTUSD",
            "quoteBin1m:XBTUSD",
            "quoteBin5m:XBTUSD",
            "trade:XBTUSD",
            "tradeBin1m:XBTUSD",
            "tradeBin5m:XBTUSD",
        ]);

        break;
    }

    //**************private
    //subscribe
    case 10:{
        /*
        $bitmex->keysecret([
            'key'=>'xxxxxxxxx',
            'secret'=>'xxxxxxxxx',
        ]);
        */

        $bitmex->keysecret($key_secret[0]);
        $bitmex->subscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',

            //private
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ]);

        break;
    }

    //unsubscribe
    case 11:{
        $bitmex->keysecret($key_secret[0]);
        $bitmex->unsubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',

            //private
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ]);

        break;
    }

    case 20:{
        //****Three ways to get all data

        //The first way
        $data=$bitmex->getSubscribes();
        print_r(json_encode($data));
        die;
        //The second way callback
        $bitmex->getSubscribes(function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $bitmex->getSubscribes(function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 21:{
        //****Three ways return to the specified channel data

        //The first way
        $data=$bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',
        ]);
        print_r($data);

        //The second way callback
        $bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',
        ],function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 22:{
        //****Three ways return to the specified channel data,All private data is also returned by default

        //The first way
        $bitmex->keysecret($key_secret[0]);
        $data=$bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',

            //private
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ]);
        print_r(json_encode($data));
        die;
        //The second way callback
        $bitmex->keysecret($key_secret[0]);
        $bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',

            //private
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ],function($data){
            print_r(json_encode($data));
        });

        //The third way is to guard the process
        $bitmex->keysecret($key_secret[0]);
        $bitmex->getSubscribe([
            //public
            'orderBook10:XBTUSD',
            'quoteBin5m:XBTUSD',

            //private
            "affiliate",
            "execution",
            "order",
            "margin",
            "position",
            "privateNotifications",
            "transact",
            "wallet"
        ],function($data){
            print_r(json_encode($data));
        },true);

        break;
    }

    case 99:{
        $bitmex->client()->test();
        break;
    }

    case 10004:{
        $bitmex->client()->test2();
        break;
    }

    case 10005:{
        $bitmex->client()->test_reconnection();

        break;
    }
}


