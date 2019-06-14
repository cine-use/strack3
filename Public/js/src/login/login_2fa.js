/**
 * Login.js
 */
window.onload=function() {
    obj = {
        // 提交2fa验证
        submit_2fa_code : function (i) {
            var verify_param = {};
            $("#verify_form").find("input").each(function () {
                var val = $(this).val();
                if(!val){
                    layer.tips($(this).attr("data-notice"), this, {
                        tips: [2, '#FF4949'],
                        time: 1000
                    });
                    verify_param = {};
                    return false;
                }else {
                    verify_param[$(this).attr("name")] = val;
                }
            });

            if(!$.isEmptyObject(verify_param)){
                verify_2fa_code(verify_param);
            }
        },
        // 注销返回登录页面
        back_login_page: function (i) {
            $.ajax({
                type : 'POST',
                url : LoginPHP['backToLoginPage'],
                success : function (data) {
                    location.href = StrackLogin['LOGIN_INDEX'];
                }
            });
        }
    };

    // 验证浏览器版本是否合乎要求
    Strack_Check.check_browser_version(
        function () {

        }
    );


    /**
     * 验证二次验证码
     * @param verify_param
     */
    function verify_2fa_code(verify_param){
        $.ajax({
            type : 'POST',
            url : LoginPHP['verify2faCode'],
            data : verify_param,
            dataType:'json',
            success : function (data) {
                if (parseInt(data['status']) === 200) {
                    //goto home index
                    location.href = StrackLogin['INDEX'];
                } else {
                    Strack_Check.login_top_notice('.login-flash-error', data["message"]);
                }
            }
        });
    }
};