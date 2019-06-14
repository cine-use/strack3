<?php

namespace Admin\Controller;

use Common\Service\SchemaService;
use Common\Service\StatusService;

// +----------------------------------------------------------------------
// | 后台状态数据控制层
// +----------------------------------------------------------------------

class StatusController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {

        $schemaService = new SchemaService();
        $moduleId = 27;
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
     * 新增项目状态
     */
    public function addStatus()
    {
        $param = $this->request->param();
        $statusService = new StatusService();
        $resData = $statusService->addStatus($param);
        return json($resData);
    }

    /**
     * 修改项目状态
     */
    public function modifyStatus()
    {
        $param = $this->request->param();
        $statusService = new StatusService();
        $resData = $statusService->modifyStatus($param);
        return json($resData);
    }

    /**
     * 删除项目状态
     */
    public function deleteStatus()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $statusService = new StatusService();
        $resData = $statusService->deleteStatus($param);
        return json($resData);
    }

    /**
     * 项目状态列表数据
     */
    public function getStatusGridData()
    {
        $param = $this->request->param();
        $statusService = new StatusService();
        $resData = $statusService->getStatusGridData($param);
        return json($resData);
    }
}