<?php
// +----------------------------------------------------------------------
// | 成员方法服务层
// +----------------------------------------------------------------------
// | 主要服务于成员数据处理
// +----------------------------------------------------------------------
// | 错误编码头 219xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\MemberModel;
use Common\Model\ProjectMemberModel;
use Common\Model\UserModel;

class MemberService
{
    /**
     * 添加成员信息
     * @param $param
     * @return array
     */
    public function addMember($param)
    {
        $memberModel = new MemberModel();
        $resData = $memberModel->addItem($param);
        if (!$resData) {
            // 保存成员失败错误码 001
            throw_strack_exception($memberModel->getError(), 219001);
        } else {
            // 返回成功数据
            return success_response($memberModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取member列表数据
     * @param $filter
     * @param $fields
     * @return array
     */
    public function getMemberList($filter, $fields)
    {
        // 查询当前这条数据下的member信息
        $memberModel = new MemberModel();
        $memberBelongData = $memberModel->selectData([
            "filter" => $filter,
            "fields" => $fields
        ]);
        return $memberBelongData;
    }

    /**
     * 获取member user用户列表数据
     * @param $filter
     * @return array
     */
    public function getMemberUserList($filter)
    {

        $horizontalService = new HorizontalService();
        $relationData = $horizontalService->getHorizontalRelationData($filter);
        if (!empty($relationData)) {

            $userIds = [];
            foreach ($relationData as $relationItem) {
                if (!in_array($relationItem["dst_link_id"], $userIds)) {
                    array_push($userIds, $relationItem["dst_link_id"]);
                }
            }

            // 获取发送用户数据
            $userModel = new UserModel();
            $userData = $userModel->selectData([
                "filter" => ["id" => ["IN", join(",", $userIds)]],
                "fields" => "id,name,email,uuid"
            ]);

            return $userData["rows"];
        } else {
            return [];
        }
    }

    /**
     * 获取属于我的任务
     * @param $filter
     * @return array
     */
    public function getBelongMyTaskMember($filter)
    {
        $filter["dst_module_id"] = C("MODULE_ID")["user"];

        $horizontalService = new HorizontalService();
        $relationData = $horizontalService->getHorizontalRelationData($filter);

        $status = "no";
        if (!empty($relationData)) {
            foreach ($relationData as $relationItem) {
                $variableConfig = json_decode($relationItem["config"], true);
                if ($variableConfig["code"] === "assign") {
                    if ($relationItem["dst_link_id"] == session("user_id")) {
                        $status = "yes";
                    }
                }
            }
        }
        return ["status" => $status];
    }
}