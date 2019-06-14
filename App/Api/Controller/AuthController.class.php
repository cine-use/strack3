<?php

namespace Api\Controller;

use Common\Service\AuthService;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    /**
     * 添加父节点权限
     * @return \Think\Response
     */
    public function createParentAuth()
    {
        $resData = $this->authService->addClientPageAuth($this->requestParam, true);
        return json($resData);
    }

    /**
     * 添加子节点权限
     * @return \Think\Response
     */
    public function createChildAuth()
    {
        $resData = $this->authService->addClientPageAuth($this->requestParam);
        return json($resData);
    }

    /**
     * 获取节点权限
     * @return \Think\Response
     */
    public function getNodeAuth()
    {
        $resData = $this->authService->getPageAuthRules($this->requestParam);
        return json(success_response("", $resData));
    }

    /**
     * 修改权限节点
     * @return \Think\Response
     */
    public function updateNodeAuth()
    {
        $resData = $this->authService->updateClientPageAuth($this->requestParam);
        return json($resData);
    }

    /**
     * 删除权限节点
     * @return \Think\Response
     */
    public function deleteNodeAuth()
    {
        $resData = $this->authService->deleteClientPageAuth($this->requestParam);
        return json($resData);
    }

    /**
     * 查找多条节点权限
     * @return \Think\Response
     */
    public function selectNodeAuth()
    {
        $resData = $this->authService->selectClientPageAuth($this->requestParam);
        return json($resData);
    }
}