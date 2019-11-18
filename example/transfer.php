<?php 
require '../vendor/autoload.php';
use Yjtec\Pay\Transfer;
$config = [
    'appid' => 'jEMQRh6zMZPMhikq',
    'secret' => 'KDI4P6hvSnkaq0QU4qv1H550J4Xx9wJ1',
    'debug' => true,
];

$order = [
    'out_trade_no' => '', //转账单号
    'trans_amount' => '0.1', //转账金额
    'body' => '测试转账', //转账描述
    'account' => '13072419652', //转账账号
    'real_name' => '康帅杰' //真实姓名
];

$data = Transfer::alipay($config)->run($order);
var_dump($data);

