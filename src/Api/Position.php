<?php
namespace Lin\Bitmex\Api;

use Lin\Bitmex\Request;

class Position extends Request
{
    public function get(array $data=[]){
        $this->type='GET';
        $this->path='/api/v1/position';
        $this->data=$data;
        
        return $this->exec();
    }
    
    public function postIsolate(array $data){
        $this->type='POST';
        $this->path='/api/v1/position/isolate';
        $this->data=$data;
        return $this->exec();
    }

    /**
     * 设置账户杠杆
     * $data = [
     *      symbol => symbol,
     *      leverage => 0
     * ] // 这只是全仓模式的配置示范,其他模式传其他数据
     * @param array $data
     * @return mixed
     * @throws \Lin\Bitmex\Exceptions\Exception
     */
    public function postLeverage(array $data)
    {
        $this->type='POST';
        $this->path='/api/v1/position/leverage';
        $this->data=$data;

        return $this->exec();
    }
    
    public function postRiskLimit(array $data){
        $this->type='POST';
        $this->path='/api/v1/position/leverage';
        $this->data=$data;
        return $this->exec();
    }
    
    public function postTransferMargin(array $data){
        $this->type='POST';
        $this->path='/api/v1/position/transferMargin';
        $this->data=$data;
        return $this->exec();
    }
}