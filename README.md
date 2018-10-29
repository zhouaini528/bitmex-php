### 初始化

订单类的初始化
```php
$order=new \Lin\Bitmex\Api\Order($key, $secret);
$order->test();

//订单查询
$rlt=$order->get([
    'symbol'=>'ADAZ18',
]);
print_r($a);

//创建新订单
$data=[
    'symbol'=>'ADAZ18',
    'price'=>'0.00001196',
    'orderQty'=>'10',
    'ordType'=>'Limit',
];
$rlt=$order->post($data);

//功能多API请查看API
```

用户类的初始化
```php
$user=new \Lin\Bitmex\Api\User($key, $secret);
$user->test();

//订单查询
$rlt=$user->get();
print_r($rlt);

//功能多API请查看API
```


$class->test();

初始化该方法是请求测试服务器，正式部署注释掉该方法
