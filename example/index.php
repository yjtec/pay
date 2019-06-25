<?php 
require '../vendor/autoload.php';
use Yjtec\Pay\Pay;
$config = [
    'appid' => 'SxmfErjzem3ylFBA',
    'secret' => 'lbfK571EUHt7oDEYA46D0ylY5zZhbuIi',
    'return_url' => 'http://www.baidu.com',
    'notify_url' => 'http://www.baidu.com'
];
$order = [
    'out_trade_no' => time(),
    'total_amount' => '0.01',
    'body' => 'test 支付商品',
    //'http_method' =>'get'
];
//$url = Pay::alipay($config)->wap($order); //支付宝手机支付测试
$url = Pay::wx($config)->mp($order); //微信公众号
//$url = Pay::alipay($config)->scan($order); //支付宝扫码测试
//$url = Pay::wx($config)->scan($order); //微信扫码测试
//$url = Pay::alipay($config)->app($order);//阿里app支付
//$url = Pay::wx($config)->app($order);//阿里app支付
echo $url;
?>