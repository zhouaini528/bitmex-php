<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Announcement extends Request
{
    /**
     * 
     * */
    function get(array $data=[]){
        $this->type='GET';
        $this->path='/announcement';
        $this->data=$data;
        
        return $this->exec();
    }
    
    /**
     *
     * */
    function getUrgent(array $data=[]){
        $this->type='GET';
        $this->path='/announcement/urgent';
        $this->data=$data;
        
        return $this->exec();
    }
}