<?php
namespace app\api\controller;
use app\common\lib\exception\ApiException;
use think\Cache;
use think\Controller;
use app\common\lib\IAuth;
use app\common\lib\Time;

/**
 * API模块基类
 * Class Base
 * @package app\api\controller
 */
class Base extends Controller{
    //headers信息
    public $headers = '';
    //初始化方法
    public function _initialize()
    {
        parent::_initialize();
        $this->checkRequestAuth();
    }

    //检测app没次请求的数据是否合法
    public function checkRequestAuth(){
        //首先需要获取headers的数据
        $headers = request()->header();
        //FdjP4J0wngyHF3oOqOkHJjGwWLWEiGsgeRf5IUeXtVSlQoSheNcSxkhpLTw9p8yiJU2TZileHgIRKe3FQyGuLw==
//        $data = [
//            'model' => 'sanxing5.6',
//            'version' => 1,
//            'app-type' => 'android',
//            'did' => '123456'
//        ];
//        echo IAuth::setSign($data);die;
        //基础参数校验
        if(empty($headers['sign'])){
            throw new ApiException('sign不存在',400);
        }
        //检测app_types
        if(!in_array(strtolower($headers['app-type']),config('app.app_types'))){
            throw new ApiException('app-type不合法',400);
        }

        //检测sign
        if(!IAuth::checkSign($headers)){
            throw new ApiException('授权码sign失败',401);
        }

        //将sign存入缓存用于唯一性判断
        Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));

        $this->headers = $headers;
    }

    public function testAes(){
        $data = [
            'model' => 'ios',
            'did' => '123456',
            'time' => Time::get13TimeStamp(),
        ];
//        echo IAuth::setSign($data);die;
    }

    /**
     * 获取处理的新闻内容的数据
     * @param array $news
     * @return array
     */
    protected function getDealNews($news = []){
        if(empty($news)){
            return [];
        }

        $cats = config('cat.lists');

        foreach ($news as $key => $value){
            $news[$key]['catname'] = $cats[$value['catid']] ? $cats[$value['catid']] : '-';
        }
        return $news;
    }

    //获取小图片
    protected function getSmallImage($news){
        if(empty($news)){
            return [];
        }

        foreach ($news as $key => $value){
            $news[$key]['image'] = $value['image'].'-small';
        }
        return $news;
    }
}