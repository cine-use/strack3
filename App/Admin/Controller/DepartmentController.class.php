<?php

namespace Admin\Controller;

use Common\Service\SchemaService;
use Common\Service\UserService;

// +----------------------------------------------------------------------
// | 人员部门设置数据控制层
// +----------------------------------------------------------------------

class DepartmentController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $moduleId = 8;
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        // 把数据发送到前端页面
        $param = [
            "page" => 'admin_' . $moduleData["code"],
            "module_id" => $moduleId,
            "module_code" => $moduleData["code"],
            "module_name" => $moduleData["name"],
            "module_icon" => $moduleData["icon"]
        ];

        $this->assign($param);

        return $this->display();
    }

    /**
     * 新增部门
     */
    public function addDepartment()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->addDepartment($param);
        return json($resData);
    }

    /**
     * 修改部门
     */
    public function modifyDepartment()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->modifyDepartment($param);
        return json($resData);
    }

    /**
     * 删除部门
     */
    public function deleteDepartment()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $userService = new UserService();
        $resData = $userService->deleteDepartment($param);
        return json($resData);
    }

    /**
     * 获取所有部门
     */
    public function getDepartmentGridData()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->getDepartmentGridData($param);
        return json($resData);
    }
}