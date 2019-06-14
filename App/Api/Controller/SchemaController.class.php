<?php

namespace Api\Controller;


use Common\Service\SchemaService;

class SchemaController extends BaseController
{
    protected $schemaService;

    public function __construct()
    {
        parent::__construct();
        $this->schemaService = new SchemaService();
    }

    /**
     * 获得Schema
     * @return \Think\Response
     */
    public function getSchemaStructure()
    {
        $resData = $this->schemaService->getModuleRelationData($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 创建Schema关联结构
     * @return \Think\Response
     * @throws \Exception
     */
    public function createSchemaStructure()
    {
        $resData = $this->schemaService->saveSchemaModuleRelation($this->requestParam);
        return $this->responseApiData($resData);
    }


    /**
     * 修改Schema结构
     * @return \Think\Response
     * @throws \Exception
     */
    public function updateSchemaStructure()
    {
        $resData = $this->schemaService->modifySchemaModuleRelation($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 删除Schema
     * @return \Think\Response
     */
    public function deleteSchemaStructure()
    {
        $resData = $this->schemaService->deleteSchema($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 获取Schema数据
     * @return \Think\Response
     */
    public function getAllSchema()
    {
        $resData = $this->schemaService->getSchemaList([]);
        return $this->responseApiData($resData);
    }

    /**
     * 创建Entity模块
     * @return \Think\Response
     * @throws \Exception
     */
    public function createEntityModule()
    {
        $resData = $this->schemaService->saveEntityModuleData($this->requestParam);
        $resData["data"] = [];
        return $this->responseApiData($resData);
    }

    /**
     * 获取单个表配置
     * @return array|\Think\Response
     */
    public function getTableConfig()
    {
        $resData = $this->schemaService->getTableFieldData($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 获取所有表配置
     * @return array|\Think\Response
     */
    public function getAllTableName()
    {
        $resData = $this->schemaService->getAllTableName();
        return $this->responseApiData($resData);
    }

    /**
     * 更新字段表配置
     * @return \Think\Response
     */
    public function updateTableConfig()
    {
        $resData = $this->schemaService->modifyFieldConfig($this->requestParam);
        return $this->responseApiData($resData);
    }

}
