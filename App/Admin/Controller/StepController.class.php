<?php

namespace Admin\Controller;

use Common\Service\SchemaService;
use Common\Service\StepService;

// +----------------------------------------------------------------------
// | 工序数据控制层
// +----------------------------------------------------------------------

class StepController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $moduleId = 28;
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
     * 项目工序数据
     */
    public function getStepGridData()
    {
        $param = $this->request->param();
        $stepService = new StepService();
        $resData = $stepService->getStepGridData($param);
        return json($resData);
    }


    /**
     * 新增工序
     */
    public function addStep()
    {
        $param = $this->request->param();
        $stepService = new StepService();
        $resData = $stepService->addStep($param);
        return json($resData);
    }


    /**
     * 修改工序
     */
    public function modifyStep()
    {
        $param = $this->request->param();
        $stepService = new StepService();
        $resData = $stepService->modifyStep($param);
        return json($resData);
    }

    /**
     * 删除工序
     */
    public function deleteStep()
    {
        $param = $this->request->param();
        $stepService = new StepService();
        $resData = $stepService->deleteStep($param);
        return json($resData);
    }

    /**
     * 获取工序列表
     */
    public function getStepList()
    {
        $stepService = new StepService();
        $resData = $stepService->getStepList();
        return json($resData);
    }
}