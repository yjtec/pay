<?php
namespace Yjtec\Pay;
use Yjtec\Support\Sign;
use Yjtec\Support\Curl;
class Pay
{
    private $type; //支付方式  Alipay Wx
    private $appid;
    private $secret;
    private $return_url;
    private $notify_url;
    private $params;
    private $url = "http://npay.360vrsh.com/";
    public function __construct($config, $type)
    {

        $this->config     = $config;
        $this->type       = $type;
        $this->appid      = $config['appid'];
        $this->secret     = $config['secret'];
        $this->notify_url = $config['notify_url'];
        $this->return_url = $config['return_url'];
        $this->timeStamp  = time();
        $this->params     = $this->makeParams();
    }
    public function verify()
    {
        $postData  = $_POST;
        if(!isset($postData['timeStamp']) || !isset($postData['sign'])){
            throw new SignException('签名错误','SIGN FAIL');
        }
        $timeStamp = $postData['timeStamp'];
        $postSign  = $postData['sign'];
        unset($postData['timeStamp']);
        unset($postData['sign']);
        $sign = Sign::make($this->secret,$timeStamp,$postData);
        if($sign['sign'] != $postSign){
            throw new SignException('签名错误','SIGN FAIL');
        }
        return $postData;
    }

    public function success(){
        return [
            'errcode' => 'SUCCESS',
            'errmsg' => 'OK'
        ];
    }

    public function __call($func, $arguments)
    {
        list($order) = $arguments;
        $params      = $order;
        $params      = array_merge($this->params, [
            'gateway' => strtoupper($func),
        ]);
        $params['bz_content'] = json_encode($order);
        $sign                 = $this->makeSign($params);
        $params['sign']       = $sign;

        $re = Curl::get($this->url.'pay/prepay?'.http_build_query($params));
        $re = json_decode($re,true);
        if($re['errcode'] != 0){
            throw new \Exception('下单错误','PRE FAIL');
        }
        return $this->url . 'pay?' . http_build_query($params);
    }
    public static function __callStatic($func, $arguments)
    {
        list($config) = $arguments;
        $func         = ucfirst($func);
        return new self($config, $func);
    }
    private function makeParams()
    {
        $params['appId']      = $this->appid;
        $params['timeStamp']  = $this->timeStamp;
        $params['type']       = $this->type;
        $params['notify_url'] = $this->notify_url;
        $params['return_url'] = $this->return_url;
        return $params;
    }
    private function makeSign($params)
    {
        ksort($params);
        $paramstr = '';
        foreach ($params as $k => $v) {
            $paramstr .= "{$k}{$v}";
        }
        $secret    = $this->secret;
        $timeStamp = $this->timeStamp;
        return md5("{$secret}-{$paramstr}-{$timeStamp}");
    }
}
