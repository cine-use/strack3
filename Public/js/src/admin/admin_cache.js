$(function () {
    obj = {
        //清除系统缓存
        clear_system_cache:function () {
            $.ajax({
                type :'POST',
                url :CachePHP['clearSystemCache'],
                dataType:"json",
                beforeSend:function(){
                    $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                },
                success:function(data){
                    load_cache_statistics('old');
                    $.messager.progress('close');
                    Strack.top_message({bg:'g',msg:data['message']});
                }
            });
        },
        //清空系统日志
        clear_system_logs_cache: function () {
            $.ajax({
                type :'POST',
                url :CachePHP['clearSystemLogsCache'],
                dataType:"json",
                beforeSend:function(){
                    $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                },
                success:function(data){
                    load_cache_statistics('old');
                    $.messager.progress('close');
                    Strack.top_message({bg:'g',msg:data['message']});
                }
            });
        },
        //清除
        clear_upload_temp_cache:function () {
            $.ajax({
                type :'POST',
                url :CachePHP['clearUploadsTempCache'],
                dataType:"json",
                beforeSend:function(){
                    $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                },
                success:function(data){
                    load_cache_statistics('old');
                    $.messager.progress('close');
                    Strack.top_message({bg:'g',msg:data['message']});
                }
            });
        }
    };

    load_cache_statistics('new');


    /**
     * 获取磁盘缓存数据
     */
    function load_cache_statistics(mode) {
        $.ajax({
            type :'POST',
            url :CachePHP['getCacheStatistics'],
            dataType:"json",
            beforeSend:function(){
                $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
            },
            success:function(data){

                // 磁盘进度条
                if(mode === 'new'){
                    $('#sys_disk').progressbar({
                        value: data['disk_info']['percent']
                    });
                }else {
                    $('#sys_disk').progressbar("setValue", data['disk_info']["percent"]);
                }

                fill_html_data(data);

                $.messager.progress('close');
            }
        })
    }

    /**
     * 填充缓存数据
     * @param data
     */
    function fill_html_data(data) {
        var total_disk = parseInt(data['disk_info']["percent"]),
            free_disk_color = "";
        if(total_disk<50){
            free_disk_color = "disk-warn-normal";
        }else if(50<=total_disk<90){
            free_disk_color = "disk-warn-notice";
        }else{
            free_disk_color = "disk-warn-crisis";
        }
        $("#disk_total").html(data['disk_info']["total"]);
        $("#disk_free").html(data['disk_info']["free"]).addClass(free_disk_color);

        $("#sys_cache").html(data["system_cache"]);
        $("#logs_cache").html(data["system_log"]);
        $("#upload_cache").html(data["upload_temp"]);
    }
});