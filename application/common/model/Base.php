<?php
namespace app\common\model;
use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true;
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
}