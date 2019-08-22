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

$action=intval($_GET['action'] ?? 0);//http pattern
if(empty($action)) $action=intval($argv[1]);//cli pattern

$bitmex=new Bitmex($key,$secret,$host);

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

switch ($action){
    case 0:{
        try {
            $result=$bitmex->announcement()->get();
        }catch (\Exception $e){
            print_r(json_decode($e->getMessage(),true));
        }
        break;
    }
    case 1:{
        try {
            $result=$bitmex->announcement()->getUrgent();
        }catch (\Exception $e){
            print_r(json_decode($e->getMessage(),true));
        }
        break;
    }
}

print_r($result);
