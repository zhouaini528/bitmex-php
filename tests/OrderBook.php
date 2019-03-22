<?php
use Lin\Bitmex\Bitmex;

require __DIR__ .'../../vendor/autoload.php';

$bitmex=new Bitmex('','','host');

try {
    $result=$bitmex->orderBook()->get([
        'symbol'=>'XBTUSD',
        'depth'=>30
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r($e->getMessage());
    die('hhh');
}


$result=$bitmex->orderBook()->get([
    'symbol'=>'ETHUSD',
    'depth'=>20
]);
print_r($result);
?>