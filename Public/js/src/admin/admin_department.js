$(function(){
    obj={
        dept_add:function(){
            var formData = Strack.validate_form('add_dept');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : DeptPHP['addDepartment'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.department_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        dept_modify:function(){
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_dept_dialog(rows[0], 'datagrid_box');
            }
        },
        dept_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', DeptPHP['modifyDepartment'],{
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
        dept_delete:function(){
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Department_Notice'], DeptPHP['deleteDepartment']);
        },
        department_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    //设置输入框掩码
    $("#dept_code").inputmask('alphaDash');

    var param = Strack.generate_hidden_param();

    load_dept_data();

    /**
     * 加载区域数据表格
     */
    function load_dept_data() {
        $('#datagrid_box').datagrid({
            url: DeptPHP['getDepartmentGridData'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('.admin-dept-right', 0),
            DragSelect:true,
            adaptive: {
                dom: '.admin-dept-right',
                min_width: 300,
                exth: 0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'department_id', title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 300},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 300}
            ]],
            toolbar: '#tb',
            pagination: true,
            pageSize: 25,
            pageList: [25, 50],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false,
            onDblClickRow: function (index, row) {
                $(this).datagrid('selectRow',index);
                modify_dept_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 编辑区域
     * @param row
     * @param id
     */
    function modify_dept_dialog(row ,id) {
        Strack.open_dialog('dialog', {
            title: StrackLang['Modify_Department'],
            width: 480,
            height: 240,
            content: Strack.dialog_dom({
                type: 'normal',
                hidden: [
                    {case: 101, id: 'Mdept_id', type: 'hidden', name: 'id', valid: 1, value: row['id']}
                ],
                items: [
                    {case: 1, id: 'Mdept_name', type: 'text', lang: StrackLang['Name'], name: 'name', valid: "1,128", value: row['name']},
                    {case: 1, id: 'Mdept_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: row['code']}
                ],
                footer: [
                    {obj: 'dept_update', type: 1, title: StrackLang['Update']},
                    {obj: 'dialog_cancel',type: 8,title:StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                //设置输入框掩码
                $("#Mdept_code").inputmask('alphaDash');
            },
            close: function () {
                $('#'+id).datagrid('reload');
            }
        });
    }
});