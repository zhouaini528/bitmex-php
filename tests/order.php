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


//Get your orders
try {
    $result=$bitmex->order()->get();
    print_r($result);
}catch (\Exception $e){
    print_r(json_decode($e->getMessage(),true));
}

?>