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
        try{
            $image = Upload::image();
        }catch (\Exception $e){
            exit(json_encode(array('status'=>'0','message'=>$e->getMessage())));
        }

        if($image){
           $data = array(
               'status' => '1',
               'message' => '上传成功',
               'data' => config('qiniu.image_url').$image
           );
           exit(json_encode($data));
        }else{
            exit(json_encode(array('status'=>'0','message'=>'上传失败')));
        }
    }

    public function show(){
        return $this->fetch();
    }

    public function token(){
        return Upload::token();
    }
}