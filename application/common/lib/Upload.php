<?php
namespace app\common\lib;

//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;

/**
 * 七牛云图片上传基础类库
 * Class Upload
 * @package app\common\lib
 */
class Upload{
    /**
     * 图片上传
     */
    public static function image(){
        if(empty($_FILES['file']['tmp_name'])){
            exception('您提交的图片数据不合法',404);
        }

        $config = config('qiniu');
        //构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传的token
    }
}