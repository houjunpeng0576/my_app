<?php
namespace app\api\controller;
use Qiniu\Auth;

class Upload extends Base{
    public function token(){
        $config = config('qiniu');
        //构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传的token
        $token = $auth->uploadToken($config['bucket'],null,3600,$config['api_policy']);
        $returnData = [
            'token' => $token
        ];
        return show(1,'OK',$returnData);
    }
}