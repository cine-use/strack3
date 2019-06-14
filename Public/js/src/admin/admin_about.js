$(function(){
    obj = {
        //更新许可证对话框
        update_license:function () {
            Strack.open_dialog('dialog',{
                title: StrackLang['License_Update'],
                width: 480,
                height: 250,
                content: Strack.dialog_dom({
                    type: 'normal',
                    items:[
                        {case:7,id:'Mlicense',lang:StrackLang['License'],name:'license',valid:1,value:""}
                    ],
                    footer:[
                        {obj:'License_submit',type:1,title:StrackLang['Update']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                })
            });
        },
        //复制授权许可
        copy_request: function () {
            layer.msg(StrackLang["Copy_Clipboard_SC"]);
        },
        //更新许可证
        License_submit:function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val','',AboutPHP['updateLicense'],{
                back:function(data){
                    if (parseInt(data['status']) === 200) {
                        Strack.top_message({bg: 'g', msg: data['message']});
                        load_data('reload');
                        Strack.dialog_cancel();
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        //更新系统
        upgrade_system: function () {

        }
    };

    //ajax错误信息
    var clipboard;

    load_data('new');

    Strack.delete_storage('admin_menu_top');

    /**
     * 加载About页面统计数据
     */
    function load_data(mode) {
        $.ajax({
            type:'POST',
            url: AboutPHP['getSystemAbout'],
            dataType: 'json',
            success : function (data) {
                // 版本号
                $("#strack_version").html(data["package_version"]);
                // 服务器状态显示
                generate_server_status_list(data["server_list"]);
                // 服务器 license 状态
                generate_server_license_status(data["license_status"]);
                // license请求码
                if(mode === 'new'){
                    if(data["license_request"]){
                        $("#request_data").val(data["license_request"]);
                        clipboard = new Clipboard('#copy_request');
                    }else {
                        $("#copy_request").hide();
                    }
                }
            }
        });
    }

    /**
     * 生成服务器状态列表
     * @param server_list
     */
    function generate_server_status_list(server_list) {
        var dom = '';
        server_list.forEach(function (val) {
            dom += server_dom(val);
        });

        $("#server_list").empty().append(dom);
    }

    /**
     * 服务器状态Base DOM
     * @returns {string}
     */
    function server_dom(val) {
        var dom = '';
        dom +='<div class="server-sta-item aign-left '+server_status_css(val["status"])+'">'+
            '<div class="server-item-name">'+
            server_status_name(val["status"])+
            '</div>'+
            '<div class="server-item-sta">'+
            val["name"]+
            '</div>'+
            '<div class="server-item-sta">'+
            val["connect_time"]+ ' ms' +
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 服务器状态 背景颜色 css
     * @param code
     * @returns {string}
     */
    function server_status_css(code) {
        if(parseInt(code) === 200){
            return "background-success";
        }else {
            return "background-danger";
        }
    }

    /**
     * 获得状态
     */
    function server_status_name(code) {
        if(parseInt(code) === 200){
            return StrackLang['Status_OK'];
        }else {
            return StrackLang['Status_Lose'];
        }
    }
});