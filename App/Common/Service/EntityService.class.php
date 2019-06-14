<?php
// +----------------------------------------------------------------------
// | 实体服务层
// +----------------------------------------------------------------------
// | 主要服务于实体数据处理
// +----------------------------------------------------------------------
// | 错误编码头 205xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\EntityModel;
use Common\Model\FileCommitModel;
use Common\Model\FollowModel;
use Common\Model\NoteModel;
use Common\Model\OnsetLinkModel;
use Common\Model\PageSchemaUseModel;
use Common\Model\ReviewLinkModel;
use Common\Model\VariableModel;
use Common\Model\VariableValueModel;

class EntityService
{
    /**
     * 获取Entity Grid 表格数据
     * @param $param
     * @return mixed
     */
    public function getEntityGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $entityModel = new EntityModel();
        $resData = $entityModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取详情页面中的表格数据
     * @param $param
     * @return mixed
     */
    public function getDetailGridData($param)
    {
        $schemaService = new SchemaService();
        if (in_array($param['module_type'], ["horizontal_relationship", "be_horizontal_relationship", "entity_child"])) {
            $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
            $table = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];
            $moduleCode = $table;
            $horizontalService = new HorizontalService();
            switch ($param['module_type']) {
                case "horizontal_relationship":
                    $dstLinkIds = $horizontalService->getModuleRelationIds([
                        'src_module_id' => $param['parent_module_id'],
                        'src_link_id' => $param['item_id'],
                        'dst_module_id' => $param["module_id"]
                    ], "dst_link_id");
                    $request = [
                        "field" => "id",
                        "value" => join(',', $dstLinkIds),
                        "condition" => "IN",
                        "module_code" => $moduleData["code"],
                        "table" => string_initial_letter($table)
                    ];
                    array_push($param['filter']['request'], $request);
                    break;
                case "be_horizontal_relationship":
                    $dstLinkIds = $horizontalService->getModuleRelationIds([
                        'src_module_id' => $param['module_id'],
                        'dst_link_id' => $param['item_id'],
                        'dst_module_id' => $param["parent_module_id"]
                    ], "src_link_id");
                    $request = [
                        "field" => "id",
                        "value" => join(',', $dstLinkIds),
                        "condition" => "IN",
                        "module_code" => $moduleData["code"],
                        "table" => string_initial_letter($table)
                    ];
                    array_push($param['filter']['request'], $request);
                    break;
                case "entity_child":
                    $param['filter']['request'] = [
                        [
                            "field" => "parent_id",
                            "value" => $param["item_id"],
                            "condition" => "EQ",
                            "module_code" => $moduleData["code"],
                            "table" => string_initial_letter($table)
                        ],
                        [
                            "field" => "parent_module_id",
                            "value" => $param["parent_module_id"],
                            "condition" => "EQ",
                            "module_code" => $moduleData["code"],
                            "table" => string_initial_letter($table)
                        ]
                    ];
                    break;
            }
        } else {
            $moduleCode = "entity";
        }


        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $modelClassName = '\\Common\\Model\\' . string_initial_letter($moduleCode) . 'Model';
        $modelClass = new $modelClassName();
        $resData = $modelClass->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 生成固定字段保存数据
     * @param $field
     * @param $customData
     * @return mixed
     */
    protected function generateCustomFieldData($field, &$customData)
    {
        $variableService = new VariableService();
        $variableConfig = $variableService->getVariableConfig($field['variable_id']);
        $relationModuleId = array_key_exists("relation_module_id", $variableConfig) ? $variableConfig["relation_module_id"] : 0;
        $relationModuleCode = array_key_exists("relation_module_code", $variableConfig) ? $variableConfig["relation_module_code"] : "";

        $customData["variable_id"] = $field["variable_id"];
        $customData["value"] = $field["value"];
        $customData["field_type"] = $field["field_type"];
        $customData["module_code"] = "variable_value";
        $customData["project_id"] = $field["project_id"];
        $customData["module_id"] = $field["module_id"];
        $customData["fields"] = $variableConfig["code"];
        $customData["type"] = $variableConfig["type"];
        $customData["relation_module_id"] = $relationModuleId;
        $customData["relation_module_code"] = $relationModuleCode;

        return $customData;
    }

    /**
     * 组装面板保存数据格式
     * @param $dialogData
     * @param $param
     * @return array
     */
    public function generateModifyBatchDataFormat($dialogData, $param)
    {
        // 获取module字段数据
        $schemaService = new SchemaService();
        $moduleCodeMapData = $schemaService->getModuleMapData("code");

        // 初始化返回数据
        $resData = [
            "master_data" => [],
            "relation_data" => []
        ];

        $masterModule = $param["current_module"]["type"] === "entity" ? $param["current_module"]["type"] : $param["current_module"]["code"];

        // 处理主表
        if (array_key_exists($masterModule, $dialogData)) {
            foreach ($dialogData[$masterModule] as $masterItem) {
                $field = explode("-", $masterItem['field']);
                if ($masterItem['field_type'] == "built_in") {
                    if (reset($field) === $masterModule) {
                        $resData["master_data"][end($field)] = $masterItem["value"];
                    }
                    $resData["master_data"]["field_type"] = $masterItem["field_type"];
                    $resData["master_data"]["project_id"] = $param["project_id"];
                    $resData["master_data"]["id"] = !empty($param["primary_id"]) ? ["IN", $param['primary_id']] : 0;;
                } else {
                    $currentModuleId = $moduleCodeMapData[$param["current_module"]["code"]]["id"];
                    $masterItem["module_id"] = $currentModuleId;
                    $masterItem["project_id"] = $param["project_id"];
                    $this->generateCustomFieldData($masterItem, $customData);

                    if ($customData["relation_module_code"] === "media") {
                        foreach ($dialogData["media"]["data"] as $mediaItem) {
                            $field = explode("-", $mediaItem['field']);
                            if (reset($field) === "media") {
                                $mediaData[end($field)] = $mediaItem["value"];
                            }
                            $mediaData["relation_type"] = $dialogData["media"]["type"];
                            $customData["media_data"] = $mediaData;
                        }
                    }

                    if (array_key_exists($masterModule, $resData["relation_data"])) {
                        array_push($resData["relation_data"][$masterModule], $customData);
                    } else {
                        $resData["relation_data"][$masterModule][] = $customData;
                    }
                }
            }
        }

        // 媒体页面修改数据时，查询主键id
        if (array_key_exists("is_review", $param) && $param["is_review"] == "yes") {
            $baseModel = new BaseModel();
            $primaryId = $baseModel->where(["entity_id" => $param["primary_id"], "name" => $resData["master_data"]["code"]])
                ->getField("id");
            $resData["master_data"]["id"] = $primaryId;
            $resData["master_data"]["primary_id"] = $primaryId;
        }

        if (array_key_exists("media", $dialogData) && $dialogData["media"]["type"] === "horizontal") {
            $relationDialogData = array_diff_key($dialogData, [$masterModule => [], "media" => []]);
        } else {
            $relationDialogData = array_diff_key($dialogData, [$masterModule => []]);
        }

        // 关联表数据
        if (!empty($relationDialogData)) {
            // 处理关联表
            foreach ($relationDialogData as $moduleKey => $updateItem) {
                $updateData = $moduleKey == "media" ? $updateItem["data"] : $updateItem;
                foreach ($updateData as $item) {
                    if (is_array($item)) {
                        $field = explode("-", $item['field']);
                        if (array_key_exists("field_type", $item) && $item['field_type'] == "built_in") {
                            if (reset($field) === $moduleKey) {
                                $resData["relation_data"][$moduleKey][0][end($field)] = $item["value"];
                            }
                            $resData["relation_data"][$moduleKey][0]["field_type"] = $item["field_type"];
                            $resData["relation_data"][$moduleKey][0]["module_id"] = $param["current_module"]["id"];
                            $resData["relation_data"][$moduleKey][0]["module_code"] = $moduleKey;
                        } else {
                            if (!empty($item)) {
                                $currentModuleId = $moduleCodeMapData[$moduleKey]["id"];
                                if (reset($field) === $moduleKey) {
                                    $customData[end($field)] = $item["value"];
                                }
                                $item["module_id"] = $currentModuleId;
                                $item["project_id"] = $param["project_id"];
                                $this->generateCustomFieldData($item, $customData);
                                if (array_key_exists($moduleKey, $resData["relation_data"])) {
                                    array_push($resData["relation_data"][$moduleKey], $customData);
                                } else {
                                    $resData["relation_data"][$moduleKey][] = $customData;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $resData;
    }

    /**
     * 批量添加任务
     * @param $param
     * @param string $mode
     * @return array
     */
    public function batchSaveEntityBase($param, $mode = "add")
    {
        $param["entity_param"]["entity_id"] = array_key_exists("entity_id", $param["entity_param"]) ? $param["entity_param"]["entity_id"] : 0;

        // 处理批量保存任务的数据格式
        $taskRows = $this->assembleEntityModifyDataFormat($param);

        $resData = [];
        $param["entity_param"]["module"] = "base";
        $commonService = new CommonService(string_initial_letter("base"));

        // 调用保存信息
        foreach ($taskRows as $taskKey => $taskItem) {
            if ($mode == "modify") {
                $resData = $commonService->modifyItemDialog($taskItem, [
                    "module" => $param["entity_param"]["module"],
                    "module_id" => C("MODULE_ID")["base"],
                    "project_id" => $param["entity_param"]["project_id"],
                    "primary_id" => $taskItem["master_data"]["id"]
                ]);
            } else {
                $resData = $commonService->addItemDialog($taskItem, $param["entity_param"]);
            }
        }

        return $resData;
    }

    /**
     * 组装实体批量保存任务的数据格式
     * @param $param
     * @return array
     */
    protected function assembleEntityModifyDataFormat($param)
    {
        // 将工序数组做成以code为key的字段数据
        $stepCodeMap = array_column($param["step_ids"], null, "code");

        $entityParam = $param["entity_param"];

        // 获取主表的module信息
        $schemaService = new SchemaService();
        $moduleIdMapData = $schemaService->getModuleMapData("id");
        $taskModuleData = $moduleIdMapData[$entityParam["task_module_id"]];

        $taskRows = [];

        // 处理工序任务数据
        foreach ($param["entity_ids"] as $entityKey => $entityItem) {
            foreach ($param["task_rows"] as $stepKey => $stepItem) {
                foreach ($stepItem as $taskKey => $taskItem) {
                    $relationData = $this->generateModifyBatchDataFormat($taskItem, [
                        "module_id" => $entityParam["task_module_id"],
                        "project_id" => $entityParam["project_id"],
                        "primary_id" => $entityParam["entity_id"],
                        "is_review" => "yes",
                        "current_module" => $taskModuleData
                    ]);

                    $relationData["master_data"]["step_id"] = $stepCodeMap[$stepKey]["id"];
                    $relationData["master_data"]["entity_id"] = $entityItem["id"];
                    $relationData["master_data"]["entity_module_id"] = $entityParam["module_id"];
                    $taskRows[] = $relationData;
                }
            }
        }

        return $taskRows;
    }

    /**
     * 找到entity的所有parent
     * @param $entityId
     * @param $projectId
     * @param $ret
     */
    public function getParentInfo($entityId, $projectId, &$ret)
    {
        $entityModel = new EntityModel();
        $filter = ["filter" => ["id" => $entityId, "project_id" => $projectId]];
        $current = $entityModel->findData($filter);

        if (!empty($current["parent_id"]) && $current["parent_id"] !== $current["id"]) {
            $this->getParentInfo($current["parent_id"], $projectId, $ret);
        }

        array_push($ret, $current);
    }

    /**
     * 获取审核页面所有播放列表数据
     * @param $param
     * @return array
     */
    public function getReviewPlaylist($param)
    {
        $options = [
            "filter" => [
                "module_id" => $param["review_module_id"],
                "project_id" => $param["project_id"]
            ],
            "fields" => "id,name,code,project_id,module_id,status_id,created_by,created",
            "order" => "created desc",
            "page" => [$param["page_number"], $param["page_size"]]
        ];

        // 名称搜索
        if (array_key_exists("filter", $param) && !empty($param["filter"])) {
            $options["filter"]["name"] = $param["filter"]["name"];
        }

        if ($param["type"] === "my") {
            array_push($options["filter"], ["created_by" => session("user_id")]);
        }

        // 查询所有review任务
        $entityModel = new EntityModel();
        $resData = $entityModel->selectData($options);

        $reviewLinkModel = new ReviewLinkModel();
        $fileCommitModel = new FileCommitModel();
        $mediaService = new MediaService();
        $userService = new UserService();
        foreach ($resData["rows"] as $key => &$item) {
            // 格式化时间分组
            $item["group_md5"] = get_date_group_md5($item["created"]);
            $item["group_name"] = date("Y-m-d", strtotime($item["created"]));
            $userData = $userService->getUserFindField(["id" => $item["created_by"]], "name");
            $item["created_by"] = !empty($userData) ? $userData["name"] : "";
            // 获取是否关注
            $followService = new FollowService();
            $followStatus = $followService->getItemFollowStatus($param["review_module_id"], $item["id"]);
            $item["is_follow"] = $followStatus["follow_status"];
            // 获取缩略图
            $item["thumb"] = [];
            $reviewLinkData = $reviewLinkModel->selectData([
                "filter" => ["entity_id" => $item["id"]],
                "limit" => 4
            ]);

            $item["thumb"] = [];
            foreach ($reviewLinkData["rows"] as $fileCommitItem) {
                $fileCommitData = $fileCommitModel->findData(["filter" => ["id" => $fileCommitItem["file_commit_id"]]]);
                if (!empty($fileCommitData)) {
                    $mediaData = $mediaService->getMediaThumb(["module_id" => C("MODULE_ID")["file_commit"], "link_id" => $fileCommitData["id"]]);
                    array_push($item["thumb"], $mediaData);
                }

            }
        }
        return $resData;
    }

    /**
     * 获取审核页面我关注的播放列表数据
     * @param $param
     * @return array
     */
    public function getReviewFollowPlaylist($param)
    {
        $options = [
            "filter" => ["module_id" => $param["review_module_id"], "project_id" => $param["project_id"]],
            "fields" => "id,name,code,project_id,module_id,status_id,created_by,created",
            "order" => "created desc",
            "page" => [$param["page_number"], $param["page_size"]]
        ];

        // 获取我关注的信息
        $followModel = new FollowModel();
        $followData = $followModel->where(["module_id" => $param["review_module_id"], "user_id" => session("user_id")])->select();
        $followIds = array_column($followData, 'link_id');
        if (!empty($followIds)) {
            $options["filter"]["id"] = ["IN", join(",", $followIds)];

            if (!empty($param["filter"])) {
                $options["filter"]["name"] = ["LIKE", $param["filter"]["name"][1]];
            }

            // 查询所有review任务
            $entityModel = new EntityModel();
            $resData = $entityModel->selectData($options);

            $reviewLinkModel = new ReviewLinkModel();
            $fileCommitModel = new FileCommitModel();
            $mediaService = new MediaService();
            $userService = new UserService();
            foreach ($resData["rows"] as $key => &$item) {
                $item["is_follow"] = "yes";

                // 格式化时间分组
                $item["group_md5"] = get_date_group_md5($item["created"]);
                $item["group_name"] = date("Y-m-d", strtotime($item["created"]));
                $userData = $userService->getUserFindField(["id" => $item["created_by"]], "name");
                $item["created_by"] = !empty($userData) ? $userData["name"] : "";

                // 获取缩略图
                $item["thumb"] = [];
                $reviewLinkData = $reviewLinkModel->selectData([
                    "filter" => ["entity_id" => $item["id"]],
                    "limit" => 4
                ]);
                foreach ($reviewLinkData["rows"] as $fileCommitItem) {
                    $fileCommitData = $fileCommitModel->findData(["filter" => ["id" => $fileCommitItem["file_commit_id"]]]);
                    $mediaData = $mediaService->getMediaThumb(["module_id" => C("MODULE_ID")["file_commit"], "link_id" => $fileCommitData["id"]]);
                    array_push($item["thumb"], $mediaData);
                }
            }
            return $resData;
        } else {
            return ["total" => 0, "rows" => []];
        }
    }

    /**
     * 获取播放列表下的实体详情信息
     * @param $param
     * @return array|mixed
     */
    public function getPlayEntityInfo($param)
    {
        $entityModel = new EntityModel();
        $resData = $entityModel->findData([
            "filter" => ["id" => $param["entity_id"]],
            "fields" => "id,name,code,project_id,module_id,status_id"
        ]);

        // 获取step列表
        $templateService = new TemplateService();
        $stepList = $templateService->getTemplateConfig(['filter' => ["project_id" => $resData['project_id']], 'module_code' => "review", 'category' => 'step']);
        $stepMapData = array_column($stepList, null, 'id');

        // 获取任务数据
        $baseModel = new BaseModel();
        $baseData = $baseModel->field("id,name,code,status_id,step_id,priority")
            ->where(["entity_id" => $param["entity_id"]])
            ->select();

        $taskModuleId = C("MODULE_ID")["base"];

        // 获取任务字段配置
        $moduleData = D("Module")->field("id as module_id,name,code,type")->where(["id" => $taskModuleId])->find();
        $schemaService = new SchemaService();
        $fieldConfig = $schemaService->getTableFieldConfig($moduleData, $resData["project_id"]);

        // 固定字段配置
        $builtInFieldConfig = array_column($fieldConfig["built_in"], null, 'id');
        // 自定义字段配置
        $customFieldConfig = array_column($fieldConfig["custom"], null, 'fields');

        // 获取module数据
        $moduleIdMapData = $schemaService->getModuleMapData("id");

        $horizontalService = new HorizontalService();
        // 将任务数据放到相应的工具下
        foreach ($baseData as &$item) {
            // 自定义字段数据
            foreach ($fieldConfig["custom"] as $customFields) {
                if ($customFields["type"] === "horizontal_relationship") {
                    $dstLinkIds = $horizontalService->getModuleRelationIds([
                        'src_module_id' => $taskModuleId,
                        'src_link_id' => $item["id"]
                    ], "dst_link_id");
                    if ($moduleIdMapData[$customFields["relation_module_id"]]["type"] === "entity") {
                        $serviceClass = new EntityService();
                    } else {
                        $serviceClassName = '\\Common\\Service\\' . string_initial_letter($moduleIdMapData[$customFields["relation_module_id"]]["code"]) . 'Service';
                        $serviceClass = new $serviceClassName();
                    }
                    $filterData = [
                        "project_id" => $resData['project_id'],
                        "src_module_id" => $taskModuleId,
                        "variable_id" => $customFields["variable_id"],
                        "dst_module_id" => $customFields["relation_module_id"],
                        "src_link_id" => $item["id"],
                        "link_data" => [join(",", $dstLinkIds)],
                        "from" => "widget"
                    ];

                    // 获取当前水平关联数据
                    $horizontalRelationData = $serviceClass->getHRelationSourceData($filterData, [], "selected");
                    $item[$customFields["fields"]] = $horizontalRelationData["rows"];
                } else {
                    $variableValueModel = new VariableValueModel();
                    $item[$customFields["fields"]] = $variableValueModel->where([
                        "link_id" => $item["id"],
                        "module_id" => $taskModuleId,
                        "variable_id" => $customFields["variable_id"]
                    ])->getField("value");
                }
            }
            if (array_key_exists($item["step_id"], $stepMapData)) {
                $stepMapData[$item["step_id"]]["base_data"][] = $item;
            }
        }

        // 将工序数据放到新数组
        $resData["step_data"] = [];
        foreach ($stepMapData as $item) {
            if (array_key_exists("base_data", $item)) {
                foreach ($item["base_data"] as $key => $baseItem) {
                    $resData["step_data"][$item["code"]][$baseItem["code"]]["base"] = [];
                    foreach ($baseItem as $fieldKey => $baseValue) {
                        if (array_key_exists($fieldKey, $builtInFieldConfig)) {
                            // 固定字段配置
                            $field = [
                                "field" => $builtInFieldConfig[$fieldKey]["module"] . "-" . $fieldKey,
                                "field_type" => $builtInFieldConfig[$fieldKey]["field_type"],
                                "value" => $baseValue,
                                "variable_id" => 0
                            ];
                            array_push($resData["step_data"][$item["code"]][$baseItem["code"]]["base"], $field);
                        }

                        // 自定义字段配置
                        if (array_key_exists($fieldKey, $customFieldConfig)) {
                            $field = [
                                "field" => $customFieldConfig[$fieldKey]["module"] . "-" . $fieldKey,
                                "field_type" => $customFieldConfig[$fieldKey]["field_type"],
                                "value" => $baseValue,
                                "variable_id" => $customFieldConfig[$fieldKey]["variable_id"]
                            ];
                            array_push($resData["step_data"][$item["code"]][$baseItem["code"]]["base"], $field);
                        }
                    }
                }
            }
        }

        $resData["step_config"] = array_column($stepList, null, 'code');
        return $resData;
    }

    /**
     * 删除指定的审核实体播放列表
     * @param $param
     * @return array|mixed
     */
    public function deleteReviewPlaylist($param)
    {
        $entityFilter = ["entity_id" => $param["entity_id"]];

        $schemaService = new SchemaService();
        $moduleMapData = $schemaService->getModuleMapData("id");

        $baseModel = new BaseModel();
        $baseData = $baseModel->selectData(["filter" => $entityFilter]);

        $entityModel = new EntityModel();
        $entityModel->startTrans();

        if ($baseData["total"] > 0 && $param["progress"] == "start") {
            return throw_strack_exception(L("Current_Entity_Exists_Task"), 205003);
        } else {
            try {
                if ($param["progress"] == "continue") {

                    $reviewModuleId = C("MODULE_ID")["review"];
                    $deleteReviewParam = [
                        "module_id" => $reviewModuleId,
                        "module_code" => $moduleMapData[$reviewModuleId]["code"],
                        "module_type" => $moduleMapData[$reviewModuleId]["type"],
                        "primary_ids" => $param["entity_id"],
                    ];
                    $commonService = new CommonService(string_initial_letter("Entity"));
                    $commonService->deleteLinkageData($deleteReviewParam);
                }

                $resData = $entityModel->deleteItem(["id" => $param["entity_id"]]);
                if (!$resData) {
                    // 删除指定的审核实体播放列表失败错误码 002
                    throw_strack_exception($entityModel->getError(), 205002);
                }
                $entityModel->commit();
                // 返回成功数据
                return success_response($entityModel->getSuccessMassege(), $resData);
            } catch (\Exception $e) {
                $entityModel->rollback();
                // 删除指定的审核实体播放列表失败错误码 002
                throw_strack_exception($e->getMessage(), 205004);
            }
        }
    }

    /**
     * 获取审核实体审核进度
     * @param $baseId
     * @return mixed
     */
    public function getReviewEntityProgress($baseId)
    {
        // 查询当前任务的实体ID
        $baseModel = new BaseModel();
        $entityId = $baseModel->where(["id" => $baseId])->getField("entity_id");

        // 查询当前实体所有相关任务数据
        $reviewEntityData = $baseModel->alias("base")
            ->join("LEFT JOIN strack_step step ON step.id = base.step_id")
            ->join("LEFT JOIN strack_status status ON status.id = base.status_id")
            ->where([
                "base.entity_id" => $entityId
            ])
            ->field("
                base.id,
                base.name,
                step.name as step_name,
                step.code as step_code,
                status.code as status_code
            ")
            ->order('base.step_id asc')
            ->select();

        // 获取所有状态从属字典
        $statusService = new StatusService();
        $statusCorrespondDict = $statusService->getStatusCorrespondDict();

        // 组装实体进度数据
        $moduleId = C("MODULE_ID")["base"]; // 任务模块 module_id
        $reviewEntityProgress = [];
        $noteModel = new NoteModel();
        // 获取第一条note数据
        foreach ($reviewEntityData as $reviewEntityItem) {
            if (!array_key_exists($reviewEntityItem["step_code"], $reviewEntityProgress)) {
                $reviewEntityProgress[$reviewEntityItem["step_code"]] = [
                    "step_name" => $reviewEntityItem["step_name"],
                    "list" => []
                ];
            }
            $noteData = $noteModel->alias("note")
                ->join("LEFT JOIN strack_user user ON user.id = note.created_by")
                ->where(["note.link_id" => $reviewEntityItem["id"], "note.module_id" => $moduleId])
                ->field("note.text,user.name as created_by")
                ->order("note.created desc")
                ->find();
            $active = $reviewEntityItem["id"] === $baseId ? "yes" : "no";

            if (isset($noteData["text"])) {
                $noteData["text"] = htmlspecialchars_decode($noteData["text"]);
            }

            array_push($reviewEntityProgress[$reviewEntityItem["step_code"]]["list"], [
                "status" => array_key_exists($reviewEntityItem["status_code"], $statusCorrespondDict) ? $statusCorrespondDict[$reviewEntityItem["status_code"]] : "",
                "step" => $reviewEntityItem["step_name"],
                "note" => $noteData,
                "active" => $active
            ]);
        }

        return $reviewEntityProgress;
    }

    /**
     * 获取水平关联源数据
     * @param $param
     * @param $searchValue
     * @param $mode
     * @return array
     */
    public function getHRelationSourceData($param, $searchValue, $mode)
    {
        if ($mode === "all") {
            if (array_key_exists("horizontal_type", $param) && $param["horizontal_type"] === "entity_child") {
                $filter = [
                    "project_id" => $param["project_id"],
                    "parent_id" => ["NEQ", $param["src_link_id"]],
                    "module_id" => $param["src_module_id"]
                ];
            } else {
                $filter = [
                    "id" => ["NOT IN", join(",", $param["link_data"])],
                    "project_id" => $param["project_id"],
                    "module_id" => $param["dst_module_id"]
                ];
            }
        } else {
            if (array_key_exists("horizontal_type", $param) && $param["horizontal_type"] === "entity_child") {
                $filter = [
                    "project_id" => $param["project_id"],
                    "parent_id" => ["EQ", $param["src_link_id"]],
                    "module_id" => $param["src_module_id"],
                    "parent_module_id" => $param["dst_module_id"]
                ];
            } else {
                $filter = [
                    "id" => ["IN", join(",", $param["link_data"])],
                    "project_id" => $param["project_id"],
                    "module_id" => $param["dst_module_id"]
                ];
            }
        }

        // 有额外过滤条件
        if (!empty($searchValue)) {
            $filter = [
                $filter,
                [
                    "name" => ["LIKE", "%{$searchValue}%"],
                    "code" => ["LIKE", "%{$searchValue}%"],
                    "_logic" => "OR"
                ],
                "_logic" => "AND"
            ];
        }

        $option = [
            "filter" => $filter,
            "fields" => "id,name,code",
        ];

        if (array_key_exists("pagination", $param)) {
            $option["page"] = [$param["pagination"]["page_number"], $param["pagination"]["page_size"]];
        }

        $entityModel = new EntityModel();
        $horizontalRelationData = $entityModel->selectData($option);

        return $horizontalRelationData;
    }
}