<?php 
namespace Yjtec\Pay;
use Yjtec\Support\Sign;
use Yjtec\Support\Curl;
class Refund extends Base{
    public function __call($func, $arguments){
        list($order) = $arguments;
        $params      = array_merge($this->params, [
            'gateway' => strtoupper($func),
        ],$order);
        $sign                 = $this->makeSign($params);
        $params['sign']       = $sign;
        return $this->url.'/refund?'.http_build_query($params);
        $re = Curl::get($this->url.'/refund?'.http_build_query($params));
        $re = json_decode($re,true);
        if($re['errcode'] != 0){
            throw new \Exception('退款错误','REFUND FAIL');
        }
        return $re;
    }

    public static function __callStatic($func, $arguments)
    {
        list($config) = $arguments;
        $func         = ucfirst($func);
        return new self($config, $func);
    }
}
?>