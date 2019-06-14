<?php
// +----------------------------------------------------------------------
// | Schema 模型服务
// +----------------------------------------------------------------------
// | 主要服务于Schema数据处理
// +----------------------------------------------------------------------
// | 错误编码头 223xxx
// +----------------------------------------------------------------------

namespace Common\Service;

use Common\Model\ModuleModel;
use Common\Model\ProjectTemplateModel;
use Common\Model\SchemaModel;
use Common\Model\ModuleRelationModel;
use Common\Model\OptionsModel;
use Common\Model\FieldModel;
use Common\Model\PageSchemaUseModel;

class SchemaService
{
    // Field Model 对象
    protected $fieldModel;

    // Schema Model 对象
    protected $schemaModel;

    // Module Model 对象
    protected $moduleModel;

    // Module Relation Model 对象
    protected $moduleRelationModel;

    // Page Schema Use Model 对象
    protected $pageSchemaUseModel;

    // Module Code
    protected $moduleCode = [];

    // Module Type
    protected $moduleType = [];

    // Module Data
    protected $moduleData = [];

    // 屏蔽has many 显示类型
    protected $hasManyDoesNotDisplay = [
        "entity" => ["entity", "base"]
    ];

    // 屏蔽has one 显示类型
    protected $hasOneDoesNotDisplay = [
        "project" => ["project_disk", "project_template"]
    ];

    /**
     * SchemaService constructor.
     */
    public function __construct()
    {
        $this->fieldModel = new FieldModel();
        $this->schemaModel = new SchemaModel();
        $this->moduleModel = new ModuleModel();
        $this->moduleRelationModel = new ModuleRelationModel();
        $this->pageSchemaUseModel = new PageSchemaUseModel();
    }

    /**
     * 获取module数据
     * @param $moduleId $moduleId 查询条件
     * @param string $field 指定查询字段
     * @return array|mixed
     */
    private function getCurrentModuleData($moduleId, $field = '')
    {

        if (empty($field) && array_key_exists($moduleId, $this->moduleData)) {
            return $this->moduleData[$moduleId];
        }

        if ($field == 'code' && array_key_exists($moduleId, $this->moduleCode)) {
            return $this->moduleCode[$moduleId];
        }

        if ($field == 'type' && array_key_exists($moduleId, $this->moduleType)) {
            return $this->moduleType[$moduleId];
        }

        $moduleData = $this->moduleModel->findData(['filter' => ['id' => $moduleId], 'fields' => 'id as module_id,code,type']);

        // 保存到变量
        $this->moduleData[$moduleId] = $moduleData;
        $this->moduleCode[$moduleId] = $moduleData["code"];
        $this->moduleType[$moduleId] = $moduleData["type"];

        if (!empty($field)) {
            return $moduleData[$field];
        } else {
            return $moduleData;
        }
    }

    /**
     * 添加模块
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function addModule($param)
    {
        $authService = new AuthService();
        $resData = $this->moduleModel->addItem($param);
        if (!$resData) {
            // 添加模块失败错误码 001
            throw_strack_exception($this->moduleModel->getError(), 223001);
        } else {
            // 保存实体的权限数据
            if ($resData["type"] !== "fixed") {
                // 保存关联初始配置数据
                $horizontalService = new HorizontalService();
                $horizontalService->addInitialHorizontalConfigData();
                // 保存权限
                $authService->addEntityAuthData($resData);
            }
            // 返回成功数据
            return success_response($this->moduleModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改模块
     * @param $param
     * @return array
     */
    public function modifyModule($param)
    {
        $resData = $this->moduleModel->modifyItem($param);
        if (!$resData) {
            // 修改模块失败错误码 002
            throw_strack_exception($this->moduleModel->getError(), 223002);
        } else {
            // 返回成功数据
            return success_response($this->moduleModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除模块
     * @param $param
     * @return array
     */
    public function deleteModule($param)
    {
        $authService = new AuthService();

        $moduleData = $this->moduleModel->selectData(["filter" => $param, "fields" => "id,type"]);
        $resData = $this->moduleModel->deleteItem($param);
        if (!$resData) {
            // 删除模块失败错误码 003
            throw_strack_exception($this->moduleModel->getError(), 223003);
        } else {
            try {
                foreach ($moduleData["rows"] as $item) {
                    if ($item["type"] == "entity") {
                        $authService->deleteEntityAuthData($item["id"]);
                    }
                }
            } catch (\Exception $e) {

            }
            // 返回成功数据
            return success_response($this->moduleModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 新增Schema数据
     * @param $param
     * @return array
     */
    public function addSchema($param)
    {
        $addData = [
            'name' => $param["name"],
            'code' => $param["code"],
            'type' => $param["type"]
        ];
        $resData = $this->schemaModel->addItem($addData);
        if (!$resData) {
            // 添加Schema失败错误码 005
            throw_strack_exception($this->schemaModel->getError(), 223005);
        } else {
            if (isset($param["id"]) && !empty($param["id"])) {
                // 存在schema_id 则拷贝给当前新增的Schema
                $moduleRelationOptions = [
                    'filter' => ["schema_id" => $param["id"]],
                    'fields' => 'type,src_module_id,dst_module_id,link_id,node_config,schema_id'
                ];
                $moduleRelationData = $this->moduleRelationModel->selectData($moduleRelationOptions);
                $newSchemaId = ($this->schemaModel->_resData)["id"];
                if ($moduleRelationData["total"] > 0) {
                    foreach ($moduleRelationData["rows"] as $moduleRelationItem) {
                        $moduleRelationItem["schema_id"] = $newSchemaId;
                        $this->moduleRelationModel->addItem($moduleRelationItem);
                    }
                }
            }
            // 返回成功数据
            return success_response($this->schemaModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改Schema数据
     * @param $param
     * @return array
     */
    public function modifySchema($param)
    {
        $resData = $this->schemaModel->modifyItem($param);
        if (!$resData) {
            // 修改Schema失败错误码 006
            throw_strack_exception($this->schemaModel->getError(), 223006);
        } else {
            // 返回成功数据
            return success_response($this->schemaModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除数据结构，同时删除关联数据结构
     * @param $param
     * @return array
     */
    public function deleteSchema($param)
    {
        $this->schemaModel->startTrans();
        try {
            $schemaResult = $this->schemaModel->deleteItem(["id" => $param["schema_id"]]);
            if (!$schemaResult) {
                throw new \Exception($this->schemaModel->getError());
            } else {
                $moduleRelationResult = $this->moduleRelationModel->deleteItem($param);
                if (!$moduleRelationResult) {
                    throw new \Exception($this->moduleRelationModel->getError());
                }
            }
            $this->schemaModel->commit();
            // 返回成功数据
            return success_response($this->schemaModel->getSuccessMassege());
        } catch (\Exception $e) {
            $this->schemaModel->rollback();
            // 删除Schema失败错误码 007
            throw_strack_exception($e->getMessage(), 223007);
        }
    }

    /**
     * 新增页面使用数据结构配置
     * @param $param
     * @return array
     */
    public function addPageSchemaUse($param)
    {
        $resData = $this->pageSchemaUseModel->addItem($param);
        if (!$resData) {
            // 添加页面使用数据结构配置失败错误码 013
            throw_strack_exception($this->pageSchemaUseModel->getError(), 223013);
        } else {
            // 返回成功数据
            return success_response($this->pageSchemaUseModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改页面使用数据结构配置
     * @param $param
     * @return array
     */
    public function modifyPageSchemaUse($param)
    {
        $resData = $this->pageSchemaUseModel->modifyItem($param);
        if (!$resData) {
            // 修改页面使用数据结构配置失败错误码 014
            throw_strack_exception($this->pageSchemaUseModel->getError(), 223014);
        } else {
            // 返回成功数据
            return success_response($this->pageSchemaUseModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除页面使用数据结构配置
     * @param $param
     * @return array
     */
    public function deletePageSchemaUse($param)
    {
        $resData = $this->pageSchemaUseModel->deleteItem($param);
        if (!$resData) {
            // 删除页面使用数据结构配置失败错误码 015
            throw_strack_exception($this->pageSchemaUseModel->getError(), 223015);
        } else {
            // 返回成功数据
            return success_response($this->pageSchemaUseModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取模块数据
     * @param $param
     * @return array
     */
    public function getModuleData($param = [])
    {
        if (!empty($param)) {
            $options = [
                'page' => [$param["page"], $param["rows"]],
                'oder' => 'type asc'
            ];
        } else {
            $options = [];
        }
        return $this->moduleModel->selectData($options);
    }

    /**
     * 获取单个模块数据
     * @param $filter
     * @return mixed
     */
    public function getModuleFindData($filter)
    {
        $resData = $this->moduleModel->findData(['filter' => $filter]);
        return $resData;
    }

    /**
     * 获取module字段数据
     * @param array $options
     * @param string $field
     * @return array
     */
    public function getModuleMapData($field = "code", $options = [])
    {
        // 获取module字典信息
        $moduleList = $this->moduleModel->selectData($options);
        $moduleMapData = array_column($moduleList["rows"], null, $field);
        return $moduleMapData;
    }

    /**
     * 获取固定模块列表
     * @return array
     */
    public function getFixedModuleList()
    {
        $tableData = $this->fieldModel->getTables();

        //已经添加的固定模块
        $options = [
            'fields' => 'code',
            'filter' => ["type" => "fixed"]
        ];

        $existFixedModuleData = $this->moduleModel->selectData($options);
        $existFixedModuleLists = [];
        foreach ($existFixedModuleData["rows"] as $item) {
            array_push($existFixedModuleLists, $item["code"]);
        }

        //去掉strack_前缀
        $fixedModuleList = [];
        foreach ($tableData as $tableItem) {
            $moduleItem = str_replace('strack_', '', $tableItem);
            if (!in_array($moduleItem, $existFixedModuleLists)) {
                array_push($fixedModuleList, [
                    'id' => $moduleItem,
                    'name' => $moduleItem,
                ]);
            }
        }

        return $fixedModuleList;
    }

    /**
     * 获取Schema数据
     * @param $param
     * @return mixed
     */
    public function getSchemaList($param)
    {
        $options = [];
        if (isset($param['filter']) && !empty($param['filter'])) {
            $options = [
                'filter' => ['name' => ['LIKE', "%{$param['filter']}%"]]
            ];
        }
        $resData = $this->schemaModel->selectData($options);
        return $resData["rows"];
    }

    /**
     * 获取项目模板可配置模块列表
     * @param $templateId
     * @return array
     */
    public function getProjectTemplateModuleList($templateId)
    {
        // 获取当前template使用的schema_id
        $projectTemplateModel = new ProjectTemplateModel();
        $schemaId = $projectTemplateModel->where(["id" => $templateId])->getField("schema_id");

        // 获取Schema Name
        $schemaName = $this->schemaModel->where(["id" => $schemaId])->getField("name");

        // 获取当前结构module_id
        $moduleIdData = $this->moduleRelationModel->field("src_module_id,dst_module_id")->where(["schema_id" => $schemaId])->select();

        // module id去重
        $moduleIds = [];
        foreach ($moduleIdData as $moduleIdItem) {
            if (!in_array($moduleIdItem["src_module_id"], $moduleIds)) {
                array_push($moduleIds, $moduleIdItem["src_module_id"]);
            }
            if (!in_array($moduleIdItem["dst_module_id"], $moduleIds)) {
                array_push($moduleIds, $moduleIdItem["dst_module_id"]);
            }
        }

        // 分为固定字段和entity固定字段
        $templateModuleList = [
            'schema_name' => $schemaName,
            'fixed' => [
                'title' => L("Fixed_Module"),
                'data' => []
            ],
            'entity' => [
                'title' => L("Dynamic_Module"),
                'data' => []
            ]
        ];

        // 查找当前Schema里面数据
        $moduleModel = new ModuleModel();
        $schemaModuleData = $moduleModel->where(["id" => ["IN", join(",", $moduleIds)]])->select();

        // 填入动态模块
        foreach ($schemaModuleData as $schemaModuleItem) {
            if ($schemaModuleItem["type"] === "entity") {
                $schemaModuleItem["name"] = L(ucfirst($schemaModuleItem["code"]));
                array_push($templateModuleList["entity"]["data"], $schemaModuleItem);
            }
        }

        // 允许项目配置的固定模块
        $allowFixedModuleList = [
            'project', // 项目概况
            'base', // 任务
            'note', // 动态
            'file', // 文件
            'file_commit', // 提交文件（1.0的版本）
            'onset', //前期数据
            'timelog', // 时间日志
            'media',
            //'entity' // shot asset 等动态模块
        ];

        $fixedModuleData = $moduleModel->where(["type" => "fixed"])->select();

        // 整理模块
        foreach ($fixedModuleData as $fixedModuleItem) {
            if (in_array($fixedModuleItem["code"], $allowFixedModuleList)) {
                $fixedModuleItem["name"] = L(ucfirst($fixedModuleItem["code"]));
                if ($fixedModuleItem["code"] === "project") {
                    // 把项目模块置顶
                    array_unshift($templateModuleList["fixed"]["data"], $fixedModuleItem);
                } else {
                    array_push($templateModuleList["fixed"]["data"], $fixedModuleItem);
                }
            }
        }

        return $templateModuleList;
    }

    /**
     * 获取Schema Combobox数据列表
     * @return array
     */
    public function getSchemaCombobox()
    {
        $resData = $this->schemaModel->selectData();
        $schemaCombobox = [];
        foreach ($resData["rows"] as $schemaItem) {
            array_push($schemaCombobox, [
                'id' => $schemaItem['id'],
                'name' => $schemaItem['name']
            ]);
        }
        return $schemaCombobox;
    }

    /**
     * 获取Schema模型列表
     * @param $schemaId
     * @return array
     */
    public function getSchemaModuleList($schemaId)
    {
        //获取module列表
        $moduleOptions = [
            'oder' => 'type asc'
        ];
        $moduleData = $this->moduleModel->selectData($moduleOptions);
        $moduleList = [];
        if ($moduleData["total"] > 0) {
            foreach ($moduleData["rows"] as $moduleItem) {
                if (array_key_exists($moduleItem["type"], $moduleList)) {
                    array_push($moduleList[$moduleItem["type"]], $moduleItem);
                } else {
                    $moduleList[$moduleItem["type"]] = [$moduleItem];
                }
            }
        }
        // 获取当前数据结构保存的树
        $moduleRelationOptions = [
            'filter' => ["schema_id" => $schemaId]
        ];
        $moduleRelationData = $this->moduleRelationModel->selectData($moduleRelationOptions);
        $schemaList = [
            "nodes" => [],
            "edges" => [],
            "ports" => [],
            "groups" => [],
        ];
        if ($moduleRelationData["total"] > 0) {
            foreach ($moduleRelationData["rows"] as $moduleRelationItem) {
                //$nodeConfig = json_decode($moduleRelationItem['node_config'], true);
                $nodeConfig = $moduleRelationItem['node_config'];
                if (array_key_exists('source', $nodeConfig["node_data"])) {
                    array_push($schemaList["nodes"], $nodeConfig["node_data"]['source']);
                }
                if (array_key_exists('target', $nodeConfig["node_data"])) {
                    array_push($schemaList["nodes"], $nodeConfig["node_data"]['target']);
                }
                if (array_key_exists("edges", $nodeConfig)) {
                    array_push($schemaList["edges"], $nodeConfig['edges']);
                }
            }
        }

        return ["total" => $moduleData["total"], "module_list" => $moduleList, "schema_list" => $schemaList];
    }

    /**
     * 保存关联模块设置
     * @param $param
     * @return array
     */
    public function saveModuleRelation($param)
    {
        $message = "";
        $this->moduleRelationModel->startTrans();
        try {
            //删除当前结构的数据
            $deleteOptions = [
                'schema_id' => $param["schema_id"]
            ];
            $this->moduleRelationModel->deleteItem($deleteOptions);

            //新增管理数据结构
            foreach ($param["schema_data"] as $item) {
                $source = $item['node_config']['node_data']["source"];
                $target = $item['node_config']['node_data']["target"];
                if ($item['type'] == 'belong_to') {
                    if ($source["module_type"] == "entity" && $target["module_type"] == "entity") {
                        $linkId = "parent_id";
                    } else {
                        $moduleCode = $target["module_type"] == "entity" ? $target["module_type"] : $target["module_code"];
                        if ($moduleCode === "module" && $source["module_code"] == "base") {
                            $linkId = "entity_module_id";
                        } else {
                            $linkId = $moduleCode . "_id";
                        }
                    }
                } elseif ($item['type'] == 'has_one') {
                    $sourceCode = $source["module_type"] == "entity" ? $source["module_type"] : $source["module_code"];
                    $linkId = $sourceCode . "_id";
                } else {
                    $linkId = "id";
                }

                $item["link_id"] = $linkId;
                $resData = $this->moduleRelationModel->addItem($item);
                if (!$resData) {
                    throw new \Exception();
                }
            }

            $this->moduleRelationModel->commit();
            $message = $this->moduleRelationModel->getSuccessMassege();
        } catch (\Exception $e) {
            $this->moduleRelationModel->rollback();
            // 保存关联模块设置失败错误码 008
            throw_strack_exception($e->getMessage(), 223008);
        }

        // 返回成功数据
        return success_response($message);
    }

    /**
     * 获取实体类型数据结构列表
     * @return array
     */
    public function getEntitySchemaList()
    {
        $options = [
            'filter' => ['type' => 'project']
        ];
        $entityData = $this->schemaModel->selectData($options);
        return $entityData;
    }

    /**
     * 获取语言包模块数据
     * @param $colKey
     * @return array
     */
    public function getLanguageModuleData($colKey)
    {
        $moduleOptions = [
            'filter' => ['type' => 'entity']
        ];
        $moduleData = $this->moduleModel->selectData($moduleOptions);
        //获取当前语言设置
        $optionsModel = new OptionsModel();
        $options = [
            'fields' => 'config',
            'filter' => ['name' => 'lang_settings'],
        ];
        $langSetting = $optionsModel->findData($options);
        $langSettingIndex = [];


        foreach ($langSetting["config"] as $langItem) {
            $langSettingIndex[$langItem["id"]] = $langItem;
        }

        $moduleListGroup = [];
        $existTaskId = [];
        foreach ($moduleData["rows"] as $moduleItem) {
            if (!in_array($moduleItem['id'], $existTaskId)) {
                array_push($existTaskId, $moduleItem['id']);
                foreach ($colKey as $key) {
                    if (array_key_exists($moduleItem['id'], $langSettingIndex)) {
                        if (isset($langSettingIndex[$moduleItem['id']][$key])) {
                            $moduleItem [$key] = $langSettingIndex[$moduleItem['id']][$key];
                        } else {
                            $moduleItem [$key] = $moduleItem['name'];
                        }
                    } else {
                        $moduleItem [$key] = $moduleItem['name'];
                    }
                }
                array_push($moduleListGroup, $moduleItem);
            }
        }

        return $moduleListGroup;
    }

    /**
     * 生成语言包
     * @param $param
     */
    public function saveLanguagePackage($param)
    {
        // 把语言包设置保存到数据库
        $optionsModel = new OptionsModel();
        $optionsModel->updateOptionsData("lang_settings", $param["modules"]);
    }

    /**
     * 获取页面使用数据结构配置列表数据
     * @param $param
     * @return array
     */
    public function getPageSchemaUseGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        return $this->pageSchemaUseModel->selectData($options);
    }

    /**
     * 获取表的所有字段及主键
     * @param $tableName
     * @return mixed
     */
    public function getFieldsConfigInfo($tableName)
    {
        $fieldConfig = $this->fieldModel->getTableFieldsConfig($tableName);

        $primaryKey = "";
        foreach ($fieldConfig as $key => $fieldItem) {
            if (array_key_exists("is_primary_key", $fieldItem) && $fieldItem['is_primary_key'] == "yes") {
                $primaryKey = $fieldItem['id'];
            }
        }
        return ['fields' => $fieldConfig, 'primary_key' => $primaryKey];
    }

    /**
     * 获取页面使用配置单条数据
     * @param $filter
     * @param $fields
     * @return array
     */
    public function getPageSchemaUseFinaData($filter, $fields)
    {
        // 查找页面数据结构设置
        $pageSchemaUseData = $this->pageSchemaUseModel->findData(['filter' => [$filter], 'fields' => $fields]);
        return empty($pageSchemaUseData) ? [] : $pageSchemaUseData;
    }

    /**
     * 获取Schema单条数据
     * @param $filter
     * @return array|mixed
     */
    public function getSchemaData($filter)
    {
        $resData = $this->schemaModel->findData(["filter" => $filter]);
        return $resData;
    }

    /**
     * 获取当前页面
     * @param $moduleType
     * @param $page
     * @param $templateId
     * @return mixed
     */
    public function getPageSchemaId($moduleType, $page, $templateId)
    {
        switch ($moduleType) {
            case "project":
                // 查找项目模板设置
                $projectTemplateModel = new ProjectTemplateModel();
                $projectTemplateData = $projectTemplateModel->findData(['filter' => ['id' => $templateId], 'fields' => 'schema_id']);
                return $projectTemplateData["schema_id"];
            case "system":
            default:
                // 查找页面数据结构设置
                $pageSchemaUseData = $this->pageSchemaUseModel->findData(['filter' => ['page' => $page], 'fields' => 'schema_id']);
                return $pageSchemaUseData["schema_id"];
        }
    }

    /**
     * 获取指定模块的固定字段
     * @param $moduleData
     * @return mixed
     */
    protected function getModuleFixedFields($moduleData)
    {
        // 获取当前模块表名
        $tableName = $moduleData["type"] === 'fixed' ? $moduleData['code'] : $moduleData['type'];

        // 获取当前表内置字段
        return $this->fieldModel->getTableFieldsConfig($tableName, $moduleData);
    }

    /**
     * 获取指定模块的自定义字段
     * @param $moduleData
     * @param int $projectId
     * @return array
     */
    protected function getModuleCustomFields($moduleData, $projectId = 0)
    {
        $variableService = new VariableService();
        $moduleData['project_id'] = $projectId;
        return $variableService->getCustomFields($moduleData);
    }

    /**
     * 获取指定模块所有字段
     * @param $moduleData
     * @param int $projectId
     * @return array
     */
    protected function getModuleAllFields($moduleData, $projectId = 0)
    {
        // 获取当前表内置字段
        $builtInFields = $this->getModuleFixedFields($moduleData);

        // 获取当前表自定义字段
        $customFields = $this->getModuleCustomFields($moduleData, $projectId);

        return array_merge(array_column($builtInFields, null, "id"), array_column($customFields, null, "id"));
    }

    /**
     * 获取指定表的字段
     * @param $moduleData
     * @param $projectId
     * @return array
     */
    public function getTableFieldConfig($moduleData, $projectId = 0)
    {
        // 获取当前表内置字段
        $builtInFields = $this->getModuleFixedFields($moduleData);

        // 获取当前表自定义字段
        $customFields = $this->getModuleCustomFields($moduleData, $projectId);

        return ['built_in' => $builtInFields, 'custom' => $customFields];
    }


    /**
     * 获取指定模块指定表的字段
     * @param $filterModuleKeyList
     * @param $projectIds
     * @return array
     */
    public function getModuleAllCustomFieldConfig($filterModuleKeyList, $projectIds)
    {
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->field("id as module_id,type,name,code")
            ->where(["code" => ["IN", join(",", $filterModuleKeyList)]])
            ->select();

        $moduleAllFieldsMap = [];
        foreach ($moduleData as $moduleItem) {
            $fixedFieldsConfig = $this->getModuleFixedFields($moduleItem);
            $moduleAllFieldsMap[$moduleItem["code"]] = array_column($fixedFieldsConfig, null, "id");
        }

        foreach ($projectIds as $projectId) {
            foreach ($moduleData as $moduleItem) {
                $customFieldsConfig = $this->getModuleCustomFields($moduleItem, $projectId);
                foreach ($customFieldsConfig as $item) {
                    $item["project_id_value"] = $projectId;
                    $moduleAllFieldsMap[$moduleItem["code"]][$item["id"]] = $item;
                }
            }
        }

        return $moduleAllFieldsMap;
    }

    /**
     * 获取数据结构字段
     * @param $param
     * @param $schemaId
     * @return array
     */
    public function getSchemaFields($param, $schemaId)
    {
        // 关联结构数据
        $schemaFields = [];

        // 获取当前模块的 Module 数据
        $moduleMainData = $this->getCurrentModuleData($param["module_id"]);

        $schemaFields[$moduleMainData["code"]]['field_configs'] = $this->getTableFieldConfig($moduleMainData, $param["project_id"]);
        $schemaFields[$moduleMainData["code"]]["code"] = $moduleMainData["code"];
        $schemaFields[$moduleMainData["code"]]["type"] = $moduleMainData["type"];

        // 判断获取主表表名
        $tableName = $moduleMainData["type"] === 'fixed' ? $moduleMainData['code'] : $moduleMainData['type'];

        $fieldConfig = $this->getFieldsConfigInfo($tableName);

        // 数据关联结构
        $relationStructure = [
            'table_name' => $tableName,
            'table_alias' => $moduleMainData['code'],
            'module_type' => $moduleMainData["type"],
            'module_id' => $moduleMainData["module_id"],
            'primary_key' => $fieldConfig['primary_key'],
            'fields' => [],
            'filter' => [],
            'format_list' => [], // 需要格式化的字段
            'relation_join' => [],
            'relation_has_many' => []
        ];

        if ($schemaId > 0) {
            // 获取当前模型所关联的数据表
            $moduleRelationDataConfig = $this->moduleRelationModel->selectData([
                'filter' => ['src_module_id' => $param["module_id"], 'schema_id' => $schemaId],
                'fields' => 'schema_id,link_id,type,src_module_id,dst_module_id,node_config'
            ]);

            // 生成关联表结构
            $relationModuleList = [];
            foreach ($moduleRelationDataConfig["rows"] as $moduleRelationItem) {

                $moduleRelationData = $this->getCurrentModuleData($moduleRelationItem['dst_module_id']);

                // 获取关联模型所有的字段
                $schemaFields[$moduleRelationData["code"]]['field_configs'] = $this->getTableFieldConfig($moduleRelationData, $param["project_id"]);
                $schemaFields[$moduleRelationData["code"]]["code"] = $moduleRelationData["code"];
                $schemaFields[$moduleRelationData["code"]]["type"] = $moduleRelationData["type"];

                $isDirectly = $moduleRelationItem["type"] === "has_many" ? "yes" : "no";
                // 组装关联结构
                $key = $moduleRelationItem["node_config"]["node_data"]['target']['module_code'];

                $relationModuleList[$key] = [
                    'mapping_type' => $moduleRelationItem["type"],
                    'is_directly_relation' => $isDirectly,
                    'module_id' => $moduleRelationItem["dst_module_id"],
                    'foreign_key' => $moduleRelationItem["link_id"],
                    'module_code' => $key,
                    'module_type' => $moduleRelationItem["node_config"]["node_data"]['target']['module_type'],
                    'fields' => []
                ];

                // 如果关联类型是 has_many 判断他是否有 belong_to 关联结构
                if ($moduleRelationItem["type"] == "has_many") {
                    $schemaId = $this->pageSchemaUseModel->checkModuleSchemaExit($moduleRelationData["code"]);
                    if ($schemaId > 0) {
                        // 获取主表表名
                        $hasManyTableName = $moduleRelationData["type"] === 'fixed' ? $moduleRelationData['code'] : $moduleRelationData['type'];
                        // 获取 has many 关联数据显示配置
                        $belongToModel = D('Common/' . camelize($hasManyTableName));
                        $belongToFormat = $belongToModel->_hasManyDataShowFormat;
                        $belongToFormatCode = $belongToFormat["format"]["table"];

                        $belongToModuleData = $this->moduleModel->findData(["filter" => ["code" => $belongToFormatCode], "fields" => "id as module_id,name,code,type"]);

                        if (!empty($belongToModuleData)) {
                            $schemaFields[$belongToFormatCode]['field_configs'] = $this->getTableFieldConfig($belongToModuleData, $param["project_id"]);
                            $schemaFields[$belongToFormatCode]["code"] = $belongToModuleData["code"];
                            $schemaFields[$belongToFormatCode]["type"] = $belongToModuleData["type"];

                            $relationModuleList[$key]["belong_to_config"] = $belongToFormat;
                        }
                    }
                }
            }

            // 关联模型列表
            foreach ($relationModuleList as $key => $moduleItem) {
                switch ($moduleItem["mapping_type"]) {
                    case "has_one":
                    case "belong_to":
                        $relationStructure["relation_join"][$key] = $moduleItem;
                        break;
                    case "has_many":
                    case "many_to_many":
                        $relationStructure["relation_has_many"][$key] = $moduleItem;
                        break;
                }
            }
        }

        $resData = [
            "schema_fields" => $schemaFields,
            "relation_structure" => $relationStructure
        ];

        return $resData;
    }

    /**
     * 获取字段列名称
     * @param $field
     * @param $masterCode
     * @param bool $isEntityBase
     * @return string
     */
    public function getFieldColumnName($field, $masterCode, $isEntityBase = false)
    {
        if ($field["module_code"] !== $masterCode) {
            if (array_key_exists("is_foreign_key", $field) && $field["is_foreign_key"] === "yes") {
                // 外键处理
                if ($field["frozen_module"] === $field["module_code"]) {
                    $fields = "{$field["module_code"]}_{$field["value_show"]}";
                } else {
                    $fields = "{$field["frozen_module"]}_{$field["module_code"]}_{$field["value_show"]}";
                }
            } else if ($field["field_type"] === "custom") {
                // 自定义字段处理
                if (in_array($field["type"], ["belong_to", "horizontal_relationship"])) {
                    $fields = "{$masterCode}_{$field["module_code"]}_{$field["value_show"]}";
                } else {
                    if ($isEntityBase) {
                        $fields = "{$field["module_code"]}_{$field["value_show"]}_value";
                    } else {
                        $fields = "{$masterCode}_{$field["module_code"]}_{$field["value_show"]}_value";
                    }
                }
            } else if (array_key_exists("is_has_many", $field) && $field["is_has_many"]) {
                $fields = "{$masterCode}_{$field["has_many_module"]}";
            } else {
                if (array_key_exists("belong_module", $field)) {
                    if ($field["belong_module"] === "base" && $field["module"] === "module") {
                        $fields = "{$field["belong_module"]}_entity_{$field["module_code"]}_{$field["value_show"]}";
                    } else {
                        $fields = "{$field["belong_module"]}_{$field["module_code"]}_{$field["value_show"]}";
                    }
                } else {
                    $fields = "{$masterCode}_{$field["module_code"]}_{$field["value_show"]}";
                }
            }
            return $fields;
        } else {
            // 主表字段
            if ($field["field_type"] === "custom") {
                // 自定义字段处理
                if (in_array($field["type"], ["belong_to", "horizontal_relationship"])) {
                    $fields = "{$field["module_code"]}_{$field["value_show"]}";
                } else {
                    $fields = "{$field["module_code"]}_{$field["value_show"]}_value";
                }
            } else {
                $fields = $field["module_code"] . "_" . $field["value_show"];
            }
            return $fields;
        }
    }

    /**
     * 获取格式化字段
     * @param $field
     * @return array
     */
    protected function getFieldFormatData($field)
    {
        // 需要显示来源表的数据
        if (array_key_exists("show_from", $field) && !empty($field["show_from"])) {
            return [
                'format' => $field["show_from"],
                'type' => "show_from",
                'data' => []
            ];
        }

        // 需要格式化的字段
        if (!empty($field["format"])) {
            $formatList = [
                'format' => $field["format"],
                'type' => $field["field_type"],
                'data' => []
            ];

            // 自定义字段独有
            if ($field["editor"] === "combobox") {
                $comboboxList = array_key_exists("combobox_list", $field) ? $field["combobox_list"] : [];
                $formatList["data"] = $comboboxList;
            }
            return $formatList;
        }
    }

    /**
     * 获取自定义水平关联字段数据
     * @param $field
     * @return array
     */
    protected function getFieldHorizontal($field)
    {
        // 判断module_code
        $moduleData = $this->getCurrentModuleData($field["relation_module_id"], "");
        $moduleCode = $moduleData['type'] == 'fixed' ? $moduleData['code'] : $moduleData['type'];

        // 获取水平关联字段格式
        $relationData = $this->generateCustomFieldConfig($field, "has_many", "{$moduleCode}_id", $field["type"], $moduleCode);

        $fieldConfig = [];
        // 处理关联表的字段
        $horizontalRelationFieldConfig = $this->getTableFieldConfig($moduleData);
        foreach ($horizontalRelationFieldConfig["built_in"] as $builtInItem) {
            if ($builtInItem["show"] == "yes") {
                // 组装字段格式
                $builtInFieldKey = $builtInItem["module_code"] . "." . $builtInItem['fields'] . " " . $builtInItem["module_code"] . "_" . $builtInItem['fields'];
                // 将字段追加到配置中
                array_push($fieldConfig, [$builtInItem["fields"] => $builtInFieldKey]);
            }
        }

        return ["relation_data" => $relationData, "fields" => $fieldConfig];
    }

    /**
     * 生成自定义字段配置
     * @param $customField
     * @param $mappingType
     * @param $foreignKey
     * @param $fieldType
     * @param $moduleCode
     * @return array
     */
    protected function generateCustomFieldConfig($customField, $mappingType, $foreignKey, $fieldType, $moduleCode)
    {
        // 添加自定义字段表配置
        $customFieldConfig = [
            "mapping_type" => $mappingType,
            "module_id" => $customField['module_id'],
            "belong_module" => $customField['module_code'],
            "relation_module_id" => $customField['relation_module_id'],
            "primary_key" => $customField['module_code'] . "_id",
            "foreign_key" => $foreignKey,
            "module_code" => $moduleCode,
            "module_type" => $fieldType,
            "variable_id" => $customField['variable_id'],
            "field_type" => $customField["type"],
            "fields" => []
        ];
        return $customFieldConfig;
    }

    /**
     * 获取一对多不现实模块配置
     * @param $moduleData
     * @return array|mixed
     */
    protected function getModuleHasManyDoesNotDisplay($moduleData)
    {
        $hasManyDoesNotDisplay = [];
        $moduleKey = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];
        if (array_key_exists($moduleKey, $this->hasManyDoesNotDisplay)) {
            $hasManyDoesNotDisplay = $this->hasManyDoesNotDisplay[$moduleKey];
        }
        return $hasManyDoesNotDisplay;
    }

    /**
     * 获取一对多映射
     * @param $relationHasMany
     * @param $moduleData
     * @return array
     */
    public function getHasManyConfigDataMap($relationHasMany, $moduleData)
    {
        $hasManyDataMap = [];
        $hasManyDoesNotDisplay = $this->getModuleHasManyDoesNotDisplay($moduleData);

        foreach ($relationHasMany as $key => $hasManyItem) {

            if ($hasManyItem["module_type"] === "entity") {
                $hasManyModuleKey = $hasManyItem["module_type"];
            } else {
                $hasManyModuleKey = $hasManyItem["module_code"];
            }

            $show = true;
            if (in_array($hasManyModuleKey, $hasManyDoesNotDisplay)) {
                $show = false;
            }
            if (!array_key_exists("belong_to_config", $hasManyItem)) {
                $hasManyDataMap[$key] = [
                    "has_many_module" => $key,
                    "show" => $show,
                    "module_id" => $hasManyItem["module_id"],
                    "module_code" => $hasManyItem["module_code"],
                    "module_type" => $hasManyItem["module_type"]
                ];
            } else {
                $hasManyDataMap[$hasManyItem["belong_to_config"]["format"]["table"]] = [
                    "has_many_module" => $key,
                    "show" => $show,
                    "module_id" => $hasManyItem["module_id"],
                    "module_code" => $hasManyItem["module_code"],
                    "module_type" => $hasManyItem["module_type"]
                ];
                $hasManyDataMap[$key] = [
                    "show" => false
                ];
            }
        }

        return $hasManyDataMap;
    }

    /**
     * 组装字段配置
     * @param $moduleSchemaConfig
     * @param $moduleData
     * @param bool $isGrid
     * @param array $shieldModule
     * @param bool $isQuery
     * @param bool $isApi
     * @return array
     */
    public function generateColumnsConfig($moduleSchemaConfig, $moduleData, $isGrid = true, $shieldModule = [], $isQuery = false, $isApi = false)
    {

        if (!$isApi) {
            $schemaFields = $moduleSchemaConfig['field_clean_data']["schema_fields"];
        } else {
            $schemaFields = $moduleSchemaConfig["schema_fields"];
        }

        // 分离主表和关联表字段集合
        $masterModuleFields = [];
        $foreignKeyList = [];
        $relationModuleFieldsMap = [];
        $moduleBaseSchemaConfig = [];

        foreach ($schemaFields as $key => $schemaField) {

            // 拆分固定字段
            if (array_key_exists("built_in", $schemaField['field_configs'])) {
                foreach ($schemaField['field_configs']['built_in'] as $builtInField) {
                    $builtInField["from_module_code"] = $key;
                    if ($builtInField["module_code"] === $moduleData["code"]) {
                        // 判断是否是外键
                        if ($moduleData["code"] === "base" && $builtInField["fields"] === "entity_id") {
                            $builtInField["is_foreign_key"] = "no";
                            $builtInField["belong_module"] = $moduleData["code"];
                            array_push($moduleBaseSchemaConfig, $builtInField);
                        } else {
                            if (array_key_exists("is_foreign_key", $builtInField) && $builtInField["is_foreign_key"] === "yes") {

                                if (array_key_exists("foreign_key_map", $builtInField) && !empty($builtInField["foreign_key_map"])) {
                                    $foreignKeyModule = str_replace("_id", "", $builtInField["foreign_key_map"]);
                                    if ($foreignKeyModule === "entity") {
                                        $foreignModuleData = $this->getEntityBelongParentModule(["module_code" => $moduleData["code"]]);
                                        if (!empty($foreignModuleData)) {
                                            $foreignKeyModule = $foreignModuleData["code"];
                                        }
                                    }
                                    $builtInField["foreign_key_module"] = $foreignKeyModule;
                                } else {
                                    $builtInField["foreign_key_module"] = str_replace("_id", "", $builtInField["fields"]);
                                }

                                $builtInField["belong_module"] = $moduleData["code"];

                                if (!in_array($builtInField["foreign_key_module"], $foreignKeyList)) {
                                    $foreignKeyList[] = $builtInField["foreign_key_module"];
                                }

                                if ($isQuery) {
                                    array_push($moduleBaseSchemaConfig, $builtInField);
                                }
                            } else {
                                $builtInField["is_foreign_key"] = "no";
                                $builtInField["belong_module"] = $moduleData["code"];
                                array_push($moduleBaseSchemaConfig, $builtInField);
                            }
                        }
                        // 主表字段
                        array_push($masterModuleFields, $builtInField);
                    } else {
                        // 处理外联编辑
                        if (!array_key_exists("outreach_edit", $builtInField)) {
                            $builtInField["outreach_edit"] = "deny";
                        }
                        // 处理外联编辑器
                        if (!array_key_exists("outreach_editor", $builtInField)) {
                            $builtInField["outreach_editor"] = "none";
                        }

                        $builtInField["belong_module"] = $moduleData["code"];
                        $relationModuleFieldsMap[$builtInField["module_code"]][] = $builtInField;
                    }
                }
            }

            //  拆分自定义字段
            if (!empty($schemaField['field_configs']['custom'])) {
                foreach ($schemaField['field_configs']['custom'] as $customField) {

                    $customField["from_module_code"] = $key;

                    if (!$isGrid && in_array($customField["type"], ["belong_to", "horizontal_relationship"])) {
                        // 非表格控件处理
                        if ($customField["type"] === "horizontal_relationship") {
                            $customField["editor"] = "tagbox";
                            $customField["outreach_editor"] = "tagbox";
                        }

                        $customField["editor_type"] = $customField["type"] === "belong_to" ? "belong_to" : "has_many";
                        $customField["multiple"] = $customField["type"] === "belong_to" ? "no" : "yes";
                        $customField["data_source"] = $customField["type"];
                        $customField["table"] = $customField["module"];
                    }

                    if ($customField["module_code"] === $moduleData["code"]) {
                        // 主表字段
                        array_push($moduleBaseSchemaConfig, $customField);
                    } else {
                        // 关联表字段
                        $customField["outreach_edit"] = "deny";
                        $customField["outreach_editor"] = "none";
                        $relationModuleFieldsMap[$customField["module_code"]][] = $customField;
                    }
                }
            }
        }

        // 把外键表插入回去
        foreach ($masterModuleFields as $masterModuleField) {

            if ($masterModuleField["is_foreign_key"] === "yes" && array_key_exists($masterModuleField["foreign_key_module"], $relationModuleFieldsMap)) {
                foreach ($relationModuleFieldsMap[$masterModuleField["foreign_key_module"]] as $relationField) {
                    if (!$isApi) {
                        if (array_key_exists("outreach_display", $relationField) && $relationField["outreach_display"] === "yes") {
                            $relationField["editor"] = $masterModuleField["editor"];
                            if ($relationField["field_type"] !== "custom") {
                                $relationField["is_foreign_key"] = "yes";
                            }
                            if (array_key_exists("foreign_key_module_lang", $masterModuleField) && !empty($masterModuleField["foreign_key_module_lang"])) {
                                $relationField["foreign_key_module_lang"] = $masterModuleField["foreign_key_module_lang"];
                            } else {
                                $relationField["foreign_key_module_lang"] = $relationField["module_code"];
                            }

                            if (array_key_exists("outreach_editor", $relationField) && array_key_exists("outreach_edit", $relationField) && $relationField["outreach_edit"] === "allow") {
                                $relationField["editor"] = $relationField["outreach_editor"];
                            } else {
                                $relationField["editor"] = "none";
                            }

                            // 等于主表module
                            $relationField["module"] = $masterModuleField["module"];
                            $relationField["table"] = $masterModuleField["table"];
                            $relationField["belong_module"] = $masterModuleField["belong_module"];
                            $relationField["foreign_key"] = $masterModuleField["fields"];
                            $relationField["frozen_module"] = $masterModuleField["module_code"];
                            $relationField["flg_module"] = $masterModuleField["foreign_key_module"];
                            $relationField["title"] = $masterModuleField["foreign_key_module"];
                            array_push($moduleBaseSchemaConfig, $relationField);
                        }
                    } else {
                        array_push($moduleBaseSchemaConfig, $relationField);
                    }
                }
            }
        }

        // 处理一对多字段显示（仅仅显示name字段，远端关联显示远端name字段）
        $hasManyDataMap = $this->getHasManyConfigDataMap($moduleSchemaConfig["relation_structure"]["relation_has_many"], $moduleData);

        // 把其他非外键关联插入回去
        foreach ($relationModuleFieldsMap as $key => $relationModuleFields) {
            if (!in_array($key, $foreignKeyList) && !in_array($key, $shieldModule)) {
                if (!array_key_exists($key, $hasManyDataMap) || (array_key_exists($key, $hasManyDataMap) && $key === "base" && $isQuery)) {
                    foreach ($relationModuleFields as $relationModuleField) {
                        if (!$isApi) {
                            if ((array_key_exists($moduleData["code"], $this->hasOneDoesNotDisplay) && !in_array($relationModuleField["module_code"], $this->hasOneDoesNotDisplay[$moduleData["code"]]))
                                || !array_key_exists($moduleData["code"], $this->hasOneDoesNotDisplay)) {
                                // 判断是否为屏蔽的Has one 字段
                                array_push($moduleBaseSchemaConfig, $relationModuleField);
                            }
                        } else { // api 不需要屏蔽Has one 字段
                            array_push($moduleBaseSchemaConfig, $relationModuleField);
                        }
                    }
                } else {
                    if ($hasManyDataMap[$key]["show"]) {
                        foreach ($relationModuleFields as $relationModuleField) {
                            if ($relationModuleField["fields"] === "name") {
                                $relationModuleField["is_has_many"] = true;
                                $relationModuleField["has_many_module"] = $hasManyDataMap[$key]["has_many_module"];
                                if (!$isGrid) {
                                    $relationModuleField["editor"] = "tagbox";
                                    $relationModuleField["editor_type"] = "has_many";
                                    $relationModuleField["data_source"] = $relationModuleField["module"];
                                    $relationModuleField["multiple"] = "yes";
                                    $relationModuleField["module"] = $hasManyDataMap[$key]["has_many_module"];
                                    $relationModuleField["table"] = $hasManyDataMap[$key]["has_many_module"];
                                }
                                array_push($moduleBaseSchemaConfig, $relationModuleField);
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $moduleBaseSchemaConfig;
    }

    /**
     * 关联模型数据结构
     * @param $param
     * @param $schemaFieldConfig
     * @param $moduleData
     * @param array $masterQueryFields
     * @return mixed
     */
    public function getModelRelation($param, $schemaFieldConfig, $moduleData, $masterQueryFields = [])
    {
        // 关联结构数据
        $relationStructure = $schemaFieldConfig["relation_structure"];
        $relationStructure["filter"] = $param["filter"]; // 填充filter数据

        // 关联结构字段数据
        $schemaFieldsData = $schemaFieldConfig["schema_fields"];

        // 主表的module code
        $masterModuleCode = $moduleData["code"];

        // 处理字段，将字段填回相应的key值里面
        foreach ($schemaFieldsData as $schemaFieldItem) {
            // 字段查询忽略api查询
            if ($schemaFieldItem['show'] === "yes" || session("event_from") === "strack_api") {

                // 组装字段格式
                if ($moduleData["type"] === "entity" && $schemaFieldItem["from_module_code"] === "base") {
                    $valueShowFields = $this->getFieldColumnName($schemaFieldItem, $masterModuleCode, true);
                } else {
                    $valueShowFields = $this->getFieldColumnName($schemaFieldItem, $masterModuleCode);
                }

                if ($schemaFieldItem["field_type"] == "built_in") {
                    // 格式化字段 组装key值
                    $formatKey = $valueShowFields;

                    $builtInFieldKey = $schemaFieldItem["module_code"] . "." . $schemaFieldItem['fields'] . " " . $valueShowFields;

                    // 主表字段填充
                    if ($schemaFieldItem["module_code"] === $relationStructure["table_alias"]) {

                        if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                            || empty($masterQueryFields)) {

                            array_push($relationStructure["fields"], [$schemaFieldItem["fields"] => $builtInFieldKey]);
                        }
                    }

                    // 关联表字段填充
                    if (array_key_exists($schemaFieldItem["from_module_code"], $relationStructure["relation_join"])) {
                        if ((!empty($masterQueryFields) &&
                                array_key_exists($schemaFieldItem["from_module_code"], $masterQueryFields["relation"]) &&
                                in_array($schemaFieldItem["fields"], $masterQueryFields["relation"][$schemaFieldItem["from_module_code"]]))
                            || empty($masterQueryFields)) {
                            array_push($relationStructure["relation_join"][$schemaFieldItem["from_module_code"]]["fields"], [$schemaFieldItem["fields"] => $builtInFieldKey]);
                        }
                    } else if (array_key_exists($schemaFieldItem["from_module_code"], $relationStructure["relation_has_many"])) {
                        if ($moduleData["type"] === "entity" && $schemaFieldItem["from_module_code"] === "base" && session("event_from") === "strack_web") {

                            // 格式化字段 组装key值
                            $formatKey = $schemaFieldItem["module_code"] . "_" . $schemaFieldItem["fields"];

                            // 单独处理实体下面显示工序任务
                            if ($schemaFieldItem["module_code"] === $schemaFieldItem["from_module_code"]) {
                                $baseFieldKey = $schemaFieldItem["module_code"] . "." . $schemaFieldItem['fields'] . " " . $schemaFieldItem["module_code"] . "_" . $schemaFieldItem["fields"];
                            } else {
                                $baseFieldKey = $schemaFieldItem["module_code"] . "." . $schemaFieldItem['fields'] . " " . $schemaFieldItem["from_module_code"] . "_" . $schemaFieldItem["module_code"] . "_" . $schemaFieldItem["fields"];
                            }

                            if (array_key_exists($schemaFieldItem["module_code"], $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"])) {
                                $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"][$schemaFieldItem["module_code"]]["list"][$schemaFieldItem["fields"]] = $baseFieldKey;
                            } else {
                                $foreignKey = array_key_exists("foreign_key", $schemaFieldItem) ? $schemaFieldItem["foreign_key"] : '';
                                $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"][$schemaFieldItem["module_code"]] = [
                                    "table" => $schemaFieldItem["table"],
                                    "table_alias" => $schemaFieldItem["module_code"],
                                    "foreign_key" => $foreignKey,
                                    "field_type" => "built_in",
                                    "list" => [$schemaFieldItem["fields"] => $baseFieldKey]
                                ];
                            }
                        } else {
                            if ((!empty($masterQueryFields) &&
                                    array_key_exists($schemaFieldItem["from_module_code"], $masterQueryFields["relation"]) &&
                                    in_array($schemaFieldItem["fields"], $masterQueryFields["relation"][$schemaFieldItem["from_module_code"]]))
                                || empty($masterQueryFields)) {
                                array_push($relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"], [$schemaFieldItem["fields"] => $builtInFieldKey]);
                            }
                        }
                    }
                } else { // 处理自定义字段
                    if (in_array($schemaFieldItem["type"], ["horizontal_relationship", "belong_to"]) && $relationStructure["table_alias"] == $schemaFieldItem["module_code"]) {
                        $formatKey = $schemaFieldItem["fields"];

                        // 水平关联配置
                        $relationData = $this->getFieldHorizontal($schemaFieldItem);
                        if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                            || empty($masterQueryFields)) {
                            $relationStructure["relation_has_many"][$formatKey] = $relationData["relation_data"];
                            $relationStructure["relation_has_many"][$formatKey]["fields"] = $relationData["fields"];
                        }

                    } else { // 自定义字段配置

                        if ($schemaFieldItem["module_code"] == $masterModuleCode) {
                            $formatKey = $schemaFieldItem["module_code"] . '_' . $schemaFieldItem["fields"];
                        } else {
                            if ($moduleData["type"] === "entity" && $schemaFieldItem["from_module_code"] === "base") {
                                $formatKey = $schemaFieldItem["module_code"] . '_' . $schemaFieldItem["fields"];
                            } else {
                                $formatKey = $masterModuleCode . "_" . $schemaFieldItem["module_code"] . '_' . $schemaFieldItem["fields"];
                            }
                        }

                        $customQueryField = $formatKey . ".value " . $valueShowFields;

                        // 关联表字段填充
                        if (array_key_exists($schemaFieldItem["from_module_code"], $relationStructure["relation_has_many"])) {
                            if ($moduleData["type"] === "entity" && $schemaFieldItem["from_module_code"] === "base" && session("event_from") === "strack_web") {
                                // 实体页面base表数据查询
                                $schemaFieldKey = $schemaFieldItem["module_code"] . '_' . $schemaFieldItem["fields"];
                                if (array_key_exists($schemaFieldKey, $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"])) {
                                    if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                                        || empty($masterQueryFields)) {
                                        $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"][$schemaFieldKey]["list"][$schemaFieldItem["fields"]] = $customQueryField;
                                    }
                                } else {
                                    $customFieldData = [
                                        "table" => $schemaFieldItem["table"],
                                        "table_alias" => $formatKey,
                                        "foreign_key" => "link_id",
                                        "field_type" => "custom",
                                        "custom_type" => $schemaFieldItem["type"],
                                        "variable_id" => $schemaFieldItem["variable_id"],
                                        "project_id" => $param["project_id"],
                                        "list" => [$schemaFieldItem["fields"] => $customQueryField]
                                    ];

                                    if (in_array($schemaFieldItem["type"], ["horizontal_relationship", "belong_to"])) {
                                        $customFieldData["horizontal_relationship_config"] = [
                                            "src_module_id" => $schemaFieldItem["module_id"],
                                            "dst_module_id" => $schemaFieldItem["relation_module_id"]
                                        ];
                                    }

                                    if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                                        || empty($masterQueryFields)) {
                                        $relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"][$schemaFieldKey] = $customFieldData;
                                    }
                                }
                            } else {

                                if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                                    || empty($masterQueryFields)) {
                                    array_push($relationStructure["relation_has_many"][$schemaFieldItem["from_module_code"]]["fields"], $customQueryField);
                                }
                            }
                        } else {
                            if (in_array($schemaFieldItem["type"], ["horizontal_relationship", "belong_to"])) {
                                $formatKey = $schemaFieldItem["fields"];

                                $relationData = $this->getFieldHorizontal($schemaFieldItem);
                                if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                                    || empty($masterQueryFields)) {
                                    $relationStructure["relation_has_many"][$formatKey] = $relationData["relation_data"];
                                    $relationStructure["relation_has_many"][$formatKey]["fields"] = $relationData["fields"];
                                }
                            } else {
                                $mappingType = "belong_to";
                                $foreignKey = "link_id";
                                $fieldType = $schemaFieldItem["field_type"];
                                $moduleCode = "variable_value";

                                if ((!empty($masterQueryFields) && in_array($schemaFieldItem["fields"], $masterQueryFields["master"]))
                                    || empty($masterQueryFields)) {
                                    // 生成自定义字段配置
                                    $relationStructure["relation_join"][$formatKey] = $this->generateCustomFieldConfig($schemaFieldItem, $mappingType, $foreignKey, $fieldType, $moduleCode);
                                    // 将字段追加到配置中
                                    array_push($relationStructure["relation_join"][$formatKey]['fields'], ['value' => $customQueryField]);
                                }
                            }
                        }
                    }
                }

                // 格式化字段
                if ((array_key_exists("show_from", $schemaFieldItem) && !empty($schemaFieldItem["show_from"]))
                    || !empty($schemaFieldItem["format"])) {
                    $relationStructure["format_list"][$formatKey] = $this->getFieldFormatData($schemaFieldItem);
                }

            }
        }

        return $relationStructure;
    }


    /**
     * 生成Relation查询结构
     * @param $param
     * @return mixed
     */
    public function generateModuleRelation($param)
    {
        // 获取主表Module信息
        $moduleData = $this->moduleModel->findData(["filter" => ["code" => $param["master"]["module_code"]], "fields" => "id as module_id,code,type"]);

        $checkFields = $this->checkFields($param["master"]["fields"], $param["project_id"], $moduleData);
        if (!$checkFields) {
            throw_strack_exception(L("Field_Error"));
        }

        // 循环遍历关联表字段是否正确

        $flagFields = true;
        if (array_key_exists("relation", $param)) {
            foreach ($param["relation"] as $item) {
                $moduleRelationData = $this->moduleModel->findData(["filter" => ["code" => $item["module_code"]], "fields" => "id as module_id,code,type"]);
                $checkFieldRelation = $this->checkFields($item["fields"], $param["project_id"], $moduleRelationData);
                if (!$checkFieldRelation) {
                    $flagFields = false;
                } else {
                    $flagFields = true;
                }
            }
        }

        if (!$flagFields) {
            throw_strack_exception(L("Field_Error"));
        } else {
            // 处理filter条件
            $param["filter"]["group"] = [];
            // 获取关联数据结构
            return $this->getApiRelationStructure($param, $moduleData);
        }
    }

    /**
     * 检查字段是否合法
     * @param $fields
     * @param $projectId
     * @param $moduleData
     * @return bool
     */
    private function checkFields($fields, $projectId, $moduleData)
    {
        if (!empty($fields)) {
            // 获取自定义字段信息
            $fieldsConfig = $this->getTableFieldConfig($moduleData, $projectId);

            $fieldsList = [];
            // 将自定义字段和固定字段放到数组中
            foreach ($fieldsConfig["built_in"] as $key => $builtInItem) {
                array_push($fieldsList, $builtInItem["id"]);
            }

            foreach ($fieldsConfig["custom"] as $key => $customItem) {
                array_push($fieldsList, $customItem["id"]);
            }

            $flag = true;
            $fieldsArray = explode(",", $fields);
            foreach ($fieldsArray as $item) {
                if (!in_array($item, $fieldsList)) {
                    $flag = false;
                } else {
                    $flag = true;
                }
            }
            return $flag;
        }else{
            return true;
        }
    }

    /**
     * 获取关联结构
     * @param $param
     * @param $moduleData
     * @return array
     */
    private function getApiRelationStructure($param, $moduleData)
    {

        $screenSchemaFields = [];
        $relationModuleList = [];

        // 主表moduleCode
        $masterModuleCode = $param["master"]["module_code"];

        // 如果存在关联
        if (array_key_exists("relation", $param) && !empty($param["relation"])) {
            $schemaData = $this->getSchemaData(["code" => $masterModuleCode]);
            $schemaId = !empty($schemaData["id"]) ? $schemaData["id"] : 0;
        } else {
            $schemaId = 0;
        }

        // 获取数据结构
        $schemaFieldsData = $this->getSchemaFields([
            "project_id" => $param["project_id"],
            "module_id" => $moduleData["module_id"]
        ], $schemaId);

        // 获取数据结构字段
        $schemaFields = $schemaFieldsData["schema_fields"];
        // 数据结构
        $relationStructure = $schemaFieldsData["relation_structure"];

        // 传入的主表字段
        $masterFieldList = explode(",", $param["master"]["fields"]);
        $relationQueryFields = [
            "master" => $masterFieldList,
            "relation" => []
        ];

        // 筛选后的字段数据
        $screenSchemaFields[$masterModuleCode] = $schemaFields[$masterModuleCode];

        // 关联表数据
        if ($schemaId > 0) {
            $relationModuleList = array_column($param["relation"], null, "module_code");
            // 将传入的关联module放入新数组
            foreach ($schemaFields as $key => $item) {
                if (array_key_exists($key, $relationModuleList)) {
                    $screenSchemaFields[$key] = $item;
                    $relationQueryFields["relation"][$key] = explode(",", $relationModuleList[$key]["fields"]);
                }
            }
        }

        // 重新组装数据结构
        $moduleBaseConfig = [
            "schema_fields" => $screenSchemaFields,
            "relation_structure" => $relationStructure
        ];
        $moduleBaseSchemaFields = $this->generateColumnsConfig($moduleBaseConfig, $moduleData, false, [], true, true);

        // 组装获取查询字段的filter
        $filter = [
            "filter" => $param["filter"],
            "project_id" => $param["project_id"],
            "module_id" => $moduleData["module_id"],
            "pagination" => $param["master"]["pagination"]
        ];

        // 获取字段查询数据
        $relationStructure = $this->getModelRelation($filter, [
            "schema_fields" => $moduleBaseSchemaFields,
            "relation_structure" => $relationStructure
        ], $moduleData, $relationQueryFields);

        // 重新组装新数据
        $relationJoin = [];
        $relationHasMany = [];

        // 一对一查询组装
        foreach ($relationStructure["relation_join"] as $key => $item) {
            if (array_key_exists($key, $relationModuleList) || $item["module_type"] == "custom") {
                $relationJoin[$key] = $item;
            }
        }
        $relationStructure["relation_join"] = $relationJoin;

        // 一对多查询组装
        foreach ($relationStructure["relation_has_many"] as $key => $item) {
            if (array_key_exists($key, $relationModuleList) || in_array($item["module_type"], ["custom", "belong_to", "horizontal_relationship"])) {
                $relationHasMany[$key] = $item;
            }
        }
        $relationStructure["relation_has_many"] = $relationHasMany;

        return ["module_id" => $moduleData["module_id"], "relation_structure" => $relationStructure, "pagination" => $param["master"]["pagination"]];
    }

    /**
     * 获取关联结构
     * @param $param
     * @return array
     */
    public function getModuleRelationData($param)
    {
        $moduleRelationData = $this->moduleRelationModel->selectData(["filter" => ["schema_id" => $param["schema_id"]]]);
        if ($moduleRelationData["total"] > 0) {
            foreach ($moduleRelationData["rows"] as $key => &$item) {
                $srcModuleData = $this->getModuleFindData(["id" => $item["src_module_id"]]);
                $dstModuleData = $this->getModuleFindData(["id" => $item["dst_module_id"]]);
                $item["src_module_code"] = $srcModuleData["code"];
                $item["dst_module_code"] = $dstModuleData["code"];
            }
        }
        return $moduleRelationData;
    }

    /**
     * 保存实体相关模块信息
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function saveEntityModuleData($param)
    {
        $number = 10;
        $resData = [];
        $this->moduleModel->startTrans();
        try {
            foreach ($param as &$item) {
                $number = $number + 10;
                $item["type"] = "entity";
                $item["number"] = $number;
                $item["icon"] = "icon-uniEAB1";
                $resData = $this->addModule($item);
            }
            $this->moduleModel->commit();
            return $resData;
        } catch (\Exception $e) {
            $this->moduleModel->rollback();
            throw_strack_exception($e->getMessage(), 223004);
        }
    }

    /**
     * 保存schema关联结构
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function saveSchemaModuleRelation($param)
    {
        $moduleMapData = $this->getModuleMapData();

        $resData = [];
        foreach ($param as $schemaItem) {
            // 保存schema信息
            $schemaParam = [
                "name" => $schemaItem["name"],
                "code" => $schemaItem["code"],
                "type" => $schemaItem["type"],
            ];
            $resSchemaData = $this->addSchema($schemaParam);

            if ($schemaItem["type"] != "project") {
                // 保存页面使用配置信息
                $pageSchemaUseParam = [
                    "page" => "project_" . $resSchemaData["data"]["code"],
                    "schema_id" => $resSchemaData["data"]["id"]
                ];
                $this->addPageSchemaUse($pageSchemaUseParam);
            }

            // 保存关联结构信息
            foreach ($schemaItem["relation_data"] as $key => $relationData) {
                $srcModuleData = $moduleMapData[$key];
                $resData = $this->addModuleRelation($relationData, $srcModuleData, $moduleMapData, $resSchemaData["data"]["id"]);
            }
        }

        return $resData;
    }

    /**
     * 修改Schema关联结构
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function modifySchemaModuleRelation($param)
    {
        // 获取模块字典数据
        $moduleMapData = $this->getModuleMapData();

        $schemaId = $param["schema_param"]["schema_id"];

        // 修改schema信息
        $param["schema_param"]["id"] = $schemaId;
        $this->modifySchema($param["schema_param"]);

        // 删除moduleRelation信息
        $this->moduleRelationModel->deleteItem(["schema_id" => $schemaId]);

        // 保存moduleRelation信息
        $resData = [];
        foreach ($param["relation_data"] as $key => $relationData) {
            $srcModuleData = $moduleMapData[$key];
            $resData = $this->addModuleRelation($relationData, $srcModuleData, $moduleMapData, $schemaId);
        }
        return $resData;
    }

    /**
     * 获取关联结构保存的json数据格式
     * @param $uuid
     * @param $moduleData
     * @param string $top
     * @param string $left
     * @return array
     */
    protected function generateRelationNodeData($uuid, $moduleData, $top = "46", $left = "343")
    {
        $data = [
            "h" => "80",
            "w" => "120",
            "id" => $uuid,
            "top" => $top,
            "left" => $left,
            "text" => $moduleData["name"],
            "type" => "module",
            "module_id" => $moduleData["id"],
            "module_code" => $moduleData["code"],
            "module_type" => $moduleData["type"]
        ];
        return $data;
    }

    /**
     * 添加关联结构信息
     * @param $relationData
     * @param $srcModuleData
     * @param $moduleMapData
     * @param $schemaId
     * @return array
     * @throws \Exception
     */
    protected function addModuleRelation($relationData, $srcModuleData, $moduleMapData, $schemaId)
    {
        $srcUuid = create_uuid();

        // 保存关联结构
        $this->moduleRelationModel->startTrans();
        try {
            foreach ($relationData as $dataKey => $item) {
                // 关联Module信息
                $dstModuleData = $moduleMapData[$item["code"]];

                // 判断Link Id
                if ($item['mapping_type'] == 'belong_to') {
                    if ($srcModuleData["type"] == "entity" && $dstModuleData["type"] == "entity") {
                        $linkId = "parent_id";
                    } else {
                        $moduleCode = $dstModuleData["type"] == "entity" ? $dstModuleData["type"] : $dstModuleData["code"];
                        $linkId = $moduleCode . "_id";
                    }
                } elseif ($item['mapping_type'] == 'has_one') {
                    $sourceCode = $srcModuleData["type"] == "entity" ? $srcModuleData["type"] : $srcModuleData["code"];
                    $linkId = $sourceCode . "_id";
                } else {
                    $linkId = "id";
                }

                $dstUuid = create_uuid();

                $saveRelationData = [
                    'type' => $item["mapping_type"],
                    'src_module_id' => $srcModuleData["id"],
                    'dst_module_id' => $dstModuleData["id"],
                    'link_id' => $linkId,
                    'schema_id' => $schemaId,
                    'node_config' => [
                        "edges" => [
                            "data" => [
                                "type" => "connection",
                                "label" => $item["mapping_type"]
                            ],
                            "source" => $srcUuid,
                            "target" => $dstUuid
                        ],
                        "node_data" => [
                            "source" => $this->generateRelationNodeData($srcUuid, $srcModuleData),
                            "target" => $this->generateRelationNodeData($dstUuid, $dstModuleData)
                        ]
                    ]
                ];

                $resData = $this->moduleRelationModel->addItem($saveRelationData);
                if (!$resData) {
                    throw new \Exception($this->moduleRelationModel->getError());
                }
            }
            $this->moduleRelationModel->commit();
            return success_response($this->moduleRelationModel->getSuccessMassege());
        } catch (\Exception $e) {
            $this->moduleRelationModel->rollback();
            throw_strack_exception($e->getMessage());
        }
    }

    /**
     * 获取当前schema关联module（权限使用）
     * @param $param
     * @return array
     */
    public function getSchemaRelationModule($param)
    {
        // 获取schemaId
        $schemaId = $this->pageSchemaUseModel->where(["page" => $param["page"]])->getField("schema_id");

        $moduleRelationData = $this->moduleRelationModel->selectData(["filter" => ["schema_id" => $schemaId], "fields" => "src_module_id,dst_module_id"]);

        $moduleList = [$param["param"]["module_code"]];

        // 获取module字典信息
        $moduleListData = $this->moduleModel->selectData();
        $moduleMapData = array_column($moduleListData["rows"], null, "id");

        foreach ($moduleRelationData["rows"] as $item) {
            if ($moduleMapData[$item["dst_module_id"]]["code"] === "tag_link") {
                array_push($moduleList, "tag");
            } else {
                array_push($moduleList, $moduleMapData[$item["dst_module_id"]]["code"]);
            }
        }

        return $moduleList;
    }

    /**
     * 获取实体父级模块信息
     * @param $param
     * @param string $mode
     * @return array|mixed
     */
    public function getEntityBelongParentModule($param, $mode = "parent")
    {
        // 获取schema_id
        $schemaId = $this->schemaModel->where(["code" => $param["module_code"]])->getField("id");

        // 获取关联结构数据
        $moduleRelationData = $this->moduleRelationModel->selectData(["filter" => ["schema_id" => $schemaId]]);

        // 获取module字典数据
        $moduleMapData = $this->getModuleMapData("id");

        $resData = [];
        switch ($mode) {
            case "parent":
                foreach ($moduleRelationData["rows"] as $relationItem) {
                    $moduleData = $moduleMapData[$relationItem["dst_module_id"]];
                    if ($relationItem["type"] == "belong_to" && $moduleData["type"] === "entity") {
                        $resData = $moduleData;
                    }
                }
                break;
            case "children":
                foreach ($moduleRelationData["rows"] as $relationItem) {
                    $moduleData = $moduleMapData[$relationItem["dst_module_id"]];
                    if ($relationItem["type"] == "has_many" && $moduleData["type"] === "entity") {
                        $resData = $moduleData;
                    }
                }
                break;
        }

        return $resData;
    }

    /**
     * 获取父级数据
     * @param $entityData
     * @param $entityId
     * @return array
     */
    public function getEntityParentModuleData($entityData, $entityId)
    {
        $list = [];
        foreach ($entityData as $item) {
            if ($item['item_id'] == $entityId) {
                // 把数组放到list中
                $item["module_lang"] = L($this->getCurrentModuleData($item["module_id"], "code"));
                $item["is_self"] = "no";
                $list[] = $item;
                if ($item["parent_id"] > 0) {
                    $list = array_merge($this->getEntityParentModuleData($entityData, $item["parent_id"]), $list);
                }
            }
        }
        return $list;
    }

    /**
     * 获取字段表数据
     * @param $tableName
     * @return mixed
     */
    public function getTableFieldData($tableName)
    {
        $count = $this->fieldModel->where(["table" => $tableName])->count();
        if ($count == 0) {
            throw_strack_exception(L("Table_Not_Exist"), 223010);
        }
        $fieldData = $this->fieldModel->getTableFieldsConfig($tableName);
        return $fieldData;
    }

    /**
     * 获取所有表名
     * @return array
     */
    public function getAllTableName()
    {
        $tables = $this->fieldModel->getTables();
        $tablesName = array_map(function ($table) {
            return str_replace(C("DB_PREFIX"), "", $table);
        }, $tables);
        return $tablesName;
    }

    /**
     * 修改字段配置
     * @param $param
     * @return array
     */
    public function modifyFieldConfig($param)
    {
        $count = $this->fieldModel->where(["table" => $param["table"]])->count();
        if ($count > 0) {
            $fieldData = $this->fieldModel->modifyFieldConfig($param["table"], json_encode($param["config"]));
            return $fieldData;
        } else {
            throw_strack_exception(L("Table_Not_Exist"), 223010);
        }
    }
}