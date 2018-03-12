<?php
namespace app\common\lib;

/**
 * AES加密解密类库
 * Class Aes
 * @package app\common\lib
 */
class Aes {
    //AES加密模式
    private static $method = 'AES-128-ECB';
    /**
     * 加密
     * @param string $input 需要加密的字符串(可以是字符串和对象，不可以是数组)
     * @param string $key 解密的key
     */
    public static function encrypt($input = ''){
        $str = openssl_encrypt($input,self::$method,config('app.aes_key'));
        return $str;
    }

    /**
     * 解密
     * @param string $input 需要加密的字符串
     * @param string $key 解密的key
     */
    public static function decrypt($input = ''){
        $str = openssl_decrypt($input,self::$method,config('app.aes_key'));
        return $str;
    }
}