/**
 * Login.js
 */
window.onload=function() {
    obj = {
        // 重置用户密码
        reset_password : function (i) {
            var reset_param = {};
            $("#reset_password_form").find("input").each(function () {
                var val = $(this).val();
                if(!val){
                    layer.tips($(this).attr("data-notice"), this, {
                        tips: [2, '#FF4949'],
                        time: 1000
                    });
                    reset_param = {};
                    return false;
                }else {
                    reset_param[$(this).attr("name")] = val;
                }
            });

            if(!$.isEmptyObject(reset_param) && reset_param["new_password"] === reset_param["confirm_password"] ){
                // 提交修改
                reset_param["user_id"] = $("#user_id").val();
                reset_user_password(reset_param);
            }else {
                // 两次输入密码不匹配
                Strack_Check.login_top_notice('.login-flash-error', StrackLang["Two_Password_Mismatches"]);
            }
        }
    };

    // 验证浏览器版本是否合乎要求
    Strack_Check.check_browser_version(
        function () {
            var expiration_date = parseInt($("#expiration_date").val());
            var expiration = setInterval(function(){
                expiration_date--;
                if(expiration_date === 0){
                    //修改密码有效期结束
                    clearInterval(expiration);
                    // 刷新当前页面
                    window.location.reload();
                }else{
                    $('#forgot_showtime').html(Strack_Check.time_format(expiration_date));
                }
            },1000);
        }
    );
    
    function reset_user_password(reset_param) {
        $.ajax({
            type : 'POST',
            url : resetpassPHP['modifyUserPassword'],
            data : reset_param,
            dataType:'json',
            success : function (data) {
                if (parseInt(data['status']) === 200) {
                    // 修改密码成功跳转到登录页面
                    layer.msg(data['message'], {
                        icon: 1
                        ,shade: 0.2
                        ,time:1000
                    }, function(){
                        location.href= StrackLogin['LOGIN_INDEX'];
                    });
                } else {
                    Strack_Check.login_top_notice('.login-flash-error', data["message"]);
                }
            }
        });
    }
};