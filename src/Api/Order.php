<?php
/**
 * @author lin <465382251@qq.com>
 * 
 * Most of them are unfinished and need your help
 * https://github.com/zhouaini528/bitmex-php.git
 * */

namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Order extends Request
{
    /**
     * 
     * */
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function getOne(array $data){
        if(!isset($data['orderID']) && !isset($data['clOrdID']) ) return [];
        $symbol=$data['symbol'];
        unset($data['symbol']);
        
        $data=[
            'reverse'=>'true',
            'symbol'=>$symbol,
            'count'=>1,
            'filter'=>json_encode($data)
        ];
        
        return current($this->get($data));
    }
    
    public function getAll(array $data){
        if(!isset($data['count'])) $data['count']=100;//默认100条
        
        $data['reverse']='true';
        
        return $this->get($data);
    }
    
    public function put(array $data){
        
    }
    
    /**
     * $data=[
            'symbol'=>'XBTUSD',
            'price'=>'10',
            'side'=>'Sell  Buy',
            'orderQty'=>'10',
            'ordType'=>'Limit',
            
            'clOrdID'    Optional Client  ID
            
            More  https://www.bitmex.com/api/explorer/#!/Order/Order_new
        ];
     * */
    public function post(array $data){
        $this->type='POST';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     * 
     * */
    public function delete(array $data){
        $this->type='DELETE';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     *
     * */
    public function deleteAll(array $data){
        $this->type='DELETE';
        $this->path='/api/v1/order/all';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function putBulk(array $data){
        
    }
    
    public function postBulk(array $data){
        
    }
    
    public function postCancelAllAfter(array $data){
        
    }
    
    public function postClosePosition(array $data){
        
    }
}