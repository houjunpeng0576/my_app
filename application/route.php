<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
use think\Route;

//接口
Route::get('api/:version/cat','api/:version.Cat/read');
Route::get('api/:version/index','api/:version.index/index');

//news
Route::resource('api/:version/news','api/:version.news');

//rank(排行)
Route::get('api/:version/rank','api/:version.rank/index');

//API:七牛云上传token
Route::get('api/upload_token','api/upload/token');

//init(初始化)
Route::get('api/:version/init','api/:version.index/init');

//短信验证码相关
Route::resource('api/:version/identify','api/:version.identify');

//登陆接口
Route::post('api/:version/login','api/:version.login/save');

//user
Route::resource('api/:version/user','api/:version.user');

//检测用户名是否唯一
Route::get('api/:version/check_username','api/:version.user/checkUsername');

//图片上传
Route::post('api/:version/image','api/:version.image/save');

//点赞
Route::post('api/:version/upvote','api/:version.upvote/save');
//取消点赞
Route::delete('api/:version/upvote','api/:version.upvote/delete');
//是否点赞
Route::get('api/:version/upvote/:id','api/:version.upvote/read');

//评论
Route::post('api/:version/comment','api/:version.comment/save');
Route::get('api/:version/comment/:id','api/:version.comment/read');


//动态注册路由规则
//Route::rule('路由表达式','路由地址','请求类型','路由参数(数组)','变量规则(数组)');

Route::get('/',function(){
    return 'Hello,world!';
});

Route::get(['new','new/[:id]$'],'@index/News/read');//[]是可选项，$ 完全匹配
//Route::miss('index/Index/miss');  //没有匹配的路由时执行
Route::get('hello/[:name]',function($name='猴哥'){//闭包写法
    return 'Hello,'.$name.'!';
//    return url('index/blog/read','id=5&name=thinkphp');//生成url
});

//变量规则
Route::pattern('name','\d+');//设置全局变量规则
Route::get('new/:name','News/read',[],['name'=>'\w+']);//局部变量规则
Route::get('new/:id','News/read',[],['__url__'=>'new\/\w+$']);//完整url规则

//路由别名
Route::alias('user','index/User',[//缩短路由
    'ext'=>'html',//设置条件
    'allow'=>'aaa',//设置白名单
//    'except'=>'aaa',//设置黑名单
    'method'=>['aaa'=>'GET','bbb'=>'POST','ccc'=>'DELETE'],//设置请求类型
]);

//路由分组(允许把相同前缀的路由定义合并分组，这样可以提高路由匹配的效率，不必每次都去遍历完整的路由规则。)
Route::group('blog',[
    ':id'   => ['Blog/read', ['method' => 'put'], ['id' => '\d+']],
    ':name' => ['Blog/read', ['method' => 'post']],
]);

Route::resource('oauth2','oauth2/Index');
