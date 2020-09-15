<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 创建密码
 * author <马良 1826888766@qq.com>
 * time 2020/9/11 13:36
 *
 * @param string $string 明文密码
 * @param string $salt 加盐
 *
 * @return false|string|null
 */
function createPassword($string)
{
    return password_hash($string, PASSWORD_DEFAULT);
}

/**
 * 比较密码
 * author <马良 1826888766@qq.com>
 * time 2020/9/11 13:36
 *
 * @param string $string   明文密码
 * @param string $password hash 用户数据库加密密码
 */
function verifyPasswrod($string, $password)
{
    return password_verify($string, $password);
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}