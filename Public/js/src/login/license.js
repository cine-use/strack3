$(function () {
    obj={
        submit:function () {
            var lic_content = $("#lic_text").val();
            if(lic_content.length===0){
                layer.msg( StrackLang['Please_Input_License'], {icon: 2,time:2000,anim: 6});
            }else {
                $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : ErrorPHP['validationLicense'],
                    data:{
                        license: lic_content
                    },
                    beforeSend : function () {
                        layer.load(1, {shade: [0.5,'#fff'] });
                    },
                    success : function (data) {
                        layer.closeAll();
                        if(parseInt(data["status"]) === 200){
                            layer.msg(data['message'], {
                                icon: 1
                                ,shade: 0.01
                                ,time:2000
                            }, function(){
                                location.href=ErrorPHP['login_page'];
                            });
                        }else {
                            if(parseInt(data["status"]) === 208004) {
                                // 用户数量超量
                                $("#adjust_active_user").show();
                                cancel_current_number = parseInt(data["data"]['current_number']) - parseInt(data["data"]['license_number']);
                                $("#cancel_current_user_number span").html(data["data"]['current_number']);
                                $("#cancel_lic_user_number span").html(cancel_current_number);
                            }
                            layer.msg( data['message'], {icon: 2,time:2000, anim: 6});
                        }
                    }
                });
            }
        },
        // 下载许可申请文件
        download_file: function () {
            window.open(ErrorPHP['getRequestFile']);
        }
    };

    var cancel_current_number = 0;

    //系统激活请求
    get_request_data();

    load_user_datagrid();

    /**
     * 获取激活请求数据
     */
    function get_request_data() {
        $.ajax({
            type : 'POST',
            dataType : 'json',
            url : ErrorPHP['getLicenseRequestData'],
            beforeSend : function () {
                layer.load(1, {shade: [0.5,'#fff'] });
            },
            success : function (data) {
                var $lic_request = $("#lic_request");
                if(parseInt(data.length) === 0){
                    $lic_request.empty().append(StrackLang["No_Authorized_History"]);
                }else {
                    $("#old_lic_user_number span").html(data['user_number']);
                    $("#old_lic_expire_date span").html(data['expiry_date']);
                    $("#old_lic_expire_days span").html(Math.abs(data['expiry_days']));
                }
                layer.closeAll();
            }
        });
    }

    /**
     * 加载状态数据表格
     */
    function load_user_datagrid() {
        $("#datagrid_box").dataTable({
            check: true,
            pageCapacity: 0,
            loading: true,
            serial: false,
            method: "POST",
            url: ErrorPHP['getActiveUserGridData'],
            style: {"font-size": "12px", "width": "100%"},
            align:"center",
            ButtonStyle:{fontColor:"#ffffff",backgroundColor:"#1890ff"},
            columns: [
                {title: StrackLang["Cancel_User"], button: "del", buttonName: StrackLang["Cancel_User"], width: 50},
                {ColumnName: "id", title: StrackLang["ID"], width: 30},
                {ColumnName: "login_name", title: StrackLang["Login_Name"], width: 300},
                {ColumnName: "name", title: StrackLang["User_Name"], width: 300},
                {ColumnName: "nickname", title: StrackLang["Nickname"], width: 300}
            ],
            delClick: function (i, row) {
                cancel_account(i, row.id);
            }
        });
    }

    /**
     * 注销用户
     * @param i
     * @param user_id
     */
    function cancel_account(i, user_id) {
        $.ajax({
            type: 'POST',
            url: ErrorPHP['cancelAccount'],
            data: {
                user_id: user_id
            },
            dataType: 'json',
            beforeSend: function () {
                layer.load(1, {shade: [0.5,'#fff'] });
            },
            success: function (data) {
                cancel_current_number--;
                $("#cancel_lic_user_number span").html(cancel_current_number);
                $(i).closest("tr").remove();
                if(cancel_current_number === 0){
                    obj.submit();
                }
                layer.closeAll();
            }
        });
    }
});
