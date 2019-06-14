$(function () {
    obj = {
        // 保存登录二次验证配置
        security_save: function (i) {
            var mfa = Strack.get_switch_val('#open_mfa');
            $.ajax({
                type : 'POST',
                url: AccountPHP['saveUserSecurity'],
                dataType:"json",
                data:{
                    mfa :  mfa
                },
                beforeSend : function () {
                    $('.account-page-right').append(Strack.loading_dom("white","","mypref"));
                },
                success : function (data) {
                    $("#st-load_mypref").remove();

                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
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
            url: AccountPHP['getUserSecurity'],
            dataType:"json",
            beforeSend : function () {
                $('.account-page-right').append(Strack.loading_dom("white","","mypref"));
            },
            success : function (data) {
                $("#st-load_mypref").remove();

                $("#qrcode_url").empty()
                    .append('<img src="'+data["qrcode_url"]+'">');

                //系统默认时区
                var open_mfa_verify = data["mfa"]=== "yes" ? 1 : 0;
                Strack.init_open_switch({
                    dom: '#open_mfa',
                    value: open_mfa_verify,
                    disable: disabledEdit,
                    onText: StrackLang['Switch_ON'],
                    offText: StrackLang['Switch_OFF'],
                    width: 100
                });
            }
        });
    }
});