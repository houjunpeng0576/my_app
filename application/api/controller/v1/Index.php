<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\exception\ApiException;
use think\Log;

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

    /**
     * 客户端初始化接口（检测app是否需要升级）
     */
    public function init(){
        //app_type  去ent_version查询
        $version = model('Version')->getLastNormalVersionByAppType($this->headers['app-type']);
        if(empty($version)){
            throw new ApiException('error',400);
        }
        if($version['version'] > $this->headers['version']){
            $version->isUpdate = $version->is_force ? 2 : 1;
        }else{
            $version->isUpdate = 0;//0 不更新，1 更新，2 强制更新
        }

        //记录用户的基本信息
        $actives = [
            'version' => $this->headers['version'],
            'did' => $this->headers['did'],
            'model' => $this->headers['model'],
            'app_type' => $this->headers['app-type'],
        ];
        try{
            model('AppActive')->add($actives);
        }catch (\Exception $e){
            //todo:写入日志
//            Log::write();
        }
        return show(1,'ok',$version);
    }
}