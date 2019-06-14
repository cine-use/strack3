$(function () {
    obj = {
        // 切换左侧导航显示
        switch_tab: function (i) {
            var tab_name = $(i).data("tab");
            switch_tab(tab_name);
        },
        // 给项目添加成员
        member_add: function (i) {
            var lang = $(i).data("lang");
            Strack.item_operate_dialog(lang,
                {
                    mode: "create",
                    field_list_type: ['edit'],
                    module_id: 3,
                    project_id: param["project_id"],
                    page: "project_member",
                    schema_page: "project_member",
                    type: "add_panel"
                },
                function () {
                    obj.reset_member();
                }
            );
        },
        member_edit: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#team_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type: ['edit'],
                        module_id: 3,
                        project_id: param["project_id"],
                        page: 'project_member',
                        schema_page: "project_member",
                        type: "update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.reset_member();
                    }
                );
            });
        },
        member_delete: function (i) {
            Strack.ajax_grid_delete('team_datagrid_box', 'id', StrackLang['Delete_Member_Notice'], StrackPHP['deleteGridData'], param);
        },
        // 重置member数据表格
        reset_member: function()
        {
            $("#team_datagrid_box").datagrid("reload");
        },
        // 切换开启自动保存
        nav_auto_save: function (i) {
            var $this = $(i);
            if ($this.hasClass("active")) {
                $this.removeClass("active");
                $this.find("i").removeClass("icon-checked")
                    .addClass("icon-unchecked");
                G_nav_switch = false;
            } else {
                $this.addClass("active");
                $this.find("i").removeClass("icon-unchecked")
                    .addClass("icon-checked");
                G_nav_switch = true;
            }
        },
        // 报错项目导航设置
        nav_save: function (i) {
            save_nav_data();
        },
        // 选择模块
        select_module: function (i) {
            var tab_name = $(i).data("tabname");
            var module_param = {
                module_id: $(i).data("moduleid"),
                module_name: $(i).data("modulename"),
                module_type: $(i).data("moduletype"),
                module_code: $(i).data("modulecode"),
                template_id: param.template_id,
                filter: ''
            };

            $(".nation-items").removeClass("admin-bid-ac");
            $(i).addClass("admin-bid-ac");

            // 获取当前模块
            switch (tab_name) {
                case "status":
                    // 获取当前模块状态设置
                    G_status_param = module_param;
                    show_status_panel();
                    get_module_status();
                    break;
                case "step":
                    // 获取当前模块状态设置
                    G_step_param = module_param;
                    show_step_panel();
                    get_module_step();
                    break;
            }
        },
        // 添加status dialog
        status_add: function (i) {
            add_status_dialog();
        },
        // 提交status添加
        status_submit: function (i) {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', ProjectPHP['addStatus'], {
                back: function (data) {
                    if (parseInt(data['status']) === 200) {
                        Strack.dialog_cancel();
                        G_status_param["filter"] = data["data"]["name"];
                        $("#status_search").val(data["data"]["name"]);
                        get_module_status();
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 过滤查询status
        filter_status: function (i) {
            G_status_param["filter"] = $("#status_search").val();
            get_module_status();
        },
        // 把状态添加到状态拖拽栏
        add_status_to_drag: function (i) {
            var status_id = $(i).attr("data-statusid"),
                checked = $(i).attr("data-checked");
            var icon, checked_sta;
            if (checked === "no") {
                icon = "icon-uniF068";
                checked_sta = 'yes';
                // 添加到拖拽列表区域
                $("#status_drag_list").find(".temp-setlist-no").remove();
                G_checked_status_data[status_id] = G_status_data[status_id];
                add_single_drag_status(G_status_data[status_id]);
            } else {
                icon = "icon-uniF067";
                checked_sta = 'no';
                // 从拖拽区域删除
                $("#drag_status_item_" + status_id).remove();
                // 判断还有没有列表
                if ($(".drag-status-item").length === 0) {
                    $("#status_drag_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Please_Select_One_Status"] + '</p></div>');
                }
            }
            $(i).attr("data-checked", checked_sta);
            $(i).empty().append('<i class="' + icon + '"></i>');

            auto_save_status_data();
        },
        // 状态拖拽列表保存
        drag_status_save: function (i) {
            save_status_config_data();
        },
        // 状态拖拽列表自动保存
        drag_status_auto_save: function (i) {
            var $this = $(i);
            if ($this.hasClass("active")) {
                $this.removeClass("active");
                $this.find("i").removeClass("icon-checked")
                    .addClass("icon-unchecked");
                G_status_switch = false;
            } else {
                $this.addClass("active");
                $this.find("i").removeClass("icon-unchecked")
                    .addClass("icon-checked");
                G_status_switch = true;
            }
        },
        // 添加step dialog
        step_add: function (i) {
            add_step_dialog();
        },
        // 提交step添加
        step_submit: function (i) {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', ProjectPHP['addStep'], {
                back: function (data) {
                    if (parseInt(data['status']) === 200) {
                        Strack.dialog_cancel();
                        G_step_param["filter"] = data["data"]["name"];
                        $("#step_search").val(data["data"]["name"]);
                        get_module_step();
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 过滤查询step
        filter_step: function (i) {
            G_step_param["filter"] = $("#step_search").val();
            get_module_step();
        },
        // 把工序添加到工序拖拽栏
        add_step_to_drag: function (i) {
            var step_id = $(i).attr("data-stepid"),
                checked = $(i).attr("data-checked");
            var icon, checked_sta;
            if (checked === "no") {
                icon = "icon-uniF068";
                checked_sta = 'yes';
                // 添加到拖拽列表区域
                $("#step_drag_list").find(".temp-setlist-no").remove();
                G_checked_step_data[step_id] = G_step_data[step_id];
                add_single_drag_step(G_step_data[step_id]);
            } else {
                icon = "icon-uniF067";
                checked_sta = 'no';
                // 从拖拽区域删除
                $("#drag_step_item_" + step_id).remove();
                // 判断还有没有列表
                if ($(".drag-step-item").length === 0) {
                    $("#step_drag_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Please_Select_One_Step"] + '</p></div>');
                }
            }
            $(i).attr("data-checked", checked_sta);
            $(i).empty().append('<i class="' + icon + '"></i>');

            auto_save_step_data();
        },
        // 状态拖拽列表保存
        drag_step_save: function (i) {
            save_step_config_data();
        },
        // 状态拖拽列表自动保存
        drag_step_auto_save: function (i) {
            var $this = $(i);
            if ($this.hasClass("active")) {
                $this.removeClass("active");
                $this.find("i").removeClass("icon-checked")
                    .addClass("icon-unchecked");
                G_step_switch = false;
            } else {
                $this.addClass("active");
                $this.find("i").removeClass("icon-unchecked")
                    .addClass("icon-checked");
                G_step_switch = true;
            }
        },
        // 添加磁盘
        nav_add_disk: function (i) {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Entity_Disk_Title'],
                width: 480,
                height: 370,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[],
                    items:[
                        {case:1,id:'Ndisk_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"1",value:""},
                        {case:1,id:'Ndisk_code',type:'text',lang:StrackLang['Code'],name:'code',valid:"1",value:""},
                        {case:1,id:'Nwin_path',type:'text',lang:StrackLang['Win_Path'],name:'win_path',valid:"",value:""},
                        {case:1,id:'Nmac_path',type:'text',lang:StrackLang['Mac_Path'],name:'mac_path',valid:"",value:""},
                        {case:1,id:'Nlinux_path',type:'text',lang:StrackLang['Linux_Path'],name:'linux_path',valid:"",value:""}
                    ],
                    footer:[
                        {obj:'submit_add_disk',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){

                }
            });
        },
        // 提交磁盘添加
        submit_add_disk: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['addProjectDisk'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        // 刷新当前页面所有combobox
                        var comb_id;
                        $("#overview_disk").find('.combobox-f')
                            .each(function () {
                                comb_id = $(this).attr('id');
                                $("#"+comb_id).combobox("reload");
                            });
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 添加更多磁盘
        add_more_disk: function (i) {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_More_Disk_Title'],
                width: 480,
                height: 280,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[
                        {case:101,id:'Mdisk_id',type:'hidden',name:'disk_id',valid:1,value:param['disk_id']}
                    ],
                    items:[
                        {case:1,id:'Mdisk_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"1",value:""},
                        {case:1,id:'Mdisk_code',type:'text',lang:StrackLang['Code'],name:'code',valid:"1",value:""},
                        {case:2,id:'Mdisk_list',lang:StrackLang['Disks'],name:'id',valid:'1'}
                    ],
                    footer:[
                        {obj:'add_more_project_disk',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){
                    Strack.combobox_widget('#Mdisk_list', {
                        url: StrackPHP["getDiskCombobox"],
                        valueField: 'id',
                        textField: 'name'
                    });
                }
            });
        },
        // 添加更多磁盘
        add_more_project_disk: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['addProjectMoreDisk'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        // 刷新当前页面所有combobox
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                        add_more_new_disk_item(data["data"]);
                        obj.check_more_project_disk_notice();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 删除更多磁盘
        delete_more_project_disk: function(i)
        {
            var code = $(i).attr("data-code");
            $.ajax({
                type : 'POST',
                url : StrackPHP['deleteProjectMoreDisk'],
                data : {
                    disk_id: param.disk_id,
                    code : code
                },
                dataType : 'json',
                beforeSend : function () {
                    $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                },
                success : function (data) {
                    $.messager.progress('close');
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        $("#item_disk_"+code).remove();
                        obj.check_more_project_disk_notice();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 判断添加更多磁盘显示
        check_more_project_disk_notice: function () {
            if($("#entity_disk_list .disk-setting-item").length>0){
                $("#entity_disk_list .datagrid-empty-no").remove();
            }else {
                $("#entity_disk_list").html('<div class="datagrid-empty-no">'+StrackLang["No_More_Disks_Configured"]+'</div>');
            }
        }
    };

    var param = Strack.generate_hidden_param();
    param["item_id"] = param["project_id"];
    var G_nav_data = {},
        G_nav_switch = false;
    var G_status_data = {},
        G_checked_status_data = {},
        G_status_switch = false,
        G_status_param = {};
    var G_step_data = {},
        G_checked_step_data = {},
        G_step_switch = false,
        G_step_param = {};


    /**
     * 键盘事件
     */
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter"){
            // 按回车键搜索
            if($("#status_search").is(':focus')){
                // 搜索状态
                e.preventDefault();
                obj.filter_status(Strack.get_obj_by_id("search_status_bnt"));
            }

            if($("#step_search").is(':focus')){
                // 搜索工序
                e.preventDefault();
                obj.filter_step(Strack.get_obj_by_id("search_step_bnt"));
            }
        }
    });

    assembly_panel();

    /**
     * 组装页面
     */
    function assembly_panel() {
        // 获取左侧菜单隐藏状态
        var left_status = Strack.read_storage(param.page);
        if(left_status){
            Strack.toggle_media_menu(Strack.get_obj_by_id("overview_left_menu"), left_status);
        }

        // 获取当前页面url锚点
        if(param.url_tab && param["rule_tab_"+param.url_tab] === "yes"){
            switch_tab(param.url_tab);
        }else {
            var default_tab = get_default_tabs();
            if(default_tab){
                switch_tab(default_tab);
            }
        }
    }

    /**
     * 获取允许访问默认的tabs
     */
    function get_default_tabs() {
        var default_tab = "";
        var list = ["details", "team", "navigation", "status", "step", "disk"];
        list.forEach(function (value) {
            if(param["rule_tab_"+value] === "yes" && !default_tab){
                default_tab = value;
                return false;
            }
        });
        return default_tab;
    }
    
    /**
     * 切换tab
     * @param tab_name
     */
    function switch_tab(tab_name) {
        $('.media-m-item').removeClass("media-m-w-active").each(function () {
            if ($(this).data("tab") === tab_name) {
                $(this).addClass("media-m-w-active");
            }
        });

        modify_url_address(tab_name, 'tab='+tab_name);

        switch (tab_name) {
            case "details":
                load_info_panel();
                break;
            case "team":
                load_team_data();
                break;
            case "navigation":
                // 项目页面导航设置
                init_nav_item();
                break;
            case "status":
                get_module_list(tab_name);
                break;
            case "step":
                get_module_list(tab_name);
                break;
            case "disk":
                init_disk_panel();
                break;
        }

        //激活 显示主窗口
        $('.pitem-wrap')
            .removeClass("active")
            .each(function () {
                if ($(this).data("tab") === tab_name) {
                    $(this).addClass("active");
                }
            });
    }

    /**
     * 加载项目详细信息
     */
    function load_info_panel() {
        var info_param = param;
        info_param["category"] = "project_overview";
        Strack.load_info_panel({
            id: "#project_base_info",
            mask: 'project_info',
            pos: 'max',
            url: StrackPHP["getProjectInfo"],
            data: info_param,
            loading_type: 'white'
        }, function (data) {
            var img = '';
            var media_data = data['media_data'];
            media_data['link_id'] = param["project_id"];
            media_data['module_id'] = param["module_id"];
            media_data['param']['icon'] = "icon-uniF1ED";
            Strack.thumb_media_widget('#project_base_thumb', media_data, {modify_thumb:param.rule_thumb_modify, clear_thumb:param.rule_thumb_clear});
        });
    }


    /**
     * 初始化导航设置
     */
    function init_nav_item() {
        $.ajax({
            type: 'POST',
            url: ProjectPHP['getProjectNavSetting'],
            dataType: "json",
            data: {
                category: "navigation",
                module_code: param["module_code"],
                module_id: param["module_id"],
                project_id: param["project_id"],
                template_id: param["template_id"]
            },
            beforeSend: function () {
                G_nav_data = {};
            },
            success: function (data) {
                var $nav_list = $("#nav_module_list");
                $nav_list.empty();
                var disabled = false;
                data.forEach(function (val) {
                    $nav_list.append(drag_nav_item_dom(val));
                    var is_checked = val["checked"] === "yes" ? 1 : 0;

                    if(val["code"] !== "overview" && param.rule_navigation_switch_button === "yes"){
                        disabled = false;
                    }else {
                        disabled = true;
                    }

                    G_nav_data[val["module_id"]] = val;
                    Strack.init_open_switch({
                        dom: '#' + val["code"] + '_nav_swicth',
                        disabled: disabled,
                        value: is_checked,
                        onText: StrackLang['Switch_ON'],
                        offText: StrackLang['Switch_OFF'],
                        width: 100,
                        height: 26
                    }, function (data) {
                        // 判断是否自动保存
                        auto_save_nav_data();
                    });
                });

                if(param.rule_navigation_drag === "yes"){
                    nav_item_drag();
                }
            }
        });
    }

    /**
     * 拖拽导航设置项DOM
     * @param data
     * @returns {string}
     */
    function drag_nav_item_dom(data) {
        var dom = '';
        dom += '<li class="text-no-select">' +
            '<div class="overview-nav-item" data-moduleid="' + data["module_id"] + '" data-swicthid="' + data["code"] + '_nav_swicth">' +
            '<div class="overview-nav-handle aign-left">' +
            '<i class="icon-uniE6A1"></i>' +
            '</div>' +
            '<div class="overview-nav-icon aign-left">' +
            '<i class="' + data["icon"] + '"></i>' +
            '</div>' +
            '<div class="overview-nav-title aign-left">' +
            '<div class="nav-name text-ellipsis">' +
            data["name"] +
            '</div>' +
            '<div class="nav-description text-ellipsis">' +
            data["type_name"] +
            '</div>' +
            '</div>' +
            '<div class="overview-nav-swicth aign-left">' +
            '<input id="' + data["code"] + '_nav_swicth" />' +
            '</div>' +
            '</div>' +
            '</li>';
        return dom;
    }

    /**
     * 拖拽导航事件绑定
     */
    function nav_item_drag() {
        Sortable.create(Strack.get_obj_by_id('nav_module_list'), {
            animation: 150,
            forceFallback: true,
            filter : '.overview-nav-swicth',
            onEnd: function (/**Event*/evt) {
                // 判断是否自动保存
                auto_save_nav_data();
            }
        });
    }

    /**
     * 判断是否自动保存
     */
    function auto_save_nav_data() {
        if (G_nav_switch) {
            save_nav_data();
        }
    }

    /**
     * 保存导航数据
     */
    function save_nav_data() {
        var switch_val, module_id = 0;
        var config = [];
        $(".overview-nav-item").each(function () {
            switch_val = Strack.get_switch_val('#' + $(this).attr("data-swicthid"));
            module_id = $(this).attr("data-moduleid");
            if (parseInt(switch_val) === 1) {
                config.push(G_nav_data[module_id]);
            }
        });
        $.ajax({
            type: 'POST',
            url: ProjectPHP['modifyProjectNavTemplateConfig'],
            data: JSON.stringify({
                category: "navigation",
                module_code: param["module_code"],
                module_id: param["module_id"],
                project_id: param["project_id"],
                template_id: param["template_id"],
                config: config
            }),
            dataType: 'json',
            contentType: 'application/json',
            beforeSend: function () {
                $('#tab_navigation').prepend(Strack.loading_dom('white', '', 'navigation'));
            },
            success: function (data) {
                Strack.top_message({bg: 'g', msg: data['message']});
                $('#st-load_navigation').remove();
                if (parseInt(data["status"]) === 200) {
                    data["data"].forEach(function (val) {
                        G_nav_data[val["module_id"]] = val;
                    });
                    // 调整导航显示
                    Strack.refresh_top_menu(data["menu_data"]);
                }
            }
        });
    }

    /**
     * 加载状态数据表格
     */
    function load_team_data() {
        Strack.load_grid_columns('#team_datagrid_main', {
            loading_id: ".team_datagrid_main",
            page: 'project_member',
            schema_page: 'project_member',
            module_id: param["project_member_module_id"],
            project_id: param["project_id"],
            grid_id: 'team_datagrid_box',
            view_type: "grid",
            temp_fields: {
                add: {},
                cut: {}
            }
        }, function (data) {
            //过滤条件
            var filter_data = {
                filter: {
                    temp_fields: {
                        add: {},
                        cut: {}
                    },
                    group: data['grid']["group_name"],
                    sort: data['grid']["sort_config"]["sort_query"],
                    request: [
                        {field : 'project_id', value : param.project_id, condition : 'EQ', module_code : 'project_member', table : 'ProjectMember'}
                    ],
                    filter_input: data['grid']["filter_config"]["filter_input"],
                    filter_panel: data['grid']["filter_config"]["filter_panel"],
                    filter_advance: data['grid']["filter_config"]["filter_advance"]
                },
                page: 'project_member',
                schema_page: 'project_member',
                module_id: param["project_member_module_id"],
                project_id: param["project_id"]
            };
            // datagrid 配置参数
            var gird_param = {
                url: ProjectPHP['getProjectTeamMembers'],
                height: Strack.panel_height(".p-group-full", 0),
                view:scrollview,
                rowheight: 50,
                differhigh: false,
                singleSelect: false,
                adaptive: {
                    dom: ".base-m-grid",
                    min_width: 680,
                    exth: 0,
                    domresize: 1
                },
                ctrlSelect: true,
                multiSort: true,
                DragSelect: true,
                moduleId: param["project_member_module_id"],
                projectId: param['project_id'],
                queryParams: {
                    filter_data: JSON.stringify(filter_data)
                },
                panelConfig: {
                    active_filter_id: data['grid']["filter_config"]["filter_id"]
                },
                sortConfig: data['grid']["sort_config"],
                sortData: data['grid']["sort_config"]["sort_data"],
                toolbarConfig: {
                    id: 'team_datagrid_main',
                    page: "project_member",
                    sortAllow: true,
                    groupAllow: true,
                    fieldAllow: true,
                    viewAllow: true,
                    actionAllow: true
                },
                searchConfig: {
                    id: 'team_grid_search',
                    bar_show: data['grid']["filter_bar_show"],
                    filterBar: {
                        main_dom: 'team_datagrid_main',
                        bar_dom: 'team_filter_main'
                    }
                },
                filterConfig: {
                    id: 'team_filter_main',
                    schema_page: 'project_member',
                    barParam: {}
                },
                authorityRules: {
                    filter: {
                        show : param.rule_team_panel_filter,
                        edit : param.rule_team_modify_filter
                    },
                    sort : param.rule_team_sort,
                    group : param.rule_team_group
                },
                contextMenuData: {
                    id: 'st_menu_project_team',
                    copy_id: 'ac_copy_cell',
                    edit_id: '#team_datagrid_main .edit-menu',
                    data: []
                },
                columnsFieldConfig: data['grid']["columnsFieldConfig"],
                frozenColumns: data['grid']["frozenColumns"],
                columns: data['grid']["columns"],
                toolbar: '#team_tb',
                pagination: true,
                pageNumber: 1,
                pageSize: 200,
                pageList: [100, 200, 300, 400, 500],
                pagePosition: 'bottom',
                remoteSort: false,
                onDblClickRow: function (index, row) {

                }
            };

            //是否应用分组
            if (!$.isEmptyObject(data['grid']["group_name"])){
                gird_param["groupActive"] = true;
                gird_param["groupField"] = Strack.get_grid_group_field(data['grid']["group_name"])["field"];
                gird_param["groupFormatter"] = function (value, rows) {
                    return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                };
            }

            $('#team_datagrid_box').datagrid(gird_param)
                .datagrid('enableCellEditing')
                .datagrid('disableCellSelecting')
                .datagrid('gotoCell',
                    {
                        index: 0,
                        field: 'id'
                    }
                ).datagrid('columnMoving');
        });
    }

    /**
     * 获取模块列表
     */
    function get_module_list(tab_name) {
        var $module_list = $("#" + tab_name + "_module_list");
        $.ajax({
            url: ProjectPHP['getProjectOverviewModuleList'],
            type: 'POST',
            dataType: 'json',
            data: {
                tab_name: tab_name,
                template_id: param.template_id
            },
            beforeSend: function () {
                $module_list.append(Strack.loading_dom('white', '', 'module'));
            },
            success: function (data) {
                var dom = '',
                    type_list = ['fixed', 'entity'];

                //模块列表
                type_list.forEach(function (type) {
                    if (data[type]) {
                        dom += '<li class="module-items-title">' + data[type]["title"] + '</li>';
                        data[type]['data'].forEach(function (val) {
                            dom += module_list_dom(val, tab_name);
                        });
                    }
                });

                $module_list.empty().append(dom);
                $('#st-load_module').remove();
            }
        });
    }

    /**
     * 模块列表DOM
     * @param data
     * @param tab_name
     * @returns {string}
     */
    function module_list_dom(data, tab_name) {
        var dom = '';
        dom += '<a href="javascript:;" class="nation-items" onclick="obj.select_module(this)" data-tabname="' + tab_name + '" data-moduleid="' + data["id"] + '" data-modulename="' + data["name"] + '" data-moduletype="' + data["type"] + '" data-modulecode="' + data["code"] + '">' +
            '<div class="nation-items-wrap middle">' +
            '<div class="aign-left">' +
            '<i class="' + data["icon"] + ' icon-left"></i>' +
            '<span>' + data["name"] + '</span>' +
            '</div>' +
            '</div>' +
            '</a>';
        return dom;
    }

    /**
     * 显示状态配置面板
     */
    function show_status_panel() {
        var $status = $("#status_config");
        if (!$status.hasClass("visible")) {
            $status.addClass("visible");
            $("#status_config_notice").hide();
            $status.find(".p-status-allow").show();
            $status.find(".p-status-now").show();
        }
    }

    /**
     * 获取当前选择模块状态设置
     */
    function get_module_status() {
        $.ajax({
            url: ProjectPHP['getProjectOverviewStatusList'],
            type: 'POST',
            dataType: 'json',
            data: G_status_param,
            beforeSend: function () {
                G_status_data = {};
                $('#module_status_list').append(Strack.loading_dom('white', '', 'module_status'));
            },
            success: function (data) {
                var dom = '';
                var status_list = data["status_list"];
                var correspond_lidt = ['blocked', 'not_started', 'in_progress', 'daily', 'done', 'hide'];

                // 状态列表
                correspond_lidt.forEach(function (val) {
                    if (status_list[val]['data'].length > 0) {
                        dom += '<li class="module-items-title">' + status_list[val]["title"] + '</li>';
                        status_list[val]['data'].forEach(function (item) {
                            item["corresponds_lang"] = status_list[val]["title"];
                            dom += status_list_dom(item);
                            G_status_data[item["id"]] = item;
                        });
                    }
                });

                if (dom.length > 0) {
                    $("#module_status_list").empty().append(dom);
                } else {
                    $("#module_status_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Datagird_No_Data"] + '</p></div>');
                }


                // 状态已经呗选中列表
                var drag_dom = '';
                data["status_checked"].forEach(function (val) {
                    G_checked_status_data[val["id"]] = val;
                    drag_dom += drag_status_item_dom(val);
                });
                if (drag_dom.length > 0) {
                    $("#status_drag_list").empty().append(drag_dom);
                    if(param.rule_status_drag === "yes") {
                        status_item_drag();
                    }
                } else {
                    $("#status_drag_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Please_Select_One_Status"] + '</p></div>');
                }
            }
        });
    }

    /**
     * 拖拽状态事件绑定
     */
    function status_item_drag() {
        Sortable.create(Strack.get_obj_by_id('status_drag_list'), {
            animation: 150,
            forceFallback: true,
            onEnd: function (/**Event*/evt) {
                // 判断是否自动保存
                auto_save_status_data();
            }
        });
    }

    /**
     * 添加单个可拖拽状态
     * @param status_data
     */
    function add_single_drag_status(status_data) {
        $("#status_drag_list").prepend(drag_status_item_dom(status_data));
        status_item_drag();
    }

    /**
     * 拖拽状态设置项DOM
     * @param data
     * @returns {string}
     */
    function drag_status_item_dom(data) {
        var dom = '';
        dom += '<li class="text-no-select">' +
            '<div id="drag_status_item_' + data["id"] + '" class="drag-status-item" data-statusid="' + data["id"] + '">' +
            '<div class="overview-nav-handle aign-left">' +
            '<i class="icon-uniE6A1"></i>' +
            '</div>' +
            '<div class="overview-nav-icon aign-left">' +
            '<i class="' + data["icon"] + '" style="color:\#' + data["color"] + '"></i>' +
            '</div>' +
            '<div class="overview-nav-title aign-left">' +
            '<div class="nav-name text-ellipsis">' +
            data["name"] +
            '</div>' +
            '<div class="nav-description text-ellipsis">' +
            data["corresponds_lang"] +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';
        return dom;
    }


    /**
     * Status List DOM
     * @param data
     * @returns {string}
     */
    function status_list_dom(data) {
        var dom = '';
        var checked = data["checked"] === "yes" ? "icon-uniF068" : "icon-uniF067";
        dom += '<li class="nation-items">' +
            '<div class="nation-items-wrap middle">' +
            '<div class="aign-left">' +
            '<i class="' + data["icon"] + ' icon-left" style="color:\#' + data["color"] + '"></i>' +
            data["name"] +
            '</div>' ;

        if(param.rule_status_save === "yes"){
            dom += '<a href="javascript:;" onclick="obj.add_status_to_drag(this);" class="aign-right" data-statusid="' + data["id"] + '" data-checked="' + data["checked"] + '">' +
                '<i class="' + checked + '"></i>' +
                '</a>' ;
        }

        dom += '</div>' +
            '</li>';
        return dom;
    }

    /**
     * 添加状态
     */
    function add_status_dialog() {
        Strack.open_dialog('dialog', {
            title: StrackLang['Add_Status_Title'],
            width: 480,
            height: 400,
            content: Strack.dialog_dom({
                type: 'normal',
                hidden: [],
                items: [
                    {case: 1, id: 'Mstatus_name', type: 'text', lang: StrackLang['Name'], name: 'name', valid: '1,128', value: ''},
                    {case: 1, id: 'Mstatus_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: '1,128', value: ''},
                    {case: 2, id: 'Mstatus_color', lang: StrackLang['Color'], name: 'color', valid: '6,6'},
                    {case: 2, id: 'Mstatus_Icon', lang: StrackLang['Icon'], name: 'icon', valid: '1,24'},
                    {case: 2, id: 'Mstatus_Cponds', lang: StrackLang['Corresponds'], name: 'correspond', valid: '1'}
                ],
                footer: [
                    {obj: 'status_submit', type: 1, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.color_pick_widget('#Mstatus_color', 'hex', 'light', '', 320);

                Strack.combobox_widget('#Mstatus_Icon', {
                    url: StrackPHP["getIconList"],
                    valueField: 'icon',
                    textField: 'icon',
                    formatter: function (row) {
                        return '<div class="combo-icons-warp" style="overflow: hidden"><div class="combo-icons aign-left"><i class="' + row.icon + '"></i></div><div class="combo-name">' + row.icon + '</div></div>';
                    }
                });
                Strack.combobox_widget('#Mstatus_Cponds', {
                    url: StrackPHP["getStatusCorresponds"],
                    valueField: 'id',
                    textField: 'name'
                });

                $("#Mstatus_code").inputmask('alphaDash');
            },
            close: function () {

            }
        });
    }

    /**
     * 保存当前模块状态配置数据
     */
    function save_status_config_data() {
        var config = [];
        var status_id = 0;
        $(".drag-status-item").each(function () {
            status_id = $(this).attr("data-statusid");
            config.push(G_checked_status_data[status_id]);
        });
        G_status_param["new_status_config"] = config;
        $.ajax({
            type: 'POST',
            url: ProjectPHP['modifyModuleStatusConfig'],
            data: JSON.stringify(G_status_param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#status_config').prepend(Strack.loading_dom('white', '', 'status'));
            },
            success: function (data) {
                if (parseInt(data["status"]) === 200) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                } else {
                    Strack.top_message({bg: 'r', msg: data['message']});
                }
                $('#st-load_status').remove();
            }
        });
    }


    /**
     * 判断是否自动保存状态配置
     */
    function auto_save_status_data() {
        if (G_status_switch) {
            save_status_config_data();
        }
    }

    /**
     * 显示工序配置面板
     */
    function show_step_panel() {
        var $step = $("#step_config");
        if (!$step.hasClass("visible")) {
            $step.addClass("visible");
            $("#step_config_notice").hide();
            $step.find(".p-status-allow").show();
            $step.find(".p-status-now").show();
        }
    }

    /**
     * 获取当前选择模块工序设置
     */
    function get_module_step() {
        $.ajax({
            url: ProjectPHP['getProjectOverviewStepList'],
            type: 'POST',
            dataType: 'json',
            data: G_step_param,
            beforeSend: function () {
                G_step_data = {};
                $('#module_step_list').append(Strack.loading_dom('white', '', 'module_step'));
            },
            success: function (data) {
                var dom = '';
                data['step_list'].forEach(function (item) {
                    dom += step_list_dom(item);
                    G_step_data[item["id"]] = item;
                });

                if (dom.length > 0) {
                    $("#module_step_list").empty().append(dom);
                } else {
                    $("#module_step_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Datagird_No_Data"] + '</p></div>');
                }

                // 工序已经呗选中列表
                var drag_dom = '';
                data["step_checked"].forEach(function (val) {
                    G_checked_step_data[val["id"]] = val;
                    drag_dom += drag_step_item_dom(val);
                });
                if (drag_dom.length > 0) {
                    $("#step_drag_list").empty().append(drag_dom);
                    if(param.rule_step_drag === "yes"){
                        step_item_drag();
                    }
                } else {
                    $("#step_drag_list").empty().append('<div class="temp-setlist-no"><p>' + StrackLang["Please_Select_One_Step"] + '</p></div>');
                }
            }
        });
    }

    /**
     * Step List DOM
     * @param data
     * @returns {string}
     */
    function step_list_dom(data) {
        var dom = '';
        var checked = data["checked"] === "yes" ? "icon-uniF068" : "icon-uniF067";
        dom += '<li class="nation-items">' +
            '<div class="nation-items-wrap middle">' +
            '<div class="aign-left">' +
            '<span class="nation-items-label icon-left" style="background-color:\#' + data["color"] + '"></span>' +
            data["name"] +
            '</div>' ;

        if(param.rule_step_save === "yes"){
            dom +='<a href="javascript:;" onclick="obj.add_step_to_drag(this);" class="aign-right" data-stepid="' + data["id"] + '" data-checked="' + data["checked"] + '">' +
                '<i class="' + checked + '"></i>' +
                '</a>' ;
        }

        dom += '</div>' +
            '</li>';
        return dom;
    }

    /**
     * 添加单个可拖拽状态
     * @param step_data
     */
    function add_single_drag_step(step_data) {
        $("#step_drag_list").prepend(drag_step_item_dom(step_data));
        step_item_drag();
    }

    /**
     * 拖拽工序设置项DOM
     * @param data
     * @returns {string}
     */
    function drag_step_item_dom(data) {
        var dom = '';
        dom += '<li class="text-no-select">' +
            '<div id="drag_step_item_' + data["id"] + '" class="drag-step-item" data-stepid="' + data["id"] + '">' +
            '<div class="overview-nav-handle aign-left">' +
            '<i class="icon-uniE6A1"></i>' +
            '</div>' +
            '<div class="overview-nav-icon aign-left" style="background-color:\#' + data["color"] + '">' +
            '</div>' +
            '<div class="overview-nav-title aign-left">' +
            '<div class="nav-name text-ellipsis">' +
            data["name"] +
            '</div>' +
            '<div class="nav-description text-ellipsis">' +
            data["code"] +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';
        return dom;
    }

    /**
     * 拖拽工序事件绑定
     */
    function step_item_drag() {
        Sortable.create(Strack.get_obj_by_id('step_drag_list'), {
            animation: 150,
            forceFallback: true,
            onEnd: function (/**Event*/evt) {
                // 判断是否自动保存
                auto_save_step_data();
            }
        });
    }

    /**
     * 添加工序
     */
    function add_step_dialog() {
        Strack.open_dialog('dialog', {
            title: StrackLang['Add_Step_Title'],
            width: 480,
            height: 320,
            content: Strack.dialog_dom({
                type: 'normal',
                hidden: [],
                items: [
                    {
                        case: 1,
                        id: 'Mstep_name',
                        type: 'text',
                        lang: StrackLang['Name'],
                        name: 'name',
                        valid: "1,128",
                        value: ''
                    },
                    {case: 1, id: 'Mstep_code', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: ''},
                    {case: 2, id: 'Mstep_color', lang: StrackLang['Color'], name: 'color', valid: "6,6"}
                ],
                footer: [
                    {obj: 'step_submit', type: 1, title: StrackLang['Update']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.color_pick_widget('#Mstep_color', 'hex', 'light', '', 320);
                $("#Mstep_code").inputmask('alphaDash');
            },
            close: function () {

            }
        });
    }

    /**
     * 判断是否自动保存状态配置
     */
    function auto_save_step_data() {
        if (G_step_switch) {
            save_step_config_data();
        }
    }

    /**
     * 保存当前模块工序配置数据
     */
    function save_step_config_data() {
        var config = [];
        var step_id = 0;
        $(".drag-step-item").each(function () {
            step_id = $(this).attr("data-stepid");
            config.push(G_checked_step_data[step_id]);
        });
        G_step_param["new_step_config"] = config;
        $.ajax({
            type: 'POST',
            url: ProjectPHP['modifyModuleStepConfig'],
            data: JSON.stringify(G_step_param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#step_config').prepend(Strack.loading_dom('white', '', 'step'));
            },
            success: function (data) {
                if (parseInt(data["status"]) === 200) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                } else {
                    Strack.top_message({bg: 'r', msg: data['message']});
                }
                $('#st-load_step').remove();
            }
        });
    }

    /**
     * 初始化磁盘配置
     */
    function init_disk_panel() {

        $.ajax({
            type: 'POST',
            url: ProjectPHP['getProjectDiskConfig'],
            data: JSON.stringify(param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#overview_disk').prepend(Strack.loading_dom('white', '', 'disk'));
            },
            success: function (data) {
                // 初始化entity disk
                var $entity_disk_list = $("#entity_disk_list");
                var disabled = param.rule_disk_modify === "yes"? false: true;
                var default_disk_id = '';

                // 清空磁盘区域dom
                $entity_disk_list.empty();

                for(var key in data){
                    if(key === "default"){
                        default_disk_id = data[key]["id"];
                    }else {
                        $entity_disk_list.append(disk_item_dom(data[key]));
                        Strack.combobox_widget('#disk_'+data[key]['code'], {
                            url: StrackPHP["getDiskCombobox"],
                            prompt: StrackLang["Please_Select_Disk"],
                            valueField: 'id',
                            textField: 'name',
                            disabled: disabled,
                            value: data[key]['id'],
                            width: 300,
                            height: 30,
                            onSelect: function (record) {
                                data[key]["disk_id"] = param.disk_id;
                                update_project_disk(data[key], record);
                            }
                        });
                    }
                }

                Strack.combobox_widget('#disk_global_combobox', {
                    url: StrackPHP["getDiskCombobox"],
                    prompt: StrackLang["Please_Select_Disk"],
                    valueField: 'id',
                    textField: 'name',
                    disabled: disabled,
                    value: default_disk_id,
                    width: 300,
                    height: 30,
                    onSelect: function (record) {
                        update_project_disk({
                            disk_id: param.disk_id,
                            name: StrackLang["Default"],
                            code : 'default'
                        }, record);
                    }
                });

                obj.check_more_project_disk_notice();

                $('#st-load_disk').remove();
            }
        });
    }

    /**
     * 添加新的磁盘
     * @param val
     */
    function add_more_new_disk_item(val) {
        $("#entity_disk_list").prepend(disk_item_dom(val));
        Strack.combobox_widget('#disk_'+val['code'], {
            url: StrackPHP["getDiskCombobox"],
            prompt: StrackLang["Please_Select_Disk"],
            valueField: 'id',
            textField: 'name',
            value: val["id"],
            width: 300,
            height: 30,
            onSelect: function (record) {
                val["disk_id"] = param.disk_id;
                update_project_disk(val, record);
            }
        });
    }

    /**
     * 磁盘配置DOM
     * @returns {string}
     */
    function disk_item_dom(data) {
        var dom = '';
        var id = 'disk_'+data['code'];
        dom += '<div id="item_'+id+'" class="ui grid disk-setting-item">'+
            '<div class="two column row">'+
            '<div class="five wide column">'+
            '<a href="javascript:;" class="delete-bnt" onclick="obj.delete_more_project_disk(this)" data-code="'+data['code']+'">' +
            '<i class="icon-uniE6DB"></i>'+
            '</a>'+
            '<span class="title">'+
            data['name']+
            '</span>'+
            '</div>'+
            '<div class="eleven wide column combobox">'+
            '<input id="'+id+'" autocomplete="off"/>'+
            '</div>'+
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 更新项目磁盘设置
     */
    function update_project_disk(param, data) {
        $.ajax({
            type : 'POST',
            url : ProjectPHP['modifyProjectDisk'],
            data : JSON.stringify({
                param : param,
                data : data
            }),
            dataType: 'json',
            contentType: "application/json",
            beforeSend : function () {
                $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
            },
            success : function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    }

    /**
     * 修改url地址
     * @param scene
     * @param url_tag
     */
    function modify_url_address(scene, url_tag) {
        var base_url = param.project_id+'.html';
        if(url_tag){
            base_url +='?'+url_tag;
        }
        history.replaceState(null, scene, base_url);
    }
});