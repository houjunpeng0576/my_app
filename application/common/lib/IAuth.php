<?php
namespace app\common\lib;
use think\Cache;

/**
 * IAuth相关
 * Class IAuth
 * @package app\common\lib
 */
class IAuth
{
    /**
     * 设置密码
     * @param $data
     * @return string;
     */
    public static function setPassword($data){
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成每次请求的sign
     * 安全性问题：时间有效性、唯一性、时间一致性（一致性可以通过返回给客户端time，客户端加上对比的时间差来解决）
     * @param array $data
     * @return string
     */
    public static function setSign($data= []){
        //1.按照字典许排序
        ksort($data);
        //2.拼接字符串数据
        $string = http_build_query($data);
        //3.使用aes进行加密
        $string = Aes::encrypt($string);
        return $string;
    }

    /**
     * 检查sign是否正确
     * @param string $sign
     * @param $data
     */
    public static function checkSign($data){
        $str = Aes::decrypt($data['sign']);

        if(empty($str)){
            return false;
        }

        parse_str($str,$arr);
        if(!is_array($arr)){
            return false;
        }
        foreach ($arr as $key => $value){
            if($arr[$key] != $data[$key]){
                return false;
            }
        }

        //app_dubug为true时不验证时间有效性和时间唯一性
        if(!config('app_debug')){
            //解决时间有效性问题
            if(time() - ceil($arr['time'] / 1000) > config('app.app_sign_time')){
                return false;
            }

            //解决时间唯一性问题
            if(Cache::get($data['sign'])){
                return false;
            }
        }

        return true;
    }

    /**
     * 设置登录的token  唯一的
     * @param string $phone
     */
    public static function setAppLoginToken($phone = ''){
        $token = md5(uniqid(md5(microtime(true)),true));
        return sha1($token.$phone);
    }
}