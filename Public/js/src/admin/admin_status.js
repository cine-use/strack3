$(function(){
    obj={
        status_add:function(){
            var formData = Strack.validate_form('add_status');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : StatusPHP['addStatus'],
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
        status_modify:function(){
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_status_dialog(rows[0], 'datagrid_box');
            }
        },
        status_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StatusPHP['modifyStatus'],{
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
        status_delete:function(){
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Status_Notice'], StatusPHP['deleteStatus'], param);
        },
        status_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    //初始化控件
    Strack.color_pick_widget('#status_color', 'hex', 'light');
    Strack.combobox_widget('#status_icon', {
        url: StrackPHP["getIconList"],
        valueField: 'icon',
        textField: 'icon',
        width: 300,
        height: 30,
        formatter: function (row) {
            return '<div class="combo-icons-warp" style="overflow: hidden"><div class="combo-icons aign-left"><i class="' + row.icon + '"></i></div><div class="combo-name">' + row.icon + '</div></div>';
        }
    });
    Strack.combobox_widget('#status_corresponds', {
        url: StrackPHP["getStatusCorresponds"],
        valueField: 'id',
        textField: 'name',
        width: 300,
        height: 30
    });

    //设置输入框掩码
    $("#status_code").inputmask('alphaDash');

    var param = Strack.generate_hidden_param();

    load_status_data();

    /**
     * 加载状态数据表格
     */
    function load_status_data() {
        $('#datagrid_box').datagrid({
            url: StatusPHP['getStatusGridData'],
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
                {field: 'status_id', title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'icon', title: StrackLang['Icon'], align: 'center', width: 60,
                    formatter: function(value,row,index) {
                        return '<i class="'+value+'" style="color: \#'+row.status_color+'"></i>';
                    }
                },
                {field: 'color', title: StrackLang['Color'], align: 'center', width: 180,
                    formatter: function(value,row,index) {
                        return '<div class="picker-color" style="background-color: \#'+value+'">#'+value+'</div>';
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 260},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 260},
                {field: 'correspond_name', title: StrackLang['Corresponds'], align: 'center', width: 260}
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
                modify_status_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 编辑状态
     * @param row
     * @param id
     */
    function modify_status_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Status_Title'],
            width: 480,
            height: 400,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mstatus_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mstatus_name',type:'text',lang:StrackLang['Name'],name:'name',valid:'1,128',value:row['name']},
                    {case:1,id:'Mstatus_code',type:'text',lang:StrackLang['Code'],name:'code',valid:'1,128',value:row['code']},
                    {case:2,id:'Mstatus_color',lang:StrackLang['Color'],name:'color',valid:'6,6'},
                    {case:2,id:'Mstatus_Icon',lang:StrackLang['Icon'],name:'icon',valid:'1,24'},
                    {case:2,id:'Mstatus_Cponds',lang:StrackLang['Corresponds'],name:'correspond',valid:'1'}
                ],
                footer:[
                    {obj:'status_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.color_pick_widget('#Mstatus_color', 'hex', 'light', row['color'],320);
                Strack.combobox_widget('#Mstatus_Icon', {
                    url: StrackPHP["getIconList"],
                    valueField: 'icon',
                    textField: 'icon',
                    value: row['icon'],
                    formatter: function (row) {
                        return '<div class="combo-icons-warp" style="overflow: hidden"><div class="combo-icons aign-left"><i class="' + row.icon + '"></i></div><div class="combo-name">' + row.icon + '</div></div>';
                    }
                });
                Strack.combobox_widget('#Mstatus_Cponds', {
                    url: StrackPHP["getStatusCorresponds"],
                    valueField: 'id',
                    textField: 'name',
                    value: row['correspond']
                });
                $("#Mstatus_code").inputmask('alphaDash');
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});
