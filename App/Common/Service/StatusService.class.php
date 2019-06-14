<?php
// +----------------------------------------------------------------------
// | Status 状态服务
// +----------------------------------------------------------------------
// | 主要服务于Status数据处理
// +----------------------------------------------------------------------
// | 错误编码头 224xxx
// +----------------------------------------------------------------------

namespace Common\Service;

use Common\Model\StatusModel;

class StatusService
{

    /**
     * 新增状态
     * @param $param
     * @return array
     */
    public function addStatus($param)
    {
        $statusModel = new StatusModel();
        $resData = $statusModel->addItem($param);
        if (!$resData) {
            // 添加状态失败错误码 001
            throw_strack_exception($statusModel->getError(), 224001);
        } else {
            // 返回成功数据
            return success_response($statusModel->getSuccessMassege(), $resData);
        }
    }

    /**、
     * 修改状态
     * @param $param
     * @return array
     */
    public function modifyStatus($param)
    {
        $statusModel = new StatusModel();
        $resData = $statusModel->modifyItem($param);
        if (!$resData) {
            // 修改状态失败错误码 002
            throw_strack_exception($statusModel->getError(), 224002);
        } else {
            // 返回成功数据
            return success_response($statusModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除状态
     * @param $param
     * @return array
     */
    public function deleteStatus($param)
    {
        $statusModel = new StatusModel();
        $resData = $statusModel->deleteItem($param);
        if (!$resData) {
            // 删除状态失败错误码 003
            throw_strack_exception($statusModel->getError(), 224003);
        } else {
            // 返回成功数据
            return success_response($statusModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取状态表格数据
     * @param $param
     * @return mixed
     */
    public function getStatusGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $statusModel = new StatusModel();
        $statusData = $statusModel->selectData($options);
        foreach ($statusData["rows"] as &$statusItem) {
            $statusItem["correspond_name"] = status_corresponds_lang($statusItem["correspond"]);
        }
        return $statusData;
    }

    /**
     * 获取状态数据列表
     */
    public function getStatusList()
    {
        $statusData = $this->getStatusDataList();
        return $statusData["rows"];
    }

    /**
     * 获取状态数据列表数据
     * @return mixed
     */
    public function getStatusDataList()
    {
        $statusModel = new StatusModel();
        $statusData = $statusModel->selectData();
        foreach ($statusData["rows"] as &$statusItem) {
            $statusItem["correspond_name"] = status_corresponds_lang($statusItem["correspond"]);
        }
        return $statusData;
    }

    /**
     * 获取模板配置中的状态
     * @param $param
     * @return array
     */
    public function getTemplateStatusList($param)
    {
        // 获取项目模板状态配置
        $templateService = new TemplateService();
        $statusData = $templateService->getTemplateConfig(['filter' => ["project_id" => $param['project_id']], 'module_code' => $param['frozen_module'], 'category' => 'status']);

        $statusList = [
            [
                "id" => 0,
                "name" => L("Empty_Default"),
                'correspond_name' => ""
            ]
        ];

        if (!empty($statusData)) {
            // 获取状态数据
            $statusIds = unique_arr(array_column($statusData, "id"));
            $statusModel = new StatusModel();
            $statusListData = $statusModel->selectData([
                "filter" => [
                    "id" => ["IN", join(",", $statusIds)]
                ]
            ]);

            foreach ($statusListData["rows"] as $statusItem) {
                // 将模板中存在的id名称赋给新的数据
                array_push($statusList, [
                    'id' => $statusItem["id"],
                    'name' => $statusItem["name"],
                    'correspond_name' => status_corresponds_lang($statusItem["correspond"])
                ]);
            }
        }

        return $statusList;
    }

    /**
     * 获取单条状态数据
     * @param $filter
     * @return array|mixed
     */
    public function getStatusFindData($filter)
    {
        $statusModel = new StatusModel();
        $resData = $statusModel->findData(["filter" => $filter]);
        return $resData;
    }

    /**
     * 获取状态通用控件值
     * @param $itemData
     * @param $moduleCode
     * @return mixed
     */
    public function getStatusWidgetData(&$itemData, $moduleCode)
    {
        $statusData = $this->getStatusFindData(["id" => $itemData["status_id"]]);
        if (!empty($statusData)) {
            $itemData[$moduleCode . "_status_name"] = $statusData["name"];
            $itemData[$moduleCode . "_status_icon"] = $statusData["icon"];
            $itemData[$moduleCode . "_status_color"] = $statusData["color"];
        }
        return $itemData;
    }

    /**
     * 把状态按照Correspond分类
     * @param string $correspond
     * @return array|mixed
     */
    public function getCorrespondStatusIds($correspond = '')
    {
        $statusModel = new StatusModel();
        $allStatusData = $statusModel->selectData(['fields' => 'id,correspond']);
        $correspondStatusData = [];
        foreach ($allStatusData['rows'] as $allStatusItem) {
            if (array_key_exists($allStatusItem['correspond'], $correspondStatusData)) {
                array_push($correspondStatusData[$allStatusItem['correspond']], $allStatusItem['id']);
            } else {
                $correspondStatusData[$allStatusItem['correspond']] = [$allStatusItem['id']];
            }
        }
        if (!empty($correspond)) {
            return $correspondStatusData[$correspond];
        } else {
            return $correspondStatusData;
        }
    }

    /**
     * 获取状态从属字典
     * @return array
     */
    public function getStatusCorrespondDict()
    {
        $statusModel = new StatusModel();
        $allStatusData = $statusModel->selectData(['fields' => 'code,correspond']);
        $statusCorrespondDict = [];
        foreach ($allStatusData["rows"] as $statusItem) {
            $statusCorrespondDict[$statusItem["code"]] = $statusItem["correspond"];
        }

        return $statusCorrespondDict;
    }
}