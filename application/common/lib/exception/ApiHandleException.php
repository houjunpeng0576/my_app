<?php
namespace app\common\lib\exception;
use think\exception\Handle;
class ApiHandleException extends Handle{
    public $httpCode = 500;
    //重构render是为了将错误信息展示给app端
    function render(\Exception $e){
        //在对render进行重构的时候，我们需要保留render重构前渲染详细错误信息的功能，以便于后端工程师排查错误
        if(config('app_debug') == true){
            return parent::render($e);
        }
        //检测异常是Exception抛出的还是ApiException抛出的
        if($e instanceof ApiException){
            $this->httpCode = $e->httpCode;//如果是ApiException抛出的异常，则将http状态码换成ApiException抛出的http状态码
        }
        return show(0,$e->getMessage(),[],$this->httpCode);
    }
}