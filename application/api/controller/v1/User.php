<?php
namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\IAuth;

class User extends AuthBase{
    /**
     * 获取用户信息
     */
    public function read(){
        return show(config('code.api_success'),'ok',Aes::encrypt($this->user));
    }

    /**
     * 用户信息修改
     */
    public function update(){
        $putData = input('put.');
        $validate = validate('User');
        if(!$validate->check($putData)){
            return show(config('code.api_error'),$validate->getError(),[],403);
        }

        $data = [];
        if(!empty($putData['head_image'])){
            $data['head_image'] = $putData['head_image'];
        }
        if(!empty($putData['username'])){
            $data['username'] = $putData['username'];
        }
        if(!empty($putData['sex'])){
            $data['sex'] = $putData['sex'];
        }
        if(!empty($putData['signature'])){
            $data['signature'] = $putData['signature'];
        }
        //TODO：需要对传输过来的密码进行加密
        if(!empty($putData['password'])){
            $data['password'] = IAuth::setPassword($putData['password']);
        }

        if(empty($data)){
            return show(config('code.api_error'),'参数不合法',[],404);
        }

        try{
            $id = model('User')->save($data,['id' => $this->user->id]);
            if($id){
                return show(config('code.api_success'),'修改成功',[],202);
            }else{
                return show(config('code.api_error'),'修改失败',[],401);
            }
        }catch (\Exception $e){
            return show(config('code.api_error'),$e->getMessage(),[],500);
        }
    }

    /**
     * 检测昵称是否唯一
     */
    public function checkUsername(){
        $data = input('get.');
        $validate = validate('User');
        $isUnique = $validate->check($data);
        return show(config('code.api_success'),$isUnique ? 'ok' : $validate->getError(),['isUnique'=>$isUnique]);
    }
}