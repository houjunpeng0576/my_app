<?php
namespace app\common\model;
use think\Model;

class Base extends Model
{
    //自动完成时间戳
    protected $autoWriteTimestamp = true;
    //请求页数
    public $page = '';
    //每页的条数
    public $size = '';
    //搜索条件
    public $map = '';
    //搜索排序
    public $order = '';
    //需要搜索的字段
    protected $fields = '*';

    /**
     * 新增
     * @param mixed|string $data
     * @return mixed
     */
    public function add($data)
    {
        if(!is_array($data)){
            exception('传递数据不合法');
        }
        $this->allowField(true)->save($data);//过滤数据字段添加

        return $this->id;//返回新增id
    }

    /**
     * 完成搜索需要的各种参数
     * @param array $where 搜索条件
     * @param array $order 排序
     */
    public function search($where = [],$order = []){
        $this->map = empty($where) ? '' : $where;
        $this->order = empty($order) ? '' : $order;
        $this->page = $this->page ? $this->page : 1;
        $this->size = $this->size ? $this->size : config('paginate.list_rows');
        return $this->autoPage();
    }

    //分页
    public function autoPage(){
        //获取总数据条数
        $result['total'] = $this->where($this->map)->count();
        //获取总页数
        $result['lastPage'] = ceil($result['total'] / $this->size);
        //是否有更多数据
        $result['hasMore'] = $this->page < $result['lastPage'];
        //每页的数据条数
        $result['listRows'] = $this->size;
        //请求页数大于总页数的时候，返回''
        if($this->page > $result['lastPage']){
            $result['currentPage'] = 0;
            $result['lists'] = [];
            return $result;
        }

        //当前页数
        $result['currentPage'] = $this->page;

        $from = ($this->page - 1) * $this->size;

        $result['lists'] = $this->field($this->field)
            ->where($this->map)
            ->order($this->order)
            ->limit($from,$this->size)
            ->select();

        return $result;
    }
}