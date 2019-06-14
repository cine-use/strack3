$(function(){
    obj={
        //切换日程设置菜单
        switch_schedul:function(i){
            var tabname = $(i).data("tab");
            $('#sc_nomenu').hide();
            $('.templates-items').removeClass("templates-active");
            $(i).parent().addClass("templates-active");
            switch_tab(tabname);
        },
        //选择工作日设置
        check_workday:function(i){
            var day = $(i).data("day");
            if($(i).hasClass("workday-ac")){
                $(i).removeClass("workday-ac")
            }else {
                $(i).addClass("workday-ac")
            }
        },
        //提交WorkHours
        save_work_time:function(){
            var $start = $('#workday_start'),
                start_h =  $start.timespinner("getHours"),
                start_m =  $start.timespinner("getMinutes"),
                $end = $('#workday_end'),
                end_h = $end.timespinner("getHours"),
                end_m = $end.timespinner("getMinutes"),
                exdate_val = Strack.get_combos_val('#exclude_date', 'combobox', 'getValues'),
                days = [];
            var exDate = exdate_val? exdate_val:[];
            var Tstart = start_h*3600+start_m*60,
                Tend = end_h*3600+end_m*60;
            if(!Tstart){Tstart = 0}
            if(!Tend){Tend = 0}
            $('#workday_list').find(".workday-item").each(function(){
                if($(this).hasClass("workday-ac")){
                    days.push($(this).data("day"));
                }
            });
            $.ajax({
                type:'POST',
                url: SchedulPHP['saveScheduleWorkdaySetting'],
                data:{
                    start:Tstart,
                    end:Tend,
                    exclude_date: exDate.join(","),
                    days:days.join(",")
                },
                dataType : "json",
                beforeSend : function () {
                    $('#sc_workhours').append(Strack.loading_dom("white","","workhour"));
                },
                success : function (data) {
                    if (parseInt(data['status']) === 200) {
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $('#st-load_workhour').remove();
                }
            });
        },
        //提交提醒设置
        save_reminder_set:function(){
            var ropen =Strack.get_switch_val(),
                rtitle = $('#reminders_title').val(),
                rbody = $('#reminders_body').val();
            if(ropen>0&&rtitle.length===0){
                layer.msg( StrackLang['Reminders_Title_NULL'], {icon: 2,time:1200,anim: 6});
            }else if(ropen>0&&rbody.length===0){
                layer.msg( StrackLang['Reminders_Content_NULL'], {icon: 2,time:1200,anim: 6});
            }else{
                $.ajax({
                    type:'POST',
                    url: SchedulPHP['saveReminderSetting'],
                    data:{
                        ropen:ropen,
                        rtitle:rtitle,
                        rbody:rbody
                    },
                    dataType: "json",
                    beforeSend : function () {
                        $('#sc_reminders').append(Strack.loading_dom("white","","reminders"));
                    },
                    success : function (data) {
                        if (parseInt(data['status']) === 200) {
                            Strack.top_message({bg: 'g', msg: data['message']});
                        } else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                        $('#st-load_reminders').remove();
                    }
                });
            }
        },
        //添加timelog issue
        add_timelog:function(){
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Timelog_Item'],
                width: 480,
                height: 180,
                content: Strack.dialog_dom({
                    type:'normal',
                    items:[
                        {case:1,id:'Ntimelog_name',type:'text',lang:StrackLang['Timelog_Item_Name'],name:'name',valid:"1,128",value:""}
                    ],
                    footer:[
                        {obj:'update_timelog_issue',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                })
            });
        },
        //提交timelog issue
        update_timelog_issue:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchedulPHP['addTimelogIssue'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                        $('#datagrid_timelog').datagrid('reload');
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        //修改timelog issue
        modify_timelog:function(){
            var rows = $('#datagrid_timelog').datagrid('getSelections');
            if(rows.length <1){
                layer.msg( StrackLang['Please_Select_One'], {icon: 2,time:1200,anim: 6});
            }else if(rows.length > 1){
                layer.msg( StrackLang['Only_Choose_One'], {icon: 2,time:1200,anim: 6});
            }else {
                modify_timeLog_dialog(rows[0], 'datagrid_box');
            }
        },
        //提交修改timelog issue
        update_timelog:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchedulPHP['modifyTimelogIssue'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                        $('#datagrid_timelog').datagrid('reload');
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        //删除timelog issue
        delete_timelog:function(){
            Strack.ajax_grid_delete('datagrid_timelog', 'id', StrackLang['Delete_Timelog_Notice'], SchedulPHP['deleteTimelogIssue'], time_issue_param);
        },
        //添加timelog calendar
        add_calendar:function(){
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Time_Calendar'],
                width: 480,
                height: 360,
                content: Strack.dialog_dom({
                    type:'normal',
                    items:[
                        {case:1,id:'calendar_name',type:'text',lang:StrackLang['Time_Calendar_Name'],name:'name',valid:"1,128",value:""},
                        {case:2,id:'calendar_start',type:'text',lang:StrackLang['Start_Date'],name:'start_time',valid:"1",value:""},
                        {case:2,id:'calendar_end',type:'text',lang:StrackLang['End_Date'],name:'end_time',valid:"1",value:""},
                        {case:2,id:'calendar_type',type:'text',lang:StrackLang['Type'],name:'type',valid:"1",value:""}
                    ],
                    footer:[
                        {obj:'submit_calendar',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){
                    Strack.open_date_box('#calendar_start',378,26);
                    Strack.open_date_box('#calendar_end',378,26);
                    Strack.combobox_widget('#calendar_type', {
                        url: SchedulPHP["getCalendarTypeList"],
                        valueField: 'id',
                        textField: 'name',
                        width: 378,
                        height: 26
                    });
                }
            });
        },
        //提交timelog calendar
        submit_calendar:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchedulPHP['addCalendar'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                        $('#datagrid_calendar').datagrid('reload');
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        //修改timelog calendar
        modify_calendar:function(){
            var rows = $('#datagrid_calendar').datagrid('getSelections');
            if(rows.length <1){
                layer.msg( StrackLang['Please_Select_One'], {icon: 2,time:1200,anim: 6});
            }else if(rows.length > 1){
                layer.msg( StrackLang['Only_Choose_One'], {icon: 2,time:1200,anim: 6});
            }else {
                modify_calendar_dialog(rows[0], 'datagrid_box');
            }
        },
        //提交修改timelog calendar
        update_timeCalendar_set:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchedulPHP['modifyCalendar'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                        $('#datagrid_calendar').datagrid('reload');
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        //删除timelog calendar
        delete_calendar:function(){
            Strack.ajax_grid_delete('datagrid_calendar', 'id', StrackLang['Delete_Calendar_Notice'], SchedulPHP['deleteCalendar'], calendar_param);
        }
    };


    var param = Strack.generate_hidden_param();

    var time_issue_param = {
        page : param.page,
        module_id : param.timeLog_issue_module_id,
        module_code : param.timeLog_issue_module_code,
        module_name : param.timeLog_issue_module_name
    };

    var calendar_param = {
        page : param.page,
        module_id : param.calendar_module_id,
        module_code : param.calendar_module_code,
        module_name : param.calendar_module_name
    };

    /**
     * 加载工作时间
     */
    function load_work_time_set(){
        $.ajax({
            type:'POST',
            url: SchedulPHP['getScheduleWorkdaySetting'],
            beforeSend : function () {
                $('#sc_workhours').append(Strack.loading_dom("white","","workhour"));
            },
            dataType : "json",
            success : function (data) {
                $('#workday_start').timespinner({
                    height:35,
                    width:500,
                    value:format_work_time(data["start"])
                });
                $('#workday_end').timespinner({
                    height:35,
                    width:500,
                    value:format_work_time(data["end"])
                });

                $('#exclude_date').combobox({
                    url: SchedulPHP["getScheduleExcludeList"],
                    width: 500,
                    height: 35,
                    valueField: 'id',
                    textField: 'name',
                    value: data["exclude_date"],
                    multiple: true
                });

                var days_arr = (data["days"]).split(",");
                $('#workday_list').find(".workday-item").each(function(){
                    if($.inArray($(this).data("day"), days_arr)>=0){
                        $(this).addClass("workday-ac");
                    }
                });

                $('#st-load_workhour').remove();
            }
        })
    }

    /**
     * 加载工作提醒
     */
    function load_reminder_set(){
        $.ajax({
            type:'POST',
            url: SchedulPHP['getReminderSetting'],
            dataType: "json",
            beforeSend : function () {
                $('#sc_workhours').append(Strack.loading_dom("white","","reminders"));
            },
            success : function (data) {
                $('#reminders_title').val(data["rtitle"]);
                $('#reminders_body').val(data["rbody"]);
                Strack.init_open_switch({
                    dom: '#reminders_on',
                    value: data["ropen"],
                    onText: StrackLang['Switch_ON'],
                    offText: StrackLang['Switch_OFF'],
                    width: 100
                });
                $('#st-load_reminders').remove();
            }
        });
    }

    /**
     *  加载Timelog数据
     */
    function load_timelog_set(){
        $('#datagrid_timelog').datagrid({
            url: SchedulPHP['getTimelogGridData'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('#sc_ctimelog', 0),
            DragSelect:true,
            adaptive: {
                dom: '#sc_ctimelog',
                min_width: 300,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'timelog_issue_id',title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 300}
            ]],
            toolbar: '#timelog_tb',
            pagination: true,
            pageSize: 100,
            pageList: [100, 200],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false,
            onDblClickRow: function(index,row){
                $(this).datagrid('selectRow',index);
                modify_timeLog_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 修改Time log item
     * @param row
     * @param id
     */
    function modify_timeLog_dialog(row, id){
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Timelog_Item'],
            width: 480,
            height: 180,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mtimelog_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mtimelog_iname',type:'text',lang:StrackLang['Timelog_Item_Name'],name:'name',valid:"1,128",value:row["name"]}
                ],
                footer:[
                    {obj:'update_timelog',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }

    /**
     * 加载Time Calendar数据
     */
    function loadtime_calendar(){
        $('#datagrid_calendar').datagrid({
            url: SchedulPHP['getCalendarGridData'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('#sc_calendar', 0),
            DragSelect:true,
            adaptive: {
                dom: '#sc_calendar',
                min_width: 300,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'calendar_id',title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 220},
                {field: 'start_time', title: StrackLang['Start_Date'], align: 'center', width: 160},
                {field: 'end_time', title: StrackLang['End_Date'], align: 'center', width: 160},
                {field: 'type', title: StrackLang['Type'], align: 'center', width: 160},
                {field: 'created_by', title: StrackLang['Created_by'], align: 'center', width: 180}
            ]],
            toolbar: '#calendar_tb',
            pagination: true,
            pageSize: 50,
            pageList: [50, 100],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false,
            onDblClickRow: function(index,row){
                $(this).datagrid('selectRow',index);
                modify_calendar_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 修改Calendar
     * @param row
     * @param id
     */
    function modify_calendar_dialog(row, id){

        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Time_Calendar'],
            width: 480,
            height: 360,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mcalendar_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mcalendar_name',type:'text',lang:StrackLang['Time_Calendar_Name'],name:'name',valid:"1,128",value:row['name']},
                    {case:2,id:'Mcalendar_start',type:'text',lang:StrackLang['Start_Date'],name:'start_time',valid:"1",value:""},
                    {case:2,id:'Mcalendar_end',type:'text',lang:StrackLang['End_Date'],name:'end_time',valid:"1",value:""},
                    {case:2,id:'Mcalendar_type',type:'text',lang:StrackLang['Type'],name:'type',valid:"1",value:row['type']}
                ],
                footer:[
                    {obj:'update_timeCalendar_set',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.open_date_box('#Mcalendar_start',378,26,row['start_time']);
                Strack.open_date_box('#Mcalendar_end',378,26,row['end_time']);
                Strack.combobox_widget('#Mcalendar_type', {
                    url: SchedulPHP["getCalendarTypeList"],
                    valueField: 'id',
                    textField: 'name',
                    width: 378,
                    height: 26,
                    value: row['type']
                });
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });

    }

    /**
     * 格式化时间
     * @param time
     * @returns {string}
     */
    function format_work_time(time){
        var fh = Math.floor(time/3600),
            fm = Math.floor((time%3600)/60);
        return Strack.prefix_integer(fh,2)+':'+Strack.prefix_integer(fm, 2);
    }

    /**
     * 加载DOM内容
     * @param tabname
     */
    function switch_tab(tabname){
        $('.temp-setlist-tab').removeClass("temp-d-active");
        $('#sc_'+tabname).addClass("temp-d-active");
        switch (tabname){
            case "workhours":
                load_work_time_set();
                break;
            case "reminders":
                load_reminder_set();
                break;
            case "ctimelog":
                load_timelog_set();
                break;
            case "calendar":
                loadtime_calendar();
                break;
        }
    }
});
