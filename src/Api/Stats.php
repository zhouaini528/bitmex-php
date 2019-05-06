<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Stats extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/stats';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getHistory(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/stats/history';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getHistoryUSD(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/stats/historyUSD';
        $this->data=$data;
        
        return $this->exec();
    }
}