<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Project_Overview_Title}</title></block>

<block name="head-js">
    <script type="text/javascript" src="__COLPICK__/colpick.min.js"></script>
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/overview.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/overview.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var ProjectPHP = {
            'addStatus': '{:U("Home/Project/addStatus")}',
            'addStep' : '{:U("Home/Project/addStep")}',
            'getProjectTeamMembers': '{:U("Home/Project/getProjectTeamMembers")}',
            'deleteProjectMember': '{:U("Home/Project/deleteProjectMember")}',
            'getProjectNavSetting': '{:U("Home/Template/getProjectNavSetting")}',
            'modifyProjectNavTemplateConfig': '{:U("Home/Template/modifyProjectNavTemplateConfig")}',
            'getProjectOverviewModuleList': '{:U("Home/Template/getProjectOverviewModuleList")}',
            'getProjectOverviewStatusList': '{:U("Home/Template/getProjectOverviewStatusList")}',
            'getProjectOverviewStepList': '{:U("Home/Template/getProjectOverviewStepList")}',
            'modifyModuleStatusConfig': '{:U("Home/Project/modifyModuleStatusConfig")}',
            'modifyModuleStepConfig': '{:U("Home/Project/modifyModuleStepConfig")}',
            'getProjectDiskConfig': '{:U("Home/Project/getProjectDiskConfig")}',
            'modifyProjectDisk': '{:U("Home/Project/modifyProjectDisk")}'
        };
        Strack.G.MenuName = "project_inside";
        Strack.G.ModuleId = {$module_id};
        Strack.G.ModuleType = '{$module_type}';
        Strack.G.ProjectId = {$project_id};
    </script>
</block>

<block name="main">

    <div id="page_hidden_param">
        <input name="url_tab" type="hidden" value="{$url_tag.tab}">
        <input name="project_id" type="hidden" value="{$project_id}">
        <input name="disk_id" type="hidden" value="{$disk_id}">
        <input name="template_id" type="hidden" value="{$template_id}">
        <input name="page" type="hidden" value="{$page}">
        <input name="schema_page" type="hidden" value="{$page}">
        <input name="module_id" type="hidden" value="{$module_id}">
        <input name="project_member_module_id" type="hidden" value="{$project_member_module_id}">
        <input name="module_type" type="hidden" value="{$module_type}">
        <input name="module_code" type="hidden" value="{$module_code}">
        <input name="module_icon" type="hidden" value="{$module_icon}">
        <input name="rule_tab_details" type="hidden" value="{$view_rules.details}">
        <input name="rule_thumb_modify" type="hidden" value="{$view_rules.details__modify_thumb}">
        <input name="rule_thumb_clear" type="hidden" value="{$view_rules.details__clear_thumb}">
        <input name="rule_tab_team" type="hidden" value="{$view_rules.team}">
        <input name="rule_tab_navigation" type="hidden" value="{$view_rules.navigation_setting}">
        <input name="rule_tab_status" type="hidden" value="{$view_rules.status_setting}">
        <input name="rule_tab_step" type="hidden" value="{$view_rules.step_setting}">
        <input name="rule_tab_disk" type="hidden" value="{$view_rules.disk_setting}">
        <input name="rule_navigation_drag" type="hidden" value="{$view_rules.navigation_setting__drag}">
        <input name="rule_navigation_switch_button" type="hidden" value="{$view_rules.navigation_setting__switch_button}">
        <input name="rule_status_save" type="hidden" value="{$view_rules.status_setting__save}">
        <input name="rule_status_drag" type="hidden" value="{$view_rules.status_setting__drag}">
        <input name="rule_step_save" type="hidden" value="{$view_rules.step_setting__save}">
        <input name="rule_step_drag" type="hidden" value="{$view_rules.step_setting__drag}">
        <input name="rule_disk_modify" type="hidden" value="{$view_rules.disk_setting__modify}">
        <input name="rule_team_panel_filter" type="hidden" value="{$view_rules.team__filter_panel}">
        <input name="rule_team_modify_filter" type="hidden" value="{$view_rules.team__filter_panel__save_filter}">
        <input name="rule_team_sort" type="hidden" value="{$view_rules.team__toolbar__sort}">
        <input name="rule_team_group" type="hidden" value="{$view_rules.team__toolbar__group}">
    </div>

    <div id="tac_myhome" class="my-home-wrap">
        <div class="st-project-wrap">
            <!--media page left pane-->
            <div class="st-menu-left st-media-w-l-color">
                <a href="javascript:;" id="overview_left_menu" class="st-menu-item-toggle st-media-m-t-w-hover" onclick="Strack.toggle_media_menu(this)" data-page="{$page}" title="{$Think.lang.Hide_Or_Show}">
                    <i class="icon-uniE903"></i>
                </a>
                <div class="st-menu-item">
                    <!--左侧菜单栏-->
                    <if condition="$view_rules.details == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="details" data-lang="{$Think.lang.Details}">
                            <i class="icon-uniEA31 media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Details}</span>
                        </a>
                    </if>
                    <if condition="$view_rules.team == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="team" data-lang="{$Think.lang.Team}">
                            <i class="icon-uniE64A media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Team}</span>
                        </a>
                    </if>
                    <if condition="$view_rules.navigation_setting == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="navigation" data-lang="{$Think.lang.Navigation_Setting}">
                            <i class="icon-uniF135 media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Navigation_Setting}</span>
                        </a>
                    </if>
                    <if condition="$view_rules.status_setting == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="status" data-lang="{$Think.lang.Status_Setting}">
                            <i class="icon-uniF21E media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Status_Setting}</span>
                        </a>
                    </if>
                    <if condition="$view_rules.step_setting == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="step" data-lang="{$Think.lang.Step_Setting}">
                            <i class="icon-uniE8B9 media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Step_Setting}</span>
                        </a>
                    </if>
                    <if condition="$view_rules.disk_setting == 'yes' ">
                        <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="disk" data-lang="{$Think.lang.Disk_Setting}">
                            <i class="icon-uniF01C media-m-icon-left"></i>
                            <span class="media-m-title">{$Think.lang.Disk_Setting}</span>
                        </a>
                    </if>
                </div>
            </div>
            <div class="st-menu-right">
                <!--myhome pane main-->
                <div class="stm-main-wrapper stm-m-w-myhome stm-m-wrapper-color">
                    <if condition="$view_rules.details == 'yes' ">
                        <div class="ui tab pitem-wrap" data-tab="details">
                            <!--项目详情信息-->
                            <div class="stm-main-header st-media-w-h-color">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Details}
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <div id="project_base_thumb" class="project-thumb-wrap">
                                    <!--项目缩略图-->
                                </div>
                                <div id="project_base_info" class="project-info-wrap task-info-mainwrap">
                                    <!--项目基本信息-->
                                </div>
                            </div>
                        </div>
                    </if>
                    <if condition="$view_rules.team == 'yes' ">
                        <div class="ui tab pitem-wrap" data-tab="team">
                            <!--项目团队-->
                            <div class="stm-main-header st-media-w-h-color">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Team}
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <!--项目团队管理-->
                                <div class="p-group-full aign-left">

                                    <div id="team_datagrid_main" class="entity-datalist base-m-grid">
                                        <div id="team_tb" class="proj-tb tb-padding-grid grid-toolbar" data-grid="team_datagrid_box" data-page="project_member" data-schemapage="project_member" data-moduleid="3" data-maindom="team_datagrid_main" data-bardom="team_filter_main" data-projectid="{$project_id}">

                                            <eq name="view_rules.team__toolbar__create" value="yes">
                                                <div class="st-buttons-sig st-buttons-blue aign-left">
                                                    <a href='javascript:;' onclick="obj.member_add(this);" data-lang="{$Think.lang.Member}">
                                                        <i class="icon plus"></i>
                                                        <span class="stp-title">{$Think.lang.Member}</span>
                                                    </a>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__toolbar__edit" value="yes">
                                                <div class="ui dropdown st-dropdown aign-left">
                                                    {$Think.lang.Edit}<i class="dropdown icon"></i>
                                                    <div class="menu edit-menu">
                                                        <eq name="view_rules.team__toolbar__edit__batch_edit" value="yes">
                                                            <a href="javascript:;" class="item" onclick="obj.member_edit(this);" data-lang="{$Think.lang.Batch_Edit}">
                                                                <i class="icon-uniF044 icon-left"></i>
                                                                {$Think.lang.Modify}
                                                            </a>
                                                        </eq>
                                                        <div class="divider"></div>
                                                        <eq name="view_rules.team__toolbar__edit__import_excel" value="yes">
                                                            <a href="javascript:;" class="item" onclick="Strack.import_excel_data(this);">
                                                                <i class="icon-uniE986 icon-left"></i>
                                                                <span class="stp-title">{$Think.lang.Import_Excel}</span>
                                                            </a>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__edit__export_excel" value="yes">
                                                            <a href='javascript:;' class="item" onclick="Strack.export_excel_file(this);">
                                                                <i class="icon-uniE6082 icon-left"></i>
                                                                <span class="stp-title">{$Think.lang.Export_Excel}</span>
                                                            </a>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__edit__action" value="yes">
                                                            <div class="divider"></div>
                                                            <a href="javascript:;" class="item" onclick="Strack.open_action_slider(this);" data-from="grid" data-grid="main_datagrid_box" data-moduleid="{$module_id}" data-projectid="{$project_id}">
                                                                <i class="icon-uniE6BB icon-left"></i>
                                                                {$Think.lang.All_Action}
                                                            </a>
                                                            <div class="item" data-lang="{$Think.lang.Frequently_Use_Action}">
                                                                <i class="dropdown icon"></i> {$Think.lang.Frequently_Use_Action}
                                                                <div class="common_action menu st-down-menu transition hidden">
                                                                    <!--常用动作-->
                                                                </div>
                                                            </div>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__edit__batch_delete" value="yes">
                                                            <div class="divider"></div>
                                                            <a href="javascript:;" class="item" onclick="obj.member_delete(this);">
                                                                <i class="icon-uniE9D5 icon-left"></i>
                                                                {$Think.lang.Delete}
                                                            </a>
                                                        </eq>
                                                    </div>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__toolbar__sort" value="yes">
                                                <div class="ui dropdown st-dropdown aign-left">
                                                    {$Think.lang.Sort}<i class="dropdown icon"></i>
                                                    <div class="menu grid_sort data-fields">
                                                        <!--sort list-->
                                                        <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.dropdown_sort(this);" data-sort="asc" data-panel="grid">
                                                            <i class="icon-uniE93F icon-left"></i>{$Think.lang.Sort_Asc}
                                                        </a>
                                                        <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.dropdown_sort(this);" data-sort="desc" data-panel="grid">
                                                            <i class="icon-uniE946 icon-left"></i>{$Think.lang.Sort_Desc}
                                                        </a>
                                                        <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.advance_sort(this);" data-sort="advance" data-panel="grid">
                                                            <i class="icon-uniE9C6 icon-left"></i>{$Think.lang.Sort_Adv}
                                                        </a>
                                                        <div class="divider"></div>
                                                        <a href="javascript:;" class="item" onclick="Strack.sort_cancel(this);" data-panel="grid">
                                                            <i class="icon-uniE682 icon-left"></i>{$Think.lang.Sort_Cancel}
                                                        </a>
                                                    </div>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__toolbar__group" value="yes">
                                                <div class="ui dropdown st-dropdown aign-left">
                                                    {$Think.lang.Group}<i class="dropdown icon"></i>
                                                    <div class="menu grid_group data-fields">
                                                        <!--group list-->
                                                        <a href="javascript:;" class="item" onclick="Strack.delete_group(this);" data-panel="grid">
                                                            <i class="icon-uniE682 icon-left"></i>{$Think.lang.Group_Cancel}
                                                        </a>
                                                    </div>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__toolbar__column" value="yes">
                                                <div class="ui dropdown st-dropdown aign-left">
                                                    {$Think.lang.Display_Column}<i class="dropdown icon"></i>
                                                    <div class="menu grid_fields">
                                                        <!--fields list-->
                                                    </div>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__toolbar__view" value="yes">
                                                <div class="ui dropdown st-dropdown aign-left grid-view-bnt">
                                                    {$Think.lang.View}<i class="dropdown icon"></i>
                                                    <div class="menu grid_view">
                                                        <!--view list-->
                                                        <eq name="view_rules.team__toolbar__view__save_view" value="yes">
                                                            <a href="javascript:;" class="item" onclick="Strack.save_view(this);" data-panel="grid">
                                                                <i class="icon-uniF0C7 icon-left"></i>{$Think.lang.Save}
                                                            </a>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__view__save_as_view" value="yes">
                                                            <a href="javascript:;" class="item" onclick="Strack.save_as_view(this);" data-panel="grid">
                                                                <i class="icon-uniF0C5 icon-left"></i>{$Think.lang.SaveAs}
                                                            </a>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__view__modify_view" value="yes">
                                                            <a href="javascript:;" class="item" onclick="Strack.modify_view(this);" data-panel="grid">
                                                                <i class="icon-uniEA9B icon-left"></i>{$Think.lang.Modify}
                                                            </a>
                                                        </eq>
                                                        <eq name="view_rules.team__toolbar__view__delete_view" value="yes">
                                                            <a href="javascript:;" class="item" onclick="Strack.delete_view(this);" data-panel="grid">
                                                                <i class="icon-uniE9D5 icon-left"></i>{$Think.lang.Delete}
                                                            </a>
                                                        </eq>
                                                    </div>
                                                    <span class="current_view">（{$Think.lang.Default_View}）</span>
                                                </div>
                                            </eq>

                                            <eq name="view_rules.team__filter_panel" value="yes">
                                                <div class="ui search aign-right">
                                                    <input id="team_grid_search" autocomplete="off"/>
                                                </div>
                                            </eq>

                                        </div>
                                        <table id="team_datagrid_box" class="datagrid-table"></table>
                                    </div>

                                    <eq name="view_rules.team__filter_panel" value="yes">
                                        <div id="team_filter_main" class="datagrid-filter filter-full-active filter-min" data-grid="team_datagrid_box" data-page="project_member" data-schemapage="project_member" data-moduleid="3" data-maindom="team_datagrid_main" data-bardom="team_filter_main" data-projectid="{$project_id}">
                                            <!--过滤面板-->
                                        </div>
                                    </eq>

                                </div>
                            </div>
                        </div>
                    </if>
                    <if condition="$view_rules.navigation_setting == 'yes' ">
                        <div id="tab_navigation" class="ui tab pitem-wrap" data-tab="navigation">
                            <!--项目页面导航设置-->
                            <div class="stm-main-header st-media-w-h-color st-media-w-h-border">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Navigation_Setting}
                                    </div>
                                    <div class="stm-header-tool aign-left">
                                        <eq name="view_rules.navigation_setting__save" value="yes">
                                            <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.nav_save(this)">
                                                <i class="icon-uniF0C7"></i>
                                                {$Think.lang.Save}
                                            </a>
                                            <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.nav_auto_save(this)">
                                                <i class="icon-unchecked"></i>
                                                {$Think.lang.Auto_Save}
                                            </a>
                                        </eq>
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <ul id="nav_module_list" style="width: 100%; height: 100%">
                                    <!--项目导航模块列表-->
                                </ul>
                            </div>
                        </div>
                    </if>
                    <if condition="$view_rules.status_setting == 'yes' ">
                        <div class="ui tab pitem-wrap" data-tab="status">
                            <!--项目页面状态设置-->
                            <div class="stm-main-header st-media-w-h-color st-media-w-h-border">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Status_Setting}
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <!--项目模块状态管理-->
                                <div id="status_module_list" class="p-group-left p-group-border-right aign-left admin-temp-list">
                                    <!--可配置模块列表-->
                                </div>
                                <div id="status_config" class="p-group-right aign-left">
                                    <div id="status_config_notice" class="temp-setlist-no">
                                        <p>{$Think.lang.Please_Select_One_Module}</p>
                                    </div>
                                    <div class="p-status-allow aign-left admin-content-dept">
                                        <div class="admin-temp-left">
                                            <div class="dept-col-wrap">
                                                <div class="dept-form-wrap proj-tb" style="height: 41px">
                                                    <h3 class="aign-left">{$Think.lang.Status_List}</h3>
                                                    <div class="st-buttons-sig aign-left" style="padding: 6px 6px 0;">
                                                        <eq name="view_rules.status_setting__create" value="yes">
                                                            <a href="javascript:;" onclick="obj.status_add(this);">
                                                                <i class="icon plus"></i>
                                                            </a>
                                                        </eq>
                                                    </div>
                                                    <div class="ad-left-search">
                                                        <div class="ui search aign-right">
                                                            <div class="ui icon input">
                                                                <a href="javascript:;" class="st-down-filter stdown-filter">
                                                                    <i class="filter icon project_filter"></i>
                                                                </a>
                                                                <input id="status_search" class="prompt" placeholder="{$Think.lang.Search_More}" autocomplete="off" type="text">
                                                                <a href="javascript:;" id="search_status_bnt" class="st-filter-action" onclick="obj.filter_status(this);">
                                                                    <i class="search icon"></i>
                                                                </a>
                                                            </div>
                                                            <div class="results"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="admin-temp-list">
                                                    <ul id="module_status_list">
                                                        <!--状态列表-->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="p-status-now aign-left">

                                        <div class="stm-drag-tool">
                                            <eq name="view_rules.status_setting__save" value="yes">
                                                <div class="stm-header-tool aign-left">
                                                    <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.drag_status_save(this)">
                                                        <i class="icon-uniF0C7"></i>
                                                        {$Think.lang.Save}
                                                    </a>
                                                    <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.drag_status_auto_save(this)">
                                                        <i class="icon-unchecked"></i>
                                                        {$Think.lang.Auto_Save}
                                                    </a>
                                                </div>
                                            </eq>
                                        </div>
                                        <div class="drag-list-wrap">
                                            <!--被选中状态列表-->
                                            <ul id="status_drag_list" style="width: 100%; height: 100%">
                                                <!--项目导航模块列表-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </if>
                    <if condition="$view_rules.step_setting == 'yes' ">
                        <div class="ui tab pitem-wrap" data-tab="step">
                            <!--项目页面工序设置-->
                            <div class="stm-main-header st-media-w-h-color st-media-w-h-border">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Step_Setting}
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <!--项目模块工序管理-->
                                <div id="step_module_list" class="p-group-left p-group-border-right aign-left admin-temp-list">
                                    <!--可配置模块列表-->
                                </div>
                                <div id="step_config"  class="p-group-right aign-left">
                                    <div id="step_config_notice" class="temp-setlist-no">
                                        <p>{$Think.lang.Please_Select_One_Module}</p>
                                    </div>
                                    <div class="p-status-allow aign-left admin-content-dept">
                                        <div class="admin-temp-left">
                                            <div class="dept-col-wrap">
                                                <div class="dept-form-wrap proj-tb" style="height: 41px">
                                                    <h3 class="aign-left">{$Think.lang.Steps_List}</h3>
                                                    <div class="st-buttons-sig aign-left" style="padding: 6px 6px 0;">
                                                        <eq name="view_rules.step_setting__create" value="yes">
                                                            <a href="javascript:;" onclick="obj.step_add(this);">
                                                                <i class="icon plus"></i>
                                                            </a>
                                                        </eq>
                                                    </div>
                                                    <div class="ad-left-search">
                                                        <div class="ui search aign-right">
                                                            <div class="ui icon input">
                                                                <a href="javascript:;" class="st-down-filter stdown-filter">
                                                                    <i class="filter icon project_filter"></i>
                                                                </a>
                                                                <input id="step_search" class="prompt" placeholder="{$Think.lang.Search_More}" autocomplete="off" type="text">
                                                                <a href="javascript:;" id="search_step_bnt" class="st-filter-action" onclick="obj.filter_step(this);">
                                                                    <i class="search icon"></i>
                                                                </a>
                                                            </div>
                                                            <div class="results"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="admin-temp-list">
                                                    <ul id="module_step_list">
                                                        <!--状态列表-->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="p-status-now aign-left">

                                        <div class="stm-drag-tool">
                                            <div class="stm-header-tool aign-left">
                                                <eq name="view_rules.step_setting__save" value="yes">
                                                    <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.drag_step_save(this)">
                                                        <i class="icon-uniF0C7"></i>
                                                        {$Think.lang.Save}
                                                    </a>
                                                    <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.drag_step_auto_save(this)">
                                                        <i class="icon-unchecked"></i>
                                                        {$Think.lang.Auto_Save}
                                                    </a>
                                                </eq>
                                            </div>
                                        </div>
                                        <div class="drag-list-wrap">
                                            <!--被选中状态列表-->
                                            <ul id="step_drag_list" style="width: 100%; height: 100%">
                                                <!--项目导航模块列表-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </if>
                    <if condition="$view_rules.disk_setting == 'yes' ">
                        <div id="overview_disk" class="ui tab pitem-wrap" data-tab="disk">
                            <!--项目磁盘设置-->
                            <div class="stm-main-header st-media-w-h-color st-media-w-h-border">
                                <div class="stm-header-title st-sin-font">
                                    <div class="aign-left">
                                        {$Think.lang.Disk_Setting}
                                    </div>
                                    <div class="stm-header-tool aign-left">
                                        <eq name="view_rules.disk_setting__create" value="yes">
                                            <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15 aign-left" onclick="obj.nav_add_disk(this)">
                                                <i class="icon-uniEA33"></i>
                                                {$Think.lang.Add_Disks_Title}
                                            </a>
                                        </eq>
                                    </div>
                                </div>
                            </div>
                            <div class="stm-main-content">
                                <div class="overview-disk-top">
                                    <div class="title">
                                        {$Think.lang.Project_Disk_Settings_Title}
                                    </div>
                                    <div class="main">
                                        <div class="ui grid disk-setting-item">
                                            <div class="two column row">
                                                <div class="five wide column">
                                                <span class="title">
                                                    {$Think.lang.Default}
                                                </span>
                                                </div>
                                                <div class="eleven wide column combobox">
                                                    <if condition="$view_rules.disk_setting__modify == 'yes' ">
                                                        <input id="disk_global_combobox" autocomplete="off">
                                                        <else/>
                                                        <input id="disk_global_combobox" data-options="disabled:true">
                                                    </if>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="overview-disk-bottom">
                                    <div class="title">
                                        {$Think.lang.Project_Disk_More_Settings_Title}
                                        <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15" onclick="obj.add_more_disk(this)">
                                            <i class="icon-uniEA33"></i>
                                        </a>
                                    </div>
                                    <div id="entity_disk_list" class="main">
                                        <!--实体磁盘列表-->
                                        <div class="datagrid-empty-no">{$Think.lang.No_More_Disks_Configured}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </if>
                </div>
            </div>
        </div>
    </div>
</block>