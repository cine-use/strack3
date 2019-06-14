<?php

namespace Admin\Controller;

use Common\Service\OptionsService;
use Common\Service\ScheduleService;
use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 后台日期数据控制层
// +----------------------------------------------------------------------

class ScheduleController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $timeLogIssueModuleId = 32;
        $timeLogIssueModuleData = $schemaService->getModuleFindData(["id" => $timeLogIssueModuleId]);

        $calendarModuleId = 5;
        $calendarModuleData = $schemaService->getModuleFindData(["id" => $calendarModuleId]);


        // 把数据发送到前端页面
        $param = [
            "page" => 'admin_schedule',
            "timeLog_issue_module_id" => $timeLogIssueModuleId,
            "timeLog_issue_module_code" => $timeLogIssueModuleData["code"],
            "timeLog_issue_module_name" => $timeLogIssueModuleData["name"],
            "timeLog_issue_module_icon" => $timeLogIssueModuleData["icon"],
            "calendar_module_id" => $calendarModuleId,
            "calendar_module_code" => $calendarModuleData["code"],
            "calendar_module_name" => $calendarModuleData["name"],
            "calendar_module_icon" => $calendarModuleData["icon"],
        ];

        $this->assign($param);

        return $this->display();
    }

    /**
     * 获取工作时间设置
     */
    public function getScheduleWorkdaySetting()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData('schedule_workday');
        return json($resData);
    }

    /**
     * 获取日期排除类型列表
     */
    public function getScheduleExcludeList()
    {
        $typeList = ["holiday", "non_workday"];
        $excludeList = [];
        foreach ($typeList as $type) {
            array_push($excludeList, get_calendar_type($type));
        }
        return json($excludeList);
    }

    /**
     * 更新工作时间设置
     */
    public function saveScheduleWorkdaySetting()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("schedule_workday", $param, L('SchedulWorkday_Save_SC'));
        return json($resData);
    }


    /**
     * 获取提醒设置
     */
    public function getReminderSetting()
    {
        $optionsService = new OptionsService();
        $resData = $optionsService->getOptionsData('schedule_reminders');
        return json($resData);
    }


    /**
     * 更新提醒设置
     */
    public function saveReminderSetting()
    {
        $param = $this->request->param();
        $optionsService = new OptionsService();
        $resData = $optionsService->updateOptionsData("schedule_reminders", $param, L('Reminder_Save_SC'));
        return json($resData);
    }


    /**
     * 加载自定义时间日志项
     */
    public function getTimelogGridData()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->getTimelogGridData($param);
        return json($resData);
    }

    /**
     * 添加自定义时间日志项
     */
    public function addTimelogIssue()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->addTimelogIssue($param);
        return json($resData);
    }

    /**
     * 修改自定义时间日志项
     */
    public function modifyTimelogIssue()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->modifyTimelogIssue($param);
        return json($resData);
    }

    /**
     * 删除自定义时间日志项
     */
    public function deleteTimelogIssue()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->deleteTimelogIssue($param);
        return json($resData);
    }

    /**
     * 加载自定义日历事项
     */
    public function getCalendarGridData()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->getCalendarGridData($param);
        return json($resData);
    }

    /**
     * 获取日历事项列表
     */
    public function getCalendarTypeList()
    {
        $calendarList = ['holiday', 'event', 'overtime'];
        $calendarData = [];
        foreach ($calendarList as $item) {
            array_push($calendarData, get_calendar_type($item));
        }
        return json($calendarData);
    }

    /**
     * 添加自定义日历事项
     */
    public function addCalendar()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->addCalendar($param);
        return json($resData);
    }

    /**
     * 修改自定义日历事项
     */
    public function modifyCalendar()
    {
        $param = $this->request->param();
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->modifyCalendar($param);
        return json($resData);
    }

    /**
     * 删除自定义日历事项
     */
    public function deleteCalendar()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $scheduleService = new  ScheduleService();
        $resData = $scheduleService->deleteCalendar($param);
        return json($resData);
    }
}