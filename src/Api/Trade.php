<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Trade extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/trade';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getBucketed(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/trade/bucketed';
        $this->data=$data;
        
        return $this->exec();
    }
}