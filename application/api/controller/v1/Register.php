<?php

namespace app\api\controller\v1;


use app\api\controller\Api;
use app\api\tool\SendSms;
use think\Request;

class Register extends Api
{

    /**
     * 不需要鉴权方法
     * index、save不需要鉴权
     * ['index','save']
     * 所有方法都不需要鉴权
     * [*]
     */
    protected $noAuth = [];

    //普通手机号密码注册
    public function register()
    {
        echo time();
        die();
        $data = [
            'name' => $request->nickname,
            'phone' => $request->phone,
            'password' => $request->password,
            'code' => $request->code,
        ];
        //验证请求数据
        $validate = new \app\api\validate\Register;
        $result = $validate->check($data);
        if (!$result) {
            return self::returnMsg(-1, $validate->getError());
        }

        //验证手机号是否已经注册
        $this->phoneExists($data['phone']);

        //验证手机验证码是否正确

        //存储新的数据
        $data['password'] = password_hash($request->password, PASSWORD_DEFAULT);
        $user = new \app\api\model\User;
        $user->save($data);
    }

    /**
     * 验证手机号是否已经注册
     * @param $phone 手机号
     */
    public function phoneExists($phone)
    {
        $result = \app\api\model\User::where('phone', $phone)->count();
        if ($result) {
            return self::returnMsg(-1, '用户已经存在，请直接登陆');
        }
    }


    /**
     * 验证手机验证码是否正确
     */
    public function checkCode($phone,$code){
        //如果缓存不存在，就返回空字符串,这里需要注意一下缓存的过期时间是否有失效--系统bug,暂时没有解决
        $result = Cache::get($phone);
        if(!$result){
            return self::returnMsg(-1, '验证码失效，请重新获取验证码');
        }
        if($result !== $code){
            return self::returnMsg(-1, '验证码错误');
        }
    }


    /**
     * 发送短信验证码
     * @param $phone
     */
    public function sendPhoneNumber($phone){
        $send = new SendSms($phone);
        $send->sendSmsByPhone();
    }

    /**
     * 查询所有用户，测试使用
     */
 /*   public function get()
    {

        $result = \app\api\model\User::all();
        $result = json_decode(json_encode($result), true);
        return self::returnMsg(0, '', $result);

    }*/
}