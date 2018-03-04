<?php
namespace app\common\model;

class News extends Base
{
    //需要搜索的字段
    public $field = ['id','catid','image','title','read_count','status','is_position','update_time','create_time'];

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
        if(!isset($condition['status'])){
            $condition['status'] = [
                'neq',empty($condition['status']) ? config('code.content_delete') : $condition['status']
            ];
        }

        $order = ['id' => 'desc'];
        return $this->search($condition,$order);
    }

    /**
     * 获取首页投图数据
     * @param int $num 新闻数量
     */
    public function getIndexHeadNormalNews($num = 4){
        $map = [
            'status' => 1,
            'is_head_figure' => 1
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($map)
            ->field($this->field)
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**
     * 获取首页新闻数据
     * @param int $num 新闻数量
     */
    public function getPositionNormalNews($num = 20){
        $map = [
            'status' => 1,
            'is_position' => 1
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($map)
            ->field($this->field)
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**
     * 获取排行榜数据
     * @param int $num
     */
    public function getRankNormalNews($num = 5){
        $map = [
            'status' => 1,
        ];
        $order = [
            'read_count' => 'desc'
        ];
        return $this->where($map)
            ->field($this->field)
            ->order($order)
            ->limit($num)
            ->select();
    }
}