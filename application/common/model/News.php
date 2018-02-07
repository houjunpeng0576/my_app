<?php
namespace app\common\model;

class News extends Base
{
    /**
     * 后台自动化分页
     * @param array $data
     */
    public function getNews($data = []){
        $data['status'] = [
            'neq',config('code.content_delete')
        ];
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }

    //自定义数据列表获取
    public function getNewsByCondition($condition = []){
        $condition['status'] = [
            'neq',empty($condition['status']) ? config('code.content_delete') : $condition['status']
        ];
        $order = ['id' => 'desc'];
        return $this->search($condition,$order);
    }
}