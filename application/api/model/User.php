<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/1
 * Time: 23:52
 */

namespace app\api\model;


use think\Model;

class User extends Model
{
    protected $pk = 'uid';

    // 设置当前模型对应的完整数据表名称
    protected $table = 'sys_users';
}