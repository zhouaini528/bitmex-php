<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Trade extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/trade';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getBucketed(array $data=[]){
        $this->type='GET';
        $this->path='/trade/bucketed';
        $this->data=$data;
        
        return $this->exec();
    }
}