$(function () {
    obj = {
        // 初始化详情页面面板操作
        show_details_tab_page: function (tab_param) {
            switch_tab_page(tab_param);
        },
        // 修改tab配置刷新
        refresh_details_tab: function (config) {
            // 获取当前激活的tab
            var $ac_tab = $("#details_tab .tab_item.active");
            var tab_id = $ac_tab.attr("data-tabid");
            var first_tab = {};
            config.forEach(function (val) {
                if (!first_tab) {
                    first_tab = val;
                }
                if (val["tab_id"] === tab_id) {
                    first_tab = val;
                }
            });
            Strack.generate_tab_list("details_tab", param, config);
            switch_tab_page(first_tab);
        },
        // 添加固定表格类型数据
        create_single_grid_data: function (i) {
            var lang = $(i).data("lang");
            Strack.item_operate_dialog(lang,
                {
                    mode: "create",
                    field_list_type: ['edit'],
                    from_item_id: param["item_id"],
                    from_module_id: param["module_id"],
                    module_id: single_grid_param["module_id"],
                    project_id: param["project_id"],
                    page: single_grid_param["page"],
                    schema_page: single_grid_param["schema_page"],
                    type: "add_panel"
                },
                function () {
                    obj.reset_single_grid_data();
                }
            );
        },
        // 修改固定表格类型数据
        modify_single_grid_data: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#single_main_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type: ['edit'],
                        from_item_id: param["item_id"],
                        from_module_id: param["module_id"],
                        module_id: single_grid_param["module_id"],
                        project_id: param["project_id"],
                        page: single_grid_param["page"],
                        schema_page: single_grid_param["schema_page"],
                        type: "update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.reset_single_grid_data();
                    }
                );
            });
        },
        // 删除固定表格类型数据
        delete_single_grid_data: function (i) {
            var code = $(i).attr("data-code");
            var lang = 'Delete_' + Strack.string_ucwords(code) + '_Notice';
            Strack.ajax_grid_delete('single_main_datagrid_box', 'id', StrackLang[lang], StrackPHP['deleteGridData'], single_grid_param);
        },
        // 重置固定表格类型数据表格
        reset_single_grid_data: function () {
            $('#single_main_datagrid_box').datagrid('reload');
        },
        // 添加entity类型数据表格数据
        create_entity_grid_data: function (i) {
            var lang = $(i).data("lang");
            Strack.item_operate_dialog(lang,
                {
                    mode: "create",
                    field_list_type: ['edit'],
                    module_id: entity_grid_param["module_id"],
                    project_id: param["project_id"],
                    page: entity_grid_param["page"],
                    schema_page: entity_grid_param["schema_page"],
                    type: "add_panel"
                },
                function () {
                    obj.reset_entity_grid_data();
                }
            );
        },
        // 修改entity类型数据
        modify_entity_grid_data: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type: ['edit'],
                        module_id: entity_grid_param["module_id"],
                        project_id: param["project_id"],
                        page: entity_grid_param["page"],
                        schema_page: entity_grid_param["schema_page"],
                        type: "update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.reset_entity_grid_data();
                    }
                );
            });
        },
        // 删除entity类型数据
        delete_entity_grid_data: function (i) {
            var code = $(i).attr("data-code");
            var lang = 'Delete_' + Strack.string_ucwords(code) + '_Notice';
            Strack.ajax_grid_delete('main_datagrid_box', 'id', StrackLang[lang], StrackPHP['deleteGridData'], entity_grid_param);
        },
        // 重置entity类型数据表格
        reset_entity_grid_data: function () {
            $('#main_datagrid_box').datagrid('reload');
        },
        // 保存添加关联Onset
        add_link_onset: function (i) {
            var formData = Strack.validate_form('add_link_onset');
            if(parseInt(formData['status']) === 200){
                add_link_onset(formData["data"]);
            }
        }
    };

    // 读取页面参数
    var param = Strack.generate_hidden_param();

    // 全局变量
    var single_grid_param = {},
        entity_grid_param = {},
        onset_info_param = {},
        onset_param = {};

    init_details_panel();

    /**
     * 初始化详情页面
     */
    function init_details_panel() {

        // 加载顶部缩略图
        load_top_thumb();

        // 加载顶部信息
        load_top_info();

        //动态生成面包屑导航
        Strack.init_breadcrumb("item_breadcrumb", param, function (dom) {
            $("#hidebar_breadcrumb").html(dom);
        });

        //动态生成Tabs
        param["position"] = "details";
        Strack.init_tab_list("details_tab", param, function (data) {
            assembly_panel(data);
        });
    }

    /**
     * 组装页面
     * @param data
     */
    function assembly_panel(data) {
        var tab_dict = {};
        var first_tab = null;
        data.forEach(function (val) {
            tab_dict[val["tab_id"]] = val;
            if (!first_tab) {
                first_tab = val["tab_id"];
            }
        });

        // 判断是否存在url锚点以及它是否在允许tab里面
        var use_tab;
        if (param["url_tab"] && tab_dict[param["url_tab"]]) {
            use_tab = tab_dict[param["url_tab"]];
        } else {
            use_tab = tab_dict[first_tab];
        }

        if (use_tab) {
            // 存在tab
            switch_tab_page(use_tab);
        }
    }

    /**
     * 获取顶部数据
     */
    function load_top_thumb() {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getDetailTopThumb'],
            data: param,
            dataType: 'json',
            beforeSend: function () {
                $('.item-thumb-warp').prepend(Strack.loading_dom('white', '', 'thumb'));
            },
            success: function (data) {
                var media_data = data['data'];
                media_data['link_id'] = param["item_id"];
                media_data['module_id'] = param["module_id"];
                media_data['param']['icon'] = "icon-uniE61A";
                Strack.thumb_media_widget('#details_thumb', media_data, {modify_thumb:param.rule_thumb_modify, clear_thumb:param.rule_thumb_clear});
                init_hide_bar_thumb(media_data);
                $('#st-load_thumb').remove();
            }
        });
    }

    /**
     * 填充隐藏信息栏图片
     * @param media_data
     */
    function init_hide_bar_thumb(media_data) {
        var thumb = media_data.has_media === "yes" ? "" : "";
        //填充缩略图
        $('#hidebar_thumb').empty().append(Strack.build_thumb_dom(thumb, media_data.param.icon));
    }

    /**
     * 获取详情页面顶部数据
     */
    function load_top_info() {
        Strack.G.topfieldsRequestParam = {
            id: "#details_top_info",
            mask: 'top_info',
            pos: 'min',
            url: StrackPHP["getModuleItemInfo"],
            data: {
                item_id: param["item_id"],
                category : "top_field",
                schema_page : "project_"+param["module_code"],
                project_id : param["project_id"],
                module_id : param["module_id"],
                module_code : param["module_code"],
                module_type : param["module_type"],
                template_id : param["template_id"]
            },
            loading_type: 'white'
        };

        Strack.load_info_panel(Strack.G.topfieldsRequestParam,
            function (data) {

            if(param.rule_prev_next_one === "yes"){
                init_prev_and_next_bnt(param, data["prev_and_next"]);
            }

            if(parseInt(param.module_id) === 4 && param.rule_is_my_task === "yes" && param.rule_timelog === "yes"){
                Strack.init_timelog_bnt("#top_timelog_bnt", data["timelog"]);
            }

        });
    }

    /**
     * 详情页面顶部上一个和下一个按钮
     * @param info_param
     * @param data
     */
    function init_prev_and_next_bnt(info_param, data) {
        var dom = '';
        var base_url = Strack.remove_html_ext(StrackPHP["details"]);
        var prev_url = data["prev"] > 0 ? base_url + '/' + info_param["module_id"] + '-' + info_param["project_id"] + '-' + data["prev"] + '.html' : "javascript:;";
        var next_url = data["next"] > 0 ? base_url + '/' + info_param["module_id"] + '-' + info_param["project_id"] + '-' + data["next"] + '.html' : "javascript:;";
        dom += '<a href="' + prev_url + '" class="ui labeled icon button"><i class="left chevron icon"></i> ' + StrackLang["Prev_One"] + '</a>' +
            '<a href="' + next_url + '" class="ui right labeled icon button">' + StrackLang["Next_One"] + ' <i class="right chevron icon"></i></a>';
        $("#prev_next_bnt").html(dom);
    }

    /**
     * 初始化动作列表
     * @param data
     */
    function init_action_list(data) {
        var dom = '';
        data.forEach(function (val) {
            val["grid"] = '';
            val["link_id"] = param["item_id"];
            dom += Strack.common_action_dom('details', val);
        });

        $("#top_action_list").html(dom);
    }

    /**
     * 初始化详情页面面板操作
     * @param tab_param
     */
    function switch_tab_page(tab_param) {
        Strack.active_select_tab("details_tab", tab_param.tab_id);
        $(".details-page-main .pitem-wrap").hide();
        var $single_grid_page = $("#tab_single_grid");

        // 增加页面锚点
        modify_url_address("details", 'tab=' + tab_param.type + '-' + tab_param.tab_id);

        // 切换初始化对应页面
        var authority_rules = {};
        var $tab_page;

        switch (tab_param.type) {
            case "fixed":
                $tab_page = $("#tab_" + tab_param.tab_id);
                switch (tab_param.tab_id) {
                    case "base":
                        // 实体任务管理
                        $single_grid_page.show();
                        authority_rules = {
                            filter: {
                                show : param.rule_base_panel_filter,
                                edit : param.rule_base_modify_filter
                            },
                            sort : param.rule_base_sort,
                            group : param.rule_base_group
                        };

                        // 调整数据表格显示
                        show_or_hide_single_grid({
                            create : param.rule_base_create,
                            modify : param.rule_base_modify,
                            import_excel : param.rule_base_import_excel,
                            export_excel : param.rule_base_export_excel,
                            action : param.rule_base_action,
                            delete : param.rule_base_delete,
                            modify_thumb : param.rule_base_modify_thumb,
                            clear_thumb : param.rule_base_clear_thumb,
                            sort : param.rule_base_sort,
                            group : param.rule_base_group,
                            manage_custom_fields : param.rule_base_manage_custom_fields,
                            save_view : param.rule_base_save_view,
                            save_as_view : param.rule_base_save_as_view,
                            modify_view : param.rule_base_modify_view,
                            delete_view : param.rule_base_delete_view,
                            panel_filter : param.rule_base_panel_filter
                        });

                        tab_param["rule_side_thumb_modify"] = param["rule_base_modify_thumb"];
                        tab_param["rule_side_thumb_clear"] = param["rule_base_clear_thumb"];

                        load_correlation_base_grid_data(tab_param, [
                            {
                                field: 'id',
                                value: param.item_id,
                                condition: 'NEQ',
                                module_code: tab_param.module_code,
                                table: 'Base'
                            }
                        ], authority_rules);
                        break;
                    case "note":
                        // 动态页面
                        $tab_page.show();
                        init_note_panel();
                        break;
                    case "info":
                        // 详细信息页面
                        $tab_page.show();
                        load_info_panel();
                        break;
                    case "onset":
                        // 现场数据页面
                        $tab_page.show();
                        load_onset_panel();
                        break;
                    case "file":
                        // 文件管理页面
                        $single_grid_page.show();
                        authority_rules = {
                            filter: {
                                show : param.rule_file_panel_filter,
                                edit : param.rule_file_modify_filter
                            },
                            sort : param.rule_file_sort,
                            group : param.rule_file_group
                        };

                        // 调整数据表格显示
                        show_or_hide_single_grid({
                            create : param.rule_file_create,
                            modify : param.rule_file_modify,
                            import_excel : param.rule_file_import_excel,
                            export_excel : param.rule_file_export_excel,
                            action : param.rule_file_action,
                            delete : param.rule_file_delete,
                            modify_thumb : param.rule_file_modify_thumb,
                            clear_thumb : param.rule_file_clear_thumb,
                            sort : param.rule_file_sort,
                            group : param.rule_file_group,
                            manage_custom_fields : param.rule_file_manage_custom_fields,
                            save_view : param.rule_file_save_view,
                            save_as_view : param.rule_file_save_as_view,
                            modify_view : param.rule_file_modify_view,
                            delete_view : param.rule_file_delete_view,
                            panel_filter : param.rule_file_panel_filter
                        });

                        load_correlation_base_grid_data(tab_param, [
                            {
                                field: 'module_id',
                                value: param.module_id,
                                condition: 'EQ',
                                module_code: tab_param.tab_id,
                                table: 'File'
                            },
                            {
                                field: 'link_id',
                                value: param.item_id,
                                condition: 'EQ',
                                module_code: tab_param.tab_id,
                                table: 'File'
                            }
                        ], authority_rules);
                        break;
                    case "file_commit":
                        // 文件提交批次管理页面
                        $single_grid_page.show();
                        authority_rules = {
                            filter: {
                                show : param.rule_file_commit_panel_filter,
                                edit : param.rule_file_commit_modify_filter
                            },
                            sort : param.rule_file_commit_sort,
                            group : param.rule_file_commit_group
                        };

                        // 调整数据表格显示
                        show_or_hide_single_grid({
                            create : param.rule_file_commit_create,
                            modify : param.rule_file_commit_modify,
                            import_excel : param.rule_file_commit_import_excel,
                            export_excel : param.rule_file_commit_export_excel,
                            action : param.rule_file_commit_action,
                            delete : param.rule_file_commit_delete,
                            modify_thumb : param.rule_file_commit_modify_thumb,
                            clear_thumb : param.rule_file_commit_clear_thumb,
                            sort : param.rule_file_commit_sort,
                            group : param.rule_file_commit_group,
                            manage_custom_fields : param.rule_file_commit_manage_custom_fields,
                            save_view : param.rule_file_commit_save_view,
                            save_as_view : param.rule_file_commit_save_as_view,
                            modify_view : param.rule_file_commit_modify_view,
                            delete_view : param.rule_file_commit_delete_view,
                            panel_filter : param.rule_file_commit_panel_filter
                        });

                        load_correlation_base_grid_data(tab_param, [
                            {
                                field: 'module_id',
                                value: param.module_id,
                                condition: 'EQ',
                                module_code: tab_param.tab_id,
                                table: 'File'
                            },
                            {
                                field: 'link_id',
                                value: param.item_id,
                                condition: 'EQ',
                                module_code: tab_param.tab_id,
                                table: 'File'
                            }
                        ], authority_rules);
                        break;
                    case "reference":
                        // 参考文件页面
                        $tab_page.show();
                        break;
                    case "history":
                        // 历史记录页面
                        $tab_page.show();
                        load_history_grid_data();
                        break;
                    case "correlation_base":
                        $single_grid_page.show();
                        authority_rules = {
                            filter: {
                                show : param.rule_correlation_task_panel_filter,
                                edit : param.rule_correlation_task_modify_filter
                            },
                            sort : param.rule_correlation_task_sort,
                            group : param.rule_correlation_task_group
                        };

                        // 调整数据表格显示
                        show_or_hide_single_grid({
                            create : param.rule_correlation_task_create,
                            modify : param.rule_correlation_task_modify,
                            import_excel : param.rule_correlation_task_import_excel,
                            export_excel : param.rule_correlation_task_export_excel,
                            action : param.rule_correlation_task_action,
                            delete : param.rule_correlation_task_delete,
                            modify_thumb : param.rule_correlation_task_modify_thumb,
                            clear_thumb : param.rule_correlation_task_clear_thumb,
                            sort : param.rule_correlation_task_sort,
                            group : param.rule_correlation_task_group,
                            manage_custom_fields : param.rule_correlation_task_manage_custom_fields,
                            save_view : param.rule_correlation_task_save_view,
                            save_as_view : param.rule_correlation_task_save_as_view,
                            modify_view : param.rule_correlation_task_modify_view,
                            delete_view : param.rule_correlation_task_delete_view,
                            panel_filter : param.rule_correlation_task_panel_filter
                        });

                        tab_param["rule_side_thumb_modify"] = param["rule_correlation_task_modify_thumb"];
                        tab_param["rule_side_thumb_clear"] = param["rule_correlation_task_clear_thumb"];

                        load_correlation_base_grid_data(tab_param, [
                            {
                                field: 'id',
                                value: param.item_id,
                                condition: 'NEQ',
                                module_code: param.module_code,
                                table: 'Base'
                            },
                            {
                                field: 'entity_id',
                                value: param.entity_id,
                                condition: 'EQ',
                                module_code: param.module_code,
                                table: 'Base'
                            }
                        ], authority_rules);
                        break;
                }
                break;
            case "horizontal_relationship":
            case "be_horizontal_relationship":
                authority_rules = {
                    filter: {
                        show : param.rule_horizontal_relationship_panel_filter,
                        edit : param.rule_horizontal_relationship_modify_filter
                    },
                    sort : param.rule_horizontal_relationship_sort,
                    group : param.rule_horizontal_relationship_group
                };

                tab_param["src_module_id"] = tab_param["module_id"];
                var horizontal_param = Strack.deep_copy(tab_param);
                horizontal_param["module_id"] = tab_param["dst_module_id"];
                horizontal_param["module_code"] = tab_param["dst_module_code"];

                switch (tab_param["horizontal_type"]) {
                    case "fixed":
                        // 调整数据表格显示

                        if(tab_param.type === "be_horizontal_relationship"){
                            show_or_hide_single_grid({
                                create : 'no',
                                modify : 'no',
                                import_excel : 'no',
                                export_excel : 'no',
                                action : 'no',
                                delete : 'no',
                                modify_thumb : 'no',
                                clear_thumb : 'no',
                                sort : 'no',
                                group : 'no',
                                manage_custom_fields : 'no',
                                save_view : 'no',
                                save_as_view : 'no',
                                modify_view : 'no',
                                delete_view : 'no',
                                panel_filter : 'no'
                            });
                        }else {

                        }


                        horizontal_param["rule_side_thumb_modify"] = param["rule_horizontal_relationship_modify_thumb"];
                        horizontal_param["rule_side_thumb_clear"] = param["rule_horizontal_relationship_clear_thumb"];

                        set_horizontal_relationship_bnt_param("single", horizontal_param, tab_param.type);

                        $single_grid_page.show();
                        load_correlation_base_grid_data(horizontal_param, [], authority_rules);
                        break;
                    case "entity":
                        set_horizontal_relationship_bnt_param("entity", horizontal_param, tab_param.type);
                        $("#tab_entity_grid").show();
                        load_horizontal_relationship_grid_data(horizontal_param, authority_rules);
                        break;
                }
                break;
            case "entity_child":
                authority_rules = {
                    filter: {
                        show : param.rule_entity_child_panel_filter,
                        edit : param.rule_entity_child_modify_filter
                    },
                    sort : param.rule_entity_child_sort,
                    group : param.rule_entity_child_group
                };

                var entity_child_param = Strack.deep_copy(tab_param);
                set_horizontal_relationship_bnt_param("entity", entity_child_param, tab_param.type);
                $("#tab_entity_grid").show();

                load_horizontal_relationship_grid_data(entity_child_param, authority_rules);
                break;
            case "other_page":
                $tab_page = $("#tab_iframe_page");
                $tab_page.show();
                break;
        }
    }

    /**
     * 设置创建水平关联按钮参数
     * @param pos
     * @param tab_param
     * @param horizontal_type
     */
    function set_horizontal_relationship_bnt_param(pos, tab_param, horizontal_type) {
        if(horizontal_type === "be_horizontal_relationship"){
            $("#single_grid_create_bnt").hide();
            $("#entity_create_horizontal_bnt").hide();
            $("#single_grid_create_horizontal").hide();
        }else {
            if(pos === "entity"){
                $("#entity_create_horizontal_bnt").show().attr("srcmoduleid", tab_param["src_module_id"])
                    .attr("dstmoduleid", tab_param["dst_module_id"])
                    .attr("dstmodulecode", tab_param["dst_module_code"])
                    .attr("variableid", tab_param["variable_id"])
                    .attr("horizontaltype", horizontal_type)
                    .attr("srclinkid", param["item_id"]);
            }else {
                $("#single_grid_create_bnt").hide();
                $("#single_create_horizontal_bnt").attr("srcmoduleid", tab_param["src_module_id"])
                    .attr("dstmoduleid", tab_param["dst_module_id"])
                    .attr("dstmodulecode", tab_param["dst_module_code"])
                    .attr("variableid", tab_param["variable_id"])
                    .attr("horizontaltype", horizontal_type)
                    .attr("srclinkid", param["item_id"]);
                $("#single_grid_create_horizontal").show();
            }
        }
    }

    /**
     * history datagrid 加载
     */
    function load_history_grid_data() {
        var $tab_history = $('#tab_history');
        var $history_datagrid = $('#history_datagrid');
        if ($tab_history.hasClass("load_active")) {
            // 重置刷新
            $history_datagrid.datagrid("reload");
        } else {
            // 第一次加载实例化
            $tab_history.addClass("load_active");
            $history_datagrid.datagrid({
                url: StrackPHP['getModuleItemHistory'],
                height: Strack.panel_height('.task-history-wrap', 0),
                singleSelect: true,
                fitColumns: false,
                adaptive: {
                    dom: '.task-history-wrap',
                    min_width: 510,
                    exth: 0
                },
                queryParams: param,
                frozenColumns: [[
                    {field: 'event_log_id', checkbox: true}
                ]],
                columns: [[
                    {
                        field: 'id', title: StrackLang['ID'], align: 'center', width: 120, frozen: "frozen", findex: 0,
                        formatter: function (value, row, index) {
                            return row["id"];
                        }
                    },
                    {
                        field: 'operate',
                        title: StrackLang['Operate'],
                        align: 'center',
                        width: 120,
                        frozen: "frozen",
                        findex: 1
                    },
                    {
                        field: 'type',
                        title: StrackLang["Type"],
                        align: 'center',
                        width: 180,
                        frozen: "frozen",
                        findex: 2
                    },
                    {
                        field: 'record',
                        title: StrackLang["Record"],
                        align: 'center',
                        width: 600,
                        frozen: "frozen",
                        findex: 3,
                        formatter: function (value, row, index) {
                            return JSON.stringify(value);
                        }
                    },
                    {
                        field: 'from',
                        title: StrackLang["From"],
                        align: 'center',
                        width: 120,
                        frozen: "frozen",
                        findex: 4
                    },
                    {
                        field: 'created_by',
                        title: StrackLang["Created_by"],
                        align: 'center',
                        width: 160,
                        frozen: "frozen",
                        findex: 5
                    },
                    {
                        field: 'created',
                        title: StrackLang["Created"],
                        align: 'center',
                        width: 180,
                        frozen: "frozen",
                        findex: 6
                    }
                ]],
                pagination: true,
                pageSize: 100,
                pageList: [100, 300, 500],
                pageNumber: 1,
                pagePosition: 'bottom',
                remoteSort: false
            });
        }
    }

    /**
     * 重置数据表格dom数据参数
     * @param ids
     * @param grid_param
     */
    function reset_datagrid_dom_param(ids, grid_param) {
        var $dg = $(ids.dg_id);
        var $filter = $(ids.filter_id);
        var $delete = $(ids.delete_id);

        // 设置数据表格工具栏数据
        $dg.find(".proj-tb")
            .attr("data-page", grid_param["page"])
            .attr("data-schemapage", grid_param["schema_page"])
            .attr("data-moduleid", grid_param["module_id"]);

        $filter.attr("data-page", grid_param["page"])
            .attr("data-schemapage", grid_param["schema_page"])
            .attr("data-moduleid", grid_param["module_id"]);

        // 删除按钮code
        $delete.attr("data-code", grid_param["module_code"]);

        // 设置数据表格添加按钮参数
        $dg.find(".create-bnt")
            .attr("data-lang", grid_param["lang"])
            .find(".stp-title")
            .html(grid_param["lang"]);

        // 设置动作配置面板参数
        $dg.find(".all-action-slider")
            .attr("data-moduleid", grid_param["module_id"]);

        // 设置缩略图操作参数
        $dg.find(".modify-thumb-bnt")
            .attr("data-moduleid", grid_param["module_id"]);
        $dg.find(".clear-thumb-bnt")
            .attr("data-moduleid", grid_param["module_id"]);

        // 设置过滤面板操作参数
        $dg.find(".datagrid-filter")
            .attr("data-page", grid_param["page"])
            .attr("data-schemapage", grid_param["schema_page"])
            .attr("data-moduleid", grid_param["module_id"]);

    }

    /**
     * 调整单个表格显示
     * @param param
     */
    function show_or_hide_single_grid(param) {

        $("#single_grid_create_horizontal").hide();

        if(param.create === "yes"){
            $("#single_grid_create_bnt").show();
        }else {
            $("#single_grid_create_bnt").hide();
        }

        if(param.modify === "yes"){
            $(".single_grid_modify_bnt").show();
        }else {
            $(".single_grid_modify_bnt").hide();
        }

        if(param.import_excel === "yes"){
            $("#single_grid_import_excel_bnt").show();
        }else {
            $("#single_grid_import_excel_bnt").hide();
        }

        if(param.export_excel === "yes"){
            $("#single_grid_export_excel_bnt").show();
        }else {
            $("#single_grid_export_excel_bnt").hide();
        }


        if(param.action === "yes"){
            $(".single_grid_action_bnt").show();
        }else {
            $(".single_grid_action_bnt").hide();
        }

        if(param.delete === "yes"){
            $(".single_grid_delete_bnt").show();
        }else {
            $(".single_grid_delete_bnt").hide();
        }

        if(param.modify_thumb === "yes"){
            $("#single_grid_modify_thumb_bnt").show();
        }else {
            $("#single_grid_modify_thumb_bnt").hide();
        }

        if(param.clear_thumb === "yes"){
            $("#single_grid_clear_thumb_bnt").show();
        }else {
            $("#single_grid_clear_thumb_bnt").hide();
        }

        if(param.sort === "yes"){
            $("#single_grid_sort_bnt").show();
        }else {
            $("#single_grid_sort_bnt").hide();
        }

        if(param.group === "yes"){
            $("#single_grid_group_bnt").show();
        }else {
            $("#single_grid_group_bnt").hide();
        }

        if(param.manage_custom_fields === "yes"){
            $("#single_grid_manage_custom_fields_bnt").show();
        }else {
            $("#single_grid_manage_custom_fields_bnt").hide();
        }

        if(param.save_view === "yes"){
            $("#single_grid_save_view_bnt").show();
        }else {
            $("#single_grid_save_view_bnt").hide();
        }

        if(param.save_as_view === "yes"){
            $("#single_grid_save_as_view_bnt").show();
        }else {
            $("#single_grid_save_as_view_bnt").hide();
        }

        if(param.modify_view === "yes"){
            $("#single_grid_modify_view_bnt").show();
        }else {
            $("#single_grid_modify_view_bnt").hide();
        }

        if(param.delete_view === "yes"){
            $("#single_grid_delete_view_bnt").show();
        }else {
            $("#single_grid_delete_view_bnt").hide();
        }

        if(param.panel_filter === "yes"){
            $(".single_filter_main").css("width", 200).show();
        }else {
            $(".single_filter_main").css("width", 0).hide();
        }
    }

    /**
     * 加载任务类型属于同父级任务列表数据 datagrid 加载
     * @param tab_param
     * @param request_filter
     * @param authority_rules
     */
    function load_correlation_base_grid_data(tab_param, request_filter, authority_rules) {
        var page = 'details_' + tab_param.tab_id;
        var c_request_filter = request_filter ? request_filter : [];
        var is_horizontal_relationship = tab_param["type"] === "horizontal_relationship" ? "yes" : "no";

        var schema_page = Strack.generate_schema_page(tab_param["module_code"]);

        single_grid_param = {
            page: page,
            lang: tab_param["name"],
            schema_page: schema_page,
            module_id: tab_param["module_id"],
            module_type: tab_param["module_type"],
            module_code:  tab_param["module_code"],
            template_id:  param["template_id"],
            project_id: param["project_id"],
            from_item_id: param["item_id"],
            from_module_id: param["module_id"],
            rule_tab_notes: param["rule_tab_notes"],
            rule_tab_info: param["rule_tab_info"],
            rule_tab_history: param["rule_tab_history"],
            rule_tab_onset: param["rule_tab_onset"],
            rule_tab_base: param["rule_tab_base"],
            rule_tab_file: param["rule_tab_file"],
            rule_tab_file_commit: param["rule_tab_file_commit"],
            rule_tab_horizontal_relationship: param["rule_tab_horizontal_relationship"],
            rule_tab_correlation_task: param["rule_tab_correlation_task"],
            rule_tab_cloud_disk: param["rule_tab_cloud_disk"],
            rule_template_fixed_tab: param["rule_template_fixed_tab"],
            rule_side_thumb_modify: tab_param["rule_side_thumb_modify"],
            rule_side_thumb_clear: tab_param["rule_side_thumb_clear"]
        };

        reset_datagrid_dom_param({
            dg_id :"#single_datagrid_main",
            filter_id: "#single_filter_main",
            delete_id: "#single_grid_delete_item_bnt"
        }, single_grid_param);

        Strack.load_grid_columns('#tab_single_grid', {
            loading_id: "#tab_single_grid",
            page: page,
            schema_page: schema_page,
            module_id: tab_param["module_id"],
            is_horizontal_relationship: is_horizontal_relationship,
            project_id: param["project_id"],
            grid_id: 'single_main_datagrid_box',
            view_type: "grid",
            temp_fields: {
                add: {},
                cut: {}
            }
        }, function (data) {
            var $tab_single_grid = $("#tab_single_grid");
            var $single_datagrid = $('#single_main_datagrid_box');
            var gird_param = {};

            //过滤条件
            var filter_data = {
                filter: {
                    temp_fields: {
                        add: {},
                        cut: {}
                    },
                    group: data['grid']["group_name"],
                    sort: data['grid']["sort_config"]["sort_query"],
                    request: c_request_filter,
                    filter_input: data['grid']["filter_config"]["filter_input"],
                    filter_panel: data['grid']["filter_config"]["filter_panel"],
                    filter_advance: data['grid']["filter_config"]["filter_advance"]
                },
                page: page,
                schema_page: schema_page,
                module_id: tab_param["module_id"],
                project_id: param["project_id"],
                item_id: param["item_id"],
                module_code: tab_param["tab_id"],
                module_type: tab_param["type"],
                horizontal_type: tab_param["horizontal_type"],
                parent_module_id: param["module_id"]
            };

            if ($tab_single_grid.hasClass("load_active")) {

                // datagrid 配置参数
                gird_param = {
                    moduleId: tab_param['module_id'],
                    projectId: param['project_id'],
                    queryParams: {
                        filter_data: JSON.stringify(filter_data)
                    },
                    panelConfig: {
                        active_filter_id: data['grid']["filter_config"]["filter_id"]
                    },
                    sortConfig: data['grid']["sort_config"],
                    sortData: data['grid']["sort_config"]["sort_data"],
                    renderNewPage: true,
                    toolbarConfig: {
                        id: 'single_datagrid_main',
                        page: page,
                        sortAllow: true,
                        groupAllow: true,
                        fieldAllow: true,
                        viewAllow: true,
                        actionAllow: true
                    },
                    searchConfig: {
                        id: 'single_grid_search',
                        bar_show: data['grid']["filter_bar_show"],
                        filterBar: {
                            main_dom: 'single_datagrid_main',
                            bar_dom: 'single_filter_main'
                        }
                    },
                    filterConfig: {
                        id: 'single_filter_main',
                        schema_page: schema_page,
                        barParam: {}
                    },
                    authorityRules: authority_rules,
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    onDblClickRow: function (index, row) {
                        single_grid_param["item_id"] = row["id"];
                        if(single_grid_param["module_type"] === "entity" || $.inArray(single_grid_param["module_code"], ["base", "correlation_base"]) >= 0){
                            Strack.open_datagrid_slider(single_grid_param);
                        }
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

                // 重置 datagrid 数据
                $single_datagrid.datagrid("setOptions", gird_param)
                    .datagrid('reload');

            } else {
                // 第一次加载初始化
                $tab_single_grid.addClass("load_active");

                // datagrid 配置参数
                gird_param = {
                    url: StrackPHP['getDetailGridData'],
                    height: Strack.panel_height("#single_datagrid_main", 0),
                    view: scrollview,
                    rowheight: 50,
                    differhigh: false,
                    singleSelect: false,
                    adaptive: {
                        dom: "#single_datagrid_main",
                        min_width: 680,
                        exth: 0,
                        domresize: 1
                    },
                    ctrlSelect: true,
                    multiSort: true,
                    DragSelect: true,
                    queryParams: {
                        filter_data: JSON.stringify(filter_data)
                    },
                    panelConfig: {
                        active_filter_id: data['grid']["filter_config"]["filter_id"]
                    },
                    sortConfig: data['grid']["sort_config"],
                    sortData: data['grid']["sort_config"]["sort_data"],
                    moduleId: tab_param['module_id'],
                    projectId: param['project_id'],
                    toolbarConfig: {
                        id: 'single_datagrid_main',
                        page: page,
                        sortAllow: true,
                        groupAllow: true,
                        fieldAllow: true,
                        viewAllow: true,
                        actionAllow: true
                    },
                    searchConfig: {
                        id: 'single_grid_search',
                        bar_show: data['grid']["filter_bar_show"],
                        filterBar: {
                            main_dom: 'single_datagrid_main',
                            bar_dom: 'single_filter_main'
                        }
                    },
                    filterConfig: {
                        id: 'single_filter_main',
                        schema_page: schema_page,
                        barParam: {}
                    },
                    authorityRules: authority_rules,
                    contextMenuData: {
                        id: 'st_menu_single',
                        copy_id: 'ac_copy_cell',
                        edit_id: '#single_datagrid_main .edit-menu',
                        data: []
                    },
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    toolbar: '#single_tb_grid',
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 200,
                    pageList: [100, 200, 300, 400, 500],
                    pagePosition: 'bottom',
                    remoteSort: false,
                    onDblClickRow: function (index, row) {
                        single_grid_param["item_id"] = row["id"];
                        if(single_grid_param["module_type"] === "entity" || $.inArray(single_grid_param["module_code"], ["base", "correlation_base"]) >= 0){
                            Strack.open_datagrid_slider(single_grid_param);
                        }
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

                $single_datagrid.datagrid(gird_param)
                    .datagrid('enableCellEditing')
                    .datagrid('disableCellSelecting')
                    .datagrid('gotoCell',
                        {
                            index: 0,
                            field: 'id'
                        }
                    ).datagrid('columnMoving');
            }
        });
    }

    /**
     * 加载水平关联数据表格
     * @param tab_param
     * @param authority_rules
     */
    function load_horizontal_relationship_grid_data(tab_param, authority_rules) {
        var page = 'details_' + tab_param.tab_id;
        var is_horizontal_relationship = tab_param["type"] === "horizontal_relationship" ? "yes" : "no";

        var schema_page = Strack.generate_schema_page(tab_param["module_code"]);

        entity_grid_param = {
            page: page,
            lang: tab_param["name"],
            schema_page: schema_page,
            module_id: tab_param["dst_module_id"],
            module_type: tab_param["module_type"],
            module_code:  tab_param["module_code"],
            template_id:  param["template_id"],
            project_id: param["project_id"],
            from_item_id: param["item_id"],
            from_module_id: param["module_id"],
            rule_tab_notes: param["rule_tab_notes"],
            rule_tab_info: param["rule_tab_info"],
            rule_tab_history: param["rule_tab_history"],
            rule_tab_onset: param["rule_tab_onset"],
            rule_tab_base: param["rule_tab_base"],
            rule_tab_file: param["rule_tab_file"],
            rule_tab_file_commit: param["rule_tab_file_commit"],
            rule_tab_horizontal_relationship: param["rule_tab_horizontal_relationship"],
            rule_tab_correlation_task: param["rule_tab_correlation_task"],
            rule_template_fixed_tab: param["rule_template_fixed_tab"],
            rule_side_thumb_modify: param["rule_horizontal_relationship_modify_thumb"],
            rule_side_thumb_clear: param["rule_horizontal_relationship_clear_thumb"]
        };
        reset_datagrid_dom_param({
            dg_id :"#grid_datagrid_main",
            filter_id: "#grid_filter_main",
            delete_id: "#delele_horizontal_relationship_bnt"
        }, entity_grid_param);

        Strack.load_grid_columns('#tab_entity_grid', {
            loading_id: "#tab_entity_grid",
            page: page,
            schema_page: schema_page,
            module_id: tab_param["module_id"],
            project_id: param["project_id"],
            grid_id: 'main_datagrid_box',
            is_horizontal_relationship: is_horizontal_relationship,
            temp_fields: {
                add: {},
                cut: {}
            }
        }, function (data) {
            //过滤条件
            var $tab_entity_grid = $("#tab_entity_grid");
            var $entity_datagrid = $('#main_datagrid_box');
            var gird_param = {};

            var filter_data = {
                filter: {
                    temp_fields: {
                        add: {},
                        cut: {}
                    },
                    group: data['grid']["group_name"],
                    sort: data['grid']["sort_config"]["sort_query"],
                    request: [],
                    filter_input: data['grid']["filter_config"]["filter_input"],
                    filter_panel: data['grid']["filter_config"]["filter_panel"],
                    filter_advance: data['grid']["filter_config"]["filter_advance"]
                },
                page: page,
                schema_page: schema_page,
                module_id: tab_param["module_id"],
                project_id: param["project_id"],
                item_id: param["item_id"],
                module_code: tab_param["module_code"],
                module_type: tab_param["type"],
                horizontal_type: tab_param["horizontal_type"],
                parent_module_id: param["module_id"]
            };

            if ($tab_entity_grid.hasClass("load_active")) {

                // 重置实体数据表格
                gird_param = {
                    moduleId: tab_param['module_id'],
                    projectId: param['project_id'],
                    queryParams: {
                        filter_data: JSON.stringify(filter_data)
                    },
                    panelConfig: {
                        active_filter_id: data['grid']["filter_config"]["filter_id"]
                    },
                    sortConfig: data['grid']["sort_config"],
                    sortData: data['grid']["sort_config"]["sort_data"],
                    renderNewPage: true,
                    toolbarConfig: {
                        id: 'grid_datagrid_main',
                        page: page,
                        sortAllow: true,
                        groupAllow: true,
                        fieldAllow: true,
                        viewAllow: true,
                        stepAllow: true,
                        actionAllow: true
                    },
                    searchConfig: {
                        id: 'main_grid_search',
                        bar_show: data['grid']["filter_bar_show"],
                        filterBar: {
                            main_dom: 'grid_datagrid_main',
                            bar_dom: 'grid_filter_main'
                        }
                    },
                    filterConfig: {
                        id: 'grid_filter_main',
                        schema_page: schema_page,
                        barParam: {}
                    },
                    authorityRules: authority_rules,
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    onDblClickRow: function (index, row) {
                        entity_grid_param["item_id"] = row["id"];
                        Strack.open_datagrid_slider(entity_grid_param);
                    }
                };

                // 是否应用分组
                if (!$.isEmptyObject(data['grid']["group_name"])){
                    gird_param["groupActive"] = true;
                    gird_param["groupField"] = Strack.get_grid_group_field(data['grid']["group_name"])["field"];
                    gird_param["groupFormatter"] = function (value, rows) {
                        return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                    };
                }

                // 重置 datagrid 数据
                $entity_datagrid.datagrid("setOptions", gird_param)
                    .datagrid('reload');

            } else {
                // 第一次初始化
                $tab_entity_grid.addClass("load_active");

                // datagrid 配置参数
                gird_param = {
                    url: StrackPHP['getDetailGridData'],
                    height: Strack.panel_height("#grid_datagrid_main", 0),
                    view: scrollview,
                    rowheight: 50,
                    differhigh: true,
                    singleSelect: false,
                    adaptive: {
                        dom: "#grid_datagrid_main",
                        min_width: 680,
                        exth: 0,
                        domresize: 1
                    },
                    ctrlSelect: true,
                    multiSort: true,
                    DragSelect: true,
                    moduleId: tab_param['module_id'],
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
                        id: 'grid_datagrid_main',
                        page: page,
                        sortAllow: true,
                        groupAllow: true,
                        fieldAllow: true,
                        viewAllow: true,
                        stepAllow: true,
                        actionAllow: true
                    },
                    searchConfig: {
                        id: 'main_grid_search',
                        bar_show: data['grid']["filter_bar_show"],
                        filterBar: {
                            main_dom: 'grid_datagrid_main',
                            bar_dom: 'grid_filter_main'
                        }
                    },
                    filterConfig: {
                        id: 'grid_filter_main',
                        schema_page: schema_page,
                        barParam: {}
                    },
                    authorityRules: authority_rules,
                    contextMenuData: {
                        id: 'st_menu_entity',
                        copy_id: 'ac_copy_cell',
                        edit_id: '#grid_datagrid_main .edit-menu',
                        data: []
                    },
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    toolbar: '#tb_grid',
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 200,
                    pageList: [100, 200, 300, 400, 500],
                    pagePosition: 'bottom',
                    remoteSort: false,
                    onDblClickRow: function (index, row) {
                        entity_grid_param["item_id"] = row["id"];
                        Strack.open_datagrid_slider(entity_grid_param);
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

                $entity_datagrid.datagrid(gird_param)
                    .datagrid('enableCellEditing')
                    .datagrid('disableCellSelecting')
                    .datagrid('gotoCell',
                        {
                            index: 0,
                            field: 'id'
                        }
                    ).datagrid('columnMoving');
            }
        });
    }

    /**
     * 加载 note 页面
     */
    function init_note_panel() {
        var note_param = param;
        note_param['status'] = 'new';
        note_param['page_number'] = 1;
        note_param['page_size'] = 20;
        Strack.load_notes({
            page_id: '.projpage-main',
            content_id: '.task-mainwrap',
            avatar_id: '#comments_avatar',
            editor_id: 'comments_editor',
            list_id: 'comments_list',
            tab_id: '#details_tab',
            details_top_bar: true,
            tab_bar_id: 'task_hidebar'
        }, note_param);
    }

    /**
     * 加载详情页面信息面板数据
     */
    function load_info_panel() {
        Strack.load_info_panel({
            id: "#details_info",
            mask: 'main_info',
            pos: 'max',
            url: StrackPHP["getModuleItemInfo"],
            data: {
                item_id: param["item_id"],
                category : "main_field",
                schema_page : "project_"+param["module_code"],
                project_id : param["project_id"],
                module_id : param["module_id"],
                module_code : param["module_code"],
                module_type : param["module_type"],
                template_id : param["template_id"]
            },
            loading_type: 'white'
        });
    }

    /**
     * 初始化OnSet现场数据面板
     */
    function load_onset_panel() {
        // 判断当前实体是否已经关联了OnSet数据，获取可以显示OnSet任务所属实体是否关联了OnSet数据
        Strack.get_item_onset_data(param, function (data) {
            if(parseInt(data["status"]) === 200){
                if(data["data"]["has_link_onset"] === "yes"){
                    // 加载 Onset 现场数据
                    onset_param = data["data"];
                    load_onset_data();
                }else {
                    $("#onset_link_not_exit").show();
                    get_onset_list_data(data["data"]);
                }
            }else {
                // 当前任务模块没有关联实体
                $("#onset_entity_not_exit").show();
            }
        });
    }

    /**
     * 加载 Onset 现场数据
     */
    function load_onset_data() {

        $("#onset_entity_not_exit,#onset_link_not_exit").remove();

        $("#onset_link_main").show();

        // 加载 Onset 现场数据
        onset_info_param = Strack.deep_copy(param);
        onset_info_param["category"] = "detail_onset_field";
        onset_info_param["module_id"] = onset_param["entity_module_id"];
        onset_info_param["onset_id"] = onset_param["onset_id"];

        $("#onset_att_bnt").attr("data-linkid", onset_param["onset_id"])
            .attr("data-moduleid", onset_param["module_id"]);

        Strack.load_info_panel({
            id: "#onset_info",
            mask: 'onset_info',
            pos: 'onset',
            url: StrackPHP["getOnsetInfoData"],
            data: onset_info_param,
            loading_type: 'white'
        }, function (data) {
        });

        // 加载 Onset 附件数据
        Strack.load_onset_attachment("#onset_reference",{
            module_id : onset_param["module_id"],
            link_id : onset_param["onset_id"]
        });
    }


    /**
     * 初始化Onset列表控件
     * @param data
     */
    function get_onset_list_data(data) {
        $("#onset_select_module_id").val(data["module_id"]);
        $("#onset_select_entity_id").val(data["entity_id"]);
        $("#onset_select_entity_module_id").val(data["entity_module_id"]);
        Strack.combobox_widget('#onset_select_list', {
            url: StrackPHP["getProjectOnsetList"],
            valueField: 'id',
            textField: 'name',
            width: 300,
            height: 30,
            queryParams: {
                "project_id" : param.project_id
            }
        });
    }

    /**
     * 添加关联Onset
     */
    function add_link_onset(add_data) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['addEntityLinkOnset'],
            data: add_data,
            dataType: 'json',
            beforeSend: function () {
                $(param.id).prepend(Strack.loading_dom(param.loading_type), param["mask"]);
                $('#tab_onset').prepend(Strack.loading_dom('white', '', 'onset_add'));
            },
            success: function (data) {
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                    $('#onset_select_list').combobox("destroy");
                    onset_param = {
                        "onset_id" : data["data"]["onset_id"],
                        "entity_id" : data["data"]["link_id"],
                        "module_id": add_data["onset_module_id"],
                        "entity_module_id" : data["data"]["module_id"]
                    };
                    load_onset_data();
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
                $('#st-load_onset_add').remove();
            }
        });
    }

    /**
     * 修改url地址
     * @param scene
     * @param url_tag
     */
    function modify_url_address(scene, url_tag) {
        var base_url = param.module_id + '-' + param.project_id + '-' + param.item_id + '.html';
        if (url_tag) {
            base_url += '?' + url_tag;
        }
        history.replaceState(null, scene, base_url);
    }
});