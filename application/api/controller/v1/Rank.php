<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\exception\ApiException;

/**
 * 排行榜
 * Class Rank
 * @package app\api\controller\v1
 */
class Rank extends Base{
    /**
     * 排行榜数据列表
     * 1.获取数据库 然后根据read_count排序  5-10条
     * 2.优化 redis
     */
    public function index(){
        try{
            $ranks = model('News')->getRankNormalNews();
            $ranks = $this->getDealNews($ranks);
        }catch (\Exception $e){
            throw new ApiException('error',400);
        }

        return show(1,'OK',$ranks);
    }
}