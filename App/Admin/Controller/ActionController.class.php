<?php
namespace Admin\Controller;

use Common\Service\ActionService;
use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 系统动作数据控制层
// +----------------------------------------------------------------------

class ActionController extends AdminController
{
    /**
     * 显示页面
     * @return mixed
     */
    public function index()
    {
        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = 1;
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
     * 删除动作
     * @return \Think\Response
     */
    public function deleteAction()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $actionService = new ActionService();
        $resData = $actionService->deleteAction($param);
        return json($resData);
    }

    /**
     * 加载动作列表
     * @return \Think\Response
     */
    public function getActionGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $actionService = new ActionService();
        $resData = $actionService->getActionGridData($param);
        return json($resData);
    }
}