<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/3
 * Time: 17:26
 */

namespace app\api2\validate;


use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'phone'      => 'require|mobile|number',
        'password'     => 'require|min:6',
    ];

    protected $message = [
        'phone.require'     => '手机不能为空',
        'phone.mobile'      => '手机格式错误',
        'phone.number'      => '手机只能是数字',
        'password.require'  => '密码不能为空',
        'password.min'      => '密码最少6位',
    ];
}