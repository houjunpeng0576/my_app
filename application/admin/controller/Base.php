<?php
namespace app\admin\controller;

use think\Controller;

/**
 * 后台基础类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    //默认返回类型
    private $_type = 'json';
    /**
     * 初始化方法
     */
    public function _initialize(){
        //判断用户是否登录
        $isLogin = $this->isLogin();
        if(!$isLogin){
            return $this->redirect('login/index');
        }
    }

    /**
     * 判断是否登录
     */
    public function isLogin(){
        //获取session
        $user = session(config('admin.session_user'),'',config('admin.session_user_scope'));
        if($user && $user->id){
            return true;
        }
        return false;
    }

    /**
     * 封装api成功返回的数据
     * @param string $message 返回信息
     * @param $data 返回数据
     * @param int $code 返回状态码
     * @param string $type 返回类型
     */
    public function apiSuccess($message = '',$data,$code = 0,$type = ''){
        $type = $type ? $type : $this->_type;
        $this->result($data,$code,$message,$type);
    }

    //封装api成功返回的数据
    public function apiError($code = '',$message = '',$data = '',$type = ''){
        $type = $type ? $type : $this->_type;
        $this->result($data,$code,$message,$type);
    }

}