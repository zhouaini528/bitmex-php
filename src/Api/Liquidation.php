<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Liquidation extends Request
{
    public function get($data)
    {
        $this->type='GET';
        $this->path='/api/v1/liquidation';
        $this->data=$data;
        
        return $this-exec();
    }
}
