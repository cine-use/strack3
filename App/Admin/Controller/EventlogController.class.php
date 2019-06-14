<?php

namespace Admin\Controller;

use Common\Service\EventLogService;
use Common\Service\SchemaService;

class EventlogController extends AdminController
{
    /**
     * 显示页面
     * @return mixed
     */
    public function index()
    {
        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = 22;
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
     * EventLog表格数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getEventLogGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $eventLogService = new EventLogService();
        $resData = $eventLogService->getEventLogGridData($param);
        return json($resData);
    }
}