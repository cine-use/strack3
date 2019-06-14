<?php
namespace Home\Controller;

use Common\Controller\VerifyController;

class ErrorController extends VerifyController
{

    //403页面
    public function e403()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID("error_403");
        return $this->display();
    }

    //404页面
    public function e404()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID("error_404");
        return $this->display();
    }

    //500页面
    public function e500()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID("error_500");
        return $this->display();
    }
}