$(function(){
    obj={
        cloud_disk_update:function(){
            var formData = Strack.validate_form('cloud_disk_setting');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : CloudDiskPHP['updateCloudDiskConfig'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        }
    };

    //ajax获取默认设置参数
    $.ajax({
        type: 'POST',
        url: CloudDiskPHP['getCloudDiskConfig'],
        dataType: 'json',
        success: function (data) {

            // 邮件开启开关
            var open_cloud_disk = data["open_cloud_disk"]? data["open_cloud_disk"] : 0;
            Strack.init_open_switch({
                dom: '#open_cloud_disk',
                value: open_cloud_disk,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            for(var key in data){
                if(key !== "open_cloud_disk"){
                    $('#set_'+key).val(data[key]);
                }
            }
        }
    });
});
