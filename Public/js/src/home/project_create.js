$(function () {

    obj = {
        step_prev: function () {
            $step.preStep();
        },
        step_next: function () {
            $step.nextStep();
        },
        // 选择一个模板
        select_template: function (i) {
            $(".step-template").removeClass("step-template-ac");
            $(i).addClass("step-template-ac");
            project_create_data["template_id"] =  $(i).attr("data-tempid");
        },
        // 删除entity磁盘
        delete_disk_item: function (i) {
            var module_id = $(i).attr("data-moduleid");
            $("#entity_disk_"+module_id).remove();
        },
        // 提交新增项目
        step_submit: function () {
            var queueLength = $('#project_thumb_queue .uploadifive-queue-item').length;
            if(queueLength >0){
                // 先上传项目缩略图
                project_create_data.has_media = true;
                $('#choice_project_thumb').uploadifive('upload');
            }else {
                project_create_data.has_media = false;
                submit_add_project();
            }
        },
        // 添加磁盘
        nav_add_disk: function (i) {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Entity_Disk_Title'],
                width: 480,
                height: 370,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[],
                    items:[
                        {case:1,id:'Ndisk_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"",value:""},
                        {case:1,id:'Ndisk_code',type:'text',lang:StrackLang['Code'],name:'code',valid:"",value:""},
                        {case:1,id:'Nwin_path',type:'text',lang:StrackLang['Win_Path'],name:'win_path',valid:"",value:""},
                        {case:1,id:'Nmac_path',type:'text',lang:StrackLang['Mac_Path'],name:'mac_path',valid:"",value:""},
                        {case:1,id:'Nlinux_path',type:'text',lang:StrackLang['Linux_Path'],name:'linux_path',valid:"",value:""}
                    ],
                    footer:[
                        {obj:'submit_add_disk',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){

                }
            });
        },
        // 提交磁盘添加
        submit_add_disk: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['addProjectDisk'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        // 刷新当前页面所有combobox
                        var comb_id;
                        $("#add_project_disk").find('.combobox-f')
                            .each(function () {
                                comb_id = $(this).attr('id');
                                $("#"+comb_id).combobox("reload");
                            });
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 添加更多磁盘
        add_more_disk: function (i) {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_More_Disk_Title'],
                width: 480,
                height: 280,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[
                    ],
                    items:[
                        {case:1,id:'Mdisk_name',type:'text',lang:StrackLang['Name'],name:'name',valid:"1",value:""},
                        {case:1,id:'Mdisk_code',type:'text',lang:StrackLang['Code'],name:'code',valid:"1",value:""},
                        {case:2,id:'Mdisk_list',lang:StrackLang['Disks'],name:'id',valid:'1'}
                    ],
                    footer:[
                        {obj:'add_more_project_disk',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){
                    Strack.combobox_widget('#Mdisk_list', {
                        url: StrackPHP["getDiskCombobox"],
                        valueField: 'id',
                        textField: 'name'
                    });
                }
            });
        },
        // 添加更多磁盘
        add_more_project_disk: function () {
            var data= Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', '', '', {
                extra:function (data) {
                    Strack.dialog_cancel();
                    if($.inArray(data["code"], more_disk_key) === -1){
                        more_disk_key.push(data["code"]);
                        add_more_new_disk_item(data);
                        obj.check_more_project_disk_notice();
                    }else {
                        layer.msg(StrackLang['Project_Disks_Code_Exist'], {icon: 2, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 删除更多磁盘
        delete_more_project_disk: function(i)
        {
            var code = $(i).attr("data-code");
            $("#item_disk_"+code).remove();
            obj.check_more_project_disk_notice();
        },
        // 判断添加更多磁盘显示
        check_more_project_disk_notice: function () {
            if($("#entity_disk_list .disk-setting-item").length>0){
                $("#entity_disk_list .datagrid-empty-no").remove();
            }else {
                $("#entity_disk_list").html('<div class="datagrid-empty-no">'+StrackLang["No_More_Disks_Configured"]+'</div>');
            }
        }
    };

    // 全局变量
    var param = Strack.generate_hidden_param();
    var more_disk_key = [];
    var project_create_data = {
            template_id : 0,
            info : {},
            disk : {},
            has_media: false,
            media: {
                mode: 'single',
                module_id: param.module_id
            }
        },
        Gpage_is_init = [];

    var current_step_error = false;

    var $step = $("#project_step").step({
        mustStep: [1,2],
        stepCallBack: function (step_id) {
            // 验证数据
            check_step_data(step_id);
        }
    });
    
    $step.goStep(1);
    get_template_list();

    /**
     * 验证每个步骤数据
     * @param step_id
     */
    function check_step_data(step_id) {
        var check_list = ['template', 'info', 'disk', 'group'];
        var error_list = {
            'template': StrackLang["Please_Select_Template"],
            'info': StrackLang["Please_Fill_Project_Info"],
            'disk': StrackLang["Please_Set_Disk"],
            'group': ""
        };

        var check_status = true;
        var current_key = 0;
        var current_pos = '';

        check_list.forEach(function (val, index) {
            if( index+1 < step_id && check_status){
                current_pos = val;
                switch (val){
                    case 'template':
                        check_status = check_project_template();
                        break;
                    case 'info':
                        check_status = check_project_info();
                        break;
                    case 'disk':
                        check_status = check_project_disk();
                        break;
                }
                current_key = index+1 ;
                if(!check_status){
                    return false;
                }
            }else {
                return false;
            }
        });

        if(check_status){
            switch (current_key+1){
                case 2:
                    // 判断是否是第一次加载，需要初始化页面
                    if($.inArray(current_key, Gpage_is_init) < 0){
                        Gpage_is_init.push(current_key);
                    }
                    init_project_info();
                    break;
                case 3:
                    // 初始化项目磁盘
                    if($.inArray(current_key, Gpage_is_init) < 0){
                        Gpage_is_init.push(current_key);
                        init_project_disk();
                    }
                    break;
            }
            //判断底部按钮显示

            var $prev = $("#bottom_bnt_prev"),
                $next = $("#bottom_bnt_next"),
                $submit = $("#bottom_bnt_submit");

            $step.goStep(step_id);

            switch (step_id){
                case 1:
                    $prev.hide();
                    $next.show();
                    $submit.hide();
                    break;
                case 3:
                    $prev.show();
                    $next.hide();
                    $submit.show();
                    break;
                default:
                    $prev.show();
                    $next.show();
                    $submit.hide();
                    break;
            }
        }else {
            if(!current_step_error){
                layer.msg(error_list[current_pos], {icon: 2, time: 1200, anim: 6});
            }
        }
    }

    /**
     * 验证项目模板是否选择
     * @returns {boolean}
     */
    function check_project_template() {
        if(project_create_data["template_id"] > 0){
            return true;
        }else {
            return false;
        }
    }

    /**
     * 验证项目数据
     * @returns {boolean}
     */
    function check_project_info() {
        var formData = Strack.validate_form('add_project_info');
        if(parseInt(formData['status']) === 200){
            project_create_data["info"] = formData['data'];
            return true;
        }else {
            current_step_error = true;
            return false;
        }
    }

    /**
     * 验证项目磁盘设置
     */
    function check_project_disk() {
        // 必须设置全局磁盘
        var disk_config = {},
            comb_id;
        var $p_item,id, code,name;
        $("#add_project_disk").find('.combobox-f')
            .each(function () {
                $p_item = $(this).closest(".disk-setting-item");
                comb_id = $(this).attr('id');
                id= Strack.get_combos_val('#' + comb_id, 'combobox', 'getValue');
                if(id){
                    code = $p_item.attr("data-code");
                    name = $p_item.attr("data-name");
                    disk_config[code] = {
                        id : id,
                        code: code,
                        name: name
                    };
                }
            });

        project_create_data['disk'] = disk_config;
        return true;
    }

    /**
     * 初始化项目信息页面
     */
    function init_project_info() {
        var status_id = project_create_data.hasOwnProperty("info") ? project_create_data["info"]["status_id"] : '';
        var project_public = project_create_data.hasOwnProperty("info") ? project_create_data["info"]["public"]: 'yes';
        var start_date = project_create_data.hasOwnProperty("info") ? project_create_data["info"]["start_time"] : '';
        var end_date = project_create_data.hasOwnProperty("info") ? project_create_data["info"]["end_time"] : '';
        var group_open = project_create_data.hasOwnProperty("info") ? project_create_data["info"]["group_open"] : '';

        // 控件不重复初始化
        var $add_project_info = $("#add_project_info");
        if($add_project_info.hasClass("load-active")){
            // 项目状态下拉控件重新赋值
            $('#info_project_status').combobox("setValue", status_id);
        }else {
            $add_project_info.addClass("load-active");

            // 初始化项目状态下拉控件
            Strack.combobox_widget('#info_project_status', {
                url: StrackPHP["getProjectStatusCombobox"],
                valueField: 'id',
                textField: 'name',
                width: 626,
                height: 39,
                value: status_id,
                queryParams: {template_id: project_create_data["template_id"]}
            });

            // 初始化项目公开下拉控件
            project_public = project_public? project_public : 'yes';
            Strack.combobox_widget('#info_project_public', {
                url: StrackPHP["getPublicType"],
                valueField: 'id',
                textField: 'name',
                width: 626,
                height: 39,
                value: project_public
            });

            // 初始化项目开始时间
            $('#info_project_start').datebox({
                width: 626,
                height: 39,
                value : start_date,
                end_limit: "info_project_end"
            });

            // 初始化项目结束时间
            $('#info_project_end').datebox({
                width: 626,
                height: 39,
                value : end_date,
                start_limit: "info_project_start"
            });

            $("#info_project_name").inputmask('*{0,128}');
            $("#info_project_code").inputmask('alphaDash');
            $("#info_project_rate").inputmask('decimal');

            // 初始化团队拷贝开关
            Strack.init_open_switch({
                dom: "#project_group_open",
                value: group_open,
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });

            // 初始化项目缩略图上传控件
            Strack.get_media_server(
                function (media_server) {
                    // 初始化
                    $('#choice_project_thumb').uploadifive({
                        'auto': false,
                        'formData': {
                            timestamp: Strack.current_time(),
                            token: media_server['token'],
                            size : '250x140'
                        },
                        'multi': false,
                        'queueSizeLimit': 1,
                        'queueID': 'project_thumb_queue',
                        'uploadScript': media_server["upload_url"],
                        'onUpload': function (file) {
                            if (file == 0) {
                                layer.msg(StrackLang["Please_Select_File"], {icon: 2, time: 1200, anim: 6});
                            } else {
                                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                            }
                        },
                        'onUploadComplete': function (file, data) {
                            var resJson = JSON.parse(data);
                            if (parseInt(resJson['status']) === 200) {
                                // 上传成功写入数据库
                                project_create_data["media"]["media_server"] = media_server;
                                project_create_data["media"]["media_data"] = resJson['data'];
                                submit_add_project();
                            } else {
                                layer.msg(resJson['message'], {icon: 7, time: 1200, anim: 6});
                            }
                        }
                    });
                },
                function (data) {
                    $("#project_upload_thumbnail").hide();
                }
            );
        }
    }

    /**
     * 提交添加项目信息
     */
    function submit_add_project() {

        // 获取磁盘信息
        check_project_disk();

        $.ajax({
            type : 'POST',
            url : ProjectPHP['addProject'],
            data : JSON.stringify(project_create_data),
            dataType : 'json',
            contentType: "application/json",
            beforeSend : function () {
                if(!project_create_data.has_media){
                    $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                }
            },
            success : function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    layer.msg(data['message'], {
                        icon: 1
                        ,shade: 0.2
                        ,time:1000
                    }, function(){
                        location.href= ProjectPHP['project_create'];
                    });
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    }

    /**
     * 初始化项目
     */
    function init_project_disk() {
        Strack.combobox_widget('#disk_global_combobox', {
            url: StrackPHP["getDiskCombobox"],
            prompt: StrackLang["Please_Select_Disk"],
            valueField: 'id',
            textField: 'name',
            width: 300,
            height: 30,
            onSelect: function (record) {
            }
        });
    }


    /**
     * 添加新的磁盘
     * @param val
     */
    function add_more_new_disk_item(val) {
        $("#entity_disk_list").prepend(disk_item_dom(val));
        Strack.combobox_widget('#disk_'+val['code'], {
            url: StrackPHP["getDiskCombobox"],
            prompt: StrackLang["Please_Select_Disk"],
            valueField: 'id',
            textField: 'name',
            value: val["id"],
            width: 300,
            height: 30,
            onSelect: function (record) {
                val["disk_id"] = param.disk_id;
                update_project_disk(val, record);
            }
        });
    }

    /**
     * 磁盘配置DOM
     * @returns {string}
     */
    function disk_item_dom(data) {
        var dom = '';
        var id = 'disk_'+data['code'];
        dom += '<div id="item_disk_'+data['code']+'" class="ui grid disk-setting-item" data-code="'+data['code']+'" data-name="'+data['name']+'">'+
            '<div class="two column row">'+
            '<div class="five wide column">'+
            '<a href="javascript:;" class="delete-bnt" onclick="obj.delete_more_project_disk(this)" data-code="'+data['code']+'">' +
            '<i class="icon-uniE6DB"></i>'+
            '</a>'+
            '<span class="title">'+
            data['name']+
            '</span>'+
            '</div>'+
            '<div class="eleven wide column combobox">'+
            '<input id="'+id+'" name="'+data['code']+'" autocomplete="off"/>'+
            '</div>'+
            '</div>'+
            '</div>';
        return dom;
    }

    /**
     * 获取模板列表
     */
    function get_template_list() {
        $.ajax({
            type: 'POST',
            url: ProjectPHP['getTemplateList'],
            dataType: 'json',
            beforeSend: function () {
                $('.project-step-content').append(Strack.loading_dom('white', '', 'template'));
            },
            success: function (data) {
                var $built_in = $("#template_builtin_list"),
                    built_exit = true;
                var $project = $("#template_project_list"),
                    project_exit = true;
                data["rows"].forEach(function (val) {
                    if(parseInt(val["project_id"]) === 0){
                        if(built_exit){
                            $built_in.empty();
                            built_exit = false;
                        }
                        $built_in.append(template_dom(val));
                    }else {
                        if(project_exit){
                            $project.empty();
                            project_exit = false;
                        }
                        $project.append(template_dom(val));
                    }
                });
                $(".st-load").remove();
            }
        });
    }

    /**
     * 模板dom
     * @param data
     * @returns {string}
     */
    function template_dom(data) {
        var dom ='', icon = '';
        if(parseInt(data["project_id"]) === 0){
            icon = '<div class="panel-thumb-null"><i class="icon-uniF1ED"></i></div>';
        }else {
            if(data.hasOwnProperty("thumb")){
                icon = '<img src="'+data["thumb"]+'">';
            }else {
                icon = '<div class="panel-thumb-null"><i class="icon-uniF1ED"></i></div>';
            }
        }
        dom += '<a href="javascript:;" class="wide column step-template" onclick="obj.select_template(this)" data-tempid="'+data["project_template_id"]+'">'+
            '<div class="template-item">'+
            '<div class="template-card">'+
            icon+
            '<p class="template-name">'+data["name"]+'</p>'+
            '</div>'+
            '</div>'+
            '</a>';
        return dom;
    }
});