<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex;

use GuzzleHttp\Exception\RequestException;
use Lin\Bitmex\Exceptions\Exception;

class Bitmex
{
    /**
     * 是否开启bitmex测试账号，需要先去申请测试账号。
     * */
    private $test=false;
    
    protected $key='';
    
    protected $secret='';
    
    protected $host='';
    
    protected $nonce='';
    
    protected $signature='';
    
    protected $headers=[];
    
    protected $type='';
    
    protected $path='';
    
    protected $data=[];
    
    protected $timeout=15;
    
    public function __construct(string $key,string $secret)
    {
        $this->key = $key;
        
        $this->secret=$secret;
        
        if(empty($host)) $this->host='https://www.bitmex.com';
    }
    
    /**
     * 是否开启测试
     * */
    public function test($value=true){
        $this->test=$value;
        
        if($this->test) {
            $this->host='https://testnet.bitmex.com';
        }else{
            $this->host='https://www.bitmex.com';
        }
    }
    
    /**
     * 认证
     * */
    protected function auth(){
        $this->nonce();
        
        $this->signature();
        
        $this->headers();
    }
    
    /**
     * 过期时间
     * */
    protected function nonce(){
        $this->nonce = (string) number_format(round(microtime(true) * 100000), 0, '.', '');
    }
    
    /**
     * 签名
     * */
    protected function signature(){
        $endata=http_build_query($this->data);
        $this->signature=hash_hmac('sha256', $this->type.$this->path.$this->nonce.$endata, $this->secret);
    }
    
    /**
     * 默认头部信息
     * */
    protected function headers(){
        $this->headers=[
            'accept' => 'application/json',
            'api-expires'      => $this->nonce,
            'api-key'=>$this->key,
            'api-signature' => $this->signature,
        ];
        
        if(!empty($this->data)) $this->headers['content-type']='application/x-www-form-urlencoded';
    }
    
    /**
     * 发送http
     * */
    protected function send(){
        $client = new \GuzzleHttp\Client();
        
        $data=[
            'headers'=>$this->headers,
            'timeout'=>$this->timeout
        ];
        
        if(!empty($this->data)) $data['form_params']=$this->data;
        
        $response = $client->request($this->type, $this->host.$this->path, $data);
        
        return $response->getBody()->getContents();
    }
    
    /*
     * 执行流程
     * */
    protected function exec(){
        $this->auth();
        
        //可以记录日志
        try {
            return $this->send();
        }catch (RequestException $e){
            //TODO  该流程可以记录各种日志
            throw new Exception($e->getMessage());
        }
    }
}