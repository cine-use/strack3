<?php
namespace Admin\Controller;

use Common\Controller\VerifyController;

class AdminController extends VerifyController
{

    /**
     * 后台控制器基类
     */
    protected function _initialize()
    {
        parent::_initialize();

        // 生成页面唯一信息
        $this->generatePageIdentityID('admin_'.$this->currentController);
    }
}