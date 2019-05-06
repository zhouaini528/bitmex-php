<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Schema extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/schema';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getWebsocketHelp(array $data=[]){
        $this->type='GET';
        $this->path='/schema/websocketHelp';
        $this->data=$data;
        
        return $this->exec();
    }
}