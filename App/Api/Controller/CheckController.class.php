<?php

namespace Api\Controller;

use Common\Controller\VerifyController;
use Common\Service\CommonService;
use Common\Service\HorizontalService;
use Common\Service\SchemaService;
use Common\Service\VariableService;

class CheckController extends VerifyController
{
    /**
     * 错误信息
     * @var string
     */
    protected $errorMessage = "";
    /**
     * 错误码
     * @var
     */
    protected $errorNumber;
    /**
     * 模块信息
     * @var array
     */
    protected $moduleMap = [];
    /**
     * entity 模块
     * @var array
     */
    protected $entityModule = [];
    /**
     * 字段信息
     * @var array
     */
    private $fieldsData = [];

    /**
     * 获取错误信息
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * 获取错误码
     * @return mixed
     */
    public function getErrorNumber()
    {
        return $this->errorNumber;
    }

    /**
     * 处理请求参数
     * @param $param
     * @param $method
     * @return array|bool
     */
    public function checkRequestParam($param, $method)
    {

        //需要module参数的方法
        $requestModuleList = ["find", "select", "create", "update", "fields"];
        if (in_array($method, $requestModuleList)) {
            //检查module
            if (array_key_exists("module", $param) && $this->checkRequireParam(["id", "code"], $param["module"])) {
                //适配Task获取表配置
                $param["module"]["code"] = "task" == $param["module"]["code"] ? "base" : $param["module"]["code"];
            } else {
                $this->errorMessage = L("Module_Not_Exist");
                $this->errorNumber = 401002;
                return false;
            }
            $schemaService = new SchemaService();
            $this->moduleMap = $schemaService->getModuleMapData();
            $this->entityModule = $schemaService->getModuleMapData("code", ["filter" => ["type" => "entity"]]);
        }
        return $this->checkMethod($param, $method);
    }


    /**
     * 验证入口
     * @param $param
     * @param $method
     * @return array|mixed
     */
    public function checkMethod($param, $method)
    {
        //调用的方法
        $function = "check" . ucfirst(strtolower($method)) . "Param";
        if (!method_exists($this, $function)) {
            $resData = [];
        } else {
            //参数为空
            if (empty($param)) {
                $this->errorMessage = L("Error_Valid_Empty");
                $this->errorNumber = 401001;
                return false;
            }
            $resData = call_user_func(array($this, $function), $param);
        }
        return $resData;
    }

    /**
     * 单条查询参数
     * @param $param
     * @return array|bool
     */
    public function checkFindParam($param)
    {
        return $this->checkSelectParam($param);
    }

    /**
     * 验证多条查询参数
     * @param $param
     * @return array|bool
     */
    public function checkSelectParam($param)
    {
        //检查filter参数
        if (!array_key_exists("filter", $param)) {
            $this->errorMessage = L("Filter_Null");
            $this->errorNumber = 401003;
            return false;
        }
        //structure
        $fields = array_key_exists("fields", $param) ? $param["fields"] : [];
        $order = array_key_exists("order", $param) ? $param["order"] : [];
        $page = array_key_exists("page", $param) ? $param["page"] : [];
        //filter
        $filter = [];
        foreach ($param["filter"] as $key => $value) {
            foreach ($value as $k => $v) {
                if (!is_array($v) || count($v) !== 2) {
                    $this->errorMessage = 401013;
                    $this->errorMessage = L("Filter_Error");
                    return false;
                }
            }
            $filter[$key == "task" ? "base" : $key] = $value;
        }
        $masterCode = $param["module"]["code"] == "task" ? "base" : $param["module"]["code"];
        //filter中表获取
        $filterTable = array_keys($filter);
        //tag fields写入tag_link
        $filterTable = in_array("tag", $filterTable) && $masterCode !== "tag" ? array_merge($filterTable, ["tag_link"]) : $filterTable;
        //主表fields
        $fieldsData = array_merge(array_fill_keys($filterTable, []), [$masterCode => []], $fields);
        $fields = [];
        foreach ($fieldsData as $table => $value) {
            $table = $table == "task" ? "base" : $table;
            $fields[$table] = $value;
        }

        //检查分页参数
        if (empty($page["page_size"]) || empty($page["page_number"])) {
            $page = [
                "page_size" => $this->currentAction == "select" ? 10000 : 1,
                "page_number" => 1
            ];
        }

        //适配base 改为task
        $sort = [];
        foreach ($order as $orderKey => $orderValue) {
            $explodeStringData = explode('.', $orderKey);
            if (count($explodeStringData) !== 2) {
                $this->errorNumber = 401012;
                $this->errorMessage = $orderKey . ' ' . L('Order_Error');
                return false;
            }
            $sort[$orderKey] = $orderValue;
        }
        $param = [
            "page" => $page,
            "order" => $sort,
            "fields" => $fields,
            "filter" => $filter,
        ];

        //生成集合
        $params = [];
        $masterFilter = isset($param["filter"][$masterCode]) ? $param["filter"][$masterCode] : [];
        //主键
        $pk = $masterCode == "project" ? "id" : "project_id";
        if (array_key_exists($pk, $masterFilter)) {
            $projectIdFilter = ["id" => $masterFilter[$pk]];
        } else {
            $projectIdFilter = [];
        }
        //主表字段
        $masterFields = $this->getTableConfig($masterCode);
        //项目id
        $projectIds = [0];
        if (array_key_exists($pk, $masterFields["fixed_field"])) {
            $projectIds = $this->getProjectIds($projectIdFilter);
            if (empty($projectIdFilter)) {
                $projectIds = array_merge([0], $projectIds);
            }
        }

        foreach ($projectIds as $projectId) {
            $params[] = $this->generateModuleRelationalStructure($param, $projectId, $masterCode);
        }

        return $params;
    }


    /**
     * 验证创建参数
     * @param $param
     * @return array|bool
     */
    protected function checkCreateParam($param)
    {
        if (array_key_exists("id", $param)) {
            $this->errorMessage = L("Create_Can_Not_Fill_Primary_Key");
            $this->errorNumber = 401009;
            return false;
        }
        $projectId = array_key_exists("project_id", $param) ? $param["project_id"] : 0;

        return $this->formatCreateAndUpdate($param, $projectId);
    }

    /**
     * 格式化创建或修改参数
     * @param $param
     * @param $projectId
     * @return array|bool
     */
    protected function formatCreateAndUpdate($param, $projectId)
    {
        $data = [];
        foreach ($param as $key => $value) {
            if ($key == "module") {
                continue;
            }
            $data[$key] = $value;
        }
        $masterCode = $param["module"]["code"];
        //检查字段
        $customFields = $this->checkFields($masterCode, $data, $projectId);
        if ($customFields === false) {
            return false;
        }

        $moduleId = $param["module"]["id"];
        $masterData = [];
        $customResult = [];
        $relationModuleId = 0;
        $relationModuleCode = "";
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $customFields)) {
                if ($customFields[$key]['type'] == "horizontal_relationship") {
                    $relationModuleId = isset($customFields[$key]["config"]["relation_module_id"]) ? $customFields[$key]["config"]["relation_module_id"] : 0;
                    $relationModuleCode = isset($customFields[$key]["config"]["relation_module_code"]) ? $customFields[$key]["config"]["relation_module_code"] : "";
                }
                $customData = [
                    "module_id" => $moduleId,
                    "variable_id" => $customFields[$key]["id"],
                    "type" => $customFields[$key]['type'],
                    "value" => $value,
                    "field_type" => "custom",
                    "project_id" => $projectId,
                    "module_code" => "variable_value",
                    "relation_module_id" => $relationModuleId,
                    "relation_module_code" => $relationModuleCode,
                    "fields" => $key
                ];
                array_push($customResult, $customData);
            } else {
                $masterData[$key] = $value;
            }
        }

        if (array_diff_key($masterData, ["id" => "", "module" => ""])) {
            //entity 把module_id 加入数据
            if ($this->currentController == "entity") {
                $masterReplenishData = [
                    "field_type" => "built_in",
                    "project_id" => $projectId,
                    "module_id" => $moduleId
                ];
                $masterData = array_merge($masterData, $masterReplenishData);
            } else {
                $masterReplenishData = [
                    "field_type" => "built_in",
                ];
                $masterData = array_merge($masterReplenishData, $masterData);
            }

        } else {
            $masterData = [];
        }

        $results["master_data"] = $masterData;
        $results["relation_data"] = empty($customResult) ? [] : [$param["module"]["code"] => $customResult];

        $extrasData = [
            "module_id" => $moduleId,
            "project_id" => $projectId,
            "module_code" => $masterCode,
            "module" => $masterCode
        ];
        $resData = [
            "query_param" => $results,
            "extra_data" => $extrasData
        ];
        return $resData;
    }

    /**
     * 检查字段返回并返回调用的自定义字段的信息
     * @param $masterCode
     * @param $data
     * @param int $projectId
     * @return array|bool
     */
    public function checkFields($masterCode, $data, $projectId = 0)
    {
        $tableConfig = $this->getTableConfig($masterCode, $projectId);
        // 获取自定义字段映射字典
        $customFieldsDict = array_column($tableConfig["custom_field"], null, "code");
        //固定字段
        $fixedFieldsDict = $tableConfig["fixed_field"];
        // 检查字段是否合法
        $customData = [];
        foreach ($data as $field => $value) {
            if (!array_key_exists($field, $fixedFieldsDict) && !array_key_exists($field, $customFieldsDict)) {
                // 不属于固定字段也不属于自定义字段，当前存在非法字段
                $this->errorMessage = $field . "_" . L("Field_Error");
                $this->errorNumber = 401004;
                return false;
            } else if (array_key_exists($field, $customFieldsDict)) {
                $customData[$customFieldsDict[$field]["code"]] = $customFieldsDict[$field];
            }
        }
        // 返回存在的自定义字段
        return $customData;
    }

    /**
     * 生成关联结构查询
     * @param $param
     * @param $projectId
     * @param $master
     * @return array|bool
     */
    public function generateModuleRelationalStructure($param, $projectId, $master)
    {
        //生成fields
        $fieldsData = $this->generateFields($param, $master, $projectId);
        //生成filter
        $filter = $this->generateFilterRequestData($param, $fieldsData, $master, $projectId);
        //拼装主表
        $masterData = [
            "module_code" => $master,
            "pagination" => $param["page"],
            "fields" => implode(",", $fieldsData[$master]["fields"])
        ];
        $relationData = [];
        foreach ($fieldsData as $table => $fields) {
            if (in_array($table, [$master])) {
                continue;
            }
            $relationData[] = [
                "module_code" => $table,
                "fields" => implode(",", $fields["fields"]),
            ];
        }

        $queryData = [
            "filter" => $filter,
            "master" => $masterData,
            "relation" => $relationData,
            "project_id" => $projectId
        ];
        $resData = [
            "query_param" => $queryData,
            "extra_data" => []
        ];
        return $resData;
    }

    /**
     * 生成filter下的request
     * @param $param
     * @param $fieldsData
     * @param $master
     * @param $projectId
     * @return array|bool
     */
    private function generateFilterRequestData($param, &$fieldsData, $master, $projectId)
    {
        if ($master == "project") {
            $param["filter"][$master]["id"] = ["EQ", $projectId];
        } elseif (in_array("project_id", $fieldsData[$master]["raw_data"]["fixed_field"])) {
            $param["filter"][$master]["project_id"] = ["EQ", $projectId];
        }
        $idDictList = array_column($this->moduleMap, null, "id");
        $masterModuleData = $this->moduleMap[$master];
        //Entity 查询
        if ($masterModuleData["type"] == "entity") {
            $param["filter"][$master]["module_id"] = ["EQ", $masterModuleData["id"]];
        }

        $filterRequest = [];
        $filterPanel = [];
        foreach ($param["filter"] as $key => $value) {
            $customFields = $fieldsData[$key]["raw_data"]["custom_field"];
            $moduleData = $this->moduleMap[$key];
            //开始request数据转化
            foreach ($value as $field => $v) {
                //条件为*不生效 适配参数不能为空
                list($expression, $expressionValue) = $v;
                if ($expressionValue === "*") {
                    continue;
                }
                $table = string_initial_letter($moduleData["type"] == "entity" ? "entity" : $key);
                $requestFilter = [
                    "field" => $field,
                    "value" => $expressionValue,
                    'condition' => $expression,
                    "module_code" => $key,
                    "table" => $table,
                    "editor" => "text",
                    "variable_id" => 0,
                    "field_type" => "built_in"
                ];
                //tag过滤额外参数
                if (strtolower($key) == "tag" && $master !== "tag") {
                    $fieldInfo = $this->getFieldSpecifyData("tag", $field);
                    $requestFilter["editor"] = $fieldInfo["editor"];
                    $requestFilter["value"] = explode(",", $expressionValue);
                } else {
                    $splitField = explode('.', $field);
                    $field = count($splitField) === 2 ? reset($splitField) : $field;
                    if (array_key_exists($field, $customFields)) {
                        $requestFilter["field_type"] = "custom";
                        $requestFilter["variable_id"] = $customFields[$field]["id"];
                        $requestFilter["editor"] = $customFields[$field]["type"];
                        $requestFilter["table"] = 'variable_value';
                        //水平关联字段
                        if (count($splitField) === 2 && $customFields[$field]["type"] == 'horizontal_relationship') {
                            list(, $horizontalRelationshipFieldUseField) = $splitField;
                            $editor = isset($customFields[$field]["config"]["editor"]) ? $customFields[$field]["config"]["editor"] : "tagbox";
                            $relationModuleData = $idDictList[$customFields[$field]["config"]['relation_module_id']];
                            $relationModuleCode = $relationModuleData["code"];
                            $requestFilter['editor'] = $editor;
                            $requestFilter['field'] = $horizontalRelationshipFieldUseField;
                            $requestFilter['module_code'] = $customFields[$field]['code'];
                            $requestFilter['table'] = $relationModuleData["type"] == "entity" ? "Entity" : $relationModuleCode;
                        }
                    } elseif ($masterModuleData["code"] == $requestFilter["module_code"]) {
                        array_push($filterRequest, $requestFilter);
                        continue;
                    }
                }
                if (!in_array($field, $fieldsData[$key]['fields'])) {
                    $fieldsData[$key]['fields'][] = $field;
                }
                array_push($filterPanel, $requestFilter);
            }
        }
        //排序数据
        $order = $param["order"];
        $sort = [];
        foreach ($order as $orderKey => $orderValue) {
            list($moduleCode, $field) = explode('.', $orderKey);
            $replaceString = str_replace('.', "_", str_replace("task", "base", $orderKey));
            $moduleCode = str_replace('task', 'base', $moduleCode);
            if (!array_key_exists($moduleCode, $fieldsData)) {
                throw_strack_exception($orderKey . ' ' . L('Order_Error'), 401012);
            }
            $sort[$replaceString] = [
                'type' => $orderValue,
                'field' => $field,
                'field_type' => array_key_exists($field, $fieldsData[$moduleCode]['raw_data']["custom_field"]) ? 'custom' : 'built_in',
                'value_show' => $replaceString,
                'module_code' => $moduleCode
            ];
        }
        $filter = [
            'sort' => $sort,
            'request' => $filterRequest,
            'filter_panel' => $filterPanel,
            "filter_input" => [],
            'filter_advance' => [],
        ];
        return $filter;
    }

    /**
     * 生成fields相关的结构数据
     * @param $param
     * @param $master
     * @param $projectId
     * @return array
     */
    protected function generateFields($param, $master, $projectId)
    {
        $fieldInfo = $param["fields"];
        $moduleRelationData = $this->getModuleRelationData($master);
        $tableList = array_keys($fieldInfo);
        $fieldsData = [];
        foreach ($tableList as $table) {
            $tableConfig = $this->getTableConfig($table, $projectId);
            $fixedFields = array_keys($tableConfig["fixed_field"]);
            $customFields = $tableConfig["custom_field"];
            $customFieldsData = empty($customFields) ? [] : array_column($customFields, null, "code");
            $fields = array_merge($fixedFields, array_keys($customFieldsData));
            //存在字段
            if (!empty($fieldInfo[$table] && $fieldInfo[$table] !== "*")) {
                //返回字段交集
                $fields = array_intersect($fieldInfo[$table], $fields);
                if (!in_array("id", $fields)) {
                    array_push($fields, "id");
                }
            }
            if ($this->currentController !== "entity" && !empty($moduleRelationData)) {
                //link表加入link_id
                if (in_array("link_id", $fixedFields) && !in_array("link_id", $fields)) {
                    array_push($fields, "link_id");
                } elseif (
                    array_key_exists($table, $moduleRelationData)
                    && $moduleRelationData[$table] == "has_many"
                    && !array_key_exists($table, $this->entityModule)
                    && in_array($master . "_id", $fixedFields)
                )
                    //关系为一对多的加入主表code+Id拼装的字段
                    array_push($fields, $master . "_id");
            }
            $fieldsData[$table]["fields"] = $fields;
            $fieldsData[$table]["raw_data"] = [
                "custom_field" => $customFieldsData,
                "fixed_field" => $fixedFields
            ];
        }
        if (array_key_exists("media", $fieldsData) && !in_array("param", $fieldsData["media"]["fields"])) {
            array_push($fieldsData["media"]["fields"], "param");
        }
        return $fieldsData;
    }


    /**
     * 获取项目Id
     * @param array $filter
     * @return array
     */
    private function getProjectIds($filter = [])
    {
        $projectData = (new CommonService('project'))->select(["filter" => $filter, "fields" => ["id"]])["data"]["rows"];
        $projectIds = array_column($projectData, 'id');
        return $projectIds;
    }

    /**
     * 获取关联表关系
     * @param $code
     * @return array
     */
    public function getModuleRelationData($code)
    {
        $schemaService = new SchemaService();
        $schemaData = $schemaService->getSchemaData(["code" => $code]);
        if (empty($schemaData)) {
            return [];
        }
        $moduleRelationData = $schemaService->getModuleRelationData(["schema_id" => $schemaData["id"]]);
        //获取关联表关系
        $data = [];
        foreach ($moduleRelationData["rows"] as $value) {
            $data[$value["dst_module_code"]] = $value["type"];
        }
        return $data;
    }

    /**
     * 验证更新参数
     * @param $param
     * @return bool
     */
    protected function checkUpdateParam($param)
    {
        $projectId = 0;
        if (array_key_exists("id", $param)) {
            //查找数据
            $data = (new CommonService(CONTROLLER_NAME))->find(["filter" => ["id" => $param["id"]]])["data"];
            if (empty($data)) {
                $this->errorNumber = 401011;
                $this->errorMessage = L('Data_Not_Exist');
                return false;
            }

            if (array_key_exists("project_id", $param)) {
                $projectId = $param["project_id"];
            } elseif (array_key_exists("project_id", $data)) {
                $projectId = $data["project_id"];
            }

            $resData = $this->formatCreateAndUpdate($param, $projectId);
            if (false !== $resData) {
                $resData["extra_data"]["primary_id"] = $param["id"];
            }
            return $resData;
        } else {
            $this->errorMessage = L("Primary_Not_Exist");
            $this->errorNumber = 401005;
            return false;
        }

    }

    /**
     * 验证删除参数
     * @param $param
     * @return bool
     */
    protected function checkDeleteParam($param)
    {
        //检查主键
        if (array_key_exists("id", $param)) {
            $resData = ["id" => $param["id"]];
        } else {
            $this->errorMessage = L("Primary_Not_Exist");
            $this->errorNumber = 401005;
            $resData = false;
        }
        return $resData;
    }


    /**
     * 检查获得文件路径参数
     * @param $param
     * @return bool
     */
    public function checkGetTemplatePathParam($param)
    {
        $requireParam = ["module_id", "link_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查创建系统Schema参数
     * @param $param
     * @return bool
     */
    public function checkCreateSchemaStructureParam($param)
    {
        $requireParam = ["name", "code", "relation_data"];
        foreach ($param as $value) {
            if (!$this->checkRequireParam($requireParam, $value)) {
                return false;
            }
        }
        return $param;
    }

    /**
     * 检查查找单条Schema参数
     * @param $param
     * @return bool
     */
    public function checkGetSchemaStructureParam($param)
    {
        $requireParam = ["schema_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }


    /**
     * 检查修改Schema参数
     * @param $param
     * @return bool
     */
    public function checkUpdateSchemaStructureParam($param)
    {
        $requireParam = ["schema_param", "relation_data"];
        //必填的schema_id
        if ($this->checkRequireParam($requireParam, $param) && $this->checkRequireParam(["schema_id"], $param["schema_param"])) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 删除Schema参数
     * @param $param
     * @return bool
     */
    public function checkDeleteSchemaStructureParam($param)
    {
        $requireParam = ["schema_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查获得指定服务器配置参数
     * @param $param
     * @return bool
     */
    public function checkGetMediaServerItemParam($param)
    {
        $requireParam = ["server_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param["server_id"];
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查创建media参数
     * @param $param
     * @return bool
     */
    public function checkCreateMediaParam($param)
    {
        $requireParam = ["media_data", "media_server", "link_id", "module_id", "type"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $param["mode"] = $param["type"] == "attachment" ? "multiple" : "";
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查更新media参数
     * @param $param
     * @return bool
     */
    public function checkUpdateMediaParam($param)
    {
        $requireParam = ["media_data", "media_server", "link_id", "module_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $param["mode"] = "";
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;

    }

    /**
     * 检查获取media参数
     * @param $param
     * @return bool
     */
    public function checkGetMediaDataParam($param)
    {
        $requireParam = ["filter"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param["filter"];
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查获取指定尺寸的媒体缩略图路径参数
     * @param $param
     * @return bool
     */
    public function checkGetSpecifySizeThumbPathParam($param)
    {
        $requireParam = ["filter", "size"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 获取多个媒体信息
     * @param $param
     * @return bool
     */
    public function checkSelectMediaDataParam($param)
    {
        $requireParam = ["server_id", "md5_name_list"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查获取文件真实路径参数
     * @param $param
     * @return bool
     */
    public function checkGetItemPathParam($param)
    {
        $requireParam = ["module_id", "link_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查创建水平关联数据参数
     * @param $param
     * @return bool
     */
    public function checkCreateHorizontalParam($param)
    {
        $requireParam = ["src_module_id", "src_link_id", "dst_module_id", "dst_link_id", "variable_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查获取配置参数
     * @param $param
     * @return bool
     */
    public function checkGetOptionsParam($param)
    {
        $requireParam = ["options_name"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查更新配置参数
     * @param $param
     * @return bool
     */
    public function checkUpdateOptionsParam($param)
    {
        $requireParam = ["options_name", "config"];
        if (!$this->checkRequireParam($requireParam, $param)) {
            $resData = false;
        } else {
            $resData = $param;
        }
        return $resData;
    }

    /**
     * 检查添加配置参数
     * @param $param
     * @return bool
     */
    public function checkAddOptionsParam($param)
    {
        $requireParam = ["options_name", "config"];
        if (!$this->checkRequireParam($requireParam, $param)) {
            $resData = false;
        } else {
            $resData = $param;
        }
        return $resData;
    }

    /**
     * 检查添加计时器参数
     * @param $param
     * @return bool
     */
    public function checkStartTimerParam($param)
    {
        $requireParam = ["user_id", "module_id", "link_id", "project_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $param["id"] = $param["link_id"];
            $resData = $param;
        } else {
            $resData = false;
        }

        return $resData;
    }

    /**
     * 检查停止计时器参数
     * @param $param
     * @return bool
     */
    public function checkStopTimerParam($param)
    {
        $requireParam = ["id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查创建默认视图参数
     * @param $param
     * @return bool
     */
    public function checkCreateDefaultViewParam($param)
    {
        $requireParam = ["name", "code", "config", "page", "project_id"];
        if (!$this->checkRequireParam($requireParam, $param)) {
            $resData = false;
        } else {
            $resData = $param;
        }
        return $resData;
    }

    /**
     * 检查默认
     * @param $param
     * @return bool
     */
    public function checkFindDefaultViewParam($param)
    {

        if (!array_key_exists("filter", $param) || empty($param["filter"])) {
            $this->errorMessage = L("Filter_Null");
            $this->errorNumber = 401003;
            return false;
        }
        $filterData = $param["filter"];
        $tableFields = ["id" => "", "name" => "", "code" => "", "page" => "", "config" => "", "project_id" => "", "uuid" => ""];
        $diff = array_diff_key($filterData, $tableFields);

        if (empty($diff)) {
            return $filterData;
        } else {
            $errorData = implode(",", array_keys($diff));
            $this->errorNumber = 401015;
            $this->errorMessage = $errorData . ' ' . L("Illegal_Field");
            return false;
        }
    }

    /**
     * 检查删除默认视图参数
     * @param $param
     * @return bool
     */
    public function checkDeleteDefaultViewParam($param)
    {
        $requireParam = ["page", "project_id"];
        if (!$this->checkRequireParam($requireParam, $param)) {
            return false;
        } else {
            return $param;
        }
    }

    /**
     * 创建Entity模块
     * @param $param
     * @return bool
     */
    public function checkCreateEntityModuleParam($param)
    {
        $requireParam = ["name", "code"];
        foreach ($param as $value) {
            if (!$this->checkRequireParam($requireParam, $value)) {
                return false;
            }
        }
        return $param;
    }

    /**
     * 检查多条查找节点权限
     * @param $param
     * @return bool|array
     */
    public function checkSelectNodeAuthParam($param)
    {
        $requireParam = ["filter"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = [];
        }
        return $resData;
    }

    /**
     * 检查创建父节点权限参数
     * @param $param
     * @return bool
     */
    public function checkCreateParentAuthParam($param)
    {
        $requireParam = ["name", "code", "lang"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $param["parent_id"] = 0;
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查创建子节点权限参数
     * @param $param
     * @return bool
     */
    public function checkCreateChildAuthParam($param)
    {
        $requireParam = ["name", "code", "lang", "parent_id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查获取节点权限参数
     * @param $param
     * @return bool
     */
    public function checkGetNodeAuthParam($param)
    {
        $requireParam = ["node"];
        if (!$this->checkRequireParam($requireParam, $param)) {
            $resData = false;
        } else {
            $resData = $param["node"];
        }
        return $resData;
    }

    /**
     * 检查修改节点参数
     * @param $param
     * @return bool
     */
    public function checkUpdateNodeAuthParam($param)
    {
        $requireParam = ["id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查删除节点参数
     * @param $param
     * @return bool
     */
    public function checkDeleteNodeAuthParam($param)
    {
        $requireParam = ["id"];
        if ($this->checkRequireParam($requireParam, $param)) {
            $resData = $param;
        } else {
            $resData = false;
        }
        return $resData;
    }

    /**
     * 检查字段请求参数
     * @param $param
     * @return bool
     */
    public function checkFieldsParam($param)
    {
        $resData = $this->getRelationTableConfig($param);
        return $resData;
    }

    /**
     * 检查登录参数
     * @param $param
     * @return bool
     */
    public function checkInParam($param)
    {
        $requestParam = ['login_name', "password", "method", "server_id"];
        $resData = $this->checkRequireParam($requestParam, $param);
        if (false === $resData) {
            $resData = false;
        } else {
            $resData = $param;
        }
        return $resData;
    }

    /**
     * 检查获取字段参数
     * @param $param
     * @return bool
     */
    public function checkGetTableConfigParam($param)
    {
        $requestParam = ["table"];
        $check = $this->checkRequireParam($requestParam, $param);
        if (false === $check) {
            return false;
        } else {
            return $param["table"];
        }
    }

    /**
     * 检查更新表参数
     * @param $param
     * @return bool
     */
    public function checkUpdateTableConfigParam($param)
    {
        $requestParam = ["table", "config"];
        $check = $this->checkRequireParam($requestParam, $param);
        if (false === $check) {
            return false;
        } else {
            return $param;
        }
    }

    /**
     * 检查获取指定项目模板路径
     * @param $param
     * @return bool
     */
    public function checkFindTemplatePathParam($param)
    {
        if (!array_key_exists("filter", $param) || empty($param["filter"])) {
            $this->errorMessage = L("Filter_Null");
            $this->errorNumber = 401003;
            return false;
        }
        $filterData = $param["filter"];
        $allowedKey = ["id" => "", "pattern" => "", "code" => "", "parent_id" => "", "disk_id" => "", "module_id" => "", "project_id" => "", "type" => "", "rule" => "", "created_by" => "", "created" => "", "uuid" => ""];
        $diff = array_diff_key($filterData, $allowedKey);
        if (empty($diff)) {
            return $filterData;
        } else {
            $errorData = implode(",", array_keys($diff));
            $this->errorNumber = 401015;
            $this->errorMessage = $errorData . ' ' . L("Illegal_Field");
            return false;
        }
    }

    /**
     * 检查创建自定义字段参数
     * @param $param
     * @return array|bool
     */
    public function checkCreateVariableParam($param)
    {
        $requestParam = ["name", "code", "module_id", "project_id", "config", "type", "action_scope"];
        $data = $this->checkRequireParam($requestParam, $param);
        if (!$data) {
            return false;
        }
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
        if (empty($moduleData)) {
            $this->errorMessage = L("Model_Not_Exist");
            $this->errorNumber = 401017;
            return false;
        }
        //检查水平关联模块
        if ($param["type"] == "horizontal_relationship") {
            $relationModuleId = isset($param["config"]["relation_module_id"]) ? $param["config"]["relation_module_id"] : 0;
            $horizontalService = new HorizontalService();
            $relationModuleData = $horizontalService->getHorizontalRelationList(["module_id" => $param["module_id"]]);
            //关联过的模块
            $allowRelationModule = array_column($relationModuleData, "dst_module_id");
            if (empty($allowRelationModule) || !in_array($relationModuleId, $allowRelationModule)) {
                $this->errorMessage = L("Horizontal_Module_Not_Allow");
                $this->errorNumber = 401016;
                return false;
            }
        }
        $authData = [
            "name" => $param["name"],
            "code" => $param["code"],
            "module_code" => $moduleData["code"],
            "module_id" => $param["module_id"],
            "project_id" => $param["project_id"]
        ];
        return $authData;
    }

    /**
     * 检查必要参数
     * @param $requireParamList
     * @param array $param
     * @return bool
     */
    public function checkRequireParam($requireParamList, $param)
    {
        foreach ($requireParamList as $value) {
            if (!array_key_exists($value, $param)) {
                $this->errorMessage = strtoupper($value) . ' ' . L("Required_Param_Not_Exist");
                $this->errorNumber = 401007;
                return false;
            }
        }
        return true;
    }

    /**
     * 获取单个表配置
     * @param $tableName
     * @param int $projectId
     * @return array
     */
    protected function getTableConfig($tableName, $projectId = 0)
    {
        $fieldsConfig = $this->getTableFieldsInfo($tableName);
        //获取字段
        $fixedFields = [];
        array_walk($fieldsConfig, function ($value) use ($tableName, &$fixedFields) {
            if (!($tableName == "user" && in_array($value["id"], ["password", "login_session"]))) {
                $fixedFields[$value["id"]] = $value["type"];
            }
        });
        //获取自定义字段
        $customFields = (new VariableService())->getAllCustomFieldsList($this->moduleMap[$tableName]["id"], $projectId);
        $fieldsData = [
            "fixed_field" => $fixedFields,
            "custom_field" => $customFields,
        ];
        return $fieldsData;
    }

    /**
     * 获取表详情
     * @param $tableName
     * @return mixed
     */
    private function getTableFieldsInfo($tableName)
    {
        if (array_key_exists($tableName, $this->fieldsData)) {
            $fieldsConfig = $this->fieldsData[$tableName];
        } else {
            $schemaService = new SchemaService();
            //处理entity表名
            $disposeTableName = array_key_exists($tableName, $this->entityModule) ? "entity" : $tableName;
            //获取表配置
            $fieldsConfig = $schemaService->getTableFieldData($disposeTableName);

            $this->fieldsData[$tableName] = $fieldsConfig;
        }
        return $fieldsConfig;
    }

    /**
     * 返回字段的指定项信息
     * @param $tableName
     * @param $field
     * @return mixed
     */
    private function getFieldSpecifyData($tableName, $field)
    {
        $fieldsData = $this->getTableFieldsInfo($tableName);

        foreach ($fieldsData as $item) {
            if ($item["id"] == $field) {
                return $item;
            }
        }
        throw_strack_exception($field . "_" . L("Field_Error"), 401004);
    }

    /**
     * 获取关联表配置
     * @param $param
     * @return mixed
     */
    protected function getRelationTableConfig($param)
    {
        $module = $param["module"];
        $projectId = array_key_exists("project_id", $param) && is_numeric($param["project_id"]) ? $param["project_id"] : 0;
        //获得主表配置
        $tableConfig = $this->getTableConfig(un_camelize($module["code"]), $projectId);
        $ModuleRelationData = $this->getModuleRelationData($module["code"]);
        //关联表数据
        $relationTableData = !empty($ModuleRelationData) ? array_keys($ModuleRelationData) : [];
        if (!empty($relationTableData)) {
            foreach ($relationTableData as $value) {
                //适配base转换为task
                $tableConfig["relation"][$value == "base" ? "task" : $value] = $this->getTableConfig($value, $projectId);
            }
        }

        return $tableConfig;
    }
}