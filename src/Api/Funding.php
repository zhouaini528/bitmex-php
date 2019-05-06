<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Funding extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/funding';
        $this->data=$data;
        
        return $this->exec();
    }
}