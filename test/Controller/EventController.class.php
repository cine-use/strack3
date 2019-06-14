<?php

namespace Test\Controller;


use Think\Controller;
use Common\Service\EventLogService;

class EventController extends Controller
{

    public function getEventData()
    {
        $filter = [
            "filter" => [],
            "pagination" => [
                "page_number" => 1,
                "page_size" => 4000
            ]
        ];

        $eventService = new EventLogService();
        $data = $eventService->getEventLogGridData($filter);
        dump($data);
    }
}