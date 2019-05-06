<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class GlobalNotification extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/globalNotification';
        $this->data=$data;
        
        return $this->exec();
    }
}