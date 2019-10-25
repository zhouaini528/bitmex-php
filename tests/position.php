<?php

/**
 * @author lin <465382251@qq.com>
 *
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/bitmex-php.git
 * */

use Lin\Bitmex\Bitmex;

require __DIR__ .'../../vendor/autoload.php';

//Test API address  default  https://www.bitmex.com
$key='eLB_l505a_cuZL8Cmu5uo7EP';
$secret='wG3ndMquAPl6c-jHUQNhyBQJKGBwdFenIF2QxcgNKE_g8Kz3';
$host='https://testnet.bitmex.com';

$bitmex=new Bitmex($key,$secret,$host);


try {
    $result=$bitmex->position()->postIsolate([
        'symbol'=>'XBTUSD',
        'enabled'=>'false',
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

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

//Choose leverage for a position
try {
    $result=$bitmex->position()->postLeverage([
        'symbol'=>'XBTUSD',
        'leverage'=>0
    ]);
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

?>