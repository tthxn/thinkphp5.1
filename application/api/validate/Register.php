<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/2
 * Time: 0:02
 */

namespace app\api\validate;


use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'name'      => 'require',
        'phone'     => 'require|mobile',
        'password'  => 'require|min:6',
    ];

    protected $message = [
        'name.require'      => '昵称不能为空',
        'phone.require'     => '手机不能为空',
        'phone.mobile'      => '手机格式错误',
        'password.require'  => '密码不能为空',
        'password.min'      => '密码最少6位',
    ];
}