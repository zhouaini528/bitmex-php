### 建议优先用测试服务器

在线接口测试[https://www.bitmex.com/api/explorer/](https://www.bitmex.com/api/explorer/)

测试服务器[https://testnet.bitmex.com](https://testnet.bitmex.com)

正式服务器[https://www.bitmex.com](https://www.bitmex.com)

所有的接口方式初始化与bitmex提供的接口方式一样，详细请看[src/api](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)

支持[Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README_CN.md#Websocket)

大部分的接口已经完成，使用者可以根据我的设计方案继续扩展，欢迎与我一起迭代它。

[English Document](https://github.com/zhouaini528/bitmex-php/blob/master/README.md)

QQ交流群：668421169

### 其他交易所API

[Exchanges](https://github.com/zhouaini528/exchanges-php) 它包含以下所有交易所，强烈推荐使用该SDK。

[Bitmex](https://github.com/zhouaini528/bitmex-php) 支持[Websocket](https://github.com/zhouaini528/bitmex-php/blob/master/README_CN.md#Websocket)

[Okex](https://github.com/zhouaini528/okex-php) 支持[Websocket](https://github.com/zhouaini528/okex-php/blob/master/README_CN.md#Websocket)

[Huobi](https://github.com/zhouaini528/huobi-php) 支持[Websocket](https://github.com/zhouaini528/huobi-php/blob/master/README_CN.md#Websocket)

[Binance](https://github.com/zhouaini528/binance-php) 支持[Websocket](https://github.com/zhouaini528/binance-php/blob/master/README_CN.md#Websocket)

[Kucoin](https://github.com/zhouaini528/kucoin-php)

[Mxc](https://github.com/zhouaini528/mxc-php)

[Coinbase](https://github.com/zhouaini528/coinbase-php)

[ZB](https://github.com/zhouaini528/zb-php)

[Bitfinex](https://github.com/zhouaini528/zb-php)

[Bittrex](https://github.com/zhouaini528/bittrex-php)

[Kraken](https://github.com/zhouaini528/kraken-php)

[Gate](https://github.com/zhouaini528/gate-php)   

[Bigone](https://github.com/zhouaini528/bigone-php)   

[Crex24](https://github.com/zhouaini528/crex24-php)   

[Bybit](https://github.com/zhouaini528/bybit-php)  

[Coinbene](https://github.com/zhouaini528/coinbene-php)   

[Bitget](https://github.com/zhouaini528/bitget-php)   

[Poloniex](https://github.com/zhouaini528/poloniex-php)

**如果没有找到你想要的交易所SDK你可以告诉我，我来加入它们。**



#### 安装方式
```
composer require linwj/bitmex
```

支持更多的请求设置 [More](https://github.com/zhouaini528/bitmex-php/blob/master/tests/proxy.php#L24)
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

行情数据 [more](https://github.com/zhouaini528/bitmex-php/blob/master/tests/position.php)
```php
//Get market data
//Market parameters can not key and secret
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

订单类 [more](https://github.com/zhouaini528/bitmex-php/blob/master/tests/order.php)
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


仓位查询 [more](https://github.com/zhouaini528/bitmex-php/blob/master/tests/position.php)
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

更多用例请查看 [more](https://github.com/zhouaini528/bitmex-php/tree/master/tests)

更多API请查看 [more](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)

### Websocket

Websocket有两个服务server和client，server负责处理交易所新连接、数据接收、认证登陆等等。client负责获取数据、处理数据。

Server端初始化，必须在Liunx CLI模式下开启。[Websocket行情应用举例](https://github.com/zhouaini528/websocket-market)
```php
use \Lin\Bitmex\BitmexWebSocket;
require __DIR__ .'./vendor/autoload.php';

$bitmex=new BitmexWebSocket();

$bitmex->config([
    //是否开启日志,默认未开启 false
    //'log'=>true,
    //可以设置日志名称，默认开启日志
    'log'=>['filename'=>'bitmex'],

    //进程服务端口地址,默认 0.0.0.0:2211
    //'global'=>'127.0.0.1:2211',

    //频道数据更新时间,默认 0.5 seconds
    //'data_time'=>0.5,

    //订阅新的频道监控时间, 默认 2 秒
    //'listen_time'=>2,

    //心跳时间默认 30 seconds
    //'ping_time'=>30,

    //私有数据队列默认保存100条
    //'queue_count'=>100,

    //baseurl host 地址设置
    //'baseurl'=>'ws://www.bitmex.com/realtime',//默认地址
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);

$bitmex->start();
```

如果你要测试，你可以 php server.php start 可以在终端即时输出日志。

如果你要部署，你可以 php server.php start -d  开启常驻进程模式，并开启'log'=>true 查看日志。

[More Test](https://github.com/zhouaini528/bitmex-php/tree/master/tests/websocket)

Client端初始化。
```php
$bitmex=new BitmexWebSocket();

$bitmex->config([
    //是否开启日志,默认未开启 false
    //'log'=>true,
    //可以设置日志名称，默认开启日志
    'log'=>['filename'=>'bitmex'],

    //进程服务端口地址,默认 0.0.0.0:2216
    //'global'=>'127.0.0.1:2216',

    //Channel subscription monitoring time,2 seconds
    //'listen_time'=>2,

    //频道数据更新时间,默认 0.5 seconds
    //'data_time'=>0.5,

    //心跳时间默认 30 seconds
    //'ping_time'=>30,

    //baseurl host 地址设置
    //'baseurl'=>'ws://www.bitmex.com/realtime',//默认地址
    //'baseurl'=>'ws://testnet.bitmex.com/realtime',//test
]);
```

频道订阅
```php
//你可以只订阅公共频道
$bitmex->subscribe([
    //public
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
]);

//你也可以私人频道与公共频道混合订阅
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

频道订阅取消
```php
//取消订阅公共频道
$bitmex->unsubscribe([
    //public
    'orderBook10:XBTUSD',
    'quoteBin5m:XBTUSD',
]);

//取消私人频道与公共频道混合订阅
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

获取全部频道订阅数据
```php
//第一种方式，直接获取当前最新数据
$data=$bitmex->getSubscribes();
print_r(json_encode($data));


//第二种方式，通过回调函数，获取当前最新数据
$bitmex->getSubscribes(function($data){
    print_r(json_encode($data));
});

//第二种方式，通过回调函数并开启常驻进程，获取当前最新数据
$bitmex->getSubscribes(function($data){
    print_r(json_encode($data));
},true);
```

获取部分频道订阅数据
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

获取私有频道订阅数据
```php
//The first way
$bitmex->keysecret($key_secret);
$data=$bitmex->getSubscribe();//返回私有频道所有数据
print_r(json_encode($data));

//The second way callback
$bitmex->keysecret($key_secret);
$bitmex->getSubscribe([//以回调方法返回数据
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
$bitmex->getSubscribe([//以开启常驻进程方法获取数据,数据返回频率 $bitmex->config['data_time']=0.5s
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


