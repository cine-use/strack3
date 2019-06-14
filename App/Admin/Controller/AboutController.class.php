<?php

namespace Admin\Controller;

use Common\Service\MediaService;
use Common\Service\OptionsService;

// +----------------------------------------------------------------------
// | 关于数据控制层
// +----------------------------------------------------------------------

class AboutController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获得系统参数
     * @return \Think\Response
     */
    public function getSystemAbout()
    {
        // 获取日志服务器状态
        $optionsService = new OptionsService();
        $logServerStatus = $optionsService->getLogServerStatus();

        // 获取媒体服务器状态（存在多台）
        $mediaService = new MediaService();
        $mediaServerStatusList = $mediaService->getMediaServerStatus();

        $serverList = [];
        if (!empty($mediaServerStatusList)) {
            $serverList = $mediaServerStatusList;
        }

        if (!empty($logServerStatus)) {
            array_unshift($serverList, $logServerStatus);
        }

        // 获取当前版本号
        $strackVersionConfig = $optionsService->getOptionsData('system_version');

        $resData = [
            'strack_version' => $strackVersionConfig["version"],
            'package_version' => C("STRACK_VERSION"),
            'server_list' => $serverList,
        ];

        return json($resData);
    }
}