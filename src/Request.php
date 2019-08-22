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
    
    protected $options=[];
    
    public function __construct(array $data)
    {
        $this->key=$data['key'] ?? '';
        $this->secret=$data['secret'] ?? '';
        $this->host=$data['host'] ?? 'https://www.bitmex.com';
        
        $this->options=$data['options'] ?? [];
    }
    
    /**
     * 认证
     * */
    protected function auth(){
        $this->nonce();
        
        $this->signature();
        
        $this->headers();
        
        $this->options();
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
     * 请求设置
     * */
    protected function options(){
        $this->options=array_merge([
            'headers'=>$this->headers,
            //'verify'=>false   //关闭证书认证
        ],$this->options);
        
        $this->options['timeout'] = $this->options['timeout'] ?? 60;
        
        if(isset($this->options['proxy']) && $this->options['proxy']===true) {
            $this->options['proxy']=[
                'http'  => 'http://127.0.0.1:12333',
                'https' => 'http://127.0.0.1:12333',
                'no'    =>  ['.cn']
            ];
        }
    }
    
    /**
     * 发送http
     * */
    protected function send(){
        $client = new \GuzzleHttp\Client();
        
        if(!empty($this->data)) $this->options['form_params']=$this->data;
        
        $response = $client->request($this->type, $this->host.$this->path, $this->options);
        
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