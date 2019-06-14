$(function(){
    obj={
        // 添加项目模板
        template_add: function () {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Project_Template'],
                width: 480,
                height: 310,
                content: Strack.dialog_dom({
                    type:'normal',
                    items:[
                        {case:1,id:'Nname',lang:StrackLang['Name'],name:'name',valid:'1,128',value:""},
                        {case:1,id:'Ncode',lang:StrackLang['Code'],name:'code',valid:'1,128',value:""},
                        {case:2,id:'Nschema',lang:StrackLang['Schema'],name:'schema_id',valid:1}
                    ],
                    footer:[
                        {obj:'template_add_submit',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits: function () {
                    //初始化控件
                    Strack.combobox_widget('#Nschema', {
                        url: TemplatePHP["getEntitySchemaComboboxList"],
                        valueField: 'id',
                        textField: 'name',
                        width: 378,
                        height: 26
                    });
                },
                close:function(){

                }
            });
        },
        // 提交项目模板添加
        template_add_submit: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', TemplatePHP['addProjectTemplate'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        obj.reset_template_list();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        // 执行项目模板信息过滤
        template_filter: function () {
            var search_val = $("#search_val").val();
            if(search_val.length>0){
                Gfilter = {'name':['-lk', "%"+search_val+"%"]};
            }else {
                Gfilter = '';
            }
            obj.reset_template_list();
        },
        // 项目模板信息修改
        template_modify: function (i) {
            var temp_id = $(i).data("tempid"),
                temp_name = $(i).data("tempname"),
                temp_code = $(i).data("tempcode");

            Strack.open_dialog('dialog',{
                title: StrackLang['Modify_Project_Template_Title'],
                width: 480,
                height: 280,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[
                        {case:101,id:'Mtemplate_id',type:'hidden',name:'id',valid:1,value:temp_id}
                    ],
                    items:[
                        {case:1,id:'name',lang:StrackLang['Name'],name:'name',valid:'1,128',value:temp_name},
                        {case:1,id:'code',lang:StrackLang['Code'],name:'code',valid:'1,128',value:temp_code}
                    ],
                    footer:[
                        {obj:'template_modify_submit',type:1,title:StrackLang['Update']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                close:function(){

                }
            });
        },
        // 项目模板修改提交
        template_modify_submit: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', TemplatePHP['modifyProjectTemplate'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        obj.reset_template_list();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        template_to_default: function (i) {
            var temp_id = $(i).data("tempid"),
                temp_name = $(i).data("tempname");

            if(temp_id > 0){
                Strack.open_dialog('dialog',{
                    title: StrackLang['Template_Rollback_Default'],
                    width: 480,
                    height: 220,
                    content: Strack.dialog_dom({
                        type:'normal',
                        hidden:[
                            {case:101,id:'Mtemplate_id',type:'hidden',name:'src_template_id',valid:1,value:temp_id}
                        ],
                        items:[
                            {case:1,id:'Mdist_template',lang:StrackLang['Builtin_template'],name:'dist_template_id',valid:1,value:temp_name},
                        ],
                        footer:[
                            {obj:'project_template_reset',type:1,title:StrackLang['Update']},
                            {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                        ]
                    }),
                    inits:function(){
                        Strack.combobox_widget('#Mdist_template', {
                            url: TemplatePHP["getProjectBuiltinTemplateList"],
                            valueField: 'project_template_id',
                            textField: 'name'
                        });
                    }
                });
            }
        },
        // 项目内置模板重置
        project_template_reset: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', TemplatePHP['resetTemplateConfig'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        obj.reset_template_list();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        template_delete: function (i) {
            var temp_id = $(i).data("tempid");
            Strack.ajax_base_delete(temp_id,StrackLang['Del_Template_Notice'], TemplatePHP['deleteProjectTemplate'], function (data) {
                obj.reset_template_list();
            });
        },
        // 选择一个模板
        select_template: function (i) {
            var temp_id = $(i).data("tempid"),
                temp_name = $(i).data("tempname"),
                temp_code = $(i).data("tempcode"),
                project_id = $(i).data("pid");

            $("#hide_temp_id").val(temp_id);
            $("#hide_temp_name").val(temp_name);
            $("#hide_temp_code").val(temp_code);
            $("#hide_project_id").val(project_id);

            $('.templates-items').removeClass('templates-active');
            $('#temp_id_'+temp_id).addClass('templates-active');


            $(".temp-content-right-no").show();
            $(".temp-set-main").hide();

            $(".temp-setlist-no").hide();
            $(".temp-setlists").show();

            //加载模块列表
            get_module_list(temp_id);
        },
        // 选择一个模板
        select_module: function (i) {
            var module_id = $(i).data("moduleid"),
                module_name = $(i).data("modulename"),
                module_type = $(i).data("moduletype"),
                module_code = $(i).data("modulecode");

            var page_type;
            var $base_tfield =  $("#temp_base_tfield"),
                $tfixed_tab = $("#temp_fixed_tab");
            switch (module_type){
                case "entity":
                    page_type = module_type;
                    break;
                default:
                    switch (module_code){
                        case "base":
                            $base_tfield.show();
                            $tfixed_tab.show();
                            page_type = module_type;
                            break;
                        case "onset":
                        case "file":
                        case "file_commit":
                        case "timelog":
                            $base_tfield.hide();
                            $tfixed_tab.hide();
                            page_type = module_type;
                            break;
                        default:
                            page_type = module_code;
                            break;
                    }
                    break;
            }


            $(".nation-items").removeClass("admin-bid-ac");
            $(i).addClass("admin-bid-ac");

            $("#hide_module_id").val(module_id);
            $("#hide_module_name").val(module_name);
            $("#hide_module_code").val(module_code);

            $(".temp-content-right-no").hide();
            $(".temp-set-main").hide();
            $("#temp_set_"+page_type).show();
        },
        reset_template_list: function () {
            $(".temp-content-right-no").show();
            $(".temp-set-main").hide();
            $(".temp-setlist-no").show();
            $(".temp-setlists").hide();
            $("#hide_temp_id").val("");
            $("#hide_temp_name").val("");
            $("#hide_temp_code").val("");
            get_temp_list(Gfilter);
        },
        // 设置项目显示导航
        project_set_nav: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();

            template_set_dialog({'datalist_url': TemplatePHP["getProjectNavModuleList"], 'title': title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'module_id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Module"], 'group' : 'module_name', 'limit': 0});
        },
        // 设置项目可以状态
        template_set_status: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_dialog({'datalist_url': TemplatePHP["getStatusDataList"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Status"], 'group' : 'correspond_name', 'limit': 0});
        },
        template_set_tag: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_dialog({'datalist_url': TemplatePHP["getTagDataList"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Tag"], 'group' : 'type', 'limit': 0});
        },
        template_set_sort: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();

            template_set_sort({'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'fields' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'belong_table', 'limit': 3});
        },
        template_set_group:function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_dialog({'datalist_url': TemplatePHP["getModuleRelationColumns"],'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'fields' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'belong_table', 'limit': 1});
        },
        template_set_field: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            var limit = 0;
            if(category === "top_field"){
                limit = 3;
            }
            template_set_dialog({'datalist_url': TemplatePHP["getModuleBaseColumns"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'field_group_id' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'belong_table', 'limit': limit});
        },
        template_set_tab: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_dialog({'datalist_url': TemplatePHP["getModuleTabList"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'tab_id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Tab"], 'group' : 'group', 'limit': 0});
        },
        template_set_link_onset: function(i)
        {
            var category = $(i).attr("data-category");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();

            Strack.open_dialog('dialog',{
                title: StrackLang['Link_Onset_Switch'],
                width: 480,
                height: 220,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[
                        {case:101,id:'Mcategory',type:'hidden',name:'category',valid:1,value: category},
                        {case:101,id:'Mmodule_id',type:'hidden',name:'module_id',valid:1,value: module_id},
                        {case:101,id:'Mmodule_code',type:'hidden',name:'module_code',valid:1,value: module_code},
                        {case:101,id:'Mtemplate_id',type:'hidden',name:'template_id',valid:1,value: temp_id}
                    ],
                    items:[
                        {case:2,id:'Mlink_onset_switch',lang:StrackLang['Switch'],name:'link_onset',valid:''}
                    ],
                    footer:[
                        {obj:'modify_set_link_onset',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits:function(){
                    $.ajax({
                        type: 'POST',
                        url: TemplatePHP["getTemplateConfig"],
                        dataType: 'json',
                        data:{
                            template_id: temp_id,
                            module_code: module_code,
                            category : category
                        },
                        beforeSend:function(){
                            $('#dialog').prepend(Strack.loading_dom('white','','config'));
                        },
                        success: function (data) {

                            var val = data["switch"] ? data["switch"] : 0;
                            Strack.init_open_switch({
                                dom: '#Mlink_onset_switch',
                                onText: StrackLang['Switch_ON'],
                                offText: StrackLang['Switch_OFF'],
                                value: val,
                                width: 100
                            });

                            $("#st-load_config").remove();
                        }
                    });
                }
            });
        },
        modify_set_link_onset: function()
        {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', TemplatePHP['modifyTemplateConfig'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        // 刷新当前页面所有combobox
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            },{
                extra: function (data) {
                    data["config"] = {
                        "switch" : data["link_onset"]
                    };
                    return data;
                }
            });
        },
        template_set_step: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_dialog({'datalist_url': TemplatePHP["getTemplateStepList"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Steps"], 'group' : '', 'limit': 0});
        },
        template_entity_step_field: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            var limit = 0;
            template_set_dialog({'datalist_url': TemplatePHP["getModuleBaseColumns"],'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':4, 'category': category, 'id_field' : 'field_group_id' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'belong_table', 'limit': limit});
        },
        template_set_relationship: function (i) {
            var category = $(i).attr("data-category"),
                title = $(i).attr("data-title");
            var module_id = $("#hide_module_id").val();
            var module_code = $("#hide_module_code").val();
            var temp_id = $("#hide_temp_id").val();
            template_set_relationship({'datalist_url': TemplatePHP["getModuleRelationConfig"], 'title':title, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'category': category, 'id_field' : 'fields' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'field_group'});
        },
        update_config_set: function () {
            var temp_id = $('#Mtemp_id').val(),
                module_code = $('#Mmodule_code').val(),
                category = $('#Mcategory').val(),
                id_field = $('#Mid_field').val(),
                rows =  $('#template-columns').datagrid('getRows');

            var config = [];
            rows.forEach(function (val) {
                switch (category){
                    case "navigation":
                        config.push(val);
                        break;
                    case "note_tag":
                        config.push({"id": val["id"], "name": val["name"], "type": val["type"]});
                        break;
                    case "column":
                    case "main_field":
                        config.push({"fields": val[id_field], "module": val["module"], "table": val["table"]});
                        break;
                    case "group":
                        config.push({
                            "fields": val[id_field],
                            "field": val["fields"],
                            "field_type": val["field_type"],
                            "module": val["module"],
                            "module_code": val["module_code"],
                            "value_show": val["value_show"],
                            "table": val["table"],
                            "order": 'asc'
                        });
                        break;
                    case "tab":
                    case "step":
                    case "sort":
                    case "top_field":
                    case "step_fields":
                        config.push(val);
                        break;
                    default:
                        var temp = {};
                        temp[id_field] = val[id_field];
                        config.push(temp);
                        break;
                }
            });

            submit_template_config(temp_id, module_code, category, config);
        },
        //保存排序模板设置
        update_sort_config_set: function () {
            var temp_id = $('#Mtemp_id').val(),
                module_code = $("#hide_module_code").val(),
                category = $('#Mcategory').val(),
                id_field = $('#Mid_field').val(),
                sort_index = ['first', 'second', 'third'];
            var config = [];
            sort_index.forEach(function (val) {
                var sort_val = $("#sort_"+val).combobox("getRowValue", "id"),
                    sort_func = $("#sort_"+val+"_func").combobox("getValue");

                if(sort_val){
                    if(!sort_func){
                        sort_func = 'asc';
                    }
                    config.push({
                        "index": val,
                        "field": sort_val["fields"],
                        "fields": sort_val["fields"],
                        "field_type": sort_val["field_type"],
                        "module": sort_val["module"],
                        "module_code": sort_val["module_code"],
                        "value_show": sort_val["value_show"],
                        "table": sort_val["table"],
                        "order": sort_func
                    });
                }
            });

            submit_template_config(temp_id, module_code, category, config);
        },
        update_relation_config_set: function () {
            var temp_id = $('#Mtemp_id').val(),
                category = $('#Mcategory').val(),
                module_code = $('#Mmodule_code').val();

            var config = [];

            $(".st-dialog-input").each(function () {
                var name = $(this).attr("data-name");
                var from_id = $("#first_"+name).combobox("getValue"),
                    to_id = $("#second_"+name).combobox("getValue");
                config.push({"from": from_id, "to": to_id});
            });

            submit_template_config(temp_id, module_code, category, config);
        }
    };


    var param = Strack.generate_hidden_param();
    var Gfilter = '';

    get_temp_list(Gfilter);

    /**
     * 键盘事件
     */
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter"){
            // 按回车键搜索
            if($("#search_val").is(':focus')){
                // 搜索项目模板
                e.preventDefault();
                obj.template_filter(Strack.get_obj_by_id("search_template_bnt"));
            }
        }
    });

    /**
     * ajax加载项目模板列表
     * @param filter
     */
    function get_temp_list(filter){
        $.ajax({
            url:TemplatePHP['getTemplateList'],
            type: 'POST',
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify({
                filter : filter
            }),
            beforeSend:function(){
                $('#template_list').empty().append(Strack.loading_dom('null'));
            },
            success:function(data){
                var tlist='';
                var $temp_list = $('#template_list');
                var temp_id = $('#hide_temp_id').val();

                data["rows"].forEach(function (val) {
                    tlist += temp_list(val);
                });

                if(tlist){
                    $("#template_active_notice").remove();
                    $temp_list.append(tlist);
                }else {
                    if($("#template_active_notice").length === 0){
                        $temp_list.before('<div id="template_active_notice" class="datagrid-empty-no">'+StrackLang["No_Project_Template_List"]+'</div>');
                    }
                }

                //选中当前已经选中的模板
                if(temp_id > 0){
                    obj.select_template($("#temp_id_"+temp_id).find('a'));
                }
                $('#st-load').remove();
            }
        });
    }

    /**
     * 项目模板 list DOM
     * @param tempData
     * @returns {string}
     */
    function temp_list(tempData){
        var templist='';
        templist +='<li id="temp_id_'+tempData["project_template_id"]+'" class="templates-items" >'+
            '<div class="role-name text-ellipsis aign-left">' +
            '<a href="javascript:;" class="list-item" onclick="obj.select_template(this);" data-pid="'+tempData["project_id"]+'"  data-tempid="'+tempData["project_template_id"]+'" data-tempname="'+tempData["name"]+'" data-tempcode="'+tempData["code"]+'">'+
            tempData["name"] +
            '</a>' +
            '</div>' +
            '<div class="role-bnt aign-right">';

        if(param.rule_modify === "yes"){
            templist +='<a href="javascript:;" class="aign-left" onclick="obj.template_modify(this);" data-tempid="' + tempData["project_template_id"] + '" data-tempname="' + tempData["name"] + '" data-tempcode="' + tempData["code"] + '">' +
                '<i class="icon-uniE684"></i>' +
                '</a>';
        }
        if(param.rule_reset === "yes") {
            templist += '<a href="javascript:;" class="aign-left" onclick="obj.template_to_default(this);" data-tempid="' + tempData["project_template_id"] + '" data-tempname="' + tempData["name"] + '">' +
                '<i class="icon-uniF01E"></i>' +
                '</a>';
        }

        if(param.rule_delete === "yes") {
            templist += '<a href="javascript:;" class="aign-left" onclick="obj.template_delete(this);" data-tempid="' + tempData["project_template_id"] + '">' +
                '<i class="icon-uniE6DB"></i>' +
                '</a>';
        }

        templist +='</div>' +
            '</li>';
        return templist;
    }

    /**
     * 获取系统可以设置模块列表
     * @param temp_id
     */
    function get_module_list(temp_id) {
        $.ajax({
            url:TemplatePHP['getProjectTemplateModuleList'],
            type: 'POST',
            dataType: 'json',
            data: {
                template_id : temp_id
            },
            beforeSend:function(){
                $('#temp_module').append(Strack.loading_dom('white','','module'));
            },
            success:function(data){
                var dom = '',
                    type_list = ['fixed', 'entity'];

                // 填充项目数据结构名称
                $("#project_schema_name").html(data["schema_name"]);

                //模块列表
                type_list.forEach(function (type) {
                    dom += '<li class="module-items-title">'+data[type]["title"]+'</li>';
                    data[type]['data'].forEach(function (val) {
                        if(val["code"] !== "media"){
                            dom += module_list_dom(val);
                        }
                    });
                });

                $("#module_list").empty().append(dom);
                $('#st-load_module').remove();
            }
        });
    }

    /**
     * 模块列表DOM
     * @param data
     * @returns {string}
     */
    function module_list_dom(data){
        var dom = '';
        dom += '<a href="javascript:;" class="nation-items" onclick="obj.select_module(this)" data-moduleid="'+data["id"]+'" data-modulename="'+data["name"]+'" data-moduletype="'+data["type"]+'" data-modulecode="'+data["code"]+'">'+
                    '<div class="nation-items-wrap min">'+
                        '<div class="aign-left">' +
                            '<i class="'+data["icon"]+' icon-left"></i>'+
                            '<span>'+data["name"]+'</span>'+
                        '</div>'+
                    '</div>'+
                '</a>';
        return dom;
    }


    /**
     * 模板设置对话框
     * @param param
     */
    function template_set_dialog(param){
        Strack.open_dialog('dialog',{
            title: param["title"],
            width: 800,
            height: 520,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mtemp_id',type:'hidden',name:'temp_id',valid:1,value:param['temp_id']},
                    {case:101,id:'Mid_field',type:'hidden',name:'id_field',valid:1,value:param['id_field']},
                    {case:101,id:'Mmodule_code',type:'hidden',name:'module_code',valid:1,value:param['module_code']},
                    {case:101,id:'Mcategory',type:'hidden',name:'category',valid:1,value:param['category']}
                ],
                items:[
                    {case:5,id:'',type:'text',lang:'',name:'',valid:'',value:0}
                ],
                footer:[
                    {obj:'update_config_set', type:1, title:StrackLang['Update']},
                    {obj:'dialog_cancel', type:8, title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                var $Rdatagrid;
                $('#template-field').datalist({
                    url: param['datalist_url'],
                    width:320,
                    height:380,
                    idField:param["id_field"],
                    valueField:param["id_field"],
                    textField:param["text_field"],
                    groupField:param["group"],
                    checkbox: true,
                    singleSelect: false,
                    queryParams:{
                        module_code: param["module_code"],
                        category : param['category'],
                        module_id : param['module_id'],
                        project_id: 0,
                        template_id : param['temp_id']
                    },
                    onLoadSuccess:function(data){

                        var $datalist = $(this);

                        $.ajax({
                            type:'POST',
                            url: TemplatePHP["getTemplateConfig"],
                            dataType: 'json',
                            data:{
                                template_id: param["temp_id"],
                                module_code: param["module_code"],
                                category : param['category']
                            },
                            beforeSend:function(){
                                $('#dialog').prepend(Strack.loading_dom('white','','config'));
                            },
                            success:function(data){
                                var columns = [
                                    {field: param["id_field"], checkbox: true},
                                    {field: param["text_field"], title: param["text_field_lang"], align: 'center', width: 160}
                                ];

                                if(param["group"]){
                                    columns.push({field: param["group"], title: StrackLang['Group'], align: 'center', width: 160});
                                }

                                $('#template-columns').datagrid({
                                    data:[],
                                    width:380,
                                    height:380,
                                    rownumbers:true,
                                    fitColumns:true,
                                    columns:[columns],
                                    dragSelection: true,
                                    onLoadSuccess: function(){
                                        $Rdatagrid = $(this);
                                        $Rdatagrid.datagrid('enableDnd');
                                    }
                                });

                                //选择赋值
                                data.forEach(function (val) {
                                    $datalist.datalist('selectRecord', val[param["id_field"]]);
                                });

                                $("#st-load_config").remove();
                            }
                        });
                    },
                    onSelect:function(index, row){
                        // //选中一行 判断
                        var $columns=$('#template-columns');
                        $columns.datagrid('appendRow',row);
                        $Rdatagrid.datagrid('enableDnd');
                        if(param["limit"] >0 ){
                            var rows = $columns.datagrid('getRows');
                            if(rows.length > param["limit"]){
                                $(this).datagrid('unselectRow', index);
                            }
                        }
                    },
                    onUnselect:function(index, row){
                        //取消选中一行，获取当前选择取消row行号
                        var $columns=$('#template-columns'),
                            rownum = $columns.datagrid('getRowIndex',row);
                        $columns.datagrid('deleteRow',rownum);
                    }
                });
            }
        });
    }

    /**
     * 模板设置排序
     * @param param
     */
    function template_set_sort(param) {
        Strack.open_dialog('dialog', {
            title: param["title"],
            width: 420,
            height: 320,
            content: Strack.dialog_dom({
                type: 'adv_sort',
                hidden: [
                    {case:101,id:'Mtemp_id',type:'hidden',name:'temp_id',valid:1,value:param['temp_id']},
                    {case:101,id:'Mid_field',type:'hidden',name:'id_field',valid:1,value:param['id_field']},
                    {case:101,id:'Mmodule_code',type:'hidden',name:'module_code',valid:1,value:param['module_code']},
                    {case:101,id:'Mcategory',type:'hidden',name:'category',valid:1,value:param['category']}
                ],
                footer: [
                    {obj: 'update_sort_config_set', type: 1, title: StrackLang['Update']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {

                Strack.combobox_widget('#sort_first,#sort_second,#sort_third', {
                    url: TemplatePHP["getTemplateDataList"],
                    valueField: param["id_field"],
                    textField: param["text_field"],
                    width: 160,
                    height: 25,
                    groupField: param["group"],
                    queryParams:  {
                        category : param['category'],
                        module_id : param['module_id'],
                        project_id : 0,
                        template_id : param['temp_id']
                    }
                });

                Strack.combobox_widget('#sort_first_func,#sort_second_func,#sort_third_func', {
                    url: StrackPHP["getSortList"],
                    valueField: 'id',
                    textField: 'name',
                    width: 110,
                    height: 25
                });

                $.ajax({
                    type:'POST',
                    url: TemplatePHP["getTemplateConfig"],
                    dataType: 'json',
                    data:{
                        template_id: param["temp_id"],
                        category : param['category'],
                        module_code: param['module_code']
                    },
                    beforeSend:function(){
                        $('#dialog').prepend(Strack.loading_dom('white','','config'));
                    },
                    success:function(data){
                        data.forEach(function (val) {
                            $("#sort_"+val["index"]).combobox("setValue", val["field"]);
                            $("#sort_"+val["index"]+"_func").combobox("setValue", val["order"]);
                        });
                        $("#st-load_config").remove();
                    }
                });
            }
        });
    }

    /**
     * 设置关联关系
     * @param param
     */
    function template_set_relationship(param) {
        Strack.open_dialog('dialog', {
            title: param["title"],
            width: 720,
            height: 420,
            content: Strack.dialog_dom({
                type: 'relationship_set',
                hidden: [
                    {case:101,id:'Mtemp_id',type:'hidden',name:'temp_id',valid:1,value:param['temp_id']},
                    {case:101,id:'Mmodule_id',type:'hidden',name:'module_id',valid:1,value:param['module_id']},
                    {case:101,id:'Mid_field',type:'hidden',name:'id_field',valid:1,value:param['id_field']},
                    {case:101,id:'Mmodule_code',type:'hidden',name:'module_code',valid:1,value:param['module_code']},
                    {case:101,id:'Mcategory',type:'hidden',name:'category',valid:1,value:param['category']}
                ],
                footer: [
                    {obj: 'update_relation_config_set', type: 1, title: StrackLang['Update']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                $.ajax({
                    type:'POST',
                    url: param["datalist_url"],
                    dataType: 'json',
                    data:{
                        template_id: param["temp_id"],
                        module_id: param["module_id"],
                        module_code : param['module_code'],
                        category : param['category']
                    },
                    beforeSend:function(){
                        $('#dialog').prepend(Strack.loading_dom('white','','config'));
                    },
                    success:function(data){

                        var dom = '';
                        data["exist"].forEach(function (val) {
                            dom += '<tr>' +
                                '<td>'+ val["from"] +'</td>' +
                                '<td>'+ val["to"] +'</td>' +
                                '</tr>';
                        });

                        $("#related_module_list").append(dom);

                        // data["config"].forEach(function (val) {
                        //     var random = Strack.dialog_relationship_item();
                        //     $("#first_"+random).combobox("setValue", val["from"]);
                        //     $("#second_"+random).combobox("setValue", val["to"]);
                        // });
                        $("#st-load_config").remove();
                    }
                });
            }
        });
    }

    /**
     * 提交模板设置
     * @param temp_id
     * @param module_code
     * @param category
     * @param config
     */
    function submit_template_config(temp_id, module_code, category, config) {
        var up_data = {
            template_id: temp_id,
            module_code: module_code,
            category: category,
            config: config
        };
        $.ajax({
            type:'POST',
            url:TemplatePHP['modifyTemplateConfig'],
            data: JSON.stringify(up_data),
            dataType: 'json',
            contentType: "application/json",
            beforeSend:function(){
                $('#dialog').prepend(Strack.loading_dom('white','','config'));
            },
            success:function(data){
                $('#st-load_config').remove();
                Strack.top_message({bg:'g',msg:data['message']});
                Strack.dialog_cancel();
            }
        });
    }
});