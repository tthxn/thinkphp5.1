<?php
/**
 * Created by PhpStorm.
 * User: sxj
 * Date: 2019/3/4
 * Time: 19:58
 */

namespace app\admin\model;


use think\Model;

class SysAdmin extends Model
{
    protected $pk = 'uid';

    // 设置当前模型对应的完整数据表名称
    protected $table = 'sys_admin';

    /**
     * 根据用户名检测用户数据
     * @param $userName
     */
    public function checkUser($userName)
    {
        return $this->where('username', $userName)->find();
    }

    /**
     * 更新管理员状态
     * @param array $param
     */
    public function updateStatus($param = [], $uid)
    {
//        try{
            $this->where('uid', $uid)->update($param);
//            return msg(200, 'success', []);
//        }catch (\Exception $e){
//            return msg(201, $e->getMessage(),[]);
//        }
    }
}