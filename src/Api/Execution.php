<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Execution extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/execution';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getTradeHistory(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/execution/tradeHistory';
        $this->data=$data;
        
        return $this->exec();
    }
}