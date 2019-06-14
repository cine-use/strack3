<?php

namespace Home\Controller;

use Common\Controller\VerifyController;

class HelpController extends VerifyController
{
    /**
     * 显示help页面
     */
    public function index()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID('help');
        return $this->display();
    }
}