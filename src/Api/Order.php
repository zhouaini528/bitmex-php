<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api;

use Lin\Bitmex\Bitmex;

class Order extends Bitmex
{
    /**
     * $data=[
            'symbol'=>'ADAZ18',
            
            //可选参数  具体参考API  https://testnet.bitmex.com/api/explorer/#!/Order/Order_getOrders
             * 数量
             * 时间
        ];
     * */
    public function get($data=[]){
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
    
    public function put($data){
        
    }
    
    /**
     * $data=[
            'symbol'=>'XBTUSD',
            'price'=>'10',
            'side'=>'sell,buy',该参数可以为空。则价格正负代表做多~做空
            'orderQty'=>'10',
            'ordType'=>'Limit',//limit 限价交易
        ];
     * */
    public function post($data){
        $this->type='POST';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function delete($data){
        $this->type='DELETE';
        $this->path='/api/v1/order';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function putBulk($data){
        
    }
    
    public function postBulk($data){
        
    }
    
    public function postCancelAllAfter($data){
        
    }
    
    public function postClosePosition($data){
        
    }
}