<?php

namespace app\api\controller;

use think\Controller;
use app\common\Nsq;

/**
 *
 * Class Index
 *
 * @package app\api\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:16
 */
class Index extends Controller
{
    public function index(){
        $msg['project_name'] = "创享互动平台";
        $msg['project_type'] = "web";
        $msg['device_name'] = "android";
        $msg['device_type'] = "华为p30";
        $msg['source'] = "好友分享";
        $msg['from'] = "";
        $msg['to'] = "";
        $msg['page'] = "首页";
        $msg['event_name'] = "页面";
        $msg['event_act'] = "浏览";
        $msg['event_stay_time'] = 0;
        $msg['user_id'] = "uxey21983";
        $nsq = new Nsq();
        $result = $nsq->publicToNsq(json_encode($msg));

    }
}
