<?php
namespace app\api\controller\v1;

class Upvote extends AuthBase{
    /**
     * 新闻点赞功能开发
     */
    public function save(){
        $id = input('post.id',0,'intval');
        if(empty($id)){
            return show(config('code.api_error'),'id不存在',[],404);
        }

        //判断id对应的新闻是否存在 =》 ent_news
        if(!model('News') ->field('id')->where(['id' => $id,'status' => config('code.content_normal')])->find()){
            return show(config('code.api_error'),'新闻不存在',[],404);
        }

        //查询文章是否被该用户点赞
        $data = [
            'user_id' => $this->user->id,
            'news_id' => $id,
        ];
        if(model('UserNews')->find($data)){
            return show(config('code.api_error'),'您已经点赞了该新闻',[],401);
        }

        //添加到表中
        try{
            $userNewsId = model('UserNews')->add($data);
            if($userNewsId){
                model('News')->where(['id' => $id])->setInc('upvote_count');
                return show(config('code.api_success'),'点赞成功',[],202);
            }else{
                return show(config('code.api_error'),'内部错误，点赞失败',[],500);
            }
        }catch (\Exception $e){
            return show(config('code.api_error'),'内部错误，点赞失败',[],500);
        }
    }

    /**
     * 取消点赞
     */
    public function delete(){
        $id = input('delete.id',0,'intval');
        if(empty($id)){
            return show(config('code.api_error'),'id不存在',[],404);
        }

        //判断id对应的新闻是否存在 =》 ent_news
        if(!model('News') ->field('id')->where(['id' => $id,'status' => config('code.content_normal')])->find()){
            return show(config('code.api_error'),'新闻不存在',[],404);
        }

        //查询文章是否被该用户点赞
        $data = [
            'user_id' => $this->user->id,
            'news_id' => $id,
        ];
        if(!model('UserNews')->where($data)->find()){
            return show(config('code.api_error'),'您没有点赞该新闻',[],401);
        }

        //删除表中数据
        try{
            $userNewsId = model('UserNews')->where($data)->delete();
            if($userNewsId){
                model('News')->where(['id' => $id])->setDec('upvote_count');
                return show(config('code.api_success'),'取消成功',[],202);
            }else{
                return show(config('code.api_error'),'内部错误，取消失败',[],500);
            }
        }catch (\Exception $e){
            return show(config('code.api_error'),'内部错误，取消失败',[],500);
        }
    }

    /**
     * 查询文章是否被用户点赞
     */
    public function read(){
        $id = input('param.id',0,'intval');
        if(empty($id)){
            return show(config('code.api_error'),'id不存在',[],404);
        }

        //判断id对应的新闻是否存在 =》 ent_news
        if(!model('News') ->field('id')->where(['id' => $id,'status' => config('code.content_normal')])->find()){
            return show(config('code.api_error'),'新闻不存在',[],404);
        }

        //查询文章是否被该用户点赞
        $data = [
            'user_id' => $this->user->id,
            'news_id' => ['in','2,3,4'],
        ];
        halt((model('UserNews')->where($data)->select(false)));
        if(model('UserNews')->select($data)){
            return show(config('code.api_success'),'ok',['isUpvote' => 1]);
        }else{
            return show(config('code.api_success'),'ok',['isUpvote' => 0]);
        }
    }
}