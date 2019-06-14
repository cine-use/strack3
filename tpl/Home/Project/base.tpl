<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Task_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/base.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/base.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var BasePHP = {
            'getBaseGridData': '{:U('Home/Base/getBaseGridData')}',
            'deleteBase': '{:U('Home/Base/deleteBase')}'
        };
        // 当前页面参数
        Strack.G.MenuName = "project_inside";
        Strack.G.ModuleId = {$module_id};
        Strack.G.ModuleType = '{$module_type}';
        Strack.G.ProjectId = {$project_id};
    </script>
</block>

<block name="main">

    <div id="page_hidden_param">
        <input name="project_id" type="hidden" value="{$project_id}">
        <input name="page" type="hidden" value="{$page}">
        <input name="module_id" type="hidden" value="{$module_id}">
        <input name="module_type" type="hidden" value="{$module_type}">
        <input name="module_code" type="hidden" value="{$module_code}">
        <input name="module_name" type="hidden" value="{$module_name}">
        <input name="template_id" type="hidden" value="{$template_id}">
        <input name="rule_panel_filter" type="hidden" value="{$view_rules.filter_panel}">
        <input name="rule_modify_filter" type="hidden" value="{$view_rules.filter_panel__save_filter}">
        <input name="rule_sort" type="hidden" value="{$view_rules.toolbar__sort}">
        <input name="rule_group" type="hidden" value="{$view_rules.toolbar__group}">
        <input name="rule_tab_base" type="hidden" value="{$view_rules.side_bar__tab_bar__base}">
        <input name="rule_tab_notes" type="hidden" value="{$view_rules.side_bar__tab_bar__note}">
        <input name="rule_tab_info" type="hidden" value="{$view_rules.side_bar__tab_bar__info}">
        <input name="rule_tab_history" type="hidden" value="{$view_rules.side_bar__tab_bar__history}">
        <input name="rule_tab_onset" type="hidden" value="{$view_rules.side_bar__tab_bar__onset}">
        <input name="rule_tab_file" type="hidden" value="{$view_rules.side_bar__tab_bar__file}">
        <input name="rule_tab_file_commit" type="hidden" value="{$view_rules.side_bar__tab_bar__commit}">
        <input name="rule_tab_correlation_task" type="hidden" value="{$view_rules.side_bar__tab_bar__correlation_task}">
        <input name="rule_tab_horizontal_relationship" type="hidden" value="{$view_rules.side_bar__tab_bar__horizontal_relationship}">
        <input name="rule_template_fixed_tab" type="hidden" value="{$view_rules.side_bar__tab_bar__template_fixed_tab}">
        <input name="rule_tab_cloud_disk" type="hidden" value="{$view_rules.side_bar__tab_bar__cloud_disk}">
        <input name="rule_side_thumb_modify" type="hidden" value="{$view_rules.side_bar__top_panel__modify_thumb}">
        <input name="rule_side_thumb_clear" type="hidden" value="{$view_rules.side_bar__top_panel__clear_thumb}">
    </div>

    <div class="projpage-main">
        <div class="projtable-content">

            <!--grid data list-->
            <div id="grid_datagrid_main" class="entity-datalist base-m-grid">
                <div id="tb_grid" class="proj-tb tb-padding-grid grid-toolbar" data-grid="main_datagrid_box" data-page="{$page}" data-schemapage="{$page}" data-moduleid="{$module_id}" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">

                    <eq name="view_rules.toolbar__create" value="yes">
                        <div class="st-buttons-sig st-buttons-blue aign-left">
                            <a href='javascript:;' onclick="obj.base_add(this);" data-lang="{$module_name}">
                                <i class="icon plus"></i>
                                <span class="stp-title">{$module_name}</span>
                            </a>
                        </div>
                    </eq>

                    <eq name="view_rules.toolbar__edit" value="yes">
                        <div class="ui dropdown st-dropdown aign-left">
                            {$Think.lang.Edit}<i class="dropdown icon"></i>
                            <div class="menu edit-menu">

                                <eq name="view_rules.toolbar__edit__batch_edit" value="yes">
                                    <a href="javascript:;" class="item" onclick="obj.base_edit(this);" data-lang="{$Think.lang.Batch_Edit}">
                                        <i class="icon-uniF044 icon-left"></i>
                                        {$Think.lang.Edit_Selected}
                                    </a>
                                </eq>

                                <eq name="view_rules.toolbar__edit__batch_add_note" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.batch_add_note(this);" data-lang="{$Think.lang.Batch_Add_Note}">
                                        <i class="icon-uniE645 icon-left"></i>
                                        {$Think.lang.Batch_Add_Note}
                                    </a>
                                </eq>

                                <div class="divider"></div>

                                <eq name="view_rules.toolbar__edit__import_excel" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.import_excel_data(this);">
                                        <i class="icon-uniE986 icon-left"></i>
                                        <span class="stp-title">{$Think.lang.Import_Excel}</span>
                                    </a>
                                </eq>

                                <eq name="view_rules.toolbar__edit__export_excel" value="yes">
                                    <a href='javascript:;' class="item" onclick="Strack.export_excel_file(this);">
                                        <i class="icon-uniE6082 icon-left"></i>
                                        <span class="stp-title">{$Think.lang.Export_Excel}</span>
                                    </a>
                                </eq>

                                <div class="divider"></div>
                                <eq name="view_rules.toolbar__edit__action" value="yes">
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

                                <div class="divider"></div>

                                <eq name="view_rules.toolbar__edit__modify_thumb" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.grid_change_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="{$module_id}">
                                        <span class="stp-title">{$Think.lang.Modify_Thumb}</span>
                                    </a>
                                </eq>

                                <eq name="view_rules.toolbar__edit__clear_thumb" value="yes">
                                    <a href='javascript:;' class="item" onclick="Strack.grid_clear_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="{$module_id}">
                                        <span class="stp-title">{$Think.lang.Clear_Thumb}</span>
                                    </a>
                                </eq>

                                <eq name="view_rules.toolbar__edit__batch_delete" value="yes">
                                    <div class="divider"></div>
                                    <a href="javascript:;" class="item" onclick="obj.base_delete(this);">
                                        <i class="icon-uniE9D5 icon-left"></i>
                                        {$Think.lang.Delete}
                                    </a>
                                </eq>
                            </div>
                        </div>
                    </eq>

                    <eq name="view_rules.toolbar__sort" value="yes">
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

                    <eq name="view_rules.toolbar__group" value="yes">
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

                    <eq name="view_rules.toolbar__column" value="yes">
                        <div class="ui dropdown st-dropdown aign-left">
                            {$Think.lang.Display_Column}<i class="dropdown icon"></i>
                            <div class="menu grid_fields">
                                <!--fields list-->
                                <eq name="view_rules.toolbar__column__manage_custom_fields" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.manage_fields(this);" data-lang="{$Think.lang.Manage_Custom_Fields}">
                                        <i class="icon-uniE71D icon-left"></i>{$Think.lang.Manage_Custom_Fields}
                                    </a>
                                </eq>
                            </div>
                        </div>
                    </eq>


                    <eq name="view_rules.toolbar__view" value="yes">
                        <div class="ui dropdown st-dropdown aign-left grid-view-bnt">
                            {$Think.lang.View}<i class="dropdown icon"></i>
                            <div class="menu grid_view">
                                <!--view list-->
                                <eq name="view_rules.toolbar__view__save_view" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.save_view(this);" data-panel="grid">
                                        <i class="icon-uniF0C7 icon-left"></i>{$Think.lang.Save}
                                    </a>
                                </eq>
                                <eq name="view_rules.toolbar__view__save_as_view" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.save_as_view(this);" data-panel="grid">
                                        <i class="icon-uniF0C5 icon-left"></i>{$Think.lang.SaveAs}
                                    </a>
                                </eq>
                                <eq name="view_rules.toolbar__view__modify_view" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.modify_view(this);" data-panel="grid">
                                        <i class="icon-uniEA9B icon-left"></i>{$Think.lang.Modify}
                                    </a>
                                </eq>
                                <eq name="view_rules.toolbar__view__delete_view" value="yes">
                                    <a href="javascript:;" class="item" onclick="Strack.delete_view(this);" data-panel="grid">
                                        <i class="icon-uniE9D5 icon-left"></i>{$Think.lang.Delete}
                                    </a>
                                </eq>
                            </div>
                            <span class="current_view">（{$Think.lang.Default_View}）</span>
                        </div>
                    </eq>

                    <eq name="view_rules.filter_panel" value="yes">
                        <div class="ui search aign-right">
                            <input id="main_grid_search" autocomplete="off"/>
                        </div>
                    </eq>

                </div>
                <table id="main_datagrid_box" class="datagrid-table"></table>
            </div>
            <eq name="view_rules.filter_panel" value="yes">
                <div id="grid_filter_main" class="datagrid-filter filter-full-active filter-min" data-grid="main_datagrid_box" data-page="{$page}" data-schemapage="{$page}" data-moduleid="{$module_id}" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">
                    <!--过滤面板-->
                </div>
            </eq>

        </div>
    </div>
</block>