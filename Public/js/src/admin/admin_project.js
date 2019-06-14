$(function () {
    obj = {
        // 选择一个项目
        select_project: function (i) {
            var $this = $(i),
                $project_id_dom = $('#active_project_id');

            var project_id = $(i).attr("data-projectid");

            //清除提示
            if ($project_id_dom.val()>0) {
                $('.mproj-item').removeClass('templates-active');
            } else {
                $('.temp-setlist-no').hide();
                $('.admin-temp-rheader').show();
            }

            //赋值project_id
            $project_id_dom.val(project_id);

            //添加templates-active class
            $this.parent().addClass('templates-active');

            load_project_details(project_id);
        },
        // 保存项目修改
        project_save: function () {
            var formData = Strack.validate_form('modify_project');
            if(formData['status'] === 200){
                var project_id =  $('#active_project_id').val();
                formData["data"]["id"] = project_id;
                $.ajax({
                    type : 'POST',
                    url : ProjectPHP['modifyProject'],
                    data : formData['data'],
                    dataType : 'json',
                    beforeSend : function () {
                        $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            load_project_list(Gfilter);
                            load_project_details(project_id);
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        // 删除项目
        project_delete: function () {
            $.messager.confirm(StrackLang['Delete_Project_Title'], StrackLang['Delete_Project_Confirm'], function (flag) {
                if (flag) {
                    var project_id = $("#active_project_id").val();
                    $.ajax({
                        type: 'POST',
                        url: ProjectPHP['deleteProject'],
                        dataType:'json',
                        data: {
                            primary_ids: project_id
                        },
                        beforeSend: function () {
                            $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                        },
                        success: function (data) {
                            $.messager.progress('close');
                            if(parseInt(data['status']) === 200){
                                Strack.top_message({bg:'g',msg: data['message']});
                                $("#project_details").hide();
                                $('#active_project_id').val("");
                                load_project_list(Gfilter);
                            }else {
                                layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                            }
                        }
                    });
                }
            });
        },
        // 过滤项目列表
        project_filter: function (i) {
            var search_val = $("#search_val").val();
            if(search_val.length>0){
                Gfilter = {'name':['-lk', "%"+search_val+"%"]};
            }else {
                Gfilter = '';
            }
            obj.refresh_details();
            load_project_list(Gfilter);
        },
        // 刷新项目详情
        refresh_details: function () {
            $('#active_project_id').val(0);
            $('.temp-setlist-no').show();
            $('.admin-temp-rheader').hide();
            $("#project_details").hide();
        }
    };

    var Gfilter = '';

    //生成项目列表
    load_project_list(Gfilter);

    /**
     * 键盘事件
     */
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter"){
            // 按回车键搜索
            if($("#search_val").is(':focus')){
                // 搜索项目模板模块
                e.preventDefault();
                obj.project_filter(Strack.get_obj_by_id("search_project_bnt"));
            }
        }
    });

    /**
     * 加载项目列表
     * @param filter
     */
    function load_project_list(filter) {
        $.ajax({
            type: 'POST',
            url: ProjectPHP['getAdminProjectList'],
            dataType : 'json',
            data:JSON.stringify({
                filter : filter
            }),
            contentType: "application/json",
            beforeSend: function () {
                $('#project_list')
                    .empty()
                    .append(Strack.loading_dom('null'));
            },
            success: function (data) {
                var list_dom = '';
                var $project_list = $('#project_list');

                data['rows'].forEach(function (val) {
                    list_dom += project_list_dom(val);
                });
                if(list_dom){
                    $("#pactive_notice").remove();
                    $project_list.append(list_dom);
                    jumpto_active_project();
                }else {
                    if($("#pactive_notice").length === 0){
                        $project_list.before('<div id="pactive_notice" class="datagrid-empty-no">'+StrackLang["No_Filter_Project"]+'</div>');
                    }
                }

                $('#st-load').remove();
            }
        });
    }

    /**
     * 跳转到激活的项目
     */
    function jumpto_active_project() {
        var spid = $('#active_project_id').val();
        if(spid > 0){
            var $pitem = $("#mproj_item_"+spid);
            $pitem.addClass("templates-active");
            $(".admin-temp-list").scrollTop($pitem.offset().top);
        }
    }

    /**
     * 加载项目详情
     * @param project_id
     */
    function load_project_details(project_id) {
        var module_id = 20;
        $.ajax({
            type: 'POST',
            url: ProjectPHP['getProjectDetails'],
            dataType: 'json',
            data: {
                project_id: project_id,
                module_id: module_id
            },
            beforeSend: function () {
                $(".admin-temp-right").prepend(Strack.loading_dom('white'));
            },
            success: function (data) {

                // 生成缩略图
                var media_data = data['media_data'];
                media_data['link_id'] = project_id;
                media_data['module_id'] = module_id;
                media_data['param']['icon'] = "icon-uniE61A";
                Strack.thumb_media_widget('#project_thumb', media_data, {modify_thumb: "yes", clear_thumb: "yes"});

                // 填充数据
                $("#project_name").val(data['name']);
                $("#project_code").val(data['code']);
                $("#project_rate").val(data['rate']);
                $("#project_description").val(data['description']);

                Strack.combobox_widget('#project_status', {
                    url: StrackPHP["getProjectStatusCombobox"],
                    valueField: 'id',
                    textField: 'name',
                    width: 494,
                    height: 39,
                    value: data['status_id'],
                    queryParams: {template_id: data["template_id"]}
                });

                Strack.open_date_box('#project_start', 494, 39, data['start_time']);
                Strack.open_date_box('#project_end', 494, 39, data['end_time']);


                $("#project_details").show();

                $('#st-load').remove();

            }
        });
    }

    /**
     * 后台项目列表
     * @param data
     * @returns {string}
     */
    function project_list_dom(data) {
        var projdom = '';
        projdom += '<div id="mproj_item_'+data["id"]+'" class="item mproj-item">' +
            '<a href="javascript:;" class="header" onclick="obj.select_project(this);" data-projectid="' + data["id"] + '">'+
                Strack.build_thumb_dom(data["thumb"], "icon-uniF1ED")+
            '<div class="mproj-content text-ellipsis">'+
            data["name"]+
            '</div>'+
            '</a>'+
            '</div>';
        return projdom;
    }
});
