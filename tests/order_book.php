<?php
/**
 * @author lin <465382251@qq.com>
 * 
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/bitmex-php.git
 * */

use Lin\Bitmex\Bitmex;

require __DIR__ .'../../vendor/autoload.php';

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


//Fatal error capture
try {
    $bitmex=new Bitmex('xxx','xxx','host');
    $result=$bitmex->orderBook()->get([
        'symbol'=>'XBTUSD',
        'depth'=>30
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
    exit;
}

?>