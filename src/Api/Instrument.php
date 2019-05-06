<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Instrument extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/instrument';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getActive(array $data=[]){
        $this->type='GET';
        $this->path='/instrument/active';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getActiveAndIndices(array $data=[]){
        $this->type='GET';
        $this->path='/instrument/activeAndIndices';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getActiveIntervals(array $data=[]){
        $this->type='GET';
        $this->path='/instrument/activeIntervals';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getCompositeIndex(array $data=[]){
        $this->type='GET';
        $this->path='/instrument/compositeIndex';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getIndices(array $data=[]){
        $this->type='GET';
        $this->path='/instrument/indices';
        $this->data=$data;
        
        return $this->exec();
    }
}