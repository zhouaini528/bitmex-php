<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex\Api;

use Lin\Bitmex\Bitmex;

class OrderBook extends Bitmex
{
    /**
     * 
     * @param array symbol=XBTUSD&depth=25
     * */
    public function get($data=['symbol'=>'XBTUSD','depth'=>100]){
        $this->type='GET';
        $this->path='/api/v1/orderBook/L2';
        $this->data=$data;
        
        return $this->exec();
    }
}