<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class GlobalNotification extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/globalNotification';
        $this->data=$data;
        
        return $this->exec();
    }
}