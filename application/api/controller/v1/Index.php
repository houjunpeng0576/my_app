<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\exception\ApiException;

class Index extends Base{
    /**
     * 获取首页接口
     * 1.投图  4-6条
     * 2.推荐位列表  默认40条
     */
    public function index(){
        try{
            $newsModel = model('News');
            $headNews = $newsModel->getIndexHeadNormalNews();//获取首页投图数据
            $headNews = $this->getDealNews($headNews);
            $positionNews = $newsModel->getPositionNormalNews();//获取首页投图数据
            $positionNews = $this->getDealNews($positionNews);
            $positionNews = $this->getSmallImage($positionNews);
        }catch (\Exception $e){
            throw new ApiException('error',400);
        }

        $result = [
            'heads' => $headNews,
            'positions' =>$positionNews
        ];
        return show(config('code.api_success'),'ok',$result);
    }
}