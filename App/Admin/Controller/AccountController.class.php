<?php

namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 后台账户设置数据控制层
// +----------------------------------------------------------------------

use Common\Service\SchemaService;
use Common\Service\UserService;


class AccountController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $moduleId = 34;
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        // 把数据发送到前端页面
        $param = [
            "page" => 'admin_' . $moduleData["code"],
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => $moduleData["name"],
            "module_icon" => $moduleData["icon"]
        ];

        $this->assign($param);

        return $this->display();
    }

    /**
     * 新增帐号
     * @return \Think\Response
     */
    public function addAccount()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->addAccount($param);
        return json($resData);
    }

    /**
     * 修改帐号
     * @return \Think\Response
     */
    public function modifyAccount()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->modifyAccount($param);
        return json($resData);
    }

    /**
     *  删除账号
     */
    public function deleteAccount()
    {
        $param = $this->request->param();
        $param["user_id"] = ['IN', $param["primary_ids"]];
        $userService = new UserService();
        $resData = $userService->deleteAccount($param);
        return json($resData);
    }

    /**
     * 获取用户表格数据
     * @return \Think\Response
     */
    public function getAccountGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $userService = new UserService();
        $resData = $userService->getUserGridData($param);
        return json($resData);
    }

    /**
     * 注销用户（设置用户离职状态）
     * @return \Think\Response
     */
    public function cancelAccount()
    {
        $param = $this->request->param();
        $upData = [
            "id" => ["IN", $param["ids"]],
            "status" => "departing"
        ];
        $userService = new UserService();
        $resData = $userService->cancelAccount($upData);
        return json($resData);
    }

    /**
     * 重置用户密码为默认密码
     * @return \Think\Response
     */
    public function resetAccountPassword()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->resetUserDefaultPassword($param["ids"]);
        return json($resData);
    }
}