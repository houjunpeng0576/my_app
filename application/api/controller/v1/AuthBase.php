<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\model\User;

/**
 * 权限控制
 * 1.每个需要登录的接口(例如：用户中心 评论 点赞等)都必须继承该类库
 * 2.判定access_user_token是否合法,token有后端传给前端，前端最好重新进行加密
 * 3.用户信息 =》user
 * 安全性问题：唯一性处理
 * Class AuthBase
 * @package app\api\controller\v1
 */
class AuthBase extends Base{
    public $user = '';//登录用户的基本信息
    /**
     * 初始化方法 进行基础参数验证
     */
    public function _initialize(){
        parent::_initialize();
        if(!$this->isLogin()){
            throw new ApiException('您没有登录',401);
        }
    }

    /**
     * 判断用户是否登录
     * @return bool
     */
    public function isLogin(){
        //判定是否存在参数
        if(empty($this->headers['access-user-token'])){
            return false;
        }

        //解密token
        $access_user_token = Aes::decrypt($this->headers['access-user-token']);
        if(empty($access_user_token)){
            return false;
        }
        if(!preg_match('/||/',$access_user_token)){
            return false;
        }

        //分离token和id
        list($token,$id) = explode('||',$access_user_token);
        //查询用户信息，判断用户状态
        $user = User::get(['id' => $id]);
        if(!$user || $user->status != config('code.status_normal')) {
            return false;
        }

        //判断token是否正确，是否过期
        if($token != $user->token || time() > $user->time_out){
            return false;
        }

        $this->user = $user;
        return true;
    }
}