<?php
namespace app\api\controller\v1;
use app\api\controller\Base;
use app\common\lib\exception\ApiException;

class News extends Base{
    public function index(){
        //TODO:完成validate机制
        $data = input('get.');
        $whereData['status'] = config('code.content_normal');
        if(!empty($data['catid'])){
            $whereData['catid'] = input('get.catid',0,'intval');
        }

        if(!empty($data['title'])){
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }

        try{
            $newsModel = model('News');
            $newsModel->page = empty($data['page']) ? 1 : $data['page'];
            $newsModel->size = empty($data['size']) ? config('paginate.list_rows') : $data['size'];
            $news = $newsModel->getNewsByCondition($whereData);
        }catch (\Exception $e){
            throw new ApiException('error',400);
        }

        return show(1,'OK',$news);
    }

    /**
     * 新闻详情
     * app  1.xxx.com/1/html  2.接口
     * @param int $id
     */
    public function read(){
        $id = input('param.id','0','intval');
        if(empty($id)){
            throw new ApiException('id is not',404);
        }

        //通过id获取数据库里的数据
        $news = model('News')->get($id);
        if(empty($news) || $news->status != config('code.content_normal')){
            throw new ApiException('新闻不存在',404);
        }

        $cats = config('cat.lists');
        $news->catname = $cats[$news->catid];

        //增加阅读数
        try{
            model('News')->where(['id'=>$id])->setInc('read_count');
        }catch (\Exception $e){
            throw new ApiException('error',400);
        }

        return show('1','ok',$news);
    }
}