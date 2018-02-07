<?php
namespace app\common\lib\exception;
use think\Exception;
use Throwable;

class ApiException extends Exception{
    public $message = '';
    public $httpCode = 500;
    public $code = 0;

    /**
     * ApiException constructor.
     * @param string $message 错误信息
     * @param int $httpCode http状态码
     * @param Throwable $code 业务层状态码
     */
    public function __construct($message = "", $httpCode = 0, $code = 0)
    {
        $this->message = $message;
        $this->httpCode = $httpCode;
        $this->code = $code;
    }
}