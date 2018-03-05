<?php
namespace app\common\validate;
use think\Validate;

class Identify extends Validate{
    protected $regex = [
        'phone' => '/^[1][3,4,5,7,8][0-9]{9}$/'
    ];

    protected $rule = [
        'phone' => 'require|regex:phone',
    ];

    protected $message = [
        'phone.require' => '手机号必须存在',
        'phone.regex' => '手机号格式错误'
    ];
}