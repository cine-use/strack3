<?php

namespace Admin\Controller;

use Common\Service\OptionsService;

// +----------------------------------------------------------------------
// | 系统日志服务器控制层
// +----------------------------------------------------------------------

class LogServerController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取日志服务器配置
     */
    public function getLogServerConfig()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("log_settings");
        return json($resData);
    }

    /**
     * 更新默认设置
     */
    public function updateLogServerConfig()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("log_settings", $param, L("Save_Log_Server_SC"));
        return json($resData);
    }
}