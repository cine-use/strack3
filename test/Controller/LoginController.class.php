<?php

namespace Test\Controller;


use Api\Controller\BaseController;
use Common\Service\LoginService;

class LoginController extends BaseController
{
    public function loginTest()
    {
        $loginService = new LoginService();
        $resData      = $loginService->login([
            "login_name" => "strack_admin",
            "password"   => "chengwei5566",
            "from"       => "api",

        ]);
        $a=json_encode($resData,true);
        echo $a;
        return $resData;
    }

    public function ldapLoginTest()
    {

        $loginService = new LoginService();
        $resData      = $loginService->login([
            "login_name" => "sayms\Administrator",
            "password"   => "P@ssw0rd",
            "from"       => "api",
            "method"     => "ldap"]);

        echo '<pre>';
        dump($resData);

    }
}