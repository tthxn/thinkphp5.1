<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/1
 * Time: 23:08
 */

namespace app\api\tool;

use think\facade\Cache;
use think\Request;

/**
 * Class SendSms 发送短信验证码类（这里使用聚合短信验证，地址：https://www.juhe.cn/docs/api/id/54）
 * @package app\api\tool
 */
class SendSms
{
    protected $phone = '';
    protected $company = '';

    public function __construct($phoneNumber,$company = '天成公司')
    {
        $this->phone = $phoneNumber;
        $this->company = $company;
    }

    /**
     * 发送短信
     */
    public function sendSmsByPhone()
    {
        //生成短信验证码
        $code = create_code();
        //发送 短信验证码
        $this->sendSmsApi($this->phone, $code);
        //存储在缓存中（5分钟内有效）
        Cache::set($this->phone,$code,300);
    }


    public function sendSmsApi($phone, $code)
    {

        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL

        $smsConf = array(
            'key' => '*****************', //您申请的APPKEY
            'mobile' => $phone, //接受短信的用户手机号码
            'tpl_id' => '111', //您申请的短信模板ID，根据实际情况修改
            'tpl_value' => '#code#=' . $code . '&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );

        $content = juhecurl($sendUrl, $smsConf, 1); //请求发送短信

        if ($content) {
            $result = json_decode($content, true);
            $error_code = $result['error_code'];
            if ($error_code == 0) {
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：" . $result['result']['sid'];
            } else {
                //状态非0，说明失败
                $msg = $result['reason'];
                echo "短信发送失败(" . $error_code . ")：" . $msg;
            }
        } else {
            //返回内容异常，以下可根据业务逻辑自行修改
            echo "请求发送短信失败";
        }
    }

    //聚合验证的函数,无需修改,放在类外或者公共文件

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    /**
     * 生成验证码
     */
    function create_code($length = 6)
    {
        $min = pow(10, ($length - 1));
        $max = pow(10, $length) - 1;

        return mt_rand($min, $max);
    }


}