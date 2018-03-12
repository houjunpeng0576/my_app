<?php
namespace app\common\model;

class User extends Base
{
    public function comment()
    {
        return $this->belongsTo('Comment');
    }

    /**
     * 根据id(多个)获取用户信息
     * @param array $ids
     */
    public function getUserByIds($ids = []){
        $ids_str = implode(',',$ids);
        $where = [
            'id' => ['in',$ids_str],
            'status' => config('code.status_normal')
        ];

        $order = [
            'id' => 'desc'
        ];

        return $this->where($where)
            ->field('id,username,head_image')
            ->order($order)
            ->select();
    }
}