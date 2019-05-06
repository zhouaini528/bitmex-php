<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Insurance extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/insurance';
        $this->data=$data;
        
        return $this->exec();
    }
}