<?php
namespace app\api\controller\v1;
use app\api\controller\Base;

class Cat extends Base{
    /**
     * 栏目接口
     */
    public function read(){
        $cats = config('cat.lists');
        $result = [];

        foreach ($cats as $catid => $catname){
            $result[] = [
                'catid' => $catid,
                'catname' => $catname
            ];
        }

        return show(config('code.api_success'),'OK',$result);
    }
}