$(function(){
    obj={
        save_config:function(){
            var formData = Strack.validate_form('add_email');
            if(formData['status'] === 200){
                $.ajax({
                    type : 'POST',
                    url : EmailPHP['saveEmailSetting'],
                    data : formData['data'],
                    dataType : 'json',
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
        },
        //发送测试邮件
        send_test_email:function () {
            var email_content = $("#test_email").val(),
                email_account = $("#test_account").val();
            if(email_content.length===0){
                layer.msg( StrackLang['Email_Test_Content_Null'], {icon: 2,time:1200,anim: 6});
            }else if(email_account.length===0){
                layer.msg( StrackLang['Email_Test_Account'], {icon: 2,time:1200,anim: 6});
            }else {
                $.ajax({
                    type :'POST',
                    url :EmailPHP['testSendEmail'],
                    dataType:'json',
                    data :{
                        email_content:email_content,
                        email_account:email_account
                    },
                    beforeSend:function(){
                        $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                    },
                    success:function(data){
                        $.messager.progress('close');
                        var dom = '';
                        dom += '<p style="font-weight: 600;color: #FF4949">' +
                            StrackLang["Sending_Results"]+': '+data['message']+'' +
                            '</p>';
                        $("#test_email_result").empty().append(dom);
                    }
                });
            }
        }
    };




    //AJAX填充数据
    $.ajax({
        type:'POST',
        url:EmailPHP['getEmailSetting'],
        dataType : "json",
        success:function(data){
            
            // 邮件开启开关
            var open_switch_val = data["open_email"]? data["open_email"] : 0;
            Strack.init_open_switch({
                dom: '#email_open',
                value: open_switch_val,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 开启邮件加密链接发送
            var open_smtp_auth = data["open_security"]? data["open_security"] : 0;
            Strack.init_open_switch({
                dom: '#email_open_security',
                value: open_smtp_auth,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 邮件加密方式
            var smtp_secure = data["smtp_secure"]? data["smtp_secure"] : '';
            Strack.combobox_widget('#email_smtp_secure', {
                url: StrackPHP["getSmtpSecureList"],
                valueField: 'id',
                textField: 'name',
                width: 300,
                height: 30,
                value: smtp_secure
            });

            $('#email_charset').val(data['charset']);
            $('#email_server').val(data['server']);
            $('#email_port').val(data['port']).inputmask('9{1,6}');
            $('#email_user').val(data['username']).inputmask('email');
            $('#email_pass').val(data['password']);
            $('#email_addresser_name').val(data['addresser_name']);

        }
    });
});
