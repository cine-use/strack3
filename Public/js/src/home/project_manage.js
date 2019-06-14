$(function () {
    obj = {
        // 搜索项目
        search_project : function (i) {
            Gfilter["name"] = $("#proj_search_box").val();
            load_project_list(Gfilter);
        },
        // 切换分组
        click_down_item: function (i) {
            var from = $(i).attr("from");
            var options = $(i).attr("options");
            Strack.toggle_item_icon(i, from);
            if(options !== "all"){
                switch (from){
                    case "project_status":
                        Gfilter["project_status"] = [];
                        $("#project_toolbar_status")
                            .find(".view-g-item")
                            .each(function () {
                                if($(this).find("i").hasClass("icon-checked")){
                                    Gfilter["project_status"].push($(this).attr("options"));
                                }
                            });
                        break;
                    case "project_time":
                        Gfilter["project_time"] = options;
                        break;
                }
            }else {
                Gfilter["project_status"] = [];
                Gfilter["project_time"] = "";
            }

            load_project_list(Gfilter);
        },
        // 显示隐藏项目分组
        toggle_group: function (i) {
            var group_id = $(i).attr("data-groupid");
            var $group = $("#proj_group_"+group_id);
            if($group.hasClass("hidden")){
                $group.show().removeClass("hidden");
                $(i).find("i").removeClass("down").addClass("up");
            }else {
                $group.hide().addClass("hidden");
                $(i).find("i").removeClass("up").addClass("down");
            }
        }
    };

    var Gfilter = {
        "project_status" : [],
        "project_time" : "",
        "name" : ""
    };

    init_project_toolbar();
    load_project_list(Gfilter);

    // 按回车键查询
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter") {
            // 按回车键搜索
            if(true === $("#proj_search_box").is(":focus")){
                e.preventDefault();
                obj.search_project();
            }
        }
    });

    /**
     * 加载项目列表
     */
    function load_project_list(filter)
    {
        var $project_main = $('.add-project-main');
        var $project_list = $("#project_list");
        $.ajax({
            type: "POST",
            url: ProjectPHP['getProjectList'],
            dataType: "json",
            contentType: "application/json",
            data:JSON.stringify(filter),
            beforeSend: function () {
                $project_main.append(Strack.loading_dom("white", "", "project")).css("overflow", "hidden");
            },
            success: function (data) {
                $("#st-load_project").remove();
                $project_main.css("overflow", "auto");

                var count = 0;
                var list_dom = '';
                var iem_dom = '';
                data["rows"].forEach(function (val, index) {
                    //
                    count ++;
                    if(count === 6){
                        count = 0;
                        iem_dom += project_card_dom(val);
                        list_dom += project_row_dom(iem_dom);
                        iem_dom = '';
                    }else {
                        iem_dom += project_card_dom(val);
                    }

                    // 结尾
                    if(count !== 6 && parseInt(data["total"]) === index+1){
                        list_dom += project_row_dom(iem_dom);
                        iem_dom = '';
                    }
                });

                if(!list_dom){
                    $project_list.empty().append('<div id="pactive_notice" class="project-empty-no">'+StrackLang["No_Filter_Project"]+'</div>');
                }else {
                    $project_list.empty().append(list_dom);
                }
            }
        });
    }

    /**
     * 初始化项目页面工具栏
     */
    function init_project_toolbar() {
        $.ajax({
            type: "POST",
            url: ProjectPHP['getProjectToolbarSettings'],
            dataType: "json",
            beforeSend: function () {
                $(".add-project-header").append(Strack.loading_dom("white", "", "project_toolbar"));
            },
            success: function (data) {
                var status_list = '',
                    time_list = '';

                // 组装项目状态菜单选项DOM
                data["status_corresponds_list"].forEach(function (val) {
                    status_list +=  project_toolbar_menu_dom('project_status', val);
                });

                $("#project_toolbar_status").empty().append(status_list);

                // 组装项目时间范围菜单选项DOM
                data["time_data_list"].forEach(function (val) {
                    time_list +=  project_toolbar_menu_dom('project_time', val);
                });

                $("#project_toolbar_time").empty().append(time_list);

                $("#st-load_project_toolbar").remove();
            }
        });
    }

    /**
     * 项目工具栏菜单dom
     * @param from
     * @param data
     */
    function project_toolbar_menu_dom(from, data) {
        var dom = '';
        dom += ' <a href="javascript:;" class="item view-g-item view-g-active" onclick="obj.click_down_item(this);" from="'+from+'" options="'+data["id"]+'">' +
            '<i class="icon-left icon-unchecked"></i>' +
            data["name"] +
            '</a>';
        return dom;
    }

    /**
     * 一行最多6个卡片dom
     * @param rows
     * @returns {string}
     */
    function project_row_dom(rows) {
        var dom = '';
        dom += ' <div class="proj-search-rows">' +
            '<div class="ui six column doubling grid">' +
            rows+
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 单个卡片dom
     * @param data
     * @returns {string}
     */
    function project_card_dom(data) {
        var dom = '';
        var thumb = data["thumb"]? data["thumb"] : StrackPHP["IMG"]+'/project_thumb_default2.jpg';
        var url = Strack.remove_html_ext(ProjectPHP["project_overview"])+ '/' + data["id"] + '.html';

        dom += '<div class="column">'+
            '<a href="'+url+'" class="proj-list-card">'+
            '<div class="card">'+
            '<div class="image">'+
            '<img src="'+thumb+'">'+
            '</div>'+
            '<div class="content">'+
            '<div class="header text-ellipsis">' +
            '<div>' +
            '<span class="project-menu-icon ui empty circular label" style="background-color: #'+data["status_color"]+'; margin-right: 10px" title="'+["status_name"]+'"></span>' +
            '<strong>'+data["name"]+'</strong>' +
            '</div>' +
            '</div>'+
            '<div class="status text-ellipsis">' +
            data["status_name"]+
            '</div>' +
            '<div class="controller text-ellipsis">' +
            data["created_by"]+
            '</div>' +
            '</div>'+
            '<div class="progress">'+
            '<div class="progress-base" title="'+StrackLang["Progress"]+' : '+data["progress"]+'%"></div>'+
            '<div class="progress-current" title="'+StrackLang["Progress"]+' : '+data["progress"]+'%" style="width: '+data["progress"]+'%;"></div>'+
            '</div>'+
            '</div>'+
            '</a>'+
            '</div>';

        return dom;
    }

    /**
     * 分组标题
     * @param data
     * @returns {string}
     */
    function project_group_title(data) {
        var dom = '';
        dom += '<a href="javascript:;" class="proj-search-title" onclick="obj.toggle_group(this)" data-groupid="'+data["index"]+'">'+
            data["title"] +
            '<i class="triangle down icon"></i>'+
            '</a>';
        return dom;
    }


    /**
     * 项目分组DOM
     * @param group_dom
     * @returns {string}
     */
    function project_group_dom(group_dom) {
        var dom = '';
        dom += '<div id="proj_group_1" class="proj-search-group">'+
            group_dom +
            '</div>';
        return dom;
    }

});