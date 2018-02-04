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
            'neq',config('code.status_delete')
        ];
        $order = ['id' => 'desc'];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }

    //自定义数据列表获取
    public function getNewsByCondition($param = []){
        $condition['status'] = [
            'neq',config('code.status_delete')
        ];

        //获取总数据条数
        $result['total'] = $this->where($condition)->count();
        //获取总页数
        $result['lastPage'] = ceil($result['total'] / $param['size']);
        //请求页数大于总页数的时候，返回''
        if($param['page'] > $result['lastPage']){
            return '';
        }
        //是否有更多数据
        $result['hasMore'] = $param['page'] < $result['lastPage'];
        //当前页数
        $result['currentPage'] = $param['page'];
        //每页的数据条数
        $result['listRows'] = $param['size'];

        $order = ['id' => 'desc'];
        $from = ($param['page'] - 1) * $param['size'];

        //获取当前页的数据
        $result['lists'] = $this->where($condition)
            ->order($order)
            ->limit($from,$param['size'])
            ->select();
//        $result['lists'] = collection($news)->toArray();
        return $result;
    }
}