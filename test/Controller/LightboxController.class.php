<?php

namespace Test\Controller;

use Think\Controller;

class LightboxController extends Controller
{

    /**
     * 测试灯箱插件显示
     */
    public function index()
    {
        $systemConfig = [
            "is_dev" => APP_DEBUG,
            "user_id" => session("user_id"),
            'new_login' => 'no',
            'allow_admin' => 'yes'
        ];
        $this->assign($systemConfig);
        return $this->display();
    }
}