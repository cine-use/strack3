<?php

namespace Admin\Controller;

use Common\Service\PermissionService;
use Common\Service\AuthService;

// +----------------------------------------------------------------------
// | 用户权限组数据控制层
// +----------------------------------------------------------------------

class RoleController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 添加角色
     */
    public function addAuthRole()
    {
        $param = $this->request->param();
        $authRoleService = new PermissionService();
        $resData = $authRoleService->addAuthRole($param);
        return json($resData);
    }

    /**
     * 修改角色
     */
    public function modifyAuthRole()
    {
        $param = $this->request->param();
        $authRoleService = new PermissionService();
        $resData = $authRoleService->modifyAuthRole($param);
        return json($resData);
    }

    /**
     * 删除角色
     */
    public function deleteAuthRole()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $authRoleService = new PermissionService();
        $resData = $authRoleService->deleteAuthRole($param);
        return json($resData);
    }

    /**
     * 获取角色列表
     */
    public function getAuthRoleList()
    {
        $param = $this->request->param();
        $authRoleService = new PermissionService();
        $resData = $authRoleService->getAuthRoleList($param);
        return json($resData);
    }

    /**
     * 获取页面权限规则模块
     * @return \Think\Response
     */
    public function getAuthPageModuleData()
    {
        $param = $this->request->param();
        $authService = new AuthService();
        $moduleData = [];
        switch ($param["tab"]) {
            case "project":
                $moduleData = $authService->getAuthPageModuleData("project");
                break;
            case "front":
                $moduleData = $authService->getAuthPageModuleData("front,top_panel");
                break;
            case "admin":
                $moduleData = $authService->getAuthPageModuleData("admin_menu");
                break;
            case "api":
                $moduleData = $authService->getAuthPageModuleData("api");
                break;
            case "client":
                $moduleData = $authService->getAuthPageModuleData("client");
                break;
        }
        return json($moduleData);
    }

    /**
     * 获取字段权限规则模块
     */
    public function getAuthFieldModuleData()
    {
        $authService = new AuthService();
        $resData = $authService->getAuthFieldModuleData();
        return json($resData);
    }

    /**
     * 获取权限规则子集
     * @return \Think\Response
     */
    public function getAuthModuleRules()
    {
        $param = $this->request->param();
        $authService = new AuthService();
        $authService->setRole($param["role_id"]);
        if ($param["mode"] === "field") {
            $resData = $authService->getAuthFieldRules($param);
        } else {
            $resData = $authService->getAuthModuleRules($param);
        }
        return json($resData);
    }

    /**
     * 保存角色权限设置
     */
    public function saveAuthAccess()
    {
        $param = $this->request->param();
        $authService = new AuthService();
        $resData = $authService->saveAuthAccess($param);
        return json($resData);
    }
}