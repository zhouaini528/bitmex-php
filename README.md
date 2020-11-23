### It is recommended that you use the test server first

Online interface testing [https://www.bitmex.com/api/explorer/](https://www.bitmex.com/api/explorer/)

Address of the test [https://testnet.bitmex.com](https://testnet.bitmex.com)

The official address [https://www.bitmex.com](https://www.bitmex.com)

All interface methods are initialized the same as those provided by Bitmex. See details [src/api](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)

Support [Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README.md#Websocket)

Most of the interface is now complete, and the user can continue to extend it based on my design, working with me to improve it.

[中文文档](https://github.com/zhouaini528/bitmex-php/blob/master/README_CN.md)

### Other exchanges API

[Exchanges](https://github.com/zhouaini528/exchanges-php) It includes all of the following exchanges and is highly recommended.

[Bitmex](https://github.com/zhouaini528/bitmex-php) Support [Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README.md#Websocket)

[Okex](https://github.com/zhouaini528/okex-php) Support [Websocket](https://github.com/zhouaini528/okex-php/blob/master/README.md#Websocket)

[Huobi](https://github.com/zhouaini528/huobi-php) Support [Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README.md#Websocket)

[Binance](https://github.com/zhouaini528/binance-php) Support [Websocket](https://github.com/zhouaini528/binance-php/blob/master/README.md#Websocket)

[Kucoin](https://github.com/zhouaini528/Kucoin-php)

[Mxc](https://github.com/zhouaini528/mxc-php)

[Coinbase](https://github.com/zhouaini528/coinbase-php)

[ZB](https://github.com/zhouaini528/zb-php)

[Bitfinex](https://github.com/zhouaini528/zb-php)

[Bittrex](https://github.com/zhouaini528/bittrex-php)

[Gate](https://github.com/zhouaini528/gate-php)

[Bigone](https://github.com/zhouaini528/bigone-php)   

[Crex24](https://github.com/zhouaini528/crex24-php)   

#### Installation
```
composer require linwj/bitmex
```

Support for more request Settings [More](https://github.com/zhouaini528/bitmex-php/blob/master/tests/proxy.php#L24)
```php
$bitmex=new Bitmex();

//You can set special needs
$bitmex->setOptions([
    //Set the request timeout to 60 seconds by default
    'timeout'=>10,
    
    //If you are developing locally and need an agent, you can set this
    'proxy'=>true,
    //More flexible Settings
    /* 'proxy'=>[
     'http'  => 'http://127.0.0.1:12333',
     'https' => 'http://127.0.0.1:12333',
     'no'    =>  ['.cn']
     ], */
    //Close the certificate
    //'verify'=>false,
]);
```

Book Data [More](https://github.com/zhouaini528/bitmex-php/blob/master/tests/position.php)
```php
//Get market data
//Book data may be key and secret
try {
    $bitmex=new Bitmex();
    $result=$bitmex->orderBook()->get([
        'symbol'=>'ETHUSD',
        'depth'=>20
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

Order [More](https://github.com/zhouaini528/bitmex-php/blob/master/tests/order.php)
```php
//Test API address  default  https://www.bitmex.com
$key='eLB_l505a_cuZL8Cmu5uo7EP';
$secret='wG3ndMquAPl6c-jHUQNhyBQJKGBwdFenIF2QxcgNKE_g8Kz3';
$host='https://testnet.bitmex.com';

$bitmex=new Bitmex($key,$secret,$host);

//bargaining transaction
try {
    $result=$bitmex->order()->post([
        'symbol'=>'XBTUSD',
        'price'=>'100',
        'side'=>'Buy',
        'orderQty'=>'1',
        'ordType'=>'Limit',
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//track the order
try {
    $result=$bitmex->order()->getOne([
        'symbol'=>'XBTUSD',
        'orderID'=>$result['orderID'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//update the order
try {
    $result=$bitmex->order()->put([
        'symbol'=>'XBTUSD',
        'orderID'=>$result['orderID'],
        'price'=>'200',
        'orderQty'=>'2',
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}

//cancellation of order
try {
    $result=$bitmex->order()->delete([
        'symbol'=>'XBTUSD',
        'orderID'=>$result['orderID'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```


Postion [More](https://github.com/zhouaini528/bitmex-php/blob/master/tests/position.php)
```php
//bargaining transaction
try {
    //Default return all
    $result=$bitmex->position()->get([
        //'filter'=>'{"symbol": "XBTUSD"}',
        //'columns'=>'markPrice',
        //'count'=>1,
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
}
```

[More Test](https://github.com/zhouaini528/bitmex-php/tree/master/tests)

[More API](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)

### Websocket

Websocket has two services, server and client. The server is responsible for dealing with the new connection of the exchange, data receiving, authentication and login. Client is responsible for obtaining and processing data.

Server initialization must be started in cli mode.
```php
use \Lin\Bitmex\BitmexWebSocket;
require __DIR__ .'./vendor/autoload.php';

$bitmex=new BitmexWebSocket();

$bitmex->config([
    //Do you want to enable local logging,default false
    //'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'bitmex'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Heartbeat time,default 30 seconds
    //'ping_time'=>30,

    //baseurl host
    //'baseurl'=>'ws://www.bitmex.com/realtime',//default
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);

$bitmex->start();
```

If you want to test, you can "php server.php start" immediately outputs the log at the terminal.

If you want to deploy, you can "php server.php start -d" enables resident process mode, and enables "log=>true" to view logs.

[More Test](https://github.com/zhouaini528/bitmex-php/tree/master/tests/websocket)

Client side initialization.
```php
$bitmex=new BitmexWebSocket();

$bitmex->config([
    //Do you want to enable local logging,default false
    //'log'=>true,
    //Or set the log name
    'log'=>['filename'=>'bitmex'],

    //Daemons address and port,default 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //Channel data update time,default 0.5 seconds
    //'data_time'=>0.5,

    //Heartbeat time,default 30 seconds
    //'ping_time'=>30,

    //baseurl host
    //'baseurl'=>'ws://www.bitmex.com/realtime',//default
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);
```

Subscribe
```php
//You can only subscribe to public channels
$bitmex->subscribe([
    //public
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
]);

//You can also subscribe to both private and public channels.If keysecret() is set, all private channels will be subscribed by default
$bitmex->keysecret([
    'key'=>'xxxxxxxxx',
    'secret'=>'xxxxxxxxx',
]);
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
```

Unsubscribe
```php
//Unsubscribe from public channels
$bitmex->unsubscribe([
    //public
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
]);

//Unsubscribe from public and private channels.If keysecret() is set, private channels will be Unsubscribed by default
$bitmex->keysecret([
    'key'=>'xxxxxxxxx',
    'secret'=>'xxxxxxxxx',
]);
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
```

Get all channel subscription data
```php
//The first way
$data=$bitmex->getSubscribe();
print_r(json_encode($data));

//The second way callback
$bitmex->getSubscribe(function($data){
    print_r(json_encode($data));
});

//The third way is to guard the process
$bitmex->getSubscribe(function($data){
    print_r(json_encode($data));
},true);
```

Get partial channel subscription data
```php
//The first way
$data=$bitmex->getSubscribe([
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
]);
print_r(json_encode($data));

//The second way callback
$bitmex->getSubscribe([
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
],function($data){
    print_r(json_encode($data));
});

//The third way is to guard the process
$bitmex->getSubscribe([
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
],function($data){
    print_r(json_encode($data));
},true);
```

Get partial private channel subscription data
```php
//The first way
$bitmex->keysecret($key_secret);
$data=$bitmex->getSubscribe();//Return all data of private channel
print_r(json_encode($data));

//The second way callback
$bitmex->keysecret($key_secret);
$bitmex->getSubscribe([//Return data private and market 
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
$bitmex->keysecret($key_secret);
$bitmex->getSubscribe([//Resident process to get data return frequency $bitmex->config['data_time']=0.5s
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
```


