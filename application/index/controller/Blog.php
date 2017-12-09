<?php
namespace app\index\controller;

class Blog
{
    public function read()
    {
        $id = input('get.id');
        return $id;
        if($id)
        {
            return '第'.$id.'篇博客阅读';
        }else{
            return '请输入正确的路由格式：http://www.domain.com/index.php/read/id/$id';
        }

    }
}