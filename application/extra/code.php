<?php
/**
 * Created by PhpStorm.
 * User: an_xin
 * Date: 2017/10/11
 * Time: 23:14
 */
//和状态码相关的文案配置
return [
    //常用状态
    'status_delete' => -1,//删除状态
    'status_normal' =>1,//正常状态

    //文章状态
    'content_failed' => -3,//文章审核未通过
    'content_off' => -2,//文章下架状态
    'content_delete' => -1,//文章删除状态
    'content_normal' =>1,//文章正常(发布)状态
    'content_padding' => 0,//文章待审核状态

    //api业务状态码
    'api_success' => '1',
    'api_error' => 0,
];