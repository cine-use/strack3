<?php
// +----------------------------------------------------------------------
// | 通用服务层
// +----------------------------------------------------------------------
// | 目录模板服务
// +----------------------------------------------------------------------
// | 错误编码头 216xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Api\Controller\CheckController;
use Common\Model\DirTemplateModel;


class DirTemplateService
{
    protected $dirTemplateModel;
    protected $schemaService;

    /**
     * DirTemplateService constructor.
     */
    public function __construct()
    {
        $this->dirTemplateModel = new DirTemplateModel();
        $this->schemaService = new SchemaService();
    }

    /**
     * 递归获取上级目录，直到根目录
     * @param $dirId
     * @param $projectId
     * @return array 里面有 pattern， module id，rule
     */
    public function getParentDirs($dirId, $projectId)
    {
        $collection = [];
        $filter = ["filter" => ["id" => $dirId, "project_id" => $projectId]];
        $ret = $this->dirTemplateModel->selectData($filter);

        // 如果查询结果为空，就返回空数组
        if (!isset($ret) || $ret["total"] <= 0) {
            return [];
        }

        list($data) = $ret["rows"];
        $path = ["path" => $data["pattern"], "module_id" => $data["module_id"], "rule" => $data["code"]];

        if (!empty($data["parent_id"]) && $data["id"] !== $data["parent_id"]) {
            $parentDir = $this->getParentDirs($data["parent_id"], $projectId);
            // 父目录加入数组
            array_push($collection, $parentDir);
        }
        //当前目录加入数组
        array_push($collection, $path);
        return $collection;
    }

    /**
     * 还原
     * @param $arrTmp
     * @return null
     */
    function reformatTree($arrTmp)
    {
        static $data = [];
        foreach ($arrTmp as $key => $value) {
            if (!isset($value["path"])) {
                $this->reformatTree($value);
            } else {
                $data[] = $value;
            }
        }
        return $data;
    }


    /**
     * 返回项目的disk根目录信息
     * @param $projectId
     * @return array
     */
    public function getProjectRootDirs($projectId)
    {
        $filter = ["filter" => ["project_id" => $projectId, "parent_id" => "0"]];
        $ret = $this->dirTemplateModel->selectData($filter);

        // 如果查询结果为空，就返回空数组
        if (!isset($ret) || $ret["total"] <= 0) {
            throw_strack_exception(L("Project_Root_Not_Exist"), 216004);
        }

        return success_response("", $ret["rows"]);
    }


    /**
     * 获取Entity相关信息
     * @param $entityId
     * @param $projectId
     * @return array
     */
    protected function getEntityModuleArray($entityId, $projectId)
    {
        if ($entityId == 0) {
            return [];
        }
        $info = [];
        $entityService = new EntityService();
        $result = [];
        $entityService->getParentInfo($entityId, $projectId, $result);
        $moduleMap = $this->schemaService->getModuleMapData('id');
        foreach ($result as $item) {
            if (empty($item) || !array_key_exists($item['id'], $moduleMap)) {
                continue;
            }
            $info[$moduleMap[$item['id']]['code']] = $item;
        }
        return $info;
    }


    /**
     * 获取关联数据
     * @param $param
     * @param $projectId
     * @return array
     */
    protected function getRelationData($param, $projectId)
    {
        $moduleData = $this->schemaService->getModuleFindData(["id" => $param["module_id"]]);
        //拼装查询参数的module
        $param["module"] = [
            "id" => $moduleData["id"],
            "code" => $moduleData["code"]
        ];
        //查询是否属于schema
        $schemaData = $this->schemaService->getSchemaData(["code" => $moduleData["code"]]);
        $fields = [];

        $checkController = new CheckController();
        if (!empty($schemaData)) {
            //表的关联关系
            $tableRelation = $checkController->getModuleRelationData($moduleData["code"]);
            foreach ($tableRelation as $key => $value) {
                //过滤掉关联关系为一对多的数据
                if ($value !== "has_many") {
                    $fields[$key] = [];
                }
            }
        }

        $untreatedQueryParam = ["filter" => [$param["module"]["code"] == "base" ? "task" : $param["module"]["code"] => ["id" => ["EQ", $param["link_id"]], "project_id" => ["EQ", $projectId]]], "module" => $param["module"], "fields" => $fields];
        list($queryData) = $checkController->checkRequestParam($untreatedQueryParam, "find");
        $queryParam = $queryData["query_param"];
        //要使用的Model
        $modelName = $moduleData["type"] == "entity" ? "Entity" : $param["module"]["code"];
        //查询数据
        $commonService = new CommonService($modelName);
        $data = $commonService->relation($queryParam)["data"];
        if ($data["total"] > 0) {
            list($result) = $data["rows"];
        } else {
            $result = [];
        }
        $masterFields = explode(",", $queryParam["master"]["fields"]);

        foreach ($masterFields as $value) {
            if (array_key_exists($value, $result)) {
                $result[$param["module"]["code"]][$value] = $result[$value];
            }
        }
        return $result;
    }

    /**
     * 获取过滤模板信息
     * @param $filter
     * @return bool|string
     */
    public function getFilterTemplatePath($filter)
    {
        $path = "";
        $data = $this->dirTemplateModel->findData(["filter" => $filter]);
        if (!empty($data)) {
            //路径数组
            $data = $this->reformatTree($this->getParentDirs($data["id"], $data["project_id"]));
            foreach ($data as $value) {
                $path = $path . $value["path"] . "/";
            }
            $path = substr($path, 0, -1);
        }
        return success_response("", $path);
    }

    /**
     * 获取目录模板信息
     * @param $param
     * @return bool|string
     */
    public function getTemplatePath($param)
    {
        $moduleData = $this->schemaService->getModuleFindData(["id" => $param["module_id"]]);
        if (empty($moduleData)) {
            throw_strack_exception(L("Module_Not_Exist", 216007));
        }
        if ($moduleData["type"] != "entity" && !in_array($moduleData["code"], ["file", "base", "project"])) {
            throw_strack_exception(L("Module_Not_Be_Allowed"), 216008);;
        }
        $linkData = $this->getLinkData($param, $moduleData);

        $rule = empty($param["code"]) ? "" : $param["code"];
        //dirTemplate中查找对应文件module的
        $dirTemplateData = $this->dirTemplateModel->findData(["filter" => ["module_id" => $param["module_id"], "project_id" => $linkData["project_id"], "code" => $rule]]);
        //模板不存在
        if (empty($dirTemplateData)) {
            throw_strack_exception(L("Template_Not_Exist"), 216010);
        }
        //路径数组
        $data = $this->getParentDirs($dirTemplateData["id"], $linkData["project_id"]);

        $linkArray = array_column($this->reformatTree($data), "path");

        //组装路径
        $path = "";
        foreach ($linkArray as $value) {
            // 组装成路径
            $path = $path . $value . "/";
        }
        return success_response("", substr($path, 0, -1));
    }

    /**
     * 获取关联数据
     * @param $param
     * @param $moduleData
     * @return mixed
     */
    public function getLinkData($param, $moduleData)
    {
        $module = $moduleData["type"] == "entity" ? "entity" : $moduleData["code"];
        //关联数据
        if ($module == "entity") {
            $filter = ["id" => $param["link_id"], "module_id" => $param["module_id"]];
        } else {
            $filter = ["id" => $param["link_id"]];
        }
        $commonService = new CommonService($module);
        $linkData = $commonService->find(["filter" => $filter])["data"];
        if (empty($linkData)) {
            throw_strack_exception(L("Link_Data_Not_Exist"), 216008);
        }
        return $linkData;
    }

    /**
     * 获得文件真实路径
     * @param $param
     * @return bool|mixed|string
     */
    public function getFilePath($param)
    {
        $moduleData = $this->schemaService->getModuleFindData(["id" => $param["module_id"]]);
        if (empty($moduleData)) {
            throw_strack_exception(L("Module_Not_Exist", 216007));
        }
        $linkData = $this->getLinkData($param, $moduleData);
        $projectId = $linkData["project_id"];

        //关联查询数据
        $relationData = $this->getRelationData($param, $projectId);

        $templatePath = $this->getTemplatePath($param)["data"];
        if ($moduleData["code"] == "file") {
            $nameRules = isset($relationData["file_type"]) ? $relationData["file_type"]["naming_rule"] : "";
            $templatePath = $templatePath . '/' . $nameRules;
        }

        preg_match_all("/(?:\{)(.*?)(?:\})/i", $templatePath, $result);
        list(, $linkItem) = $result;

        $data = [];
        $entityId = 0;
        $module = $moduleData["type"] == "entity" ? "entity" : $moduleData["code"];

        switch ($module) {
            case 'file':
                $fileModuleData = $this->schemaService->getModuleFindData(["id" => $relationData["file"]["module_id"]]);
                if (empty($fileModuleData)) {
                    break;
                }
                //去查base
                if ($fileModuleData["code"] == "base") {
                    $data = $this->getBaseRelationData(["link_id" => $relationData["file"]["link_id"]], $projectId);
                    $entityId = !empty($data) ? $data["base"]["entity_id"] : $entityId;
                }
                //去查entity
                if ($fileModuleData["type"] == "entity") {
                    $entityId = $relationData["file"]["link_id"];
                }
                break;
            case 'base':
                //去查entity
                $entityId = $relationData["base"]["entity_id"];
                break;
            case 'entity':
                $entityId = $relationData[$moduleData["code"]]["id"];
                break;
        }
        $entityData = $this->getEntityModuleArray($entityId, $projectId);
        $result = array_merge($relationData, $data, $entityData);
        $frameRange = "";
        foreach ($linkItem as $value) {
            $explodeData = explode(".", $value);
            if (count($explodeData) !== 2) {
                throw_strack_exception(L("Illegal_Path"), 216010, $templatePath);
            }
            list($table, $field) = $explodeData;
            $table = $table == "task" ? "base" : $table;
            if (isset($result[$table][$field])) {
                if ($table == "file" && $field == "frame_range" && !empty($result[$table][$field])) {
                    $frameRange = $result[$table][$field];
                    $endStr = explode(",", $frameRange);
                    $endStr = array_pop($endStr);
                    $endStr = explode("-", $endStr);
                    $endStr = array_pop($endStr);
                    $endStr = preg_replace('/\D/', '', $endStr);
                    $result[$table][$field] = "%" . strlen($endStr) . "d";
                }
                $templatePath = str_replace("{" . $value . "}", $result[$table][$field], $templatePath);
            }
        }
        $templatePath = empty($frameRange) ? $templatePath : $templatePath . " " . $frameRange;
        //检查是否拼接完成
        $status = strstr($templatePath, "{");
        if (false === $status) {
            return success_response("", $templatePath);
        } else {
            throw_strack_exception(L("Path_Not_Spliced_Completely"), 216009, $templatePath);
        }
    }

    /**
     * 获取任务信息
     * @param $param
     * @param $projectId
     * @return array
     */
    protected function getBaseRelationData($param, $projectId)
    {
        $resData = $this->getRelationData(["module_id" => 4, "link_id" => $param["link_id"]], $projectId);
        return $resData;
    }
}