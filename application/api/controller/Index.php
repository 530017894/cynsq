<?php

namespace app\api\controller;

use think\Controller;
//use app\common\Nsq;
use app\admin\service\Es;
use Ip2Region;
use app\common\facade\Response;
use Aknife\Agent\Agent;


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
    public function collect(){
        $timestamp = $this->request->post('timestamp');
        $signature = $this->request->post('signature');
//        if(!check_signature($timestamp,$signature)){
//            return Response::fail('1001',"签名错误");
//        }

        $ip = $this->request->ip();
        $ip2region = new Ip2Region();
        $info = $ip2region->memorySearch('110.249.156.126');
        $arae = explode('|',$info['region']);

        Agent::lang('zh_cn');
        $platform = Agent::platform();
        $device = Agent::device();
        //halt($this->request->header());
        $projectid = substr($this->request->post('pointid'),0,4);
        $pointid = substr($this->request->post('pointid'),-4);
        $body = array();
        $body['projectid'] = $projectid;
        $body['pointid'] = $pointid;
        $body['platform'] = $this->request->post('platform');
        $body['expointid'] = $this->request->post('expointid');
        $body['uuid'] = $this->request->post('uuid');

        $body['province'] = $arae[2];
        $body['city'] = $arae[3];
        $body['device_name'] = $platform['name'];
        $body['device_brand'] = isset($device['brand'])?$device['brand']:'';
        $body['device_type'] = isset($device['name'])?$device['name']:'';
        $body['device_version'] = $platform['version'];

        //halt($body);

        $result = Es::instance()->create($body);

        return Response::success($result);




    }
}
