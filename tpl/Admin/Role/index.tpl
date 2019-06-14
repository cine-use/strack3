<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Auth_Role_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_role.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_role.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var RolePHP = {
            'getAuthRoleList': '{:U("Admin/Role/getAuthRoleList")}',
            'addAuthRole': '{:U("Admin/Role/addAuthRole")}',
            'modifyAuthRole': '{:U("Admin/Role/modifyAuthRole")}',
            'deleteAuthRole': '{:U("Admin/Role/deleteAuthRole")}',
            'getAuthPageModuleData' : '{:U("Admin/Role/getAuthPageModuleData")}',
            'getAuthFieldModuleData' : '{:U("Admin/Role/getAuthFieldModuleData")}',
            'getAuthModuleRules': '{:U("Admin/Role/getAuthModuleRules")}',
            'saveAuthAccess': '{:U("Admin/Role/saveAuthAccess")}'
        };
        Strack.G.MenuName = "role";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Admin_Auth_Role}
</block>

<block name="admin-main">
    <div id="active-role" class="admin-content-dept">
        <div class="admin-temp-left">
            <div class="dept-col-wrap">

                <div class="dept-form-wrap proj-tb">
                    <h3 class="aign-left">{$Think.lang.Admin_Role_List}</h3>
                    <div class="st-buttons-sig aign-left" style="padding: 7px 6px 0;">
                        <a href="javascript:;" onclick="obj.auth_role_add(this);">
                            <i class="icon plus"></i>
                        </a>
                    </div>
                    <div class="ad-left-search">
                        <div class="ui search aign-right">
                            <div class="ui icon input">
                                <a href='javascript:;' class="st-down-filter stdown-filter">
                                    <i class="filter icon project_filter"></i>
                                </a>
                                <input id="search_val" class="prompt" placeholder="{$Think.lang.Search_More}" type="text" autocomplete="off">
                                <a href="javascript:;" id="search_auth_role" class="st-filter-action" onclick="obj.auth_role_filter(this);">
                                    <i class="search icon"></i>
                                </a>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-temp-list">
                    <ul id="auth_role_list">

                    </ul>
                </div>
            </div>
        </div>
        <div class="admin-temp-right">
            <div id="hide_role_param">
                <input id="hide_role_id" type="hidden" name="role_id" autocomplete="off">
                <input id="hide_role_name" type="hidden" name="role_name" autocomplete="off">
                <input id="hide_role_code" type="hidden" name="role_code" autocomplete="off">
                <input id="hide_role_tab" type="hidden" name="role_tab">
                <input id="hide_role_rule_tab" name="role_rule_tab" type="hidden"/>
                <input id="hide_role_rule_id" name="role_rule_id" type="hidden"/>
                <input id="hide_role_template_id" name="role_template_id" type="hidden"/>
                <input id="hide_role_module_id" name="role_module_id" type="hidden"/>
                <input id="hide_role_rule_code" name="role_rule_code" type="hidden"/>
            </div>
            <div class="temp-setlist-wrap">
                <div class="temp-setlist-no">
                    <p>{$Think.lang.Please_Select_One_Role}</p>
                </div>
                <div class="temp-setlists">

                    <div class="admin-temp-tab">
                        <div class="ui secondary pointing menu">
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="project">{$Think.lang.Project_Module}</a>
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="front">{$Think.lang.Front_Module}</a>
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="admin">{$Think.lang.Admin_Module}</a>
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="field">{$Think.lang.Field_Authority}</a>
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="api">{$Think.lang.API_Module}</a>
                            <a href="javascript:;" class="item group-item" onclick="obj.select_role_tab(this)" data-tab="client">{$Think.lang.Client_Module}</a>
                        </div>
                    </div>

                    <div id="page_auth_panel" class="ui tab admin-group-content group-no-input">

                        <div id="admin_module" class="temp-content-left admin-temp-list">
                            <ul id="page_module_list" class="module-list">
                                <!--固定可以配置权限模块列表-->
                            </ul>
                        </div>
                        <div id="content_right_page"  class="temp-content-right">
                            <div class="temp-content-right-no">
                                <p>{$Think.lang.Please_Select_One_Module}</p>
                            </div>
                            <div class="temp-content-right-wrap">
                                <div class="role-set-toolbar">
                                    <a href="javascript:;" class="st-dialog-button button-dgsub ah_userac_modify" onclick="obj.auth_module_tab_save();">
                                        {$Think.lang.Save}
                                    </a>
                                </div>
                                <div class="admin-temp-tab">
                                    <div class="ui secondary pointing menu">
                                        <a href="javascript:;" class="item group-rule-item active" onclick="obj.toggle_rule_tab(this)" data-tab="function">{$Think.lang.Function_Authority}</a>
                                    </div>
                                </div>
                                <div class="role-set-wrap">
                                    <div id="rule_tab_page_function" class="ui tab admin-rule-content temp-set-main">
                                        <!--角色可以配置项目功能权限设置页面-->
                                        <ul id="rule_page_function_list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="field_auth_panel" class="ui tab admin-group-content group-no-input">
                        <div id="admin_module" class="temp-content-left admin-temp-list">
                            <ul id="field_module_list" class="module-list">
                                <!--固定可以配置权限模块列表-->
                            </ul>
                        </div>
                        <div id="content_right_field"  class="temp-content-right">
                            <div class="temp-content-right-no">
                                <p>{$Think.lang.Please_Select_One_Module}</p>
                            </div>
                            <div class="temp-content-right-wrap">
                                <div class="role-set-toolbar">
                                    <a href="javascript:;" class="st-dialog-button button-dgsub ah_userac_modify" onclick="obj.auth_module_tab_save();">
                                        {$Think.lang.Save}
                                    </a>
                                </div>
                                <div class="admin-temp-tab">
                                    <div class="ui secondary pointing menu">
                                        <a href="javascript:;" id="rule_item_tab_field" class="item group-rule-item active" onclick="obj.toggle_rule_tab(this)" data-tab="field">{$Think.lang.Field_Authority}</a>
                                    </div>
                                </div>
                                <div id="auth_tab_module_rules" class="role-set-wrap role-rule-wrap">
                                    <div id="rule_tab_field_function" class="ui tab admin-rule-content temp-set-field">
                                        <!--角色可以配置项目字段权限块设置页面-->
                                        <table id="rule_auth_field_list" class="rule-table"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
</block>