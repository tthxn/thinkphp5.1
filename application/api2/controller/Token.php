<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/3
 * Time: 15:31
 */

namespace app\api2\controller;


use Firebase\JWT\JWT;
use think\Controller;
use think\Db;
use think\Request;

class Token extends Controller
{
    //密钥,用于生成token 请不要随意更改
    protected $key = '1gHuiop975cdashyex9Ud23ldsvm2Xq';
    //密钥，用于生成refresh_token
    protected $refreshKey = 'QWERTYUIOP';
    //token过期时间2小时
    protected $expireTime = 7200;
    //refresh_token过期时间30天
    protected $refreshExpireTime = 60 * 60 * 12 * 30;

    public function index(Request $request)
    {
        //判断请求类型refresh_token 还是 password 或者短信验证码登陆
        $grantType = $request->param('grant_type');
        if (empty($grantType)) {
            return self::returnMsg(-1, 'grant_type未传递', []);
        }
        switch ($grantType) {
            case 'password':
                //用户名密码形式登陆，获取token,必传参数：phone，password
                $this->chechUser($request);
            case 'refresh_token':
                //刷新token，返回token和refresh_token,必传参数：refresh_token
                $this->refreshToken($request->param('refresh_token'));
            case 'code':
                //短信验证码形式
            default:
                return self::returnMsg(-1, '缺少参数', []);
        }
    }


    /**
     * 验证用户信息，并生成token
     */
    public function chechUser($data)
    {
        //参数校验
        $userInfo = [
            'phone' => $data->param('phone'),
            'password' => $data->param('password'),
        ];

        $validate = new \app\api2\validate\Login;

        if (!$validate->check($userInfo)) {
            return self::returnMsg(-1, $validate->getError(), []);
        }

        //1、判断数据库中有没有这个phone,没有就去注册
        $res = Db::table('sys_users')->where('phone', $userInfo['phone'])->find();
        if (!$res) {
            return self::returnMsg(-1, '用户不存在，请先注册', []);
        }

        //2、判断用户名和密码是否正确
        $checkResult = password_verify($userInfo['password'], $res['password']);

        if (!$checkResult) {
            return self::returnMsg(-1, '用户密码错误', []);
        }

        //验证成功，返回token
        $data = ['userid' => $res['uid'], 'username' => $res['name']];
        //生成普通token,过期时间是7200s，2小时
        $token = $this->createToken($this->key, $this->expireTime, $data);
        //生成刷新的token，过期时间是15天
        $refreshToken = $this->createToken($this->refreshKey, $this->refreshExpireTime, $data);
        $data = [
            'token' => $token,
            'expire' => time() + $this->expireTime,
            'refresh_token' => $refreshToken,
            'refresh_expire' => time() + $this->refreshExpireTime
        ];
        return self::returnMsg(0, 'success', $data);
    }

    /**
     * 生成token/refresh_token
     * @param $setKey 加密密钥
     * @param int $expTime 过期时间，默认2小时
     * @param array $data 用户相关信息
     */
    public function createToken($setKey, $expTime = 7200, $data = [])
    {
        $time = time(); //当前时间
        $token = [
            'iss' => 'http://www.test.net', //签发者 可选
            'aud' => 'http://www.test.net', //接收该JWT的一方，可选
            'iat' => $time, //签发时间
            'nbf' => $time, //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time + $expTime, //过期时间,这里设置2个小时
            'data' => $data
        ];
        return JWT::encode($token, $setKey); //输出Token
    }


    /**
     * 验证token，将对应token解密
     * @param $setKey 密钥
     * @param $token jwt生成的token
     * @return mixed
     */
    public function varification($setKey, $token)
    {
        JWT::$leeway = 60;//将时间留点余地。当前时间减去60
        $decoded = JWT::decode($token, $setKey, ['HS256']);
        $arr = (array)$decoded;
        return $arr;
    }

    /**
     * 刷新token，获取新的token和refresh_token
     * @param $refreshToken 旧的refresh_token
     */
    public function refreshToken($refreshToken)
    {
        if (empty($refreshToken)) {
            return self::returnMsg(-1, '缺少参数refresh_token', []);
        }
        //旧的refresh_token解密
        $oldRefreshTokenInfo = $this->varification($this->refreshKey, $refreshToken);
        if ($oldRefreshTokenInfo['exp'] < time()) {
            return self::returnMsg(-2, '请重新登陆', []);
        }

        //生成新的token
        $token = $this->createToken($this->key, $this->expireTime, $oldRefreshTokenInfo['data']);
        //生成新的refresh_token
        $refreshToken = $this->createToken($this->refreshKey, $this->refreshExpireTime, $oldRefreshTokenInfo['data']);
        $data = [
            'token' => $token,
            'expire' => time() + $this->expireTime,
            'refresh_token' => $refreshToken,
            'refresh_expire' => time() + $this->refreshExpireTime
        ];
        return self::returnMsg(0, 'success', $data);
    }


}