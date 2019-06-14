<?php

namespace Test\Controller;

use Common\Model\FieldModel;
use Common\Model\HorizontalModel;
use Common\Model\ModuleModel;
use Common\Model\UserModel;
use Think\Controller;
use Common\Service\ViewService;
use Think\Model;

class ViewController extends Controller
{


    protected function getModuleData($moduleId)
    {
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->findData(["filter" => ["id" => $moduleId], "fields" => "id as module_id,name,code,type"]);
        return $moduleData;
    }

    /**
     *
     */
    public function getViewConfig()
    {

        $fixedParam = [
            "page" => "project_base",
            "schema_page" => "project_base",
            "module_id" => 4,
            "view_type" => "grid",
            "project_id" => 1
        ];

        // 实体
        $param = [
            "page" => "project_shot",
            "schema_page" => "project_shot",
            "module_id" => 56,
            "view_type" => "grid",
            "project_id" => 1
        ];

        $viewService = new ViewService();
        $resData = $viewService->getGirdViewConfig($fixedParam);
        dump($resData);
    }

    public function getQueryConfig()
    {
        $viewService = new ViewService();
        $resData = $viewService->getQueryConfig(["module_id" => 34, "page" => "admin_account", "project_id" => 0, "view_type" => "grid", "filter" => ["fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [
            ],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance"
            => []]]);

        $userModel = new UserModel();
        $data = $userModel->getRelationData($resData);
        dump($data);
    }

    /**
     * 获取前端数据表格
     */
    public function getGridColumns()
    {
        $param = [
            "module_id" => 4, "page" => "project_base", "project_id" => 1
        ];
        $viewService = new ViewService();
        $resData = $viewService->getGirdViewConfig($param);
        dump($resData);
    }

    /**
     * 获取视图面板
     */
    public function getGridPanelData()
    {

        $viewService = new ViewService();
        $resData = $viewService->getGridPanelData([
            "page" => "project_shot",
            "schema_page" => "project_shot",
            "module_id" => 56,
            "view_type" => "grid",
            "project_id" => 1
        ]);
        dump($resData);die;
    }

    /**
     * 获取显示字段
     */
    public function getFields()
    {
        $param = [
            'page' => 'project_base',
            'schema_page' => 'project_base',
            'module_id' => 4,
            'mode' => 'create',
            'project_id' => 1,
            'field_list_type' => ['edit'],
            'type' => 'add_panel',
            'not_fields' => ["entity_id", "status_id", "thumb"],
        ];
        $viewService = new ViewService();

        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->findData(['filter' => ['id' => $param['module_id']], 'fields' => 'id,type,code']);
        $resData = $viewService->getFields($param, $moduleData["type"]);
        dump($resData);
        die;
    }

    /**
     * 获取权限字段
     */
    public function getAuthFields()
    {
        // 权限测试数据
        $authConfig = [
            'base' => [
                'name' => [
                    'show' => true,
                    'edit' => false
                ],
                'code' => [
                    'show' => true,
                    'edit' => true
                ]
            ],
            'status' => [
                'name' => [
                    'show' => true,
                    'edit' => false
                ],
                'code' => [
                    'show' => true,
                    'edit' => true
                ]
            ]
        ];
    }

    /**
     * 测试-获取权限过滤字段格式
     */
    public function getFieldCleanConfig()
    {
        [
            'sort' => [
                'sort_query' => [
                    'user.login' => 'asc',
                    'user.name' => 'desc'
                ],
                'sort_data' => [
                    'user_login' => 'asc',
                    'user_name' => 'desc'
                ],
                'sort_type' => ''
            ],
            'group' => [
                'user.login' => 'asc',
                'user_combobox_test.value' => 'desc'
            ],
            'fields' => [],
            'filter' => [

            ]
        ];

    }

    /**
     * 测试-获取导入字段
     */
    public function getImportFields()
    {
        $param = [
            "module_id" => 57,
            "project_id" => 1,
            "page" => "project_shot",
            "schema_page" => "project_shot"
        ];
        $viewService = new ViewService();
        $resData = $viewService->getImportFields($param);
        dump($resData);
    }

    /**
     * 获取默认视图参数
     */
    public function getViewDefaultParam()
    {
        $param = [
            'module_id' => 51,
            'name' => '任务',
            'code' => 'episode',
            'view_data' => [
                'fields' => [
                    [

                    ],
                    [
                        [
                            "field" => "entity_id",
                            "width" => 120,
                            "frozen_status" => false

                        ],
                        [
                            "field" => "entity_name",
                            "width" => 120,
                            "frozen_status" => false
                        ],
                        [
                            "field" => "entity_code",
                            "width" => 120,
                            "frozen_status" => false
                        ]
                    ]

                ],
                'filter' => [
                    [
                        [

                            "field" => "name",
                            "module_code" => "episode",
                            "condition" => "EQ",
                            "value" => "qqqq1",
                        ],
                        'logic' => 'and'
                    ],
                    [
                        [
                            "field" => "name",
                            "module_code" => "episode",
                            "condition" => "EQ",
                            "value" => "qqqq1",
                        ],
                        'logic' => 'and'
                    ],
                    'logic' => 'and'
                ]
            ]
        ];

        $viewService = new ViewService();
        $resData = $viewService->getViewDefaultParam($param);
        dump(json_encode($resData));
    }

    /**
     * 处理has_many查询
     */
    public function dealHasManyFilter()
    {
        $hasManyData = [
            'has_one_data' => [
                [
                    "entity_id" => 1,
                    "entity_name" => "ccc1",
                    "entity_status_id" => 2,
                    "entity_description" => NULL,
                    "entity_parent_module_id" => 0,
                    "entity_start_time" => 0,
                    "entity_end_time" => 0,
                    "status_name" => "Waiting to Start",
                    "project_id" => 2,
                    "project_name" => "qqqqccqqq",
                    "project_code" => "11112222",
                    "project_status_id" => 2,
                    "project_rate" => "111",
                    "project_description" => 0,
                    "project_start_time" => 0,
                    "project_end_time" => 0,
                    "project_created_by" => 1,
                    "media_thumb" => NULL,
                    "entity_sss_value" => NULL,
                    "entity_text_custom1_value" => NULL,
                    "entity_cccc_value" => NULL
                ],
                [
                    "entity_id" => 4,
                    "entity_name" => "2222",
                    "entity_status_id" => 2,
                    "entity_description" => NULL,
                    "entity_parent_module_id" => 0,
                    "entity_start_time" => 0,
                    "entity_end_time" => 0,
                    "status_name" => "Waiting to Start",
                    "project_id" => 2,
                    "project_name" => "qqqqccqqq",
                    "project_code" => "11112222",
                    "project_status_id" => 2,
                    "project_rate" => "111",
                    "project_description" => 0,
                    "project_start_time" => 0,
                    "project_end_time" => 0,
                    "project_created_by" => 1,
                    "media_thumb" => NULL,
                    "entity_sss_value" => NULL,
                    "entity_text_custom1_value" => NULL,
                    "entity_cccc_value" => NULL
                ],
                [
                    "entity_id" => 200015,
                    "entity_name" => "333",
                    "entity_status_id" => 2,
                    "entity_description" => NULL,
                    "entity_parent_module_id" => 0,
                    "entity_start_time" => 0,
                    "entity_end_time" => 0,
                    "status_name" => "Waiting to Start",
                    "project_id" => 2,
                    "project_name" => "qqqqccqqq",
                    "project_code" => "11112222",
                    "project_status_id" => 2,
                    "project_rate" => "111",
                    "project_description" => 0,
                    "project_start_time" => 0,
                    "project_end_time" => 0,
                    "project_created_by" => 1,
                    "media_thumb" => NULL,
                    "entity_sss_value" => NULL,
                    "entity_text_custom1_value" => NULL,
                    "entity_cccc_value" => NULL
                ]
            ],
            'has_many_relation' => [
                "base" => [
                    "mapping_type" => "has_many",
                    "is_directly_relation" => "yes",
                    "module_id" => 4,
                    "foreign_key" => "id",
                    "module_code" => "base",
                    "module_type" => "fixed",
                    "fields" => [
                        [
                            "id" => "base.id base_id"
                        ],
                        [
                            "name" => "base.name base_name"
                        ],
                        [
                            "priority" => "base.priority base_priority"
                        ],
                        [
                            "id" => "base.id base_id"
                        ]
                    ]
                ],
                "tag_link" => [
                    "mapping_type" => "has_many",
                    "is_directly_relation" => "yes",
                    "module_id" => 30,
                    "foreign_key" => "id",
                    "module_code" => "tag_link",
                    "module_type" => "fixed",
                    "fields" => [
                        [
                            "id" => "tag_link.id tag_link_id"
                        ],
                        [
                            "tag_id" => "tag_link.tag_id tag_link_tag_id"
                        ],
                        [
                            "link_id" => "tag_link.link_id tag_link_link_id"
                        ],
                        [
                            "module_id" => "tag_link.module_id tag_link_module_id"
                        ]
                    ],
                    "belong_to_config" => [
                        "primary_key" => "id",
                        "foreign_key" => "tag_id",
                        "format" => [
                            "table" => "tag",
                            "fields" => "id,name"
                        ]
                    ]
                ]

            ],
            'master_alias_name' => 'entity',
            'master_module_type' => 'entity',
        ];

        // ---------------------------------

        // 查询预处理
        $primaryIds = [];
        $primaryMapData = [];
        $primaryKey = $hasManyData['master_alias_name'] . "_id";
        foreach ($hasManyData['has_one_data'] as $relationJoinKey => $item) {
            $primaryMapData[$item[$primaryKey]] = $item;
            array_push($primaryIds, $item[$primaryKey]);
        }
        $primaryIdsString = join(",", $primaryIds);

        // 组装一对多查询条件
        foreach ($hasManyData['has_many_relation'] as $key => $relationItem) {
            $hasManyKey = $hasManyData['master_alias_name'] . "_" . $key;
            $hasManyFields = '';

            $middleMap = [];
            $middleIds = [];
            if (array_key_exists("belong_to_config", $relationItem)) {
                // belong to 关联查询

                // 获取中间表查询预处理
                //$belongToModel = new Model(camelize($key));
                $belongToModel = new Model("TagLink");

                $belongToSchemaData = $relationItem['belong_to_config'];

                // 组装必要的字段
                $fields = $belongToSchemaData['foreign_key'] . ',link_id';
                $filter = [
                    'link_id' => ["IN", $primaryIdsString],
                    'module_id' => $relationItem["module_id"]
                ];

                $middleData = $belongToModel->field($fields)->where($filter)->select();

                foreach ($middleData as $middleItem) {

                    if (array_key_exists($middleItem[$belongToSchemaData['foreign_key']], $middleMap)) {
                        array_push($middleMap[$middleItem[$belongToSchemaData['foreign_key']]], $middleItem["link_id"]);
                    } else {
                        $middleMap[$middleItem[$belongToSchemaData['foreign_key']]] = [$middleItem["link_id"]];
                    }

                    if (!in_array($middleItem[$belongToSchemaData['foreign_key']], $middleIds)) {
                        array_push($middleIds, $middleItem[$belongToSchemaData['foreign_key']]);
                    }
                }

                $hasManyFilter["id"] = ["IN", join(",", $middleIds)];

                // belong to 查询字段
                $hasManyFields = $belongToSchemaData['format']['fields'];
                $hasManyModel = new Model(camelize($belongToSchemaData['format']['table']));

            } else {
                if ($relationItem['module_type'] === "horizontal_relationship") {
                    // 远端关联查询

                    // 获取中间表查询预处理
                    $horizontalModel = new HorizontalModel();
                    $filter = [
                        'src_link_id' => ["IN", $primaryIdsString],
                        'src_module_id' => $relationItem["module_id"],
                        'dst_module_id' => $relationItem["relation_module_id"],
                        'variable_id' => $relationItem["variable_id"]
                    ];

                    $middleData = $horizontalModel->field("src_link_id,dst_link_id")->where($filter)->select();
                    foreach ($middleData as $middleItem) {
                        if (array_key_exists($middleItem["dst_link_id"], $middleMap)) {
                            array_push($middleMap[$middleItem["dst_link_id"]], $middleItem["src_link_id"]);
                        } else {
                            $middleMap[$middleItem["dst_link_id"]] = [$middleItem["src_link_id"]];
                        }

                        if (!in_array($middleItem["dst_link_id"], $middleIds)) {
                            array_push($middleIds, $middleItem["dst_link_id"]);
                        }
                    }

                    $hasManyFilter["id"] = ["IN", join(",", $middleIds)];

                    $hasManyModel = new Model(camelize($relationItem["module_code"]));
                } else {
                    // 直接一对多查询
                    $hasManyFilter[$primaryKey] = ["IN", $primaryIdsString];

                    $hasManyModel = new Model(camelize($key));
                }

                // 处理查询字段
                if (!empty($relationItem["fields"])) {
                    $hasManyFields = $this->handelField($relationItem["fields"], "has_many");
                }
            }

            // 查询关联表数据
            $middleHasManyData = $hasManyModel->field($hasManyFields)->where($hasManyFilter)->select();

            dump($middleHasManyData);
            die;

            if (!empty($middleMap)) {
                // 如果有中间表先把中间表进行映射处理
                foreach ($middleHasManyData as $hasManyItem) {
                    if (is_array($middleMap[$hasManyItem["id"]])) {
                        $tempArray = $middleMap[$hasManyItem["id"]];
                        foreach ($tempArray as $tempItemId) {
                            if (array_key_exists($hasManyKey, $primaryMapData[$tempItemId])) {
                                array_push($primaryMapData[$tempItemId][$hasManyKey], $hasManyItem);
                            } else {
                                $primaryMapData[$tempItemId][$hasManyKey] = [$hasManyItem];
                            }
                        }
                    } else {
                        if (array_key_exists($hasManyKey, $primaryMapData[$hasManyItem["id"]])) {
                            array_push($primaryMapData[$hasManyItem["id"]][$hasManyKey], $hasManyItem);
                        } else {
                            $primaryMapData[$hasManyItem["id"]][$hasManyKey] = [$hasManyItem];
                        }
                    }
                }
            } else {
                // 直接 has many 数据不需要中间过程
                foreach ($middleHasManyData as $hasManyItem) {
                    if (array_key_exists($hasManyKey, $primaryMapData[$hasManyItem[$primaryKey]])) {
                        array_push($primaryMapData[$hasManyItem[$primaryKey]][$hasManyKey], $hasManyItem);
                    } else {
                        $primaryMapData[$hasManyItem[$primaryKey]][$hasManyKey] = [$hasManyItem];
                    }
                }
            }

        }

        foreach ($hasManyData['has_one_data'] as $relationJoinKey => $item) {
            foreach ($hasManyData['has_many_relation'] as $key => $relationItem) {
                $belong_to_config = [];
                if (array_key_exists("belong_to_config", $relationItem)) {
                    $belong_to_config = $relationItem['belong_to_config'];
                }
                switch ($relationItem['module_type']) {
                    case "horizontal_relationship":

                        // 组装的外键
                        $connectionForeignKey = $hasManyData['master_alias_name'] . "_id";

                        // 查询水平关联数据
                        $horizontalModel = new HorizontalModel();

                        $horizontalData = $horizontalModel->field('src_link_id,dst_link_id')->where([
                            'variable_id' => $relationItem['variable_id'],
                            'src_module_id' => $relationItem['module_id'],
                            'dst_module_id' => $relationItem['relation_module_id'],
                            'src_link_id' => $item[$connectionForeignKey]
                        ])->select();

                        $relationModuleIds = array_column($horizontalData, 'dst_link_id');

                        // 组装has_many要查询的条件
                        if (array_key_exists($key, $hasManyFilter) && !in_array($item[$connectionForeignKey], $hasManyFilter[$key]["filter"])) {
                            array_push($hasManyFilter[$key]["filter"], $item[$connectionForeignKey]);
                            array_push($hasManyFilter[$key]["relation_data"], [$item[$connectionForeignKey] => $relationModuleIds]);
                        } else {
                            // 组装水平关联的查询条件
                            $hasManyFilter[$key] = [
                                'module_type' => $relationItem['module_type'],
                                'filter' => [$item[$connectionForeignKey]],
                                'foreign_key' => $relationItem['foreign_key'],
                                'module_code' => $relationItem['module_code'],
                                'relation_data' => [$item[$connectionForeignKey] => $relationModuleIds]
                            ];
                        }
                        break;
                    case "fixed":
                        $connectionForeignKey = $hasManyData['master_alias_name'] . "_id";

                        // 处理显示的字段
                        $relationHasManyField = [];
                        if (!empty($relationItem["fields"])) {
                            $relationHasManyField[] = $this->handelField($relationItem["fields"], "has_many");
                        }

                        // 组装has_many要查询的条件
                        if (array_key_exists($relationItem["module_code"], $hasManyFilter) && !in_array($item[$connectionForeignKey], $hasManyFilter[$relationItem["module_code"]]["filter"])) {
                            array_push($hasManyFilter[$relationItem["module_code"]]["filter"], $item[$connectionForeignKey]);
                        } else {
                            $hasManyFilter[$relationItem["module_code"]] = [
                                'foreign_key' => $relationItem['foreign_key'],
                                'filter' => [$item[$connectionForeignKey]],
                                'module_id' => $relationItem['module_id'],
                                'module_type' => $relationItem['module_type'],
                                'fields' => $relationHasManyField,
                                'belong_to_config' => $belong_to_config
                            ];
                        }
                        break;
                }
            }
        }
    }

    /**
     * 处理查询字段
     * @param $fieldConfig
     * @param $type
     * @return string
     */
    public function handelField($fieldConfig, $type)
    {
        $fieldData = [];
        $fieldString = "";
        switch ($type) {
            case "has_one":
                foreach ($fieldConfig as $key => $fieldItem) {
                    foreach ($fieldItem as $fieldKey => $item) {
                        $fieldData[$fieldKey] = $item;
                    }
                }
                $fieldString = implode(",", $fieldData);
                break;
            case "has_many":
                foreach ($fieldConfig as $key => $fieldItem) {
                    foreach ($fieldItem as $fieldKey => $item) {
                        $fieldString .= $fieldKey . ",";
                    }
                }
                $fieldString = rtrim($fieldString, ",");
                break;
        }
        return $fieldString;
    }

}