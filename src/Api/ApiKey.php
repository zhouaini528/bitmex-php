<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class ApiKey extends Request
{
    public function get(){
        $this->type='GET';
        $this->path='/api/v1/apiKey';
        
        return $this->exec();
    }
    
    public function post(array $data){
        $this->type='POST';
        $this->path='/api/v1/apiKey';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postDisable(array $data){
        $this->type='POST';
        $this->path='/api/v1/apiKey/disable';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postEnable(array $data){
        $this->type='POST';
        $this->path='/api/v1/apiKey/enable';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function delete(array $data){
        $this->type='DELETE';
        $this->path='/api/v1/apiKey';
        $this->data=$data;
        
        return $this->exec();
    }
}