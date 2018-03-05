<?php
namespace app\common\model;

class Version extends Base
{
    /**
     * 根据app-type获取最新版本信息
     * @param string $app_type
     */
    public function getLastNormalVersionByAppType($app_type = ''){
        $map = [
            'status' => 1,
            'app_type' => $app_type
        ];
        $order = [
            'id' => 'desc'
        ];
        return $this->where($map)
            ->order($order)
            ->limit(1)
            ->find();
    }
}