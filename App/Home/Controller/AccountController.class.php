<?php

namespace Home\Controller;

use Common\Controller\VerifyController;

class AccountController extends VerifyController
{
    /*
   * 显示My Account页面
   */
    public function index()
    {
        $param = [
            'module_id' => C("MODULE_ID")["user"],
            "user_id" => session("user_id"),
            "page" => "my_account"
        ];

        // 生成页面唯一信息
        $this->generatePageIdentityID("my_account");

        //$this->getPageAuthRules("my_account", "home");
        $this->assign($param);
        return $this->display();
    }

    /*
     * 显示Account Preferences页面
     */
    public function preferences()
    {
        $param = [
            'module_id' => C("MODULE_ID")["user"],
            "page" => "my_account_preference"
        ];

        // 生成页面唯一信息
        $this->generatePageIdentityID("my_account_preference");

        //$this->getPageAuthRules("my_account_preference", "home");
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示Account Security页面
     */
    public function security()
    {
        if(session("user_id") === 1){
            $this->_noPermission();
        }

        $param = [
            "page" => "my_account_security"
        ];

        // 生成页面唯一信息
        $this->generatePageIdentityID("my_account_security");

        $this->assign($param);

        return $this->display();
    }
}