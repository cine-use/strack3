$(function () {
    obj = {
        save_setting: function () {
            var formData = Strack.validate_form('save_setting');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : SettingsPHP['updateDefaultSetting'],
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
        url: SettingsPHP['getDefaultOptions'],
        data: {
            options_field: 'default_settings'
        },
        dataType: 'json',
        success: function (data) {

            //系统默认语言
            $('#set_default_lang').combobox({
                url: SettingsPHP['getLangList'],
                height: 30,
                width: 500,
                valueField: 'id',
                textField: 'name',
                value: data['default_lang']
            });

            //系统默认时区
            $('#set_default_timezone').combobox({
                url: SettingsPHP['getTimezoneData'],
                height: 30,
                width: 500,
                valueField: 'val',
                textField: 'zone',
                value: data['default_timezone']
            });

            $('#set_email').val(data['default_emailsuffix']);
            $('#set_password').inputmask('*{8,96}').val(data['default_password']);
            $('#set_beian_number').val(data['default_beian_number']);

            // 访问后台开关
            var open_mfa_verify = data["open_mfa_verify"]? data["open_mfa_verify"] : 0;
            Strack.init_open_switch({
                dom: '#open_mfa_verify',
                value: open_mfa_verify,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });
        }
    });
});
