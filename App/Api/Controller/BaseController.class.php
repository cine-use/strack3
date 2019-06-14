<?php

namespace Api\Controller;

use Common\Controller\VerifyController;
use Common\Service\CommonService;
use Common\Service\SchemaService;


class BaseController extends VerifyController
{
    /**
     * CommonService 对象
     * @var \Common\Service\CommonService
     */
    protected $commonService;

    // 最大分页数量
    protected $maxPageSize = 10000;

    // 处理好的请求数据
    protected $requestParam = [];

    // 模块映射字典
    protected $moduleMapData = [];

    // 查询的模块映射字典
    protected $moduleQueryMapData = [];

    // 查询项目ID
    protected $queryProjectId = [];

    // 允许访问 module
    protected $allowModel = [
        "Action", "Calendar", "Department", "DirTemplate", "DirVariable", "Disk", "Entity", "File", "Follow", "HorizontalConfig", "Horizontal", "Media", "Member", "Note", "Onset", "ProjectDisk", "ProjectMember", "Project", "ProjectTemplate", "Status", "Step", "TagLink", "Tag", "TimelogIssue", "Timelog", "UserConfig", "Variable", "VariableValue", "User", "FileCommit", "FileType", "Task", "CommonAction", "OnsetLink", "ReviewLink", "Role", "RoleUser", "View", "ViewUse"
    ];

    // 包含 project_id 的 module
    protected $exitsProjectIdModuleList = ["action", "base", "entity", "dir_template", "dir_variable", "file", "file_commit", "file_type", "member", "note", "onset", "project_disk", "project_member", "project_template", "review_link", "timelog", "variable", "view", "view_default"];

    /**
     * 初始化
     * @return bool|void
     */
    public function _initialize()
    {
        parent::_initialize();

        // 获取模块字典映射数据
        $this->getModuleMapData($this->currentAction);

        // 获取api请求数据
        $param = $this->request->param();

        $this->checkParam($param, $this->currentAction);

        // 实例化通用模型
        if (in_array($this->currentAction, ["find", "select", "delete", "update", "create"])) {
            $this->initCommonService();
        }
    }

    /**
     * 处理请求参数
     * @param $method
     */
    protected function getModuleMapData($method)
    {
        //需要module参数的方法
        if (in_array($method, ["find", "select", "create", "update"])) {
            $schemaService = new SchemaService();
            $this->moduleMapData = $schemaService->getModuleMapData();
        }
    }

    /**
     * 获取指定模块所有自定义字段配置
     * @param $filterModuleKeyList
     * @param $projectIds
     * @return array
     */
    protected function getModuleAllCustomFieldMapData($filterModuleKeyList, $projectIds)
    {
        $schemaService = new SchemaService();
        return $schemaService->getModuleAllCustomFieldConfig($filterModuleKeyList, $projectIds);
    }

    /**
     * 初始化Common Service
     */
    protected function initCommonService()
    {
        if (in_array(CONTROLLER_NAME, $this->allowModel)) {
            $this->commonService = new CommonService(CONTROLLER_NAME);
        }
    }

    /**
     * 检查是否有模块参数
     * @param $param
     */
    protected function checkModuleParam($param)
    {
        if (!(array_key_exists("module", $param) && !empty($param["module"]))) {
            throw_strack_exception(L("Param_Error"));
        }
    }

    /**
     * 检查参数
     * @param $param
     * @param $method
     */
    protected function checkParam($param, $method)
    {
        if (!in_array($this->currentController, ["core", "login", "dirtemplate", "options", "media"])) {
            $this->checkModuleParam($param);
        }

        //调用的方法
        $checkFunction = "check" . ucfirst($method) . "Param";
        if (method_exists($this, $checkFunction)) {
            $this->requestParam = call_user_func([$this, $checkFunction], $param);
        } else {
            $this->requestParam = $param;
        }
    }

    /**
     * 检查find查询参数
     * @param $param
     * @return array
     */
    protected function checkFindParam($param)
    {
        return $this->checkSelectParam($param);
    }

    /**
     * 检查select查询参数
     * @param $param
     * @return array
     */
    protected function checkSelectParam($param)
    {
        // 判断是否有 fields 参数
        $param["fields"] = array_key_exists("fields", $param) ? $param["fields"] : [];

        // 把 filter 里面出现的出现的 key 值放入 fields 中
        $filterModuleKeyList = [];
        if (array_key_exists('filter', $param) && !empty($param['filter'])) {
            foreach ($param['filter'] as $key => $value) {
                $filterModuleKeyList[] = $key;
                if (!array_key_exists($key, $param["fields"])) {
                    $param["fields"][$key] = [];
                    if ($key === "tag" && $param["module"]["code"] !== "tag") {
                        $param["fields"]["tag_link"] = [];
                    }
                }
            }

            // 判断主表是否在 fields 里面
            if (!array_key_exists($param["module"]["code"], $param["fields"])) {
                $param["fields"][$param["module"]["code"]] = [];
            }
        }

        // 检查分页参数
        $this->checkPage($param);

        // 判断是否存在指定的project
        if (in_array($param["module"]["code"], $this->exitsProjectIdModuleList) || $param["module"]["type"] === "entity") {
            if (array_key_exists('project_id', $param) && !empty($param["project_id"])) {
                $projectIds = [$param["project_id"]];
            } else {
                $projectData = M("Project")->field("id")->select();
                $projectIds = array_column($projectData, "id");
            }
        } else {
            $projectIds = [0];
        }

        // 组装过滤条件
        if (!empty($filterModuleKeyList)) {
            $param["filter"] = $this->generateFilterData($param["filter"], $filterModuleKeyList, $projectIds);
        } else {
            $param["filter"] = [
                "request" => [],
                "filter_input" => [],
                "filter_panel" => [],
                "filter_advance" => []
            ];
        }

        // 获取排序条件
        if (array_key_exists("order", $param) && !empty($param["order"])) {
            $param["filter"]["sort"] = $this->checkOrder($param["order"]);
        }else{
            $param["filter"]["sort"] = [];
        }

        // 组装字段数据
        $param["fields"] = $this->checkFields($param["fields"], $param["module"]["code"]);

        // 组装最终的查询条件
        return $this->generateQueryFilter($param, $projectIds);
    }

    /**
     * 组装最终查询条件
     * @param $param
     * @param $projectIds
     * @return array
     */
    protected function generateQueryFilter($param, $projectIds)
    {
        $params = [];

        // 组装最终的查询条件
        $param["fields"]["master"]["pagination"] = $param["page"];
        $queryParam = [
            "filter" => $param["filter"],
            "master" => $param["fields"]["master"],
            "relation" => $param["fields"]["relation"]
        ];

        // 加入项目ID过滤条件
        $projectList = !empty($this->queryProjectId) ? $this->queryProjectId : $projectIds;

        foreach ($projectList as $projectId) {
            $projectFilter = [
                "field" => "project_id",
                "value" => $projectId,
                "condition" => "EQ",
                "module_code" => "project",
                "table" => "Project",
                "editor" => "text",
                "variable_id" => 0,
                "field_type" => "built_in"
            ];
            array_push($queryParam["filter"]["filter_panel"], $projectFilter);
            $queryParam["project_id"] = $projectId;
            $params[] = $queryParam;
        }

        return $params;
    }

    /**
     * 获取过滤条件格式
     * @param $field
     * @param $queryData
     * @param bool $isHorizontal
     * @return array
     */
    protected function getFilterFormat($field, $queryData, $isHorizontal = false)
    {
        list($expression, $expressionValue) = $queryData["filter_item"];
        $resData = [
            "field" => $isHorizontal ? $queryData["field_query"] : $field["id"],
            "value" => $expressionValue,
            "condition" => $expression,
            "module_code" => $isHorizontal ? $queryData["field_code"] : $field["module_code"],
            "table" => $isHorizontal ? string_initial_letter($field["module_code"]) : $field["table"],
            "editor" => $field["editor"],
            "variable_id" => array_key_exists("variable_id", $field) ? $field["variable_id"] : 0,
            "field_type" => $field["field_type"]
        ];
        return $resData;
    }

    /**
     * 组装过滤条件
     * @param $filter
     * @param $filterModuleKeyList
     * @param $projectIds
     * @return array
     */
    protected function generateFilterData($filter, $filterModuleKeyList, $projectIds)
    {
        // 查回指定表的字段配置
        $moduleFieldsMap = $this->getModuleAllCustomFieldMapData($filterModuleKeyList, $projectIds);

        $this->moduleQueryMapData = $moduleFieldsMap;
        // 组装过滤条件
        $filterList = [
            "request" => [],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance" => []
        ];

        foreach ($filter as $moduleCode => $fieldsList) {
            foreach ($fieldsList as $field => $fieldItem) {
                // 水平关联字段格式：assign.id 需要拆分后处理
                $explodeField = explode(".", $field);
                // 取字典数据时使用
                $fieldCode = count($explodeField) > 1 ? array_first($explodeField) : $field;
                // 查询字段
                $fieldQuery = count($explodeField) > 1 ? end($explodeField) : $field;

                // 如果当前字段不在字段字典中
                if (!array_key_exists($fieldCode, $moduleFieldsMap[$moduleCode])) {
                    throw_strack_exception(L("Field_Error"));
                }

                if ($moduleFieldsMap[$moduleCode][$fieldCode]["field_type"] === "custom") {
                    $projectId = $moduleFieldsMap[$moduleCode][$fieldCode]["project_id_value"];
                    if (in_array($projectId, $projectIds) && !in_array($projectId, $this->queryProjectId)) {
                        $isHorizontal = $moduleFieldsMap[$moduleCode][$fieldCode]["type"] === "horizontal_relationship" ? true : false;
                        $filterData = $this->getFilterFormat($moduleFieldsMap[$moduleCode][$fieldCode], [
                            "field_code" => $fieldCode,
                            "field_query" => $fieldQuery,
                            "filter_item" => $fieldItem,
                        ], $isHorizontal);
                        array_push($filterList["filter_panel"], $filterData);
                        array_push($this->queryProjectId, $moduleFieldsMap[$moduleCode][$fieldCode]["project_id_value"]);
                    }
                } else {
                    $filterData = $this->getFilterFormat($moduleFieldsMap[$moduleCode][$fieldCode], [
                        "field_code" => $fieldCode,
                        "field_query" => $fieldQuery,
                        "filter_item" => $fieldItem,
                    ]);
                    array_push($filterList["filter_panel"], $filterData);
                }
            }
        }

        return $filterList;
    }

    /**
     * 检查字段参数
     * @param $fields
     * @param $masterCode
     * @return array
     */
    protected function checkFields($fields, $masterCode)
    {
        $fieldData = [
            "master" => [],
            "relation" => []
        ];

        if(!empty($fields)){
            foreach ($fields as $moduleCode => $fieldItem) {
                if (array_key_exists($moduleCode, $this->moduleQueryMapData) && empty($fieldItem)) {
                    $fieldList = array_column($this->moduleQueryMapData[$moduleCode], "fields");
                    if ($masterCode === $moduleCode) {
                        $fieldData["master"] = [
                            "module_code" => $masterCode,
                            "fields" => join(",", $fieldList)
                        ];
                    } else {
                        $fieldData["relation"][] = [
                            "module_code" => $moduleCode,
                            "fields" => join(",", $fieldList)
                        ];
                    }
                } else {
                    if ($masterCode === $moduleCode) {
                        $fieldData["master"] = [
                            "module_code" => $masterCode,
                            "fields" => $fieldItem
                        ];
                    } else {
                        $fieldData["master"]["relation"][] = [
                            "module_code" => $moduleCode,
                            "fields" => $fieldItem
                        ];
                    }
                }
            }
        }else{
            $fieldData["master"] = [
                "module_code" => $masterCode,
                "fields" => 'id,name'
            ];
        }
        return $fieldData;
    }

    /**
     * 检查排序
     * @param $order
     * @return array
     */
    protected function checkOrder($order)
    {
        $sort = [];
        foreach ($order as $orderKey => $orderValue) {
            list($moduleCode, $field) = explode('.', $orderKey);
            $fieldKey = str_replace('.', "_", $orderKey);
            $moduleCode = str_replace('task', 'base', $moduleCode);
            if (array_key_exists($moduleCode, $this->moduleQueryMapData)) {
                $sort[$fieldKey] = [
                    'type' => $orderValue,
                    'field' => $field,
                    'field_type' => $this->moduleQueryMapData[$moduleCode][$field]["field_type"],
                    'value_show' => $fieldKey,
                    'module_code' => $moduleCode
                ];
            }
        }

        return $sort;
    }

    /**
     * 检查查询分页参数
     * @param $param
     */
    protected function checkPage(&$param)
    {
        // 处理分页参数
        if ($this->currentAction == "select") {
            if(array_key_exists("page", $param)){
                if (!array_key_exists("page_size", $param["page"]) || empty($param["page"]["page_size"])) {
                    $param["page"]["page_size"] = $this->maxPageSize;
                }

                if (!array_key_exists("page_number", $param["page"]) || empty($param["page"]["page_number"])) {
                    $param["page"]["page_number"] = 1;
                }
            }else{
                $param["page"] = [
                    'page_size' => $this->maxPageSize,
                    "page_number" => 1
                ];
            }
        } else {
            // find 查询
            $param["page"] = [
                'page_size' => 1,
                "page_number" => 1
            ];
        }
    }

    /**
     * 检查创建参数
     * @param $param
     */
    protected function checkCreateParam($param)
    {
        $this->requestParam = $this->generateModifyFormat($param, "create");
    }

    /**
     * 检查修改参数
     * @param $param
     */
    protected function checkUpdateParam($param)
    {
        // 获取主键ID
        $primaryId = 0;
        if (array_key_exists("filter", $param) && !empty($param["filter"])) {
            $primaryId = array_key_exists("id", $param["filter"]) ? $param["filter"]["id"] : 0;
        }

        $updateData = $this->generateModifyFormat($param, "update");
        $updateData["query_param"]["master"]["id"] = $primaryId;
        $updateData["extra_data"]["primary_id"] = $primaryId;

        $this->requestParam = $updateData;
    }

    /**
     * 获取自定义字段创建格式
     * @param $field
     * @param $moduleId
     * @param $projectId
     * @param $value
     * @return array
     */
    protected function getCustomCreateFormat($field, $moduleId, $projectId, $value)
    {
        $customData = [
            "module_id" => $moduleId,
            "variable_id" => $field["variable_id"],
            "type" => $field['type'],
            "value" => $value,
            "field_type" => $field["field_type"],
            "project_id" => $projectId,
            "module_code" => "variable_value",
            "relation_module_id" => array_key_exists("relation_module_id", $field) ? $field["relation_module_id"] : 0,
            "relation_module_code" => array_key_exists("relation_module_code", $field) ? $field["relation_module_code"] : "",
            "fields" => $field["fields"]
        ];

        return $customData;
    }

    /**
     * 生成创建/修改的参数
     * @param $param
     * @param $mode
     * @return array
     */
    protected function generateModifyFormat($param, $mode)
    {
        $masterData = [];
        $customResult = [];
        $projectId = 0;

        $masterCode = $param["module"]["code"];
        $moduleId = $param["module"]["id"];

        // 判断是否有添加的数据
        if (array_key_exists("data", $param) && !empty($param["data"])) {

            // 获取项目ID
            $projectId = array_key_exists("project_id", $param["data"]) ? $param["data"]["project_id"] : 0;
            // 如果为修改，判断当前模块是否有项目ID，有查询数据取项目ID
            if ($mode == "update") {
                // 判断是否存在指定的project
                if (in_array($masterCode, $this->exitsProjectIdModuleList)) {
                    $data = (new CommonService(CONTROLLER_NAME))->find(["filter" => ["id" => $param["filter"]["id"]]])["data"];
                    if (array_key_exists("project_id", $data)) {
                        $projectId = $data["project_id"];
                    }
                }
            }

            // 获取当前表的字段
            $moduleMapData = $this->getModuleAllCustomFieldMapData([$masterCode], [$projectId]);

            foreach ($param["data"] as $key => $value) {
                if (array_key_exists($key, $moduleMapData[$masterCode])) {
                    if ($moduleMapData[$masterCode][$key]["field_type"] === "custom") {
                        $customData = $this->getCustomCreateFormat($moduleMapData[$masterCode][$key], $moduleId, $projectId, $value);
                        array_push($customResult, $customData);
                    } else {
                        $masterData[$key] = $value;
                        $masterData["field_type"] = $moduleMapData[$masterCode][$key]["field_type"];
                        $masterData["project_id"] = $projectId;
                        $masterData["module_id"] = $moduleId;
                    }
                }
            }
        } else {
            $masterData = [];
        }

        $extrasData = [
            "module_id" => $moduleId,
            "project_id" => $projectId,
            "module_code" => $masterCode,
            "module" => $masterCode
        ];

        $resData = [
            "query_param" => [
                "master_data" => $masterData,
                "relation_data" => empty($customResult) ? [] : [$masterCode => $customResult]
            ],
            "extra_data" => $extrasData
        ];
        return $resData;
    }

    /**
     * 检查删除参数
     * @param $param
     * @return array|bool
     */
    protected function checkDeleteParam($param)
    {
        // 检查主键
        if (array_key_exists("id", $param["filter"])) {
            return ["id" => $param["filter"]["id"]];
        }
    }

    /**
     * 单个查找基础方法
     * @return \Think\Response
     */
    public function find()
    {
        $data = $this->relation();
        if ($data["total"] > 0) {
            $resData = $data["rows"][0];
        } else {
            $resData = [];
        }
        return $this->responseApiData(success_response('', $resData));
    }


    /**
     * 多个查找基础方法
     * @return \Think\Response
     */
    public function select()
    {
        $resData = $this->relation();
        return $this->responseApiData(success_response('', $resData));
    }

    /**
     * 关联查询
     * @return array
     */
    private function relation()
    {
        $total = 0;
        $resData = [];
        if (isset($this->commonService)) {
            foreach ($this->requestParam as $value) {
                try {
                    $relationData = $this->commonService->relation($value);
                    if ($relationData["data"]["total"] > 0) {
                        $total += $relationData["data"]["total"];
                        $resData = array_merge($resData, $relationData["data"]["rows"]);
                    }
                } catch (\Exception $e) {
                }
            }
        } else {
            $this->_empty();
        }
        return ["total" => $total, "rows" => $resData];
    }


    /**
     * 创建基础方法
     * @return \Think\Response
     */
    public function create()
    {
        if (isset($this->commonService)) {

            $extraData = $this->requestParam["extra_data"];
            $queryParam = $this->requestParam["query_param"];
            $resData = $this->commonService->addItemDialog($queryParam, $extraData);
            return $this->responseApiData($resData);
        } else {
            $this->_empty();
        }
    }

    /**
     * 更新基础方法
     * @return \Think\Response
     */
    public function update()
    {
        if (isset($this->commonService)) {
            $extraData = $this->requestParam["extra_data"];
            $queryParam = $this->requestParam["query_param"];
            try {
                $resData = $this->commonService->modifyItemDialog($queryParam, $extraData);
            } catch (\Exception $e) {
                $resData = ['message' => $e->getMessage(), "status" => $e->getCode(), "data" => []];
            }
            return $this->responseApiData($resData);

        } else {
            $this->_empty();
        }
    }

    /**
     * 删除基础方法
     * @return \Think\Response
     */
    public function delete()
    {
        if (isset($this->commonService)) {
            $resData = $this->commonService->delete($this->requestParam);
            return $this->responseApiData($resData);
        } else {
            $this->_empty();
        }
    }


    /**
     * 字段基础方法
     * @return \Think\Response
     */
    public function fields()
    {
        $schemaService = new SchemaService();
        $this->requestParam["module"]["module_id"] = $this->requestParam["module"]["id"];
        $fieldsData = $schemaService->getTableFieldConfig($this->requestParam["module"], $this->requestParam["project_id"]);
        return $this->responseApiData($fieldsData);
    }

    /**
     * 返回请求参数
     * @return array|bool
     */
    public function getParam()
    {
        return $this->requestParam;
    }

    /**
     * 返回结果处理
     * @param $data
     * @return \Think\Response
     */
    public function responseApiData($data)
    {
        if (is_array($data)) {
            $resData = $data;
        } else {
            $resData = success_response("", $data);
        }
        return json($resData);
    }
}