<?php
namespace app\admin\controller;

use app\common\lib\IAuth;

class Admin extends Base
{
    public function add(){
        $request = request();
        //判断是否是post提交
        if($request->isPost()){
            $data = input('post.');//接受post传过来的参数
            $validate = validate('AdminUser');//实例化验证类
            if(!$validate->check($data)){//检测传递过来的数据
                $this->error($validate->getError());//捕获错误信息，并提示
            }

            $data['password'] = IAuth::setPassword($data['password']);
            $data['status'] = 1;

            //捕获数据异常
            try{
                $id = model('AdminUser')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if($id){
                $this->success('id为'.$id.'的用户新增成功');
            }else{
                $this->error('error');
            }
        }else{
            return $this->fetch();
        }
    }
}