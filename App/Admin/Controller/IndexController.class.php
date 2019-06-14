<?php

namespace Admin\Controller;

use Common\Service\LoginService;

class IndexController extends AdminController
{

    /**
     * 显示页面
     */
    public function index()
    {
        if (!session('?web_admin_login_session')) {
            return $this->display();
        }else{
            $this->redirect('/admin/about');
        }
    }

    /**
     * 登录后台管理
     * @throws \Exception
     */
    public function LoginAdmin()
    {
        $param = $this->request->param();
        $userId = session('user_id');

        // 获取当前用户信息
        $userData = S('user_data_' . $userId);

        $param = [
            "login_name" => $userData["login_name"],
            "password" => $param["password"],
            "from" => "web_admin",
            "method" => ""
        ];

        $loginService = new LoginService();
        $resData = $loginService->login($param);
        return json($resData);
    }


    /**
     * 退出后台登录
     */
    public function logoutAdmin()
    {
        session("web_admin_login_session", null);
        $this->redirect('/admin/index');
    }
}