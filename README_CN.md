### 建议优先用测试服务器

在线接口测试[https://www.bitmex.com/api/explorer/](https://www.bitmex.com/api/explorer/)

测试服务器[https://testnet.bitmex.com](https://testnet.bitmex.com)

正式服务器[https://www.bitmex.com](https://www.bitmex.com)

所有的接口方式初始化与bitmex提供的接口方式一样，详细请看[src/api](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)

大部分的接口已经完成，使用者可以根据我的设计方案继续扩展，欢迎与我一起迭代它。

[English Document](https://github.com/zhouaini528/bitmex-php/blob/master/README.md)

### 其他交易所API

[Exchanges](https://github.com/zhouaini528/exchanges-php) 它包含以下所有交易所，强烈推荐使用该SDK。

[Bitmex](https://github.com/zhouaini528/bitmex-php)

[Okex](https://github.com/zhouaini528/okex-php)

[Huobi](https://github.com/zhouaini528/huobi-php)

[Binance](https://github.com/zhouaini528/binance-php)

[Kucoin](https://github.com/zhouaini528/Kucoin-php)

[Mxc](https://github.com/zhouaini528/mxc-php)

[Coinbase](https://github.com/zhouaini528/coinbase-php)

[ZB](https://github.com/zhouaini528/zb-php)

[Bitfinex](https://github.com/zhouaini528/zb-php)

[Bittrex](https://github.com/zhouaini528/bittrex-php)

[Gate](https://github.com/zhouaini528/gate-php)

[Bigone](https://github.com/zhouaini528/bigone-php)   

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
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}

//track the order
try {
    $result=$bitmex->order()->getOne([
        'symbol'=>'XBTUSD',
        'orderID'=>$result['orderID'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}

//cancellation of order
try {
    $result=$bitmex->order()->delete([
        'symbol'=>'XBTUSD',
        'orderID'=>$result['orderID'],
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
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
    print_r(json_decode($e->getMessage(),true));
}
```

更多用例请查看 [more](https://github.com/zhouaini528/bitmex-php/tree/master/tests)

更多API请查看 [more](https://github.com/zhouaini528/bitmex-php/tree/master/src/Api)


