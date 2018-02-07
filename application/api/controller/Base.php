<?php
namespace app\api\controller;
use think\Controller;

/**
 * API模块基类
 * Class Base
 * @package app\api\controller
 */
class Base extends Controller{
    //初始化方法
    public function _initialize()
    {
        parent::_initialize();
        $this->checkRequestAuth();
    }

    //检测app没次请求的数据是否合法
    public function checkRequestAuth(){
        //首先需要获取headers的数据
        $headers = request()->header();
    }
}