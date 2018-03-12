<?php
namespace app\common\lib;
use Aliyun\DySDKLite\SignatureHelper;
use think\Cache;
use think\Log;

class SendSms{
    const LOG_TPL = "---------------------------------------------------------------\naliyun-sms：";
    /**私有静态变量保存全局的实例
     * @var null
     */
    private static $_instance = null;

    /**
     * 私有的构造方法，防止外部实例化
     * SendSms constructor.
     */
    private function __construct(){

    }

    /**
     * 私有的克隆方式，防止被克隆
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 静态单例模式入口
     */
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 发送短信
     */
    function sendSms($phone) {

        $params = array ();
        $config = config('sms');
        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = $config['accessKeyId'];
        $accessKeySecret = $config['accessKeySecret'];

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $phone;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $config['signName'];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $config['templateCode'];

        $code = rand(100000,999999);
        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $code,
        );

        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        try{
            $content = $helper->request(
                $accessKeyId,
                $accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action" => "SendSms",
                    "Version" => "2017-05-25",
                ))
            );
        }catch (\Exception $e){
            //写入日志
            Log::write(self::LOG_TPL."set------".$e->getMessage());
            return false;
        }

        if($content->Code == 'OK'){
            Cache::set($phone,$code,$config['identify_time']);
            return true;
        }else{
            Log::write(self::LOG_TPL."set------111".json_encode($content));
        }
        return false;
    }

    /**
     * 根据手机号码查看验证码是否正常
     * @param int $phone
     */
    public function checkSmsIdentify($phone = 0,$code = 0){
        if(!$phone || !$code || Cache::get($phone) != $code){
            return false;
        }

        return true;
    }
}