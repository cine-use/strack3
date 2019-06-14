<?php
// +----------------------------------------------------------------------
// | 水平关联方法服务层
// +----------------------------------------------------------------------
// | 主要服务于水平关联数据处理
// +----------------------------------------------------------------------
// | 错误编码头 207xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\HorizontalConfigModel;
use Common\Model\HorizontalModel;
use Common\Model\ModuleModel;

class HorizontalService extends EventService
{
    /**
     * 更新水平关联数据
     * @param $param
     * @return array
     */
    public function modifyHRelationDestData($param)
    {
        $horizontalModel = new HorizontalModel();

        // 删除已经存在的
        if (!empty($param["up_data"]["delete"])) {
            $deleteFilter = [
                "src_link_id" => $param["param"]["src_link_id"],
                "src_module_id" => $param["param"]["src_module_id"],
                "dst_module_id" => $param["param"]["dst_module_id"],
                "variable_id" => $param["param"]["variable_id"],
                "dst_link_id" => ["IN", join(",", $param["up_data"]["delete"])]
            ];
            $resData = $horizontalModel->deleteItem($deleteFilter);
            if (!$resData) {
                // 删除水平关联失败错误码 003
                throw_strack_exception($horizontalModel->getError(), 224002);
            }
        }

        $resData = [];
        // 新增关联数据
        if (!empty($param["up_data"]["add"])) {
            $baseData = [
                "src_link_id" => $param["param"]["src_link_id"],
                "src_module_id" => $param["param"]["src_module_id"],
                "dst_module_id" => $param["param"]["dst_module_id"],
                "variable_id" => $param["param"]["variable_id"],
                "dst_link_id" => 0
            ];

            foreach ($param["up_data"]["add"] as $addId) {
                $baseData["dst_link_id"] = $addId;
                $resData = $horizontalModel->addItem($baseData);
                if (!$resData) {
                    // 添加水平关联失败错误码 001
                    throw_strack_exception($horizontalModel->getError(), 224001);
                }
            }
        }

        $message = L("Modify_Horizontal_Relation_Data_SC");
        if (session("event_from") === "strack_web") {
            // 获取消息返回数据
            $this->projectId = $param["param"]["project_id"];
            $this->message = $message;
            $this->messageFromType = 'widget_common';
            $this->messageOperate = 'update';
            $resData["id"] = $param["param"]["src_link_id"];
            return $this->afterModify($resData, ["id" => $param["param"]["src_module_id"]]);
        } else {
            // 返回成功数据
            return success_response($message, $resData);
        }
    }

    /**
     * 获取关联模块Ids
     * @param $filter
     * @param $fields
     * @return array
     */
    public function getModuleRelationIds($filter, $fields)
    {
        $horizontalModel = new HorizontalModel();
        $dstModuleData = $horizontalModel->field($fields)->where($filter)->select();
        return array_column($dstModuleData, $fields);
    }

    /**
     * 保存关联数据
     * @param $param
     * @param string $mode
     * @return array
     */
    public function saveHorizontalRelationData($param, $mode = "single")
    {
        $addData = [
            "src_link_id" => $param['link_id'],
            "src_module_id" => $param["module_id"],
            "dst_link_id" => $param["value"],
            "dst_module_id" => $param["relation_module_id"],
            "variable_id" => $param["variable_id"]
        ];

        switch ($mode) {
            case "batch":
                return $this->modifyDiffHorizontalData($addData);
                break;
            default:
                if (!empty($param["value"])) {
                    return $this->modifyHorizontal($addData);
                } else {
                    return $this->deleteHorizontal([
                        "src_link_id" => $param['link_id'],
                        "src_module_id" => $param["module_id"],
                        "variable_id" => $param["variable_id"]
                    ]);
                }
                break;
        }
    }

    /**
     * 获取关联数据
     * @param $filter
     * @return mixed
     */
    public function getHorizontalRelationData($filter)
    {
        $horizontalModel = new HorizontalModel();

        $relationData = $horizontalModel->alias("relation")
            ->join("LEFT JOIN strack_variable variable on variable.id = relation.variable_id")
            ->field("relation.src_link_id,relation.dst_link_id,relation.variable_id,variable.config")
            ->where($filter)
            ->select();

        return $relationData;
    }

    /**
     * 获取指定模块水平关联配置
     * @param $param
     * @return array
     */
    public function getModuleRelationConfig($param)
    {
        $options = [
            "fields" => "horizontal_config_id,src_module_id,dst_module_id,project_template_id",
            "filter" => [
                "src_module_id" => $param["module_id"],
                "dst_module_id" => $param["module_id"],
                "_logic" => "OR"
            ]
        ];
        $horizontalConfigModel = new HorizontalConfigModel();
        $moduleRelationList = $horizontalConfigModel->selectData($options);

        $existModuleRelationConfig = [];

        $moduleModel = new ModuleModel();
        foreach ($moduleRelationList["rows"] as $item) {
            array_push($existModuleRelationConfig, [
                "horizontal_config_id" => $item["horizontal_config_id"],
                "from" => $moduleModel->where(["id" => $item["src_module_id"]])->getField("name"),
                "to" => $moduleModel->where(["id" => $item["dst_module_id"]])->getField("name")
            ]);
        }
        return $existModuleRelationConfig;
    }

    /**
     * 添加水平关联配置
     * @param $param
     * @return array
     */
    public function addHorizontalConfig($param)
    {
        $addData = [
            "project_template_id" => $param["template_id"]
        ];

        $horizontalConfigModel = new HorizontalConfigModel();
        $message = "";
        // 开启事务
        $horizontalConfigModel->startTrans();
        try {
            foreach ($param["config"] as $item) {
                $addData["src_module_id"] = $item["from"];
                $addData["dst_module_id"] = $item["to"];
                $resData = $horizontalConfigModel->addItem($addData);
                if (!$resData) {
                    throw new \Exception($horizontalConfigModel->getError());
                }
                $horizontalConfigModel->commit(); // 提交事物
                $message = $horizontalConfigModel->getSuccessMassege();
            }
        } catch (\Exception $e) {
            $horizontalConfigModel->rollback(); // 事物回滚
            // 添加水平关联配置失败错误码 004
            throw_strack_exception($e->getMessage(), 223004);
        }

        // 返回成功数据
        return success_response($message);
    }

    /**
     * 添加水平关联数据
     * @param $param
     * @return array
     */
    public function addHorizontalData($param)
    {
        $horizontalConfigModel = new HorizontalConfigModel();
        $horizontalConfigData = $horizontalConfigModel->findData(["filter" => [["src_module_id" => $param["src_module_id"], ["dst_module_id" => $param["dst_module_id"]]]]]);
        // 水平关联配置为空新增配置
        if (empty($horizontalConfigData)) {
            $this->saveHorizontalConfig(["src_module_id" => $param["src_module_id"], "dst_module_id" => $param["dst_module_id"]]);
        }
        // 新增一条水平关联数据
        return $this->saveHorizontal($param);
    }

    /**
     * 保存关联配置
     * @param $param
     * @return array
     */
    public function saveHorizontalConfig($param)
    {
        $horizontalConfigModel = new HorizontalConfigModel();
        $resData = $horizontalConfigModel->addItem($param);
        if (!$resData) {
            // 保存水平配置失败错误码 009
            throw_strack_exception($horizontalConfigModel->getError(), 223009);
        } else {
            // 返回成功数据
            return success_response($horizontalConfigModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 保存关联关系
     * @param $param
     * @return array
     */
    public function saveHorizontal($param)
    {
        $horizontalModel = new HorizontalModel();
        $resData = $horizontalModel->addItem($param);
        if (!$resData) {
            // 添加关联关系失败错误码 010
            throw_strack_exception($horizontalModel->getError(), 223010);
        } else {
            // 返回成功数据
            return success_response($horizontalModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 保存实体初始化关联数据
     * @return array|bool|mixed
     */
    public function addInitialHorizontalConfigData()
    {
        // 获取实体module信息
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->where(["type" => "entity"])->select();

        $dstModuleList = $moduleData;
        $otherModuleData = $moduleModel->where(["code" => ["IN", "user,media,status"]])->select();
        $dstModuleData = array_merge($dstModuleList, $otherModuleData);

        // 处理成对应的数组
        $horizontalConfigData = [];
        foreach ($moduleData as $srcItem) {
            $srcModuleId = $srcItem["id"];
            foreach ($dstModuleData as $dstItem) {
                $dstModuleId = $dstItem["id"];
                if (in_array($dstItem["code"], ["media", "status"])) {
                    $type = "belong_to";
                } else {
                    $type = "has_many";
                }
                array_push($horizontalConfigData, [
                    'src_module_id' => $srcModuleId,
                    'dst_module_id' => $dstModuleId,
                    'project_template_id' => 0,
                    'type' => $type
                ]);
            }
        }

        $resData = [];
        $horizontalConfigModel = new HorizontalConfigModel();
        foreach ($horizontalConfigData as $dataItem) {
            $configId = $horizontalConfigModel->where([
                "src_module_id" => $dataItem["src_module_id"], "dst_module_id" => $dataItem["dst_module_id"]
            ])->getField("id");
            if (empty($configId)) {
                $resData = $horizontalConfigModel->addItem($dataItem);
            }
        }
        return $resData;
    }

    /**
     * 获取水平关联模块列表
     * @param $param
     * @return array
     */
    public function getHorizontalRelationList($param)
    {
        $horizontalConfigModel = new HorizontalConfigModel();
        $options = [
            'fields' => "id,dst_module_id,src_module_id",
            'filter' => ["src_module_id" => $param["module_id"], "type" => "has_many"]
        ];

        $moduleRelationList = $horizontalConfigModel->selectData($options);
        $existModuleRelationConfig = [];

        $moduleModel = new ModuleModel();
        foreach ($moduleRelationList["rows"] as $item) {
            $srcModuleName = $moduleModel->where(["id" => $item["src_module_id"]])->getField("name");
            $dstModuleName = $moduleModel->where(["id" => $item["dst_module_id"]])->getField("name");
            array_push($existModuleRelationConfig, [
                "id" => $item["id"],
                "dst_module_id" => $item["dst_module_id"],
                "name" => $srcModuleName . ' - ' . $dstModuleName
            ]);
        }
        return $existModuleRelationConfig;
    }

    /**
     * 获取实体关联模型列表（排除已经强关联的模型）
     * @param $param
     * @return array
     */
    public function getEntityRelationshipModuleList($param)
    {
        // 排除已经关联的模块
        $horizontalConfigModel = new HorizontalConfigModel();
        $existRelationModuleIndex = [];
        $options = [
            "fields" => "dst_module_id",
            "filter" => [
                "src_module_id" => $param["module_id"],
                "project_template_id" => $param["template_id"]
            ]
        ];
        $existRelationConfigData = $horizontalConfigModel->selectData($options);
        foreach ($existRelationConfigData["rows"] as $configItem) {
            array_push($existRelationModuleIndex, $configItem["dst_module_id"]);
        }

        $schemaService = new SchemaService();
        $projectTemplateModuleList = $schemaService->getProjectTemplateModuleList($param["template_id"]);
        $entityModuleList = [];
        foreach ($projectTemplateModuleList["entity"]["data"] as $entityItem) {
            if (!in_array($entityItem["module_id"], $existRelationModuleIndex) || $param["position"] === "first") {
                array_push($entityModuleList, [
                    "id" => $entityItem["module_id"],
                    "name" => $entityItem["name"],
                    "code" => $entityItem["code"]
                ]);
            }
        }
        return $entityModuleList;
    }

    /**
     * 修改水平关联数据
     * @param $param
     * @return array
     */
    public function modifyHorizontal($param)
    {
        $horizontalModel = new HorizontalModel();
        $horizontalId = $horizontalModel->where([
            "src_link_id" => $param["src_link_id"],
            "src_module_id" => $param["src_module_id"],
            "variable_id" => $param["variable_id"],
        ])->getField("id");

        if ($horizontalId > 0) {
            // 修改已存在的数据
            $param["id"] = $horizontalId;

            $resData = $horizontalModel->modifyItem($param);
            if (!$resData) {
                throw_strack_exception($horizontalModel->getError(), 223011);
            } else {
                return success_response($horizontalModel->getSuccessMassege(), $resData);
            }
        } else {
            // 添加数据
            return $this->saveHorizontal($param);
        }
    }

    /**
     * 删除水平关联数据
     * @param $param
     * @return array
     */
    public function deleteHorizontal($param)
    {
        $horizontalModel = new HorizontalModel();
        $resData = $horizontalModel->deleteItem($param);
        if (!$resData) {
            throw_strack_exception($horizontalModel->getError(), 223012);
        } else {
            return success_response($horizontalModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改差异水平关联数据
     * @param $param
     * @return array
     */
    public function modifyDiffHorizontalData($param)
    {
        $horizontalModel = new HorizontalModel();
        $horizontalList = $horizontalModel->selectData([
            "filter" => [
                "src_link_id" => $param["src_link_id"],
                "src_module_id" => $param["src_module_id"],
                "variable_id" => $param["variable_id"]
            ]
        ]);

        $requestHorizontalIds = explode(",", $param["dst_link_id"]);
        if ($horizontalList["total"] > 0) {
            $horizontalIds = array_column($horizontalList["rows"], "dst_link_id");
            // 获取Horizontal查询Horizontal比较不同，结果添加
            $diffAddHorizontalIds = array_diff($requestHorizontalIds, $horizontalIds);
            // 查询Horizontal获取Horizontal比较不同，结果删除
            $diffDeleteHorizontalIds = array_diff($horizontalIds, $requestHorizontalIds);
            // 删除已不存的Horizontal
            $horizontalModel->deleteItem([
                "dst_link_id" => ["IN", join(",", $diffDeleteHorizontalIds)],
                "src_link_id" => $param["src_link_id"],
                "src_module_id" => $param["src_module_id"],
                "variable_id" => $param["variable_id"],
            ]);
        } else {
            $diffAddHorizontalIds = $requestHorizontalIds;
        }

        if (!in_array("", $diffAddHorizontalIds) && !empty($diffAddHorizontalIds)) {
            $resData = [];
            foreach ($diffAddHorizontalIds as $horizontalIdItem) {
                $param["dst_link_id"] = $horizontalIdItem;
                $resData = $horizontalModel->addItem($param);
            }
            if (!$resData) {
                throw_strack_exception($horizontalModel->getError(), 223013);
            } else {
                return success_response($horizontalModel->getSuccessMassege(), $resData);
            }
        } else {
            return success_response($horizontalModel->getSuccessMassege(), ["status" => 200, "message" => L("Modify_Horizontal_Sc")]);
        }
    }
}