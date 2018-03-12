<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\lib\SendSms;
use app\common\model\User;
use think\Log;

class Login extends Base{
    const LOG_TPL = "---------------------------------------------------------------\nlogin-error：";
    public function save(){
        //密码：2fuECrnylnRXqN8iajJgmMchxUjp2e7juacsz8ELpO3e+i7O4pIUIOhlnGBRjwDt
        //验证码：2fuECrnylnRXqN8iajJgmHrgXo1SRfNgHAwrtaHtyCYMdN6KkbJnGqRRAUIFRoSa
//        halt(Aes::decrypt('2fuECrnylnRXqN8iajJgmMchxUjp2e7juacsz8ELpO3e+i7O4pIUIOhlnGBRjwDt'));
        //检测请求方式
        if(!request()->isPost()){
            return show(config('code.api_error'),'请求方式错误',[],403);
        }

        //检测参数是否合法
        $param = $this->input();
        //判断登录方式
        $scene = '';
        switch ($param){
            case array_key_exists('code',$param):
                $scene = 'code';//验证码登录
                break;
            case array_key_exists('password',$param):
                $scene = 'password';//密码登录
                break;
            default:
                return show(config('code.api_error'),'参数错误',[],404);
        }

        $validate = validate('Identify');
        if(!$validate->scene($scene)->check($param)){
            return show(config('code.api_error'),$validate->getError(),[],404);
        }
        //检测验证码是否正确
        if($scene == 'code'){
            if(!SendSms::getInstance()->checkSmsIdentify($param['phone'],$param['code'])){
                return show(config('code.api_error'),'手机验证码错误',[],403);
            }
        }

        //生成token
        $token = IAuth::setAppLoginToken($param['phone']);

        $data = [
            'token' => $token,
            'time_out' => strtotime('+'.config('app.app_login_time_days').' days'),
        ];

        //根据phone查询用户是否存在
        $user = User::get(['phone' => $param['phone']]);
        if($user && $user->status == 1){
            //检测密码是否正确
            if($scene == 'password'){
                if(IAuth::setPassword($param['password']) != $user->password){
                    return show(config('code.api_error'),'密码错误',[],403);
                }
            }
            //更新的逻辑
            try{
                model('User')->save($data,['phone' => $param['phone']]);
                $id = $user->id;
            }catch (\Exception $e){
                Log::write(self::LOG_TPL.'--save--'.$e->getMessage());
                return show(config('code.api_error'),'ok',[],403);
            }
        }else{
            //第一次登录，注册数据
            if($scene == 'code'){
                $data['username'] = '小专家-'.$param['phone'];
                $data['status'] = 1;
                $data['phone'] = $param['phone'];
                try{
                    $id = model('User')->add($data);
                }catch (\Exception $e){
                    Log::write(self::LOG_TPL.'--add--'.$e->getMessage());
                    return show(config('code.api_error'),$e->getMessage(),[],403);
                }
            }else{
                return show(config('code.api_error'),'用户不存在',[],403);
            }
        }

        if($id){
            return show(config('code.api_success'),'ok',Aes::encrypt($token.'||'.$id));
        }else{
            return show(config('code.api_error'),'登录失败',[],403);
        }
    }
}