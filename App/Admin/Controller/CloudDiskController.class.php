<?php

namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 云盘设置数据控制层
// +----------------------------------------------------------------------

use Common\Service\OptionsService;

class CloudDiskController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取云盘配置
     */
    public function getCloudDiskConfig()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("cloud_disk_settings");
        return json($resData);
    }

    /**
     * 更新默认设置
     */
    public function updateCloudDiskConfig()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("cloud_disk_settings", $param, L("Save_Cloud_Disk_SC"));
        return json($resData);
    }
}