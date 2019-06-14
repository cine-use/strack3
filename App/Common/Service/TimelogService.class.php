<?php
// +----------------------------------------------------------------------
// | Timelog 时间日志服务
// +----------------------------------------------------------------------
// | 主要服务于Timelog数据处理
// +----------------------------------------------------------------------
// | 错误编码头 227xxx
// +----------------------------------------------------------------------

namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\ModuleModel;
use Common\Model\TimelogIssueModel;
use Common\Model\TimelogModel;

class TimelogService
{
    /**
     * 获取Timelog Grid 表格数据
     * @param $param
     * @return mixed
     */
    public function getTimelogGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $timeLogModel = new TimelogModel();
        $resData = $timeLogModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取指定模块项时间日志状态
     * @param $param
     * @return array
     */
    public function getModuleTimelogStatus($param)
    {
        $filter = [
            "module_id" => $param["module_id"],
            "link_id" => $param["item_id"],
            "complete" => "no"
        ];

        $timeLogModel = new TimelogModel();
        $activeTimeLogId = $timeLogModel->where($filter)->getField("id");

        $timeLogStatus = [
            "color" => "green",
            "id" => 0
        ];

        if ($activeTimeLogId > 0) {
            // 存在时间日志并且还没有停止
            $timeLogStatus["color"] = "red";
            $timeLogStatus["id"] = $activeTimeLogId;
        }

        return $timeLogStatus;
    }

    /**
     * 获取当前用户时间日志计数器个数
     * @param $userId
     * @return mixed
     */
    public function getCurrentTimerNumber($userId)
    {
        $filter = [
            'complete' => 'no',
            'user_id' => $userId
        ];

        $timeLogModel = new TimelogModel();
        $timerNumber = $timeLogModel->where($filter)->count();

        return $timerNumber;
    }

    /**
     * 获取时间日志事项Combobox
     * @return array
     */
    public function getTimeLogIssuesCombobox($param)
    {
        // 获取时间日志事项数据-group为custom
        $timeLogIssuesModel = new TimelogIssueModel();
        $timeLogIssuesData = $timeLogIssuesModel->selectData();

        $list = [];
        if ($timeLogIssuesData["total"] > 0) {
            foreach ($timeLogIssuesData["rows"] as $item) {
                $tempItem = [
                    'id' => $item["id"],
                    'name' => $item["name"],
                    'group_type' => 'custom',
                    'group_lang' => L('Custom'),
                    'module_id' => 32
                ];
                array_push($list, $tempItem);
            }
        }

        // 获取是我的任务
        $horizontalService = new HorizontalService();
        $taskMemberData = $horizontalService->getHorizontalRelationData([
            "src_module_id" => C("MODULE_ID")["base"],
            "dst_module_id" => C("MODULE_ID")["user"],
            "dst_link_id" => session("user_id"),
            "code" => "assign",
        ]);
        $linkIds = array_column($taskMemberData, 'src_link_id');

        // 获取任务相关信息
        $baseModel = new BaseModel();
        $filter["id"] = ["IN", join(",", $linkIds)];
        if ($param["project_id"] > 0) {
            $filter["project_id"] = $param["project_id"];
        }
        $baseData = $baseModel->selectData(["filter" => $filter]);
        if ($baseData["total"] > 0) {
            foreach ($baseData["rows"] as $item) {
                $tempItem = [
                    'id' => $item["id"],
                    'name' => $item["name"],
                    'group_type' => 'task',
                    'group_lang' => L('Task'),
                    'module_id' => C("MODULE_ID")["base"]
                ];
                array_push($list, $tempItem);
            }
        }

        return $list;
    }

    /**
     * 添加事件日志计时器
     * @param $param
     * @return array
     */
    public function addTimelogTimer($param)
    {
        // 判断当前 Timelog 是不是已经被当前用户启动了，并且没有完成！
        $timeLogModel = new TimelogModel();
        $filter = [
            'complete' => 'no',
            'module_id' => $param['module_id'],
            'link_id' => $param['id'],
            'user_id' => $param['user_id'],
        ];
        $timeLogCount = $timeLogModel->where($filter)->count();
        if ($timeLogCount > 0) {
            // 添加时间日志错误码 003
            throw_strack_exception(L("Tiemlog_Start_By_Current_User"), 227003);
        } else {
            // 添加Timelog
            $addData = [
                'complete' => 'no',
                'module_id' => $param['module_id'],
                'link_id' => $param['id'],
                'start_time' => date('Y-m-d H:i:s', time()),
                'user_id' => $param['user_id'],
            ];
            $resData = $timeLogModel->addItem($addData);
            if (!$resData) {
                // 添加工序失败错误码 002
                throw_strack_exception($timeLogModel->getError(), 227002);
            } else {
                // 返回成功数据
                return success_response($timeLogModel->getSuccessMassege(), $resData);
            }
        }
    }


    /**
     * 停止时间日志计数器
     * @param $timeLogId
     * @return array
     */
    public function stopTimelogTimer($timeLogId)
    {
        $updateData = [
            'id' => $timeLogId,
            'complete' => 'yes',
            'end_time' => date('Y-m-d H:i:s', time())
        ];

        // 更新Timelog end_time
        $timeLogModel = new TimelogModel();
        $resData = $timeLogModel->modifyItem($updateData);
        if (!$resData) {
            // 修改时间日志失败错误码 004
            throw_strack_exception($timeLogModel->getError(), 227004);
        } else {
            // 返回成功数据
            return success_response($timeLogModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 停止开启时间日志
     * @param $param
     * @return array
     */
    public function startOrStopTimelog($param)
    {
        if ($param["timelog_id"] > 0) {
            // 暂停当前Timelog
            $resData = $this->stopTimelogTimer($param["timelog_id"]);
        } else {
            // 新增当前Timelog
            $resData = $this->addTimelogTimer($param);
        }

        // 获取激活timer数据
        $resData["data"]["timer_number"] = $this->getCurrentTimerNumber($param["user_id"]);

        return $resData;
    }

    /**
     * 获取指定用户激活的Timer
     * @param $userId
     * @return mixed
     */
    public function getSideTimelogMyTimer($userId)
    {
        $filter = [
            'complete' => 'no',
            'user_id' => $userId
        ];
        $timeLogModel = new TimelogModel();
        $timeLogTimerData = $timeLogModel
            ->field('id,module_id,link_id,start_time,end_time')
            ->where($filter)
            ->order('created desc')
            ->select();

        foreach ($timeLogTimerData as &$timeLogTimerItem) {
            $timeLogTimerItem['timer_start'] = time() - $timeLogTimerItem['start_time'];
        }

        return $timeLogTimerData;
    }

    /**
     * 获取指定用户事件日志
     * @param $param
     * @return array
     */
    public function getSideTimelogMyData($param)
    {
        $options = [
            'filter' => [
                'complete' => 'yes',
                'user_id' => $param['user_id']
            ],
            'fields' => 'id,module_id,link_id,start_time,end_time,created',
            'page' => [$param['page_number'], $param['page_size']],
            'order' => 'created desc'
        ];
        $timeLogModel = new TimelogModel();
        $timeLogData = $timeLogModel->selectData($options, false);

        // 获取所有module模块信息
        $moduleModel = new ModuleModel();
        $allModuleData = $moduleModel->field("id,type,name,code")->select();

        $moduleIndexKey = [];
        foreach ($allModuleData as $moduleItem) {
            $moduleIndexKey[$moduleItem['id']] = $moduleItem;
        }

        foreach ($timeLogData['rows'] as &$timeLogItem) {
            $timeLogItem['created'] = get_format_date($timeLogItem['created'], 2);
            $timeLogItem['group'] = get_date_group_md5($timeLogItem['created']);
            $timeLogItem['duration'] = $timeLogItem['end_time'] - $timeLogItem['start_time'];
            $timeLogItem['end_time'] = get_format_date($timeLogItem['end_time'], 2);
            $timeLogItem['start_time'] = get_format_date($timeLogItem['start_time'], 2);
            // 获取当前timeLog belong
            $moduleItemData = $moduleIndexKey[$timeLogItem['module_id']];
            $itemName = '';
            if ($moduleItemData['type'] === 'entity') {
                // 为实体类型
            } else {
                // 为固定表类型
                $class = '\\Common\\Model\\' . string_initial_letter($moduleItemData['code']) . 'Model';
                $linkModel = new $class();
                $itemName = $linkModel->where(['id' => $timeLogItem['link_id']])->getField("name");
            }

            $timeLogItem['title'] = $itemName;

            if ($moduleItemData['code'] === 'timelog_issue') {
                $parentName = L('Custom');
                $timeLogItem['belong'] = "{$parentName} / {$itemName}";
            } else {
                $timeLogItem['belong'] = "{$moduleItemData['name']} / {$itemName}";
            }
        }

        return $timeLogData;
    }

    /**
     * 删除时间日志
     * @param $param
     * @return array
     */
    public function deleteTimelog($param)
    {
        $timeLogModel = new TimelogModel();
        $resData = $timeLogModel->deleteItem($param);
        if (!$resData) {
            // 删除时间日志失败错误码 005
            throw_strack_exception($timeLogModel->getError(), 227005);
        } else {
            // 返回成功数据
            return success_response($timeLogModel->getSuccessMassege(), $resData);
        }
    }
}