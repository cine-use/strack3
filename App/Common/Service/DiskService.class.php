<?php
// +----------------------------------------------------------------------
// | 磁盘服务层
// +----------------------------------------------------------------------
// | 主要服务于磁盘路径配置
// +----------------------------------------------------------------------
// | 错误编码头 203xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\DiskModel;
use Common\Model\ProjectMemberModel;
use Common\Model\ProjectModel;

class DiskService
{

    /**
     * 添加磁盘
     * @param $param
     * @return array
     */
    public function addDisks($param)
    {
        $diskModel = new DiskModel();
        $resData = $diskModel->addItem($param);
        if (!$resData) {
            // 磁盘创建失败错误码 001
            throw_strack_exception($diskModel->getError(), 203001);
        } else {
            // 返回成功数据
            return success_response($diskModel->getSuccessMassege(), $resData);
        }
    }

    /**、
     * 修改磁盘
     * @param $param
     * @return array
     */
    public function modifyDisks($param)
    {
        $diskModel = new DiskModel();
        $resData = $diskModel->modifyItem($param);
        if (!$resData) {
            // 磁盘修改失败错误码 002
            throw_strack_exception($diskModel->getError(), 203002);
        } else {
            // 返回成功数据
            return success_response($diskModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除磁盘
     * @param $param
     * @return array
     */
    public function deleteDisks($param)
    {
        $diskModel = new DiskModel();
        $resData = $diskModel->deleteItem($param);
        if (!$resData) {
            // 磁盘删除失败错误码 003
            throw_strack_exception($diskModel->getError(), 203003);
        } else {
            // 返回成功数据
            return success_response($diskModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取磁盘Combobox列表
     * @return mixed
     */
    public function getDiskCombobox()
    {
        $diskModel = new DiskModel();
        $diskList = $diskModel->field("id,name")->select();
        return $diskList;
    }

    /**
     * 加载项目存储路径列表
     * @param $param
     * @return array
     */
    public function getDisksGridData($param)
    {

        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];

        $diskModel = new DiskModel();
        $diskData = $diskModel->selectData($options);
        return $diskData;
    }

    /**
     * 通过code返回disk信息
     * @param $code
     * @return array|mixed
     */
    public function getDiskByCode($code)
    {
        $diskModel = new DiskModel();
        $ret = $diskModel->findData(["filter" => ["code" => $code]]);
        return $ret;
    }

    /**
     * 获取云盘配置数据
     * @return array|mixed
     */
    public function getCloudDiskConfig()
    {
        $optionsService = new OptionsService();
        $couldDiskSettings = $optionsService->getOptionsData("cloud_disk_settings");
        if (!empty($couldDiskSettings) && $couldDiskSettings["open_cloud_disk"] == 1) {
            return $couldDiskSettings;
        }
        return ["open_cloud_disk" => 0];
    }

    /**
     * 获取云盘访问路径
     * @param int $projectId
     * @param string $folderName
     * @return mixed|string
     */
    public function getCloudDiskUrl($projectId = 0, $folderName = '')
    {
        $couldDiskSettings = $this->getCloudDiskConfig();
        $url = '';
        $requestUrl = '';
        $requestToken = '';
        if ($couldDiskSettings["open_cloud_disk"] > 0) {
            $url = $couldDiskSettings["endpoint"] . '/files';
            $requestUrl = $couldDiskSettings["endpoint"];
            if ($projectId > 0) {
                // 拼接磁盘项目路径
                $projectModel = new ProjectModel();
                $projectCode = $projectModel->where(["id" => $projectId])->getField("code");
                $url .= '/' . $projectCode;
            }
            if (!empty($folderName)) {
                $url .= '/' . $folderName;
            }
            $url .= '/';
        }
        return [
            "cloud_disk_url" => $url,
            "cloud_disk_request_url" => $requestUrl
        ];
    }

    /**
     * 获取边侧栏云盘访问路径
     * @param $projectId
     * @param $param
     * @return array
     */
    public function getDataGridSliderOtherPageData($param)
    {
        $diskService = new DiskService();
        $tableName = $param["module_type"] === "entity" ? "Entity" : string_initial_letter($param["module_code"]);
        $itemUUID = M($tableName)->where(["id" => $param["item_id"]])->getField("uuid");
        $cloudDiskUrl = $diskService->getCloudDiskUrl($param["project_id"], "{$param["module_code"]}_{$itemUUID}");
        if (!empty($cloudDiskUrl)) {
            return success_response('', $cloudDiskUrl);
        }
        throw_strack_exception('', 203004);
    }
}