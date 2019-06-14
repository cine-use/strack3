$(function(){
    obj={
        rebuild_all:function(){
            $.messager.confirm(StrackPHP['Confirmation_Box'], ApikeyPHP['Rebuild_All_Confirm'], function(flag) {
                if (flag) {
                    $.ajax({
                        type:'POST',
                        url:ApikeyPHP['rebuildApikey'],
                        beforeSend : function () {
                            $.messager.progress({title: StrackPHP['Waiting'], msg: StrackPHP['loading']});
                        },
                        success : function (data) {
                            $.messager.progress('close');
                            if(parseInt(data['status']) == 200){
                                $('#datagrid_box').datagrid("reload");
                                Strack.top_message({bg:'g',msg: data['message']});
                            }else {
                                layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                            }
                        }
                    })
                }
            });
        }
    };

    $('#datagrid_box').datagrid({
        url:ApikeyPHP['getApikeyData'],
        height: Strack.panel_height('.admin-content-account',76),
        differhigh:true,
        rowheight:30,
        striped:true,
        adaptive:{
            dom:'.admin-content-account',
            min_width:360,
            exth:0
        },
        columns: [[
            {field: 'apikey_id', checkbox: true},
            {field: 'id', title: StrackPHP['ID'], align: 'center',width: 160,
                formatter: function(value,row,index){
                    return row["apikey_id"];
                }
            },
            {field: 'user_name', title:StrackPHP['FullName'], align: 'center', width: 360},
            {field: 'seckey', title: ApikeyPHP['Api_seckey'], align: 'center',width: 600}
        ]],
        toolbar: '#tb',
        pagination: true,
        pageSize: 200,
        pageList: [200, 400],
        pageNumber: 1,
        pagePosition: 'bottom',
        remoteSort: false
    });
});