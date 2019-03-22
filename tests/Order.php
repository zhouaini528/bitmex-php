<?php
use Lin\Bitmex\Bitmex;

require __DIR__ .'../../vendor/autoload.php';

$bitmex=new Bitmex();
$result=$bitmex->order()->get();
print_r($result);


?>