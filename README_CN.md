### 初始化

建议优先用测试服务器

在线接口测试[https://www.bitmex.com/api/explorer/](https://www.bitmex.com/api/explorer/)

测试服务器[https://testnet.bitmex.com](https://testnet.bitmex.com)

正式服务器[https://www.bitmex.com](https://www.bitmex.com)

所有的接口方式初始化与bitmex提供的接口方式一样，详细请看src/api

行情数据初始化
```php
//$host 可以不传入，默认正式服务器访问；
$order=new \Lin\Bitmex\Api\OrderBook();
$rlt=$order->get();
print_r($rlt);
//功能多API请查看API
```

订单类的初始化
```php
//$host 可以不传入，默认正式服务器访问；
$order=new \Lin\Bitmex\Api\Order($key, $secret, $host);
//订单查询
$rlt=$order->get([
    'symbol'=>'ADAZ18',
]);
print_r($rlt);

//创建新订单
$data=[
    'symbol'=>'ADAZ18',
    'price'=>'0.00001196',
    'orderQty'=>'10',
    'ordType'=>'Limit',
];
$rlt=$order->post($data);
print_r($rlt);

//功能多API请查看API
```


用户类的初始化
```php
//$host 可以不传入，默认正式服务器访问；
$user=new \Lin\Bitmex\Api\User($key, $secret, $host);

//订单查询
$rlt=$user->get();
print_r($rlt);

//功能多API请查看API
```


