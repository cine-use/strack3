<?php
namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 系统数据表模式设置数据控制层
// +----------------------------------------------------------------------

use Common\Service\OptionsService;

class ModeController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取系统模式配置
     */
    public function getModeConfig()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("default_mode");
        return json($resData);
    }

    /**
     * 保存系统模式配置
     */
    public function saveModeConfig()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("default_mode", $param, L("System_Mode_Save_SC"));
        return json($resData);
    }
}