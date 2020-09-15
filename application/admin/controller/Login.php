<?php

namespace app\admin\controller;

use app\common\facade\Response;
use app\admin\model\Users;
use think\Controller;
use think\facade\Cookie;

/**
 * 登录控制器
 * Class Login
 *
 * @package app\admin\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:11
 */
class Login extends Controller
{

    /**
     * 登录页
     *
     * @return \think\Response
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            try {
                $this->validate($param, [
                    'user_name|请输入账号' => 'require',
                    'password|请输入密码' => 'require'
                ]);
            } catch (\Exception $exception) {
                return Response::fail(-1,$exception->getMessage());
            }
            $where = [
                'name'=>$param['user_name'],
                'status'=>1,
            ];
            $user = Users::where($where)->find();
            if (!$user) {
                return Response::fail(-1,'账户错误');
            }
            if(!verifyPasswrod($param['password'], $user->password)){
                return Response::fail(-1,'密码错误');
            }
            $user->hidden(['password']);
            cookie('user',json_encode($user),86400*7);

            return Response::success($user);
        }
        return $this->fetch();
    }

    /**
     * 退出登录
     * author <马良 1826888766@qq.com>
     * time 2020/9/11 15:50
     */
    public function logout()
    {
        Cookie::clear();
        $this->redirect(url('index'));
    }

}
