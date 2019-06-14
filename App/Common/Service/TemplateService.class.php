<?php
// +----------------------------------------------------------------------
// | Template 项目模板服务
// +----------------------------------------------------------------------
// | 主要服务于Upload数据处理
// +----------------------------------------------------------------------
// | 错误编码头 226xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\ModuleModel;
use Common\Model\ProjectModel;
use Common\Model\ProjectTemplateModel;
use Common\Model\StatusModel;
use Common\Model\StepModel;

class TemplateService
{
    /**
     * 添加项目模板
     * @param $param
     * @return array
     */
    public function addProjectTemplate($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        if (!array_key_exists("config", $param)) {
            $param["config"] = [];
        }
        $resData = $projectTemplateModel->addItem($param);
        if (!$resData) {
            // 添加项目模板失败错误码 - 001
            throw_strack_exception($projectTemplateModel->getError(), 226001);
        } else {
            // 返回成功数据
            return success_response($projectTemplateModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改项目模板
     * @param $param
     * @return array
     */
    public function modifyProjectTemplate($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $resData = $projectTemplateModel->modifyItem($param);
        if (!$resData) {
            // 修改项目模板失败错误码 - 002
            throw_strack_exception($projectTemplateModel->getError(), 226002);
        } else {
            // 返回成功数据
            return success_response($projectTemplateModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除项目模板
     * @param $param
     * @return array
     */
    public function deleteProjectTemplate($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $resData = $projectTemplateModel->deleteItem($param);
        if (!$resData) {
            // 删除项目模板失败错误码 - 003
            throw_strack_exception($projectTemplateModel->getError(), 226003);
        } else {
            // 返回成功数据
            return success_response($projectTemplateModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 重置项目模板
     * @param $param
     * @return array
     */
    public function resetTemplateConfig($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        // 查询目标模板的配置
        $templateInfo = $projectTemplateModel->findData(['filter' => ['id' => $param['dist_template_id']], 'fields' => 'config']);
        $config = empty($templateInfo['config']) ? [] : json_decode($templateInfo['config']);
        // 将要修改的数据组成新的数组
        $templateParam = [
            'id' => $param['src_template_id'],
            'config' => $config,
        ];
        // 执行修改
        $resData = $projectTemplateModel->modifyItem($templateParam);
        if (!$resData) {
            // 重置项目模板失败错误码 - 005
            throw_strack_exception($projectTemplateModel->getError(), 226005);
        } else {
            // 返回成功数据
            return success_response($projectTemplateModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取项目模板列表
     * @param $filter
     * @return array
     */
    public function getTemplateList($filter)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $options = [
            "fields" => "id as project_template_id,name,code,project_id",
            "order" => "project_id asc"
        ];
        if (!empty($filter)) {
            $options["filter"] = $filter;
        }
        $templateData = $projectTemplateModel->selectData($options);

        // 获取当前项目名称
        $projectModel = new ProjectModel();
        foreach ($templateData["rows"] as &$templateItem) {
            if ($templateItem["project_id"] !== 0) {
                $templateItem["name"] = $projectModel->where(["id" => $templateItem["project_id"]])->getField("name");
            } else {
                $notice = L("Builtin_template");
                $templateItem["name"] = "{$templateItem["name"]} ( {$notice} )";
            }
        }

        return $templateData;
    }

    /**
     * 判断指定任务父级实体link_onset配置
     * @param $templateId
     * @param $taskId
     * @return bool
     */
    protected function checkTaskParentEntityLinkOnsetConfig($templateId, $taskId)
    {
        $baseModel = new BaseModel();
        $entityModuleId = $baseModel->where(["id" => $taskId])->getField("entity_module_id");

        if (!empty($entityModuleId)) {
            // 获取当实体所属module信息
            $moduleModel = new ModuleModel();

            $moduleData = $moduleModel->field("
                id as module_id,
                code as module_code,
                type as module_type
                ")->where(["id" => $entityModuleId])
                ->find();

            // 获取当前模块的link_onset配置
            $linkSwitchConfig = $this->getTemplateConfig([
                "category" => "link_onset",
                "module_code" => $moduleData["module_code"],
                "template_id" => $templateId
            ]);

            if (array_key_exists("switch", $linkSwitchConfig)) {
                if ((int)$linkSwitchConfig["switch"] === 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 获取指定模块标签栏列表
     * @param $param
     * @return array
     */
    public function getModuleTabList($param)
    {
        // 获取当前module信息
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);

        // 固定模块和动态模块分开处理
        $allowFixedTabs = [];
        switch ($moduleData["type"]) {
            case "fixed":
                // 固定模块
                switch ($moduleData["code"]) {
                    case "base":
                        // 任务模块
                        $allowFixedTabs = ['note', 'info', 'history', 'file', 'file_commit', 'correlation_base'];
                        if (array_key_exists("item_id", $param) && isset($param["item_id"])) {
                            // 验证当前任务父级是否配置了On-Set数据显示
                            if ($this->checkTaskParentEntityLinkOnsetConfig($param["template_id"], $param["item_id"])) {
                                array_push($allowFixedTabs, "onset");
                            }
                        } else {
                            array_push($allowFixedTabs, "onset");
                        }
                        break;
                    case "media":
                        // 媒体
                        $allowFixedTabs = ['info', 'history'];
                        break;
                    case "onset":
                        // 现场数据
                        $allowFixedTabs = ['info', 'reference', 'history'];
                        break;
                    case "file":
                        // 文件
                        $allowFixedTabs = ['info', 'file', 'history'];
                        break;
                    case "timelog":
                        // 时间日志
                        $allowFixedTabs = ['info', 'history'];
                        break;
                }
                break;
            case "entity": // 动态模块
                //  判断当前模块是否可以关联On-Set数据
                $linkSwitchConfig = $this->getTemplateConfig([
                    "category" => "link_onset",
                    "module_code" => $param["module_code"],
                    "template_id" => $param["template_id"]
                ]);

                $allowFixedTabs = ['note', 'base', 'info', 'history'];

                if (array_key_exists("switch", $linkSwitchConfig)) {
                    if ((int)$linkSwitchConfig["switch"] === 1) {
                        array_push($allowFixedTabs, 'onset');
                    }
                }
                break;
        }

        $moduleCodeMapData = $schemaService->getModuleMapData("code");
        $moduleIdMapData = $schemaService->getModuleMapData("id");

        //固定tab
        $tabList = [];
        foreach ($allowFixedTabs as $tab) {
            $tabData = tab_config($tab);
            $tabData["module_id"] = array_key_exists($tab, $moduleCodeMapData) ? $moduleCodeMapData[$tab]["id"] : 0;
            $tabData["type"] = "fixed";
            $tabData["module_type"] = $tabData["module_id"] > 0 ? $moduleCodeMapData[$tab]['type'] : "fixed";
            $tabData["table"] = '';
            $tabData["group"] = L("Fixed_Module");
            $tabData["module_code"] = $tabData['tab_id'];
            $tabData["dst_module_code"] = $tabData['tab_id'];
            array_push($tabList, $tabData);
        }

        // 获取实体下级
        if ($moduleData["type"] === "entity") {
            $childrenData = $schemaService->getEntityBelongParentModule(["module_code" => $param["module_code"]], "children");
            if (!empty($childrenData)) {
                array_push($tabList, generate_entity_child_tab_data($childrenData,$moduleData["id"]));
            }
        }

        // 处理水平关联的自定义数据
        $templateModel = new ProjectTemplateModel();
        $templateData = $templateModel->findData(["filter" => ["id" => $param["template_id"]], "fields" => "project_id"]);
        if ($templateData["project_id"] > 0) {
            // 获取类型为水平关联的自定义字段
            $variableService = new VariableService();
            $variableData = $variableService->getVariableHorizontalList($param["module_id"]);
            $this->generateHorizontalList($tabList, $variableData, $param, $moduleIdMapData, $moduleCodeMapData);

            // 获取水平被关联字段
            $beRelatedVariableData = $variableService->getBeRelatedVariableHorizontalList($param["module_id"]);
            $this->generateHorizontalList($tabList, $beRelatedVariableData, $param, $moduleIdMapData, $moduleCodeMapData, true);
        }

        // 判断是否启用了云盘（属于第三方页面）
        $diskService = new DiskService();
        $couldDiskSettings = $diskService->getCloudDiskConfig();
        if ($couldDiskSettings["open_cloud_disk"] == 1) {
            $couldDiskTabConfig = [
                'type' => 'other_page',
                'module_id' => 'cloud_disk',
                'tab_id' => 'cloud_disk',
                'module_code' => 'cloud_disk',
                'module_type' => 'other_page',
                'table' => '',
                'name' => L("Cloud_Disk"),
                "group" => L("Other"),
                "config" => $couldDiskSettings
            ];
            array_push($tabList, $couldDiskTabConfig);
        }

        // 返回数据
        return $tabList;
    }

    /**
     * 生成tab列表
     * @param $tabList
     * @param $variableData
     * @param $param
     * @param $moduleIdMapData
     * @param $moduleCodeMapData
     * @param bool $isBeRelated
     */
    protected function generateHorizontalList(&$tabList, $variableData, $param, $moduleIdMapData, $moduleCodeMapData, $isBeRelated = false)
    {
        if ($isBeRelated) {
            $variableType = "be_horizontal_relationship";
            $variableLang = L("Be_Horizontal_Relationship");
        } else {
            $variableType = "horizontal_relationship";
            $variableLang = L("Horizontal_Relationship");
        }

        foreach ($variableData as $item) {
            if ($isBeRelated) {
                $beRelatedModuleCode = $moduleIdMapData[$item["config"]["relation_module_id"]]["code"];
                $tagDataVariable = [
                    'module_id' => $item["config"]["relation_module_id"],
                    'dst_module_id' => $item["module_id"],
                    'variable_id' => $item["id"],
                    'tab_id' => 'be_' . $moduleIdMapData[$item["module_id"]]["code"] . '_' . $item["code"],
                    'module_code' => $beRelatedModuleCode,
                    'dst_module_code' => $moduleIdMapData[$item["module_id"]]["code"],
                    'module_type' => $moduleCodeMapData[$beRelatedModuleCode]["type"],
                    'table' => get_table_name($beRelatedModuleCode),
                    'name' => $item["name"],
                    'horizontal_type' => $moduleCodeMapData[$beRelatedModuleCode]["type"]
                ];
            } else {
                $tagDataVariable = [
                    'module_id' => $item["module_id"],
                    'dst_module_id' => $item["config"]["relation_module_id"],
                    'variable_id' => $item["id"],
                    'tab_id' => $param["module_code"] . '_' . $item["code"],
                    'module_code' => $param["module_code"],
                    'dst_module_code' => $moduleIdMapData[$item["config"]["relation_module_id"]]["code"],
                    'module_type' => $moduleCodeMapData[$param["module_code"]]["type"],
                    'table' => get_table_name($param["module_code"]),
                    'name' => $item["name"],
                    'horizontal_type' => $moduleCodeMapData[$param["module_code"]]["type"]
                ];
            }

            $tagDataVariable["type"] = $variableType;
            $tagDataVariable["group"] = $variableLang;
            // 追加到返回数组中
            array_push($tabList, $tagDataVariable);
        }
    }

    /**
     * 获取用户自定义配置
     * @param $param
     * @param int $userId
     * @return array
     */
    public function getUserCustomConfig($param, $userId = 0)
    {
        if ($userId > 0) {
            $templateService = new UserService();
            $filter = [
                "type" => $param["category"],
                "user_id" => $userId,
                "page" => $param["module_code"]
            ];
            $userConfig = $templateService->getUserCustomConfig($filter);
            if (!empty($userConfig) && array_key_exists("config", $userConfig)) {
                return $userConfig["config"];
            } else {
                $resData = $this->getTemplateConfig($param);
                return $resData;
            }
        } else {
            $resData = $this->getTemplateConfig($param);
            return $resData;
        }
    }

    /**
     * 获取模板配置
     * @param $param
     * @return array
     */
    public function getTemplateConfig($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $filter = array_key_exists('filter', $param) ? $param['filter'] : ["id" => $param["template_id"]];
        $configJson = $projectTemplateModel->where($filter)->getField("config");

        $fromConfig = [];
        if (!empty($configJson)) {
            $configData = json_decode($configJson, true);
            if (array_key_exists($param["module_code"], $configData)) {
                if (isset($param["category"])) {
                    // 取回指定的category项目模版配置信息
                    if (array_key_exists($param["category"], $configData[$param["module_code"]])) {
                        $fromConfig = $configData[$param["module_code"]][$param["category"]];
                    }
                } else {
                    // 如果不传category则取回当前模块所有项目模版配置信息
                    $fromConfig = $configData[$param["module_code"]];
                }
            }
        }
        return $fromConfig;
    }

    /**
     * 获取当前项目的模板ID
     * @param $projectId
     * @return mixed
     */
    public function getProjectTemplateID($projectId)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $templateId = $projectTemplateModel->where(["project_id" => $projectId])->getField("id");
        return $templateId;
    }

    /**
     * 修改项目模板配置
     * @param $param
     * @return array
     */
    public function modifyTemplateConfig($param)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $templateData = $projectTemplateModel->field("project_id,config")->where(["id" => $param["template_id"]])->find();
        $configData = json_decode($templateData["config"], true);

        if (!is_array($configData)) {
            $configData = [];
        }

        if (!array_key_exists($param["module_code"], $configData)) {
            $configData[$param["module_code"]] = [
                $param["category"] => $param["config"]
            ];
        } else {
            $configData[$param["module_code"]][$param["category"]] = $param["config"];
        }

        $resData = $projectTemplateModel->modifyItem([
            "id" => $param["template_id"],
            "config" => $configData,
        ]);

        if (!$resData) {
            // 修改项目模板配置失败错误码 - 004
            throw_strack_exception($projectTemplateModel->getError(), 226004);
        } else {
            $message = string_initial_letter($param["module_code"] . '_' . $param["category"] . '_Template_SC', "_");
            if (in_array($param["category"], ["step", "step_fields"])) {
                $configFormat = json_decode($resData["config"], true);
                $stepList = array_key_exists("step", $configFormat[$param["module_code"]]) ? $configFormat[$param["module_code"]]["step"] : [];
                $stepFields = array_key_exists("step_fields", $configFormat[$param["module_code"]]) ? $configFormat[$param["module_code"]]["step_fields"] : [];
                if (!empty($stepList)) {
                    $stepParam = [
                        "category" => $param["category"],
                        "module_code" => $param["module_code"],
                        "step_list" => $stepList,
                        "step_fields" => $stepFields,
                        "project_id" => $templateData["project_id"]
                    ];
                    $this->changeStepFieldsLinkView($stepParam);
                }
            }

            // 返回成功数据
            return success_response(L($message), $resData);
        }
    }

    /**
     * 改变任务表自定义字段相应的改变实体视图
     * @param $param
     * @param $mode
     * @return array
     */
    protected function changeBaseFieldsLinkEntity($param, $mode)
    {
        $resData = [];

        // 获取模版ID
        $templateId = $this->getProjectTemplateID($param["project_id"]);
        // 获取模版配置
        $templateConfig = $this->getTemplateConfig([
            "template_id" => $templateId,
            "module_code" => $param["module_code"]
        ]);

        // 处理数据修改
        if (array_key_exists($param["category"], $templateConfig)) {
            $fieldConfig = [];
            switch ($mode) {
                case "delete":
                    foreach ($templateConfig[$param["category"]] as $fieldItem) {
                        if (($fieldItem["field_type"] !== "custom") ||
                            ($fieldItem["field_type"] === "custom" && $param["original_fields"] !== $fieldItem["fields"])) {
                            array_push($fieldConfig, $fieldItem);
                        }
                    }
                    break;
                case "update":
                    $originalFields = array_column($templateConfig[$param["category"]], null, "fields");
                    if (array_key_exists($param["original_fields"], $originalFields) && $originalFields[$param["original_fields"]]["field_type"] === "custom") {
                        $originalFields[$param["original_fields"]]["lang"] = $param["variable_name"];
                        $originalFields[$param["original_fields"]]["fields"] = $param["update_fields"];
                        $originalFields[$param["original_fields"]]["id"] = $param["update_fields"];
                        $originalFields[$param["original_fields"]]["value_show"] = $param["update_fields"];
                        $originalFields[$param["original_fields"]]["field_group_id"] = "{$originalFields[$param["original_fields"]]["module_code"] }_{$param["update_fields"]}";
                    }
                    $fieldConfig = array_column($originalFields, null);
                    break;
            }

            try {
                $resData = $this->modifyTemplateConfig([
                    "module_code" => $param["module_code"],
                    "category" => $param["category"],
                    "template_id" => $templateId,
                    "config" => $fieldConfig
                ]);
            } catch (\Exception $e) {

            }
        }

        return $resData;
    }

    /**
     * 新建自定义字段，同时更新视图
     * @param $param
     * @param string $mode
     * @return array
     */
    public function changeViewCustomFields($param, $mode)
    {
        // 获取符合条件的视图
        $filter = ["page" => $param["page"], "project_id" => $param["project_id"]];

        $viewService = new ViewService();
        // 自定义视图
        $viewListData = $viewService->getViewListData([
            "filter" => ["filter" => $filter, "fields" => "id,config"],
            "module_code" => "view"
        ]);
        // 获取默认视图
        $viewDefaultData = $viewService->getViewListData([
            "filter" => ["filter" => $filter, "fields" => "id,page,config"],
            "module_code" => "view_default"
        ]);

        // 设置显示的数据
        $valueShowFields = "{$param["module_code"]}_{$param["code"]}";
        $field = in_array($param["field_type"], ["horizontal_relationship", "belong_to"]) ? $valueShowFields : "{$valueShowFields}_value";

        // 视图中字段格式
        $viewFields = [
            "field" => $field,
            "width" => 120,
            "frozen_status" => false
        ];

        $resData = [];

        if ($viewListData["total"] > 0 || $viewDefaultData["total"] > 0) {
            $viewList = array_merge($viewListData["rows"], $viewDefaultData["rows"]);
            switch ($mode) {
                case "add":
                    foreach ($viewList as $viewItem) {

                        if ($param["module_type"] === "entity") {
                            array_push($viewItem["config"]["fields"][1], $viewFields);
                        } else {
                            array_push($viewItem["config"]["fields"], $viewFields);
                        }

                        // 默认
                        if (array_key_exists("page", $viewItem)) {
                            $viewService->modifyDefaultView($viewItem);
                        } else { // 自定义视图
                            $viewService->modifyView($viewItem);
                        }
                    }
                    break;
                case "update":
                    if ($param["module_code"] === "base") {
                        $moduleModel = new ModuleModel();
                        $moduleList = $moduleModel->where(["type" => "entity"])->select();
                        foreach ($moduleList as $moduleItem) {
                            $this->changeBaseFieldsLinkEntity([
                                "category" => "step_fields",
                                "module_code" => $moduleItem["code"],
                                "project_id" => $param["project_id"],
                                "original_fields" => $param["old_code"],
                                "update_fields" => $param["code"],
                                "variable_name" => $param["name"]
                            ], "update");
                        }
                    }

                    // 设置显示的数据
                    $oldValueShowFields = "{$param["module_code"]}_{$param["old_code"]}";
                    $oldField = in_array($param["field_type"], ["horizontal_relationship", "belong_to"]) ? $oldValueShowFields : "{$oldValueShowFields}_value";

                    foreach ($viewList as $viewItem) {
                        if ($param["module_type"] === "entity") {
                            $originalView = array_column($viewItem["config"]["fields"][1], null, "field");
                            if (array_key_exists($oldField, $originalView)) {
                                $originalView[$oldField]["field"] = $field;
                            }

                            $viewItem["config"]["fields"][1] = array_column($originalView, null);
                        } else {

                            $originalView = array_column($viewItem["config"]["fields"], null, "field");
                            if (array_key_exists($oldField, $originalView)) {
                                $originalView[$oldField]["field"] = $field;
                            }

                            $viewItem["config"]["fields"] = array_column($originalView, null);
                        }

                        // 默认
                        if (array_key_exists("page", $viewItem)) {
                            $viewService->modifyDefaultView($viewItem);
                        } else { // 自定义视图
                            $viewService->modifyView($viewItem);
                        }
                    }
                    break;
                case "delete":
                    if ($param["module_code"] === "base") {
                        $moduleModel = new ModuleModel();
                        $moduleList = $moduleModel->where(["type" => "entity"])->select();
                        foreach ($moduleList as $moduleItem) {
                            $this->changeBaseFieldsLinkEntity([
                                "category" => "step_fields",
                                "module_code" => $moduleItem["code"],
                                "project_id" => $param["project_id"],
                                "original_fields" => $param["code"]
                            ], "delete");
                        }
                    }

                    foreach ($viewList as $viewItem) {
                        if ($param["module_type"] === "entity") {
                            $firstFieldData = $this->dealViewFirstFields([
                                "first_field_data" => $viewItem["config"]["fields"][0],
                                "delete_field" => $field
                            ], "delete");
                            $viewItem["config"]["fields"][0] = $firstFieldData["first_field_list"];

                            $secondFieldData = [];
                            foreach ($viewItem["config"]["fields"][1] as $fieldItem) {
                                if ($fieldItem["field"] !== $field) {
                                    array_push($secondFieldData, $fieldItem);
                                }
                            }

                            $viewItem["config"]["fields"][1] = $secondFieldData;
                        } else {
                            $secondFieldData = [];
                            foreach ($viewItem["config"]["fields"] as $fieldItem) {
                                if ($fieldItem["field"] !== $field) {
                                    array_push($secondFieldData, $fieldItem);
                                }
                            }
                            $viewItem["config"]["fields"] = $secondFieldData;
                        }

                        // 默认视图
                        if (array_key_exists("page", $viewItem)) {
                            $viewService->modifyDefaultView($viewItem);
                        } else { // 自定义视图
                            $viewService->modifyView($viewItem);
                        }
                    }
                    break;
            }
        }

        return $resData;
    }

    /**
     * 保存模版与视图字段之间的联动
     * @param $param
     * @return array
     */
    protected function changeStepFieldsLinkView($param)
    {
        $viewService = new ViewService();
        $schemaService = new SchemaService();

        // 模版设置工序
        $templateStep = $param["step_list"];
        $stepCodeMap = array_column($templateStep, null, "code");

        // 模版设置工序字段
        $templateStepFields = $param["step_fields"];

        // 增加视图显示字段格式
        $masterModuleCode = "base";
        foreach ($templateStepFields as &$stepFieldItem) {
            $stepFieldItem["view_field"] = $schemaService->getFieldColumnName($stepFieldItem, $masterModuleCode);
        }
        $stepFieldsMap = array_column($templateStepFields, null, "view_field");

        // 获取所有的工序显示字段
        $showStepFields = array_column($templateStepFields, "view_field");
        // 获取工序显示的第一个字段
        $firstStepFields = array_first($showStepFields);
        // 获取除第一个以外的字段
        $fieldList = [];
        foreach ($showStepFields as $key => $fieldItem) {
            if ($key > 0) {
                array_push($fieldList, $fieldItem);
            }
        }

        $page = "project_{$param["module_code"]}";

        $filter = ["page" => $page, "project_id" => $param["project_id"]];
        // 自定义视图
        $viewListData = $viewService->getViewListData([
            "filter" => ["filter" => $filter, "fields" => "id,config"],
            "module_code" => "view"
        ]);
        // 获取默认视图
        $viewDefaultData = $viewService->getViewListData([
            "filter" => ["filter" => $filter, "fields" => "id,page,config"],
            "module_code" => "view_default"
        ]);

        $viewParam = [
            "config" => [],
            "first_field" => $firstStepFields,
            "field_list" => $fieldList,
            "step_code_map" => $stepCodeMap,
            "step_fields_map" => $stepFieldsMap,
            "step_show_field_list" => $showStepFields
        ];

        $resData = [];
        if ($viewListData["total"] > 0 || $viewDefaultData["total"] > 0) {
            $viewList = array_merge($viewListData["rows"], $viewDefaultData["rows"]);
            foreach ($viewList as $viewData) {
                $viewParam["config"] = $viewData["config"];
                $viewData["config"] = $this->generateViewConfigData($viewParam);
                // 默认视图
                if (array_key_exists("page", $viewData)) {
                    $resData = $viewService->modifyDefaultView($viewData);
                } else { // 自定义视图
                    $resData = $viewService->modifyView($viewData);
                }
            }
        }

        return $resData;
    }

    /**
     * 处理一层字段数据
     * @param $param
     * @param string $mode
     * @return mixed
     */
    public function dealViewFirstFields($param, $mode = "add")
    {
        $firstFnameMap = [];
        $firstStepData = [];
        switch ($mode) {
            case "add":
                foreach ($param["first_field_data"] as $firstFieldItem) {
                    if (array_key_exists("step", $firstFieldItem) && $firstFieldItem["step"] === "yes") {
                        if (array_key_exists($firstFieldItem["fname"], $param["step_code_map"])) {
                            if (!$firstFieldItem["fhcol"]) {
                                $firstFieldItem["colspan"] = count($param["step_show_field_list"]);
                            } else {
                                $firstFieldItem["colspan"] = 1;
                            }
                            $firstFieldItem["first_field"] = $param["first_field"];
                            $firstFieldItem["field_list"] = join(",", $param["field_list"]);

                            array_push($firstStepData, $firstFieldItem);
                        } else {
                            $firstFieldMapData = array_column($firstStepData, null, "fname");
                            foreach ($param["step_code_map"] as $stepItem) {
                                if (!array_key_exists($stepItem["code"], $firstFieldMapData)) {
                                    $stepData = [
                                        "bgc" => $stepItem["color"],
                                        "but" => $stepItem["code"],
                                        "step" => "yes",
                                        "class" => "{$stepItem["code"]}_h",
                                        "fhcol" => true,
                                        "fname" => $stepItem["code"],
                                        "title" => $stepItem["name"],
                                        "colspan" => 1,
                                        "field_list" => join(",", $param["field_list"]),
                                        "first_field" => $param["first_field"],
                                        "frozen_status" => false,
                                        "hidden_status" => "no"
                                    ];
                                    array_push($firstStepData, $stepData);
                                }
                            }
                        }
                    } else {
                        array_push($firstStepData, $firstFieldItem);
                    }
                }
                $firstFnameMap = array_column($firstStepData, null, "fname");
                break;
            case "delete":
                foreach ($param["first_field_data"] as &$firstFieldItem) {
                    if (array_key_exists("step", $firstFieldItem) && $firstFieldItem["step"] === "yes") {
                        $fieldList = explode(",", $firstFieldItem["field_list"]);
                        array_push($fieldList, $firstFieldItem["first_field"]);
                        if (in_array($param["delete_field"], $fieldList)) {
                            $retainFields = array_diff($fieldList, [$param["delete_field"]]);
                            $firstField = array_first($retainFields);

                            array_splice($retainFields, array_search($firstField, $retainFields), 1);
                            $firstFieldItem["first_field"] = $firstField;
                            $firstFieldItem["field_list"] = join(",", $retainFields);
                            array_push($firstStepData, $firstFieldItem);
                        }
                    }
                }
                break;
        }

        return ["first_fname_map" => $firstFnameMap, "first_field_list" => $firstStepData];
    }

    /**
     * 处理step字段数据
     * @param $viewSecondFields
     * @param $valueShowFields
     * @param $field
     * @param $param
     * @param $stepItem
     * @return mixed
     */
    protected function dealStepFieldData(&$viewSecondFields, $valueShowFields, $field, $param, $stepItem)
    {
        // 工序最后一个字段
        $lastStepFields = end($param["step_show_field_list"]);
        if (in_array($field, [$param["first_field"], $lastStepFields])) {
            $viewSecondFields[$valueShowFields]["bdc"] = $stepItem["color"];
            $viewSecondFields[$valueShowFields]["cellClass"] = "datagrid-cell-c1-{$valueShowFields}";
            $viewSecondFields[$valueShowFields]["deltaWidth"] = 1;
            if ($field == $param["first_field"]) {
                $viewSecondFields[$valueShowFields]["hidden"] = false;
                $viewSecondFields[$valueShowFields]["cbd"] = "colleft";
                $viewSecondFields[$valueShowFields]["step_index"] = "first";
            } else {
                $hidden = $param["first_fname_map"][$stepItem["code"]]["colspan"] > 1 ? false : true;
                $viewSecondFields[$valueShowFields]["hidden"] = $hidden;
                $viewSecondFields[$valueShowFields]["cbd"] = "colright";
                $viewSecondFields[$valueShowFields]["step_index"] = "last";
            }
        } else {
            $hidden = $param["first_fname_map"][$stepItem["code"]]["colspan"] > 1 ? false : true;
            $viewSecondFields[$valueShowFields]["hidden"] = $hidden;
            $viewSecondFields[$valueShowFields]["step_index"] = "";
            $viewSecondFields[$valueShowFields] = array_diff_key($viewSecondFields[$valueShowFields], ["cellClass" => "", "bdc" => "", "cbd" => "", "deltaWidth" => ""]);
        }
        return $viewSecondFields;
    }

    /**
     * 处理视图字段数据
     * @param $param
     * @return mixed
     */
    private function generateViewConfigData($param)
    {
        $viewData = $param["config"];

        // 处理双层表头中 第一层数据
        $countLayer = count($viewData["fields"]);
        if ($countLayer === 2) {
            $param["first_field_data"] = $viewData["fields"][0];
            $firstFieldData = $this->dealViewFirstFields($param, "add");
            $firstFnameMap = $firstFieldData["first_fname_map"];
            $viewData["fields"][0] = $firstFieldData["first_field_list"];

            // 处理双层表头中 第二层数据
            $viewSecondFields = [];
            $viewSecondFieldMap = array_column($viewData["fields"][1], null, "field");
            foreach ($viewSecondFieldMap as $key => $secondFieldItem) {
                if (array_key_exists("step", $secondFieldItem) && $secondFieldItem["step"]) {
                    if (array_key_exists($secondFieldItem["belong"], $firstFnameMap)) {

                        foreach ($param["step_show_field_list"] as $stepFieldItem) {
                            $valueShowFields = $secondFieldItem["belong"] . "_" . $stepFieldItem;
                            if (!array_key_exists($valueShowFields, $viewSecondFields)) {
                                if (array_key_exists($valueShowFields, $viewSecondFieldMap)) {
                                    $viewSecondFields[$valueShowFields] = $viewSecondFieldMap[$valueShowFields];
                                } else {
                                    $addStepFields = [
                                        "drag" => false,
                                        "step" => true,
                                        "align" => "center",
                                        "field" => "{$secondFieldItem["belong"]}_{$param["step_fields_map"][$stepFieldItem]["view_field"]}",
                                        "title" => $param["step_fields_map"][$stepFieldItem]["lang"],
                                        "width" => 120,
                                        "belong" => $secondFieldItem["belong"],
                                        "findex" => 0,
                                        "hidden" => false,
                                        "step_index" => "",
                                        "frozen_status" => false,
                                    ];
                                    $viewSecondFields[$valueShowFields] = $addStepFields;
                                }
                            }
                            $param["first_fname_map"] = $firstFnameMap;
                            $this->dealStepFieldData($viewSecondFields, $valueShowFields, $stepFieldItem, $param, $param["step_code_map"][$secondFieldItem["belong"]]);
                        }
                    } else {
                        foreach ($param["step_code_map"] as &$stepItem) {
                            $stepItem["step_show_field_list"] = $param["step_show_field_list"];
                        }

                        foreach ($param["step_code_map"] as $stepKey => $stepCodeItem) {
                            foreach ($stepCodeItem["step_show_field_list"] as $fieldItem) {
                                $valueShowFields = $stepKey . "_" . $fieldItem;

                                $addStepFields = [
                                    "drag" => false,
                                    "step" => true,
                                    "align" => "center",
                                    "field" => "{$stepKey}_{$param["step_fields_map"][$fieldItem]["view_field"]}",
                                    "title" => $param["step_fields_map"][$fieldItem]["lang"],
                                    "width" => 120,
                                    "belong" => $stepKey,
                                    "findex" => 0,
                                    "hidden" => false,
                                    "step_index" => "",
                                    "frozen_status" => false,
                                ];
                                $viewSecondFields[$valueShowFields] = $addStepFields;
                                $param["first_fname_map"] = $firstFnameMap;
                                $this->dealStepFieldData($viewSecondFields, $valueShowFields, $fieldItem, $param, $stepCodeItem);
                            }
                        }
                    }
                } else {
                    $viewSecondFields[$secondFieldItem["field"]] = $secondFieldItem;
                }
            }

            $sortSecondsViewFields = array_column($viewSecondFields, null);
            foreach ($sortSecondsViewFields as $key => &$item) {
                if (array_key_exists("findex", $item)) {
                    $item["findex"] = $key;
                }
            }
            $viewData["fields"][1] = $sortSecondsViewFields;
        }

        return $viewData;
    }

    /**
     * 获取数据表格视图模板配置数据（分组、排序、工序、工序字段）
     * @param $param
     * @return array
     */
    public function getGridViewTemplateConfig($param)
    {
        // 获取当前模块项目模版配置
        $moduleTemplateConfig = $this->getTemplateConfig($param);

        // 定义变量
        $groupConfig = [];
        $sortConfig = ["sort_data" => [], "sort_query" => []];
        $stepListConfig = [];
        $stepFieldsConfig = [];

        //  存在项目模板配置
        if (!empty($moduleTemplateConfig)) {

            // 工序配置列表和工序字段缺一不可
            if (array_key_exists("step", $moduleTemplateConfig) && !empty($moduleTemplateConfig["step"]) &&
                array_key_exists("step_fields", $moduleTemplateConfig) && !empty($moduleTemplateConfig["step_fields"])
            ) {
                $stepListConfig = $moduleTemplateConfig['step'];
                $stepFieldsConfig = $moduleTemplateConfig['step_fields'];
            }
        }
        return [
            "group" => $groupConfig,
            "sort" => $sortConfig,
            "step_list" => $stepListConfig,
            "step_fields" => $stepFieldsConfig,
        ];
    }

    /**
     * 获取项目模板指定模块目标配置
     * @param $templateId
     * @param $moduleCode
     * @param $keyName
     * @return array
     */
    public function getConfigTargetSetting($templateId, $moduleCode, $keyName)
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $configData = $projectTemplateModel->findData([
            "fields" => "config",
            "filter" => ["id" => $templateId]
        ]);

        if (array_key_exists($moduleCode, $configData["config"])) {
            if (array_key_exists($keyName, $configData["config"][$moduleCode])) {
                return $configData["config"][$moduleCode][$keyName];
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    /**
     * 获取项目工序列表
     * @return array
     */
    public function getTemplateStepList()
    {
        $stepModel = new StepModel();
        $options = [
            'fields' => 'id,name,code,color'
        ];
        $resData = $stepModel->selectData($options);
        return $resData;
    }

    /**
     * 获取制定模块工序列表
     * @param $param
     * @return array
     */
    public function getProjectOverviewStepList($param)
    {
        // 获取所有状态
        $stepModel = new StepModel();
        $options = [
            "fields" => "id,name,code,color",
        ];

        // 判断是否有查询条件
        if (isset($param["filter"])) {
            $options["filter"] = ["name" => ["LIKE", "%" . $param["filter"] . "%"]];
        }

        $filterStepData = $stepModel->selectData($options);

        // 获取当前项目模板设置
        $templateService = new TemplateService();
        $templateStepConfig = $templateService->getConfigTargetSetting($param["template_id"], $param["module_code"], "step");
        $isCheckedStepList = [];

        foreach ($templateStepConfig as $item) {
            array_push($isCheckedStepList, $item["id"]);
        }

        $stepList = [];
        foreach ($filterStepData["rows"] as $stepItem) {
            if (in_array($stepItem["id"], $isCheckedStepList)) {
                $stepItem["checked"] = "yes";
            } else {
                $stepItem["checked"] = "no";
            }
            array_push($stepList, $stepItem);
        }

        // 被选中的step按顺序返回
        $stepCheckedList = [];
        $checkedStepData = $stepModel->selectData([
            "fields" => "id,name,code,color",
            "filter" => ["id" => ["IN", join(",", $isCheckedStepList)]]
        ]);

        $checkedStepDataIndex = [];
        foreach ($checkedStepData["rows"] as $stepItem) {
            $checkedStepDataIndex[$stepItem["id"]] = $stepItem;
        }
        // 按状态排序
        foreach ($isCheckedStepList as $stepId) {
            array_push($stepCheckedList, $checkedStepDataIndex[$stepId]);
        }

        return ["step_list" => $stepList, "step_checked" => $stepCheckedList];

    }

    /**
     * 获取项目首页模块状态列表
     * @param $param
     * @return array
     */
    public function getProjectOverviewStatusList($param)
    {
        // 获取所有状态
        $statusModel = new StatusModel();

        $options = [
            "fields" => "id,name,code,color,icon,correspond",
        ];

        // 判断是否有查询条件
        if (isset($param["filter"])) {
            $options["filter"] = ["name" => ["LIKE", "%" . $param["filter"] . "%"]];
        }

        $filterStatusData = $statusModel->selectData($options);

        // 获取当前项目模板设置
        $templateStatusConfig = $this->getConfigTargetSetting($param["template_id"], $param["module_code"], "status");
        $isCheckedStatusList = [];
        foreach ($templateStatusConfig as $item) {
            array_push($isCheckedStatusList, $item["id"]);
        }

        // 分组整理状态列表
        $statusList = [
            'blocked' => ['title' => status_corresponds_lang('blocked'), 'data' => []],
            'not_started' => ['title' => status_corresponds_lang('not_started'), 'data' => []],
            'in_progress' => ['title' => status_corresponds_lang('in_progress'), 'data' => []],
            'daily' => ['title' => status_corresponds_lang('daily'), 'data' => []],
            'done' => ['title' => status_corresponds_lang('done'), 'data' => []],
            'hide' => ['title' => status_corresponds_lang('hide'), 'data' => []]
        ];

        foreach ($filterStatusData["rows"] as $statusItem) {
            if (in_array($statusItem["id"], $isCheckedStatusList)) {
                $statusItem["checked"] = "yes";
            } else {
                $statusItem["checked"] = "no";
            }
            array_push($statusList[$statusItem["correspond"]]["data"], $statusItem);
        }

        // 被选中的status按顺序返回
        $statusCheckedList = [];
        $checkedStatusData = $statusModel->selectData([
            "fields" => "id,name,code,color,icon,correspond",
            "filter" => ["id" => ["IN", join(",", $isCheckedStatusList)]]
        ]);

        $checkedStatusDataIndex = [];
        foreach ($checkedStatusData["rows"] as $statusItem) {
            $statusItem["corresponds_lang"] = status_corresponds_lang($statusItem["correspond"]);
            $checkedStatusDataIndex[$statusItem["id"]] = $statusItem;
        }
        // 按状态排序
        foreach ($isCheckedStatusList as $statusId) {
            array_push($statusCheckedList, $checkedStatusDataIndex[$statusId]);
        }

        return ["status_list" => $statusList, "status_checked" => $statusCheckedList];
    }

    /**
     * 获取指定项目的导航
     * @param $projectId
     * @param $moduleId
     * @param $menuName
     * @return array
     */
    public function getProjectNavigation($projectId, $moduleId, $menuName = "")
    {
        $projectTemplateModel = new ProjectTemplateModel();
        $templateConfig = $projectTemplateModel->findData([
            'fields' => 'id,config',
            'filter' => ["project_id" => $projectId]
        ]);

        $navigationConfig = $templateConfig["config"]["project"]["navigation"];
        $navigationAllowShow = [];

        foreach ($navigationConfig as $item) {
            array_push($navigationAllowShow, $item["module_id"]);
        }

        $schemaService = new SchemaService();
        $projectTemplateModuleList = $schemaService->getProjectTemplateModuleList($templateConfig["id"]);
        $projectNavigationIndex = [];

        // 固定模块数据
        foreach ($projectTemplateModuleList["fixed"]["data"] as $item) {
            //$name = $item["code"] === "project" ? L("Setting") : L(ucfirst($item["code"]));
            //$url = $item["code"] === "project" ? rebuild_url(U('/project/overview'), $projectId) : rebuild_url(U('/project/' . $item["code"]), $projectId);
            if ($item["code"] === "project") {
                $name = L("Setting");
                $item["code"] = "overview";
                $url = rebuild_url(U('/project/overview'), $projectId);
            } else {
                $name = L(ucfirst($item["code"]));
                $url = rebuild_url(U('/project/' . $item["code"]), $projectId);
            }

            if ($item["id"] == $moduleId) {
                if ($menuName !== 'project_detail') {
                    $url = '#';
                }
                $projectNavigationIndex[$item["id"]] = [
                    "module_id" => $item["id"],
                    "name" => $name,
                    "code" => $item["code"],
                    "type" => 'fixed',
                    'url' => $url,
                    'active' => 'yes'
                ];
            } else if (in_array($item["id"], $navigationAllowShow) || $item["code"] === "overview") {
                // project 信息管理页面必须存在
                $projectNavigationIndex[$item["id"]] = [
                    "module_id" => $item["id"],
                    "name" => $name,
                    "code" => $item["code"],
                    "type" => 'fixed',
                    'url' => $url,
                    'active' => 'no'
                ];
            }
        }

        // 动态模块数据
        foreach ($projectTemplateModuleList["entity"]["data"] as $item) {
            $active = $item["id"] == $moduleId ? 'yes' : 'no';
            if ($item["id"] == $moduleId && $menuName !== 'project_detail') {
                $url = '#';
            } else {
                $url = rebuild_url(U('/project/entity'), $item["id"] . '-' . $projectId);
            }
            $projectNavigationIndex[$item["id"]] = [
                "module_id" => $item["id"],
                "name" => L(ucfirst($item["code"])),
                "code" => $item["code"],
                "type" => 'entity',
                'url' => $url,
                'active' => $active
            ];
        }

        // 获取云盘模块数据
        $diskService = new DiskService();
        $couldDiskSettings = $diskService->getCloudDiskConfig();
        if ($couldDiskSettings["open_cloud_disk"] == 1) {
            $active = 'cloud_disk' === $moduleId ? 'yes' : 'no';
            $projectNavigationIndex['cloud_disk'] = build_cloud_disk_menu_data($active, $projectId);
        }

        // 根据配置顺序生成导航数据
        $projectNavigation = [];
        $includeProjectModule = false;
        foreach ($navigationConfig as $item) {
            if ($item["code"] === "overview") {
                $includeProjectModule = true;
            }
            array_push($projectNavigation, $projectNavigationIndex[$item["module_id"]]);
        }

        // project首页设置模块为必选项
        if (!$includeProjectModule) {
            array_unshift($projectNavigation, $projectNavigationIndex[20]);
        }

        return $projectNavigation;
    }

    /**
     * 获取项目导航模块列表
     * @param $templateId
     * @return array
     */
    public function getProjectNavModuleList($templateId)
    {
        $schemaService = new SchemaService();
        $projectTemplateModuleList = $schemaService->getProjectTemplateModuleList($templateId);
        $projectNavModuleList = [];
        foreach ($projectTemplateModuleList["fixed"]["data"] as $item) {
            if ($item["code"] !== "entity") {
                $name = $item["code"] === "project" ? L("Setting") : L(ucfirst($item["code"]));
                array_push($projectNavModuleList, [
                    "module_id" => $item["id"],
                    "icon" => $item["icon"],
                    "name" => $name,
                    "code" => $item["code"],
                    "module_name" => $projectTemplateModuleList["fixed"]["title"],
                    "type" => 'fixed',
                ]);
            }
        }
        foreach ($projectTemplateModuleList["entity"]["data"] as $item) {
            array_push($projectNavModuleList, [
                "module_id" => $item["id"],
                "icon" => $item["icon"],
                "name" => L(ucfirst($item["code"])),
                "code" => $item["code"],
                "module_name" => $projectTemplateModuleList["entity"]["title"],
                "type" => 'entity',
            ]);
        }

        // 判断云盘是否打开
        $diskService = new DiskService();
        $couldDiskSettings = $diskService->getCloudDiskConfig();
        if ($couldDiskSettings["open_cloud_disk"] == 1) {
            array_push($projectNavModuleList, [
                "module_id" => 'cloud_disk',
                "icon" => 'icon-uniE6D7',
                "name" => L("Cloud_Disk"),
                "code" => 'cloud_disk',
                "module_name" => L("Cloud_Disk"),
                "type" => 'other_page',
            ]);
        }

        return $projectNavModuleList;
    }
}