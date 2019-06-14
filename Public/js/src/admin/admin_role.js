$(function () {
    obj = {
        auth_role_add: function () {
            Strack.open_dialog('dialog', {
                title: StrackLang['Add_Auth_Role'],
                width: 480,
                height: 240,
                content: Strack.dialog_dom({
                    type: 'normal',
                    items: [
                        {case: 1, id: 'Nname', lang: StrackLang['Name'], name: 'name', valid: '1,128', value: ""},
                        {case: 1, id: 'Ncode', lang: StrackLang['Code'], name: 'code', valid: '1,128', value: ""}
                    ],
                    footer: [
                        {obj: 'role_add_submit', type: 1, title: StrackLang['Submit']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                    ]
                }),
                close: function () {

                }
            });
        },
        role_add_submit: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', RolePHP['addAuthRole'], {
                    back: function (data) {
                        if (parseInt(data['status']) === 200) {
                            Strack.dialog_cancel();
                            obj.auth_role_filter();
                            Strack.top_message({bg: 'g', msg: data['message']});
                        } else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                },
                {
                    extra : function f(data) {
                        data["type"] = "custom";
                        return data;
                    }
                });
        },
        auth_role_modify: function (i) {
            var auth_role_id = $(i).data("roleid"),
                auth_role_name = $(i).data("name"),
                auth_role_code = $(i).data("code");

            Strack.open_dialog('dialog', {
                title: StrackLang['Modify_Auth_Role'],
                width: 480,
                height: 240,
                content: Strack.dialog_dom({
                    type: 'normal',
                    hidden: [
                        {case: 101, id: 'Mauth_role_id', type: 'hidden', name: 'id', valid: 1, value: auth_role_id}
                    ],
                    items: [
                        {
                            case: 1,
                            id: 'Mauth_role_name',
                            type: 'text',
                            lang: StrackLang['Name'],
                            name: 'name',
                            valid: 1,
                            value: auth_role_name
                        },
                        {
                            case: 1,
                            id: 'Mauth_role_code',
                            type: 'text',
                            lang: StrackLang['Code'],
                            name: 'code',
                            valid: 1,
                            value: auth_role_code
                        }
                    ],
                    footer: [
                        {obj: 'modify_auth_role', type: 1, title: StrackLang['Update']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                    ]
                }),
                close: function () {

                }
            });
        },
        modify_auth_role: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', RolePHP['modifyAuthRole'], {
                back: function (data) {
                    if (parseInt(data['status']) === 200) {
                        Strack.dialog_cancel();
                        obj.auth_role_filter();
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        auth_role_delete: function (i) {
            var auth_role_id = $(i).data("roleid");
            Strack.ajax_base_delete(auth_role_id, StrackLang['Delete_AuthRole_Notice'], RolePHP['deleteAuthRole'], function (data) {
                obj.auth_role_filter();
            });
        },
        auth_role_filter: function () {
            var search_val = $("#search_val").val(), filter = '';
            if (search_val.length > 0) {
                filter = JSON.stringify({'name': ['LIKE', "%" + search_val + "%"]});
            }
            obj.reset_right_panel();
            get_role_list(filter);
        },
        select_auth_role: function (i) {
            var role_id = $(i).data("roleid"),
                role_name = $(i).data("name"),
                role_code = $(i).data("code");

            $(".temp-setlist-no").hide();
            $(".temp-setlists").show();

            $("#hide_role_id").val(role_id);
            $("#hide_role_name").val(role_name);
            $("#hide_role_code").val(role_code);

            $('.role-items').removeClass('templates-active');
            $(i).closest(".role-items").addClass('templates-active');

            obj.reset_right_rule_panel();
            switch_auth_tab("project", role_id);
        },
        select_role_tab: function (i) {
            var role_id = $("#hide_role_id").val(),
                tab_name = $(i).data("tab");

            obj.reset_right_rule_panel();
            switch_auth_tab(tab_name, role_id);
        },
        select_module: function (i) {
            var role_id = $("#hide_role_id").val();

            var tab = $(i).data("tab");
            var type = $(i).data("type");
            var id = $(i).data("id");

            var param = Gmodule_data[id];

            param["role_id"] = role_id;
            param["mode"] = tab;

            $(".nation-items").removeClass("admin-bid-ac");
            $(i).addClass("admin-bid-ac");

            // 显示右侧面板
            var $content_right_tab = $("#content_right_"+type);
            $content_right_tab.find(".temp-content-right-no").hide();
            $content_right_tab.find(".temp-content-right-wrap").show();
            $("#rule_tab_"+type+"_function").show();

            switch_module_item(tab, param);
        },
        // 切换权限设置面板
        toggle_rule_tab: function (i){

        },
        auth_module_tab_save: function () {
            // 获取角色参数
            var role_param = {};
            $("#hide_role_param input").each(function () {
                role_param[$(this).attr("name")] = $(this).val();
            });

            save_module_auth(role_param);
        },
        // 重置右侧权限面板显示
        reset_right_rule_panel: function()
        {
            $(".temp-content-right-no").show();
            $(".temp-content-right-wrap").hide();
        },
        // 重置右侧面板显示
        reset_right_panel: function(){
            $(".temp-setlist-no").show();
            $(".temp-setlists").hide();
        }
    };


    var Gmodule_data = {};


    // 加载角色列表
    get_role_list('');

    /**
     * 键盘事件
     */
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter" && $("#tab_project").hasClass("active")){
            if($("#search_val").is(':focus')){
                // 搜索角色
                e.preventDefault();
                obj.auth_role_filter(Strack.get_obj_by_id("search_auth_role"));
            }
        }
    });

    /**
     * ajax加载项目模板列表
     * @param filter
     */
    function get_role_list(filter) {
        $.ajax({
            url: RolePHP['getAuthRoleList'],
            type: 'POST',
            dataType: 'json',
            data: {
                filter: filter
            },
            beforeSend: function () {
                $('#auth_role_list').empty().append(Strack.loading_dom('null'));
            },
            success: function (data) {
                var tlist = '';
                var auth_role_list = $('#auth_role_list');
                var role_id = $('#role_id').val();

                data['rows'].forEach(function (val) {
                    tlist += group_list_dom(val);
                });
                if (tlist) {
                    $("#pactive_notice").remove();
                    auth_role_list.append(tlist);
                } else {
                    if ($("#pactive_notice").length === 0) {
                        auth_role_list.before('<div id="pactive_notice" class="datagrid-empty-no">' + StrackLang["Datagird_No_Data"] + '</div>');
                    }
                }
                //选中当前已经选中的模板
                if (role_id > 0) {
                    $("#role_id_" + role_id).addClass("templates-active");
                }
                $('#st-load').remove();
            }
        });
    }


    /**
     * 权限 list DOM
     * @param data
     * @returns {string}
     */
    function group_list_dom(data) {
        var templist = '';
        templist += '<li id="role_id_' + data["auth_role_id"] + '" class="role-items" >' +
            '<div class="role-name text-ellipsis aign-left">' +
            '<a href="javascript:;" onclick="obj.select_auth_role(this);" data-roleid="' + data["auth_role_id"] + '" data-name="' + data["name"] + '" data-code="' + data["code"] + '">' +
            data["name"] +
            '</a>' +
            '</div>' +
            '<div class="role-bnt aign-right">' +
            '<a href="javascript:;" class="aign-left" onclick="obj.auth_role_modify(this);" data-roleid="' + data["auth_role_id"] + '" data-name="' + data["name"] + '" data-code="' + data["code"] + '">' +
            '<i class="icon-uniE684"></i>' +
            '</a>' +
            '<a href="javascript:;" class="aign-left" onclick="obj.auth_role_delete(this);" data-roleid="' + data["auth_role_id"] + '">' +
            '<i class="icon-uniE6DB"></i>' +
            '</a>' +
            '</div>' +
            '</li>';
        return templist;
    }

    /**
     * 获取项目可设置项
     * @param tab_name
     */
    function get_auth_field_module(tab_name) {
        $.ajax({
            url: RolePHP['getAuthFieldModuleData'],
            type: 'POST',
            beforeSend: function () {
                $('#project_module').append(Strack.loading_dom('white', '', 'module'));
            },
            success: function (data) {
                var mlist = '';
                for (var i in data) {
                    mlist += '<li class="module-items-title">' + data[i]["lang"] + '</li>';

                    if(data[i]["list"]){
                        data[i]["list"].forEach(function (val) {
                            mlist += module_list_dom(val, tab_name, data[i], 'field');
                        });
                    }
                }
                $("#field_module_list").empty().append(mlist);
                $('#st-load_module').remove();
            }
        });
    }

    /**
     * 生成后台角色权限模块列表
     */
    function get_auth_page_module(tab_name) {
        $.ajax({
            url: RolePHP['getAuthPageModuleData'],
            type: 'POST',
            data: {
                tab: tab_name
            },
            dataType: 'json',
            beforeSend: function () {
                $('#field_module').append(Strack.loading_dom('white', '', 'module'));
            },
            success: function (data) {
                var mlist = '';
                for (var i in data) {
                    mlist += '<li class="module-items-title">' + data[i]["lang"] + '</li>';
                    data[i]["list"].forEach(function (val) {
                        mlist += module_list_dom(val, "admin", data[i], 'page');
                    });
                }
                $("#page_module_list").empty().append(mlist);
                $('#st-load_module').remove();
            }
        });
    }

    /**
     * 模块列表DOM
     * @param data
     * @param tab
     * @param param
     * @param type
     * @returns {string}
     */
    function module_list_dom(data, tab, param, type) {
        var list = '', icon_dom = '';

        Gmodule_data[data["id"]] = data;

        if(tab === "project"){
            Gmodule_data[data["id"]]["template_id"] = param.template_id;
        }

        list += '<a href="javascript:;" class="nation-items" onclick="obj.select_module(this)" data-id="' + data["id"] + '" data-type="' + type + '" data-tab="'+tab+'">' +
            '<div class="nation-items-wrap min">' +
            '<div class="aign-left">' +
            icon_dom +
            '<span>' + data["lang"] + '</span>' +
            '</div>' +
            '</div>' +
            '</a>';

        return list;
    }

    /**
     * 切换模块选择
     * @param tab
     * @param param
     */
    function switch_module_item(tab, param) {
        $("#hide_role_rule_id").val(param["id"]);
        $("#hide_role_rule_code").val(param["code"]);
        $("#hide_role_template_id").val(param["template_id"]);
        $("#hide_role_module_id").val(param["module_id"]);
        get_module_function_rules(param, tab);
    }

    /**
     * 获取当前模块规则列表
     * @param param
     * @param tab
     */
    function get_module_function_rules(param, tab) {
        $.ajax({
            url: RolePHP['getAuthModuleRules'],
            type: 'POST',
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify(param),
            beforeSend: function () {
                $('#content_right_func').append(Strack.loading_dom('white', '', 'module_item'));
            },
            success: function (data) {
                $("#st-load_module_item").remove();
                var role_rule_tab = [];
                switch (tab){
                    case "project":
                    case "front":
                    case "admin":
                    case "api":
                    case "client":
                        if(data["view"]){
                            // 生成视图权限配置树
                            role_rule_tab.push("view");
                            $("#rule_page_function_list").tree({
                                data: data["view"],
                                checkbox: true
                            });
                        }
                        break;
                    case "field":
                        var $rule_project_field_list = $("#rule_auth_field_list");
                        if(data["column"]){
                            // 生成视图权限配置树
                            role_rule_tab.push("column");
                            var $rule_tab_project_field = $("#rule_tab_project_field");

                            $rule_tab_project_field.addClass("active");

                            if($rule_project_field_list.hasClass("datagrid-f")){
                                $rule_project_field_list.treegrid("loadData", generate_role_rule_grid(data["column"]));
                            }else {
                                var role_rule_grid_column = generate_role_rule_grid(data["column"]);
                                $rule_project_field_list.treegrid({
                                    data: role_rule_grid_column,
                                    idField: 'id',
                                    treeField: 'lang',
                                    dataGridType: "treegrid",
                                    headerAddCheckbox: true,
                                    rowheight: 36,
                                    height: Strack.panel_height('.role-rule-wrap',0),
                                    adaptive:{
                                        dom:'.role-rule-wrap',
                                        min_width:1004,
                                        exth:0
                                    },
                                    columns:[[
                                        {field:'lang', title:StrackLang["Authority"], width:220},
                                        {field:'view', title:StrackLang["Check"], width:120, align:'center',
                                            formatter: function(value,row,index){
                                                return generate_rule_rule_checkbox('view', row, value);
                                            }
                                        },
                                        {field:'create', title:StrackLang["Create"], width:120, align:'center',
                                            formatter: function(value,row,index){
                                                return generate_rule_rule_checkbox('create', row, value);
                                            }
                                        },
                                        {field:'clear', title:StrackLang["Clear"], width:120, align:'center',
                                            formatter: function(value,row,index){
                                                return generate_rule_rule_checkbox('clear', row, value);
                                            }
                                        },
                                        {field:'modify', title:StrackLang["Modify"], width:120, align:'center',
                                            formatter: function(value,row,index){
                                                return generate_rule_rule_checkbox('modify', row, value);
                                            }
                                        },
                                        {field:'delete', title:StrackLang["Delete"], width:120, align:'center',
                                            formatter: function(value,row,index){
                                                return generate_rule_rule_checkbox('delete', row, value);
                                            }
                                        }
                                    ]],
                                    // 渲染成功
                                    onAfterRender: function (target) {
                                        Strack.init_rule_grid_data(target);
                                    }
                                });
                            }

                            $rule_tab_project_field.removeClass("active");
                        }
                        break;
                }

                $("#hide_role_rule_tab").val(role_rule_tab.join(","));
            }
        });
    }


    /**
     * 生成字段权限配置数据表格
     * @param data
     * @returns {Array}
     */
    function generate_role_rule_grid(data) {
        var grid_data = [];
        var item_data = {};
        var field_lang = '';
        for(var key in data){
            item_data ={
                "id": key,
                "lang": StrackLang[data[key]["lang"]],
                "code": key,
                "is_parent" : 'yes',
                "state":"open",
                "children":[]
            };
            data[key]["list"].forEach(function (val) {
                field_lang = val["type"] === "custom" ? val["lang"] : StrackLang[val["lang"]];
                item_data["children"].push({
                    "id": val["id"],
                    "code": val["name"],
                    "lang": field_lang,
                    "is_parent" : 'no',
                    "parent_code" : key,
                    "module_id" : val["module_id"],
                    "project_id" : val["project_id"],
                    "view": val["permission"]["view"],
                    "create": val["permission"]["create"],
                    "modify": val["permission"]["modify"],
                    "clear": val["permission"]["clear"],
                    "delete": val["permission"]["delete"]
                });
            });
            grid_data.push(item_data);
        }
        return grid_data;
    }

    /**
     * 生成规则表格checkbox
     * @param field
     * @param row
     * @param value
     * @returns {string}
     */
    function generate_rule_rule_checkbox(field, row, value) {
        if(row.is_parent === "yes"){
            return  '<a href="javascript:;" onclick="Strack.rule_grid_header_checkbox(this)" class="dg-rule-checkbox" style="margin-right: 5px" data-pos="parent" data-field="'+field+'" data-code="'+row.code+'"><div class="tree-checkbox tree-checkbox0"></div></a>';
        }else {
            // 判断当前控件选中状态
            var check_css = value === "allow" ?"tree-checkbox1" : "tree-checkbox0";
            return  '<a href="javascript:;" onclick="Strack.rule_grid_header_checkbox(this)" class="dg-rule-checkbox" style="margin-right: 5px" data-pos="single" data-field="'+field+'" data-parent="'+row.parent_code+'" data-code="'+row.code+'"><div class="tree-checkbox '+check_css+'"></div></a>';
        }
    }

    /**
     * 生成页面权限
     * @param data
     * @param view_config
     * @param checked_nodes_map
     * @param indeterminate_nodes_map
     * @param role_id
     * @returns {*}
     */
    function generate_view_auth_data(data, view_config, checked_nodes_map, indeterminate_nodes_map, role_id) {
        var permission = 'deny';
        if($.inArray(data["code"]+'_'+data["id"], checked_nodes_map)>=0){
            permission = 'allow';
        }

        if($.inArray(data["code"]+'_'+data["id"], indeterminate_nodes_map)>=0){
            permission = 'indeterminate';
        }

        view_config[data["id"]] = {
            "role_id" : role_id,
            "auth_id" : data["id"],
            "page" : data["page"],
            "type" : "page",
            "param" : data["param"],
            "permission" : permission
        };

        if(data["children"]){
            data["children"].forEach(function (item) {
                generate_view_auth_data(item, view_config, checked_nodes_map, indeterminate_nodes_map, role_id);
            });
        }
        return view_config;
    }

    /**
     * 保存模块权限
     * @param role_param
     */
    function save_module_auth(role_param) {

        var role_rule_tab = role_param["role_rule_tab"].split(",");
        var rule_config = {};

        // 获取视图权限数据
        if($.inArray("view", role_rule_tab) >= 0){
            var $rule_project_function_list = $("#rule_page_function_list");
            var roots = $rule_project_function_list.tree("getRoots");
            var checked_nodes = $rule_project_function_list.tree('getChecked', ['checked']);
            var indeterminate_nodes = $rule_project_function_list.tree('getChecked', ['indeterminate']);

            var checked_nodes_map = [];
            checked_nodes.forEach(function (val) {
                checked_nodes_map.push(val["code"]+'_'+val["id"]);
            });

            var indeterminate_nodes_map = [];
            indeterminate_nodes.forEach(function (val) {
                indeterminate_nodes_map.push(val["code"]+'_'+val["id"]);
            });

            var view_config = {};

            roots.forEach(function (root) {
                view_config = generate_view_auth_data(root, view_config, checked_nodes_map, indeterminate_nodes_map, role_param["role_id"]);
            });

            rule_config["view"] = view_config;
        }

        // 获取字段权限数据
        if($.inArray("column", role_rule_tab) >= 0){
            // 获取所有check字段值
            var checked_field_map = {};
            var checked_field_parent_map = {};
            var tmp_key = "";
            var tmp_rule_key = "";
            var temp_checked = false;
            var pos = '';
            var code = '';

            $("#rule_tab_field_function .dg-rule-checkbox").each(function () {
                pos = $(this).data("pos");
                if(pos === "single"){
                    tmp_key = $(this).data("parent")+'_'+$(this).data("code");
                    tmp_rule_key = $(this).data("field");
                    if($(this).find(".tree-checkbox").hasClass("tree-checkbox1")){
                        temp_checked = true;
                    }else {
                        temp_checked = false;
                    }
                    if(!checked_field_map[tmp_key]){
                        checked_field_map[tmp_key] = {};
                    }

                    checked_field_map[tmp_key][tmp_rule_key] = temp_checked;
                }else if(pos === "parent"){
                    code = $(this).data("code");
                    if($(this).find(".tree-checkbox").hasClass("tree-checkbox0")){
                        temp_checked = false;
                    }else {
                        temp_checked = true;
                    }
                    if(!checked_field_parent_map[code] || temp_checked){
                        checked_field_parent_map[code] = temp_checked;
                    }
                }
            });
            var column_config = [];
            var column_check_status = {};
            var column_permission = {};
            var field_permission_keys =  ["view", "create", "modify", "delete", "clear"];

            var grid_roots = $("#rule_auth_field_list").treegrid("getRoots");



            grid_roots.forEach(function (val) {
                val["children"].forEach(function (item) {
                    column_check_status = checked_field_map[val["code"]+'_'+item["code"]];
                    column_permission = [];

                    field_permission_keys.forEach(function (key) {
                        if(column_check_status[key]){
                            column_permission.push(key);
                        }
                    });

                    column_config.push({
                        role_id : role_param["role_id"],
                        auth_id : item["id"],
                        page : val["code"],
                        param : '',
                        type : 'field',
                        permission: column_permission.join(","),
                        module_id : item["module_id"],
                        project_id : item["project_id"]
                    });
                });
            });

            rule_config["column"] = column_config;
        }

        $.ajax({
            url: RolePHP['saveAuthAccess'],
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                param : role_param,
                config : rule_config
            }),
            contentType: "application/json",
            beforeSend: function () {
                $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    }

    /**
     * 切换角色tab
     * @param tab_name
     * @param role_id
     */
    function switch_auth_tab(tab_name, role_id) {
        $("#hide_role_tab").val(tab_name);

        $(".group-item")
            .each(function () {
                if($(this).data("tab") === tab_name){
                    $(this).addClass("active");
                }else {
                    $(this).removeClass("active");
                }
            });

        $(".admin-group-content").removeClass("active");
        var $page_auth_panel = $("#page_auth_panel");
        var $field_auth_panel = $("#field_auth_panel");

        switch (tab_name) {
            case "project":
            case "front":
            case "admin":
            case "api":
            case "client":
                $page_auth_panel.addClass("active");
                get_auth_page_module(tab_name);
                break;
            case "field":
                $field_auth_panel.addClass("active");
                get_auth_field_module(tab_name);
                break;
        }
    }
});