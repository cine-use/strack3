<?php

namespace Test\Controller;


use Common\Service\MediaService;
use Think\Controller;

class MediaController extends Controller
{
    public function getServerStatus()
    {
        $mediaService = new MediaService();
        $mediaService->getMediaServerStatus();
    }

    /**
     * 获取媒体数据
     */
    public function getMedia()
    {
        $filter = [
            "md5_name" => "1539351262AJtMb2qy"
        ];
        $mediaService = new MediaService();
        $meidaData = $mediaService->getMediaData($filter);
        dump($meidaData);
    }

    public function testUploadFile()
    {
        $mediaService = new MediaService();
        $file = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/Uploads/temp/excel/excel_82180//excel_images/excel_image_temp953f9271.jpg';
        $mediaService->uploadMedia($file);
    }

    public function savePlaylist()
    {
        $param = [
            // 保存entity
            'entity_data' => [
                'name' => 'test',
                'code' => 'test',
                'status_id' => 19,
            ],
            'entity_id' => 0,
            // 保存review_link
            'file_commit_ids' => [
                [
                    'id' => 1,
                    'index' => 1,
                ],
                [
                    'id' => 2,
                    'index' => 2,
                ],
            ],
            'mode' => 'add',
            "entity_param" => [
                "module_id" => "57",
                "module_name" => "镜头",
                "project_id" => "1",
                "grid" => "main_datagrid_box",
                "page" => "project_shot",
                "type" => "add_entity_task",
                "main_dom" => "grid_datagrid_main",
                "bar_dom" => "grid_filter",
            ],
            // 保存任务
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


        $mediaService = new MediaService();
        $resData = $mediaService->savePlaylist($param);
        dump($resData);
    }
}