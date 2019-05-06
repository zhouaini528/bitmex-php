<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Chat extends Request
{
    public function get(array $data=[]){
        $this->type='POST';
        $this->path='/chat';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function post(array $data){
        $this->type='POST';
        $this->path='/chat';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getChannels(array $data=[]){
        $this->type='POST';
        $this->path='/chat/channels';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getConnected(array $data=[]){
        $this->type='POST';
        $this->path='/chat/connected';
        $this->data=$data;
        
        return $this->exec();
    }
}