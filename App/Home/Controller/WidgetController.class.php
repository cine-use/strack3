<?php

namespace Home\Controller;
// +----------------------------------------------------------------------
// | 控件数据控制层
// +----------------------------------------------------------------------

use Common\Controller\VerifyController;
use Common\Model\EntityModel;
use Common\Model\ProjectModel;
use Common\Model\RoleModel;
use Common\Model\VariableValueModel;
use Common\Service\ActionService;
use Common\Service\CommonService;
use Common\Service\EntityService;
use Common\Service\HorizontalService;
use Common\Service\MediaService;
use Common\Service\MemberService;
use Common\Service\MessageService;
use Common\Service\OptionsService;
use Common\Service\SchemaService;
use Common\Service\DiskService;
use Common\Service\ProjectService;
use Common\Service\StatusService;
use Common\Service\StepService;
use Common\Service\TagService;
use Common\Service\TemplateService;
use Common\Service\TimelogService;
use Common\Service\UserService;
use Common\Service\VariableService;


class WidgetController extends VerifyController
{
    /**
     * 系统图标列表
     */
    public function getIconList()
    {
        $iconData = icon_data();
        return json($iconData);
    }

    /**
     * 状态从属关系
     */
    public function getStatusList()
    {
        $statusService = new StatusService();
        $statusData = $statusService->getStatusList();
        return json($statusData);
    }

    /**
     * 状态从属关系
     */
    public function getStatusCorresponds()
    {
        $correspondsData = status_corresponds_data();
        return json($correspondsData);
    }

    /**
     * 作用范围
     */
    public function getScopeAction()
    {
        $scopeList = ['all', 'current'];
        $scopeData = [];
        foreach ($scopeList as $item) {
            array_push($scopeData, get_scope_action($item));
        }
        return json($scopeData);
    }

    /**
     * 日期选择框类型
     */
    public function getDateboxType()
    {
        $typeList = ['datebox', 'datetimebox'];
        $typeData = [];
        foreach ($typeList as $item) {
            array_push($typeData, datebox_type($item));
        }
        return json($typeData);
    }

    /**
     * 获取Tag 类型列表
     */
    public function getTagTypeList()
    {
        $typeList = ['system', 'review', 'approve', 'publish', 'custom'];
        $typeData = [];
        foreach ($typeList as $item) {
            array_push($typeData, tag_type($item));
        }
        return json($typeData);
    }

    /**
     * 获取系统模式配置列表
     */
    public function getSystemModeList()
    {
        $typeList = ['strack', 'liber'];
        $typeData = [];
        foreach ($typeList as $item) {
            array_push($typeData, system_mode_type($item));
        }
        return json($typeData);
    }

    /**
     * 获取过滤tag颜色列表
     */
    public function getFilterColorList()
    {
        $colorList = ['red', 'orange', 'olive', 'green', 'teal', 'blue', 'violet', 'purple', 'pink', 'brown', 'grey', 'black'];
        $colorData = [];
        foreach ($colorList as $item) {
            array_push($colorData, filter_color($item));
        }
        return json($colorData);
    }

    /**
     * 是否置顶
     */
    public function getStickType()
    {
        $stickList = ['yes', 'no'];
        $stickData = [];
        foreach ($stickList as $item) {
            array_push($stickData, stick_type($item));
        }
        return json($stickData);
    }

    /**
     * 是否分享
     */
    public function getPublicType()
    {
        $stickList = ['yes', 'no'];
        $stickData = [];
        foreach ($stickList as $item) {
            array_push($stickData, public_type($item));
        }
        return json($stickData);
    }

    /**
     * 获取语言包列表
     */
    public function getLangList()
    {
        $langList = ["zh-cn", "en-us"];
        $langData = [];
        foreach ($langList as $lang) {
            array_push($langData, get_lang_package($lang));
        }
        return json($langData);
    }

    /**
     * 获取时区列表
     */
    public function getTimezoneList()
    {
        $resData = timezone_data();
        return json($resData);
    }

    /**
     * 获取排序规则
     */
    public function getSortList()
    {
        $sortIds = ['asc', 'desc'];
        $resData = [];
        foreach ($sortIds as $sortId) {
            array_push($resData, sort_type($sortId));
        }
        return json($resData);
    }

    /**
     * 获取优先级
     */
    public function getPriorityList()
    {
        $sortIds = ['normal', 'urgent', 'high', 'medium', 'low'];
        $resData = [];
        foreach ($sortIds as $sortId) {
            array_push($resData, get_priority($sortId));
        }
        return $resData;
    }

    /**
     * 获取置顶列表
     */
    public function getStickList()
    {
        $stickIds = ['yes', 'no'];
        $resData = [];
        foreach ($stickIds as $stickId) {
            array_push($resData, stick_type($stickId));
        }
        return $resData;
    }

    /**
     * 获取动态类型
     * @return array
     */
    public function getNoteType()
    {
        $typeIds = ['text', 'audio'];
        $resData = [];
        foreach ($typeIds as $typeId) {
            array_push($resData, get_note_type($typeId));
        }
        return $resData;
    }

    /**
     * 获取掩码规则列表
     */
    public function getInputMaskList()
    {
        $inputMaskIds = ['arbitrary', 'integer_no_range', 'letter_no_range', 'url', 'ip', 'email', 'mac', 'decimal', 'integer', 'percentage', 'phone', 'range', 'alphaDash', 'resolution', 'timecode', 'cropping'];
        $resData = [];
        foreach ($inputMaskIds as $inputMaskId) {
            array_push($resData, input_mask_rule($inputMaskId));
        }
        return json($resData);
    }

    /**
     * 获取用户状态Combobox
     * @return array
     */
    public function getUserStatusCombobox()
    {
        $resData = [];
        foreach (['in_service', 'departing'] as $item) {
            array_push($resData, get_user_status($item));
        }
        return $resData;
    }

    /**
     * 获取邮件安全链接下拉列表
     * @return array
     */
    public function getSmtpSecureList()
    {
        $secureIds = ['ssl', 'tls'];
        $resData = [];
        foreach ($secureIds as $secureId) {
            array_push($resData, get_smtp_secure($secureId));
        }
        return $resData;
    }

    /**
     * 获取水平管理列表
     */
    public function getHorizontalRelationList()
    {
        $param = $this->request->param();
        $horizontalService = new HorizontalService();
        $resData = $horizontalService->getHorizontalRelationList($param);
        return json($resData);
    }

    /**
     * 获取项目状态Combobox列表
     */
    public function getProjectStatusCombobox()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getProjectStatusCombobox($param);
        return json($resData);
    }

    /**
     * 获取磁盘Combobox列表
     */
    public function getDiskCombobox()
    {
        $diskService = new DiskService();
        $resData = $diskService->getDiskCombobox();
        return json($resData);
    }

    /**
     * 获取动作类型Combobox
     */
    public function getActionType()
    {
        $typeIds = ['launcher', 'plugin', 'tool', 'service'];
        $resData = [];
        foreach ($typeIds as $typeId) {
            array_push($resData, get_action_type($typeId));
        }
        return $resData;
    }

    /**
     * 获取标签类型Combobox
     */
    public function getTagType()
    {
        $typeIds = ['system', 'review', 'publish', 'approve', 'custom'];
        $resData = [];
        foreach ($typeIds as $typeId) {
            array_push($resData, get_tag_type($typeId));
        }
        return $resData;
    }

    /**
     * 获取顶部右侧信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getTopRightData()
    {
        $param = $this->request->param();

        $userId = session("user_id");
        $moduleId = C("MODULE_ID")["user"];

        // 获取用户信息
        $userService = new UserService();
        $userData = $userService->getUserInfo($userId);

        // 获取用户头像
        $mediaService = new MediaService();
        $userData['avatar'] = $mediaService->getSpecifySizeThumbPath(['link_id' => $userId, 'module_id' => $moduleId], '90x90');

        // 获取激活timer数据
        $timeLogService = new TimelogService();
        $timeLogData = $timeLogService->getCurrentTimerNumber($userId);

        // 获取是否是示例项目
        if ($param["project_id"] > 0) {
            $projectService = new ProjectService();
            $projectData = $projectService->checkIsDemoProject($param["project_id"]);
        } else {
            $projectData = [];
        }

        // 获取消息数据
        $messageService = new MessageService();
        $messageData = $messageService->getUnReadNumber($userId);

        // 组装返回数据
        $resData = ["user_data" => $userData, "project_data" => $projectData, "timer_number" => $timeLogData, "message_data" => $messageData];

        // 返回数据
        return json($resData);
    }

    /**
     * 添加或者修改dialog编辑数据
     */
    public function updateItemDialog()
    {
        // 参数数据
        $requestParam = $this->request->param();
        $param = $requestParam["param"];
        $updateData = $requestParam["data"];

        $entityService = new EntityService();
        // 获取模块code
        $schemaService = new SchemaService();
        $moduleCodeMap = $schemaService->getModuleMapData("code");
        $moduleIdMap = $schemaService->getModuleMapData("id");

        if ($param["page"] === "details_correlation_base") {
            $param["module_id"] = C("MODULE_ID")["base"];
        }

        $moduleData = $moduleIdMap[$param["module_id"]];

        $resData = [];
        switch ($param["type"]) {
            case "combobox_add_panel":

                // 获取当前的module数据
                $currentModuleData = $moduleCodeMap[$param["module_code"]];

                // 组装保存数据格式
                $param["current_module"] = $currentModuleData;
                $requestData = $entityService->generateModifyBatchDataFormat($updateData, $param);
                $moduleCode = $currentModuleData["type"] === "entity" ? $currentModuleData["type"] : $currentModuleData["code"];

                $param["form_module_data"] = $moduleData;
                // 调用添加方法
                $commonService = new CommonService(string_initial_letter($moduleCode));
                $resData = $commonService->saveNewItemDialog($requestData, $param);
                break;
            default :
                // 组装保存数据格式
                $param["current_module"] = $moduleData;
                $requestData = $entityService->generateModifyBatchDataFormat($updateData, $param);

                $moduleCode = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];
                $param["module"] = $moduleCode;
                $commonService = new CommonService(string_initial_letter($moduleCode));
                switch ($param["mode"]) {
                    case "create":
                        // 先判断当前得模块是否在表名得数组中，如果存在继续执行；不存在返回错误提示
                        $resData = $commonService->addItemDialog($requestData, $param); // 调用添加方法
                        break;
                    case "modify":
                        $resData = $commonService->modifyItemDialog($requestData, $param); // 调用修改方法
                        break;
                }
                break;
        }

        return json($resData);
    }

    /**
     * 更新控件值
     */
    public function updateWidget()
    {
        $param = $this->request->param();

        switch ($param["module"]) {
            case "variable_value":
                $variableValueModel = new VariableValueModel();
                if (!array_key_exists("data_source", $param)) {
                    $param["data_source"] = "";
                }
                switch ($param['editor']) {
                    case "combobox":
                    case "checkbox":
                    case "tagbox":
                        if (in_array($param["data_source"], ["horizontal_relationship", "belong_to"])) {
                            $variableService = new VariableService();
                            $variableConfig = $variableService->getVariableConfig($param['variable_id']);

                            $relationModuleCode = array_key_exists("relation_module_code", $variableConfig) ? $variableConfig["relation_module_code"] : "";
                            $updateData = [
                                "editor" => $param['editor'],
                                "link_id" => $param['primary_value'],
                                "module_id" => $param['module_id'],
                                "field_type" => $variableConfig['type'],
                                "value" => $param["val"],
                                "relation_module_id" => $variableConfig["relation_module_id"],
                                "relation_module_code" => $relationModuleCode,
                                "variable_id" => $param['variable_id']
                            ];
                        } else {
                            $variableValueData = $variableValueModel->findData([
                                'filter' => ['variable_id' => $param['variable_id'], "link_id" => $param['primary_value']]
                            ]);
                            $updateData = [
                                "value" => $param['val'],
                                "id" => $variableValueData['id']
                            ];
                        }
                        break;
                    case "datebox":
                    case "datetimebox":
                        $variableValueData = $variableValueModel->findData(['filter' => ['variable_id' => $param['variable_id'], "link_id" => $param['primary_value']]]);
                        $updateData = [
                            "value" => strtotime($param['val']),
                            "id" => $variableValueData['id']
                        ];
                        break;
                    default:
                        $variableValueData = $variableValueModel->findData(['filter' => ['variable_id' => $param['variable_id'], "link_id" => $param['primary_value']]]);
                        $updateData = [
                            "value" => $param['val'],
                            "id" => $variableValueData['id']
                        ];
                }
                break;
            default:
                $entityModel = new EntityModel();
                switch ($param['module']) {
                    case "entity":
                        $schemaService = new SchemaService();
                        $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
                        $prefixName = $param['module'] . '_';
                        $field = str_replace($prefixName, "", $param['field']);
                        if ($moduleData["code"] === $param["module_code"] || $param["data_source"] !== "entity") {
                            $updateData = [
                                $field => $param['val'],
                                "id" => $param['primary_value']
                            ];
                        } else {
                            $parentModuleId = $entityModel->where(["id" => $param['val']])->getField("module_id");
                            $updateData = [
                                "parent_id" => $param['val'],
                                "parent_module_id" => $parentModuleId,
                                "id" => $param['primary_value']
                            ];
                        }
                        break;
                    case "tag_link":
                    case "tag":
                        $updateData = [
                            "tag_id" => $param['val'],
                            "link_id" => $param['primary_value'],
                            "module_id" => $param['module_id']
                        ];
                        $param['table'] = "TagLink";
                        break;
                    case "base":
                        if ($param["field"] === "entity_id") {
                            $moduleId = $entityModel->where(["id" => $param['val']])->getField("module_id");
                            $updateData = [
                                $param['field'] => $param['val'],
                                "id" => $param['primary_value'],
                                "entity_module_id" => $moduleId,
                            ];
                        } else {
                            $updateData = [
                                $param['field'] => $param['val'],
                                "id" => $param['primary_value']
                            ];
                        }
                        break;
                    default:
                        $updateData = [
                            $param['field'] => $param['val'],
                            "id" => $param['primary_value']
                        ];
                        break;
                }
                break;
        }
        $commonService = new CommonService(string_initial_letter($param['table']));
        $resData = $commonService->updateWidget($param, $updateData); // 调用修改方法
        return json($resData);
    }

    /**
     * 删除表格数据
     * @return \Think\Response
     * @throws \Exception
     */
    public function deleteGridData()
    {
        $param = $this->request->param();
        $requestParam = $param['param'];
        $requestParam["primary_ids"] = $param["primary_ids"];

        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $requestParam["module_id"]]);

        $moduleCode = $moduleData['type'] === 'entity' ? $moduleData['type'] : $moduleData['code'];
        if ($requestParam["module_code"] == "project") {
            $moduleCode = "project_member";
        }

        // 调用删除方法
        $commonService = new CommonService(string_initial_letter($moduleCode));
        $resData = $commonService->deleteGridData($requestParam);

        return json($resData);
    }


    /**
     * 获取水平关联目标数据
     * @param $filterData
     * @param string $mode
     * @param string $searchValue
     * @return array
     */
    protected function getHorizontalRelationDestData($filterData, $mode = '', $searchValue = '')
    {
        if (array_key_exists("horizontal_type", $filterData) && $filterData["horizontal_type"] === "entity_child") {
            $serviceClass = new EntityService();
        } else {
            // 获取当前水平关联模块信息
            $schemaService = new SchemaService();
            $dstModuleData = $schemaService->getModuleFindData([
                "id" => $filterData["dst_module_id"]
            ]);

            // 工具栏按钮，如果没有传入已经存在的水平关联数据则查询
            if ($mode === "all" && $filterData["from"] === "toolbar" && empty($filterData["link_data"])) {
                $horizontalService = new HorizontalService();
                $filterData["link_data"] = $horizontalService->getModuleRelationIds([
                    "src_link_id" => $filterData["src_link_id"],
                    "src_module_id" => $filterData["src_module_id"],
                    "dst_module_id" => $filterData["src_module_id"],
                ], "dst_link_id");
            }

            if ($dstModuleData["type"] === "entity") {
                $serviceClass = new EntityService();
            } else {
                $serviceClassName = '\\Common\\Service\\' . string_initial_letter($dstModuleData["code"]) . 'Service';
                $serviceClass = new $serviceClassName();
            }
        }

        // 获取当前水平关联数据
        $horizontalRelationData = $serviceClass->getHRelationSourceData($filterData, $searchValue, $mode);

        return $horizontalRelationData;
    }

    /**
     * 获取组件数据
     */
    public function getWidgetData()
    {
        $param = $this->request->param();

        switch ($param['field_type']) {
            case "custom":
                // 自定义字段
                switch ($param["data_source"]) {
                    case "horizontal_relationship":
                        // 获取当前水平关联自定义数据
                        $variableService = new VariableService();
                        $VariableConfig = $variableService->getVariableConfig($param["variable_id"]);

                        $filterData = [
                            "project_id" => $param["project_id"],
                            "src_module_id" => $param["module_id"],
                            "variable_id" => $param["variable_id"],
                            "dst_module_id" => $VariableConfig["relation_module_id"],
                            "src_link_id" => $param["primary"],
                            "link_data" => [],
                            "from" => "widget"
                        ];

                        $horizontalRelationDestData = $this->getHorizontalRelationDestData($filterData, 'all');
                        $resData = $horizontalRelationDestData["rows"];
                        break;
                    default:
                        $variableService = new VariableService();
                        $resData = $variableService->getWidgetData($param['variable_id']);
                        break;
                }
                break;
            default :
                $projectMemberService = new ProjectService();
                switch ($param["data_source"]) {
                    case "status":
                        $statusService = new StatusService();
                        $resData = $statusService->getTemplateStatusList($param);
                        break;
                    case "step":
                        $stepService = new StepService();
                        $resData = $stepService->getTemplateStepList($param);
                        break;
                    case 'priority':
                        $resData = $this->getPriorityList();
                        break;
                    case 'stick':
                    case 'complete':
                        $resData = $this->getStickList();
                        break;
                    case 'note_type':
                        $resData = $this->getNoteType();
                        break;
                    case 'action_type':
                        $resData = $this->getActionType();
                        break;
                    case 'tag_type':
                        $resData = $this->getTagType();
                        break;
                    case "user_status":
                        $resData = $this->getUserStatusCombobox();
                        break;
                    case "public_type":
                        $stickList = ['yes', 'no'];
                        $resData = [];
                        foreach ($stickList as $item) {
                            array_push($resData, public_type($item));
                        }
                        break;
                    case 'user_id':
                        $resData = $projectMemberService->getProjectMemberCombobox($param["project_id"], true);
                        break;
                    case 'belong_id':
                        $resData = $projectMemberService->getProjectMemberCombobox($param["project_id"]);
                        break;
                    case 'status_corresponds':
                        $resData = status_corresponds_data();
                        break;
                    case 'icon':
                        $iconData = icon_data();
                        $resData = [];
                        foreach ($iconData as $item) {
                            array_push($resData, ["id" => $item["id"], "name" => $item["icon"]]);
                        }
                        break;
                    default:
                        $resData = $this->getComboboxList($param);
                        break;
                }
                break;
        }
        return json($resData);
    }

    /**
     * 获取 Combobox List 列表
     * @param $param
     * @return array
     */
    private function getComboboxList($param)
    {
        $filter = [];
        $fields = "";
        $schemaService = new SchemaService();
        switch ($param["data_source"]) {
            case "user":
                $filter = ["id" => ["NOT IN", "1,2"]];
                break;
            case "entity_parent":
            case "entity":
                if (array_key_exists("project_id", $param)) {
                    $filter["project_id"] = $param['project_id'];
                }

                if (array_key_exists("entity_module_id", $param)) {
                    $filter["module_id"] = $param['entity_module_id'];
                } else {
                    $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
                    if ($moduleData["type"] === "entity") {
                        $parentModule = $schemaService->getEntityBelongParentModule(["module_code" => $moduleData["code"]]);
                        $filter["module_id"] = $parentModule['id'];
                    }
                }

                $fields = 'id,name,module_id';
                break;
        }

        $moduleCode = $param["data_source"] === "entity_parent" ? "entity" : $param["data_source"];

        $class = '\\Common\\Model\\' . string_initial_letter($moduleCode) . 'Model';
        $modelObj = new $class();
        $listData = $modelObj->selectData([
            'filter' => $filter,
            'fields' => $fields
        ]);

        if (array_key_exists('add_default', $param) && $param['add_default'] === 'no') {
            $list = [];
        } else {
            $list = [
                [
                    'id' => 0,
                    'name' => L("Empty_Default"),
                ]
            ];
        }

        $moduleIdMap = $schemaService->getModuleMapData("id");
        foreach ($listData["rows"] as $item) {
            if (in_array($param["data_source"], ["entity", "entity_parent"])) {
                $tempItem = [
                    'id' => $item["id"],
                    'name' => $item["name"],
                    'module_id' => $item["module_id"],
                    'group' => L($moduleIdMap[$item["module_id"]]["code"]),
                ];

            } else {
                $tempItem = [
                    'id' => $item["id"],
                    'name' => $item["name"]
                ];
            }
            array_push($list, $tempItem);
        }

        return $list;
    }

    /**
     * 获取工序Combobox列表
     * @return array
     */
    public function getEntityStepList()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $templateData = $projectService->getTemplateData($param["project_id"]);
        $options = [
            'category' => 'step',
            'module_code' => $param["module_code"],
            'template_id' => $templateData["id"],
        ];
        $templateService = new TemplateService();
        $templateStepConfig = $templateService->getTemplateConfig($options);
        $stepList = [];
        foreach ($templateStepConfig as $stepItem) {
            array_push($stepList, [
                'id' => $stepItem["id"],
                'name' => $stepItem["name"],
                'code' => $stepItem["code"],
                'color' => $stepItem["color"]
            ]);
        }
        return json($stepList);
    }

    /**
     * 获取当前行前后项数据
     * @param $moduleType
     * @param $param
     * @return array
     */
    protected function getModuleItemPrevAndNext($moduleType, $param)
    {
        if ($moduleType === "entity") {
            $class = '\\Common\\Model\\EntityModel';
            $prevFilter = [
                "module_id" => $param["module_id"],
                "project_id" => $param["project_id"],
                "id" => ["LT", $param["item_id"]]
            ];
            $nextFilter = [
                "module_id" => $param["module_id"],
                "project_id" => $param["project_id"],
                "id" => ["GT", $param["item_id"]]
            ];
        } else {
            $class = '\\Common\\Model\\' . string_initial_letter($param["module_code"]) . 'Model';
            $prevFilter = [
                "id" => ["LT", $param["item_id"]]
            ];
            $nextFilter = [
                "id" => ["GT", $param["item_id"]]
            ];
        }
        $serviceObj = new $class();

        $prevId = $serviceObj->where($prevFilter)->order("id desc")->limit(1)->getField("id");
        $nextId = $serviceObj->where($nextFilter)->order("id asc")->limit(1)->getField("id");

        $prevOne = $prevId ? $prevId : 0;
        $nextOne = $nextId ? $nextId : 0;

        return ["prev" => $prevOne, "next" => $nextOne];
    }

    /**
     * 获取指定模块详细信息数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getModuleItemInfo()
    {
        $param = $this->request->param();

        if ($param["module_code"] === "correlation_base") {
            $param["module_code"] = "base";
        }

        // 判断表名
        $moduleTable = $param["module_type"] === "entity" ? $param["module_type"] : $param["module_code"];
        // 获取指定数据详情信息
        $commonService = new CommonService(string_initial_letter($moduleTable));
        $resData = $commonService->getModuleItemInfo($param, $moduleTable);

        if ($param["category"] === "top_field") {
            // 获取前后项数据
            $resData["prev_and_next"] = $this->getModuleItemPrevAndNext($param["module_type"], $param);

            // 获取当前项可用动作列表
            $actionService = new ActionService();
            $resData["action_list"] = $actionService->getModuleActionList($param);

            // 获取当前项是否被启用时间日志
            $timelogService = new TimelogService();
            $resData["timelog"] = $timelogService->getModuleTimelogStatus($param);
        }

        $isMyTask = "no";
        if ($param["module_code"] === "base") {
            // 判断当前任务是否属于当前用户
            $memberService = new MemberService();
            $isMyTaskStatus = $memberService->getBelongMyTaskMember(["src_module_id" => $param["module_id"], "src_link_id" => $param["item_id"]]);
            $isMyTask = $isMyTaskStatus["status"];
        }

        $resData["is_my_task"] = $isMyTask;

        return json($resData);
    }

    /**
     * 获取详情页面数据表格
     * @return \Think\Response
     */
    public function getDetailGridData()
    {
        $filterData = $param = $this->request->formatGridParam($this->request->param());

        switch ($filterData["module_type"]) {
            case "entity":
                $entityService = new EntityService();
                $resData = $entityService->getDetailGridData($filterData);
                break;
            case "entity_child":
                $entityService = new EntityService();
                $resData = $entityService->getDetailGridData($filterData);
                break;
            case "horizontal_relationship":
                $moduleCode = $filterData['horizontal_type'] === 'entity' ? 'entity' : 'base';
                $class = '\\Common\\Service\\' . string_initial_letter($moduleCode) . 'Service';
                $serviceObj = new $class();
                $resData = $serviceObj->getDetailGridData($filterData);
                break;
            case "be_horizontal_relationship":
                $moduleCode = $filterData['horizontal_type'] === 'entity' ? 'entity' : 'base';
                $class = '\\Common\\Service\\' . string_initial_letter($moduleCode) . 'Service';
                $serviceObj = new $class();
                $resData = $serviceObj->getDetailGridData($filterData);
                break;
            default:
                if ($filterData["page"] === "details_correlation_base") {
                    $filterData["module_id"] = C("MODULE_ID")["base"];
                    $filterData["module_code"] = "base";
                }
                $class = '\\Common\\Service\\' . string_initial_letter($filterData["module_code"]) . 'Service';
                $serviceObj = new $class();
                $resData = $serviceObj->getDetailGridData($filterData);
        }
        return json($resData);
    }

    /**
     * 获取Note相关组件数据
     * @return \Think\Response
     */
    public function getNoteWidgetData()
    {
        $param = $this->request->param();
        $resData = [];
        switch ($param["area"]) {
            case "stick":
                $resData = $this->getStickList();
                break;
            case "status":
                $filter = [
                    'frozen_module' => 'note',
                    'project_id' => $param["project_id"],

                ];
                $statusService = new StatusService();
                $resData = $statusService->getTemplateStatusList($filter);
                break;
            case "tag":
                $tagService = new TagService();
                $resData = $tagService->getTagCombobox();
                break;
        }

        return json($resData);
    }

    /**
     * 获取项目页面顶部信息
     */
    public function getDetailTopInfo()
    {
        $param = $this->request->param();
    }

    /**
     * 获取当前触发Action模块详细信息
     */
    public function getActionModuleData()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(['id' => $param['module_id']]);
        // 记录当前Action点击次数
        $actionService = new ActionService();
        $actionService->recordClicks($param['action_id']);
        return json($moduleData);
    }

    /**
     * 获取指定模块Action面板数据
     */
    public function getSidebarActionData()
    {
        $param = $this->request->param();
        $actionService = new ActionService();
        $resData = $actionService->getSidebarActionData($param);
        return json($resData);
    }

    /**
     * 设置或者取消Action常用属性
     */
    public function setActionCommonStatus()
    {
        $param = $this->request->param();
        $actionService = new ActionService();
        $resData = $actionService->setActionCommonStatus($param);
        return json($resData);
    }

    /**
     * 获取事件服务器地址
     */
    public function getLogServerConfig()
    {
        $optionsService = new OptionsService();
        $logServerConfig = $optionsService->getLogServerStatus();
        if (!empty($logServerConfig)) {
            $logServerConfig["active"] = "yes";
            $logServerConfig["token"] = md5($logServerConfig["access_key"] . $logServerConfig["secret_key"]);
        } else {
            $logServerConfig["active"] = "no";
            $logServerConfig["token"] = "";
        }
        return json($logServerConfig);
    }

    /**
     * 获取数据表格边侧栏数据
     */
    public function getDataGirdSliderData()
    {
        $param = $this->request->param();
        return [];
    }

    /**
     * 获取水平关联目标数据
     */
    public function getHRelationDestData()
    {
        $param = $this->request->formatGridParam($this->request->param(), '');
        $filterData = $param["filter_data"];
        $searchValue = $param["search_val"];
        return $this->getHorizontalRelationDestData($filterData, $param["mode"], $searchValue);
    }

    /**
     * 更新水平关联数据
     */
    public function modifyHRelationDestData()
    {
        $param = $this->request->param();
        $horizontalService = new HorizontalService();
        $resData = $horizontalService->modifyHRelationDestData($param);
        return $resData;
    }

    /**
     * 获取一对多关联数据
     */
    public function getHasManyRelationData()
    {
        $param = $param = $this->request->formatGridParam($this->request->param(), '');
        $filterData = $param["filter_data"];
        $searchValue = $param["search_val"];
        $mode = $param["mode"];

        $serviceClassName = '\\Common\\Service\\' . string_initial_letter($filterData["field_table"]) . 'Service';
        $serviceClass = new $serviceClassName();

        // 获取一对多关联数据
        $hasManyRelationData = $serviceClass->getHasManyRelationData($filterData, $searchValue, $mode);

        return $hasManyRelationData;
    }

    /**
     * 保存修改一对多关联数据
     */
    public function modifyHasManyRelationData()
    {
        $param = $this->request->param();

        $serviceClassName = '\\Common\\Service\\' . string_initial_letter($param["param"]["field_table"]) . 'Service';
        $serviceClass = new $serviceClassName();

        $resData = $serviceClass->modifyHasManyRelationData($param);
        return $resData;
    }

    /**
     * 保存公共信息信息
     * @param $param
     * @return \Think\Response
     */
    public function commonAddItem()
    {
        $param = $this->request->param();
        if ($param["param"]["module"] == "tag_link") {
            $param["param"]["module"] = "tag";
        }
        $commonService = new CommonService(string_initial_letter($param["param"]["module"]));
        $resData = $commonService->commonAddItem($param);
        return json($resData);
    }

    /**
     * 获取数据表格边侧栏其他页面数据
     * @return array
     */
    public function getDataGridSliderOtherPageData()
    {
        $param = $this->request->param();
        $resData = [];
        switch ($param["type"]) {
            case "cloud_disk":
                // 获取云盘地址
                $diskService = new DiskService();
                $resData = $diskService->getDataGridSliderOtherPageData($param);
                break;
        }
        return $resData;
    }

    /**
     * 获取自定义字段配置
     * @return mixed
     */
    public function getCustomFieldsConfig()
    {
        $param = $this->request->param();
        $variableService = new VariableService();
        $resData = $variableService->getVariableConfig($param["variable_id"]);
        return json($resData);
    }

    /**
     * 获取角色列表
     */
    public function getRoleList()
    {
        $roleModel = new RoleModel();
        $resData = $roleModel->selectData([]);
        return json($resData["rows"]);
    }

    /**
     * 获取项目列表
     */
    public function getProjectList()
    {
        $projectModel = new ProjectModel();
        $resData = $projectModel->selectData();
        return json($resData["rows"]);
    }
}