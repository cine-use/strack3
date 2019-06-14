<?php

namespace Test\Controller;

use Think\Controller;

use Common\Service\SchemaService;

class ModuleController extends Controller
{

    /**
     * 获取项目模板可配置模块列表
     */
    public function getProjectTemplateModuleList()
    {
        $schemaService = new SchemaService();

        $resData = $schemaService->getProjectTemplateModuleList();

        dump($resData);
    }
}