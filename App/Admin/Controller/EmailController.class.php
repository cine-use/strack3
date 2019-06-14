<?php

namespace Admin\Controller;

use Common\Service\EventLogService;
use Common\Service\OptionsService;

// +----------------------------------------------------------------------
// | 后台邮件设置数据控制层
// +----------------------------------------------------------------------

class EmailController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取Email设置
     */
    public function getEmailSetting()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData("email_settings");
        return json($resData);
    }


    /**
     * 更新邮件设置
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function saveEmailSetting()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("email_settings", $param, L("Email_Settings_Save_SC"));
        // 同时保存到事件日志
        $eventLogService = new EventLogService();
        $eventLogService->addLogServiceConfig("email_settings", $param);
        return json($resData);
    }


    /**
     * 测试邮件发送
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function testSendEmail()
    {
        $param = $this->request->param();
        $param = [
            "param" => [
                "addressee" => $param["email_account"],
                "subject" => "测试邮件"
            ],
            "data" => [
                "template" => "text",
                "content" => $param["email_content"]
            ]

        ];
        $eventLogService = new EventLogService();
        $resData = $eventLogService->testSendEmail($param);
        return json($resData);
    }
}