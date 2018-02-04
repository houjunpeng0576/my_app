<?php
namespace app\common\validate;
use think\Validate;

class News extends Validate
{
    protected $rule = [
        'title' => 'require',
        'small_title' => 'require',
        'image' => 'require',
        'content' => 'require'
    ];
}