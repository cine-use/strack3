$(function(){
    obj={
        log_server_update:function(){
            var formData = Strack.validate_form('log_setting');
            if(parseInt(formData['status']) === 200){
                $.ajax({
                    type : 'POST',
                    url : LogServerPHP['updateLogServerConfig'],
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
        url: LogServerPHP['getLogServerConfig'],
        dataType: 'json',
        success: function (data) {
            for(var key in data){
                $('#set_'+key).val(data[key]);
            }
        }
    });
});
