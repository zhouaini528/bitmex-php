<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Settlement extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/settlement';
        $this->data=$data;
        
        return $this->exec();
    }
}