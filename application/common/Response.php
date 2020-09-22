<?php


namespace app\common;

/**
 * 请求响应
 * Class Response
 *
 * @package app\common\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:00
 */
class Response
{

    /**
     * /**
     * 正确返回
     *
     * @param array  $data    返回数据
     * @param string $msg     返回消息
     * @param int    $code    返回状态码
     * @param mixed  ...$vars 其他参数
     *
     * @return \think\response\Json
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:02
     */
    public function success($data = [], $msg = "请求成功")
    {
        return json([
            "code" => 200,
            "msg" => $msg,
            "data" => $data,
        ]);
    }

    /**
     * 错误返回
     *
     * @param int    $code    返回错误码
     * @param string $msg     返回错误信息
     * @param mixed  ...$vars 其他参数
     *
     * @return \think\response\Json
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:02
     */
    public function fail($code, $msg = "")
    {
        return json([
            "code" => $code,
            "msg" => $msg,
        ]);
    }

}