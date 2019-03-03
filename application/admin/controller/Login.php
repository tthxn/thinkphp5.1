<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 显示登陆列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch("/login");
    }


    /**
     * 用户登陆
     */
    public function doLogin(){

    }

    /**
     * 用户注册-动作
     */
    public function doRegister(Request $request){
        echo $request->phone;
    }

}
