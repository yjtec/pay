<?php 
namespace Yjtec\Pay;

class SignException extends \Exception{
    public function __construct($message,$code){
        $this->message = $message;
        $this->code = $code;
    }
}