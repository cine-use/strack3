$(function () {
    obj = {
        //添加 module
        module_add: function () {
            var formData = Strack.validate_form('add_module');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : ModulePHP['addModule'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.module_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        //编辑 module
        module_modify: function () {
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackPHP['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackPHP['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                module_modify_dialog(rows[0], 'datagrid_box');
            }
        },
        //提交 module 修改
        module_modify_update: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', ModulePHP['modifyModule'],{
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
        //删除 module
        module_delete: function () {
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Module_Delete_Comfirm'], ModulePHP['deleteModule']);
        },
        //重置datagrid数据
        module_reset: function () {
            $('#datagrid_box').datagrid('reload');
        }
    };

    //获取模块类型列表
    $('#type').combobox({
        url: ModulePHP['getModuleTypeList'],
        width: 300,
        height: 30,
        valueField: 'type_id',
        textField: 'type_name',
        value: 'entity',
        onSelect: function (record) {
            var $fixed_module = $("#fixed_module"),
                $module_code = $("#module_code"),
                $module_number = $("#module_number");
            switch (record.type_id){
                case "fixed":
                    $fixed_module.show();
                    $module_code.attr("disabled", "disabled");
                    $module_number.attr("disabled", "disabled");
                    break;
                case "entity":
                    $fixed_module.hide();
                    $module_code.removeAttr("disabled").val('');
                    $module_number.removeAttr("disabled").val('');
                    break;
            }
        }
    });


    //获取固定模块列表
    $('#fixmodule_list').combobox({
        url: ModulePHP['getFixedModuleList'],
        width: 300,
        height: 30,
        valueField: 'id',
        textField: 'name',
        onSelect: function (record) {
            $("#module_code").val(record.id);
            $("#module_number").val(0);
        }
    });

    
    //获取图标列表
    Strack.combobox_widget('#module_icon', {
        url: StrackPHP["getIconList"],
        valueField: 'icon',
        textField: 'icon',
        width: 300,
        height: 30,
        formatter: function (row) {
            return '<div class="combo-icons-warp" style="overflow: hidden"><div class="combo-icons aign-left"><i class="' + row.icon + '"></i></div><div class="combo-name">' + row.icon + '</div></div>';
        }
    });

    //设置输入框掩码
    $("#module_name").inputmask("*{1,128}");
    $("#module_code").inputmask('alphaDash');
    $("#module_number").inputmask("9{1,9}");

    //初始化数据表格
    module_datagrid();

    /**
     * 模块数据表格
     */
    function module_datagrid() {
        $('#datagrid_box').datagrid({
            url: ModulePHP['getModuleData'],
            rownumbers: true,
            nowrap: true,
            ctrlSelect: true,
            DragSelect:true,
            height: Strack.panel_height('.admin-dept-right',0),
            adaptive:{
                dom:'.admin-dept-right',
                min_width:474,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'module_id', title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'type', title: StrackLang['Type'], align: 'center', width: 160},
                {field: 'icon', title: StrackLang['Icon'], align: 'center', width: 85,
                    formatter: function(value,row,index) {
                        return '<i class="'+value+'"></i>';
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 200},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 160},
                {field: 'number', title: StrackLang['Number'], align: 'center', width: 160}
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
                module_modify_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 编辑模块信息
     * @param row
     * @param id
     */
    function module_modify_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Module'],
            width: 480,
            height: 360,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mmodule_id',type:'hidden',name:'id',valid:1,value:row['id']},
                    {case:101,id:'Mtype',type:'hidden',name:'type',valid:1,value:row['type']}
                ],
                items:[
                    {case:2,id:'Mmodule_icon',lang:StrackLang['Icon'],name:'icon',valid:1},
                    {case:1,id:'Mmodule_name',type:'text',lang:StrackLang['Name'],name:'name',valid:'1,128',value:row['name']},
                    {case:1,id:'Mmodule_code',lang:StrackLang['Code'],name:'code',valid:'1,128',value:row['code']},
                    {case:1,id:'Mmodule_number',lang:StrackLang['Number'],name:'number',valid:'1,9',value:row['number']}
                ],
                footer:[
                    {obj:'module_modify_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                //获取图标列表
                Strack.combobox_widget('#Mmodule_icon', {
                    url: StrackPHP["getIconList"],
                    valueField: 'icon',
                    textField: 'icon',
                    value: row['icon'],
                    formatter: function (row) {
                        return '<div class="combo-icons-warp" style="overflow: hidden"><div class="combo-icons aign-left"><i class="' + row.icon + '"></i></div><div class="combo-name">' + row.icon + '</div></div>';
                    }
                });

                //设置输入框掩码
                $("#Mmodule_name").inputmask("*{1,128}");
                $("#Mmodule_code").inputmask('alphaDash');
                $("#Mmodule_number").inputmask("9{1,9}");
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});
