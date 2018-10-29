<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Bitmex;
use Lin\Bitmex\Exceptions\UserException;

class User extends Bitmex
{
    public function get(){
        $this->type='GET';
        $this->path='/api/v1/user';
        
        $this->exec();
    }
    
    public function put($data){
        $this->type='PUT';
        $this->path='/api/v1/user';
        $this->data=$data;
        
        $this->exec();
    }
    
    public function post($data){
        
    }
}