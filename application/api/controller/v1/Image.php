<?php
namespace app\api\controller\v1;

use app\common\lib\Upload;

class Image extends AuthBase{
    public function save(){
        $image = Upload::image();
        return show(config('code.api_success'),'ok',config('qiniu.image_url').$image);
    }
}