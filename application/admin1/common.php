<?php
/**
 * 统一返回信息
 * @param $code 编码 -1失败 0成功
 * @param $msg  信息：‘失败’，‘成功’
 * @param $data
 * @return array
 */
function msg($code, $msg, $data = [])
{
    return compact('code', 'msg', 'data');
}