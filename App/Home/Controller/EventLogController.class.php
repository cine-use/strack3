<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\EventLogService;

class EventlogController extends VerifyController
{
    /**
     * 获取指定模块下面某项的历史操作记录
     * @return mixed
     * @throws \Ws\Http\Exception
     */
    public function getModuleItemHistory()
    {
        $param = $this->request->param();
        $eventService = new EventLogService();
        return $eventService->getModuleItemHistory($param);
    }

    /**
     * 获取数据表格边侧栏历史数据
     * @return mixed
     * @throws \Ws\Http\Exception
     */
    public function getDataGridSliderHistoryData()
    {
        $param = $this->request->param();
        $filter = [
            "module_id" => $param["module_id"],
            "item_id" => $param["item_id"],
            "project_id" => $param["project_id"],
            "page" => $param["page_number"],
            "rows" => $param["page_size"]
        ];
        $eventService = new EventLogService();
        return $eventService->getModuleItemHistory($filter);
    }
}