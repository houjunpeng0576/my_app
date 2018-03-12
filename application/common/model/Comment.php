<?php
namespace app\common\model;

use think\Db;

class Comment extends Base
{
    public function user()
    {
        return $this->hasMany('User','id','user_id');
    }

    /**
     * 通过条件获取评论的数量
     * @param array $param
     */
    public function getNormalCommentsCountByCondition($param = []){
//        $count = $this->where(['news_id' => $param['news_id'],'status' => 1])->find()->$this->user()->where(['status' => 1])->count();
//        halt($count);
        $count = $this->alias(['ent_comment' => 'a','ent_user' => 'b'])
            ->field('*')
            ->join('ent_user','a.user_id = b.id AND a.status = 1 AND a.news_id = '.$param['news_id'].' AND b.status = 1')
            ->count();
        return $count;
    }

    /**
 * 通过条件获取评论
 * @param array $param
 * @param int $from
 * @param int $size
 * @return array
 */
    public function getNormalCommentsByCondition($param = [],$from = 0,$size = 5){
        $comment = $this->alias(['ent_comment' => 'a','ent_user' => 'b'])
            ->field('*')
            ->join('ent_user','a.user_id = b.id')
            ->where(['a.status' => 1,'b.status' => 1,'a.news_id' => $param['news_id']])
            ->limit($from,$size)
            ->order(['a.id' => 'desc'])
            ->select();
        return $comment;
    }

    /**
     * 获取评论总数
     * @param array $param
     * @return int|string
     */
    public function getCommentCountByCondition($param = []){
        $param['status'] = config('code.content_normal');
        return $this->where($param)
            ->field('id')
            ->count();
    }

    /**
     * 获取列表页
     * @param array $param
     * @param int $from
     * @param int $size
     */
    public function getCommentsByCondition($param = [],$from = 0,$size = 5){
        $param['status'] = config('code.content_normal');
        return $this->where($param)
            ->field('id,user_id,to_user_id,content,create_time,parent_id')
            ->limit($from = 0,$size = 5)
            ->order(['id' => 'desc'])
            ->select();
    }
}