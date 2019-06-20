<?php 
require '../vendor/autoload.php';
use Yjtec\Pay\Pay;
$config = [
    'appid' => 'SxmfErjzem3ylFBA',
    'secret' => 'lbfK571EUHt7oDEYA46D0ylY5zZhbuIi',
    'return_url' => 'http://www.baidu.com',
    'notify_url' => 'http://www.baidu.com'
];
try{
    $payInstance = Pay::Alipay($config);
    $data = $payInstance ->verify();
    echo json_encode($payInstance->success());
}catch(\Exception $e){
    echo $e->getMessage();
    echo $e->getCode();
}
