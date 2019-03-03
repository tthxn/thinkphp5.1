<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/1
 * Time: 12:33
 */

namespace app\api\controller;



use think\facade\Request;

class Oauth
{
    use Send;

    /**
     * accessToken存储前缀
     *
     * @var string
     */
    public static $accessTokenPrefix = 'accessToken_';

    /**
     * 过期时间秒数
     *
     * @var int
     */
    public static $expires = 7200;


    /**
     * 认证授权 通过用户信息和路由
     * @param Request $request
     * @return \Exception|UnauthorizedException|mixed|Exception
     * @throws UnauthorizedException
     */
    final function authenticate()
    {
        return self::certification(self::getClient());
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return $this
     * @throws UnauthorizedException
     */
    public static function getClient()
    {
        //获取头部信息
        try {
            $authorization = Request::header('authentication');   //获取请求中的authentication字段，值形式为USERID asdsajh..这种形式
            $authorization = explode(" ", $authorization);        //explode分割，获取后面一窜base64加密数据
            //authentication:USERID base64_encode(appid:accesstoken:uid)
            $authorizationInfo  = explode(":", base64_decode($authorization[1]));  //对base_64解密，获取到用:拼接的自字符串，然后分割，可获取appid、accesstoken、uid这三个参数
            $clientInfo['uid'] = $authorizationInfo[2];
            $clientInfo['appid'] = $authorizationInfo[0];
            $clientInfo['access_token'] = $authorizationInfo[1];
            return $clientInfo;
        } catch (Exception $e) {
            return self::returnMsg(401,'Invalid authorization credentials',Request::header(''));
        }
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     *
     * @param array $arr 需要验证权限的数组,鉴权白名单
     * @return boolean
     */
    public static function match($arr = [])
    {
        $request = Request::instance();
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (!$arr)
        {
            return false;
        }
        //array_map中函数作用到数组$arr的每个值上
        $arr = array_map('strtolower', $arr);
        // 验证请求的方法是否在白名单中，在的话返回true
        if (in_array(strtolower($request->action()), $arr) || in_array('*', $arr))
        {
            return true;
        }

        // 没找到匹配，接下来就需要验证授权
        return false;
    }

    /**
     * 获取用户信息后 验证权限
     * @return mixed
     */
    public static function certification($data = []){

        $getCacheAccessToken = Cache::get(self::$accessTokenPrefix . $data['access_token']);  //获取缓存access_token

        if(!$getCacheAccessToken){
            return self::returnMsg(401,'fail',"access_token不存在或为空");
        }
        if($getCacheAccessToken['client']['appid'] !== $data['appid']){

            return self::returnMsg(401,'fail',"appid错误");  //appid与缓存中的appid不匹配
        }
        return $data;
    }

    /**
     * 生成签名
     * _字符开头的变量不参与签名
     */
    public static function makeSign ($data = [],$app_secret = '')
    {
        unset($data['version']);
        unset($data['sign']);
        return self::_getOrderMd5($data,$app_secret);
    }

    /**
     * 计算ORDER的MD5签名
     */
    private static function _getOrderMd5($params = [] , $app_secret = '') {
        //ksort按照键名对关联数组进行升序排列
        ksort($params);
        $params['key'] = $app_secret;
        //http_build_query()函数的作用是使用给出的关联（或下标）数组生成一个经过 URL-encode 的请求字符串
        return strtolower(md5(urldecode(http_build_query($params))));
    }
}