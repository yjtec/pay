<?php 
namespace Yjtec\Pay;
use Yjtec\Support\Sign;
use Yjtec\Support\Curl;
use Yjtec\Pay\Exceptions\TransferException;
class Transfer extends Base{
    public function __call($func, $arguments){
        list($order) = $arguments;
        $params      = array_merge($this->params,$order);
        $sign                 = $this->makeSign($params);
        $params['sign']       = $sign;
        $re = Curl::post($this->url.'transfer',$params);
        $data = json_decode($re,true);
        if(!$data){
            throw new TransferException('服务器错误');
        }
        if($data['errcode'] != 0 ){
            throw new TransferException($data['errmsg'],$data['errcode']);
        }

        if($data['data']['status'] != 1){
            throw new TransferException('转账失败',$data['data']['status']);
        }

        return $data['data'];
    }

    public static function __callStatic($func, $arguments)
    {   

        list($config) = $arguments;
        $func         = ucfirst($func);
        return new self($config, $func);
    }
}
?>