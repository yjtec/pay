<?php
namespace Yjtec\Pay;

class Pay
{
    private $type; //支付方式  Alipay Wx
    private $appid;
    private $secret;
    private $return_url;
    private $notify_url;
    private $params;
    private $url = "http://test.npay.qjzhcs.com/pay";
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

    public function __call($func, $arguments)
    {
        list($order) = $arguments;
        $params      = $order;
        $params      = array_merge($this->params, $order, [
            'gateway' => strtoupper($func),
        ]);
        $sign           = $this->makeSign($params);
        $params['sign'] = $sign;
        return $this->url . '?' . http_build_query($params);
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
