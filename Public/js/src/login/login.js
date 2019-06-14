/**
 * Login.js
 */
window.onload=function() {

    obj = {
        //登录验证
        login_verify : function () {
            var login_param = {};
            $("#login_form").find("input").each(function () {
                var val = $(this).val();
                if(!val){
                    layer.tips($(this).attr("data-notice"), this, {
                        tips: [2, '#FF4949'],
                        time: 1000
                    });
                    login_param = {};
                    return false;
                }else {
                    login_param[$(this).attr("name")] = val;
                }
            });

            if(!$.isEmptyObject(login_param)){
                login_param["from"] = "web";
                login_param["method"] = "";
                verify_login(login_param);
            }
        },
        // 使用域用户登录
        login_with_ldap : function (i) {
            var $wrap = $(".login-third-party");
            $wrap.show();
            // 1、首先查找是否打开了客户端，直接自动判断登录
            // 2、没有则请用户输入域账号密码登录

        },
        // 返回登录窗
        back_to_login : function (i) {
            // 判断是否选择了第三方登录服务器
            check_select_server();
            $(".login-third-party").hide();
        },
        // 选择服务
        select_server : function (i) {
            $(".server-wrap").removeClass("active");
            var $parent = $(i).parent();
            $parent.addClass("active");
        },
        // 取消选择域服务器登录
        close_login_server: function (i) {
            $(".server-wrap").removeClass("active");
            $(".login-server-show").hide();
            Glogin_Server = {};
        }
    };


    var Glogin_Server = {};

    // 验证浏览器版本是否合乎要求
    Strack_Check.check_browser_version(
        function () {
            // 加载第三方服务
            get_third_server();

            // 按回车键登录
            $(document).keydown(function(e){
                if(e.keyCode === 13){
                    //阻止浏览器默认动作
                    e.preventDefault();
                    obj.login_verify();
                }
            });
        }
    );


    /**
     * 验证登录信息
     * @param login_param
     */
    function verify_login(login_param) {
        if(!$.isEmptyObject(Glogin_Server)){
            login_param["method"] = Glogin_Server["type"];
            login_param["server_id"] = Glogin_Server["id"];
        }
        $.ajax({
            type : 'POST',
            url : LoginPHP['verifyLogin'],
            dataType:'json',
            data : login_param,
            success : function (data) {
                if (parseInt(data['status']) === 200) {
                    if (data["url"]) {
                        location.href = data["url"];
                    } else {
                        //goto home index
                        location.href = StrackLogin['INDEX'];
                    }
                } else {
                    Strack_Check.login_top_notice('.login-error-show', data["message"]);
                }
            }
        });
    }

    /**
     * 获取第三方服务列表
     */
    function get_third_server() {
        $.ajax({
            type : 'POST',
            url : LoginPHP['getThirdServerList'],
            dataType : 'json',
            success : function (data) {
                if(data["third_server_status"] === "on"){
                    $("#third_party_open").show();
                    // 填充third server dom
                    var count = 0;
                    var list_dom = '';
                    var iem_dom = '';
                    data["third_server_list"].forEach(function (val, index) {
                        // 每5个组成一行
                        count ++;
                        if(count === 5){
                            count = 0;
                            list_dom += server_row_dom(iem_dom);
                            iem_dom = '';
                        }else {
                            iem_dom += server_item_dom(val);
                        }

                        // 结尾
                        if(count !== 6 && parseInt(data["third_server_total"]) === index+1){
                            list_dom += server_row_dom(iem_dom);
                            iem_dom = '';
                        }
                    });

                    $('.third-party-list').empty().append(list_dom);
                }
            }
        });
    }

    /**
     * 判断获取是否选择了第三方服务器
     */
    function check_select_server() {
        var $active_server = $(".server-wrap.active");
        if($active_server.length > 0){
            var $core = $active_server.find(".server-core");
            Glogin_Server = {
                id : $core.attr("data-id"),
                type : $core.attr("data-type"),
                name : $core.attr("data-name")
            };
            $(".login-server-name").html(Glogin_Server["name"]);
            $(".login-server-show").show();
        }
    }

    /**
     * 登录第三方服务 Row DOM
     * @param item_dom
     * @returns {string}
     */
    function server_row_dom(item_dom) {
        var dom = '';
        dom += '<div class="third-party-row">'+item_dom+'</div>';
        return dom;
    }

    /**
     * 登录第三方服务 Item DOM
     * @param param
     * @returns {string}
     */
    function server_item_dom(param) {
        var dom = '';
        dom += '<div class="third-party-item">'+
            '<div class="server-wrap">'+
            '<a href="javascript:;" class="server-core" onclick="obj.select_server(this)" data-type="'+param["type"]+'" data-id="'+param["id"]+'" data-name="'+param["name"]+'">'+
            '<div class="server-name-wrap">'+
            '<p class="server-name">'+
            param["name"]+
            '</p>'+
            '</div>'+
            '</a>'+
            '</div>'+
            '</div>';
        return dom;
    }
};
