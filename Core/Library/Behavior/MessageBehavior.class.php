<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Behavior;

use Common\Service\MessageService;

/**
 * 行为扩展：处理event
 */
class MessageBehavior
{

    /**
     * 处理记录event log
     * @param $params
     * @throws \Exception
     */
    public function run(&$params)
    {
        // 增加从哪里来参数
        $from = session("event_from");

        // 记录 Event log 数据
        $messageService = new MessageService();

        $messageService->addMessage($from, $params);
    }
}
