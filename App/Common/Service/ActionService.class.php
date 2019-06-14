<?php
// +----------------------------------------------------------------------
// | 动作服务层
// +----------------------------------------------------------------------
// | 主要服务于动作
// +----------------------------------------------------------------------
// | 错误编码头 204xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\ActionModel;
use Common\Model\CommonActionModel;

class ActionService
{
    /**
     * 获取Action表格数据
     * @param $param
     * @return mixed
     */
    public function getActionGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $actionModel = new ActionModel();
        $resData = $actionModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 删除动作
     * @param $param
     * @return array
     */
    public function deleteAction($param)
    {
        $actionModel = new ActionModel();
        $resData = $actionModel->deleteItem($param);
        if (!$resData) {
            // 删除动作失败错误码 001
            throw_strack_exception($actionModel->getError(), 204001);
        } else {
            try {
                // 删除媒体数据
                $mediaService = new MediaService();
                $mediaService->batchClearMediaThumbnail([
                    'link_id' => $param['primary_ids'],
                    'module_id' => C("MODULE_ID")["action"],
                    'mode' => 'batch'
                ]);
            } catch (\Exception $e) {

            }
            // 返回成功数据
            return success_response($actionModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取动作下拉面板数据
     * @param $param
     * @return array
     */
    public function getSidebarActionData($param)
    {
        $filter = [
            'action.project_id' => ['IN', join(',', [0, $param['project_id']])],
            'action.module_id' => $param['module_id'],
            '_string' => "FIND_IN_SET('web',action.engine)",
        ];
        if (!empty($param['filter'])) {
            $filter['name'] = $param['filter']['name'];
        }
        $actionModel = new ActionModel();
        $actionData = $actionModel
            ->alias("action")
            ->join("LEFT JOIN strack_media media ON media.link_id = action.id AND media.module_id = 1")
            ->where($filter)
            ->field("
                action.id,
                action.name,
                action.module_id,
                action.project_id,
                action.version,           
                media.thumb as thumb
            ")
            ->order('action.created desc')
            ->select();

        // 获取动作常用的动作数据
        $actionIds = array_column($actionData, 'id');
        $commonActionModel = new CommonActionModel();
        $commonActionData = $commonActionModel->selectData([
            'fields' => 'id,action_id',
            'filter' => [
                'action_id' => ['IN', join(',', $actionIds)]
            ]
        ]);
        $commonActionIds = array_column($commonActionData['rows'], 'action_id');

        // 分离常用动作数据
        $commonActionList = [];
        $otherActionList = [];
        foreach ($actionData as $actionItem) {

            // 没有缩略图填充默认图标
            if (!isset($actionItem['thumb'])) {
                $actionItem['thumb'] = __ROOT__ . '/Public/images/action_default_icon.png';
            }

            // 判断是否常用动作
            if (in_array($actionItem['id'], $commonActionIds)) {
                array_push($commonActionList, $actionItem);
            } else {
                array_push($otherActionList, $actionItem);
            }
        }

        return ['common' => $commonActionList, 'other' => $otherActionList];
    }

    /**
     * 获取指定模块动作列表
     * @param $param
     * @return mixed
     */
    public function getModuleActionList($param)
    {
        $filter = [
            'project_id' => ['IN', join(',', [0, $param['project_id']])],
            'module_id' => $param['module_id'],
            '_string' => "FIND_IN_SET('web',engine)",
        ];

        // 获取action数据
        $actionModel = new ActionModel();
        $actionData = $actionModel->field("id,name")->where($filter)->select();

        return $actionData;
    }

    /**
     * 获取常用数据列表
     * @param $param
     * @return array
     */
    public function getCommonActionList($param)
    {
        $filter = [
            'project_id' => ['IN', join(',', [0, $param['project_id']])],
            'module_id' => $param['module_id'],
            '_string' => "FIND_IN_SET('web',engine)",
        ];

        // 获取常用action数据
        $commonActionModel = new CommonActionModel();
        $commonActionData = $commonActionModel->selectData([
            'fields' => 'id,action_id',
            'filter' => ['module_id' => $param['module_id']]
        ]);

        $commonActionIds = array_column($commonActionData['rows'], 'action_id');
        $filter["id"] = ["IN", join(",", $commonActionIds)];

        // 获取action数据
        $actionModel = new ActionModel();
        $actionData = $actionModel->field("id,name")->where($filter)->select();

        return $actionData;
    }

    /**
     * 记录动作点击次数
     * @param $actionId
     */
    public function recordClicks($actionId)
    {
        $actionModel = new ActionModel();
        $actionModel->where(['id' => $actionId])->setInc('frequency');
    }

    /**
     * 设置或者取消Action常用属性
     * @param $param
     * @return array
     */
    public function setActionCommonStatus($param)
    {
        $changeData = [
            "action_id" => $param["action_id"],
            "module_id" => $param["module_id"]
        ];
        switch ($param["mode"]) {
            case "cancel":
                // 取消常用
                return $this->deleteCommonAction($changeData);
                break;
            case "set":
                // 设为常用
                return $this->addCommonAction($changeData);
                break;
        }
    }


    /**
     * 新增常用动作
     * @param $param
     * @return array
     */
    public function addCommonAction($param)
    {
        $commonActionModel = new CommonActionModel();
        $resData = $commonActionModel->addItem($param);
        if (!$resData) {
            // 添加状态失败错误码 002
            throw_strack_exception($commonActionModel->getError(), 204002);
        } else {
            // 返回成功数据
            return success_response($commonActionModel->getSuccessMassege(), $resData);
        }
    }


    /**
     * 删除常用动作
     * @param $param
     * @return array
     */
    public function deleteCommonAction($param)
    {
        $commonActionModel = new CommonActionModel();
        $resData = $commonActionModel->deleteItem($param);
        if (!$resData) {
            // 删除状态失败错误码 003
            throw_strack_exception($commonActionModel->getError(), 204003);
        } else {
            // 返回成功数据
            return success_response($commonActionModel->getSuccessMassege(), $resData);
        }
    }
}