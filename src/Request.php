<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Bitmex;

use GuzzleHttp\Exception\RequestException;
use Lin\Bitmex\Exceptions\Exception;

class Request
{
    /**
     * 是否开启bitmex测试账号，需要先去申请测试账号。
     * */
    protected $key='';
    
    protected $secret='';
    
    protected $host='';
    
    protected $nonce='';
    
    protected $signature='';
    
    protected $headers=[];
    
    protected $type='';
    
    protected $path='';
    
    protected $data=[];
    
    protected $timeout=10;
    
    protected $proxy=false;
    
    public function __construct(array $data)
    {
        $this->key=$data['key'] ?? '';
        $this->secret=$data['secret'] ?? '';
        $this->host=$data['host'] ?? 'https://www.bitmex.com';
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
        ];
        
        if(!empty($this->key) && !empty($this->secret)) {
            $this->headers=array_merge($this->headers,[
                'api-expires'      => $this->nonce,
                'api-key'=>$this->key,
                'api-signature' => $this->signature,
            ]);
        }
        
        if(!empty($this->data)) $this->headers['content-type']='application/x-www-form-urlencoded';
    }
    
    /**
     * 代理端口设置
     * @param bool|array 
     * false   默认
     * true   设置本地代理
     * array  手动设置代理
     * */
    function proxy($proxy=false){
        $this->proxy=$proxy;
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
        
        //是否有代理设置
        if(is_array($this->proxy)){
            $data=array_merge($data,['proxy'=>$this->proxy]);
        }else{
            if($this->proxy) $data['proxy']=[
                'http'  => 'http://127.0.0.1:12333',
                'https' => 'http://127.0.0.1:12333',
                'no'    =>  ['.cn']
            ];
        }
        
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
            return json_decode($this->send(),true);
        }catch (RequestException $e){
            if(method_exists($e->getResponse(),'getBody')){
                $contents=$e->getResponse()->getBody()->getContents();
                
                $temp=json_decode($contents,true);
                if(!empty($temp)) {
                    $temp['_method']=$this->type;
                    $temp['_url']=$this->host.$this->path;
                }else{
                    $temp['_message']=$e->getMessage();
                }
            }else{
                $temp['_message']=$e->getMessage();
            }
            
            $temp['_httpcode']=$e->getCode();
            
            //TODO  该流程可以记录各种日志
            throw new Exception(json_encode($temp));
        }
    }
}