<?php

namespace Admin\Controller;

use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 模块结构设置数据控制层
// +----------------------------------------------------------------------

class SchemaController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取Schema数据列表
     */
    public function getSchemaList()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->getSchemaList($param);
        return json($resData);
    }


    /**
     * 获取Schema Combobox数据列表
     */
    public function getSchemaCombobox()
    {
        $schemaService = new SchemaService();
        $resData = $schemaService->getSchemaCombobox();
        return json($resData);
    }


    /**
     * 获取Schema模块数据
     */
    public function getSchemaModuleList()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resultData = $schemaService->getSchemaModuleList($param['schema_id']);
        return json($resultData);
    }

    /**
     * 添加Schema
     */
    public function addSchema()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->addSchema($param);
        return json($resData);
    }

    /**
     * 保存模块结构设置
     */
    public function modifySchema()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->modifySchema($param);
        return json($resData);
    }

    /**
     * 删除模块结构设置
     */
    public function deleteSchema()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->deleteSchema($param);
        return json($resData);
    }

    /**
     * 获取Schema Type Combobox数据列表
     */
    public function getSchemaTypeCombobox()
    {
        $correspondsData = schema_type_data();
        return json($correspondsData);
    }

    /**
     * 获取Schema连接类型
     */
    public function getSchemaConnectType()
    {
        $correspondsData = schema_connect_type_data();
        return json($correspondsData);
    }

    /**
     * 新增ModuleRelation
     */
    public function saveModuleRelation()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->saveModuleRelation($param);
        return json($resData);
    }
}