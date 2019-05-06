<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Funding extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/funding';
        $this->data=$data;
        
        return $this->exec();
    }
}