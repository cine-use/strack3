<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\MessageService;

class MessageController extends VerifyController
{
    /**
     * 获取消息盒子数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getSideInboxData()
    {
        $param = $this->request->param();
        $messageService = new MessageService();
        $resData = $messageService->getSideInboxData($param);
        return json($resData);
    }

    /**
     * 标记已读消息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function readMessage()
    {
        $userId = session("user_id");
        $param = $this->request->param();
        $messageService = new MessageService();
        $resData = $messageService->readMessage($userId, $param["created"]);
        return json($resData);
    }
}