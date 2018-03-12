<?php
namespace app\common\validate;
use think\Validate;

class Comment extends Validate{
    protected $rule = [
        'news_id' => 'require|number',
        'content' => 'require',
        'to_user_id' => 'number',
        'parent_id' => 'number'
    ];

    protected $message = [
        'news_id.require' => '参数错误',
        'news.number' => '新闻不存在',
        'content' => '参数错误',
        'to_user_id' => '用户不存在',
        'parent_id' => 'id不存在',
    ];
}