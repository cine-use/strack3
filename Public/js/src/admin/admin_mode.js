$(function () {
    obj = {
        save_setting: function () {
            var formData = Strack.validate_form('save_setting');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : ModePHP['saveModeConfig'],
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
        url: ModePHP['getModeConfig'],
        data: {
            options_field: 'default_mode'
        },
        dataType: 'json',
        success: function (data) {

            //系统默认语言
            $('#system_mode').combobox({
                url: ModePHP['getSystemModeList'],
                height: 30,
                width: 500,
                valueField: 'id',
                textField: 'name',
                value: data["mode"]
            });

            // 访问后台开关
            var visit_system_admin = data["visit_system_admin"]? data["visit_system_admin"] : 0;
            Strack.init_open_switch({
                dom: '#visit_system_admin',
                value: visit_system_admin,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 注册开启开关
            var open_switch_val = data["open_register"]? data["open_register"] : 0;
            Strack.init_open_switch({
                dom: '#open_register',
                value: open_switch_val,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 默认角色
            $('#default_role').combobox({
                url: ModePHP['getRoleList'],
                height: 30,
                width: 500,
                valueField: 'id',
                textField: 'name',
                value: data["default_role"]
            });

            // 克隆项目开启开关
            var open_clone_project_val = data["open_clone_project"]? data["open_clone_project"] : 0;
            Strack.init_open_switch({
                dom: '#open_clone_project',
                value: open_clone_project_val,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 是否允许创建项目
            var open_create_project = data["open_create_project"]? data["open_create_project"] : 0;
            Strack.init_open_switch({
                dom: '#open_create_project',
                value: open_create_project,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 默认拷贝项目
            $('#default_clone_project').combobox({
                url: ModePHP['getProjectList'],
                height: 30,
                width: 500,
                valueField: 'id',
                textField: 'name',
                value: data["default_clone_project"]
            });

            // 默认拷贝项目
            $('#default_project_public').combobox({
                url: StrackPHP['getPublicType'],
                height: 30,
                width: 500,
                valueField: 'id',
                textField: 'name',
                value: data["default_project_public"]
            });
        }
    });
});
