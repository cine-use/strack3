$(function(){
    obj = {
        tags_add:function () {
            var formData = Strack.validate_form('add_tags');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : TagsPHP['addTag'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.tag_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        tags_modify:function () {
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                module_tags_dialog(rows[0], 'datagrid_box');
            }
        },
        tags_update:function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', TagsPHP['modifyTag'],{
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
        tags_delete:function () {
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Tag_Notice'], TagsPHP['deleteTag'], param);
        },
        tag_reset:function () {
            $('#datagrid_box').datagrid('reload');
        }
    };

    //初始化控件
    Strack.color_pick_widget('#tags_color', 'hex', 'light');

    // Strack.combobox_widget('#tags_type', {
    //     url: StrackPHP["getTagTypeList"],
    //     valueField: 'id',
    //     textField: 'name',
    //     width: 300,
    //     height: 30
    // });

    //初始化input输入掩码
    $(":input").inputmask();


    var param = Strack.generate_hidden_param();

    load_tags_data();

    /**
     * 加载标签数据
     */
    function load_tags_data() {
        $('#datagrid_box').datagrid({
            url: TagsPHP['getTagGridData'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('.admin-dept-right', 0),
            DragSelect:true,
            adaptive: {
                dom: '.admin-dept-right',
                min_width: 1004,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'tag_id',title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'color', title: StrackLang['Color'], align: 'center', width: 180,
                    formatter: function(value,row,index) {
                        return '<div class="picker-color" style="background-color: \#'+value+'">#'+value+'</div>';
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 260}
                //{field: 'type', title: StrackLang['Type'], align: 'center', width: 180}
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
                module_tags_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 修改标签
     * @param row
     * @param id
     */
    function module_tags_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Tag'],
            width: 480,
            height: 300,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mtag_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mname',type:'text',lang:StrackLang['Name'],name:'name',valid:1,value:row['name'],mask:"*{1,40}"},
                    {case:2,id:'Mtag_color',lang:StrackLang['Color'],name:'color',valid:'6,6'},
                    {case:2,id:'Mtag_type',lang:StrackLang['Type'],name:'type',valid:'1'}
                ],
                footer:[
                    {obj:'tags_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.color_pick_widget('#Mtag_color', 'hex', 'light', row['color'],320);
                Strack.combobox_widget('#Mtag_type', {
                    url: StrackPHP["getTagTypeList"],
                    valueField: 'id',
                    textField: 'name',
                    value : row['type']
                });
                $("#Mname").inputmask();
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});