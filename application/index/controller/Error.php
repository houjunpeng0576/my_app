<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
//空控制器类
class Error extends Controller {
//    public function _empty($name)
//    {
//        echo '还有('.$name.')这样的操作？';
//    }

    public function index(Request $request)
    {
        return "没有".$request->controller()."这样的controller！";
    }
}