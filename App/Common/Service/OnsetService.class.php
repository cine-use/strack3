<?php
// +----------------------------------------------------------------------
// | Onset服务服务层
// +----------------------------------------------------------------------
// | 主要服务于Onset数据处理
// +----------------------------------------------------------------------
// | 错误编码头 213xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\OnsetLinkModel;
use Common\Model\OnsetModel;
use Common\Model\FieldModel;

class OnsetService
{
    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getOnsetGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $onsetModel = new OnsetModel();
        $resData = $onsetModel->getRelationData($schemaFields);

        // 返回数据
        return $resData;
    }

    /**
     * 获取实体或者任务Onset关联关系数据
     * @param $param
     * @return array
     */
    public function getItemOnsetLinkData($param)
    {
        if ($param["module_code"] === "base" && $param["module_type"] === "fixed") { // 任务
            // 获取所属entity_id 和 module_id
            $baseModel = new BaseModel();
            $entityData = $baseModel->field("entity_id,entity_module_id")->where(["id" => $param["item_id"]])->find();
            $entityModuleId = $entityData["entity_module_id"];
            $entityId = $entityData["entity_id"];
        } else {// 实体
            $entityModuleId = $param["module_id"];
            $entityId = $param["item_id"];
        }

        if ($entityId > 0 && $entityModuleId > 0) {
            // 判断是否存在关联的现场数据
            $onsetLinkModel = new OnsetLinkModel();
            $options = [
                "fields" => "onset_id",
                "filter" => [
                    "link_id" => $entityId,
                    "module_id" => $entityModuleId
                ]
            ];
            $onsetLinkData = $onsetLinkModel->findData($options);
            if (!empty($onsetLinkData)) {
                $onsetLinkData["has_link_onset"] = "yes";
                $onsetLinkData["entity_id"] = $entityId;
                $onsetLinkData["entity_module_id"] = $entityModuleId;
                $onsetLinkData["module_id"] = C("MODULE_ID")["onset"];
                $onsetLinkData["module_code"] = "onset";
                $onsetLinkData["module_type"] = "fixed";
                return success_response("", $onsetLinkData);
            } else {
                $resData = [
                    "has_link_onset" => "no",
                    "entity_id" => $entityId,
                    "module_id" => C("MODULE_ID")["onset"],
                    "entity_module_id" => $entityModuleId
                ];
                return success_response(L("Item_Onset_Link_Not_Exist"), $resData);
            }
        } else {
            // 非法操作 002
            throw_strack_exception(L("Illegal_Operation"), 213002);
        }
    }


    /**
     * 获取项目Onset列表数据
     * @param $param
     * @return mixed
     */
    public function getProjectOnsetList($param)
    {
        $options = [
            "fields" => "id,name",
            "filter" => ["project_id" => $param["project_id"]]
        ];
        $onsetModel = new OnsetModel();
        $onsetListData = $onsetModel->selectData($options);

        return $onsetListData["rows"];
    }

    /**
     * 添加实体关联Onset
     * @param $param
     * @return array
     */
    public function addEntityLinkOnset($param)
    {
        $onsetLinkModel = new OnsetLinkModel();
        $resData = $onsetLinkModel->addItem($param);
        if (!$resData) {
            // 添加关联现场数据失败错误码 003
            throw_strack_exception($onsetLinkModel->getError(), 213003);
        } else {
            // 返回成功数据
            return success_response($onsetLinkModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取关联得onset_id
     * @param $fliter
     * @return int|mixed
     */
    public function getLinkOnsetId($fliter)
    {
        $onsetLinkModel = new OnsetLinkModel();
        $onsetId = $onsetLinkModel->where($fliter)->getField("onset_id");
        if (!empty($onsetId)) {
            return $onsetId;
        } else {
            return 0;
        }
    }

    /**
     * 获取Onset详情数据
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getOnsetInfoData($param)
    {
        $onsetParam = [
            "module_code" => "onset",
            "module_type" => "fixed",
            "module_id" => C("MODULE_ID")["onset"],
            "schema_page" => "project_onset",
            "item_id" => $param["onset_id"],
            "project_id" => $param["project_id"],
            "template_id" => $param["template_id"],
            "category" => $param["category"],
        ];

        $param["schema_page"] = "project_{$onsetParam["module_code"]}";
        $commonService = new CommonService(string_initial_letter("Onset"));
        $resData = $commonService->getModuleItemInfo($onsetParam, $onsetParam["module_code"]);

        return $resData;
    }

    /**
     * 获取Onset关联附件数据
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getOnsetAttachment($param)
    {
        // 获取 note 媒体附件
        $mediaService = new MediaService();
        $mediasData = $mediaService->getMediaSelectData(["link_id" => $param["link_id"], "module_id" => $param["module_id"], "type" => "attachment"]);
        return $mediasData;
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
            $filter = [
                "id" => ["NOT IN", join(",", $param["link_data"])],
                "project_id" => $param["project_id"]
            ];
        } else {
            $filter = [
                "id" => ["IN", join(",", $param["link_data"])],
                "project_id" => $param["project_id"]
            ];
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

        $onsetModel = new OnsetModel();
        $horizontalRelationData = $onsetModel->selectData($option);

        return $horizontalRelationData;
    }
}