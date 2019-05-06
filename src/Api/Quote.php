<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Quote extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/quote';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getBucketed(array $data=[]){
        $this->type='GET';
        $this->path='/quote/bucketed';
        $this->data=$data;
        
        return $this->exec();
    }
}