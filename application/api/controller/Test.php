<?php
namespace app\api\controller;
use think\Controller;
use app\common\lib\exception\ApiException;

class Test extends Controller{
    public function test(){
        throw new ApiException('您提交的数据不合法哦','400','0');
//        exception('您提交的数据不合法');
    }
}