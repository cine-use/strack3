$(function () {
    obj = {
        // 添加rows类型数据
        file_add: function (i) {
            var lang = $(i).data("lang");
            Strack.item_operate_dialog(lang,
                {
                    mode: "create",
                    field_list_type: ['edit'],
                    module_id: param["module_id"],
                    project_id: param["project_id"],
                    page: param["page"],
                    schema_page: param["page"],
                    type:"add_panel"
                },
                function () {
                    obj.reset_file();
                }
            );
        },
        // 修改file类型数据
        file_edit: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type: ['edit'],
                        module_id: param["module_id"],
                        project_id: param["project_id"],
                        page: param["page"],
                        schema_page: param["page"],
                        type:"update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.reset_file();
                    }
                );
            });
        },
        // 删除file数据
        delete_file: function (i) {
            Strack.ajax_grid_delete('main_datagrid_box', 'id', StrackLang['Delete_File_Notice'], StrackPHP['deleteGridData'], param);
        },
        // 重置file数据表格
        reset_file: function () {
            $('#main_datagrid_box').datagrid('reload');
        }
    };

    var param = Strack.generate_hidden_param();
    param["grid_page_id"] = param["module_code"] + '_grid_' + param["project_id"];

    load_grid_data();

    /**
     * 加载 datagrid 数据
     */
    function load_grid_data() {
        Strack.load_grid_columns('#table_grid', {
            loading_id : ".projpage-main",
            page: param["page"],
            schema_page: param["page"],
            module_id: param["module_id"],
            project_id: param["project_id"],
            grid_id: 'main_datagrid_box',
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
                        {field : 'project_id', value : param.project_id, condition : 'EQ', module_code : param.module_code, table : 'File'}
                    ],
                    filter_input: data['grid']["filter_config"]["filter_input"],
                    filter_panel: data['grid']["filter_config"]["filter_panel"],
                    filter_advance: data['grid']["filter_config"]["filter_advance"]
                },
                page: param["page"],
                schema_page: param["page"],
                module_id: param["module_id"],
                project_id: param["project_id"]
            };

            // datagrid 配置参数
            var gird_param = {
                url: FilePHP['getFileGridData'],
                height: Strack.panel_height("#grid_datagrid_main", 0),
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
                moduleId: param['module_id'],
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
                    page: param["page"],
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
                contextMenuData: {
                    id: 'st_menu_file',
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
                    // param["item_id"] = row["id"];
                    // Strack.open_datagrid_slider(param);
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
