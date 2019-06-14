$(function () {
    obj = {
        switch_table: function (i) {
            var table = $(i).data("table");
            $("#current_table").val(table);
            $('.mproj-item').removeClass('templates-active');
            $(i).parent().addClass('templates-active');
            $('#datagrid_box').datagrid("reload",{table: table});
        },
        table_save: function () {
            var dg = $('#datagrid_box');
            var dg_data = dg.datagrid("getData");
            var table = $("#current_table").val();

            $.ajax({
                type: 'POST',
                url: FieldPHP['modifyFieldConfig'],
                dataType: 'json',
                data: {
                    table : table,
                    config : JSON.stringify(dg_data["rows"])
                },
                beforeSend: function () {
                    $('#temp_list').append(Strack.loading_dom('white'));
                },
                success: function (data) {
                    $('#st-load').remove();
                    Strack.top_message({bg:'g',msg: data['message']});
                    dg.datagrid("reload");
                }
            });
        }
    };

    load_table_list();
    load_field_data();

    /**
     * 加载数据表列表
     */
    function load_table_list() {
        $.ajax({
            type: 'POST',
            url: FieldPHP['getTableList'],
            dataType: 'json',
            beforeSend: function () {
                $('#table_list')
                    .empty()
                    .append(Strack.loading_dom('null'));
            },
            success: function (data) {
                var tlist = '';
                $('#st-load').remove();
                data.forEach(function (val) {
                    tlist += table_list_dom(val);
                });
                $('#table_list').append(tlist);
            }
        });
    }

    /**
     * 后台数据表列表呈现
     * @param table_name
     * @returns {string}
     */
    function table_list_dom(table_name) {
        var dom = '';
        dom += '<div id="mproj_item_' + table_name + '" class="item mproj-item">' +
            '<a href="javascript:;" class="header" onclick="obj.switch_table(this);" data-table="' + table_name + '">' +
            '<div class="mproj-content text-ellipsis">' +
            table_name +
            '</div>' +
            '</a>' +
            '</div>';
        return dom;
    }

    /**
     * 加载字段数据表格
     */
    function load_field_data() {
        $('#datagrid_box').datagrid({
            url: FieldPHP['getFieldConfig'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('.temp-setlist-wrap',0),
            rowheight:0,
            differhigh: true,
            singleSelect: true,
            adaptive:{
                dom:'.temp-setlist-wrap',
                min_width:1004,
                exth:0
            },
            cellUpdateMode: 'manual',
            queryParams: {
                table: ''
            },
            columnsFieldConfig: {
                module : {field_type: 'built_in', field_map: 'module', primary: 'id', module_code: 'field', table: 'field'},
                table : {field_type: 'built_in', field_map: 'table',  primary: 'id', module_code: 'field', table: 'field'},
                fields : {field_type: 'built_in', field_map: 'fields',   primary: 'id', module_code: 'field', table: 'field'},
                lang : {field_type: 'built_in', field_map: 'lang',  primary: 'id', module_code: 'field', table: 'field'},
                type : {field_type: 'built_in', field_map: 'type',   primary: 'id', module_code: 'field', table: 'field'},
                require : {field_type: 'built_in', field_map: 'require',   primary: 'id', module_code: 'field', table: 'field'},
                format : {field_type: 'built_in', field_map: 'format',   primary: 'id', module_code: 'field', table: 'field'},
                show_from : {field_type: 'built_in', field_map: 'show_from',   primary: 'id', module_code: 'field', table: 'field'},
                editor : {field_type: 'built_in', field_map: 'editor',   primary: 'id', module_code: 'field', table: 'field'},
                data_source : {field_type: 'built_in', field_map: 'data_source',   primary: 'id', module_code: 'field', table: 'field'},
                edit : {field_type: 'built_in', field_map: 'edit',   primary: 'id', module_code: 'field', table: 'field'},
                create_in_time: {field_type: 'built_in', field_map: 'create_in_time',   primary: 'id', module_code: 'field', table: 'field'},
                show : {field_type: 'built_in', field_map: 'show',   primary: 'id', module_code: 'field', table: 'field'},
                value_show : {field_type: 'built_in', field_map: 'value_show',   primary: 'id', module_code: 'field', table: 'field'},
                width : {field_type: 'built_in', field_map: 'width',  primary: 'id', module_code: 'field', table: 'field'},
                filter : {field_type: 'built_in', field_map: 'filter',  primary: 'id', module_code: 'field', table: 'field'},
                sort : {field_type: 'built_in', field_map: 'sort', primary: 'id', module_code: 'field', table: 'field'},
                validate : {field_type: 'built_in', field_map: 'validate' , primary: 'id', module_code: 'field', table: 'field'},
                mask : {field_type: 'built_in', field_map: 'mask', primary: 'id', module_code: 'field', table: 'field'},
                multiple : {field_type: 'built_in', field_map: 'multiple', primary: 'id', module_code: 'field', table: 'field'},
                group : {field_type: 'built_in', field_map: 'group', primary: 'id', module_code: 'field', table: 'field'},
                allow_group : {field_type: 'built_in', field_map: 'allow_group', primary: 'id', module_code: 'field', table: 'field'},
                is_primary_key : {field_type: 'built_in', field_map: 'is_primary_key', primary: 'id', module_code: 'field', table: 'field'},
                is_foreign_key : {field_type: 'built_in', field_map: 'is_foreign_key', primary: 'id', module_code: 'field', table: 'field'},
                foreign_key_map : {field_type: 'built_in', field_map: 'foreign_key_map', primary: 'id', module_code: 'field', table: 'field'},
                foreign_key_module_lang: {field_type: 'built_in', field_map: 'foreign_key_module_lang', primary: 'id', module_code: 'field', table: 'field'},
                default_value : {field_type: 'built_in', field_map: 'default_value', primary: 'id', module_code: 'field', table: 'field'},
                formatter: {field_type: 'built_in', field_map: 'formatter', primary: 'id', module_code: 'field', table: 'field'},
                outreach_display : {field_type: 'built_in', field_map: 'outreach_display', primary: 'id', module_code: 'field', table: 'field'},
                outreach_lang: {field_type: 'built_in', field_map: 'outreach_lang',  primary: 'id', module_code: 'field', table: 'field'},
                outreach_edit: {field_type: 'built_in', field_map: 'outreach_edit',  primary: 'id', module_code: 'field', table: 'field'},
                outreach_editor : {field_type: 'built_in', field_map: 'outreach_editor', primary: 'id', module_code: 'field', table: 'field'},
                outreach_formatter: {field_type: 'built_in', field_map: 'outreach_formatter', primary: 'id', module_code: 'field', table: 'field'},
                step_task_formatter : {field_type: 'built_in', field_map: 'step_task_formatter', primary: 'id', module_code: 'field', table: 'field'},
                field_type : {field_type: 'built_in', field_map: 'field_type', primary: 'id', module_code: 'field', table: 'field'}
            },
            frozenColumns: [[
                {field: 'id', align: 'center', checkbox: true}
            ]],
            columns: [[
                {field: 'module', title: StrackLang['Module'], align: 'center', width: 140, frozen:"frozen", findex:0, editor: {type: 'text'}},
                {field: 'table', title: StrackLang['Table_Name'], align: 'center', width: 140, frozen:"frozen", findex:1, editor: {type: 'text'}},
                {field: 'fields', title: StrackLang['Field'], align: 'center', width: 140, frozen:"frozen", findex:2, editor: {type: 'text'}},
                {field: 'lang', title: StrackLang['Language_Package'], align: 'center', width: 140, frozen:"frozen", findex:3, editor: {type:'text'}},
                {field: 'type', title: StrackLang['Type'], align: 'center', width: 180, frozen:"frozen", findex:4, editor: {type: 'text'}},
                {field: 'format', title: StrackLang['Format'], align: 'center', width: 120, frozen:"frozen", findex:5, editor: {type: 'text'}},
                {field: 'show_from', title: StrackLang['Show_From'], align: 'center', width: 120, frozen:"frozen", findex:6, editor: {type: 'text'}},
                {field: 'require', title: StrackLang['Require'], align: 'center', width: 120, frozen:"frozen", findex:7, editor:{
                        type:'combobox',
                        options:{
                            height: 31,
                            valueField:'id',
                            textField:'name',
                            method:'post',
                            data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                        }
                    }},
                {field: 'editor', title: StrackLang['Editor'], align: 'center', width: 140, frozen:"frozen", findex:8, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data: [{id:'none',name:'none'}, {id:'text',name:'text'}, {id:'checkbox',name:'checkbox'}, {id:'textarea',name:'textarea'}, {id:'combobox',name:'combobox'}, {id:'datebox',name:'datebox'}, {id:'datetimebox',name:'datetimebox'}, {id:'upload', name:'upload'}, {id:'relation', name:'relation'}, {id:'tagbox', name:'tagbox'}]
                    }
                }},
                {field: 'data_source', title: StrackLang['Data_Source'], align: 'center', width: 120, frozen:"frozen", findex:9, editor: {type: 'text'}},
                {field: 'edit', title: StrackLang['Edit'], align: 'center', width: 120, frozen:"frozen", findex:10, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                    }
                }},
                {field: 'create_in_time', title: StrackLang['Create_In_Time'], align: 'center', width: 120, frozen:"frozen", findex:11, editor:{
                        type:'combobox',
                        options:{
                            height: 31,
                            valueField:'id',
                            textField:'name',
                            method:'post',
                            data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                        }
                    }},
                {field: 'show', title: StrackLang['Show'], align: 'center', width: 120, frozen:"frozen", findex:12, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                    }
                }},
                {field: 'value_show', title: StrackLang['Value_Show'], align: 'center', width: 140, frozen:"frozen", findex:13, editor: {type: 'text'}},
                {field: 'width', title: StrackLang['Width'], align: 'center', width: 90, frozen:"frozen", findex:14, editor: {type: 'text'}},
                {field: 'filter', title: StrackLang['Filter'], align: 'center', width: 120, frozen:"frozen", findex:15, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                    }
                }},
                {field: 'sort', title: StrackLang['Sort'], align: 'center', width: 120, frozen:"frozen", findex:16, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                    }
                }},
                {field: 'validate', title: StrackLang['Validate'], align: 'center', width: 160, frozen:"frozen", findex:17, editor:{type: 'text'}},
                {field: 'mask', title: StrackLang['Mask'], align: 'center', width: 160, frozen:"frozen", findex:18, editor:{type: 'text'}},
                {field: 'multiple', title: StrackLang['Multiple'], align: 'center', width: 120, frozen:"frozen", findex:19, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                    }
                }},
                {field: 'group', title: StrackLang['Group'], align: 'center', width: 120, frozen:"frozen", findex:20, editor: {type: 'text'}},
                {field: 'allow_group', title: StrackLang['Allow_Group'], align: 'center', width: 120, frozen:"frozen", findex:21, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                    }
                }},
                {field: 'is_primary_key', title: StrackLang['Is_Primary_Key'], align: 'center', width: 120, frozen:"frozen", findex:22, editor:{
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                    }
                }},
                {field: 'is_foreign_key', title: StrackLang['Is_Foreign_Key'], align: 'center', width: 120, frozen:"frozen", findex:23, editor:{
                        type:'combobox',
                        options:{
                            height: 31,
                            valueField:'id',
                            textField:'name',
                            method:'post',
                            data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                        }
                    }},
                {field: 'foreign_key_map', title: StrackLang['Foreign_Key_Map'], align: 'center', width: 120, frozen:"frozen", findex:24, editor: {type: 'text'}},
                {field: 'foreign_key_module_lang', title: StrackLang['Foreign_Key_Module_Lang'], align: 'center', width: 120, frozen:"frozen", findex:25, editor: {type: 'text'}},
                {field: 'default_value', title: StrackLang['Default_Value'], align: 'center', width: 120, frozen:"frozen", findex:26, editor:{type: 'text'}},
                {field: 'formatter', title: StrackLang['Formatter'], align: 'center', width: 220, frozen:"frozen", findex:27, editor: {type: 'textarea'},
                    formatter: function(value,row,index){
                        return Strack.html_encode(value);
                    }
                },
                {field: 'outreach_display', title: StrackLang['Outreach_Display'], align: 'center', width: 120, frozen:"frozen", findex:28, editor: {
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data:  [{id:'no',name:'no'}, {id:'yes',name:'yes'}]
                    }
                }},
                {field: 'outreach_lang', title: StrackLang['Outreach_Display_Lang'], align: 'center', width: 140, frozen:"frozen", findex:29, editor: {type:'text'}},
                {field: 'outreach_edit', title: StrackLang['Outreach_Edit'], align: 'center', width: 120, frozen:"frozen", findex:30, editor:{
                        type:'combobox',
                        options:{
                            height: 31,
                            valueField:'id',
                            textField:'name',
                            method:'post',
                            data:  [{id:'allow',name:'allow'}, {id:'deny',name:'deny'}]
                        }
                    }},
                {field: 'outreach_editor', title: StrackLang['Outreach_Editor'], align: 'center', width: 120, frozen:"frozen", findex:31, editor: {
                    type:'combobox',
                    options:{
                        height: 31,
                        valueField:'id',
                        textField:'name',
                        method:'post',
                        data: [{id:'none',name:'none'}, {id:'input',name:'input'}, {id:'checkbox',name:'checkbox'}, {id:'textarea',name:'textarea'}, {id:'combobox',name:'combobox'}, {id:'datebox',name:'datebox'}, {id:'datetimebox',name:'datetimebox'}, {id:'upload', name:'upload'}, {id:'relation', name:'relation'}, {id:'tagbox', name:'tagbox'}]
                    }
                }},
                {field: 'outreach_formatter', title: StrackLang['Outreach_Formatter'], align: 'center', width: 220, frozen:"frozen", findex:32, editor: {type: 'textarea'},
                    formatter: function(value,row,index){
                        return Strack.html_encode(value);
                    }
                },
                {field: 'step_task_formatter', title: StrackLang['Step_Task_Formatter'], align: 'center', width: 220, frozen:"frozen", findex:33, editor: {type: 'textarea'},
                    formatter: function(value,row,index){
                        return Strack.html_encode(value);
                    }
                },
                {field: 'field_type', title: StrackLang['Field_Type'], align: 'center', width: 120, frozen:"frozen", findex:34}
            ]],
            toolbar: '#tb',
            remoteSort: false,
            onLoadSuccess: function(){
                $(this).datagrid('enableDnd');
            }
        }).datagrid('enableCellEditing')
            .datagrid('disableCellSelecting')
            .datagrid('gotoCell',
                {
                    index: 0,
                    field: 'id'
                }
            ).datagrid('columnMoving');
    }
});