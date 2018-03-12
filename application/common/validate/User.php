<?php
namespace app\common\validate;
use think\Validate;

class User extends Validate
{
    protected $regex = [
        'password' => [
            'regex' => '/\w_-\./'
        ]
    ];
    protected $rule = [
        'username' => 'unique:user|chsAlphaNum',
        'password' => 'length:6,20|regex:password',
    ];

    protected $message = [
        'username.require' => '昵称不能为空',
        'username.unique' => '该昵称已被他人使用',
        'username.chsAlphaNum' => '昵称只能由汉字字母数字组成',
        'password.length' => '密码的长度必须在6到20位',
        'password.regex' => '密码格式错误，只能由字母、数字、下划线、-、.等组成'
    ];
}