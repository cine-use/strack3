<?php
// +----------------------------------------------------------------------
// | Tag 标签服务
// +----------------------------------------------------------------------
// | 主要服务于Tag数据处理
// +----------------------------------------------------------------------
// | 错误编码头 235xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\TagLinkModel;
use Common\Model\TagModel;

class TagService extends EventService
{
    /**
     * 新增标签
     * @param $param
     * @return array
     */
    public function addTag($param)
    {
        $tagModel = new TagModel();
        $resData = $tagModel->addItem($param);
        if (!$resData) {
            // 添加标签失败错误码 010
            throw_strack_exception($tagModel->getError(), 235002);
        } else {
            // 返回成功数据
            return success_response($tagModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改标签
     * @param $param
     * @return array
     */
    public function modifyTag($param)
    {
        $tagModel = new TagModel();
        $resData = $tagModel->modifyItem($param);
        if (!$resData) {
            // 修改标签失败错误码 011
            throw_strack_exception($tagModel->getError(), 235004);
        } else {
            // 返回成功数据
            return success_response($tagModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除标签
     * @param $param
     * @return array
     */
    public function deleteTag($param)
    {
        $tagModel = new TagModel();
        $resData = $tagModel->deleteItem($param);
        if (!$resData) {
            // 删除标签失败错误码 012
            throw_strack_exception($tagModel->getError(), 235005);
        } else {
            // 返回成功数据
            return success_response($tagModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取标签表格数据
     * @param $param
     * @return mixed
     */
    public function getTagGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $tagModel = new TagModel();
        return $tagModel->selectData($options);
    }

    /**
     * 获取标签数据列表数据
     * @param array $options
     * @return array
     */
    public function getTagDataList($options = [])
    {
        $tagModel = new TagModel();
        $tagData = $tagModel->selectData($options);
        return $tagData;
    }

    /**
     * 获取Tag Combobox
     * @return array
     */
    public function getTagCombobox()
    {
        $tagModel = new TagModel();
        $tagData = $tagModel->selectData();

        $resData = [];
        foreach ($tagData["rows"] as $tagItem) {
            $tempItem = [
                'id' => $tagItem["id"],
                'name' => $tagItem["name"],
            ];
            array_push($resData, $tempItem);
        }
        return $resData;
    }

    /**
     * 获取标签数据
     * @param $filter
     * @return array
     */
    public function getTagData($filter)
    {
        $resData = [];
        // 获取tagData
        $tagLinkModel = new TagLinkModel();
        $tagLinkData = $tagLinkModel->selectData(["filter" => $filter, "fields" => "tag_id"]);
        foreach ($tagLinkData["rows"] as $tagLinkItem) {
            $tagModel = new TagModel();
            $tagData = $tagModel->findData(["filter" => ["id" => $tagLinkItem["tag_id"]], "fields" => "name,color"]);
            array_push($resData, $tagData);
        }
        return $resData;
    }

    /**
     * 获取标签一对多关联数据
     * @param $param
     * @param $searchValue
     * @param $mode
     * @return array
     */
    public function getHasManyRelationData($param, $searchValue, $mode)
    {
        if ($mode === "all") {
            $filter = [
                "id" => ["NOT IN", join(",", $param["link_data"])]
            ];
        } else {
            $filter = [
                "id" => ["IN", join(",", $param["link_data"])]
            ];
        }

        // 有额外过滤条件
        if (!empty($searchValue)) {
            $filter = [
                $filter,
                [
                    "name" => ["LIKE", "%{$searchValue}%"],
                    "_logic" => "OR"
                ],
                "_logic" => "AND"
            ];
        }

        $option = [
            "filter" => $filter,
            "fields" => "id,name,type",
            "page" => [$param["pagination"]["page_number"], $param["pagination"]["page_size"]]
        ];

        $tagModel = new TagModel();
        $hasManyRelationData = $tagModel->selectData($option);

        return $hasManyRelationData;
    }

    /**
     * 获取消息返回的tag信息
     * @param $filter
     * @return string
     */
    protected function getResponseMessageTag($filter)
    {
        $tagModel = new TagModel();
        $tagList = $tagModel->selectData([
            "filter" => $filter,
            "fields" => "name"
        ]);

        if ($tagList["total"] > 0) {
            $tagNames = array_column($tagList["rows"], "name");
            return join(",", $tagNames);
        } else {
            return "";
        }
    }

    /**
     * 修改标签一对多关联数据
     * @param $param
     * @return array
     */
    public function modifyHasManyRelationData($param)
    {
        $this->requestParam = $param["param"];

        $tagLinkModel = new TagLinkModel();

        // 删除已经存在的
        if (!empty($param["up_data"]["delete"])) {
            $deleteFilter = [
                "link_id" => $param["param"]["src_link_id"],
                "module_id" => $param["param"]["src_module_id"],
                "tag_id" => ["IN", join(",", $param["up_data"]["delete"])]
            ];
            $resData = $tagLinkModel->deleteItem($deleteFilter);
            if (!$resData) {
                // 删除标签关联失败错误码 003
                throw_strack_exception($tagLinkModel->getError(), 235003);
            }
        }

        // 新增关联数据
        if (!empty($param["up_data"]["add"])) {
            $baseData = [
                "link_id" => $param["param"]["src_link_id"],
                "module_id" => $param["param"]["src_module_id"],
                "tag_id" => 0
            ];
            foreach ($param["up_data"]["add"] as $addId) {
                $baseData["tag_id"] = $addId;
                $resData = $tagLinkModel->addItem($baseData);
                if (!$resData) {
                    // 添加标签关联失败错误码 001
                    throw_strack_exception($tagLinkModel->getError(), 235001);
                }
            }
        }

        $message = L("Modify_Tag_Link_Data_SC");
        if (session("event_from") === "strack_web") {
            // 获取消息返回数据
            $moduleFilter = ['id' => $param["param"]['src_module_id']];
            $this->projectId = $param["param"]['project_id'];
            $this->message = $message;
            $this->messageFromType = $param["param"]["from"];
            $this->messageOperate = 'update';
            $updateData = [];
            $updateData['id'] = $param["param"]["src_link_id"];
            if (!empty($param["up_data"]["add"])) {
                $tagIds = $param["up_data"]["add"];
            } else {
                $tagIds = $param["param"]["link_data"];
            }

            $updateData["name"] = $this->getResponseMessageTag(["id" => ["IN", join(",", $tagIds)]]);
            return $this->afterModify($updateData, $moduleFilter);
        } else {
            // 返回成功数据
            return success_response($message);
        }
    }

    /**
     * 删除标签关联
     * @param $filter
     * @return array
     */
    public function deleteTagLink($filter)
    {
        $tagLinkModel = new TagLinkModel();
        $resData = $tagLinkModel->deleteItem($filter);
        if (!$resData) {
            // 删除标签关联失败错误码 006
            throw_strack_exception($tagLinkModel->getError(), 235006);
        } else {
            // 返回成功数据
            return success_response($tagLinkModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改标签关联信息
     * @param $param
     * @return array
     */
    public function modifyDiffTagLink($param)
    {
        $tagLinkModel = new TagLinkModel();
        $tagList = $tagLinkModel->selectData([
            "filter" => ["module_id" => $param["module_id"], "link_id" => $param["link_id"]]
        ]);

        $requestTagIds = explode(",", $param["tag_id"]);
        if ($tagList["total"] > 0) {
            $tagIds = array_column($tagList["rows"], "tag_id");

            // 获取tag查询tag比较不同，结果添加
            $diffAddTags = array_diff($requestTagIds, $tagIds);
            // 查询tag获取tag比较不同，结果删除
            $diffDeleteTags = array_diff($tagIds, $requestTagIds);
            // 删除已不存的tag
            $tagLinkModel->deleteItem([
                "tag_id" => ["IN", join(",", $diffDeleteTags)],
                "module_id" => $param["module_id"],
                "link_id" => $param["link_id"]
            ]);
        } else {
            $diffAddTags = $requestTagIds;
        }

        if (!in_array("", $diffAddTags) && !empty($diffAddTags)) {
            $resData = [];
            foreach ($diffAddTags as $tagIdItem) {
                $param["tag_id"] = $tagIdItem;
                $resData = $tagLinkModel->addItem($param);
            }
            if (!$resData) {
                throw_strack_exception($tagLinkModel->getError(), 235007);
            } else {
                // 返回成功信息
                return success_response($tagLinkModel->getSuccessMassege(), $resData);
            }
        } else {
            return success_response($tagLinkModel->getSuccessMassege(), ["status" => 200, "message" => L("Modify_TagLink_Sc")]);
        }
    }
}