$(function () {

    var VideoFrame = function (options) {
        if (this === window) {
            return new VideoFrame(options);
        }
        this.obj = options || {};
        this.frameRate = this.obj.frameRate || 24;
        switch (options["type"]) {
            case "vobj":
                this.video = options["vobj"];
                break;
            default:
                this.video = document.getElementById(this.obj.id) || document.getElementsByTagName('video')[0];
                break;
        }
    };

    VideoFrame.prototype = {
        get: function () {
            return Math.floor(this.video.currentTime.toFixed(5) * this.frameRate);
        },
        listen: function (format, tick) {
            var _video = this;
            if (!format) {
                console.log('VideoFrame: Error - The listen method requires the format parameter.');
                return;
            }
            this.interval = setInterval(function () {
                if (_video.video.paused || _video.video.ended) {
                    return;
                }
                var frame = ((format === 'SMPTE') ? _video.toSMPTE() : ((format === 'time') ? _video.toTime() : _video.get()));
                if (_video.obj.callback) {
                    _video.obj.callback(frame, format);
                }
                return frame;
            }, (tick ? tick : 1000 / _video.frameRate / 2));
        },
        /** Clears the current interval */
        stopListen: function () {
            var _video = this;
            clearInterval(_video.interval);
        },
        fps: Strack.G.FrameRates
    };


    VideoFrame.prototype.toTime = function (frames) {
        var time = (typeof frames !== 'number' ? this.video.currentTime : frames), frameRate = this.frameRate;
        var dt = (new Date()), format = 'hh:mm:ss' + (typeof frames === 'number' ? ':ff' : '');
        dt.setHours(0);
        dt.setMinutes(0);
        dt.setSeconds(0);
        dt.setMilliseconds(time * 1000);
        function wrap(n) {
            return ((n < 10) ? '0' + n : n);
        }

        return format.replace(/hh|mm|ss|ff/g, function (format) {
            switch (format) {
                case "hh":
                    return wrap(dt.getHours() < 13 ? dt.getHours() : (dt.getHours() - 12));
                case "mm":
                    return wrap(dt.getMinutes());
                case "ss":
                    return wrap(dt.getSeconds());
                case "ff":
                    return wrap(Math.floor(((time % 1) * frameRate)));
            }
        });
    };


    VideoFrame.prototype.toSMPTE = function (frame) {
        if (!frame) {
            return this.toTime(this.video.currentTime);
        }
        var frameNumber = Number(frame);
        var fps = this.frameRate;

        function wrap(n) {
            return ((n < 10) ? '0' + n : n);
        }

        var _hour = ((fps * 60) * 60), _minute = (fps * 60);
        var _hours = (frameNumber / _hour).toFixed(0);
        var _minutes = (Number((frameNumber / _minute).toString().split('.')[0]) % 60);
        var _seconds = (Number((frameNumber / fps).toString().split('.')[0]) % 60);
        var SMPTE = (wrap(_hours) + ':' + wrap(_minutes) + ':' + wrap(_seconds) + ':' + wrap(frameNumber % fps));
        return SMPTE;
    };


    VideoFrame.prototype.toSeconds = function (SMPTE) {
        if (!SMPTE) {
            return Math.floor(this.video.currentTime);
        }
        var time = SMPTE.split(':');
        return (((Number(time[0]) * 60) * 60) + (Number(time[1]) * 60) + Number(time[2]));
    };


    VideoFrame.prototype.toMilliseconds = function (SMPTE) {
        var frames = (!SMPTE) ? Number(this.toSMPTE().split(':')[3]) : Number(SMPTE.split(':')[3]);
        var milliseconds = (1000 / this.frameRate) * (isNaN(frames) ? 0 : frames);
        return Math.floor(((this.toSeconds(SMPTE) * 1000) + milliseconds));
    };


    VideoFrame.prototype.toFrames = function (SMPTE) {
        var time = (!SMPTE) ? this.toSMPTE().split(':') : SMPTE.split(':');
        var frameRate = this.frameRate;
        var hh = (((Number(time[0]) * 60) * 60) * frameRate);
        var mm = ((Number(time[1]) * 60) * frameRate);
        var ss = (Number(time[2]) * frameRate);
        var ff = Number(time[3]);
        return Math.floor((hh + mm + ss + ff));
    };


    VideoFrame.prototype.__seek = function (direction, frames) {
        if (!this.video.paused) {
            this.video.pause();
        }
        var frame = Number(this.get());
        /** To seek forward in the video, we must add 0.00001 to the video runtime for proper interactivity */
        this.video.currentTime = ((((direction === 'backward' ? (frame - frames) : (frame + frames))) / this.frameRate) + 0.00001);
    };


    VideoFrame.prototype.seekForward = function (frames, callback) {
        if (!frames) {
            frames = 1;
        }
        this.__seek('forward', Number(frames));
        return (callback ? callback() : true);
    };

    VideoFrame.prototype.seekBackward = function (frames, callback) {
        if (!frames) {
            frames = 1;
        }
        this.__seek('backward', Number(frames));
        return (callback ? callback() : true);
    };


    VideoFrame.prototype.seekTo = function (config) {
        var obj = config || {}, seekTime, SMPTE;
        /** Only allow one option to be passed */
        var option = Object.keys(obj)[0];

        if (option === 'SMPTE' || option === 'time') {
            SMPTE = obj[option];
            seekTime = ((this.toMilliseconds(SMPTE) / 1000) + 0.001);
            this.video.currentTime = seekTime;
            return;
        }

        switch (option) {
            case 'frame':
                SMPTE = this.toSMPTE(obj[option]);
                seekTime = ((this.toMilliseconds(SMPTE) / 1000) + 0.001);
                break;
            case 'seconds':
                seekTime = Number(obj[option]);
                break;
            case 'milliseconds':
                seekTime = ((Number(obj[option]) / 1000) + 0.001);
                break;
        }

        if (!isNaN(seekTime)) {
            this.video.currentTime = seekTime;
        }
    };

    obj={
        // 切换playlist tab
        toggle_playlist_tab: function(i)
        {
            if(check_add_playlist_panel_active(true) ){
                var tab = $(i).data('tab');
                reset_search_box(); // 清空搜索框
                switch (tab){
                    case "task":
                        toggle_playlist_tab(tab, 'my_review', false);
                        break;
                    case "playlist":
                        toggle_playlist_tab(tab, 'my_create', false);
                        break;
                }

            }
        },
        // 切换playlist inside tab
        toggle_playlist_inside_tab: function(i)
        {
            if(check_add_playlist_panel_active(true) ) {
                var tab = $(i).data('tab');
                $("#playlist_inside_my_create,#playlist_inside_all_playlist,#playlist_inside_follow").empty();
                reset_search_box(); // 清空搜索框
                toggle_playlist_inside_tab(tab, false);
            }
        },
        // 切换info tab
        toggle_info_tab: function (i) {
            if(check_add_playlist_panel_active(true) ) {
                var tab = $(i).data('tab');
                var name = $(i).html();
                toggle_info_tab(tab, name);
            }
        },
        // 隐藏左右边侧栏
        hidden_panel: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var pos = $(i).data('pos');
                var $st_media_left = $("#st_media_left");
                var $st_media_mid = $("#st_media_mid");
                var $st_media_right = $("#st_media_right");
                switch (pos) {
                    case "left":
                        // 隐藏
                        if (check_add_playlist_panel_active(true)) {
                            $st_media_left.addClass("hidden")
                                .hide();
                            $("#show_bnt_left").addClass("bnt-active");
                            show_or_hide_sidebar();
                        }
                        break;
                    case "right":
                        $st_media_right.addClass("hidden")
                            .hide();
                        $("#show_bnt_right").addClass("bnt-active");
                        show_or_hide_sidebar();
                        break;
                }
                toggle_panel_button(pos, "show");
            }
        },
        // 显示左右边侧栏
        show_panel: function(i)
        {
            var pos = $(i).data('pos');
            var $st_media_left = $("#st_media_left");
            var $st_media_mid = $("#st_media_mid");
            var $st_media_right = $("#st_media_right");
            switch (pos){
                case "left":
                    $st_media_left.removeClass("hidden");
                    $("#show_bnt_left").removeClass("bnt-active");
                    show_or_hide_sidebar();
                    break;
                case "right":
                    $st_media_right.removeClass("hidden");
                    $("#show_bnt_right").removeClass("bnt-active");
                    show_or_hide_sidebar();
                    break;
            }
            toggle_panel_button(pos, "hidden");
        },
        // 显示文件表格区域
        show_file_grid_panel: function (i) {
            show_file_grid_panel(i);
        },
        // 显示隐藏时间线
        toggle_track: function(i)
        {
            var pos = $(i).data('pos');
            var $view_player_top = $(".media-player"),
                $file_grid = $(".media-file-grid"),
                $file_toolbar = $(".file-toolbar"),
                $view_player_bottom = $(".media-player-bottom"),
                $icon = $(i).find("i");
            $file_grid.css('height', '50px');
            $file_toolbar.hide();
            switch (pos){
                case "top":
                    // 隐藏
                    $(i).data('pos', "bottom");
                    $view_player_top.css("height", "calc(100% - 59px)");
                    $view_player_bottom.css('height', '51px');
                    $icon.removeClass('icon-uniE76B').addClass('icon-uniE76C');
                    break;
                case "bottom":
                    // 显示
                    $(i).data('pos', "top");
                    $view_player_top.css("height", "calc(100% - 348px)");
                    $view_player_bottom.css('height', '340px');
                    $icon.removeClass('icon-uniE76C').addClass('icon-uniE76B');
                    break;
            }
        },
        // 关注播放列表
        playlist_follow: function(i)
        {
            var entity_id = $(i).data("id");
            var follow_status = $(i).attr("data-follow");
            var is_follow = follow_status === "unfollow" ? "no" : "yes";
            if($(i).closest(".play-list-items").hasClass("selected")){
                generate_timeline_follow_bnt(is_follow);
            }
            toggle_item_follow_icon(entity_id, follow_status);
            playlist_follow(entity_id, follow_status, 'item');
        },
        // 时间线关注播放列表
        timeline_playlist_follow: function(i)
        {
            var timeline_entity_id = $("#timeline_entity_id").val();
            var follow_status = $(i).attr("data-follow");
            var is_follow = follow_status === "unfollow" ? "no" : "yes";
            generate_timeline_follow_bnt(is_follow);
            toggle_item_follow_icon(timeline_entity_id, follow_status);
            playlist_follow(timeline_entity_id, follow_status, 'timeline');
        },
        // 保存时间线修改
        save_timeline_change: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var timeline_entity_id = $("#timeline_entity_id").val();
                submit_save_playlist({
                    mode: "timeline",
                    id: timeline_entity_id
                });
            }
        },
        // 重载时间线
        reload_timeline: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                reload_timeLine();
            }
        },
        // 播放器控制按钮事件
        player_control: function(i)
        {
            var bnt = $(i).data("bnt");
            switch (bnt){
                case "play":
                    // 播放暂停按钮
                    play_or_pause_media();
                    break;
                case "metadata":
                    // 显示元素据按钮
                    toggle_metadata_panel();
                    break;
                case "fullscreen":
                    // 播放视图全屏按钮
                    toggle_media_view_fullscreen();
                    break;
                case "painter":
                    // 截图绘制按钮
                    player_controller_painter();
                    break;
                case "loop":
                    // 循环播放按钮
                    set_player_controller_loop();
                    break;
                case "voice":
                    // 打开或者关闭按钮
                    set_player_controller_voice();
                    break;
            }
        },
        // 退出截屏状态
        exit_media_painter : function(){
            player_controller_painter();
        },
        // 添加播放列表
        add_playlist: function(i)
        {
            // 组装页面
            assembly_panel("add_playlist");
            load_add_playlist_panel("add");
        },
        // 编辑播放列表
        playlist_edit: function(i)
        {
            var id = $(i).data("id");
            assembly_panel("modify_playlist");
            load_add_playlist_panel("modify", id);
        },
        // 删除选定的播放列表
        playlist_delete: function(i)
        {
            var entity_id = $(i).data("id");
            var active_status = $(i).closest(".play-list-items").hasClass("selected");
            delete_playlis(entity_id, active_status, 'start');
        },
        // 添加可审核文件到播放列表
        add_file_to_timeline: function(i)
        {
            append_file_to_timeline();
        },
        // 删除时间线项
        delete_track_item: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var id = $(i).data("id"),
                    uuid = $(i).data("uuid");
                $("#track_item_" + uuid).remove();
                remove_from_timeline_global_variable(uuid);
                reset_timeline_width();
            }
        },
        // 选择一个播放列表
        select_playlist: function(i)
        {
            var id = $(i).data("id"),
                url_tag = $(i).data("urltag");

            $(".play-list-items").removeClass("selected");
            $(i).closest(".play-list-items").addClass("selected");

            // 修改url
            modify_url_address("playlist", url_tag);

            assembly_panel("playlist_selected");

            // 加载时间线数据
            load_playlist_timeline_data(id , 'select');
        },
        // 新增或者修改
        save_playlist: function(i)
        {
            var mode = $(i).data("mode"),
                id = $(i).data("id");
            submit_save_playlist({
                mode : mode,
                id : id
            });
        },
        // 选择时间线项
        select_track_item: function(i){
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var $track_item = $(i).closest(".track-item");
                if ($track_item.hasClass("load-active")) {
                    var uuid = $track_item.data("uuid");
                    // 找到当前uuid的index
                    var c_index = 0;
                    var media_data = {};
                    for (var key in timeline_play_data) {
                        media_data = timeline_play_data[key];
                        if (media_data["uuid_md5"] === uuid) {
                            c_index = key;
                        }
                    }
                    playback_selected_media(media_data, c_index);
                } else {
                    layer.msg(StrackLang['Media_Not_Loaded'], {icon: 2, time: 1200, anim: 6});
                }
            }
        },
        // 过滤左侧面板
        search_left_panel: function () {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                // 判断当前在哪个tab下面
                var $active_tab = $(".playlist-tab.active");
                var tab_name = $active_tab.data("tab");
                var search_val = $("#left_search_val").val();
                if (search_val.length > 0) {
                    load_param["filter"] = {'name': ['-lk', "%" + search_val + "%"]};
                } else {
                    load_param["filter"] = '';
                }

                load_param["status"] = "new";

                // 获取子tab
                var $active_inside_tab = $(".playlist-inside-tab.active");
                var inside_tab_name = $active_inside_tab.data("tab");

                switch (tab_name) {
                    case "task":
                        // 审核任务
                        assembly_panel("review_task");
                        switch (inside_tab_name) {
                            case "my_review":
                                // 由我审核的任务
                                modify_url_address(tab_name, 'scene=task-my_review');
                                load_review_task_data('#playlist_inside_my_review', load_param, false);
                                break;
                            case "all_task":
                                // 所有审核的任务
                                modify_url_address(tab_name, 'scene=task-all_task');
                                load_review_task_data('#playlist_inside_all_task', load_param, false);
                                break;
                        }
                        break;
                    case "playlist":
                        assembly_panel("playlist");
                        switch (inside_tab_name) {
                            case "my_create":
                                // 我创建的播放列表
                                modify_url_address(tab_name, 'scene=playlist-my_create');
                                load_playlist_data('#playlist_inside_my_create', load_param, false);
                                break;
                            case "all_playlist":
                                // 所有播放列表
                                modify_url_address(tab_name, 'scene=playlist-all_playlist');
                                load_playlist_data('#playlist_inside_all_playlist', load_param, false);
                                break;
                            case "follow":
                                // 我关注的播放列表
                                modify_url_address(tab_name, 'scene=playlist-follow');
                                load_follow_playlist_data('#playlist_inside_follow', load_param, false);
                                break;
                        }
                        break;
                }
            }
        },
        // 选中一个审核任务
        select_review_task: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var id = $(i).data("id"),
                    url_tag = $(i).data("urltag");

                $(".play-list-items").removeClass("selected");
                $(i).closest(".play-list-items").addClass("selected");

                // 修改url
                modify_url_address("review_task", url_tag);

                // 组装页面
                assembly_panel("review_task_selected");

                // 加载时间线数据
                load_review_task_timeline_data(id);

                current_review_task_id = id;

                // 初始化左侧info面板
                toggle_info_tab("note", StrackLang["Feedback"]);
            }
        },
        // 删除指定审核任务
        delete_review_task: function(i)
        {
            if(Strack.G.mediaScreenshotStatus){
                // 处于截屏状态不允许播放列表切换
                layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
            }else {
                var base_id = $(i).data("id");
                var active_status = $(i).closest(".play-list-items").hasClass("selected");
                delete_review_task(base_id, active_status);
            }
        },
        //修改base类型数据
        media_edit: function (i) {
            var lang = $(i).data("lang");
            Strack.get_datagrid_select_data("#main_datagrid_box", function (ids) {
                Strack.item_operate_dialog(lang,
                    {
                        mode: "modify",
                        field_list_type: ['edit'],
                        module_id: param["file_commit_module_id"],
                        project_id: param["project_id"],
                        page: param["page"],
                        schema_page: 'project_file_commit',
                        type: "update_panel",
                        primary_id: ids.join(",")
                    },
                    function () {
                        obj.reset_media_grid();
                    }
                );
            });
        },
        // 删除base数据
        media_delete: function (i) {
            param["module_id"] = param["file_commit_module_id"];
            param["module_code"] = "file_commit";
            Strack.ajax_grid_delete('main_datagrid_box', 'id', StrackLang['Delete_File_Commit_Notice'], StrackPHP['deleteGridData'], param);
        },
        // 重置media数据表格
        reset_media_grid: function()
        {
            $('#main_datagrid_box').datagrid('reload');
        },
        // 关闭审核任务信息设置面板
        close_review_task_details: function (i) {
            // 保存当前面板信息到全局变量
            var $etask_list = $("#review_entity_step_task");
            var active_item =  $etask_list.find(".etask-l-active");
            var allow_close = true;

            if (active_item.length > 0) {
                var ac_id = active_item.attr("id"),
                    ac_step_code = active_item.attr("data-stepcode");
                var check_data = Strack.check_item_operate_fields('#m_review_task_fields', '#m_review_task_item');
                Strack.G.entityStepTaskAddData.data[ac_step_code][ac_id] = check_data.up_data;
                if (check_data.allow_up) {
                    active_item.addClass("form_ok");
                }else {
                    allow_close = false;
                }
            }

            // 隐藏主面板
            if(allow_close){
                $("#step_task_details").hide();

                // 取消任务项选中
                $etask_list.find(".stdg-etask-l-item")
                    .removeClass("etask-l-active");
            }
        },
        // 关闭添加播放列表面板
        close_review_add_playlist: function (i) {
            $.messager.confirm(StrackLang['Confirmation_Box'], StrackLang['Close_Add_Playlist_Notice'], function (flag) {
                if (flag) {
                    // 清空任务数据
                    Strack.G.entityStepTaskAddData.data = {};

                    // 显示播放列表面板
                    $(".add-review-entity,#step_task_details").hide();
                    $(".st-media-search,.media-review-list").show();

                    // 关闭file commit 数据表格
                    assembly_panel("playlist");
                }
            });
        },
        // 删除指定的截屏
        remove_screenshot: function (i) {
            $(i).closest(".pyn-st-img").remove();
            // 判断是否清空
            var $screenshot_list = $("#screenshot_list");
            if($screenshot_list.find(".pyn-st-img").length === 0){
                $screenshot_list.html('<div class="pyn-st-null">'+StrackLang["Screenshot_Null"]+'</div>');
            }
        }
    };

    var param = Strack.generate_hidden_param();
    param["grid_page_id"] = param["module_code"] + '_grid_' + param["project_id"];

    var load_param = param;
    load_param["filter"] = "";

    // media 页面视图数据记录
    var view_param = {};

    // 当前所在的场景模式
    var current_scene = "";

    // 时间线全局变量
    var timeline_item_data = {},
        timeline_play_data = {},
        media_material_cache = {},
        review_task_list_data = {};

    // 播放器全局变量
    var media_obj = null,
        video_frame_obj = null,
        image_play_interval = null,
        media_render_first = true,
        current_slider_number = 0,
        current_review_task_id = 0;

    var media_view_scene,
        media_view_renderer,
        media_view_camera,
        media_view_light,
        media_view_trackball,
        media_view_plane,
        media_view_animation,
        media_view_play_index;

    // 播放器控制器全局变量
    var player_controller_volume = 1,
        player_controller_loop = 'all_loop',
        $media_slider = $('#media_view_slider');

    var timeline_screenshot_cache = {};

    // 面板区域变化自适应
    on_panel_resize();

    // 绑定键盘事件
    media_keyboard_event();

    resize_track_height();

    init_wpaint_panel();

    // 判断是否有url锚点
    var url_tag_param = {
        url_scene : param.url_scene,
        url_tab : param.url_tab,
        url_id : param.url_id,
        url_item_name : param.url_item_name
    };

    // 权限配置

    apply_url_tag();

    /**
     * 判断系统是否存在锚点
     */
    function apply_url_tag() {
        if($.inArray(url_tag_param.url_scene, ['task', 'playlist']) >= 0 &&
            $.inArray(url_tag_param.url_tab, ['my_review','all_task','my_create','all_playlist','follow']) >= 0 &&
            url_tag_param.url_id &&
            url_tag_param.url_item_name)
        {
            if(param.rule_palylist === "yes"){
                $("#left_search_val").val(url_tag_param.url_item_name);
                load_param["filter"] = {'name': ['-lk', "%" + url_tag_param.url_item_name + "%"]};
                url_tag_param["select_id"] = "item_" + url_tag_param.url_scene + "_" + url_tag_param.url_id;
                toggle_playlist_tab(url_tag_param.url_scene, url_tag_param.url_tab, true);
            }else {
                // 左侧
                switch (url_tag_param.url_scene){
                    case "task":
                        current_review_task_id = url_tag_param.url_id;
                        review_task_list_data[current_review_task_id] = {
                            id : current_review_task_id,
                            name: url_tag_param.url_item_name
                        };
                        if(param.rule_review === "no"){
                            assembly_panel("review_task_no_left");
                            // 加载时间线数据
                            load_review_task_timeline_data(url_tag_param.url_id);
                            // 初始化左侧info面板
                            toggle_info_tab("note", StrackLang["Feedback"]);
                        }else {
                            assembly_panel("review_task_no_side");
                            // 加载时间线数据
                            load_review_task_timeline_data(url_tag_param.url_id);
                        }

                        break;
                    case "playlist":
                        assembly_panel("playlist_no_side");
                        // 加载时间线数据
                        load_playlist_timeline_data(url_tag_param.url_id , 'select');
                        break;
                }
            }
        }else {
            // 仅切换tab
            var tab = 'task', inside_tab = 'my_review';
            switch (url_tag_param.url_scene){
                case "task":
                    tab = url_tag_param.url_scene;
                    if($.inArray(url_tag_param.url_tab, ['my_review','all_task']) >= 0){
                        inside_tab = url_tag_param.url_tab;
                    }
                    break;
                case "playlist":
                    tab = url_tag_param.url_scene;
                    if($.inArray(url_tag_param.url_tab, ['my_create','all_playlist','follow']) >= 0){
                        inside_tab = url_tag_param.url_tab;
                    }
                    break;
            }

            toggle_playlist_tab(tab, inside_tab, false);
        }
    }

    /**
     * 组装媒体页面
     * 1、播放列表：#playlist 显示 左侧面板 / 中间面板
     * 2、审核任务：#review_task 显示 左侧面板 / 中间面板 / 右侧面板
     * 3、领导客户审核：#client_review 显示 中间面板 / 右侧面板
     */
    function assembly_panel(scene) {
        var $timeline_playlist_follow = $("#timeline_playlist_follow");
        var $timeline_playlist_save = $("#timeline_playlist_save");
        var $media_player_disabled = $("#media_player_disabled");
        var $preview_painter_bnt = $("#preview_painter_bnt");
        var $save_playlist_bnt = $("#save_playlist_bnt span");
        var $add_playlist_title = $("#add_playlist_title");
        var $st_media_left = $("#st_media_left");
        var $st_media_right = $("#st_media_right");
        var $st_media_mid = $("#st_media_mid");
        var $show_bnt_left = $("#show_bnt_left");
        var $show_bnt_right = $("#show_bnt_right");

        switch (scene){
            case "playlist":
                // 播放列表
                clear_timeline();
                $media_player_disabled.show();
                $timeline_playlist_follow.show(); // 关注按钮
                $timeline_playlist_save.show();
                $preview_painter_bnt.hide();
                obj.hidden_panel(Strack.get_obj_by_id("top_bnt_right"));
                show_file_grid_panel(Strack.get_obj_by_id("grid_button_center"), 'bottom');
                obj.show_panel(Strack.get_obj_by_id("grid_button_left"));
                toggle_panel_button("right", "hidden");
                toggle_panel_button("center", "hidden");
                break;
            case "playlist_selected":
                // 选中一个播放列表
                clear_timeline();
                $media_player_disabled.hide();
                $timeline_playlist_follow.show(); // 关注按钮
                $timeline_playlist_save.show();
                $preview_painter_bnt.hide();
                show_file_grid_panel(Strack.get_obj_by_id("grid_button_center"), 'bottom');
                toggle_panel_button("right", "hidden");
                toggle_panel_button("center", "show");
                break;
            case "add_playlist":
            case "modify_playlist":
                // 添加，编辑播放列表
                clear_timeline();
                // 显示添加播放列表面板
                $(".st-media-search,.media-review-list").hide();
                $(".add-review-entity").show();
                if(scene === "add_playlist"){
                    $save_playlist_bnt.html(StrackLang["Submit_Add_Playlist"]);
                    $add_playlist_title.html(StrackLang["Add_Playlist"]);
                }else {
                    $save_playlist_bnt.html(StrackLang["Submit_Modify_Playlist"]);
                    $add_playlist_title.html(StrackLang["Modify_Playlist"]);
                }
                $media_player_disabled.hide();
                $timeline_playlist_follow.hide();
                $timeline_playlist_save.hide();
                show_file_grid_panel(Strack.get_obj_by_id("grid_button_center"), 'top');
                toggle_panel_button("center", "show");
                break;
            case "review_task":
                // 进入审核任务，只能再选择审核任务之后才能进行更多编辑
                clear_timeline();
                $media_player_disabled.show();
                $timeline_playlist_follow.hide();
                $timeline_playlist_save.show();
                $preview_painter_bnt.show();

                obj.hidden_panel(Strack.get_obj_by_id("top_bnt_right"));
                show_file_grid_panel(Strack.get_obj_by_id("grid_button_center"), 'bottom');
                obj.show_panel(Strack.get_obj_by_id("grid_button_left"));
                toggle_panel_button("right", "hidden");
                toggle_panel_button("center", "hidden");
                break;
            case "review_task_selected":
                // 选中一个审核任务
                clear_timeline();
                clear_feedback_panel();
                $media_player_disabled.hide();
                $timeline_playlist_follow.hide();
                $timeline_playlist_save.show();
                $preview_painter_bnt.show();
                obj.show_panel(Strack.get_obj_by_id("grid_button_right"));
                show_file_grid_panel(Strack.get_obj_by_id("grid_button_center"), 'bottom');
                toggle_panel_button("right", "show");
                toggle_panel_button("center", "show");
                break;
            case "review_task_no_left":
                // 审核任务无左侧面板
                $media_player_disabled.hide();
                $st_media_left.addClass("hidden");
                $show_bnt_left.hide();
                $st_media_mid.removeClass('nine')
                    .removeClass('gird-mid-56')
                    .removeClass("gird-mid-81")
                    .removeClass('gird-mid-full')
                    .addClass('gird-mid-75');
                $st_media_right.show();
                break;
            case "review_task_no_side":
                // 审核任务无两侧面板
                $media_player_disabled.hide();
                $st_media_left.addClass("hidden");
                $st_media_right.addClass("hidden");
                $show_bnt_left.hide();
                $show_bnt_right.hide();
                $st_media_mid.removeClass('nine')
                    .removeClass("gird-mid-56")
                    .removeClass('gird-mid-75')
                    .removeClass("gird-mid-81")
                    .addClass('gird-mid-full');
                break;
            case "playlist_no_side":
                // 播放列表无右侧面板
                $media_player_disabled.hide();
                $st_media_left.addClass("hidden");
                $st_media_right.addClass("hidden");
                $show_bnt_left.hide();
                $show_bnt_right.hide();
                $st_media_mid.removeClass('nine')
                    .removeClass("gird-mid-56")
                    .removeClass('gird-mid-75')
                    .removeClass("gird-mid-81")
                    .addClass('gird-mid-full');
                break;
        }
    }

    /**
     * 清除重置审核面板
     */
    function clear_feedback_panel() {
        // 清空截图区域
        $("#screenshot_list").html('<div class="pyn-st-null">'+StrackLang["Screenshot_Null"]+'</div>');

    }

    /**
     * 显示隐藏审核文件面板
     * @param i
     * @param status
     */
    function show_file_grid_panel(i, status) {
        var c_pos = $(i).data("pos");
        var $grid_panel = $("#file_grid_panel");
        var $file_grid = $(".media-file-grid");
        var $file_toolbar = $(".file-toolbar");
        var $grid_panel_parent = $(i).closest('.media-file-grid-bnt');
        var $player_bottom = $(".media-player-bottom");

        var pos = status? status : c_pos;
        switch (pos) {
            case "top":
                stop_play_current_media(); // 停止当前播放媒体
                $(i).data("pos", "bottom");
                $grid_panel.slideDown(100, 'linear', function () {
                    $(i).find("i").removeClass("icon-uniF103").addClass("icon-uniF102");
                    $grid_panel_parent.removeClass("grid-bnt-top").addClass("grid-bnt-bottom");

                    $file_toolbar.show();

                    // 加载数据表格
                    load_grid_data();

                    // 隐藏反馈面板
                    obj.hidden_panel(Strack.get_obj_by_id("top_bnt_right"));

                    // 获取是时间线底部距离
                    var bottom_h = $player_bottom.height() - 102;
                    bottom_h = bottom_h >= 0 ? bottom_h : 0;
                    $file_grid.css('height', 'calc(100% - ' + bottom_h + 'px)');
                });
                break;
            case "bottom":
                $(i).data("pos", "top");
                $file_toolbar.hide();
                $file_grid.css('height', '50px');
                $grid_panel_parent.removeClass("grid-bnt-bottom").addClass("grid-bnt-top");
                $grid_panel.slideUp(100, 'linear', function () {
                    $(i).find("i").removeClass("icon-uniF102").addClass("icon-uniF103");
                });
                break;
        }
    }

    /**
     * 显示或隐藏面板切换按钮
     */
    function toggle_panel_button(pos, status) {
        switch (pos){
            case "center":
                var $bnt_center = $("#grid_button_center");
                switch (status){
                    case "show":
                        $bnt_center.show();
                        break;
                    case "hidden":
                        $bnt_center.hide();
                        break;
                }
                break;
            case "left":
                var $bnt_left = $("#show_bnt_left");
                switch (status){
                    case "show":
                        $bnt_left.show();
                        break;
                    case "hidden":
                        $bnt_left.hide();
                        break;
                }
                break;
            case "right":
                var $bnt_right = $("#show_bnt_right");
                switch (status){
                    case "show":
                        if(current_scene === "task") {
                            $bnt_right.show();
                        }
                        break;
                    case "hidden":
                        $bnt_right.hide();
                        break;
                }
                break;
        }
    }

    /**
     * 当页面大小变化
     */
    function on_panel_resize() {
        show_or_hide_sidebar();
        $("#st_media_wrap").on("mresize", function (e) {
            if(check_add_playlist_panel_active(false)) {
                show_or_hide_sidebar();
            }
        });

        $("#media_player_view").on("mresize", function (e) {
            media_view_fit_size();
        });
    }

    /**
     * 动态调整时间线区域高度
     */
    function resize_track_height() {
        var max_height, c_height;
        var min_height = 51;
        var $player_main = $(".media-player"),
            $player_bottom = $(".media-player-bottom");
        $('.center-handle').on('mousedown', function (e) {
            e.preventDefault();
            max_height = document.body.clientHeight - 110;

            $("#st_media_mid").on("mousemove", function (e) {
                //mousemove 鼠标按下 绑定鼠标移动事件
                c_height = document.body.clientHeight - e.pageY;
                if(c_height < max_height && c_height >= min_height){
                    $player_main.css('height', 'calc(100% - '+(c_height + 8)+'px)');
                    $player_bottom.css('height', c_height+'px');
                }
            }).on("mouseup", function (e) {
                //mouseup 鼠标释放 解除鼠标移动事件
                $(this).off("mousemove");
            });
        });
    }

    /**
     * 自动隐藏左右侧栏
     */
    function show_or_hide_sidebar() {
        var $st_media_left = $("#st_media_left");
        var $st_media_right = $("#st_media_right");
        var $st_media_wrap = $("#st_media_wrap");
        var $st_media_mid = $("#st_media_mid");

        var media_left_w = $st_media_left.width();
        var media_right_w = 0;
        var media_mid_w = $st_media_wrap.width();
        var media_left_hide = $st_media_left.is(":hidden");
        var media_right_hide = $st_media_right.is(":hidden");
        var media_left_hide_manual = $st_media_left.hasClass('hidden');
        var media_right_hide_manual = $st_media_right.hasClass('hidden');

        // 1、都没有手动隐藏情况
        if(!media_left_hide_manual && !media_right_hide_manual){

            if(!media_left_hide && !media_right_hide){
                // 两个页面都显示情况
                if(media_left_w <= 330){
                    $st_media_left.hide();
                    $st_media_mid.removeClass('nine')
                        .removeClass('gird-mid-56')
                        .addClass('gird-mid-75');
                }
            }

            media_right_w = $st_media_right.width();
            media_left_hide = $st_media_left.is(":hidden");
            media_right_hide = $st_media_right.is(":hidden");

            if(media_left_hide && !media_right_hide){
                // 右侧独立显示情况
                if(media_right_w <= 420) {
                    $st_media_right.hide();
                    $st_media_mid.removeClass('nine')
                        .removeClass("gird-mid-56")
                        .removeClass('gird-mid-75')
                        .removeClass("gird-mid-81")
                        .addClass('gird-mid-full');
                }

                if(media_mid_w * 0.1875 > 330){
                    $st_media_mid
                        .removeClass('nine')
                        .addClass('gird-mid-full')
                        .removeClass("gird-mid-81")
                        .removeClass('gird-mid-75')
                        .addClass("gird-mid-56");
                    $st_media_left.show();
                    $st_media_right.show();
                }
            }

            if(!media_left_hide && media_right_hide){
                // 左侧独立显示情况
                if(media_mid_w * 0.1875 > 330){
                    $st_media_mid
                        .removeClass('nine')
                        .addClass('gird-mid-full')
                        .removeClass("gird-mid-81")
                        .removeClass('gird-mid-75')
                        .addClass("gird-mid-56");
                    $st_media_left.show();
                    $st_media_right.show();
                }
            }

            if(media_left_hide && media_right_hide){
                if(media_mid_w * 0.25 > 420){
                    $st_media_mid.removeClass('nine')
                        .removeClass('gird-mid-56')
                        .removeClass("gird-mid-81")
                        .removeClass('gird-mid-full')
                        .addClass('gird-mid-75');
                    $st_media_right.show();
                }

                if(media_mid_w * 0.1875 > 330){
                    $st_media_mid.removeClass('nine')
                        .removeClass('gird-mid-75')
                        .removeClass("gird-mid-81")
                        .removeClass('gird-mid-full')
                        .addClass("gird-mid-56");
                    $st_media_left.show();
                    $st_media_right.show();
                }
            }
        }

        // 2、都手动隐藏了
        if(media_left_hide_manual && media_right_hide_manual){
            $st_media_mid.removeClass('nine')
                .removeClass('gird-mid-56')
                .removeClass("gird-mid-75")
                .removeClass('gird-mid-81')
                .addClass('gird-mid-full');
        }

        // 3、右侧手动隐藏了
        if(media_left_hide_manual && !media_right_hide_manual){
            if(media_mid_w * 0.25 > 420){
                $st_media_right.show();
                $st_media_mid.removeClass('nine')
                    .removeClass('gird-mid-56')
                    .removeClass("gird-mid-81")
                    .removeClass('gird-mid-full')
                    .addClass('gird-mid-75');
            }else {
                $st_media_right.hide();
                $st_media_mid.removeClass('nine')
                    .removeClass('gird-mid-56')
                    .removeClass("gird-mid-75")
                    .removeClass('gird-mid-81')
                    .addClass('gird-mid-full');
            }
        }

        // 4、左侧手动隐藏了
        if(!media_left_hide_manual && media_right_hide_manual){
            if(media_mid_w * 0.1875 > 330){
                $st_media_left.show();
                $st_media_mid.removeClass('nine')
                    .removeClass('gird-mid-56')
                    .removeClass("gird-mid-81")
                    .removeClass('gird-mid-full')
                    .addClass("gird-mid-81");
            }else {
                $st_media_left.hide();
                $st_media_mid.removeClass('nine')
                    .removeClass('gird-mid-56')
                    .removeClass("gird-mid-75")
                    .removeClass('gird-mid-81')
                    .addClass('gird-mid-full');
            }
        }
    }

    
    /**
     * 检查添加播放列表是否激活
     * @returns {boolean}
     */
    function check_add_playlist_panel_active(show_notice) {
        if($('.add-review-entity').is(':visible')){
            if(show_notice){
                layer.msg(StrackLang['Close_Add_Playlist_Panel_First'], {icon: 2, time: 1200, anim: 6});
            }
            return false;
        }else {
            return true;
        }
    }

    /**
     * 加载新增播放列表面板
     * @param mode
     * @param entity_id
     */
    function load_add_playlist_panel(mode, entity_id) {

        if(mode === "add"){
            // 新增播放列表数据
            init_edit_playlist_panel(mode);
        }else {
            // 修改播放列表数据
            $.ajax({
                url:MediaPHP['getPlayEntityInfo'],
                type: 'POST',
                dataType: 'json',
                data: {
                    entity_id: entity_id
                },
                beforeSend:function(){
                    $('#st_media_left').append(Strack.loading_dom('black', '', 'edit_playlist'));
                },
                success:function(data){

                    // 填充时间线播放列表名称
                    fill_timeline_entity_data({
                        entity_id : data.id,
                        entity_name : data.name
                    }, "modify");

                    init_edit_playlist_panel(mode, data);

                    $("#st-load_edit_playlist").remove();
                }
            });

            // 加载时间线
            load_playlist_timeline_data(entity_id, 'edit_playlist');
        }
    }


    /**
     * 初始化播放列表编辑面板
     * @param mode
     * @param data
     */
    function init_edit_playlist_panel(mode, data) {

        //清除任务列表区域
        $("#review_entity_step_task").empty()
            .append('<div class="datagrid-empty-no">'+StrackLang["Please_Select_Step"]+'</div>');

        if(mode === "modify"){
            $("#review_entity_name").val(data["name"]);
            $("#review_entity_code").val(data["code"]);
        }else {
            // 清除实体信息
            $("#review_entity_name,#review_entity_code").val("");
        }

        var $review_entity_status = $('#review_entity_status');
        var status_val = data? data["status_id"] : '';
        if($review_entity_status.hasClass("combobox-f")){
            // 重新赋值状态下拉框
            $review_entity_status.combobox("clear");
            if(status_val){
                $review_entity_status.combobox("setValue", status_val);
            }
        }else {
            // 初始化下拉框
            Strack.combobox_widget('#review_entity_status', {
                url: StrackPHP["getReviewStatusCombobox"],
                prompt: StrackLang["Select_One_Status"],
                queryParams: param,
                valueField: 'id',
                textField: 'name',
                width: '100%',
                height: 30,
                value: status_val
            });
        }

        // 处理step工序字段
        var step_ids = {
            step_id : "review_entity_step",
            list_id : "review_entity_step_task",
            combox_id : "m_review_task_fields",
            edit_id : "m_review_task_item"
        };
        var $review_entity_step = $('#review_entity_step');
        if(!$review_entity_step.hasClass("combobox-f")){
            Strack.combobox_widget('#review_entity_step', {
                url: StrackPHP["getReviewStepConfig"],
                prompt: StrackLang["Select_Step"],
                queryParams: param,
                multiple: true,
                valueField: 'id',
                textField: 'name',
                width: '100%',
                height: 30,
                onSelect: function (record) {
                    // 选中 step
                    if(record){
                        Strack.add_entity_step_task_group(step_ids, record, 'new');
                    }
                },
                onUnselect: function (record) {
                    // 取消选中 step
                    Strack.remove_entity_step_task_group(step_ids, record);
                },
                onLoadSuccess:function () {
                    init_step_review_task(step_ids, data);
                }
            });
        }else {
            $review_entity_step.combobox("clear");
            init_step_review_task(step_ids, data);
        }
    }

    /**
     * 初始化工序审核任务
     */
    function init_step_review_task(step_ids, data) {
        var select_column = [];
        var $review_entity_step = $('#review_entity_step');
        if(data){
            var c_step_ids = [];
            var temp_step_data = {};
            var first_column;
            Strack.G.entityStepTaskAddData.data = data["step_data"];
            for(var step_key in data["step_data"]){
                c_step_ids.push(data["step_config"][step_key]['id']);
                // 生成step
                temp_step_data.id = data["step_config"][step_key]['id'];
                temp_step_data.step_code = data["step_config"][step_key]['code'];
                temp_step_data.step_name = data["step_config"][step_key]['name'];
                for(var base_key in data["step_data"][step_key]){
                    temp_step_data.code = base_key;
                    if(!first_column){
                        first_column = data["step_data"][step_key][base_key];
                    }
                    Strack.add_entity_step_task_group(step_ids, temp_step_data, 'old');
                }
            }
            // 组装任务字段选择项
            select_column = [];

            for(var key in first_column){
                first_column[key].forEach(function (val) {
                    if($.inArray(val["field"], ["base-id", "base-step_id"]) < 0){
                        select_column.push(val["field"]);
                    }
                });

            }

            $review_entity_step.combobox("setValues", c_step_ids);
        }

        init_base_combobox(select_column);
    }

    /**
     * 初始化任务下拉栏
     * @param select_column
     */
    function init_base_combobox(select_column) {
        var fields_param = {
            mode: "create",
            field_list_type: ['edit'],
            module_id: param.task_module_id,
            project_id: param.project_id,
            page: param.page,
            schema_page: param.page,
            type: "add_entity_task_panel",
            not_fields : ["entity_id", "thumb", 'step_id']
        };

        // 获取
        Strack.get_item_fields(fields_param, function (data) {

            var field_list = [];
            for (var key in data['field_list']) {
                for (var item in data['field_list'][key]) {
                    data['field_list'][key][item]["fields"].forEach(function (val) {
                        val["field_group_name"] = data['field_list'][key][item]["title"];
                        val["project_id"] = param['project_id'];
                        val["module_id"] = param["module_id"];
                        val["frozen_module"] = val["frozen_module"];
                        val['flg_module'] = val['flg_module'];
                        val["fields"] = val["module"] + '-' + val["id"];
                        field_list.push(val);
                    });
                }
            }

            $('#m_review_task_fields').combobox({
                data: field_list,
                width: 350,
                valueField: 'fields',
                textField: 'lang',
                groupField: 'field_group_name',
                multiple: true,
                value: "",
                onSelect: function (record) {
                    if (record && $("#dgup_i_" + record["fields"]).length === 0) {
                        var upitem = Strack.field_item_dom(record, fields_param, 1);
                        $("#m_review_task_item").append(upitem["item_dom"]);
                        Strack.field_item_init(upitem['dom_id'], param["project_id"], record);
                        if (record.id === "name" || record.id === "code") {
                            // 获取当前激活项名称
                            var md5_name = $("#stdg_etask_list .etask-l-active").find(".etask-l-item-name").html();
                            $("#" + upitem.dom_id).val(md5_name);
                        }
                    }
                },
                onUnselect: function (record) {
                    $("#dgup_i_" + record["fields"]).remove();
                },
                onLoadSuccess: function () {
                    var $this = $(this);
                    if(select_column.length > 0){
                        select_column.forEach(function (val) {
                            $this.combobox('select', val);
                        });
                    }else {
                        data["user_setting"].forEach(function (val) {
                            $this.combobox('select', val);
                        });
                    }
                },
                onChange: function (newValue, oldValue) {
                    // 删除当前选中任务ok状态
                    $(".stdg-etask-l-item").removeClass("form_ok");
                }
            });
        });
    }

    /**
     * 获取指定播放列表时间线数据
     * @param id
     * @param mode
     */
    function load_playlist_timeline_data(id, mode) {

        $.ajax({
            type: 'POST',
            url: MediaPHP["getPlaylistTimeLineData"],
            data: JSON.stringify({
                entity_id: id,
                entity_param: param
            }),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                // 清空时间线
                clear_timeline();

                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {

                if(mode !== "edit_playlist"){
                    // 填充时间线播放列表名称
                    fill_timeline_entity_data(data, "timeline");
                }
                

                // 生成时间线
                generate_timeline(data['rows']);

                // 初始化拖拽
                init_timeline_drag();

                $.messager.progress('close');

                if(mode !== "edit_playlist") {
                    // 直接重载播放
                    reload_timeLine();
                }
            }
        });
    }


    /**
     * 获取指定审核任务时间线数据
     * @param id
     */
    function load_review_task_timeline_data(id) {

        $.ajax({
            type: 'POST',
            url: MediaPHP["getReviewTaskTimeLineData"],
            data: JSON.stringify({
                base_id: id,
                entity_param: param
            }),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                // 清空时间线
                clear_timeline();

                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {

                // 填充时间线播放列表名称
                fill_timeline_entity_data(data, "timeline");

                // 生成时间线
                generate_timeline(data['rows']);

                // 初始化拖拽
                init_timeline_drag();

                $.messager.progress('close');

                // 直接重载播放
                reload_timeLine();
            }
        });
    }

    /**
     * 填充时间线实体数据
     * @param data
     * @param mode
     */
    function fill_timeline_entity_data(data, mode) {
        $(".timeline-playlist-name").html(data['entity_name']);
        $("#timeline_entity_id").val(data['entity_id']);

        $("#save_playlist_bnt").attr("data-mode", mode)
            .attr("data-id", data['entity_id']);

        generate_timeline_follow_bnt(data.is_follow);
    }

    /**
     * 生成时间线关注按钮
     * @param is_follow
     */
    function generate_timeline_follow_bnt(is_follow) {
        var $timeline_playlist_follow = $("#timeline_playlist_follow");
        if(is_follow === "yes"){
            $timeline_playlist_follow.html(StrackLang["UnFollow"]);
            $timeline_playlist_follow.attr("data-follow", "unfollow");
        }else {
            $timeline_playlist_follow.html(StrackLang["Follow"]);
            $timeline_playlist_follow.attr("data-follow", "follow");
        }
    }

    /**
     * 切换列表项关注按钮图标
     * @param id
     * @param follow_status
     */
    function toggle_item_follow_icon(id, follow_status) {
        var $item = $("#playlist_item_"+id).find("a.second");
        switch (follow_status){
            case "unfollow":
                $item.attr("data-follow", "follow");
                $item.html('<i class="icon-uniEA00"></i>');
                break;
            case "follow":
                $item.attr("data-follow", "unfollow");
                $item.html('<i class="icon-uniEA02"></i>');
                break;
        }
    }

    /**
     * 添加审核文件到时间线
     */
    function append_file_to_timeline() {
        var $grid = $('#main_datagrid_box');
        var rows = $grid.datagrid('getSelections');
        if (rows.length >0 ) {
            var ids = [];
            rows.forEach(function (val) {
                ids.push(val['id']);
            });
            $.ajax({
                type: 'POST',
                url: MediaPHP["getTimeLineFileCommitData"],
                data: JSON.stringify({
                    primary_ids: ids.join(','),
                    entity_param: param
                }),
                dataType: 'json',
                contentType: "application/json",
                beforeSend: function () {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                },
                success: function (data) {
                    // 生成时间线
                    generate_timeline(data['rows']);

                    // 初始化拖拽
                    init_timeline_drag();

                    // 取消数据表格选择
                    $grid.datagrid('clearSelections');

                    $.messager.progress('close');
                }
            });
        } else {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        }
    }

    /**
     * 生成时间线
     * @param data
     */
    function generate_timeline(data) {

        // 删除空时间线提示信息
        var $empty_notice = $("#timeline_track .datagrid-empty-no");
        if($empty_notice.length >0 ){
            $empty_notice.remove();
        }

        // 追加播放项到时间线
        data.forEach(function (val) {
            append_track_item(val);
            append_timeline_global_variable(val);
        });

        // 重置时间线宽度
        reset_timeline_width();
    }

    /**
     * 增加到时间线项全局变量
     * @param item
     */
    function append_timeline_global_variable(item) {
        timeline_item_data[item['uuid_md5']] = item;
    }

    /**
     * 初始化时间线拖拽
     */
    function init_timeline_drag() {
        if(param.rule_web_player_drag === "yes"){
            Sortable.create(Strack.get_obj_by_id('timeline_track'), {
                filter : '.triangle,.delete'
            });
        }
    }

    /**
     * 移除指定时间项全局变量数据
     * @param uuid_md5
     */
    function remove_from_timeline_global_variable(uuid_md5) {
        var temp_new = {};
        for(var key in timeline_item_data){
            if(key !== uuid_md5){
                temp_new[key] = timeline_item_data[key];
            }
        }
        timeline_item_data = temp_new;
    }

    /**
     * 清空时间线
     */
    function clear_timeline() {

        // 停止当前播放媒体
        stop_play_current_media();

        // 删除画布
        if(media_view_scene){
            $("#video_main").empty();
            // 停止上一个动画循环
            cancelAnimationFrame(media_view_animation);
            // 退出截屏状态
            cancel_paint_canvas();
        }

        $(".timeline-playlist-name").html(StrackLang['Playlist_Name']);
        $("#timeline_entity_id").val("");

        $("#save_playlist_bnt").attr("data-mode", "add")
            .attr("data-id", "0")
            .find("span").html(StrackLang["Save_Timeline"]);

        // 删除时间线项dom
        $("#timeline_track").empty();

        // 清空时间线项全局变量
        timeline_item_data = {};
        timeline_play_data = {};

        // 重置播放控制
        reset_play_controller();
    }

    /**
     * 重置播放控制器
     */
    function reset_play_controller() {
        
    }

    /**
     * 重载时间线数据
     */
    function reload_timeLine() {

        var $track = $("#timeline_track");

        var track_item = $track.find(".track-item");

        if(track_item.length > 0){

            // 停止当前播放媒体
            stop_play_current_media();

            // 重置播放控制
            reset_play_controller();

            // 重置播放全局变量
            timeline_play_data = {};

            var uuid;
            track_item.each(function (index) {
                uuid = $(this).data("uuid");
                $(this).removeClass("not-load")
                    .addClass("load-active");
                if(timeline_item_data[uuid]){
                    timeline_play_data[index] = timeline_item_data[uuid];
                }
            });

            // 播放时间线
            playback_media(0);

        }else {
            layer.msg(StrackLang['Timeline_Is_Empty'], {icon: 2, time: 1200, anim: 6});
        }
    }

    /**
     * 播放选择时间线项的媒体
     * @param media_data
     * @param index
     */
    function playback_selected_media(media_data, index) {

        // 停止当前播放媒体
        stop_play_current_media();

        playback_media(index);
    }

    /**
     * 显示当前播放项截图缓存
     */
    function show_current_item_screenshot_cache() {
        var item_data = timeline_play_data[media_view_play_index];

        var $screenshot_list = $("#screenshot_list");

        $screenshot_list.empty();

       if( timeline_screenshot_cache[item_data["id"]]){
           timeline_screenshot_cache[item_data["id"]].forEach(function (val) {
               $screenshot_list.append(paint_img_item_dom(val));
           });
       }else {
           $screenshot_list.html('<div class="pyn-st-null">'+StrackLang["Screenshot_Null"]+'</div>');
       }
    }

    /**
     * 清除当前播放项截图缓存
     */
    function remove_current_item_screenshot_cache() {
        var item_data = timeline_play_data[media_view_play_index];
        timeline_screenshot_cache[item_data["id"]] = [];
    }

    /**
     * 播放时间线
     * @param index
     */
    function playback_media(index) {

        // 当前播放媒体序号
        media_view_play_index = index;

        // 获取当序号媒体数据
        var media_param = timeline_play_data[index];

        Strack.G.mediaViewPlayIndex = media_param["id"];

        fill_timeline_item_info(media_param["task_info"]);

        // 应用当前任务的截图缓存
        show_current_item_screenshot_cache();

        // 删除媒体激活状态
        $(".track-item").removeClass("item-active");


        if(media_param["media_data"]["has_media"] === 'yes'){
            // 激活时间线播放项
            $("#track_item_"+media_param["uuid_md5"]).addClass("item-active");
            // 初始化播放器视图
            init_webplayer_view(index, media_param["media_data"]["param"]);
        }else {
            layer.msg(StrackLang['Media_Data_Not_Exist'], {icon: 2, time: 1200, anim: 6});
        }
    }

    /**
     * 填充时间线项任务详细信息
     * @param data
     */
    function fill_timeline_item_info(data) {
        if(param.rule_web_player_metadata === "yes"){
            var meta_title = '',
                meta_show = '';
            data.forEach(function (val) {
                meta_title += '<li class="meta-title">'+val["lang"]+'</li>';
                meta_show += '<li class="meta-show">'+val["value"]+'</li>';
            });
            $("#metadata_name").empty().append(meta_title);
            $("#metadata_show").empty().append(meta_show);
        }
    }

    /**
     * 初始化播放器视图
     * @param index
     * @param media_data
     */
    function init_webplayer_view(index, media_data) {
        var $video_main = $("#video_main");
        var cache_index = Strack.G.mediaViewPlayIndex+"_"+index;

        // 清除视图
        if(media_view_scene){
            //$video_main.empty();
            // 停止上一个动画循环
            cancelAnimationFrame(media_view_animation);
        }

        var texture = null;
        var material = null;

        if(media_material_cache.hasOwnProperty(cache_index)){
            var media_cache = media_material_cache[cache_index];
            media_obj = media_cache.media_obj;
            texture = media_cache.texture;
            material = media_cache.material;

            media_obj.setAttribute('isCache', 'yes');

            // 生成媒体贴图，图片视频分开处理
            if(media_data["type"] === "video"){
                video_frame_obj = VideoFrame({
                    vobj: media_obj,
                    type: "vobj",
                    frameRate: media_data["rate"]
                });
            }
        }else {
            // 生成媒体贴图，图片视频分开处理
            switch (media_data["type"]) {
                case "image":
                    media_obj = document.createElement("img");
                    media_obj.src = media_data["base_url"] + media_data["md5_name"]+'_origin.'+ media_data["ext"];
                    media_obj.crossOrigin = 'anonymous';

                    var img_url = media_data["base_url"]  + media_data["md5_name"]+'_origin.'+ media_data["ext"];
                    var loader = new THREE.TextureLoader();
                    loader.crossOrigin = 'anonymous';
                    texture = loader.load(img_url);
                    break;
                case "video":
                    media_obj = document.createElement("video");
                    media_obj.src = media_data["base_url"] + media_data["md5_name"]+'.'+ media_data["ext"];
                    media_obj.crossOrigin = 'anonymous';

                    video_frame_obj = VideoFrame({
                        vobj: media_obj,
                        type: "vobj",
                        frameRate: media_data["rate"]
                    });

                    // 赋值媒体参数
                    media_obj.width = media_data["width"];
                    media_obj.height = media_data["height"];

                    texture = new THREE.Texture(media_obj);
                    texture.minFilter = THREE.LinearFilter;
                    texture.magFilter = THREE.LinearFilter;
                    texture.format = THREE.RGBFormat;
                    break;
            }


            // 生成贴图
            material = new THREE.MeshLambertMaterial({
                map: texture,
                side: THREE.FrontSide
            });

            media_material_cache[cache_index] = {
                media_obj: media_obj,
                texture : texture,
                material : material
            };

            media_obj.setAttribute('isCache', 'no');
        }

        // 获取视图数据
        var view_width = $video_main.width(),
            view_height = $video_main.height(),
            view_ratio = view_width/view_height;

        // 适配窗口大小，固定片大小 宽度 1280 或者 高度 720 长宽比 1.778
        var media_ratio = media_data["width"] / media_data["height"],
            media_width = 0,
            media_height = 0;

        if(media_ratio > view_ratio){
            media_width = view_width;
            media_height = view_width / media_ratio;
        }else {
            media_width = view_height*media_ratio;
            media_height = view_height;
        }

        // 视图摄像机默认参数
        var fov = 90,
            near = 0.1,
            far = 10000;

        // 媒体第一次渲染
        if(media_render_first){

            //创建Three对象
            media_view_renderer = new THREE.WebGLRenderer({
                antialias: true
            });

            //创建场景摄像机
            media_view_camera = new THREE.PerspectiveCamera(fov, view_width / view_height, near, far);
            media_view_scene = new THREE.Scene();
            media_view_scene.add(media_view_camera);
            media_view_camera.position.z = view_height / 2;

            media_view_renderer.setSize(view_width, view_height);

            //填充资源
            document.getElementById("video_main").appendChild(media_view_renderer.domElement);

            //创建场景环境光
            media_view_light = new THREE.AmbientLight(0xffffff);

            media_view_scene.add(media_view_light);
            media_view_trackball = new THREE.TrackballControls(media_view_camera, media_view_renderer.domElement);

            media_view_plane = new THREE.Mesh(new THREE.PlaneGeometry(media_width, media_height), material);
            media_view_plane.name = "main_version";
            media_view_scene.add(media_view_plane);
        }else {
            //填充资源
            media_view_renderer.setSize(view_width, view_height);

           if( $("#video_main canvas").length <= 0){
               document.getElementById("video_main").appendChild(media_view_renderer.domElement);
           }

            media_view_camera.aspect = view_width / view_height;

            media_view_camera.position.z = view_height/2;

            media_view_camera.updateProjectionMatrix();

            media_view_plane.geometry.vertices[0].x =  '-'+(media_width/2);
            media_view_plane.geometry.vertices[0].y =  media_height/2;
            media_view_plane.geometry.vertices[1].x =  media_width/2;
            media_view_plane.geometry.vertices[1].y =  media_height/2;
            media_view_plane.geometry.vertices[2].x =  '-'+(media_width/2);
            media_view_plane.geometry.vertices[2].y =  '-'+(media_height/2);
            media_view_plane.geometry.vertices[3].x =  media_width/2;
            media_view_plane.geometry.vertices[3].y =  '-'+(media_height/2);

            media_view_plane.geometry.verticesNeedUpdate = true;

            media_view_plane.material = material;
            media_view_plane.material.needsUpdate = true;
        }

        // 重置媒体视图
        reset_media_view_position(index);

        // 执行播放视频或图片
        animate();
        switch (media_data["type"]) {
            case 'image':
                play_image(media_data, 1);
                break;
            case 'video':
                // 加载视频
                var iscache = media_obj.getAttribute('iscache');
                if(iscache === "no"){
                    media_obj.load();
                }
                media_obj.oncanplay = play_video(media_data, iscache);
                break;
        }

        //渲染播放区域
        function render() {
            // 判断媒体是否加载完成
            if(media_data["type"] === "video" && texture && media_obj.readyState === media_obj.HAVE_ENOUGH_DATA){
                texture.needsUpdate = true;
            }
            media_view_renderer.clear();
            media_view_renderer.render(media_view_scene, media_view_camera);
            media_render_first = false;
        }

        //渲染帧动画
        function animate() {
            media_view_trackball.update();
            render();
            media_view_animation = requestAnimationFrame(animate);
        }
    }

    /**
     * 获取媒体当前截屏图像
     */
    function get_media_img_data() {
        media_view_renderer.render(media_view_scene, media_view_camera);
        return media_view_renderer.domElement.toDataURL();
    }

    /**
     * 记录当前视图位置
     * @param index
     */
    function record_media_view_position(index) {
        timeline_play_data[index]["position"] = {
            camera_x : media_view_camera.position.x,
            camera_y : media_view_camera.position.y,
            plane_x : media_view_plane.position.x,
            plane_y : media_view_plane.position.y,
            camera_zoom : media_view_camera.position.z
        };
    }

    /**
     * 重置当前视图显示位置
     * @param index
     */
    function reset_media_view_position(index) {
        if(timeline_play_data[index]["position"]){
            media_view_camera.position.z = timeline_play_data[index]["position"]["camera_zoom"];
            media_view_camera.position.x = timeline_play_data[index]["position"]["camera_x"];
            media_view_camera.position.y = timeline_play_data[index]["position"]["camera_y"];
            media_view_trackball.target.x = timeline_play_data[index]["position"]["camera_x"];
            media_view_trackball.target.y = timeline_play_data[index]["position"]["camera_y"];
            media_view_camera.updateProjectionMatrix();
            media_view_plane.position.set(timeline_play_data[index]["position"]["plane_x"], timeline_play_data[index]["position"]["plane_y"], 0);
        }
    }

    /**
     * 播放图片方法
     * @param media_data
     * @param cframe
     */
    function play_image(media_data, cframe) {

        // 图片默认播放帧速率24
        var msec = 1000 / Strack.G.FrameRates.film;

        // 图片播放3秒
        var max_frame = 72;

        set_player_controller_play("pause");

        // 初始化或者重置播放进度条
        init_media_controller_slider(media_data, max_frame);

        // 执行图片播放
        image_play_interval = setInterval(function (){
            cframe++;

            $media_slider.slider("setValue", cframe);

            set_media_frame_number(cframe, max_frame);

            if(cframe===72){

                // 记录当前播放媒体位置
                record_media_view_position(media_view_play_index);

                if (player_controller_loop === "self_loop") {
                    // 为当前自循环
                    cframe = 1;
                }else {

                    // 暂停已经存在的图片播放
                    image_pause_action();

                    // 循环播放
                    media_loop_check(media_data);
                }
            }
        },msec);
    }


    /**
     * 播放视频方法
     */
    function play_video(media_data, iscache) {
        // 播放视频音量
        media_obj.volume  = player_controller_volume;
        media_obj.currentTime = 0;

        //播放视频
        var playPromise = media_obj.play();

        if(iscache === "no"){
            var max_frame = 0;
            //初始化加载进度条
            media_obj.addEventListener("loadedmetadata", function () {
                //获取总时长
                max_frame = Strack.time_to_frame(media_obj.duration, media_data['rate']);

                // 初始化或者重置播放进度条
                init_media_controller_slider(media_data, max_frame);
            });

            //实时更新进度条
            media_obj.addEventListener("timeupdate", function () {
                var c_frame = Strack.time_to_frame(this.currentTime, media_data['rate']);
                if($media_slider.hasClass("load-ac")) {
                    $media_slider.slider("setValue", c_frame);
                }
                set_media_frame_number(c_frame, max_frame);
            });

            //当前媒体播放结束时候
            media_obj.addEventListener('ended', function () {

                record_media_view_position(media_view_play_index);

                if (player_controller_loop === "self_loop") {
                    // 为当前自循环
                    playback_media(media_view_play_index);
                }else {
                    // 循环播放
                    media_loop_check(media_data);
                }
            });
        }

        if (playPromise !== undefined) {
            playPromise.then(function (value) {
                set_player_controller_play("pause");
            }).catch(function (error) {
                console.log('当前浏览器不允许视频自动播放');
            });
        }
    }

    /**
     * 媒体播放完成循环判断
     */
    function media_loop_check(media_data) {

        var next_index = 0;
        var is_last = false;

        // 获取下一个
        if (parseInt(media_view_play_index) < Object.keys(timeline_play_data).length - 1) {
            // 播放下一个
            next_index = parseInt(media_view_play_index) + 1;
        } else {
            // 播放到末尾了
            next_index = 0;
            is_last = true;
        }

        // 判断是否继续循环播放
        if(player_controller_loop !== 'once' || (player_controller_loop === 'once' && !is_last)){
            playback_media(next_index);
        }else {
            // 停止当前播放媒体
            stop_play_current_media();

            set_player_controller_play("play");
        }
    }

    /**
     * 视频播放继续
     */
    function video_play_action() {
        if(media_obj){
            media_obj.play();
            set_player_controller_play("pause");
        }
    }

    /**
     * 视频播放暂停
     */
    function video_pause_action() {
        if(media_obj){
            media_obj.pause();
            set_player_controller_play("play");
        }
    }

    /**
     * 图片播放暂停
     */
    function image_pause_action() {
        if(image_play_interval){
            window.clearInterval(image_play_interval);
            image_play_interval = null;
            set_player_controller_play("play");
        }
    }

    /**
     * 播放或者暂停媒体播放
     */
    function play_or_pause_media(m_status) {
        if(media_obj){
            var c_status = m_status? m_status : $("#m_controller_player").data("status");
            var media_data = timeline_play_data[media_view_play_index]['media_data']['param'];
            switch (media_data["type"]) {
                case 'image':
                    if(c_status === "play"){
                        image_pause_action();
                    }else {
                        play_image(media_data, $media_slider.slider("getValue"));
                    }
                    break;
                case 'video':
                    if(c_status === "play"){
                        video_pause_action();
                    }else {
                        video_play_action();
                    }
                    break;
            }

            if(Strack.G.mediaScreenshotStatus){
                // 退出截屏
                player_controller_painter();
            }
        }
    }

    /**
     * 媒体逐帧播放
     * @param direction
     */
    function back_or_forward_media(direction) {
        if(!$.isEmptyObject(timeline_play_data)){
            var media_data = timeline_play_data[media_view_play_index]['media_data']['param'];
            switch (media_data["type"]) {
                case 'image':
                    // 暂停图片
                    image_pause_action();
                    var c_slider_val = parseInt($media_slider.slider("getValue"));
                    var c_new_val = 0;
                    if(direction === "back"){
                        c_new_val = c_slider_val > 1 ? c_slider_val - 1 : 1;
                    }else {
                        c_new_val = c_slider_val + 1;
                    }
                    $media_slider.slider("setValue", c_new_val);
                    set_media_frame_number(c_new_val, 72);
                    break;
                case 'video':
                    // 暂停视频
                    video_pause_action();
                    if(direction === "back"){
                        video_frame_obj.seekBackward(1);
                    }else {
                        video_frame_obj.seekForward(1);
                    }
                    break;
            }
        }
    }

    /**
     * 停止当前播放媒体
     */
    function stop_play_current_media() {
        if(!$.isEmptyObject(timeline_play_data)){
            switch (timeline_play_data[media_view_play_index]['media_data']['param']["type"]) {
                case 'image':
                    image_pause_action();
                    break;
                case 'video':
                    video_pause_action();
                    break;
            }
        }
    }

    /**
     * 设置播放器播放控制
     */
    function set_player_controller_play(m_status) {
        var $play_bnt = $("#m_controller_player");
        var c_status = m_status? m_status : $play_bnt.data("status");
        switch (c_status){
            case "pause":
                // 播放媒体
                $play_bnt.data("status", "play");
                $play_bnt.html('<i class="icon-uniEA46"></i>');
                break;
            case "play":
                // 暂停播放
                $play_bnt.data("status", "pause");
                $play_bnt.html('<i class="icon-uniEA45"></i>');
                break;
        }
    }

    /**
     * 设置播放器循环控制
     */
    function set_player_controller_loop() {
        var $loop_bnt = $("#m_controller_loop");
        var c_loop = $loop_bnt.data("loop");
        switch (c_loop) {
            case "all_loop":
                $loop_bnt.data("loop", "once");
                $loop_bnt.html('<i class="icon-uniF178"></i>');
                player_controller_loop = "once";
                break;
            case "once":
                $loop_bnt.data("loop", "self_loop");
                $loop_bnt.html('<i class="icon-uF0030"></i>');
                player_controller_loop = "self_loop";
                break;
            case "self_loop":
                $loop_bnt.data("loop", "all_loop");
                $loop_bnt.html('<i class="icon-uniEA56"></i>');
                player_controller_loop = "all_loop";
                break;
        }
    }

    /**
     * 打开/关闭播放器音量开关
     */
    function set_player_controller_voice() {
        var $voice_bnt = $("#m_controller_voice");
        var c_loop = $voice_bnt.data("voice");

        switch (c_loop){
            case "on":
                //关闭视频声音
                $voice_bnt.data("voice", "off");
                $voice_bnt.html('<i class="icon-uniEA53"></i>');
                //控制声音
                media_obj.volume = 0;
                player_controller_volume = 0;
                break;
            case "off":
                //开启视频声音
                $voice_bnt.data("voice", "on");
                $voice_bnt.html('<i class="icon-uniEA50"></i>');
                //控制声音
                media_obj.volume = 1;
                player_controller_volume = 1;
                break;
        }
    }

    /**
     * 初始化或重置媒体播放器进度条
     */
    function init_media_controller_slider(media_data, max_frame) {

        if(!$media_slider.hasClass("load-ac")){
            // 初始化slider
            $media_slider.find('.default-show').remove();
            $media_slider.addClass("load-ac");

            $media_slider.slider({
                mode: 'h',
                min: 1,
                max: max_frame,
                height: 14,
                step: 1,
                progressbar: true,
                onComplete: function (value) {
                    if (value < max_frame) {
                        var seconds = (value / media_data['rate']).toFixed(2);
                        if(media_data['type'] === 'video'){
                            media_obj.currentTime = seconds;
                        }
                    }
                }
            });
        }else {
            // 重新赋值
            $media_slider.slider("setOptions", {
                max: max_frame
            });
        }
    }

    /**
     * 进入媒体截屏审核操作 (单次最多截屏20张)
     */
    function player_controller_painter() {
        if(media_view_scene) {
            var $painter_bnt = $("#m_controller_painter");
            var active = $painter_bnt.data("active");
            var $left_paint = $(".left-paint");
            var $file_grid = $(".media-file-grid");
            switch (active) {
                case "on":
                    Strack.G.mediaScreenshotStatus = false;
                    $painter_bnt.data("active", "off");
                    $painter_bnt.removeClass('mc-active');
                    $left_paint.hide();
                    // 启用slider
                    $media_slider.slider("enable");
                    $media_slider.slider("setValue", current_slider_number);
                    // 保存画布绘制画布
                    save_paint_canvas();
                    $file_grid.show();
                    break;
                case "off":
                    // 立即停止媒体播放
                    var current_screenshot_number = $("#screenshot_list .pyn-st-img").length + 1; // 查询当前截屏数量
                    if(current_screenshot_number <= 20) {
                        // 隐藏提交文件数据表格
                        $file_grid.hide();
                        play_or_pause_media("play");
                        // 禁用slider
                        $media_slider.slider("disable");
                        current_slider_number = $media_slider.slider("getValue");
                        $painter_bnt.data("active", "on");
                        $painter_bnt.addClass('mc-active');
                        $left_paint.show();
                        // 填充绘制画布
                        fill_paint_canvas();
                        Strack.G.mediaScreenshotStatus = true;
                    }else {
                        layer.msg(StrackLang['Only_Supports_Twenty_Screenshots'], {icon: 2, time: 1200, anim: 6});
                    }
                    break;
            }
        }
    }

    /**
     * 取消截屏状态
     * @private
     */
    function cancel_paint_canvas() {
        var $painter_bnt = $("#m_controller_painter");
        var $left_paint = $(".left-paint");
        $("#vp_canvas_wrap").hide();
        $painter_bnt.data("active", "off");
        $painter_bnt.removeClass('mc-active');
        $left_paint.hide();
        // 启用slider
        $media_slider.slider("enable");
    }

    /**
     * 填充绘制画布
     */
    function fill_paint_canvas() {
        var $wPaint = $("#video_paint");
        var $video_main = $("#video_main");

        // 获取当前视图区域大小
        var view_width = $video_main.width(),
            view_height = $video_main.height();

        $wPaint.css({
            width: view_width,
            height: view_height
        });

        $("#video_paint canvas").attr({
            width: view_width,
            height: view_height
        });


        $wPaint.wPaint("imageBg", get_media_img_data());
        $("#vp_canvas_wrap").show();
    }

    /**
     * 保存绘制画布
     */
    function save_paint_canvas() {
        var $wPaint = $("#video_paint");

        // 隐藏绘制画布，并清空绘制工具栏配置
        $("#vp_canvas_wrap").hide();
        $wPaint.wPaint("clearUndo");

        var imgData = $wPaint.wPaint("image");
        $(".pyn-st-null").remove();

        // 存入当前项截图缓存
        var item_data = timeline_play_data[media_view_play_index];
        if(timeline_screenshot_cache[item_data["id"]] && timeline_screenshot_cache[item_data["id"]].length <20){
            timeline_screenshot_cache[item_data["id"]].push(imgData);
        }else {
            timeline_screenshot_cache[item_data["id"]] = [imgData];
        }

        $("#screenshot_list").append(paint_img_item_dom(imgData));
    }

    /**
     * 视频截图列表
     * @param imgData
     * @returns {string}
     */
    function paint_img_item_dom(imgData) {
        var dom = '';
        dom += '<div class="pyn-st-img aign-left">' +
            '<img src="' + imgData + '">' +
            '<div class="frame">' +
            current_slider_number +
            '</div>' +
            '<a href="javascript:;" class="pyn-st-delete" onclick="obj.remove_screenshot(this)">' +
            '<i class="icon-uniE6DB"></i>'+
            '</a>'+
            '</div>';
        return dom;
    }

    /**
     * 处理媒体播放区域全屏操作
     */
    function toggle_media_view_fullscreen() {
        if(Strack.G.mediaScreenshotStatus){
            // 处于截屏状态不允许播放列表切换
            layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
        }else {
            var $fullscreen_bnt = $("#m_controller_fullscreen");
            var active = $fullscreen_bnt.data("active");
            if (window.fullScreenApi.supportsFullScreen) {
                if (window.fullScreenApi.isFullScreen()) {
                    //取消全屏
                    window.fullScreenApi.cancelFullScreen();
                } else {
                    //全屏
                    window.fullScreenApi.requestFullScreen(document.getElementById('st_media_mid'));
                }
            }
            switch (active) {
                case "on":
                    $fullscreen_bnt.data("active", "off");
                    $fullscreen_bnt.html('<i class="icon-uniE9B4"></i>');
                    break;
                case "off":
                    $fullscreen_bnt.data("active", "on");
                    $fullscreen_bnt.html('<i class="icon-uniE9B5"></i>');
                    break;
            }
        }
    }

    /**
     * 显示隐藏媒体元素据面板
     */
    function toggle_metadata_panel() {
        if(media_view_scene) {
            var $metadata_bnt = $("#m_controller_metadata");
            var active = $metadata_bnt.data("active");
            $("#media_metadata_wrap").toggle();
            switch (active) {
                case "on":
                    $metadata_bnt.data("active", "off");
                    $metadata_bnt.removeClass('mc-active');
                    break;
                case "off":
                    $metadata_bnt.data("active", "on");
                    $metadata_bnt.addClass('mc-active');
                    break;
            }
        }
    }

    /**
     * 设置媒体播放器帧数显示
     * @param cframe
     * @param frame
     */
    function set_media_frame_number(cframe, frame){
        var frame_range = '<span>' + Strack.prefix_integer(cframe, frame.toString().length) + '</span> / <span>' + frame + '</span>';
        $("#preview_frame").html(frame_range);
    }

    /**
     * 增加时间线项
     * @param data
     */
    function append_track_item(data) {
        var $track = $("#timeline_track");
        $track.append(track_item_dom(data));
    }

    /**
     * 重置时间线长度
     */
    function reset_timeline_width() {
        var $track = $("#timeline_track");
        var width = ($track.find(".track-item").length * 200);
        $track.css("width", width);
    }

    /**
     * 重置搜索框
     */
    function reset_search_box() {
        // 清空搜索框
        $("#left_search_val").val("");
        // 清空搜索条件
        load_param["filter"] = '';
    }

    /**
     * 时间线项 dom
     * @param data
     * @returns {string}
     */
    function track_item_dom(data) {
        var dom = '';
        dom += '<li class="text-no-select">' +
            '<div id="track_item_'+data["uuid_md5"]+'" class="track-item not-load aign-left" data-id="'+data["id"]+'" data-uuid="'+data["uuid_md5"]+'">'+
            '<div class="item-header">'+
            '<div class="triangle"></div>'+
            '<div class="version">'+data["version"]+'</div>'+
            '<a href="javascript:;" class="delete" onclick="obj.delete_track_item(this)" data-id="'+data["id"]+'" data-uuid="'+data["uuid_md5"]+'">'+
            '<i class="icon-uniE6DF"></i>'+
            '</a>'+
            '</div>'+
            '<a href="javascript:;"  class="main" onclick="obj.select_track_item(this)" data-id="'+data["id"]+'" data-uuid="'+data["uuid_md5"]+'">'+
            '<div class="item-thumb">'+
            '<img src="'+data["thumb"]+'">'+
            '</div>'+
            '<div class="item-bottom">'+
            '<div class="parent text-ellipsis">'+data["task_name"]+'</div>'+
            '<div class="name text-ellipsis">'+data["name"]+'</div>'+
            '</div>'+
            '</a>'+
            '</div>' +
            '</li>';
        return dom;
    }

    /**
     * 提交保存播放列表，三种模式 add 新增 modify 修改 timeline 仅仅修改时间线
     */
    function submit_save_playlist(mode_data) {
        var allow_up = true;
        var timelineData = {};
        var up_data = {
            mode : mode_data.mode,
            entity_param: param,
            entity_id: mode_data.id,
            entity_data:{},
            step_ids :[],
            task_rows:{},
            file_commit_ids:[]
        };

        // 新增或修改需要，获取检查实体任务信息数据
        if($.inArray(mode_data.mode, ['add', 'modify']) >=0 ){
            // 获取实体数据
            var formData = Strack.validate_form('add_playlist_form');
            if(parseInt(formData['status']) === 404){
                allow_up = false;
            }else {
                up_data['entity_data'] = formData['data'];
            }

            // 获取工序任务数据
            if(allow_up){
                if (!$.isEmptyObject(Strack.G.entityStepTaskAddData.data)) {
                    // 获取当前激活的item
                    var $etask_list = $("#review_entity_step_task");
                    var active_item = $etask_list.find(".etask-l-active");

                    if (active_item.length > 0) {
                        var ac_id = active_item.attr("id"),
                            ac_step_code = active_item.attr("data-stepcode");
                        var check_data = Strack.check_item_operate_fields('#m_review_task_fields', '#m_review_task_item');
                        Strack.G.entityStepTaskAddData.data[ac_step_code][ac_id] = check_data.up_data;
                        if (check_data.allow_up) {
                            active_item.addClass("form_ok");
                        }
                    }

                    // 遍历item判断 任务是否可以提交
                    Strack.G.entityStepTaskAddData.status = true;
                    if(mode_data.mode !== "modify"){
                        $(".stdg-etask-l-item").each(function () {
                            if (!$(this).hasClass("form_ok")) {
                                Strack.G.entityStepTaskAddData.status = false;
                            }
                        });
                    }

                    if (Strack.G.entityStepTaskAddData.status) {
                        up_data["task_rows"] = Strack.G.entityStepTaskAddData.data;
                        up_data["step_ids"] = $('#review_entity_step').combobox('getRowValues', 'id');
                    } else {
                        allow_up = false;
                        layer.msg(StrackLang['Please_Fill_Step_Task_Data'], {icon: 2, time: 1200, anim: 6});
                    }
                }else {
                    allow_up = false;
                    layer.msg(StrackLang['Please_Select_Step'], {icon: 2, time: 1200, anim: 6});
                }
            }

            // 获取时间线数据
            if(allow_up){
                timelineData = get_timeline_data();
                up_data["file_commit_ids"] = timelineData["file_commit_ids"];
                allow_up = timelineData["allow_up"];
            }
        }else {
            timelineData = get_timeline_data();
            up_data["file_commit_ids"] = timelineData["file_commit_ids"];
            allow_up = timelineData["allow_up"];
        }

        if(allow_up){
            $.ajax({
                type : 'POST',
                url : MediaPHP['savePlaylist'],
                data : JSON.stringify(up_data),
                dataType : 'json',
                contentType: "application/json",
                beforeSend : function () {
                    $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                },
                success : function (data) {
                    if($(".add-review-entity").is(':visible') && mode_data.mode === "add"){
                        reset_add_playlist_panel();
                    }
                    $.messager.progress('close');
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        }
    }

    /**
     * 重置播放列表面板
     */
    function reset_add_playlist_panel() {
        // 清除时间线
        clear_timeline();

        // 重置全局变量
        Strack.G.entityStepTaskAddData.status = false;
        Strack.G.entityStepTaskAddData.data = {};

        // 清除添加面板信息
        $("#review_entity_name,#review_entity_code").val("");
        $("#review_entity_status,#review_entity_step").combobox("clear");

        //清除任务列表区域
        $("#review_entity_step_task").empty()
            .append('<div class="datagrid-empty-no">'+StrackLang["Please_Select_Step"]+'</div>');
    }

    /**
     * 获取时间线数据
     * @returns {{allow_up: boolean, file_commit_ids: Array}}
     */
    function get_timeline_data() {
        var $track = $("#timeline_track");
        var track_items = $track.find(".track-item");
        var file_commit_ids = [];
        var allow_up = true;
        if(track_items.length > 0){
            var temp_id = 0;
            track_items.each(function (index) {
                temp_id = $(this).data("id");
                file_commit_ids.push({id: temp_id, index: index+1});
            });
        }else {
            allow_up = false;
            layer.msg(StrackLang['Please_Add_FileCommit_To_Timeline'], {icon: 2, time: 1200, anim: 6});
        }
        return {allow_up: allow_up, file_commit_ids: file_commit_ids}
    }

    /**
     * 加载 datagrid 数据
     */
    function load_grid_data() {
        // 判断 datagrid 是否已经加载
        var $grid = $('#main_datagrid_box');
        if(!$grid.hasClass("datagrid-f")){
            Strack.load_grid_columns('#grid_datagrid_main', {
                loading_id : "#file_grid_panel",
                loading_type: 'black',
                page: param["page"],
                schema_page: 'project_file_commit',
                module_id: param["file_commit_module_id"],
                project_id: param["project_id"],
                grid_id: 'main_datagrid_box',
                view_type: "grid",
                temp_fields: {
                    add : {},
                    cut : {}
                }
            }, function (data) {
                //过滤条件
                var filter_data = {
                    filter: {
                        temp_fields: {
                            add: {},
                            cut: {}
                        },
                        group: data['grid']["group_name"],
                        sort: data['grid']["sort_config"]["sort_query"],
                        request: [
                            {field : 'project_id', value : param.project_id, condition : 'EQ', module_code : 'file_commit', table : 'FileCommit'}
                        ],
                        filter_input: data['grid']["filter_config"]["filter_input"],
                        filter_panel: data['grid']["filter_config"]["filter_panel"],
                        filter_advance: data['grid']["filter_config"]["filter_advance"]
                    },
                    page: param["page"],
                    schema_page: 'project_file_commit',
                    module_id: param["file_commit_module_id"],
                    project_id: param["project_id"]
                };

                // datagrid 距离底部距离
                var bottom_h = $(".media-player-bottom").height() - 53;
                bottom_h = bottom_h>51?bottom_h : 49;

                // datagrid 配置参数
                var gird_param = {
                    url: MediaPHP['getMediaGridData'],
                    height: Strack.panel_height("#file_grid_panel", 0),
                    view:scrollview,
                    rowheight: 50,
                    differhigh: false,
                    singleSelect: false,
                    adaptive: {
                        dom: ".base-m-grid,.datagrid-filter",
                        min_width: 680,
                        exth: bottom_h,
                        domresize: 1
                    },
                    ctrlSelect: true,
                    multiSort: true,
                    DragSelect: true,
                    moduleId: param['file_commit_module_id'],
                    projectId: param['project_id'],
                    queryParams: {
                        filter_data: JSON.stringify(filter_data)
                    },
                    panelConfig: {
                        active_filter_id: data['grid']["filter_config"]["filter_id"]
                    },
                    sortConfig: data['grid']["sort_config"],
                    sortData: data['grid']["sort_config"]["sort_data"],
                    toolbarConfig: {
                        id: 'grid_datagrid_main',
                        page: param["page"],
                        sortAllow: true,
                        groupAllow: true,
                        fieldAllow: true,
                        viewAllow: true,
                        actionAllow: true
                    },
                    searchConfig: {
                        id: 'main_grid_search',
                        bar_show: data['grid']["filter_bar_show"],
                        filterBar: {
                            main_dom: 'grid_datagrid_main',
                            bar_dom: 'grid_filter_main'
                        }
                    },
                    filterConfig: {
                        id: 'grid_filter_main',
                        schema_page: 'project_file_commit',
                        loading_type: null,
                        barParam: {}
                    },
                    authorityRules: {
                        filter: {
                            show : param.rule_file_commit_panel_filter,
                            edit : param.rule_file_commit_modify_filter
                        },
                        sort : param.rule_file_commit_sort,
                        group : param.rule_file_commit_group
                    },
                    contextMenuData: {
                        id: 'st_menu_media',
                        copy_id: 'ac_copy_cell',
                        edit_id: '#grid_datagrid_main .edit-menu',
                        data: []
                    },
                    columnsFieldConfig: data['grid']["columnsFieldConfig"],
                    frozenColumns: data['grid']["frozenColumns"],
                    columns: data['grid']["columns"],
                    toolbar: '#tb_grid',
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 200,
                    pageList: [100, 200, 300, 400, 500],
                    pagePosition: 'bottom',
                    remoteSort: false,
                    onDblClickRow: function (index, row) {
                        // param["item_id"] = row["id"];
                        // Strack.open_datagrid_slider(param);
                    }
                };

                //是否应用分组
                if (!$.isEmptyObject(data['grid']["group_name"])){
                    gird_param["groupActive"] = true;
                    gird_param["groupField"] = Strack.get_grid_group_field(data['grid']["group_name"])["field"];
                    gird_param["groupFormatter"] = function (value, rows) {
                        return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                    };
                }

                $grid.datagrid(gird_param)
                    .datagrid('enableCellEditing')
                    .datagrid('disableCellSelecting')
                    .datagrid('gotoCell',
                        {
                            index: 0,
                            field: 'id'
                        }
                    ).datagrid('columnMoving');
            });
        }else {
            $grid.datagrid("reload");
        }
    }

    /**
     * 切换左侧播放列表标签
     * @param tab
     * @param inside_tab
     * @param url_tag
     */
    function toggle_playlist_tab(tab, inside_tab, url_tag) {
        if(Strack.G.mediaScreenshotStatus){
            // 处于截屏状态不允许播放列表切换
            layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
        }else {
            current_scene = tab;

            if(!url_tag){
                reset_search_box(); // 清空搜索框
            }

            $('.media-review-list .pitem-wrap').removeClass("active");
            $(".playlist-tab").each(function () {
                if($(this).data("tab") === tab){
                    $(this).addClass("active");
                }else {
                    $(this).removeClass("active");
                }
            });
            $('#media_review_'+tab).addClass("active");
            var $grid_button_name = $("#grid_button_left span");
            switch (tab){
                case 'task':
                    $grid_button_name.html(StrackLang["Review_Task"]); // 填充左侧隐藏按钮名称
                    toggle_playlist_inside_tab(inside_tab, url_tag);
                    break;
                case 'playlist':
                    // 隐藏反馈面板
                    $grid_button_name.html(StrackLang["Playlist"]);
                    toggle_playlist_inside_tab(inside_tab, url_tag);
                    break;
            }
        }
    }

    /**
     * 切换播放列表页面内标签
     * @param tab
     * @param url_tag
     */
    function toggle_playlist_inside_tab(tab, url_tag) {
        if(Strack.G.mediaScreenshotStatus){
            // 处于截屏状态不允许播放列表切换
            layer.msg(StrackLang['On_Screenshot'], {icon: 2, time: 1200, anim: 6});
        }else {
            $(".inside-wrap-playlist").removeClass("active");
            $(".playlist-inside-tab").each(function () {
                if ($(this).data("tab") === tab) {
                    $(this).addClass("active");
                } else {
                    $(this).removeClass("active");
                }
            });
            $("#playlist_inside_" + tab).addClass("active");
            load_param['status'] = 'new';
            load_param['page_number'] = 1;
            load_param['page_size'] = 100;
            load_param['tab'] = tab;
            switch (tab) {
                case "my_review":
                    // 由我审核的任务
                    modify_url_address(tab, 'scene=task-my_review');
                    assembly_panel("review_task"); // 组装审核任务初始页面
                    load_param['type'] = 'my';
                    load_param['dom_id'] = '#playlist_inside_my_review';
                    load_review_task_data('#playlist_inside_my_review', load_param, url_tag);
                    break;
                case "all_task":
                    // 所有审核的任务
                    modify_url_address(tab, 'scene=task-all_task');
                    assembly_panel("review_task"); // 组装审核任务初始页面
                    load_param['type'] = 'all';
                    load_param['dom_id'] = '#playlist_inside_all_task';
                    load_review_task_data('#playlist_inside_all_task', load_param, url_tag);
                    break;
                case "my_create":
                    // 我创建的播放列表
                    modify_url_address(tab, 'scene=playlist-my_create');
                    assembly_panel("playlist"); // 组装审核任务初始页面
                    load_param['type'] = 'my';
                    load_param['dom_id'] = '#playlist_inside_my_create';
                    load_playlist_data('#playlist_inside_my_create', load_param, url_tag);
                    break;
                case "all_playlist":
                    // 所有播放列表
                    modify_url_address(tab, 'scene=playlist-all_playlist');
                    assembly_panel("playlist"); // 组装审核任务初始页面
                    load_param['type'] = 'all';
                    load_param['dom_id'] = '#playlist_inside_all_playlist';
                    load_playlist_data('#playlist_inside_all_playlist', load_param, url_tag);
                    break;
                case "follow":
                    // 我关注的播放列表
                    modify_url_address(tab, 'scene=playlist-follow');
                    assembly_panel("playlist"); // 组装审核任务初始页面
                    load_follow_playlist_data('#playlist_inside_follow', load_param, url_tag);
                    break;
            }
        }
    }

    /**
     * 切换右侧审核信息面板标签
     * @param tab
     * @param name
     */
    function toggle_info_tab(tab, name) {
        $('.media-right-wrap .pitem-wrap').removeClass("active");
        $(".media-info-tab").each(function () {
            if($(this).data("tab") === tab){
                $(this).addClass("active");
            }else {
                $(this).removeClass("active");
            }
        });
        $('#media_info_'+tab).addClass("active");
        $("#grid_button_right span").html(name);
        switch (tab){
            case 'note':
                init_note_panel();
                break;
            case 'progress':
                load_review_progress();
                break;
            case 'details':
                load_review_task_info();
                break;
        }
    }

    /**
     * 加载所有播放列表数据
     */
    function load_playlist_data(page_id, load_param, url_tag) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['getReviewPlaylist'],
            data: JSON.stringify(load_param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#st_media_left').prepend(Strack.loading_dom('black', '', 'all'));
            },
            success: function (data) {

                var c_status = load_param.status;

                if(load_param.status === 'new'){
                    if(data.total > 0){
                        $(page_id).empty();
                    }else {
                        $(page_id).empty().append('<div class="datagrid-empty-no">'+StrackLang["Datagird_No_Data"]+'</div>');
                    }
                    load_param.status = 'more';
                    load_param.total = data.total;
                    Strack.fall_load_data(page_id, load_param,
                        function (res_data) {
                            load_playlist_data(page_id, load_param, url_tag);
                        }
                    );
                }

                fill_palylist_list(page_id, load_param, data.rows);

                if(c_status === 'new' && url_tag && url_tag_param["select_id"]) {
                    obj.select_playlist(Strack.get_obj_by_id(url_tag_param["select_id"]));
                }

                $("#st-load_all").remove();
            }
        });
    }

    /**
     * 组装生成播放列表
     * @param page_id
     * @param load_param
     * @param rows
     */
    function fill_palylist_list(page_id, load_param, rows) {
        var group_prefix = 'pl_group_'+load_param.tab+'_';
        var group_id ='';
        rows.forEach(function (val) {
            group_id = group_prefix+val['group_md5'];
            if($('#'+group_id).length === 0){
                $(page_id).append(left_panel_group_dom(group_id, val));
            }

            $('#'+group_id).find(".plist-left-bar")
                .append(playlist_item_dom(load_param.tab, val));
        });
    }

    /**
     * 加载我关注的播放列表数据
     * @param page_id
     * @param load_param
     * @param url_tag
     */
    function load_follow_playlist_data(page_id, load_param, url_tag) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['getReviewFollowPlaylist'],
            data: JSON.stringify(load_param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#st_media_left').prepend(Strack.loading_dom('black', '', 'follow'));
            },
            success: function (data) {
                var c_status = load_param.status;

                if(load_param.status === 'new'){
                    if(data.total > 0){
                        $(page_id).empty();
                    }else {
                        $(page_id).empty().append('<div class="datagrid-empty-no">'+StrackLang["Datagird_No_Data"]+'</div>');
                    }
                    load_param.status = 'more';
                    load_param.total = data.total;
                    Strack.fall_load_data(page_id, load_param,
                        function (res_data) {
                            load_playlist_data(page_id, load_param, url_tag);
                        }
                    );
                }

                fill_palylist_list(page_id, load_param, data.rows);

                if(c_status === 'new' && url_tag && url_tag_param["select_id"]) {
                    obj.select_playlist(Strack.get_obj_by_id(url_tag_param["select_id"]));
                }

                $("#st-load_follow").remove();
            }
        });
    }

    /**
     * 关注审核实体播放列表
     * @param entity_id
     * @param follow_status
     * @param pos
     */
    function playlist_follow(entity_id, follow_status, pos) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['followReviewPlaylist'],
            data: JSON.stringify({
                entity_id: entity_id,
                mode: follow_status,
                entity_param: param
            }),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
            }
        });
    }

    /**
     * 删除审核实体播放列表
     * @param entity_id
     * @param active_status
     * @param progress
     */
    function delete_playlis(entity_id, active_status, progress) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['deleteReviewPlaylist'],
            data: {
                entity_id : entity_id,
                progress: progress
            },
            dataType: 'json',
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                    if(active_status){
                        // 如果为激活状态需要重置媒体区域界面
                        toggle_playlist_inside_tab(load_param.tab);
                    }else {
                        load_review_task_data(load_param['dom_id'], load_param, false);
                    }
                }else {
                    if(parseInt(data['status']) === 205003){
                        $.messager.confirm(StrackLang['Confirmation_Box'], StrackLang['Delete_Review_Playlist_Notice'], function (flag) {
                            if (flag) {
                                delete_playlis(entity_id, active_status, 'continue');
                            }
                        });
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            }
        });
    }

    /**
     * 加载审核任务列表数据
     * @param page_id
     * @param load_param
     * @param url_tag
     */
    function load_review_task_data(page_id, load_param, url_tag) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['getReviewTaskList'],
            data: JSON.stringify(load_param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#st_media_left').prepend(Strack.loading_dom('black', '', 'all'));
            },
            success: function (data) {
                var c_status = load_param.status;
                if(c_status === 'new'){

                    review_task_list_data = {};

                    $(page_id).empty();

                    if(parseInt(data.total) === 0){
                        $(page_id).html('<div class="datagrid-empty-no">'+StrackLang["Datagird_No_Data"]+'</div>');
                    }

                    load_param.status = 'more';
                    load_param.total = data.total;
                    Strack.fall_load_data(page_id, load_param,
                        function (res_data) {
                            load_review_task_data(page_id, load_param, url_tag);
                        }
                    );
                }

                fill_review_task_list(page_id, load_param, data.rows);

                if(c_status === 'new' && url_tag && url_tag_param["select_id"]) {
                    obj.select_review_task(Strack.get_obj_by_id(url_tag_param["select_id"]));
                }

                $("#st-load_all").remove();
            }
        });
    }

    /**
     * 删除指定审核任务
     * @param base_id
     * @param active_status
     */
    function delete_review_task(base_id, active_status) {
        $.ajax({
            type: 'POST',
            url: MediaPHP['deleteReviewTask'],
            data: {
                base_id : base_id
            },
            dataType: 'json',
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                    if(active_status){
                        // 如果为激活状态需要重置媒体区域界面
                        toggle_playlist_inside_tab(load_param.tab, false);
                    }else {
                        load_review_task_data(load_param['dom_id'], load_param, false);
                    }
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    }

    /**
     * 组装生成审核任务列表
     * @param page_id
     * @param load_param
     * @param rows
     */
    function fill_review_task_list(page_id, load_param, rows) {
        var group_prefix = 'pl_group_'+load_param.tab+'_';
        var group_id ='';
        rows.forEach(function (val) {

            review_task_list_data[val["id"]] = val;

            group_id = group_prefix+val['group_md5'];
            if($('#'+group_id).length === 0){
                $(page_id).append(left_panel_group_dom(group_id, val));
            }

            $('#'+group_id).find(".plist-left-bar")
                .append(review_task_item_dom(load_param.tab, val));
        });
    }

    /**
     * 左侧面板分组DOM
     * @param group_id
     * @param data
     * @returns {string}
     */
    function left_panel_group_dom(group_id, data) {
        var dom = '';
        dom += '<div id="'+group_id+'" class="playlist-item-group">'+
            '<div class="playlist-group-title">'+
            '<div class="playlist-g-name aign-left">'+
            '<i class=" icon-uniE717 icon-left"></i>'+
            data['group_name']+
            '</div>'+
            '<a href="javascript:;" class="playlist-g-bnt aign-right" onclick="obj.toggle_playlist_group(this)" data-groupid="'+group_id+'">'+
            '<i class="icon-uniF106 sidebar-icon"></i>'+
            '</a>'+
            '</div>'+
            '<div class="playlist-group-list" id="playlist-group-list1">'+
            '<ul class="plist-left-bar">'+
            '</ul>'+
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 播放列表项DOM
     * @returns {string}
     */
    function playlist_item_dom(tab, data) {
        var dom = '';
        var href_tag = 'scene=playlist-'+tab+'-'+data['id'];

        var follow_status = '';
        var follow_icon = '';
        if(data['is_follow'] === 'yes'){
            follow_status = 'unfollow';
            follow_icon = '<i class="icon-uniEA02"></i>';
        }else {
            follow_status = 'follow';
            follow_icon = '<i class="icon-uniEA00"></i>';
        }

        dom += '<li id="playlist_item_'+data['id']+'" class="play-list-items">'+

            '<a id="item_playlist_'+data['id']+'" href="javascript:;" class="choice" onclick="obj.select_playlist(this)"  data-id="'+data['id']+'" data-urltag="'+href_tag+'">' +
            playlist_item_thumb_dom(data['thumb'])+
            '<div class="playlist-name aign-left">'+
            '<div class="list-name-top text-ellipsis">'+
            '<span class="list_createby">'+data['created_by']+'</span>'+
            '</div>'+
            '<div class="list-name-bottom text-ellipsis">'+data['name']+'</div>'+
            '</div>'+
            '</a>';

        if(param.rule_playlist_delete === "yes"){
            dom += '<a href="javascript:;" class="playlist-button first" onclick="obj.playlist_delete(this)" data-id="'+data['id']+'">'+
                '<i class="icon-uniE6DB"></i>'+
                '</a>';
        }
        if(param.rule_playlist_follow === "yes"){
            dom += '<a href="javascript:;" class="playlist-button second" onclick="obj.playlist_follow(this)" data-id="'+data['id']+'" data-tab="'+tab+'" data-follow="'+follow_status+'">'+
                follow_icon+
                '</a>';
        }
        if(param.rule_playlist_modify === "yes"){
            dom += '<a href="javascript:;" class="playlist-button third" onclick="obj.playlist_edit(this)" data-id="'+data['id']+'">'+
                '<i class="icon-uniE684"></i>'+
                '</a>';
        }

        dom += '</li>';

        return dom;
    }

    /**
     * 播放列表项缩略图DOM
     * @returns {string}
     */
    function playlist_item_thumb_dom(thumb) {
        var dom = '';

        for(var i=thumb.length; i<4; i++){
            thumb[i] =StrackPHP["IMG"]+'/thumb_media_min.jpg';
        }

        dom += '<div class="playlist-thumb aign-left">'+
            '<div class="p-thumb-top">'+
            '<div class="p-thumb-img" style="margin-right:2px">'+
            '<img src="'+thumb[0]+'">'+
            '</div>'+
            '<div class="p-thumb-img">'+
            '<img src="'+thumb[1]+'">'+
            '</div>'+
            '</div>'+
            '<div class="p-thumb-bottom">'+
            '<div class="p-thumb-img" style="margin-right:2px">'+
            '<img src="'+thumb[2]+'">'+
            '</div>'+
            '<div class="p-thumb-img">'+
            '<img src="'+thumb[3]+'">'+
            '</div>'+
            '</div>'+
            '</div>';
        return dom;
    }


    /**
     * 审核任务项DOM
     * @param tab
     * @param data
     * @returns {string}
     */
    function review_task_item_dom(tab, data) {
        var dom = '';
        var href_tag = 'scene=task-'+tab+'-'+data['id'];
        var thumb = data['thumb']? data['thumb'] : StrackPHP["IMG"]+'/excel/excel_tasks.png';

        dom += '<li id="review_task_item_'+data['id']+'" class="play-list-items">'+
            '<a id="item_task_'+data['id']+'" href="javascript:;" class="choice" onclick="obj.select_review_task(this)"  data-id="'+data['id']+'" data-urltag="'+href_tag+'">' +
            '<div class="task-thumb aign-left">'+
            '<img src="'+thumb+'">'+
            '</div>'+
            '<div class="playlist-name text-ellipsis aign-left">'+
            '<div class="list-name-top">'+
            '<span class="list_createby">'+data['created_by']+'</span>'+
            '</div>'+
            '<div class="list-name-bottom">'+data['name']+'</div>'+
            '</div>'+
            '</a>';

        if(param.rule_task_delete === "yes"){
            dom +=  '<a href="javascript:;" class="playlist-button first" onclick="obj.delete_review_task(this)" data-id="'+data['id']+'">'+
                '<i class="icon-uniE6DB"></i>'+
                '</a>';
        }

        dom +='</li>';
        return dom;
    }

    /**
     * 初始化绘图工具栏
     */
    function init_wpaint_panel() {
        $("#video_paint").wPaint({
            menuDom: "#paint_menu",
            menuOrientation: 'vertical',
            imageBg: StrackPHP["PUBLIC"] + '/images/screenshot.png'
        });
    }

    /**
     * 加载 note 页面
     */
    function init_note_panel() {
        var task_data = review_task_list_data[current_review_task_id];

        var note_param = {
            item_id: task_data['id'],
            item_name: task_data['name'],
            module_id: param["task_module_id"],
            module_code: "base",
            module_type: "fixed",
            project_id: param["project_id"],
            template_id: param["template_id"],
            status: 'new',
            page_number: 1,
            page_size: 20
        };

        Strack.load_notes({
            page_id: '.st-media-wrap',
            content_id: '#media_info_note',
            avatar_id: '',
            editor_id: 'comments_editor',
            list_id: 'comments_list',
            tab_id: '.info-tab',
            details_top_bar: false,
            tab_bar_id: ''
        }, note_param);
    }

    /**
     * 加载当前审核任务所属审核实体，审核进度
     */
    function load_review_progress() {
        $.ajax({
            type: 'POST',
            url: MediaPHP['getReviewEntityProgress'],
            data: {
                base_id : current_review_task_id
            },
            dataType: 'json',
            beforeSend: function () {
                $('#st_media_right').prepend(Strack.loading_dom('black', '', 'progress'));
            },
            success: function (data) {
                $("#st-load_progress").remove();
                fill_review_progress_dom(data);
            }
        });
    }

    /**
     * 填充审核实体审核进度DOM
     */
    function fill_review_progress_dom(data) {
        var item_dom;
        var dom = '';
        for(var key in data){
            item_dom = '';
            if(data[key]["list"].length > 0){
                data[key]["list"].forEach(function (val) {
                    item_dom += review_progress_item_dom(val);
                });
                dom += review_progress_group_dom(data[key]["step_name"], item_dom);
            }
        }

        var $review_entity_progress = $("#review_entity_progress")
        if(dom){
            $review_entity_progress.empty().append(dom);
        }else {
            $review_entity_progress.html('<div class="etask-right-null"><div class="datagrid-empty-no">'+StrackLang["Datagird_No_Data"]+'</div></div>');
        }

    }

    /**
     * 审核实体分组DOM
     * @param step_name
     * @param step_dom
     * @returns {string}
     */
    function review_progress_group_dom(step_name, step_dom) {
        var dom = '';
        dom += '<div class="ui fluid vertical steps">'+
            '<div class="step-title">'+
            step_name+
            '</div>'+
            step_dom +
            '</div>';
        return dom;
    }

    /**
     * 审核实体项DOM
     * @param data
     * @returns {string}
     */
    function review_progress_item_dom(data) {
        var dom = '';
        var is_completed = data["status"] === "done" ? "completed" : "";
        var is_active = data["active"] === "yes" ? "active" : "";
        var note_created_by = '', note_text = '';
        if(data["note"]){
            note_created_by = data["note"]["created_by"];
            note_text = data["note"]["text"];
        }
        dom += '<div class="'+is_completed+' '+is_active+' active step">'+
            '<i class="remove icon"></i>'+
            '<div class="content">'+
            '<div class="title">'+note_created_by+'</div>'+
            '<div class="description">'+note_text+'</div>'+
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 加载当前审核任务详细信息
     */
    function load_review_task_info() {
        // 加载 Onset 现场数据字段数据
        var info_param = {
            category : "review_task",
            item_id : current_review_task_id,
            item_name : '',
            module_code : 'base',
            module_id : param.task_module_id,
            schema_page : 'project_base',
            module_type : 'fixed',
            project_id : param.project_id,
            template_id : param.template_id
        };

        Strack.load_info_panel({
            id: "#media_base_info",
            mask: 'media_base_info',
            pos: 'review_task',
            url: MediaPHP["getReviewTaskInfoData"],
            data: info_param,
            loading_type: 'black'
        }, function (data) {
            var media_data = data['media_data'];
            media_data['link_id'] = param["project_id"];
            media_data['module_id'] = param["task_module_id"];
            media_data['param']['icon'] = "icon-uniE61A";
            Strack.thumb_media_widget('#media_base_thumb', media_data, {modify_thumb:param.rule_thumb_modify, clear_thumb:param.rule_thumb_clear});
        });
    }

    /**
     * 媒体键盘操作事件
     */
    function media_keyboard_event() {

        // 标记时间线
        var $media_player = $(".media-player-bottom");
        $media_player.on("mouseenter", function (e) {
            $(this).addClass("mouse-on");
        }).on("mouseleave", function (e) {
            $(this).removeClass("mouse-on");
        });

        // 标记媒体播放区域
        var $media_player_view = $("#media_player_view");
        $media_player_view.on("mouseenter", function (e) {
            $(this).addClass("mouse-on");
        }).on("mouseleave", function (e) {
            $(this).removeClass("mouse-on");
        });

        Strack.listen_keyboard_event(function (e, data) {
            switch (data["code"]){
                case "space":
                    // 空格键（仅仅在鼠标放在时间线上面起作用）
                    if($media_player.hasClass("mouse-on")){
                        e.preventDefault();
                        play_or_pause_media();
                    }
                    break;
                case "left":
                    // 左方向键 媒体后退一格 （仅仅在非截屏状态，鼠标放在时间线上面起作用）
                    if($media_player.hasClass("mouse-on") && !Strack.G.mediaScreenshotStatus){
                        e.preventDefault();
                        back_or_forward_media("back");
                    }
                    break;
                case "right":
                    // 右方向键 媒体前进一格 （仅仅在非截屏状态，鼠标放在时间线上面起作用）
                    if($media_player.hasClass("mouse-on") && !Strack.G.mediaScreenshotStatus){
                        e.preventDefault();
                        back_or_forward_media("forward");
                    }
                    break;
                case "f_key":
                    // f 键 视频适应窗口（仅仅在非截屏状态，鼠标放在媒体播放区域上面起作用）
                    if($media_player_view.hasClass("mouse-on")){
                        e.preventDefault();
                        media_view_fit_size();
                    }
                    break;
                case "i_key":
                    // i 键 快速显示medate信息 （仅仅在非截屏状态，鼠标放在时间线上面起作用）
                    if(param.rule_web_player_metadata === "yes" && ($media_player.hasClass("mouse-on") || $media_player_view.hasClass("mouse-on"))){
                        e.preventDefault();
                        toggle_metadata_panel();
                    }
                    break;
                case "v_key":
                    // v 键 进入或者退出截屏 （仅仅在非截屏状态，鼠标放在时间线上面起作用）
                    if(param.rule_review === "yes" &&
                        param.rule_web_player_painter === "yes" &&
                        ($media_player.hasClass("mouse-on") || $media_player_view.hasClass("mouse-on"))
                    )
                    {
                        e.preventDefault();
                        player_controller_painter();
                    }
                    break;
                case "enter":
                    if($("#left_search_val").is(':focus')){
                        // 搜索状态
                        e.preventDefault();
                        obj.search_left_panel(Strack.get_obj_by_id("left_search_bnt"));
                    }
                    break;
            }
        });
    }

    /**
     * 判断是否阻止浏览器默认事件
     * @param e
     */
    function prevent_default_events(e) {
        var need_codes = [32, 37, 39];
        if($.inArray(e.keyCode, need_codes) >= 0){
            e.stopPropagation();
            e.preventDefault();
        }
    }

    /**
     * 媒体适应窗口
     */
    function media_view_fit_size() {
        if(media_view_scene && !Strack.G.mediaScreenshotStatus){
            var $media_view = $("#video_main");

            var view_width = $media_view.width(),
                view_height = $media_view.height(),
                view_ratio = view_width / view_height;

            $media_view.find("canvas").css({
                "width": view_width,
                "height": view_height
            });

            media_view_camera.position.z = view_height / 2;
            media_view_camera.aspect = view_ratio;
            media_view_camera.updateProjectionMatrix();
            media_view_plane.position.set(media_view_trackball.target.x, media_view_trackball.target.y, 0);
            media_view_renderer.setSize(view_width, view_height);
        }
    }

    /**
     * 修改url地址
     * @param scene
     * @param url_tag
     */
    function modify_url_address(scene, url_tag) {
        var base_url = param.project_id+'.html';
        if(url_tag){
            base_url +='?'+url_tag;
        }
        history.replaceState(null, scene, base_url);
    }
});