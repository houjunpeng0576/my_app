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
    //对应的数据库表
    protected $model = '';
    //主键
    protected $primary_key = 'id';

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

    //删除逻辑
    public function delete($id = 0){
        //生成跳转连接
        $referer_url = $_SERVER['HTTP_REFERER'];
        $url_arr = parse_url($referer_url);
        if(isset($url_arr['query'])){
            parse_str($url_arr['query'],$query_arr);
            if(isset($query_arr['page'])){
                unset($query_arr['page']);
            }
            if(isset($query_arr['click_time'])){
                unset($query_arr['click_time']);
            }
            $url_arr['query'] = http_build_query($query_arr);
            $url_arr['query'] = $url_arr['query'] ? '?'.$url_arr['query'] : '';
        }else{
            $url_arr['query'] = '';
        }
        $jump_url = $url_arr['scheme'].'://'.$url_arr['host'].$url_arr['path'].$url_arr['query'];

        if(!intval($id)){
            return $this->result('',0,'ID不合法');
        }

        //获取model
        $model = $this->model ? $this->model : request()->controller();

        try{
            $res = model($model)->save(['status' => -1],['id' => $id]);
        }catch (\Exception $e){
            return $this->result('',0,$e->getMessage());
        }

        if($res){
            return $this->result(['jump_url' => $jump_url],1,'删除成功');
        }
        return $this->result('',0,'删除失败');
    }

    //修改逻辑
    public function edit($id = 0){
        //获取model
        $model = $this->model ? $this->model : request()->controller();
        $model = model($model);
        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];
            unset($data['id']);
            try{
                $res = $model->allowField(true)->save($data,[$this->primary_key => $id]);
            }catch (\Exception $e){
                return $this->result('',0,$e->getMessage());
            }
            if($res){
                return $this->result(['jump_url' => $data['referer_url'],'type' => 2],1,'修改成功');
            }
            return $this->result('',0,'修改失败');
        }else{
            $info = $model->find(['id'=>$id]);
            return $this->fetch('',[
                'info' => $info,
                'cats' => config('cat.lists'),
                'referer_url' => $_SERVER['HTTP_REFERER'],
            ]);
        }
    }
}