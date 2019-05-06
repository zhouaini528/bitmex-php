<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class UserEvent extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/userEvent';
        $this->data=$data;
        
        return $this->exec();
    }
}