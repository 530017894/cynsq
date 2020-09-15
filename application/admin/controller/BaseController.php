<?php


namespace app\admin\controller;


use think\Controller;

class BaseController extends Controller
{
    public function initialize()
    {
        $user = cookie('user');
        if (!$user) {
            $this->redirect(url('login/index'));
        }
        $user = json_decode($user,true);
        $this->assign('user', $user);
    }
}