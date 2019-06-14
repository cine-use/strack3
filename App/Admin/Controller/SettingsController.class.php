<?php

namespace Admin\Controller;

use Common\Service\OptionsService;

// +----------------------------------------------------------------------
// | 后台默认设置数据控制层
// +----------------------------------------------------------------------

class SettingsController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 更新默认设置
     */
    public function updateDefaultSetting()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("default_settings", $param, L("System_Setting_Save_SC"));
        return json($resData);
    }

    /**
     * 加载默认设置
     */
    public function getDefaultOptions()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("default_settings");
        return json($resData);
    }

    /**
     * 获取时区列表
     */
    public function getTimezoneData()
    {
        $resData = timezone_data();
        return json($resData);
    }
}