<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/2
 * Time: 16:41
 */

namespace app\api2\controller;


use Firebase\JWT\JWT;
use think\Controller;
use think\facade\Log;
use think\facade\Request;


class Login extends Controller
{
    //密钥,请不要随意更改
    protected $key = '1gHuiop975cdashyex9Ud23ldsvm2Xq';

    public function index()
    {
        return $this->fetch("/login");
    }

    //登陆
    public function doLogin()
    {
        $res['result'] = 'failed';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlentities($_POST['user']);
            $password = htmlentities($_POST['pass']);
            if ($username == 'demo' && $password == 'demo') { //用户名和密码正确，则签发tokon
                $nowtime = time();
                $token = [
                    'iss' => 'http://www.fruit.com', //签发者
                    'aud' => 'http://www.fruit.com', //jwt所面向的用户
                    'iat' => $nowtime, //签发时间
                    'nbf' => $nowtime, //在什么时间之后该jwt才可用
                    'exp' => $nowtime + 600, //过期时间-10min
                    'data' => [
                        'userid' => 1,
                        'username' => $username
                    ]
                ];
                $jwt = JWT::encode($token, $this->key);

                $res['result'] = 'success';
                $res['jwt'] = $jwt;
            } else {
                $res['msg'] = '用户名或密码错误!';
            }
        }
        echo json_encode($res);
    }


    /**
     * 用户携带请求头信息访问接口
     */
    public function getInfo()
    {
        $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
        if (empty($jwt)) {
            return $this->returnMsg(-1, 'You do not have permission to access.', []);
        }
        try {
            JWT::$leeway = 60;//将时间留点余地。当前时间减去60
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            $arr = (array)$decoded;
        } catch (\Exception $e) {
            return self::returnMsg(-1, $e->getMessage(), []);
        }
        return self::returnMsg(0, 'success', $arr);
    }
}