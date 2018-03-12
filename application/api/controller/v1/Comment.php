<?php
namespace app\api\controller\v1;

use app\common\lib\exception\ApiException;
use app\common\model\Comment as CommentMod;

class Comment extends AuthBase{
    /**
     * 评论-回复功能的开发
     */
    public function save(){
        $data = input('post.');
        //验证参数
        $validate = validate('Comment');
        if(!$validate->check($data)){
            return show(config('code.api_error'),$validate->getError(),[],404);
        }

        //TODO：对新闻内容进行过滤

        //判断id对应的新闻是否存在 =》 ent_news
        if(!model('News') ->field('id')->where(['id' => $data['news_id'],'status' => config('code.content_normal')])->find()){
            return show(config('code.api_error'),'新闻不存在',[],404);
        }

        $data['user_id'] = $this->user->id;

        try{
            $id = model('Comment')->add($data);
            if($id){
                return show(config('code.api_success'),'评论成功',[],202);
            }else{
                return show(config('code.api_error'),'内部错误，评论失败',[],500);
            }
        }catch (\Exception $e){
            return show(config('code.api_error'),'内部错误，评论失败',[],404);
        }
    }

    /**
     * 评论列表
     */
//    public function read(){
//        $data = input('param.');
//
////        return show('1','ok',CommentMod::all(['news_id' => $newsId],'user'));
//
//        if(empty($data['id'])){
//            throw new ApiException('id is not',404);
//        }
//
//        $commentMod = model('Comment');
////        return show('1','ok',CommentMod::all(['news_id' => $newsId],'user'));
////        return show('1','ok',$commentMod->with(['user'])->where(['news_id' => $newsId])->select());
////        halt($commentMod->with('user')->select());
//        $map = [
//            'news_id' => $data['id']
//        ];
//        //获取该新闻的总评论数
//        $commentMod->page = empty($data['page']) ? 1 : $data['page'];
//        $commentMod->size = empty($data['size']) ? config('paginate.list_rows') : $data['size'];
//        $count = $commentMod->getNormalCommentsCountByCondition($map);
//        //获取该新闻的评论
//        $size = empty($data['size']) ? config('paginate.list_rows') : intval($data['size']);
//        $page = empty($data['size']) ? 1 : intval($data['size']);
//        $from = ($page - 1) * $size;
//        $comments = $commentMod->getNormalCommentsByCondition($map,$from,$size);
//        //返回数据
//        $lastPage = ceil($count/$size);
//        $result = [
//            'total' => $count,
//            'lastPage' => $lastPage,
//            'hasMore' => $page < $lastPage,
//            'listRows' => $size,
//            'currentPage' => $page,
//            'list' => $comments
//        ];
//        return show(1,'获取成功',$result);
//    }

    public function read(){
        $news_id = input('param.id',1,'intval');
        if(empty($news_id)){
            throw new ApiException('id is not',404);
        }

        $param['news_id'] = $news_id;
        $count = model('Comment')->getCommentCountByCondition($param);
        $size = empty($data['size']) ? config('paginate.list_rows') : intval($data['size']);
        $page = empty($data['size']) ? 1 : intval($data['size']);
        $from = ($page - 1) * $size;
        $comments = model('Comment')->getCommentsByCondition($param,$from,$size);
        $lastPage = ceil($count/$size);

        //获取到评论所有的用户id
        $user_ids = [];
        if($comments){
            foreach ($comments as $comment){
                $user_ids[] = $comment['user_id'];
                if($comment['to_user_id']){
                    $user_ids[] = $comment['to_user_id'];
                }
            }
            $user_ids = array_unique($user_ids);
        }

        //根据user_ids获取用户信息
        $usersInfo = model('User')->getUserByIds($user_ids);

        //处理多个用户的信息，讲述组的下标改为用户的ID
        if(!$usersInfo){
            $userList = [];
        }else{
            foreach ($usersInfo as $userInfo){
                $userList[$userInfo->id] = $userInfo;
            }
        }

        //组装返回数据
        $returnData = [];
        foreach ($comments as $comment){
            $returnData[] = [
                'id' => $comment->id,
                'user_id' => $comment->user_id,
                'to_user_id' => $comment->to_user_id,
                'username' => empty($userList[$comment->user_id]) ? '' : $userList[$comment->user_id]->username,
                'to_username' => empty($userList[$comment->to_user_id]) ? '' : $userList[$comment->to_user_id]->username,
                'content' => $comment->content,
                'parent_id' => $comment->parent_id,
                'create_time' => $comment->create_time,
                'head_image' => empty($userList[$comment->user_id]) ? '' : $userList[$comment->user_id]->head_image,
            ];
        }

        $result = [
            'total' => $count,
            'lastPage' => $lastPage,
            'hasMore' => $page < $lastPage,
            'listRows' => $size,
            'currentPage' => $page,
            'list' => $returnData
        ];
        return show(1,'获取成功',$result);
    }
}