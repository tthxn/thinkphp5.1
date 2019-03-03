<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/2
 * Time: 16:19
 */

namespace app\api2\controller;


use Firebase\JWT\JWT;
use think\Controller;

class Main extends Controller
{
    //签发Token
    public function lssue()
    {
        $key = '344'; //key
        $time = time(); //当前时间
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者 可选
            'aud' => 'http://www.helloweba.net', //接收该JWT的一方，可选
            'iat' => $time, //签发时间
            'nbf' => $time , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time+7200, //过期时间,这里设置2个小时
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
                'username' => '李小龙'
            ]
        ];
        echo JWT::encode($token, $key); //输出Token
    }

    public function verification()
    {
        $key = '344'; //key要和签发的时候一样

        //签发的token
        $jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuaGVsbG93ZWJhLm5ldCIsImF1ZCI6Imh0dHA6XC9cL3d3dy5oZWxsb3dlYmEubmV0IiwiaWF0IjoxNTI1MzQwMzE3LCJuYmYiOjE1MjUzNDAzMTcsImV4cCI6MTUyNTM0NzUxNywiZGF0YSI6eyJ1c2VyaWQiOjEsInVzZXJuYW1lIjoiXHU2NzRlXHU1YzBmXHU5Zjk5In19.Ukd7trwYMoQmahOAtvNynSA511mseA2ihejoZs7dxt0"; //签发的Token
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($jwt, $key, ['HS256']); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            print_r($arr);
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            echo $e->getMessage();
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            echo $e->getMessage();
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            echo $e->getMessage();
        }catch(Exception $e) {  //其他错误
            echo $e->getMessage();
        }
        //Firebase定义了多个 throw new，我们可以捕获多个catch来定义问题，catch加入自己的业务，比如token过期可以用当前Token刷新一个新Token
    }


}