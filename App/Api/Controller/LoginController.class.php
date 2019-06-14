<?php

namespace Api\Controller;

use Common\Service\LoginService;
use Common\Service\OptionsService;
use Common\Service\UserService;

class LoginController extends BaseController
{

    /**
     * API 用户登录
     * @throws \Exception
     */
    public function in()
    {
        $loginService = new LoginService();
        $resData = $loginService->login($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 续费token
     * @return \Think\Response
     */
    public function renewToken()
    {
        $userService = new UserService();
        $resData = $userService->renewToken($this->param);
        return $this->responseApiData($resData);
    }

    /**
     * 获取第三方登录列表
     * @return \Think\Response
     */
    public function getThirdServerList()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getThirdServerList();
        return $this->responseApiData($resData);
    }

}