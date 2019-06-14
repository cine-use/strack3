$(function () {
    obj = {
        // 修改用户账户信息
        modify_my_account: function () {
            var allow_up = false;
            var formData = Strack.validate_form('modify_account');

            if (formData["status"] === 200 && formData["status"]["old_password"]) {
                if(formData["data"]["new_password"].length >0 && formData["data"]["new_password_repeat"].length>0 && formData["data"]["new_password"] === formData["data"]["new_password_repeat"]){
                    allow_up = true;
                }else {
                    layer.msg(StrackLang['Reset_User_Password_Confirm'], {icon: 2, time: 1200, anim: 6});
                }
            } else {
                allow_up = true;
            }


            if(allow_up){
                if(formData['status'] === 200){
                    $.ajax({
                        type : 'POST',
                        url : AccountPHP['modifyMyAccount'],
                        data : formData['data'],
                        dataType : 'json',
                        beforeSend : function () {
                            $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                        },
                        success : function (data) {
                            $.messager.progress('close');
                            if(parseInt(data['status']) === 200){
                                Strack.top_message({bg:'g',msg: data['message']});
                                obj.account_reset();
                            }else {
                                layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                            }
                        }
                    });
                }
            }
        },
        account_reset : function () {
            $ac_hide.addClass('display-hide');
            $('input[name=old_password]').val("");
            $('input[name=new_password]').val("");
            $('input[name=new_password_repeat]').val("");
        }
    };

    var param = Strack.generate_hidden_param();
    var $ac_avatar = $('.ac-my-avatar'),
        $ac_myhover = $('.account-my-hover'),
        $ac_hide = $('.account-my-savebnt'),
        $loadwrap = $('.account-my-bottom'),
        Guser_data;

    load_my_account_data();
    avatr_event();

    /**
     * 加载当前用户信息
     */
    function load_my_account_data() {
        $.ajax({
            type: 'POST',
            url: AccountPHP["getMyAccountData"],
            dataType: 'json',
            beforeSend: function () {
                $loadwrap.prepend(Strack.loading_dom('white', '', 'acc'));
            },
            success: function (data) {

                Guser_data = data;

                //填充头像
                $('#ac_my_avatar').empty()
                    .append(Strack.build_avatar( data["id"], data["avatar"], Strack.upper_first_str(data["pinyin"])));

                //填充数据
                $('#my_user_login').val(data["login_name"]);
                $('#my_user_name').val(data["name"]);
                $('#my_user_nick_name').val(data["nickname"]);
                $('#my_user_email').val(data["email"]);
                $('#my_user_phone').val(data["phone"]);

                $('#st-load_acc').remove();
            }
        });
    }


    /**
     * 头像DOM事件
     */
    function avatr_event() {
        if(param.rule_save === "yes"){
            $('.myacinput').on('input', function () {
                if ($ac_hide.hasClass('display-hide')) {
                    $ac_hide.removeClass('display-hide');
                }
            });
        }

        if(param.rule_modify_thumb  === "yes"){
            $ac_myhover.mouseenter(function () {
                $ac_avatar.addClass("img-blur");
            }).mouseleave(function () {
                $ac_avatar.removeClass("img-blur");
            });
        }
    }
});