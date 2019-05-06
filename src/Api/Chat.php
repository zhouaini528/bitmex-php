<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Chat extends Request
{
    public function get(array $data=[]){
        $this->type='POST';
        $this->path='/api/v1/chat';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function post(array $data){
        $this->type='POST';
        $this->path='/api/v1/chat';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getChannels(array $data=[]){
        $this->type='POST';
        $this->path='/api/v1/chat/channels';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getConnected(array $data=[]){
        $this->type='POST';
        $this->path='/api/v1/chat/connected';
        $this->data=$data;
        
        return $this->exec();
    }
}