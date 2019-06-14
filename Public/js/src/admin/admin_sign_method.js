$(function () {
    obj = {
        // 切换ldap数据表格
        switch_ldap_item: function (i) {
            var ldap_id = $(i).attr("data-ldapid");
            var status;
            if($(i).hasClass("on")){
                $(i).removeClass("on").addClass("off");
                $(i).find("i").removeClass("icon-uniF205").addClass("icon-uniF204");
                status = "off";
            }else {
                $(i).removeClass("off").addClass("on");
                $(i).find("i").removeClass("icon-uniF204").addClass("icon-uniF205")
                status = "on";
            }
            save_ldap_setting({
                type: 'ldap_server_list',
                ldap_id: parseInt(ldap_id),
                status: status
            });
        }
    };

    var param = Strack.generate_hidden_param();

    $('#ldap_server_list').datagrid({
        url: SignMethodPHP["getLdapServerSettingList"],
        fitColumns: true,
        singleSelect: true,
        columns:[[
            {field:'id', title: StrackLang["Switch"], align: 'center', width:100, formatter: function(value,row,index) {
                    var iclass = row["ldap_switch"] === "on" ? "icon-uniF205" : "icon-uniF204";
                    if(param["rule_switch"] === "yes"){
                        return '<a href="javascript:;" class="swicth-gird-font '+row["ldap_switch"]+'" onclick="obj.switch_ldap_item(this)" data-ldapid="'+value+'"><i class="'+iclass+'"></i></a>';
                    }else {
                        return '<a href="javascript:;" class="swicth-gird-font"><i class="'+iclass+'"></i></a>';
                    }
                }},
            {field:'name', title:StrackLang["Ldap_Name"], align: 'center', width:300}
        ]],
        onLoadSuccess: function (data) {

            var open_val = 0;
            if(data["ldap_open"]){
                open_val = 1;
            }

            Strack.init_open_switch({
                dom: '#open_ldap_login',
                value: open_val,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100,
            }, function (status) {
                save_ldap_setting({
                    type: 'ldap_open',
                    status: status
                });
            });
        }
    });



    /**
     * 保存域登录服务配置
     * @param data
     */
    function save_ldap_setting(data) {
        $.ajax({
            type : 'POST',
            url : SignMethodPHP['saveLdapSetting'],
            data : JSON.stringify(data),
            dataType : 'json',
            contentType: "application/json",
            beforeSend : function () {
                $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
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
});