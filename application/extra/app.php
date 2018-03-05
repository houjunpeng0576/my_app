<?php
return [
    'password_pre_halt' => '',//密码加密盐
    'aes_key' => '',//aes加密盐，客户端和服务端必须保持一致
    'app_types' => [
        'ios',
        'android',
    ],//设备类型
    'app_sign_time' => 10,//sign失效时间(用于时间有效性)
    'app_sign_cache_time' => 20,//sign缓存失效时间(用于时间唯一性)
];