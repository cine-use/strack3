$(function(){

    var param = Strack.generate_hidden_param();
    param["grid_page_id"] = param["module_code"] + '_grid_' + param["project_id"];

    load_event_logs();

    /**
     * 加载后台操作历史记录
     */
    function load_event_logs() {

        Strack.load_grid_columns('#table_grid', {
            loading_id : ".projtable-content",
            page: param["page"],
            schema_page: param["page"],
            module_id: param["module_id"],
            grid_id: 'main_datagrid_box',
            project_id: 0,
            view_type: "grid"
        }, function (data) {

            if(parseInt(data["status"]) === 200){
                //过滤条件
                var filter_data = {
                    filter: {
                        group: data['grid']["group_name"],
                        sort: data['grid']["sort_config"]["sort_query"],
                        request: [],
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
                    url: LogsPHP['getEventLogGridData'],
                    height: Strack.panel_height(".projtable-content", 0),
                    rowheight: 43,
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
                        fieldAllow: false,
                        viewAllow: false
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
                            show : "yes",
                            edit : "yes"
                        },
                        sort : "yes",
                        group : "yes"
                    },
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    toolbar: '#tb_grid',
                    pagination: true,
                    pageSize: 100,
                    pageList: [100, 200, 300, 400, 500],
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
            }else {
                // 事件日志服务器配置有问题
                $(".projtable-content").empty()
                    .append('<div class="datagrid-empty-no text-center">'+StrackLang["Please_Configure_Event_Server"]+'</div>');
            }
        });
    }
});