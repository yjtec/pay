<?php
namespace Yjtec\Pay;

class Base
{
    protected $type; //支付方式  Alipay Wx
    protected $appid;
    protected $secret;
    protected $return_url;
    protected $notify_url;
    protected $params;
    protected $url = "http://test.npay.qjzhcs.com/";
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
    protected function makeParams()
    {
        $params['appId']      = $this->appid;
        $params['timeStamp']  = $this->timeStamp;
        $params['type']       = $this->type;
        return $params;
    }
    protected function makeSign($params)
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
