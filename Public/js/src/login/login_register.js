/**
 * Login.js
 */
window.onload = function () {
    obj = {
        // 发送验证短信
        send_sms: function (i) {
            var send_sms_param = {};
            if(send_status === "resend"){
                $("#input_system_verify_code")
                    .attr("disabled", false)
                    .attr("status", 'new')
                    .val("");
                refresh_verify_code();
                send_status = 'new';
            }else {
                $("#register_form").find("input").each(function () {
                    var val = $(this).val();
                    var name = $(this).attr("name");
                    if (!val && $.inArray(name, ["login_name", "phone", "system_verify_code"]) >= 0) {
                        layer.tips($(this).attr("data-notice"), this, {
                            tips: [2, '#FF4949'],
                            time: 1000
                        });
                        send_sms_param = {};
                        return false;
                    } else {
                        send_sms_param[name] = val;
                    }
                });

                if (!$.isEmptyObject(send_sms_param)) {
                    $.ajax({
                        type: 'POST',
                        url: LoginPHP['sendSMS'],
                        dataType: 'json',
                        data: send_sms_param,
                        beforeSend: function () {
                            layer.load(1, {shade: [0.5, '#fff']});
                        },
                        success: function (data) {
                            layer.closeAll();
                            if (parseInt(data['status']) === 200) {
                                // 成功发送验证码
                                layer.msg(data["message"], {icon: 1, time: 3000, anim: 6});
                                count_down_timer(60);
                                disable_input(["login_name", "cell_phone", "system_verify_code"]);
                                $("#register_batch").val(data['data']["batch"]);
                                $("#register_sms_id").val(data['data']["sms_id"]);
                            } else {
                                refresh_verify_code();
                                Strack_Check.login_top_notice('.login-flash-error', data["message"]);
                            }
                        }
                    });
                }
            }
        },
        // 注册用户
        register_submit: function (i) {
            var register_param = {};
            var batch = $("#register_batch").val();
            var sms_id = $("#register_sms_id").val();
            if(!batch){
                Strack_Check.login_top_notice('.login-flash-error', StrackLang["Verify_SMS_First"]);
            }else {
                $("#register_form").find("input").each(function () {
                    var val = $(this).val();
                    var name = $(this).attr("name");
                    if (!val) {
                        layer.tips($(this).attr("data-notice"), this, {
                            tips: [2, '#FF4949'],
                            time: 1000
                        });
                        register_param = {};
                        return false;
                    } else {
                        register_param[name] = val;
                    }
                });
                if (!$.isEmptyObject(register_param)) {
                    register_param["batch"] = batch;
                    register_param["sms_id"] = sms_id;
                    $.ajax({
                        type: 'POST',
                        url: LoginPHP['registerUser'],
                        dataType: 'json',
                        data: register_param,
                        beforeSend: function () {
                            layer.load(1, {shade: [0.5, '#fff']});
                        },
                        success: function (data) {
                            layer.closeAll();
                            if (parseInt(data['status']) === 200) {
                                //goto login index
                                location.href = LoginPHP['LoginPage'];
                            } else {
                                Strack_Check.login_top_notice('.login-flash-error', data["message"]);
                            }
                        }
                    });
                }
            }
        }
    };

    // 验证浏览器版本是否合乎要求
    var send_status = 'new';
    Strack_Check.check_browser_version(
        function () {
            // 检测浏览器刷新
            check_browser_refresh();

            // 刷新验证码
            $("#change_verify_code").on('click', function () {
                refresh_verify_code();
            });
        }
    );

    /**
     * 刷新验证码
     */
    function refresh_verify_code() {
        $("#change_verify_code").attr('src', LoginPHP["verifyCodeUrl"] + "?random=" + Math.random());
    }

    /**
     * 使指定的input不可用
     * @param list
     */
    function disable_input(list) {
        list.forEach(function (val) {
            $("#input_" + val).attr("disabled", true);
        });
    }

    /**
     * 倒计时
     */
    function count_down_timer(time) {
        $("#resend_sms_notice").show();
        $("#send_sms_bnt").hide()
            .html(StrackLang["Resend_SMS"]);

        send_status = 'resend';

        var count_down = setInterval(function () {
            time--;
            if (time === 0) {
                //修改密码有效期结束
                clearInterval(count_down);
                // 显示短信发送按钮
                $("#resend_sms_notice").hide();
                $("#send_sms_bnt").show();
                $("#resend_timer").html("60S");
            } else {
                $('#resend_timer').html(time + 'S');
            }
        }, 1000);
    }

    function check_browser_refresh() {
        window.onbeforeunload=function(e){
            return "离开";
        }
        window.onunload=function(){
            alert("离开")
        }
        window.onload=function(){
            alert("加载完成");
        }
    }
};