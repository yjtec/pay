<?php 
require '../vendor/autoload.php';
use Yjtec\Pay\Refund;
$config = [
    'appid' => 'jEMQRh6zMZPMhikq',
    'secret' => 'KDI4P6hvSnkaq0QU4qv1H550J4Xx9wJ1',
    'return_url' => 'http://www.baidu.com',
    'notify_url' => 'http://www.baidu.com'
];
$order = [
    'out_trade_no' => '1573205426',
    'out_refund_no' => time(),
    'total_fee' => '0.01',
    'refund_fee' => '0.01',
    'refund_desc' => '测试退款'
];
//$url = Refund::wx($config)->mp($order);
$url = Refund::alipay($config)->wap($order);
print_r($url);
?>