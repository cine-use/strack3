<?php

namespace Admin\Controller;

use Common\Service\HorizontalService;
use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 系统模块设置数据控制层
// +----------------------------------------------------------------------

class ModuleController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取模块类型列表
     */
    public function getModuleTypeList()
    {
        $moduleTypeList = [
            ['type_id' => 'entity', 'type_name' => L('Entity')],
            ['type_id' => 'fixed', 'type_name' => L('Fixed_Module')]
        ];
        return json($moduleTypeList);
    }

    /**
     * 获取固定模块模块列表
     */
    public function getFixedModuleList()
    {
        $schemaService = new SchemaService();
        $resData = $schemaService->getFixedModuleList();
        return json($resData);
    }

    /**
     * 获取模块数据
     */
    public function getModuleData()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->getModuleData($param);
        return json($resData);
    }

    /**
     * 添加模块
     * @return \Think\Response
     * @throws \Exception
     */
    public function addModule()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->addModule($param);
        return json($resData);
    }

    /**
     * 修改模块
     */
    public function modifyModule()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->modifyModule($param);
        return json($resData);
    }

    /**
     * 删除模块
     */
    public function deleteModule()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $schemaService = new SchemaService();
        $resData = $schemaService->deleteModule($param);
        return json($resData);
    }

    /**
     * 关联模型列表
     */
    public function getRelationshipModuleList()
    {
        $param = $this->request->param();
        $horizontalService = new HorizontalService();
        switch ($param["type"]) {
            case "entity":
                $resData = $horizontalService->getEntityRelationshipModuleList($param);
                break;
            default:
                $resData = [];
                break;
        }
        return json($resData);
    }
}