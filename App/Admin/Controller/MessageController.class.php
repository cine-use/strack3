<?php
namespace Admin\Controller;

use Common\Service\OptionsService;
use Common\Service\EventLogService;

// +----------------------------------------------------------------------
// | 后台消息配置数据控制层
// +----------------------------------------------------------------------

class MessageController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取消息配置
     * @return \Think\Response
     */
    public function getMessageSetting()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("message_settings");
        return json($resData);
    }

    /**
     * 保存消息配置
     * @return \Think\Response
     */
    public function saveMessageSetting()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("message_settings", $param, L("Message_Settings_Save_SC"));
        // 同时保存到事件日志
        $eventLogService = new EventLogService();
        $eventLogService->addLogServiceConfig("message_settings", $param);
        return json($resData);
    }
}