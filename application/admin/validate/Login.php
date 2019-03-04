<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/4
 * Time: 12:04
 */

namespace app\admin\validate;


use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'      => 'require',
        'password'     => 'require|min:6',
    ];

    protected $message = [
        'username.require'     => '用户名不能为空',
        'password.require'  => '密码不能为空'
    ];
}