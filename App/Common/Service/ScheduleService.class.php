<?php
// +----------------------------------------------------------------------
// | 日历相关 服务
// +----------------------------------------------------------------------
// | 主要服务于日历 TimeLog 数据处理
// +----------------------------------------------------------------------
// | 错误编码头 228xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\TimelogIssueModel;
use Common\Model\CalendarModel;

class ScheduleService
{
    /**
     * 新增时间日志
     * @param $param
     * @return array
     */
    public function addTimelogIssue($param)
    {
        $timelogIssueModel = new TimelogIssueModel();
        $resData = $timelogIssueModel->addItem($param);
        if (!$resData) {
            // 添加时间日志失败错误码 001
            throw_strack_exception($timelogIssueModel->getError(), 228001);
        } else {
            // 返回成功数据
            return success_response($timelogIssueModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改时间日志
     * @param $param
     * @return array
     */
    public function modifyTimelogIssue($param)
    {
        $timelogIssueModel = new TimelogIssueModel();
        $resData = $timelogIssueModel->modifyItem($param);
        if (!$resData) {
            // 修改时间日志失败错误码 002
            throw_strack_exception($timelogIssueModel->getError(), 228002);
        } else {
            // 返回成功数据
            return success_response($timelogIssueModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除时间日志
     * @param $param
     * @return array
     */
    public function deleteTimelogIssue($param)
    {
        $timelogIssueModel = new TimelogIssueModel();
        $resData = $timelogIssueModel->deleteItem($param);
        if (!$resData) {
            // 删除时间日志失败错误码 003
            throw_strack_exception($timelogIssueModel->getError(), 228003);
        } else {
            // 返回成功数据
            return success_response($timelogIssueModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 时间日志列表数据
     * @param $param
     * @return mixed
     */
    public function getTimelogGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $timelogIssueModel = new TimelogIssueModel();
        $timelogIssueData = $timelogIssueModel->selectData($options);
        return $timelogIssueData;
    }


    /**
     * 新增日历事项
     * @param $param
     * @return array
     */
    public function addCalendar($param)
    {
        $calendarModel = new CalendarModel();
        $resData = $calendarModel->addItem($param);
        if (!$resData) {
            // 添加日历事项失败错误码 004
            throw_strack_exception($calendarModel->getError(), 228004);
        } else {
            // 返回成功数据
            return success_response($calendarModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改日历事项
     * @param $param
     * @return array
     */
    public function modifyCalendar($param)
    {
        $calendarModel = new CalendarModel();
        $resData = $calendarModel->modifyItem($param);
        if (!$resData) {
            // 修改日历事项失败错误码 005
            throw_strack_exception($calendarModel->getError(), 228005);
        } else {
            // 返回成功数据
            return success_response($calendarModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除日历事项
     * @param $param
     * @return array
     */
    public function deleteCalendar($param)
    {
        $calendarModel = new CalendarModel();
        $resData = $calendarModel->deleteItem($param);
        if (!$resData) {
            // 删除日历事项失败错误码 006
            throw_strack_exception($calendarModel->getError(), 228006);
        } else {
            // 返回成功数据
            return success_response($calendarModel->getSuccessMassege(), $resData);
        }
    }


    /**
     * 日历事项列表数据
     * @param $param
     * @return mixed
     */
    public function getCalendarGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $calendarModel = new CalendarModel();
        $calendarData = $calendarModel->selectData($options);
        return $calendarData;
    }
}