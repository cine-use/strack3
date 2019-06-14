$(function () {
    obj = {
        // 新增用户
        user_add: function (i) {
            var lang = $(i).data("lang");
            Strack.item_operate_dialog(lang,
                {
                    mode: "create",
                    field_list_type : ['edit'],
                    module_id: param["module_id"],
                    project_id: 0,
                    page: 'admin_account',
                    schema_page: 'admin_account',
                    type:"add_panel"
                },
                function () {
                    obj.user_reset();
                }
            );
        },
        // 修改选择的用户
        user_modify: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type : ['edit'],
                        module_id: param["module_id"],
                        project_id: 0,
                        page: 'admin_account',
                        schema_page: 'admin_account',
                        type:"update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.user_reset();
                    }
                );
            });
        },
        // 删除选择的用户
        user_delete: function (i) {
            Strack.ajax_grid_delete('main_datagrid_box', 'id', StrackLang['Delete_User_Notice'], AccountPHP['deleteAccount'], param);
        },
        // 注销选择的用户
        user_cancel: function(i)
        {
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                $.ajax({
                    type: 'POST',
                    url: AccountPHP['cancelAccount'],
                    data: {
                        ids: ids.join(",")
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.user_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                })
            });
        },
        // 重置用户密码为默认
        user_reset_default_pass: function (i) {
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                $.ajax({
                    type: 'POST',
                    url: AccountPHP['resetAccountPassword'],
                    data: {
                        ids: ids.join(",")
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.user_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                })
            });
        },
        user_reset: function () {
            $("#main_datagrid_box").datagrid("reload");
        }
    };

    var param = Strack.generate_hidden_param();

    // 加载用户账号数据表格信息
    load_account_data();

    /**
     * 加载Accout User List
     */
    function load_account_data() {

        Strack.load_grid_columns('#active_account', {
            page: 'admin_account',
            schema_page: 'admin_account',
            view_type: 'grid',
            module_id: param["module_id"],
            project_id: 0,
            grid_id: 'main_datagrid_box',
            temp_fields: {
                add : {},
                cut : {}
            }
        }, function (data) {



            var filter_data = {
                filter:{
                    group: [],
                    sort: {},
                    request: [
                    ],
                    temp_fields: {
                        add : {},
                        cut : {}
                    },
                    filter_input: [],
                    filter_panel: [],
                    filter_advance: []
                },
                page: 'admin_account',
                schema_page: 'admin_account',
                view_type: 'grid',
                module_id: param["module_id"],
                project_id: 0
            };

            // datagrid 配置参数
            var gird_param = {
                url: AccountPHP['getAccountGridData'],
                height: Strack.panel_height('.account-list', 0),
                rowheight: 50,
                view: scrollview,
                adaptive: {
                    dom: '.account-list',
                    min_width: 1736,
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
                moduleId: param["module_id"],
                toolbarConfig: {
                    id: 'grid_datagrid_main',
                    page: 'admin_account',
                    sortAllow: true,
                    groupAllow: true,
                    fieldAllow: true,
                    viewAllow: true,
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
                    schema_page: 'admin_account',
                    barParam: {}
                },
                authorityRules: {
                    filter: {
                        show : param.rule_panel_filter,
                        edit : param.rule_modify_filter
                    },
                    sort : param.rule_sort,
                    group : param.rule_group
                },
                contextMenuData: {
                    id: 'st_menu_task',
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

            $('#main_datagrid_box').datagrid(gird_param)
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
});