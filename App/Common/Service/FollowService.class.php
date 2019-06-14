<?php
// +----------------------------------------------------------------------
// | 关注方法服务层
// +----------------------------------------------------------------------
// | 主要服务于关注数据处理
// +----------------------------------------------------------------------
// | 错误编码头 207xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\FollowModel;

class FollowService
{

    /**
     * 关注或者取消关注当前项
     * @param $followStatus
     * @param $param
     * @return array
     */
    public function followItem($followStatus, $param)
    {
        $followModel = new FollowModel();
        if ($followStatus == "yes") {
            $followModel->where($param)->delete();
            return success_response(L("UnFollow_Item_SC"), ["follow_status" => "no", "follow_status_name" => L("Follow")]);
        } else {
            $followModel->add($param);
            return success_response(L("Follow_Item_SC"), ["follow_status" => "yes", "follow_status_name" => L("UnFollow")]);
        }
    }

    /**
     * 获取当前项目被关注状态
     * @param $moduleId
     * @param $linkId
     * @return array
     */
    public function getItemFollowStatus($moduleId, $linkId)
    {
        $userId = session("user_id");
        $followModel = new  FollowModel();
        $count = $followModel->where(["link_id" => $linkId, "module_id" => $moduleId, "user_id" => $userId])->count();
        if ($count > 0) {
            return ["follow_status" => "yes", "follow_status_name" => L("UnFollow")];
        } else {
            return ["follow_status" => "no", "follow_status_name" => L("Follow")];
        }
    }

    /**
     * 关注指定的审核实体播放列表
     * @param $param
     * @return array
     */
    public function followReviewPlaylist($param)
    {
        $followModel = new FollowModel();
        $userId = session("user_id");
        if ($param["mode"] === "unfollow") {
            $data["module_id"] = $param["entity_param"]["review_module_id"];
            $data["link_id"] = $param["entity_id"];
            $data["user_id"] = $userId;
            $resData = $followModel->deleteItem($data);
        } else {
            $data = [
                "module_id" => $param["entity_param"]["review_module_id"],
                "link_id" => $param["entity_id"],
                "user_id" => $userId
            ];
            $resData = $followModel->addItem($data);
        }
        if (!$resData) {
            // 关注审核实体任务失败错误码 001
            throw_strack_exception($followModel->getError(), 207001);
        } else {
            // 返回成功数据
            return success_response($followModel->getSuccessMassege(), $resData);
        }
    }
}