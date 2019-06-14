<?php

namespace Test\Controller;


use Common\Model\EntityModel;
use Common\Model\ModuleModel;
use Common\Model\PageSchemaUseModel;
use Common\Model\ProjectTemplateModel;
use Common\Service\EntityService;
use Common\Service\ProjectService;
use Common\Service\SchemaService;
use Common\Service\StatusService;
use Common\Service\ViewService;
use Think\Controller;

class EntityController extends Controller
{
    public function getEntityGridData()
    {
        $start_time = microtime(true); #获取程序开始执行的时间


        $param = [
            'filter' => [
                "group" => [],
                "sort" => [],
                "request" => [

                ],
                "temp_fields" => ["add" => [], 'cut' => []],
                "filter_input" => [],
                "filter_panel" => [],
                "filter_advance" => []
            ],
            'page' => 'project_shot',
            'module_id' => '53',
            'project_id' => '1'
        ];

        dump($param);

        // 查找页面数据结构设置
        $pageSchemaUseModel = new PageSchemaUseModel();
        $pageSchemaUseData = $pageSchemaUseModel->findData(['filter' => ['page' => $param['page']], 'fields' => 'schema_id']);

        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getSchemaConfig($param, $pageSchemaUseData['schema_id'], "query");
        $pagination = [
            "page_size" => 100,
            "page_number" => 1
        ];
        $schemaFields["pagination"] = array_key_exists("pagination", $param) ? $param["pagination"] : $pagination;

        // 查询关联模型数据
        $entityModel = new EntityModel();
        $resData = $entityModel->getRelationData($schemaFields);
        $end_time = microtime(true);
        $totalTime = $end_time - $start_time;
        dump($totalTime);
        //dump($resData);
    }

    /**
     * 测试-批量添加entity任务
     */
    public function testBatchSaveTask()
    {
        $param = [
            "entity_param" => [
                "module_id" => "53",
                "module_name" => "镜头",
                "project_id" => "1",
                "grid" => "main_datagrid_box",
                "page" => "project_shot",
                "type" => "add_entity_task",
                "main_dom" => "grid_datagrid_main",
                "bar_dom" => "grid_filter",
                "task_module_id" => "4"
            ],
            "task_rows" => [
                "concept" => [
                    "concept_851" => [
                        "base" => [
                            [
                                "field" => "base-name",
                                "field_type" => "built_in",
                                "value" => "concept_851",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-code",
                                "field_type" => "built_in",
                                "value" => "concept_851",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-status_id",
                                "field_type" => "built_in",
                                "value" => "1",
                                "variable_id" => "0",
                            ],
                        ]
                    ],
                    "concept_719" => [
                        "base" => [
                            [
                                "field" => "base-name",
                                "field_type" => "built_in",
                                "value" => "concept_719",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-code",
                                "field_type" => "built_in",
                                "value" => "concept_719",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-status_id",
                                "field_type" => "built_in",
                                "value" => "5",
                                "variable_id" => "0",
                            ],
                        ]
                    ]
                ],
                "comp" => [
                    "comp_611" => [
                        "base" => [
                            [
                                "field" => "base-name",
                                "field_type" => "built_in",
                                "value" => "comp_611",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-code",
                                "field_type" => "built_in",
                                "value" => "comp_611",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-status_id",
                                "field_type" => "built_in",
                                "value" => "6",
                                "variable_id" => "0",
                            ],
                        ]
                    ],
                    "comp_584" => [
                        "base" => [
                            [
                                "field" => "base-name",
                                "field_type" => "built_in",
                                "value" => "comp_584",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-code",
                                "field_type" => "built_in",
                                "value" => "comp_584",
                                "variable_id" => "0",
                            ],
                            [
                                "field" => "base-status_id",
                                "field_type" => "built_in",
                                "value" => "3",
                                "variable_id" => "0",
                            ],
                        ]
                    ]
                ],
            ],
            "entity_ids" => [
                [
                    "id" => "3",
                    "name" => "镜头1",
                ],
                [
                    "id" => "4",
                    "name" => "镜头2",
                ]
            ],
            "step_ids" => [
                [
                    "id" => "11",
                    "name" => "Concept",
                    "code" => "concept",
                    "color" => "eb137b",
                ],
                [
                    "id" => "10",
                    "name" => "Composting",
                    "code" => "comp",
                    "color" => "bcd93b",
                ]
            ],
        ];
        $entityService = new EntityService();
        $resData = $entityService->batchSaveEntityBase($param);
        dump($resData);
    }

    /**
     * 测试
     */
    public function testAddDialog()
    {
        $param = [
            "base" => [
                [
                    "field" => "base-name",
                    "field_type" => "built_in",
                    "value" => "xx",
                    "variable_id" => "0"
                ],
                [
                    "field" => "base-code",
                    "field_type" => "built_in",
                    "value" => "xx",
                    "variable_id" => "0"
                ],
                [
                    "field" => "base-status_id",
                    "field_type" => "built_in",
                    "value" => "2",
                    "variable_id" => "0"
                ],
                [
                    "field" => "base-cc",
                    "field_type" => "custom",
                    "value" => "xx",
                    "variable_id" => "3"
                ]
            ],
            "member" => [
                [
                    "field" => "member-belong_id",
                    "field_type" => "built_in",
                    "value" => "3",
                    "variable_id" => "0"
                ]
            ],
            "media" => [
                [
                    "field" => "media-module_id",
                    "field_type" => "built_in",
                    "value" => "4",
                    "variable_id" => "0"
                ],
                [
                    "field" => "media-md5_name",
                    "field_type" => "built_in",
                    "value" => "1543901715uGxYk1eq",
                    "variable_id" => "0"
                ],
                [
                    "field" => "media-thumb",
                    "field_type" => "built_in",
                    "value" => "http=>//192.168.31.213=>9092/uploads/1543901715uGxYk1eq/1543901715uGxYk1eq_250x140.jpg",
                    "variable_id" => "0"
                ],
                [
                    "field" => "media-size",
                    "field_type" => "built_in",
                    "value" => "origin,250x140",
                    "variable_id" => "0"
                ],
                [
                    "field" => "media-media_server_id",
                    "field_type" => "built_in",
                    "value" => "1",
                    "variable_id" => "0"
                ]
            ]
        ];
    }

    /**
     * 组装面板保存数据格式
     * @param $dialogData
     * @param $param
     * @param $currentModuleData
     */
    private function generateModifyBatchData($dialogData, $param, $masterModuleData)
    {

        // 获取module字段数据
        $schemaService = new SchemaService();
        $moduleCodeMapData = $schemaService->getModuleMapData("code");

        $masterData = []; // 初始化主表保存数据
        $relationData = []; // 初始化关联表保存数据

        foreach ($dialogData as $moduleKey => $dataItem) {
            $currentModuleId = $moduleCodeMapData[$moduleKey]["id"];
            $relationData[$moduleKey] = [];
            foreach ($dataItem as $updateItem) {
                $field = explode("-", $updateItem['field']);
                if ($updateItem['field_type'] == "built_in") {
                    $primaryId = !empty($param["primary_id"]) ? ["IN", $param['primary_id']] : 0;
                    $fieldKey = explode("-", $updateItem['field']);

                    if (($moduleKey === "entity" && $masterModuleData["type"] === "entity") || $moduleKey === $masterModuleData["code"]) {
                        $builtInData[end($fieldKey)] = $updateItem["value"];
                        $builtInData = $this->generateBuiltInFieldData($updateItem, $param, $currentModuleId, $moduleKey);
                        $masterData = $builtInData;
                    } else {
                        $builtInData[end($fieldKey)] = $updateItem["value"];
                        $builtInData["field_type"] = $updateItem["field_type"];
                        $builtInData["project_id"] = $param["project_id"];
                        $builtInData["module_id"] = $currentModuleId;
                        $builtInData["module_code"] = $moduleKey;
                        $builtInData["link_id"] = 0;
                        array_push($relationData[$moduleKey], $builtInData);
                    }
                } else {
                    $customData = $this->generateCustomFieldData($updateItem, $param["project_id"], $currentModuleId, $moduleKey);
                    array_push($relationData[$moduleKey], $customData);
                }
            }
        }
        return ["master_data" => $masterData, "relation_data" => $relationData];
    }

    /**
     * generateBuiltInFieldData
     * @param $field
     * @param $param
     * @param $moduleId
     * @param $moduleCode
     * @param bool $isMedia
     * @return array
     */
    private function generateBuiltInFieldData($field, $param, $moduleId, $moduleCode, $isMedia = false)
    {
        if ($isMedia) {
            $primaryId = $param["entity_id"];
        } else {
            $primaryId = $param["primary_id"] > 0 ? $param["primary_id"] : 0;
        }
        $builtInData = [
            "module_id" => $moduleId,
            "link_id" => 0,
            "project_id" => $param["project_id"],
            "field_type" => $field['field_type'],
            "module_code" => $moduleCode,
            "id" => $primaryId
        ];

        return $builtInData;
    }


    /**
     * 生成固定字段保存数据
     * @param $field
     * @param $projectId
     * @param $moduleId
     * @param $moduleCode
     * @return array
     */
    private function generateCustomFieldData($field, $projectId, $moduleId, $moduleCode)
    {
        $customData = [
            "module_id" => $moduleId,
            "variable_id" => $field['variable_id'],
            "value" => $field['value'],
            "project_id" => $projectId,
            "field_type" => $field['field_type'],
            "module_code" => "variable_value",
            "belong_module" => $moduleCode
        ];

        return $customData;
    }


    /**
     * 获取播放列表下的实体数据
     */
    public function getPlayEntityInfo()
    {
        $param = [
            "entity_id" => 320020,
            "project_id" => 1
        ];
        $entityService = new EntityService();
        $resData = $entityService->getPlayEntityInfo($param);
        dump($resData);
    }
}