<?php
namespace app\common\validate;
use think\Validate;

class Identify extends Validate{
    protected $regex = [
        'phone' => '/^[1][3,4,5,7,8][0-9]{9}$/',
        'password' => '/^[\w\._-]+$/',
    ];

    protected $rule = [
        'phone' => 'require|regex:phone',
        'code' => 'require|number|length:4,8',
        'password' => 'length:6,20|regex:password'
    ];

    protected $message = [
        'phone.require' => '手机号必须存在',
        'phone.regex' => '手机号格式错误',
        'code.require' => '验证码不能为空',
        'code' => '验证码错误',
        'password' => '密码错误',
    ];

    protected $scene = [
        'sendIdentify' => ['phone'],//发送验证码
        'code' => ['phone','code'],//验证码登录
        'password' => ['phone','password'],//验证码登录
    ];
}