<?php
namespace app\admin\controller;

class News extends Base {
    /*
     * 新闻首页
     */
    public function index(){
        return $this->fetch('');
    }

    /*
     * 新闻添加
     */
    public function add(){
        //请求方式
        if(request()->isPost()){
            //接受数据
            $data = input('post.');
            //验证数据
            $validate = validate('News');//实例化验证类
            if(!$validate->check($data)){//检测传递过来的数据
                $this->error($validate->getError());//捕获错误信息，并提示
            }
            //数据入库
            try{
                $id = model('News')->add($data);
            }catch(\Exception $e){
                return $this->result('','0','添加失败！');
            }

            if($id){
                return $this->result(['jump_url' => url('news/index')],1,'添加成功！');
            }else{
                return $this->result('','0','添加失败！');
            }
        }else{
            return $this->fetch('',[
                'cats' => config('cat.lists')
            ]);
        }
    }
}