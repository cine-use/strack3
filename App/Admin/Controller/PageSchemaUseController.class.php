<?php

namespace Admin\Controller;

use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 页面使用数据结构配置
// +----------------------------------------------------------------------

class PageSchemaUseController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 新增页面使用数据结构配置
     * @return \Think\Response
     */
    public function addPageSchemaUse()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->addPageSchemaUse($param);
        return json($resData);
    }

    /**
     * 修改页面使用数据结构配置
     * @return \Think\Response
     */
    public function modifyPageSchemaUse()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->modifyPageSchemaUse($param);
        return json($resData);
    }

    /**
     * 删除页面使用数据结构配置
     * @return \Think\Response
     */
    public function deletePageSchemaUse()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $schemaService = new SchemaService();
        $resData = $schemaService->deletePageSchemaUse($param);
        return json($resData);
    }


    /**
     * 获取页面使用数据结构配置列表数据
     * @return \Think\Response
     */
    public function getPageSchemaUseGridData()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->getPageSchemaUseGridData($param);
        return json($resData);
    }

}