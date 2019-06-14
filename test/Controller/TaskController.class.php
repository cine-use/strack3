<?php

namespace Test\Controller;

use Common\Model\BaseModel;
use Common\Model\PageSchemaUseModel;
use Common\Service\ViewService;
use Think\Controller;

class TaskController extends Controller
{
    public function getEntityData()
    {
        // 获取entity单条值数据
        $columnData = [
            'shot_name' => "test1",
            'shot_code' => "test1",
            'assets' => [
                "total" => 10,
                "rows" => [
                    [
                        'assets_name' => "test1",
                        'assets_code' => "test1"
                    ],
                    [
                        'assets_name' => "test1",
                        'assets_code' => "test1"
                    ]
                ]
            ],
            "step_name" => [
                [
                    "task_id" => 1,
                    "task_name" => "task_name1"
                ],
                [
                    "task_id" => 2,
                    "task_name" => "task_name2"
                ]
            ],
            "step_code" => [
                [
                    "task_id" => 1,
                    "task_code" => "task_code1"
                ],
                [
                    "task_id" => 2,
                    "task_code" => "task_code2"
                ]
            ],
        ];
    }

    public function getBaseGridData()
    {
        $param = [
            'filter' => [
                "group" => [],
                "sort" => [],
                "request" => [

                ],
                "temp_fields" => [
                    "add" => [
                        "name" => ["field" => "name", "value_show" => "name", "module_code" => "step", "module_type" => "fixed"]
                    ],
                    'cut' => []],
                "filter_input" => [],
                "filter_panel" => [],
                "filter_advance" => []
            ],
            'page' => 'project_base',
            'module_id' => 4,
            'project_id' => 1
        ];
        // 查找页面数据结构设置
        $pageSchemaUseModel = new PageSchemaUseModel();
        $pageSchemaUseData = $pageSchemaUseModel->findData(['filter' => ['page' => $param['page']], 'fields' => 'schema_id']);

        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getSchemaConfig($param, $pageSchemaUseData['schema_id'], "query");

        // 查询关联模型数据
        $baseModel = new BaseModel();
        $baseData = $baseModel->getRelationData($schemaFields);
        dump($baseData);
    }
}