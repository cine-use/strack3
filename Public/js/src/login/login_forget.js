/**
 * Login.js
 */
window.onload=function() {
    obj = {
        // 请求修改密码
        login_forget_request : function (i) {
            var forget_param = {};
            $("#forgot_form").find("input").each(function () {
                var val = $(this).val();
                if(!val){
                    layer.tips($(this).attr("data-notice"), this, {
                        tips: [2, '#FF4949'],
                        time: 1000
                    });
                    forget_param = {};
                    return false;
                }else {
                    forget_param[$(this).attr("name")] = val;
                }
            });

            if(!$.isEmptyObject(forget_param)){
                get_login_forget_request(forget_param);
            }
        }
    };

    // 验证浏览器版本是否合乎要求
    Strack_Check.check_browser_version(
        function () {

        }
    );

    /**
     * 获取找回密码请求地址
     * @param forget_param
     */
    function get_login_forget_request(forget_param){
        $.ajax({
            type : 'POST',
            url : LoginPHP['getForgetLoginRequest'],
            data : forget_param,
            dataType:'json',
            success : function (data) {
                if (parseInt(data['status']) === 200) {
                    // 获取找回密码请求地址成功
                    layer.msg(data["message"], {icon: 1, time: 10000, anim: 6});
                } else {
                    Strack_Check.login_top_notice('.login-flash-error', data["message"]);
                }
            }
        });
    }
};