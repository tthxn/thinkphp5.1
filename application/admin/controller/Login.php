<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/4
 * Time: 0:28
 */

namespace app\admin\controller;

use app\admin\model\SysAdmin;
use think\Controller;


class Login extends Controller
{
    /**
     * 登陆列表
     */
    public function index()
    {
        return view();
    }

    /**
     * 登陆动作
     * @return \think\response\Json|void
     */
    public function doLogin()
    {
        try {


            $userInfo = [
                'username' => input("param.username"),
                'password' => input("param.password"),
                'code' => input("param.code"),
            ];
            $validate = new \app\admin\validate\Login;

            if (!$validate->check($userInfo)) {
                return self::returnMsg(201, $validate->getError(), []);
            }

            /*验证验证码
             * $verify = new Verify();
            if (!$verify->check($code)) {
                return json(msg(-2, '', '验证码错误'));
            }*/

            $userModel = new SysAdmin();
            $hasUser = $userModel->checkUser($userInfo['username']);

            if (empty($hasUser)) {
                return self::returnMsg(201, '管理员不存在', []);
            }

            if (!password_verify($userInfo['password'], $hasUser['password'])) {
                return self::returnMsg(201, '密码错误', []);
            }

            if (1 === $hasUser['status']) {
                return self::returnMsg(201, '该账号被禁用', []);
            }

            unset($hasUser['password']);
            session('userInfo', $hasUser);


            // 更新管理员状态
            $param = [
                'login_times' => $hasUser['login_times'] + 1,
                'login_ip' => request()->ip(),
                'login_time' => time()
            ];
            $res = $userModel->updateStatus($param, $hasUser['uid']);


        } catch (ValidateException $e) {
            // 这是进行验证异常捕获
            return self::returnMsg(201, $e->getError(), []);
        } catch (\Exception $e) {
            // 这是进行异常捕获
            return self::returnMsg(201, $e->getError(), []);
        }
        return self::returnMsg(200, url('index/index'), []);
    }
}
