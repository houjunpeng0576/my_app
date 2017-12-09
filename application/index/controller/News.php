<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class News extends Controller
{
    public function _initialize()
    {
        echo "_initialize初始化操作！<br>";
    }

    public function _empty($name)
    {
        return '还有('.$name.')这样的操作？';
    }

    public function read()
    {
        $this->success('ok!','News/hello','',5);
//        echo '阅读';die;
    }

    public function hello()
    {
        $request = request();
        // 获取当前域名
        echo 'domain: ' . $request->domain() . '<br/>';
        // 获取当前入口文件
        echo 'file: ' . $request->baseFile() . '<br/>';
        // 获取当前URL地址 不含域名
        echo 'url: ' . $request->url() . '<br/>';
        // 获取包含域名的完整URL地址
        echo 'url with domain: ' . $request->url(true) . '<br/>';
        // 获取当前URL地址 不含QUERY_STRING
        echo 'url without query: ' . $request->baseUrl() . '<br/>';
        // 获取URL访问的ROOT地址
        echo 'root:' . $request->root() . '<br/>';
        // 获取URL访问的ROOT地址
        echo 'root with domain: ' . $request->root(true) . '<br/>';
        // 获取URL地址中的PATH_INFO信息
        echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
        // 获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo: ' . $request->path() . '<br/>';
        // 获取URL地址中的后缀信息
        echo 'ext: ' . $request->ext() . '<br/>';
        echo "当前模块名称是" . $request->module(). '<br/>';
        echo "当前控制器名称是" . $request->controller(). '<br/>';
        echo "当前操作名称是" . $request->action(). '<br/>';
        echo '请求方法：' . $request->method() . '<br/>';
        echo '资源类型：' . $request->type() . '<br/>';
        echo '访问地址：' . $request->ip() . '<br/>';
        echo '是否AJax请求：' . var_export($request->isAjax(), true) . '<br/>';
        echo '请求参数：';
        dump($request->param());
        echo '请求参数：仅包含name';
        dump($request->only(['name']));
        echo '请求参数：排除name';
        dump($request->except(['name']));
        echo '路由信息：';
        dump($request->route());
        echo '调度信息：';
        dump($request->dispatch());

        return 'news/hello';
    }
}