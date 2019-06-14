<?php

namespace Queue\Command;

use Think\Console\Command;
use Think\Console\Input;
use Think\Console\Output;
use Common\Service\EventLogService;

class EventCommand extends Command
{
    protected function configure()
    {
        $this->setName('event')
            ->setDescription('Implementation of event')
            ->addArgument("event_data");
    }

    /**
     * 执行添加
     * @param Input $input
     * @param Output $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $eventData = json_decode($input->getArgument("event_data"), true);
        // 记录 Event log 数据
        $eventLogService = new EventLogService();
        $eventLogService->addInsideEventLog($eventData["event_from"], $eventData["params"], $eventData["user_info"]);
    }
}