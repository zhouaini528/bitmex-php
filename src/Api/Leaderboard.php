<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Leaderboard extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/leaderboard';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function getName(array $data=[]){
        $this->type='GET';
        $this->path='/leaderboard/name';
        $this->data=$data;
        
        return $this->exec();
    }
}