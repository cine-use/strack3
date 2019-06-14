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

/**
 * 行为扩展：处理event
 */
class EventBehavior
{

    /**
     * 处理记录event log
     * @param $params
     * @throws \Exception
     */
    public function run(&$params)
    {

        $eventData = [
            "event_from" => session("event_from"),   // 增加从哪里来参数
            "user_info" => S('user_data_' . fill_created_by()),
            "params" => $params
        ];

//        $eventLogService = new EventLogService();
//        $eventLogService->addInsideEventLog($eventData["event_from"], $eventData["params"], $eventData["user_info"]);

        \Queue\Controller\JobsController::push('Event', 'event', '', ["event_data" => json_encode($eventData)]);
    }
}
