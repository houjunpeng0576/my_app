<?php
namespace app\admin\controller;
use app\common\lib\IAuth;
class Login extends Base
{
    public function _initialize(){}//防止多次重定向

    public function index()
    {
        if($this->isLogin()){
            return $this->redirect('index/index');
        }
        //如果后台用户已登录，直接跳转到后台首页
        return $this->fetch();
    }

    /*
     * 登录相关业务
     */
    public function check()
    {
        if(request()->isPost()){//判定是否是POST提交数据
            $data = input('post.');//接受参数
            if(!captcha_check($data['captcha'])){//验证码验证
                $this->error('验证码不正确');
            }
            unset($data['captcha']);

            //判定username password的合法性

            $validate = validate('AdminUser');//实例化验证类
            if (!$validate->check($data)) {//数据合法性验证
                $this->error($validate->getError());
            }

            $user_mod = model('AdminUser');
            //验证用户是否存在
            try{
                $user = $user_mod->get(['username' => $data['username']]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if (!$user || $user->status != config('code.status_normal')) {//将用户状态写入文件
                $this->error('该用户不存在！');
            }

            //校验用户密码
            if (IAuth::setPassword($data['password']) != $user['password']) {
                $this->error('密码不正确！');
            }

            // 1 更新数据库 登录时间 登录ip
            $udata = [
                'last_login_time' => time(),
                'last_login_ip' => request()->ip()
            ];
            try {
                $user_mod->save($udata, ['id' => $user->id]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            // 2 session
            session(config('admin.session_user'),$user,config('admin.session_user_scope'));//将session和作用域放在配置文件extra中
            $this->success('登录成功','index/index');
        }else{
            $this->error('请求不合法');
        }

    }

    /**
     * 退出登录的逻辑
     * 1.清空session
     * 2.跳转到登录页面
     */
    public function logout(){
        session(null,config('admin.session_user_scope'));
        $this->redirect('login/index');
    }
}