##初始化

一个查询订单的初始化
```php
$order=new \Lin\Bitmex\Api\Order($key, $secret);
$order->test();

$rlt=$order->get([
    'symbol'=>'ADAZ18',
]);

print_r($a);
```
$order->test();
初始化该方法是请求测试服务器，正式部署注释掉该方法