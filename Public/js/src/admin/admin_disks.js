$(function(){
   obj ={
       disks_add:function () {
           var formData = Strack.validate_form('add_disks');
           if(formData['status'] === 200){
               $.ajax({
                   type : 'POST',
                   url : DisksPHP['addDisks'],
                   data : JSON.stringify(formData['data']),
                   dataType : 'json',
                   contentType : 'application/json',
                   beforeSend : function () {
                       $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                   },
                   success : function (data) {
                       $.messager.progress('close');
                       if(parseInt(data['status']) === 200){
                           Strack.top_message({bg:'g',msg: data['message']});
                           obj.disks_reset();
                       }else {
                           layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                       }
                   }
               });
           }
       },
       disks_modify:function () {
           var rows = $('#datagrid_box').datagrid('getSelections');
           if(rows.length <1){
               layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
           }else if(rows.length > 1){
               layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
           }else{
               modify_disks_dialog(rows[0], 'datagrid_box');
           }
       },
       disks_update:function(){
           Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', DisksPHP['modifyDisks'],{
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
       disks_delete:function () {
           Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Disks_Notice'], DisksPHP['deleteDisks'], param);
       },
       disks_reset:function(){
           $('#datagrid_box').datagrid('reload');
       }
   };


    // 初始化json脚本编辑器
    if ($("#json_editor").length > 0){
        Strack.init_json_editor('json_editor');
    }

    var param = Strack.generate_hidden_param();

    load_disks_data();

    /**
     * 加载磁盘数据
     */
    function load_disks_data() {
        $('#datagrid_box').datagrid({
            url: DisksPHP['getDisksGridData'],
            rownumbers: true,
            nowrap: true,
            fitColumns: Strack.fit_columns('.admin-dept-right', 1004),
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
                {field: 'disk_id',title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 180},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 180},
                {field: 'config', title: StrackLang['Config'], align: 'center', width: 600,
                    formatter: function(value,row,index){
                        return JSON.stringify(value);
                    }
                }
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
                modify_disks_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 修改磁盘路径设置
     * @param row
     * @param id
     */
    function modify_disks_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Disks_Modify_Title'],
            width: 480,
            height: 480,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mdisks_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mdisks_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"1",value:row['name']},
                    {case:1,id:'Mdisks_code',type:'text',lang:StrackLang['Code'],name:'code',valid:"1",value:row['code']},
                    {case:3,id:'Mdisks_config',type:'text',lang:StrackLang['Config'],name:'config',valid:"1"}
                ],
                footer:[
                    {obj:'disks_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.init_json_editor('Mdisks_config', {}, row['config']);
            },
            close:function(){
                $("#"+id).datagrid('reload');
                Strack.destroy_json_editor('Mdisks_config');
            }
        });
    }
});
