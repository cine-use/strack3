<?php

namespace Test\Controller;

use Common\Model\BaseModel;
use Common\Model\EntityModel;
use Common\Model\FileCommitModel;
use Common\Model\HorizontalConfigModel;
use Common\Model\ModuleRelationModel;
use Common\Service\EntityService;
use Common\Service\FileService;
use Common\Service\HorizontalService;
use Common\Service\SchemaService;
use Common\Service\ViewService;
use Think\Controller;

class SchemaController extends Controller
{
    /**
     * 模版与视图之间的联动数据
     */
    public function templateViewLinkageData()
    {
        $templateModuleData = [
            "shot" => [
                "tab" => [
                    [
                        "name" => "反馈",
                        "type" => "fixed",
                        "group" => "固定模块",
                        "table" => "",
                        "tab_id" => "note",
                        "module_id" => "17",
                        "module_code" => "note",
                        "module_type" => "fixed",
                        "dst_module_code" => "note"
                    ]
                ],
                "step" => [
                    [
                        "id" => "11",
                        "code" => "concept",
                        "name" => "Concept",
                        "color" => "eb137b",
                        "checked" => "no"
                    ],
                    [
                        "id" => "10",
                        "code" => "comp",
                        "name" => "Composting",
                        "color" => "bcd93b",
                        "checked" => "no"
                    ]
                ],
                "status" => [
                    [
                        "id" => "8",
                        "code" => "outsource",
                        "icon" => "icon-uniF045",
                        "name" => "Outsource",
                        "color" => "ff2ef8",
                        "checked" => "no",
                        "correspond" => "in_progress",
                        "corresponds_lang" => "进行中"
                    ],
                    [
                        "id" => "7",
                        "code" => "ip",
                        "icon" => "icon-uniE6B9",
                        "name" => "In progress",
                        "color" => "4e74f2",
                        "checked" => "no",
                        "correspond" => "in_progress",
                        "corresponds_lang" => "进行中"
                    ],
                    [
                        "id" => "5",
                        "code" => "normal",
                        "icon" => "icon-uniEAB1",
                        "name" => "Normal",
                        "color" => "10a0e8",
                        "checked" => "no",
                        "correspond" => "in_progress",
                        "corresponds_lang" => "进行中"
                    ]
                ],
                "step_fields" => [
                    [
                        "id" => "code",
                        "edit" => "allow",
                        "lang" => "编码",
                        "mask" => "",
                        "show" => "yes",
                        "sort" => "allow",
                        "type" => "varchar",
                        "group" => "",
                        "table" => "Base",
                        "editor" => "text",
                        "fields" => "code",
                        "filter" => "allow",
                        "module" => "base",
                        "require" => "yes",
                        "multiple" => "no",
                        "validate" => "",
                        "_selected" => "",
                        "formatter" => "",
                        "field_type" => "built_in",
                        "value_show" => "code",
                        "allow_group" => "allow",
                        "module_code" => "base",
                        "module_type" => "fixed",
                        "belong_table" => "任务",
                        "field_group_id" => "base_code",
                        "step_task_formatter" => ""
                    ],
                    [
                        "id" => "thumb",
                        "edit" => "allow",
                        "lang" => "缩略图",
                        "mask" => "",
                        "show" => "yes",
                        "sort" => "deny",
                        "type" => "text",
                        "group" => "",
                        "table" => "Media",
                        "width" => "105",
                        "editor" => "upload",
                        "fields" => "thumb",
                        "filter" => "deny",
                        "module" => "media",
                        "multiple" => "no",
                        "validate" => "",
                        "_selected" => "1",
                        "formatter" => "Strack.build_grid_thumb_dom(value);",
                        "field_type" => "built_in",
                        "value_show" => "thumb",
                        "allow_group" => "deny",
                        "module_code" => "media",
                        "module_type" => "fixed",
                        "belong_table" => "媒体",
                        "outreach_lang" => "Thumbnail",
                        "field_group_id" => "media_thumb",
                        "outreach_editor" => "upload",
                        "outreach_display" => "yes",
                        "outreach_formatter" => "Strack.build_grid_thumb_dom(value);"
                    ],
                    [
                        "id" => "name",
                        "edit" => "allow",
                        "lang" => "名称",
                        "mask" => "",
                        "show" => "yes",
                        "sort" => "allow",
                        "type" => "varchar",
                        "group" => "",
                        "table" => "Base",
                        "editor" => "text",
                        "fields" => "name",
                        "filter" => "allow",
                        "module" => "base",
                        "require" => "yes",
                        "multiple" => "no",
                        "validate" => "",
                        "_selected" => "1",
                        "formatter" => "",
                        "field_type" => "built_in",
                        "value_show" => "name",
                        "allow_group" => "allow",
                        "module_code" => "base",
                        "module_type" => "fixed",
                        "belong_table" => "任务",
                        "field_group_id" => "base_name",
                        "step_task_formatter" => ""
                    ],
                    [
                        "id" => "name",
                        "edit" => "allow",
                        "lang" => "名称",
                        "mask" => "",
                        "show" => "yes",
                        "sort" => "allow",
                        "type" => "varchar",
                        "group" => "",
                        "table" => "Status",
                        "editor" => "text",
                        "fields" => "name",
                        "filter" => "allow",
                        "module" => "status",
                        "require" => "yes",
                        "multiple" => "no",
                        "validate" => "",
                        "_selected" => "1",
                        "field_type" => "built_in",
                        "value_show" => "name",
                        "allow_group" => "allow",
                        "data_source" => "status",
                        "module_code" => "status",
                        "module_type" => "fixed",
                        "belong_table" => "状态",
                        "outreach_edit" => "allow",
                        "field_group_id" => "status_name",
                        "is_foreign_key" => "no",
                        "foreign_key_map" => "status_id",
                        "outreach_editor" => "combobox",
                        "outreach_display" => "yes"
                    ],
                    [
                        "id" => "name",
                        "edit" => "deny",
                        "lang" => "名称",
                        "mask" => "",
                        "show" => "yes",
                        "sort" => "deny",
                        "type" => "varchar",
                        "group" => "",
                        "table" => "Module",
                        "editor" => "none",
                        "fields" => "name",
                        "filter" => "deny",
                        "module" => "module",
                        "require" => "yes",
                        "multiple" => "no",
                        "validate" => "",
                        "_selected" => "1",
                        "field_type" => "built_in",
                        "value_show" => "name",
                        "allow_group" => "deny",
                        "module_code" => "module",
                        "module_type" => "fixed",
                        "belong_table" => "模块",
                        "field_group_id" => "module_name",
                        "outreach_display" => "yes"
                    ]
                ]
            ]
        ];
        $viewData = [
            "sort" => [
                "sort_data" => [

                ],
                "sort_query" => [
                    "shot_id" => [
                        "type" => "desc",
                        "field" => "id",
                        "field_type" => "built_in",
                        "value_show" => "shot_id",
                        "module_code" => "shot"
                    ]
                ]
            ],
            "group" => [
                "shot_code" => [
                    "type" => "asc",
                    "field" => "code",
                    "field_type" => "built_in",
                    "value_show" => "shot_code",
                    "module_code" => "shot"
                ]
            ],
            "fields" => [
                [
                    [
                        "colspan" => 2,
                        "frozen_status" => true
                    ],
                    [
                        "bgc" => "",
                        "but" => "",
                        "step" => "no",
                        "class" => "",
                        "fhcol" => true,
                        "fname" => "",
                        "title" => "",
                        "colspan" => 23,
                        "frozen_status" => false
                    ],
                    [
                        "bgc" => "eb137b",
                        "but" => "concept",
                        "step" => "yes",
                        "class" => "concept_h",
                        "fhcol" => false,
                        "fname" => "concept",
                        "title" => "Concept",
                        "colspan" => 4,
                        "field_list" => "base_code,base_name,base_status_name",
                        "first_field" => "base_media_thumb",
                        "frozen_status" => false,
                        "hidden_status" => "no"
                    ],
                    [
                        "bgc" => "",
                        "but" => "",
                        "step" => "no",
                        "class" => "",
                        "fhcol" => true,
                        "fname" => "",
                        "title" => "",
                        "colspan" => 7,
                        "frozen_status" => false
                    ],
                    [
                        "bgc" => "bcd93b",
                        "but" => "comp",
                        "step" => "yes",
                        "class" => "comp_h",
                        "fhcol" => true,
                        "fname" => "comp",
                        "title" => "Composting",
                        "colspan" => 1,
                        "field_list" => "base_code,base_name,base_status_name",
                        "first_field" => "base_media_thumb",
                        "frozen_status" => false,
                        "hidden_status" => "no"
                    ]
                ],
                [
                    [
                        "field" => "shot_media_thumb",
                        "width" => 105,
                        "frozen_status" => true
                    ],
                    [
                        "field" => "shot_id",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_name",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_code",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_description",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_start_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_end_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_duration",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_created_by",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_created",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_id",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_name",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_code",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_rate",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_description",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_start_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_end_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_created_by",
                        "width" => 230,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_project_created",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_module_name",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_status_name",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_id",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_name",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_code",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "bdc" => "eb137b",
                        "cbd" => "colleft",
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "concept_base_media_thumb",
                        "title" => "缩略图 (媒体)",
                        "width" => 105,
                        "belong" => "concept",
                        "findex" => 23,
                        "hidden" => false,
                        "cellClass" => "datagrid-cell-c1-concept_base_media_thumb",
                        "deltaWidth" => 1,
                        "step_index" => "first",
                        "frozen_status" => false
                    ],
                    [
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "concept_base_code",
                        "title" => "编码",
                        "width" => 140,
                        "belong" => "concept",
                        "findex" => 24,
                        "hidden" => false,
                        "step_index" => "",
                        "frozen_status" => false
                    ],
                    [
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "concept_base_name",
                        "title" => "名称",
                        "width" => 140,
                        "belong" => "concept",
                        "findex" => 25,
                        "hidden" => false,
                        "step_index" => "",
                        "frozen_status" => false
                    ],
                    [
                        "bdc" => "eb137b",
                        "cbd" => "colright",
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "concept_base_status_name",
                        "title" => "名称 (状态)",
                        "width" => 140,
                        "belong" => "concept",
                        "findex" => 26,
                        "hidden" => false,
                        "cellClass" => "datagrid-cell-c1-concept_base_status_name",
                        "deltaWidth" => 1,
                        "step_index" => "last",
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_description",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_start_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_end_time",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_duration",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_created_by",
                        "width" => 230,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_sequence_created",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "field" => "shot_tag_link",
                        "width" => 140,
                        "frozen_status" => false
                    ],
                    [
                        "bdc" => "bcd93b",
                        "cbd" => "colboth",
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "comp_base_media_thumb",
                        "title" => "缩略图 (媒体)",
                        "width" => 105,
                        "belong" => "comp",
                        "findex" => 35,
                        "hidden" => false,
                        "cellClass" => "datagrid-cell-c1-comp_base_media_thumb",
                        "deltaWidth" => 1,
                        "step_index" => "first",
                        "frozen_status" => false
                    ],
                    [
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "comp_base_code",
                        "title" => "编码",
                        "width" => 140,
                        "belong" => "comp",
                        "findex" => 36,
                        "hidden" => true,
                        "step_index" => "",
                        "frozen_status" => false
                    ],
                    [
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "comp_base_name",
                        "title" => "名称",
                        "width" => 140,
                        "belong" => "comp",
                        "findex" => 37,
                        "hidden" => true,
                        "step_index" => "",
                        "frozen_status" => false
                    ],
                    [
                        "bdc" => "bcd93b",
                        "cbd" => "colright",
                        "drag" => false,
                        "step" => true,
                        "align" => "center",
                        "field" => "comp_base_status_name",
                        "title" => "名称 (状态)",
                        "width" => 140,
                        "belong" => "comp",
                        "findex" => 38,
                        "hidden" => true,
                        "cellClass" => "datagrid-cell-c1-comp_base_status_name",
                        "deltaWidth" => 1,
                        "step_index" => "last",
                        "frozen_status" => false
                    ]
                ]
            ],
            "filter" => [
                "sort" => [
                    "sort_data" => [

                    ],
                    "sort_query" => [
                        "shot_id" => [
                            "type" => "desc",
                            "field" => "id",
                            "field_type" => "built_in",
                            "value_show" => "shot_id",
                            "module_code" => "shot"
                        ]
                    ]
                ],
                "group" => [
                    "shot_code" => [
                        "type" => "asc",
                        "field" => "code",
                        "field_type" => "built_in",
                        "value_show" => "shot_code",
                        "module_code" => "shot"
                    ]
                ],
                "request" => [
                    [
                        "field" => "project_id",
                        "table" => "Entity",
                        "value" => "2",
                        "condition" => "EQ",
                        "module_code" => "shot"
                    ],
                    [
                        "field" => "module_id",
                        "table" => "Entity",
                        "value" => "57",
                        "condition" => "EQ",
                        "module_code" => "shot"
                    ]
                ],
                "filter_id" => "3",
                "filter_input" => [

                ],
                "filter_panel" => [
                    [
                        "field" => "name",
                        "table" => "Entity",
                        "value" => "B",
                        "editor" => "text",
                        "condition" => "LIKE",
                        "field_type" => "built_in",
                        "module_code" => "shot",
                        "variable_id" => "0"
                    ]
                ],
                "filter_advance" => [

                ]
            ]
        ];

        // 模版设置工序
        $templateStep = $templateModuleData["shot"]["step"];

        $stepCodeMap = array_column($templateStep, null, "code");

        // 模版设置工序字段
        $templateStepFields = $templateModuleData["shot"]["step_fields"];

        // 增加视图显示字段格式
        $masterModuleCode = "base";
        foreach ($templateStepFields as &$stepFieldItem) {
            if ($stepFieldItem["module_code"] === $masterModuleCode) {
                $stepFieldItem["view_field"] = $stepFieldItem["module_code"] . "_" . $stepFieldItem["fields"];
            } else {
                $stepFieldItem["view_field"] = $masterModuleCode . "_" . $stepFieldItem["module_code"] . "_" . $stepFieldItem["fields"];
            }
        }

        // 获取所有的工序显示字段
        $viewFields = array_column($templateStepFields, "view_field");
        // 获取工序显示的第一个字段
        $firstFields = $viewFields[0];

        // 获取除第一个以外的字段
        $fieldList = [];
        foreach ($viewFields as $key => $fieldItem) {
            if ($key > 0) {
                array_push($fieldList, $fieldItem);
            }
        }

        // 处理双层表头中 第一层数据
        foreach ($viewData["fields"][0] as &$firstFieldItem) {
            if (array_key_exists("step", $firstFieldItem) && $firstFieldItem["step"] === "yes") {
                $firstFieldItem["first_field"] = $firstFields;
                $firstFieldItem["field_list"] = join(",", $fieldList);
            }
        }

        // 处理双层表头中 第二层数据
        foreach ($viewData["fields"][1] as &$secondFieldItem) {
            if (array_key_exists("step", $secondFieldItem) && $secondFieldItem["step"]) {

            }
        }

    }

    /**
     * 生产grid columns 结构
     */
    public function getGridColumns()
    {
        $param = [
            "grid_id" => "main_datagrid_box",
            "loading_id" => ".projpage-main",
            "module_id" => 4,
            "page" => "project_base",
            "project_id" => 1,
            "schema_page" => "project_base",
            "view_type" => "grid"
        ];

//        $param = [
//            "grid_id" => "main_datagrid_box",
//            "loading_id" => ".projpage-main",
//            "module_id" => 59,
//            "page" => "project_asset",
//            "project_id" => 1,
//            "schema_page" => "project_asset",
//            "view_type" => "grid"
//        ];

        $viewService = new ViewService();
        $resData = $viewService->getGirdViewConfig($param);
        dump($resData);
    }

    /**
     * 获取表格面板数据
     */
    public function getGridPanelData()
    {
        $param = [
            "module_id" => 56,
            "page" => "project_sequence",
            "project_id" => 1,
            "schema_page" => "project_sequence",
            "view_type" => "grid"
        ];
        $viewService = new ViewService();
        $resData = $viewService->getGridPanelData($param);
        dump($resData);
    }

    /**
     *
     */
    public function getEntityGridData()
    {
        $param = [
            "filter" => [
                "temp_fields" => [
                    "add" => [

                    ],
                    "cut" => [

                    ]
                ],
                "group" => [

                ],
                "sort" => [

                ],
                "request" => [
                    [
                        "field" => "project_id",
                        "value" => "1",
                        "condition" => "EQ",
                        "module_code" => "shot",
                        "table" => "Entity"
                    ],
                    [
                        "field" => "module_id",
                        "value" => "57",
                        "condition" => "EQ",
                        "module_code" => "shot",
                        "table" => "Entity"
                    ]
                ],
                "filter_panel" => [
                ]
            ],
            "page" => "project_shot",
            "schema_page" => "project_shot",
            "module_id" => "57",
            "module_code" => "shot",
            "project_id" => "1"
        ];
        // 处理参数-将分页参数组装到pagination里面
        $entityService = new EntityService();
        $resData = $entityService->getEntityGridData($param);
        dump($resData);
        // return json($resData);
    }

    /**
     *
     */
    public function getFileGridData()
    {
        $param = [
            "filter" => [
                "temp_fields" => [
                    "add" => [

                    ],
                    "cut" => [

                    ]
                ],
                "group" => [

                ],
                "sort" => [

                ],
                "request" => [
                    [
                        "field" => "project_id",
                        "value" => "1",
                        "condition" => "EQ",
                        "module_code" => "file",
                        "table" => "File"
                    ]
                ]
            ],
            "page" => "project_file",
            "schema_page" => "project_file",
            "module_id" => "24",
            "module_code" => "file",
            "project_id" => "1"
        ];
        // 处理参数-将分页参数组装到pagination里面
        $baseService = new FileService();
        $resData = $baseService->getFileGridData($param);
        dump($resData);
        //  return json($resData);
    }


    /**
     * 生成api关联结构
     */
    public function generateModuleRelation()
    {
        $param = [
            "filter" => [
                "sort" => [],
                "request" => [
                    [
                        'field' => 'project_id',
                        'value' => '1',
                        'condition' => 'EQ',
                        'module_code' => 'shot',
                        'table' => 'Shot'
                    ],
                ],
                "filter_input" => [
                    [
                        "field" => "name",
                        "value" => "asset1",
                        "condition" => "EQ",
                        "module_code" => "asset",
                        "table" => "Entity",
                        "field_type" => "horizontal_relationship",
                        "variable_id" => 4,
                        "editor" => "combobox"
                    ]
                ],
                "filter_panel" => [

                ],
                "filter_advance" => [

                ]
            ],
            "master" => [
                "module_code" => "shot",
                "fields" => "id,name,code,asset",
                "pagination" => [
                    "page_size" => 100,
                    "page_number" => 1
                ],
            ],
            "relation" => [
                [
                    "module_code" => "status",
                    "fields" => "name",
                ],
                [
                    "module_code" => "tag_link",
                    "fields" => "id",
                ]
            ],
            "project_id" => 1
        ];
        $schemaService = new SchemaService();
        $schemaFields = $schemaService->generateModuleRelation($param);
        $baseModel = new EntityModel();
        $resData = $baseModel->getRelationData($schemaFields, "api");
        dump($resData);
    }

    /**
     * 获取关联结构数据
     */
    public function getModuleRelationData()
    {
        $param = [
            'schema_id' => 5
        ];
        $schemaService = new SchemaService();
        $resData = $schemaService->getModuleRelationData($param);
        dump($resData);
    }

    /**
     * 保存水平关联结构配置
     * @throws \Exception
     */
    public function saveHorizontalConfig()
    {
        $entityParam = [
            'base_id' => 1,
            'entity_param' => [
                'project_id' => 1
            ]
        ];
        $fileService = new FileService();
        $baseData = $fileService->getReviewTaskTimeLineData($entityParam);
        $resData = $this->getFileCommitHorizontal($baseData["rows"], $entityParam);
    }

    /**
     * 保存关联配置
     * @param $fileCommitData
     * @param $param
     * @return array
     */
    public function getFileCommitHorizontal($fileCommitData, $param)
    {
        $fileCommitModel = new FileCommitModel();
        $horizontalConfigModel = new HorizontalConfigModel();
        // 获取所有当前项目下的file_commit
        $fileCommitAllData = $fileCommitModel->selectData([
            "filter" => ["project_id" => $param["entity_param"]["project_id"]],
            "fields" => "id,project_id,module_id,link_id"
        ]);

        // 根据baseId 获取entityID
        $baseModel = new BaseModel();
        $entityId = $baseModel->where(["id" => $param["base_id"]])->getField("entity_id");
        // 获取review 实体ModuleId
        $entityModel = new EntityModel();
        $reviewModuleId = $entityModel->where(["id" => $entityId])->getField("module_id");

        // 比对数据 将相同的数据 放到新数组中
        $taskHorizontalData = [];
        foreach ($fileCommitAllData["rows"] as $dataAllItem) {
            foreach ($fileCommitData as $dataTaskItem) {
                if ($dataTaskItem["file_commit_id"] == $dataAllItem["id"]) {
                    array_push($taskHorizontalData, $dataAllItem);
                }
            }
        }

        $resData = [];

        $horizontalService = new HorizontalService();

        // 处理数据保存
        foreach ($taskHorizontalData as $item) {
            if ($item["module_id"] > 0) {
                $horizontalConfigData = $horizontalConfigModel->findData([
                    "filter" => ["src_module_id" => $reviewModuleId, "dst_module_id" => $item["module_id"]],
                ]);

                if (empty($horizontalConfigData)) {
                    $saveHorizontalConfig = [
                        'src_module_id' => $reviewModuleId,
                        'dst_module_id' => $item["module_id"],
                        'project_id' => $param["entity_param"]["project_id"]
                    ];
                    $horizontalService->saveHorizontalConfig($saveHorizontalConfig);
                }

                $saveHorizontal = [
                    'src_link_id' => $entityId,
                    'src_module_id' => $reviewModuleId,
                    'dst_link_id' => $item["link_id"],
                    'dst_module_id' => $item["module_id"],
                ];
                $resData = $horizontalService->saveHorizontal($saveHorizontal);
            }
        }

        return success_response($horizontalConfigModel->getSuccessMassege(), $resData);
    }

    /**
     * 测试删除
     */
    public function deleteModuleRelation()
    {
        $param = [
            "schema_id" => 1
        ];
        $moduleRelationModel = new ModuleRelationModel();
        $resData = $moduleRelationModel->deleteItem($param);
        dump($resData);
    }

    /**
     * 保存module信息
     * @return \Think\Response
     * @throws \Exception
     */
    public function generateEntityRelation()
    {
        $schemaService = new SchemaService();

        // 保存module信息
        $moduleData = [
            [
                "name" => "集数",
                "code" => "episode"
            ],
            [
                "name" => "序列",
                "code" => "sequence"
            ],
            [
                "name" => "镜头",
                "code" => "shot"
            ],
            [
                "name" => "前期制作",
                "code" => "pre_production"
            ],
            [
                "name" => "资产",
                "code" => "asset"
            ],
            [
                "name" => "资产类型",
                "code" => "asset_type"
            ]
        ];
        $resData = $schemaService->saveEntityModuleData($moduleData);

        // 保存schema关联结构信息
        $systemRelation = [
            [
                "name" => "集数模型",
                "code" => "episode",
                "type" => "system",
                "relation_data" => [
                    "episode" => [
                        [
                            "code" => "sequence",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "序列模型",
                "code" => "sequence",
                "type" => "system",
                "relation_data" => [
                    "sequence" => [
                        [
                            "code" => "shot",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "episode",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "镜头模型",
                "code" => "shot",
                "type" => "system",
                "relation_data" => [
                    "shot" => [
                        [
                            "code" => "sequence",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "前期制作模型",
                "code" => "pre_production",
                "type" => "system",
                "relation_data" => [
                    "pre_production" => [
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "资产模型",
                "code" => "asset",
                "type" => "system",
                "relation_data" => [
                    "asset" => [
                        [
                            "code" => "asset_type",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "资产类型模型",
                "code" => "asset_type",
                "type" => "system",
                "relation_data" => [
                    "asset_type" => [
                        [
                            "code" => "asset",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "project",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "status",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "media",
                            "mapping_type" => "has_one"
                        ],
                        [
                            "code" => "module",
                            "mapping_type" => "belong_to"
                        ],
                        [
                            "code" => "tag_link",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ],
            [
                "name" => "动画",
                "code" => "animation",
                "type" => "project",
                "relation_data" => [
                    "project" => [
                        [
                            "code" => "episode",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "pre_production",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "asset_type",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "review",
                            "mapping_type" => "has_many"
                        ]
                    ],
                    "episode" => [
                        [
                            "code" => "sequence",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "sequence" => [
                        [
                            "code" => "shot",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "shot" => [
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "pre_production" => [
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "asset" => [
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "asset_type" => [
                        [
                            "code" => "asset",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "review" => [
                        [
                            "code" => "base",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "horizontal",
                            "mapping_type" => "many_to_many"
                        ]
                    ],
                    "status" => [
                        [
                            "code" => "base",
                            "mapping_type" => "has_one"
                        ]
                    ],
                    "base" => [
                        [
                            "code" => "step",
                            "mapping_type" => "has_many"
                        ],
                        [
                            "code" => "variable",
                            "mapping_type" => "has_many"
                        ]
                    ],
                    "variable" => [
                        [
                            "code" => "variable_value",
                            "mapping_type" => "has_many"
                        ]
                    ]
                ]
            ]
        ];
        $schemaService->saveSchemaModuleRelation($systemRelation);
        return json($resData);
    }

    /**
     * 保存module信息
     * @return \Think\Response
     * @throws \Exception
     */
    public function saveModuleData()
    {
        $schemaService = new SchemaService();

        // 保存module信息
        $moduleData = [
            [
                "name" => "集数",
                "code" => "episode"
            ],
            [
                "name" => "序列",
                "code" => "sequence"
            ],
            [
                "name" => "镜头",
                "code" => "shot"
            ],
            [
                "name" => "前期制作",
                "code" => "pre_production"
            ],
            [
                "name" => "资产",
                "code" => "asset"
            ],
            [
                "name" => "资产类型",
                "code" => "asset_type"
            ],
            [
                "name" => "审核",
                "code" => "review"
            ]
        ];
        $resData = $schemaService->saveEntityModuleData($moduleData);
        return json($resData);
    }
}