$(function(){
    obj = {
        // 删除动作
        action_delete: function (i) {
            Strack.ajax_grid_delete('main_datagrid_box', 'id', StrackLang['Delete_Action_Notice'], ActionPHP['deleteAction'], param);
        },
        // 重置动作数据表格
        reset_action: function (i) {
            $("#main_datagrid_box").datagrid("reload");
        }
    };

    var param = Strack.generate_hidden_param();
    param["grid_page_id"] = param["module_code"] + '_grid_' + param["project_id"];

    load_action_list();

    /**
     * 加载后台操作历史记录
     */
    function load_action_list() {
        Strack.load_grid_columns('#table_grid', {
            loading_id : ".projtable-content",
            page: param["page"],
            schema_page: param["page"],
            module_id: param["module_id"],
            project_id: 0,
            grid_id: 'main_datagrid_box',
            view_type: "grid",
            temp_fields: {
                add : {},
                cut : {}
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

                    ],
                    filter_input: data['grid']["filter_config"]["filter_input"],
                    filter_panel: data['grid']["filter_config"]["filter_panel"],
                    filter_advance: data['grid']["filter_config"]["filter_advance"]
                },
                page: param["page"],
                schema_page: param["page"],
                module_id: param["module_id"],
                project_id: 0
            };

            // datagrid 配置参数
            var gird_param = {
                url: ActionPHP['getActionGridData'],
                height: Strack.panel_height("#grid_datagrid_main", 0),
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
                moduleId: param['module_id'],
                projectId: 0,
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
                    page: param["page"],
                    sortAllow: true,
                    groupAllow: true,
                    fieldAllow: true,
                    viewAllow: true
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
                    schema_page: param["page"],
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
                columnsFieldConfig: data['grid']["columnsFieldConfig"],
                frozenColumns: data['grid']["frozenColumns"],
                columns: data['grid']["columns"],
                toolbar: '#tb_grid',
                pagination: true,
                pageSize: 100,
                pageList: [100, 200, 300, 400, 500, "All"],
                page_numberber: 1,
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