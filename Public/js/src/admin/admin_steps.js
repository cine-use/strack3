$(function(){
    obj={
        step_add:function(){
            var formData = Strack.validate_form('add_step');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : StepsPHP['addStep'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.step_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        step_modify:function(){
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_step_dialog(rows[0], 'datagrid_box');
            }
        },
        step_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StepsPHP['modifyStep'],{
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
        step_delete:function(){
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delelte_Step_Notice'], StepsPHP['deleteStep'], param);
        },
        step_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    //初始化控件
    Strack.color_pick_widget('#step_color', 'hex', 'light');

    //设置输入框掩码
    $("#step_code").inputmask('alphaDash');

    var param = Strack.generate_hidden_param();

    load_step_data();

    /**
     * 加载工序数据
     */
    function load_step_data() {
        $('#datagrid_box').datagrid({
            url: StepsPHP['getStepGridData'],
            rownumbers: true,
            nowrap: true,
            fitColumns:Strack.fit_columns('.admin-dept-right',474),
            height: Strack.panel_height('.admin-dept-right',0),
            DragSelect:true,
            adaptive:{
                dom:'.admin-dept-right',
                min_width:474,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'step_id',title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'color', title: StrackLang['Color'], align: 'center', width: 136,
                    formatter: function(value,row,index) {
                        return '<div class="picker-color" style="background-color: \#'+value+'">#'+value+'</div>';
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 260},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 260}
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
                modify_step_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 修改工序dialog
     * @param data
     * @param id
     */
    function modify_step_dialog(data, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Step'],
            width: 480,
            height: 340,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mstep_id',type:'hidden',name:'id',valid:1,value:data['id']}
                ],
                items:[
                    {case:1,id:'Mstep_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"1,128",value:data['name']},
                    {case:1,id:'Mstep_code',lang:StrackLang['Code'],name:'code',valid:"1,128",value:data['code']},
                    {case:2,id:'Mstep_color',lang:StrackLang['Color'],name:'color',valid:"6,6"}
                ],
                footer:[
                    {obj:'step_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.color_pick_widget('#Mstep_color', 'hex', 'light', data['color'], 320);
                $("#Mstep_code").inputmask('alphaDash');
            },
            close:function(){
                $("#"+id).datagrid('reload');
            }
        });
    }
});
