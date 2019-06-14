<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Scheduling_title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_schedule.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_schedule.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
      var SchedulPHP = {
          'getScheduleWorkdaySetting' : '{:U("Admin/Schedule/getScheduleWorkdaySetting")}',
          'getScheduleExcludeList' : '{:U("Admin/Schedule/getScheduleExcludeList")}',
          'saveScheduleWorkdaySetting' : '{:U("Admin/Schedule/saveScheduleWorkdaySetting")}',
          'getReminderSetting' : '{:U("Admin/Schedule/getReminderSetting")}',
          'saveReminderSetting' : '{:U("Admin/Schedule/saveReminderSetting")}',
          'getTimelogGridData' : '{:U("Admin/Schedule/getTimelogGridData")}',
          'addTimelogIssue' : '{:U("Admin/Schedule/addTimelogIssue")}',
          'modifyTimelogIssue' : '{:U("Admin/Schedule/modifyTimelogIssue")}',
          'deleteTimelogIssue' : '{:U("Admin/Schedule/deleteTimelogIssue")}',
          'addCalendar' : '{:U("Admin/Schedule/addCalendar")}',
          'modifyCalendar' : '{:U("Admin/Schedule/modifyCalendar")}',
          'deleteCalendar' : '{:U("Admin/Schedule/deleteCalendar")}',
          'getCalendarGridData' : '{:U("Admin/Schedule/getCalendarGridData")}',
          'getCalendarTypeList': '{:U("Admin/Schedule/getCalendarTypeList")}'
      };
      Strack.G.MenuName="schedule";
  </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Admin_Scheduling}
</block>

<block name="admin-main">
  <div id="active-schedule" class="admin-content-dept">

    <div id="page_hidden_param">
      <input name="page" type="hidden" value="{$page}">
      <input name="timeLog_issue_module_id" type="hidden" value="{$timeLog_issue_module_id}">
      <input name="timeLog_issue_module_code" type="hidden" value="{$timeLog_issue_module_code}">
      <input name="timeLog_issue_module_name" type="hidden" value="{$timeLog_issue_module_name}">
      <input name="calendar_module_id" type="hidden" value="{$calendar_module_id}">
      <input name="calendar_module_code" type="hidden" value="{$calendar_module_code}">
      <input name="calendar_module_name" type="hidden" value="{$calendar_module_name}">
    </div>


    <div class="admin-temp-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Scheduling_Menu}</h3>
        </div>
        <div class="admin-temp-list">
          <ul id="scheduling_list">
            <if condition="$view_rules.work_hours == 'yes' ">
              <li class="templates-items">
                <a href="javascript:;" class="list-item" onclick="obj.switch_schedul(this);" data-tab="workhours">{$Think.lang.Work_Hours}</a>
              </li>
            </if>
            <if condition="$view_rules.reminders == 'yes' ">
              <li class="templates-items">
                <a href="javascript:;" class="list-item" onclick="obj.switch_schedul(this);" data-tab="reminders">{$Think.lang.Reminders}</a>
              </li>
            </if>
            <if condition="$view_rules.custom_timelog == 'yes' ">
              <li class="templates-items">
                <a href="javascript:;" class="list-item" onclick="obj.switch_schedul(this);" data-tab="ctimelog">{$Think.lang.Custom_Timelog}</a>
              </li>
            </if>
            <if condition="$view_rules.calendar == 'yes' ">
              <li class="templates-items">
                <a href="javascript:;" class="list-item" onclick="obj.switch_schedul(this);" data-tab="calendar">{$Think.lang.Calendar}</a>
              </li>
            </if>
          </ul>
        </div>
      </div>
    </div>
    <div class="admin-temp-right">
      <div class="temp-setlist-wrap">
        <div id="sc_nomenu" class="temp-setlist-no">
          <p>{$Think.lang.No_Menu_Selected}</p>
        </div>
        <!--设置工作时间-->
        <div id="sc_workhours" class="temp-setlist-tab">
          <div class="schedul-d-wrap">
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Workday}</label>
              <div id="workday_list" class="bs-workday">
                <if condition="$view_rules.work_hours_submit == 'yes' ">
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="mon">{$Think.lang.Monday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="tue">{$Think.lang.Tuesday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="wed">{$Think.lang.Wednesday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="thu">{$Think.lang.Thursday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="fri">{$Think.lang.Friday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="sat">{$Think.lang.Saturday}</a>
                  <a href="javascript:;" class="workday-item aign-left" onclick="obj.check_workday(this)" data-day="sun">{$Think.lang.Sunday}</a>
                  <else/>
                  <a href="javascript:;" class="workday-item aign-left" data-day="mon">{$Think.lang.Monday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="tue">{$Think.lang.Tuesday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="wed">{$Think.lang.Wednesday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="thu">{$Think.lang.Thursday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="fri">{$Think.lang.Friday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="sat">{$Think.lang.Saturday}</a>
                  <a href="javascript:;" class="workday-item aign-left" data-day="sun">{$Think.lang.Sunday}</a>
                </if>
              </div>
            </div>
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Workday_Start}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.work_hours_submit == 'yes' ">
                    <input id="workday_start"  name="workday_start" autocomplete="off">
                    <else/>
                    <input id="workday_start"  name="workday_start" autocomplete="off" data-options="disabled:true">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Workday_End}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.work_hours_submit == 'yes' ">
                    <input id="workday_end" name="workday_end" autocomplete="off">
                    <else/>
                    <input id="workday_end"  name="workday_end" autocomplete="off" data-options="disabled:true">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Exclude_Date}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.work_hours_submit == 'yes' ">
                    <input id="exclude_date" name="exclude_date" autocomplete="off">
                    <else/>
                    <input id="exclude_date"  name="exclude_date" autocomplete="off" data-options="disabled:true">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-button-full">
              <if condition="$view_rules.work_hours_submit == 'yes' ">
                <a href="javascript:;" onclick="obj.save_work_time();">
                  <div class="form-button-long form-button-hover">
                    {$Think.lang.Submit}
                  </div>
                </a>
              </if>
            </div>
          </div>
        </div>
        <!--设置工作提醒-->
        <div id="sc_reminders" class="temp-setlist-tab">
          <div class="schedul-d-wrap">
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Reminders_switch}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.reminders_submit == 'yes' ">
                    <input id="reminders_on" name="reminders_on" autocomplete="off">
                    <else/>
                    <input id="reminders_on"  name="reminders_on" autocomplete="off" data-options="disabled:true">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Reminders_title}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.reminders_submit == 'yes' ">
                    <input id="reminders_title" class="form-control" name="reminders_title" autocomplete="off" placeholder="{$Think.lang.Input_Reminders_title}">
                    <else/>
                    <input id="reminders_title" class="form-control input-disabled" name="reminders_title" disabled="disabled" placeholder="{$Think.lang.Input_Reminders_title}">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="stcol-lg-1 control-label">{$Think.lang.Reminders_Body}</label>
              <div class="stcol-lg-2">
                <div class="bs-component">
                  <if condition="$view_rules.reminders_submit == 'yes' ">
                    <input id="reminders_body" class="form-control" name="reminders_body" autocomplete="off" placeholder="{$Think.lang.Input_Reminders_Body}">
                    <else/>
                    <input id="reminders_body" class="form-control input-disabled" name="reminders_body" disabled="disabled" placeholder="{$Think.lang.Input_Reminders_Body}">
                  </if>
                </div>
              </div>
            </div>
            <div class="form-button-full">
              <if condition="$view_rules.reminders_submit == 'yes' ">
                <a href="javascript:;" onclick="obj.save_reminder_set();">
                  <div class="form-button-long form-button-hover">
                    {$Think.lang.Submit}
                  </div>
                </a>
              </if>
            </div>
          </div>
        </div>
        <!--设置自定义时间日志选项-->
        <div id="sc_ctimelog" class="temp-setlist-tab">
          <table id="datagrid_timelog"></table>
          <div id="timelog_tb" style="padding:5px;">
            <if condition="$view_rules.add_timelog_item == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-uni3432" plain="true" onclick="obj.add_timelog();">
                {$Think.lang.Add_Timelog_Item}
              </a>
            </if>
            <if condition="$view_rules.timelog_item_modify == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.modify_timelog();">
                {$Think.lang.Modify}
              </a>
            </if>
            <if condition="$view_rules.timelog_item_delete == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.delete_timelog();">
                {$Think.lang.Delete}
              </a>
            </if>
          </div>
        </div>
        <!--设置日历设置-->
        <div id="sc_calendar" class="temp-setlist-tab">
          <table id="datagrid_calendar"></table>
          <div id="calendar_tb" style="padding:5px;">
            <if condition="$view_rules.time_calendar_add == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-uni3432" plain="true" onclick="obj.add_calendar();">
                {$Think.lang.Add_Time_Calendar}
              </a>
            </if>
            <if condition="$view_rules.calendar_modify == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.modify_calendar();">
                {$Think.lang.Modify}
              </a>
            </if>
            <if condition="$view_rules.calendar_delete == 'yes' ">
              <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.delete_calendar();">
                {$Think.lang.Delete}
              </a>
            </if>
          </div>
        </div>
      </div>
    </div>
</block>