<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Bitmex;

class Position extends Bitmex
{
    public function get(array $data){
        $this->type='GET';
        $this->path='/api/v1/position';
        $this->data=$data;
        
        return $this->exec();
    }
}