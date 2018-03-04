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
        //要上传的文件
        $file = $_FILES['file']['tmp_name'];

        //获取文件后缀
        $ext = explode('.',$_FILES['file']['name']);
        $ext = $ext[1];

        $config = config('qiniu');
        //构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传的token '{"saveKey":"news/$(etag).$(ext)"}'
        $token = $auth->uploadToken($config['bucket'],null,3600,$config['normal_policy']);
//        //上传到七牛后保存的文件名
//        $key = date('Y').'/'.date('m').'/'.substr(md5($file),0,5).date('YmdHis').rand(0,9999).'.'.$ext;

        //初始化UploadManager类
        $uploadManager = new UploadManager();
        list($ret,$err) = $uploadManager->putFile($token,null,$file);
        if($err !== null){
            return null;
        }else{
            return $ret['key'];
        }
    }

    public static function token(){
        $config = config('qiniu');
        //构建一个鉴权对象
        $auth = new Auth($config['ak'],$config['sk']);
        //生成上传的token
        $token = $auth->uploadToken($config['bucket']);
        return show(1,'OK',$token);
    }
}