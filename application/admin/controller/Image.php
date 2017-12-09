<?php
namespace app\admin\controller;
use think\Request;
use app\common\lib\Upload;

/**
 * 后台图片上传相关逻辑
 * Class Image
 * @package app\admin\controller
 */
class Image extends Base
{
    /**
     * 上传图片
     */
    public function upload(){
        //接受文件
        $file = Request::instance()->file('file');
        //把图片上传到制定的文件夹
        $info = $file->move('upload');
        if($info && $info->getPathname()){
            $this->apiSuccess('上传成功','/'.$info->getPathname());
        }
        $this->result(0,'上传失败');
    }

    /**
     * 七牛云上传图片
     */
    public function qiniuUpload(){
        $image = Upload::image();
    }
}