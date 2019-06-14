<?php

namespace Test\Controller;

use Common\Service\ExportExcelService;
use Common\Service\ImportExcelService;
use Common\Service\UploadService;

class ExcelController
{

    /**
     * 导入excel测试
     * @return \Think\Response
     */
    public function importExcel()
    {
        $param = [
            "param" => [
                "page" => "details_base",
                "schema_page" => "project_base",
                "module_id" => "4",
                "grid" => "single_main_datagrid_box",
                "project_id" => "2",
                "main_dom" => "single_datagrid_main",
                "bar_dom" => "single_filter_main",
                "batch_number" => "29015",
                "from_module_data" => [
                    "item_id" => "16",
                    "module_id" => "57",
                    "module_code" => "shot"
                ]
            ],
            "field_mapping" => [
                "name" => "name",
                "code" => "code"
            ],
            "grid_data" => [
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_temp361828ec.jpg",
                    "id" => "4539",
                    "name" => "gn",
                    "code" => "h",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "Not started",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "1",
                    "framerange" => "",
                    "created_by" => "孟书 吕(Lookdev)",
                    "created" => "2018-06-01"
                ],
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_tempf93cf185.jpg",
                    "id" => "4538",
                    "name" => "测试",
                    "code" => "xcxZ",
                    "project" => "Strack帮助测试项目",
                    "category" => "Character",
                    "status" => "Waiting to Start",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "0",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-28"
                ],
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_temp3069a21f.jpg",
                    "id" => "4521",
                    "name" => "沙发",
                    "code" => "sofa",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "In progress",
                    "description" => "d",
                    "resolution" => "",
                    "rate" => "0",
                    "framerange" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_temp51f2578b.jpg",
                    "created_by" => "冉 朱(制片)",
                    "created" => "2018-05-17"
                ],
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_temp79aea40e.jpg",
                    "id" => "4512",
                    "name" => "男主",
                    "code" => "Hero",
                    "project" => "Strack帮助测试项目",
                    "category" => "Character",
                    "status" => "In progress",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "0",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ],
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_tempda634424.jpg",
                    "id" => "4511",
                    "name" => "盒子",
                    "code" => "box",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "Delivered",
                    "description" => "这是一个木质的盒子。",
                    "resolution" => "1920×1080",
                    "rate" => "24",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ],
                [
                    "222" => "/Uploads/temp/excel/excel_29015//excel_images/excel_image_temp39b2898d.jpg",
                    "id" => "4508",
                    "name" => "圆球",
                    "code" => "ball",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "In progress",
                    "description" => "null ",
                    "resolution" => "",
                    "rate" => "0",
                    "framerange" => "920-1500",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ]
            ]
        ];

        $importExcelService = new ImportExcelService();
        $data = $importExcelService->importExcelData($param);
        return json($data);
    }

    /**
     * 导入Excel
     * @throws \Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function import()
    {
        $importService = new ImportExcelService();

        $path = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/APP/Test/files/' . "strack.xlsx";


//
//            $pasteData = [
//                [
//                    "bgc",
//                    "colspan",
//                    "fname",
//                    "",
//                    "",
//                    "fields",
//                ],
//                [
//                    "bgc",
//                    "colspan",
//                    "fname",
//                    "23333333333",
//                    "fields",
//                    "fields",
//                ],
//                [
//                    "bgc",
//                    "colspan",
//                    "fname",
//                    "fields",
//                    "fields",
//                    "fields",
//                ]
//            ];
//            $importService->paste($pasteData);
        $tempExcelPath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Uploads/temp/';
        $importService->file($path, $tempExcelPath);
        $importService->setHeaderStatus(true);
        $header = $importService->getHeader();
        $body = $importService->getBody();
        dump("----header----");
        dump($header);
        dump("----body----");
        dump($body);

    }

    /**
     * 粘贴csv数据
     */
    public function paste()
    {

    }


    /**
     * 复杂表头导出数据
     * @throws \Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function complexExport()
    {
        $header = [
            "0" => [
                "0" => [
                    "bgc" => "",
                    "but" => "",
                    "class" => "",
                    "colspan" => 8,
                    "fhcol" => true,
                    "fname" => "",
                    "step" => "no",
                    "title" => "",
                ],
                "1" => [
                    "bgc" => "00E6FE",
                    "but" => "lookdev",
                    "class" => "lookdev_h",
                    "colspan" => 1,
                    "fhcol" => true,
                    "fname" => "lookdev",
                    "step" => "yes",
                    "title" => "Lookdev",
                    "first_field" => "name",
                    "field_list" => "code,status_id",
                ],
                "2" => [
                    "bgc" => "FE5CFF",
                    "but" => "rig",
                    "class" => "rig_h",
                    "colspan" => 1,
                    "fhcol" => true,
                    "fname" => "rig",
                    "step" => "yes",
                    "title" => "Rig",
                    "first_field" => "name",
                    "field_list" => "code,status_id",
                ],
                "3" => [
                    "bgc" => "d526de",
                    "but" => "mp",
                    "class" => "mp_h",
                    "colspan" => 1,
                    "fhcol" => true,
                    "fname" => "mp",
                    "step" => "yes",
                    "title" => "MP",
                    "first_field" => "name",
                    "field_list" => "code,status_id",
                ],
            ],
            "1" => [
                "0" => [
                    "field" => "entity_id",
                    "title" => "编号",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 0,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_id",
                ],
                "1" => [
                    "field" => "entity_name",
                    "title" => "名称",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 1,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "  ''",
                    "sortable" => false,
                    "editor" => [
                        "type" => "text"
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_name",
                ],
                "2" => [
                    "field" => "entity_code",
                    "title" => "编码",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 2,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "editor" => [
                        "type" => "text"
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_code",
                ],
                "3" => [
                    "field" => "entity_project_id",
                    "title" => "项目",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 3,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "project",
                    "flg_module" => "project",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_project_id",
                ],
                "4" => [
                    "field" => "entity_module_id",
                    "title" => "模块",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 4,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "module",
                    "flg_module" => "module",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_module_id",
                ],
                "5" => [
                    "field" => "entity_status_id",
                    "title" => "状态",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 5,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "status",
                    "flg_module" => "status",
                    "sortable" => false,
                    "editor" => [
                        "type" => "combobox",
                        "options" => [
                            "height" => 31,
                            "valueField" => "id",
                            "textField" => "name",
                            "method" => "post",
                            "url" => "/strack/Home/Widget/getWidgetData.html",
                            "queryParams" => [
                                "primary" => 0,
                                "project_id" => "1",
                                "module" => "entity",
                                "field_type" => "built_in",
                                "fields" => "entity_status_id",
                                "variable_id" => 0,
                                "frozen_module" => "episode",
                                "flg_module" => "status",
                                "module_id" => "51",
                            ],
                        ],
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_status_id",
                ],
                "6" => [
                    "field" => "entity_start_time",
                    "title" => "开始时间",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 6,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_start_time",
                ],
                "7" => [
                    "field" => "entity_end_time",
                    "title" => "结束时间",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 7,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "entity",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-entity_end_time",
                ],
                "8" => [
                    "field" => "lookdev_name",
                    "title" => "名称",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 8,
                    "hidden" => false,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "first",
                    "belong" => "lookdev",
                    "bdc" => "00E6FE",
                    "cbd" => "colboth",
                    "cellClass" => "datagrid-cell-c1-lookdev_name",
                    "deltaWidth" => 1,
                    "boxWidth" => 159,
                ],
                "9" => [
                    "field" => "lookdev_code",
                    "title" => "编码",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 9,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "",
                    "belong" => "lookdev",
                    "boxWidth" => 159,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-lookdev_code",
                ],
                "10" => [
                    "field" => "lookdev_status_id",
                    "title" => "状态编号",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 10,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "last",
                    "belong" => "lookdev",
                    "bdc" => "00E6FE",
                    "cbd" => "colright",
                    "cellClass" => "datagrid-cell-c1-lookdev_status_id",
                    "deltaWidth" => 1,
                    "boxWidth" => 159,
                ],
                "11" => [
                    "field" => "rig_name",
                    "title" => "名称",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 11,
                    "hidden" => false,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "first",
                    "belong" => "rig",
                    "bdc" => "FE5CFF",
                    "cbd" => "colboth",
                    "cellClass" => "datagrid-cell-c1-rig_name",
                    "deltaWidth" => 1,
                    "boxWidth" => 159,
                ],
                "12" => [
                    "field" => "rig_code",
                    "title" => "编码",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 12,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "",
                    "belong" => "rig",
                    "boxWidth" => 159,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-rig_code",
                ],
                "13" => [
                    "field" => "rig_status_id",
                    "title" => "状态编号",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 13,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "last",
                    "belong" => "rig",
                    "bdc" => "FE5CFF",
                    "cbd" => "colright",
                    "cellClass" => "datagrid-cell-c1-rig_status_id",
                    "deltaWidth" => "",
                    "boxWidth" => 159,
                ],
                "14" => [
                    "field" => "mp_name",
                    "title" => "名称",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 14,
                    "hidden" => false,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "first",
                    "belong" => "mp",
                    "bdc" => "d526de",
                    "cbd" => "colboth",
                    "cellClass" => "datagrid-cell-c1-mp_name",
                    "deltaWidth" => 1,
                    "boxWidth" => 159,
                ],
                "15" => [
                    "field" => "mp_code",
                    "title" => "编码",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 15,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "",
                    "belong" => "mp",
                    "boxWidth" => 159,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-mp_code",
                ],
                "16" => [
                    "field" => "mp_status_id",
                    "title" => "状态编号",
                    "align" => "center",
                    "width" => 160,
                    "findex" => 16,
                    "hidden" => true,
                    "drag" => false,
                    "step" => true,
                    "step_index" => "last",
                    "belong" => "mp",
                    "bdc" => "d526de",
                    "cbd" => "colright",
                    "cellClass" => "datagrid-cell-c1-mp_status_id",
                    "deltaWidth" => 1,
                    "boxWidth" => 159,
                ],
            ],
        ];

//   "-0----------------------"

        $data = [
            "0" => [
                "entity_id" => "1",
                "entity_name" => "测试1",
                "entity_code" => "test1",
                "entity_project_id" => "test",
                "entity_module_id" => "集°",
                "entity_status_id" => "Not started",
                "entity_start_time" => "0",
                "entity_end_time" => "0",
                "status_id" => "Not started",
                "status_name" => "Not started",
                "status_code" => "not_started",
                "status_color" => "cccccc",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "test",
                "project_name" => "test",
                "project_code" => "test",
                "project_status_id" => "2",
                "project_rate" => "3",
                "project_description" => "",
                "project_start_time" => "1534262400",
                "project_end_time" => "1535558400",
                "project_thumb" => "",
                "project_created_by" => "1",
                "project_created" => "1534406912",
                "id" => "1",
                "mp_status_id" => [
                    "0" => [
                        "base_id" => "1"
                    ]
                ],
                "previz_name" => [
                    "0" => [
                        "base_id" => "1",
                        "base_name" => "test",
                    ]
                ],
                "previz_code" => [
                    "0" => [
                        "base_id" => "1",
                        "base_code" => "test",
                    ],
                ],
                "previz_project_id" => [
                    "0" => [
                        "base_id" => "1",
                        "base_project_id" => "1",
                    ]
                ],
                "previz_entity_id" => [
                    "0" => [
                        "base_id" => "1",
                        "base_entity_id" => "1",
                    ]
                ],
                "previz_status_id" => [
                    "0" => [
                        "base_id" => "1",
                        "base_status_id" => "5",
                    ],
                ],
                "previz_step_id" => [
                    "0" => [
                        "base_id" => "1",
                        "base_step_id" => "2",
                    ]
                ],
                "lookdev_name" => [
                    "0" => [
                        "base_id" => "1",
                        "base_priority" => "normal",
                    ],
                ],
            ],
            "1" => [
                "entity_id" => "2",
                "entity_name" => "æµè¯2",
                "entity_code" => "test2",
                "entity_project_id" => "test",
                "entity_module_id" => "éæ°",
                "entity_status_id" => "Waiting to Start",
                "entity_start_time" => "0",
                "entity_end_time" => "0",
                "status_id" => "Waiting to Start",
                "status_name" => "Waiting to Start",
                "status_code" => "waiting_to_start",
                "status_color" => "c6c6c6",
                "status_icon" => "icon-uniF068",
                "status_correspond" => "not_started",
                "project_id" => "test",
                "project_name" => "test",
                "project_code" => "test",
                "project_status_id" => "2",
                "project_rate" => "3",
                "project_description" => "",
                "project_start_time" => "1534262400",
                "project_end_time" => "1535558400",
                "project_thumb" => "",
                "project_created_by" => "1",
                "project_created" => "1534406912",
                "id" => "2",
                "entity_base" => [
                ]
            ],
            "2" => [
                "entity_id" => "3",
                "entity_name" => "æµè¯3",
                "entity_code" => "test3",
                "entity_project_id" => "test",
                "entity_module_id" => "éæ°",
                "entity_status_id" => "Ready to Start",
                "entity_start_time" => "0",
                "entity_end_time" => "0",
                "status_id" => "Ready to Start",
                "status_name" => "Ready to Start",
                "status_code" => "ready_to_start",
                "status_color" => "e7c025",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "test",
                "project_name" => "test",
                "project_code" => "test",
                "project_status_id" => "2",
                "project_rate" => "3",
                "project_description" => "",
                "project_start_time" => "1534262400",
                "project_end_time" => "1535558400",
                "project_thumb" => "",
                "project_created_by" => "1",
                "project_created" => "1534406912",
                "id" => "3",
                "entity_base" => [
                ],
            ],
        ];
        $data1 = [
            [
                "entity_id" => 1,
                "entity_name" => "集数1",
                "entity_code" => "jishu1",
                "entity_project_id" => "vvv",
                "entity_module_id" => "集数",
                "entity_status_id" => "Not started",
                "entity_start_time" => 0,
                "entity_end_time" => 0,
                "status_id" => "Not started",
                "status_name" => "Not started",
                "status_code" => "not_started",
                "status_color" => "cccccc",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "vvv",
                "project_name" => "vvv",
                "project_code" => "vvv",
                "project_status_id" => 7,
                "project_rate" => "1",
                "project_description" => "",
                "project_start_time" => 1536681600,
                "project_end_time" => 1537977600,
                "project_thumb" => "",
                "project_created_by" => 1,
                "project_created" => 1536721022,
                "id" => 1,
                "lookdev_id" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_id",
                                "value" => 1
                            ]
                        ]
                    ],

                "lookdev_name" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ],
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ]
                    ],
                "lookdev_code" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1
                            ],


                            "fields" => [
                                "field" => "base_code",
                                "value" => "test_base",
                            ]
                        ]
                    ]
            ],
            [
                "entity_id" => 1,
                "entity_name" => "集数1",
                "entity_code" => "jishu1",
                "entity_project_id" => "vvv",
                "entity_module_id" => "集数",
                "entity_status_id" => "Not started",
                "entity_start_time" => 0,
                "entity_end_time" => 0,
                "status_id" => "Not started",
                "status_name" => "Not started",
                "status_code" => "not_started",
                "status_color" => "cccccc",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "vvv",
                "project_name" => "vvv",
                "project_code" => "vvv",
                "project_status_id" => 7,
                "project_rate" => "1",
                "project_description" => "",
                "project_start_time" => 1536681600,
                "project_end_time" => 1537977600,
                "project_thumb" => "",
                "project_created_by" => 1,
                "project_created" => 1536721022,
                "id" => 1,
                "lookdev_id" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_id",
                                "value" => 1
                            ]
                        ]
                    ],

                "lookdev_name" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ],
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ]
                    ],
                "lookdev_code" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1
                            ],


                            "fields" => [
                                "field" => "base_code",
                                "value" => "test_base",
                            ]
                        ]
                    ]
            ],
            [
                "entity_id" => 1,
                "entity_name" => "集数1",
                "entity_code" => "jishu1",
                "entity_project_id" => "vvv",
                "entity_module_id" => "集数",
                "entity_status_id" => "Not started",
                "entity_start_time" => 0,
                "entity_end_time" => 0,
                "status_id" => "Not started",
                "status_name" => "Not started",
                "status_code" => "not_started",
                "status_color" => "cccccc",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "vvv",
                "project_name" => "vvv",
                "project_code" => "vvv",
                "project_status_id" => 7,
                "project_rate" => "1",
                "project_description" => "",
                "project_start_time" => 1536681600,
                "project_end_time" => 1537977600,
                "project_thumb" => "",
                "project_created_by" => 1,
                "project_created" => 1536721022,
                "id" => 1,
                "lookdev_id" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_id",
                                "value" => 1
                            ]
                        ]
                    ],

                "lookdev_name" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ],
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ]
                    ],
                "lookdev_code" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1
                            ],


                            "fields" => [
                                "field" => "base_code",
                                "value" => "test_base",
                            ]
                        ]
                    ]
            ],
            [
                "entity_id" => 1,
                "entity_name" => "集数1",
                "entity_code" => "jishu1",
                "entity_project_id" => "vvv",
                "entity_module_id" => "集数",
                "entity_status_id" => "Not started",
                "entity_start_time" => 0,
                "entity_end_time" => 0,
                "status_id" => "Not started",
                "status_name" => "Not started",
                "status_code" => "not_started",
                "status_color" => "cccccc",
                "status_icon" => "icon-uniEA7E",
                "status_correspond" => "not_started",
                "project_id" => "vvv",
                "project_name" => "vvv",
                "project_code" => "vvv",
                "project_status_id" => 7,
                "project_rate" => "1",
                "project_description" => "",
                "project_start_time" => 1536681600,
                "project_end_time" => 1537977600,
                "project_thumb" => "",
                "project_created_by" => 1,
                "project_created" => 1536721022,
                "id" => 1,
                "lookdev_id" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_id",
                                "value" => 1
                            ]
                        ]
                    ],

                "lookdev_name" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ],
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1,
                            ],

                            "fields" => [
                                "field" => "base_name",
                                "value" => "测试任务",

                            ]
                        ]
                    ],
                "lookdev_code" =>
                    [
                        [
                            "primary" => [
                                "field" => "base_id",
                                "value" => 1
                            ],


                            "fields" => [
                                "field" => "base_code",
                                "value" => "test_base",
                            ]
                        ]
                    ]
            ]

        ];

        $exportService = new ExportExcelService();
        $savePath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Uploads/temp/';
        //格式化数据
        $data = $exportService->generateExcel("sss", $header, $data1, $savePath);
//        $body = $exportService->generateExcel($data);
//        $exportService->generateHeader();
//        $exportService->generateBody();
//        $data = $exportService->save();
        dump($data);
    }

    /**
     * 简单数据导出数据
     */
    public function simpleExport()
    {
        $header = [
            "0" => [
                "0" => [
                    "field" => "base_id",
                    "title" => "编号",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 0,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_id",
                ],
                "1" => [
                    "field" => "base_name",
                    "title" => "名称",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 1,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => " 
",
                    "sortable" => true,
                    "editor" => [
                        "type" => "text"
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_name",
                ],
                "2" => [
                    "field" => "base_code",
                    "title" => "编码",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 2,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => true,
                    "editor" => [
                        "type" => "text",
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_code",
                ],
                "3" => [
                    "field" => "base_project_id",
                    "title" => "项目",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 3,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "project",
                    "flg_module" => "project",
                    "sortable" => false,
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_project_id",
                ],
                "4" => [
                    "field" => "base_entity_id",
                    "title" => "实体",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 4,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "entity",
                    "flg_module" => "entity",
                    "sortable" => false,
                    "editor" => [
                        "type" => "combobox",
                        "options" => [
                            "height" => 31,
                            "valueField" => "id",
                            "textField" => "name",
                            "method" => "post",
                            "url" => "/strack/Home/Widget/getWidgetData.html",
                            "queryParams" => [
                                "primary" => 0,
                                "project_id" => "1",
                                "module" => "base",
                                "field_type" => "built_in",
                                "fields" => "base_entity_id",
                                "variable_id" => 0,
                                "frozen_module" => "base",
                                "flg_module" => "entity",
                                "module_id" => "4",
                            ],
                        ],
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_entity_id",
                ],
                "5" => [
                    "field" => "base_status_id",
                    "title" => "状态",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 5,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "status",
                    "flg_module" => "status",
                    "sortable" => false,
                    "editor" => [
                        "type" => "combobox",
                        "options" => [
                            "height" => 31,
                            "valueField" => "id",
                            "textField" => "name",
                            "method" => "post",
                            "url" => "/strack/Home/Widget/getWidgetData.html",
                            "queryParams" => [
                                "primary" => 0,
                                "project_id" => "1",
                                "module" => "base",
                                "field_type" => "built_in",
                                "fields" => "base_status_id",
                                "variable_id" => 0,
                                "frozen_module" => "base",
                                "flg_module" => "status",
                                "module_id" => "4",
                            ],
                        ],
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_status_id",
                ],
                "6" => [
                    "field" => "base_step_id",
                    "title" => "工序",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 6,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "frozen_module" => "step",
                    "flg_module" => "step",
                    "sortable" => false,
                    "editor" => [
                        "type" => "combobox",
                        "options" => [
                            "height" => 31,
                            "valueField" => "id",
                            "textField" => "name",
                            "method" => "post",
                            "url" => "/strack/Home/Widget/getWidgetData.html",
                            "queryParams" => [
                                "primary" => 0,
                                "project_id" => "1",
                                "module" => "base",
                                "field_type" => "built_in",
                                "fields" => "base_step_id",
                                "variable_id" => 0,
                                "frozen_module" => "base",
                                "flg_module" => "step",
                                "module_id" => "4",
                            ],
                        ],
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_step_id",
                ],
                "7" => [
                    "field" => "base_priority",
                    "title" => "优先级",
                    "align" => "center",
                    "width" => 120,
                    "frozen" => "frozen",
                    "findex" => 7,
                    "field_type" => "built_in",
                    "group" => "",
                    "module" => "base",
                    "variable_id" => 0,
                    "drag" => true,
                    "outreach_formatter" => "",
                    "sortable" => false,
                    "editor" => [
                        "type" => "combobox",
                        "options" => [
                            "height" => 31,
                            "valueField" => "id",
                            "textField" => "name",
                            "method" => "post",
                            "url" => "/strack/Home/Widget/getWidgetData.html",
                            "queryParams" => [
                                "primary" => 0,
                                "project_id" => "1",
                                "module" => "base",
                                "field_type" => "built_in",
                                "fields" => "base_priority",
                                "variable_id" => 0,
                                "frozen_module" => "base",
                                "module_id" => "4",
                            ],
                        ],
                    ],
                    "boxWidth" => 119,
                    "deltaWidth" => 1,
                    "cellClass" => "datagrid-cell-c1-base_priority",
                ],
            ],
        ];
        $data = [
            "0" => [
                "base_id" => "1",
                "base_name" => "test",
                "base_code" => "test",
                "base_project_id" => "test",
                "base_entity_id" => "测试1",
                "base_status_id" => "Normal",
                "base_step_id" => "Previz",
                "base_priority" => "正常",
                "step_id" => "Previz",
                "step_name" => "Previz",
                "step_code" => "previz",
                "step_color" => "ffbf36",
                "status_id" => "Normal",
                "status_name" => "Normal",
                "status_code" => "normal",
                "status_color" => "10a0e8",
                "status_icon" => "icon-uniEAB1",
                "status_correspond" => "in_progress",
                "project_id" => "test",
                "project_name" => "test",
                "project_code" => "test",
                "project_status_id" => "2",
                "project_rate" => "3",
                "project_description" => "",
                "project_start_time" => "1534262400",
                "project_end_time" => "1535558400",
                "project_thumb" => "",
                "project_created_by" => "1",
                "project_created" => "1534406912",
                "id" => "1",
                "base_member" => [
                ],
            ],
            "1" => [
                "base_id" => "1",
                "base_name" => "test",
                "base_code" => "test",
                "base_project_id" => "test",
                "base_entity_id" => "测试1",
                "base_status_id" => "Normal",
                "base_step_id" => "Previz",
                "base_priority" => "正常",
                "step_id" => "Previz",
                "step_name" => "Previz",
                "step_code" => "previz",
                "step_color" => "ffbf36",
                "status_id" => "Normal",
                "status_name" => "Normal",
                "status_code" => "normal",
                "status_color" => "10a0e8",
                "status_icon" => "icon-uniEAB1",
                "status_correspond" => "in_progress",
                "project_id" => "test",
                "project_name" => "test",
                "project_code" => "test",
                "project_status_id" => "2",
                "project_rate" => "3",
                "project_description" => "",
                "project_start_time" => "1534262400",
                "project_end_time" => "1535558400",
                "project_thumb" => "",
                "project_created_by" => "1",
                "project_created" => "1534406912",
                "id" => "1",
                "base_member" => [
                ],
            ],
        ];
        $exportService = new ExportExcelService();
        $exportService->data("sss", $header, $data);
        $body = $exportService->formatBodyData($data);
        $exportService->generateHeader();
        $exportService->generateBody();
        $data = $exportService->save();
        dump($data);
    }

    /**
     * 导入excel保存数据测试
     * @throws \Exception
     */
    public function importExcelData()
    {
        $param = [
            "param" => [
                "page" => "project_base",
                "module_id" => "4",
                "project_id" => "1",
                "main_dom" => "grid_datagrid_main",
                "bar_dom" => "grid_filter_main",
                "batch_number" => "50711",
            ],
            "field_mapping" => [
                "name" => "name",
                "code" => "code",
                "status_id" => "status",
                "path" => "222"
            ],
            "grid_data" => [
                [
                    "222" => "/excel_images/excel_image_tempa62c381f.jpg",
                    "id" => "4539",
                    "name" => "gn",
                    "code" => "h",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "Not started",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "1",
                    "framerange" => "",
                    "created_by" => "孟书 吕(Lookdev)",
                    "created" => "2018-06-01"
                ],
                [
                    "222" => "/excel_images/excel_image_temp32a61bb4.jpg",
                    "id" => "4538",
                    "name" => "",
                    "code" => "xcxZ",
                    "project" => "Strack帮助测试项目",
                    "category" => "Character",
                    "status" => "Waiting to Start",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-28",
                ],
                [
                    "222" => "/excel_images/excel_image_temp8c4970d0.jpg",
                    "id" => "4521",
                    "name" => "沙发",
                    "code" => "sofa",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "In progress",
                    "description" => "d",
                    "resolution" => "",
                    "rate" => "",
                    "framerange" => "/excel_images/excel_image_tempb9b1bba8.jpg",
                    "created_by" => "冉 朱(制片)",
                    "created" => "2018-05-17"
                ],
                [
                    "222" => "/excel_images/excel_image_temp6e04cf18.jpg",
                    "id" => "4512",
                    "name" => "男主",
                    "code" => "Hero",
                    "project" => "Strack帮助测试项目",
                    "category" => "Character",
                    "status" => "In progress",
                    "description" => "",
                    "resolution" => "",
                    "rate" => "",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ],
                [
                    "222" => "/excel_images/excel_image_tempbca5d950.jpg",
                    "id" => "4511",
                    "name" => "盒子",
                    "code" => "box",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "Delivered",
                    "description" => "这是一个木质的盒子。",
                    "resolution" => "1920x1080",
                    "rate" => "24",
                    "framerange" => "",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ],
                [
                    "222" => "/excel_images/excel_image_tempf7833973.jpg",
                    "id" => "4508",
                    "name" => "圆球",
                    "code" => "ball",
                    "project" => "Strack帮助测试项目",
                    "category" => "Prop",
                    "status" => "In progress",
                    "description" => "null",
                    "resolution" => "",
                    "rate" => "24",
                    "framerange" => "920-1500",
                    "created_by" => "帅 杨( producer)",
                    "created" => "2018-05-09"
                ]
            ],

        ];
        $importService = new ImportExcelService();
        $resData = $importService->importExcelData($param);
        dump($resData);
    }
}