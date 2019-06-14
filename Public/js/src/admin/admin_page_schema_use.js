$(function(){
    obj={
        page_schema_use_add:function(){
            var formData = Strack.validate_form('add_page_schema_use');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : PageSchemaUsePHP['addPageSchemaUse'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.status_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        page_schema_use_modify:function(){
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_page_schema_use_dialog(rows[0], 'datagrid_box');
            }
        },
        page_schema_use_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', PageSchemaUsePHP['modifyPageSchemaUse'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        page_schema_use_delete:function(){
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Page_Schema_Use_Comfirm'], PageSchemaUsePHP['deletePageSchemaUse']);
        },
        status_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    //初始化控件
    Strack.combobox_widget('#schema_list', {
        url: PageSchemaUsePHP["getSchemaCombobox"],
        valueField: 'id',
        textField: 'name',
        width: 300,
        height: 30
    });

    load_page_schema_use_data();

    /**
     * 获取页面使用数据结构配置列表数据
     */
    function load_page_schema_use_data() {
        $('#datagrid_box').datagrid({
            url: PageSchemaUsePHP['getPageSchemaUseGridData'],
            rownumbers: true,
            nowrap: true,
            fitColumns:Strack.fit_columns('.admin-dept-right',1004),
            height: Strack.panel_height('.admin-dept-right',0),
            DragSelect:true,
            adaptive:{
                dom:'.admin-dept-right',
                min_width:1004,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'page_schema_use_id', title: StrackLang['ID'], align: 'center', width: 80,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'page', title: StrackLang['Page_Name'], align: 'center', width: 260},
                {field: 'schema_id', title: StrackLang['Schema_ID'], align: 'center', width: 260}
            ]],
            toolbar: '#tb',
            pagination: true,
            pageSize: 100,
            pageList: [100, 200],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false,
            onDblClickRow: function(index,row){
                $(this).datagrid('selectRow',index);
                modify_page_schema_use_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 编辑状态
     * @param row
     * @param id
     */
    function modify_page_schema_use_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Page_Schema_Use_Title'],
            width: 480,
            height: 240,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mpage_schema_use_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mpage_name',type:'text',lang:StrackLang['Page_Name'],name:'page',valid:'1,128',value:row['page']},
                    {case:2,id:'Mschema_list',lang:StrackLang['Schema_List'],name:'schema_id',valid:1}
                ],
                footer:[
                    {obj:'page_schema_use_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.combobox_widget('#Mschema_list', {
                    url: PageSchemaUsePHP["getSchemaCombobox"],
                    valueField: 'id',
                    textField: 'name',
                    value : row['schema_id']
                });
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});
