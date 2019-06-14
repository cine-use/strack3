$(function () {
    obj = {
        //提交保存个人偏好设置
        preference_save:function () {
            var lang = Strack.get_combos_val('#my_language','combobox','getValue'),
                timezone = Strack.get_combos_val('#my_timezone','combobox','getValue');
            if(lang.length<1){
                layer.msg( StrackLang["Please_Select_Language"], {icon: 2,time:1200,anim: 6});
            }else if(timezone.length<1){
                layer.msg( StrackLang["Please_Select_Timezone"], {icon: 2,time:1200,anim: 6});
            }else {
                $.ajax({
                    type : 'POST',
                    url: AccountPHP['saveUserPreference'],
                    dataType:"json",
                    data:{
                        lang :  lang,
                        timezone : timezone
                    },
                    beforeSend : function () {
                        $('.account-page-right').append(Strack.loading_dom("white","","mypref"));
                    },
                    success : function (data) {
                        $("#st-load_mypref").remove();

                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            //延迟刷新当前页面
                            setTimeout("location.reload()",600);
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        }
    };

    var param = Strack.generate_hidden_param();

    var disabledEdit = true;
    if(param.rule_save === "yes"){
        disabledEdit = false;
    }

    init_widget();

    /**
     * 初始化控件
     */
    function init_widget() {
        $.ajax({
            type : 'POST',
            url: AccountPHP['getUserPreference'],
            dataType:"json",
            beforeSend : function () {
                $('.account-page-right').append(Strack.loading_dom("white","","mypref"));
            },
            success : function (data) {
                $("#st-load_mypref").remove();
                //系统默认语言
                $('#my_language').combobox({
                    url:AccountPHP['getLangList'],
                    height:30,
                    width:485,
                    disabled: disabledEdit,
                    valueField:'id',
                    textField:'name',
                    value:data['lang']
                });
                //系统默认时区
                var cookie_timezone = Strack.get_cookie('think_language');
                $('#my_timezone').combobox({
                    url:AccountPHP['getTimezoneList'],
                    height:30,
                    width:485,
                    disabled: disabledEdit,
                    valueField:'val',
                    textField:'zone',
                    value:data['timezone']
                });
            }
        });
    }
});
