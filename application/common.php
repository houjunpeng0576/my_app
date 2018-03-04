<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pagination($data){
    if(!$data){
        return '';
    }
    $params = request()->param();
    return '<div class="my_app">'.$data->appends($params)->render().'</div>';
}

/**
 * 通用化API接口数据输出
 * @param $status   //业务状态码
 * @param $message  //信息提示
 * @param $data     //数据
 * @param $httpCode //http状态码
 */
function show($status,$message,$data,$httpCode = '200'){
    $returnData = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
    return json($returnData,$httpCode);
}