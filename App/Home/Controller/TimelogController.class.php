<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\TimelogService;

class TimelogController extends VerifyController
{
    /**
     * 获取 Timelog 表格信息
     */
    public function getTimelogGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $timelogService = new TimelogService();
        $resData = $timelogService->getTimelogGridData($param);
        return json($resData);
    }

    /**
     * 获取时间日志边侧栏，激活计时器
     */
    public function getSideTimelogMyTimer()
    {
        $userId = fill_created_by();
        $timeLogService = new TimelogService();
        $resData = $timeLogService->getSideTimelogMyTimer($userId);
        return json($resData);
    }

    /**
     * 获取时间日志边侧栏，个人记录
     */
    public function getSideTimelogMyData()
    {
        $param = $this->request->param();
        $param['user_id'] = fill_created_by();
        $timeLogService = new TimelogService();
        $resData = $timeLogService->getSideTimelogMyData($param);
        return json($resData);
    }

    /**
     * 获取时间日志事项列表
     */
    public function getTimeLogIssuesCombobox()
    {
        $param = $this->request->param();
        $timeLogService = new TimelogService();
        $resData = $timeLogService->getTimeLogIssuesCombobox($param);
        return json($resData);
    }

    /**
     * 添加时间日志计时器
     */
    public function addTimelogTimer()
    {
        $param = $this->request->param();
        $timeLogService = new TimelogService();
        $param["user_id"] = fill_created_by();
        $resData = $timeLogService->addTimelogTimer($param);
        return json($resData);
    }

    /**
     * 停止时间日志计时器
     */
    public function stopTimelogTimer()
    {
        $param = $this->request->param();
        $timeLogService = new TimelogService();
        $resData = $timeLogService->stopTimelogTimer($param['timer_id']);
        return json($resData);
    }

    /**
     * 停止开启时间日志
     */
    public function startOrStopTimelog()
    {
        $param = $this->request->param();
        $param["user_id"] = fill_created_by();
        $timeLogService = new TimelogService();
        $resData = $timeLogService->startOrStopTimelog($param);
        return json($resData);
    }

    /**
     * 删除时间日志
     */
    public function deleteTimelog()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $statusService = new TimelogService();
        $resData = $statusService->deleteTimelog($param);
        return json($resData);
    }
}