<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\SendSms;
class Identify extends Base{
    public function save(){
        if(!request()->isPost()){
            return show(config('code.api_error'),'请求方式错误');
        }

        //校验数据
        $validate = validate('Identify');
        $data = input('post.');
        if(!$validate->scene('sendIdentify')->check($data)){
            return show(config('code.api_error'),$validate->getError(),[],403);
        }

        if(SendSms::getInstance()->sendSms($data['phone'])){
            return show(config('code.api_success'),'OK',[],201);
        }else{
            return show(config('code.api_error'),'error',[],403);
        }
    }
}