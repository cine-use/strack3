$(function(){
    obj={
        media_server_add:function(){
            var formData = Strack.validate_form('add_media_server');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : MediaServerPHP['addMediaServer'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            obj.media_server_reset();
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        media_server_modify:function(){
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_media_server_dialog(rows[0], 'datagrid_box');
            }
        },
        media_server_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', MediaServerPHP['modifyMediaServer'],{
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
        media_server_delete:function(){
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_MediaServer_Notice'], MediaServerPHP['deleteMediaServer'], param);
        },
        media_server_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    //设置输入框掩码
    $("#media_server_code").inputmask('alphaDash');

    var param = Strack.generate_hidden_param();

    load_media_server_data();

    /**
     * 加载状态数据表格
     */
    function load_media_server_data() {
        $('#datagrid_box').datagrid({
            url: MediaServerPHP['getMediaServerGridData'],
            rownumbers: true,
            nowrap: true,
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
                {field: 'media_server_id', title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Name'], align: 'center', width: 180},
                {field: 'code', title: StrackLang['Code'], align: 'center', width: 180},
                {field: 'request_url', title: StrackLang['Media_Server_Request_Address'], align: 'center', width: 360},
                {field: 'upload_url', title: StrackLang['Media_Server_Upload_Address'], align: 'center', width: 360},
                {field: 'access_key', title: StrackLang['AccessKey'], align: 'center', width: 260},
                {field: 'secret_key', title: StrackLang['SecretKey'], align: 'center', width: 260}
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
                modify_media_server_dialog(row, 'datagrid_box');
            }
        });
    }

    /**
     * 编辑状态
     * @param row
     * @param id
     */
    function modify_media_server_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Media_Server_Title'],
            width: 480,
            height: 430,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mmedia_server_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mmedia_server_name',type:'text',lang:StrackLang['Name'],name:'name',valid:'1,128',value:row['name']},
                    {case:1,id:'Mmedia_server_code',type:'text',lang:StrackLang['Code'],name:'code',valid:'1,128',value:row['code']},
                    {case:1,id:'Mmedia_server_request_url',type:'text',lang:StrackLang['Media_Server_Request_Address'],name:'request_url',valid:'1,255',value:row['request_url']},
                    {case:1,id:'Mmedia_server_upload_url',type:'text',lang:StrackLang['Media_Server_Upload_Address'],name:'upload_url',valid:'1,255',value:row['upload_url']},
                    {case:1,id:'Mmedia_server_access_key',type:'text',lang:StrackLang['AccessKey'],name:'access_key',valid:'1,128',value:row['access_key']},
                    {case:1,id:'Mmedia_server_secret_key',type:'text',lang:StrackLang['SecretKey'],name:'secret_key',valid:'1,128',value:row['secret_key']}
                ],
                footer:[
                    {obj:'media_server_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                $("#Mmedia_server_code").inputmask('alphaDash');
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});
