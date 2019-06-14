$(function(){
    obj ={
        //登录后台
        admin_login:function () {
            var password = $("#admin_pass").val();
            if(password.length<1){
                layer.msg( ADLoginPHP['Input_Login_Password'], {icon: 2,time:1200,anim: 6});
            }else {
                $.ajax({
                    type:'POST',
                    url: ADLoginPHP['LoginAdmin'],
                    dataType:'json',
                    data:{
                        password:password
                    },
                    beforeSend:function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if (parseInt(data['status']) === 200) {
                            window.location.reload();
                        } else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        }
    };

    Strack.delete_storage('admin_menu_top');

    $(document).keydown(function(e){
        if(e.keyCode === 13){
            //阻止浏览器默认动作
            e.preventDefault();
            obj.admin_login();
        }
    });

});
