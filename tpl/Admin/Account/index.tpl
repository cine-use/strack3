<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Account_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_account.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_account.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var AccountPHP = {
            'getAccountGridData': '{:U("Admin/Account/getAccountGridData")}',
            'getModuleFieldData' : '{:U("WebApp/View/getModuleFieldData")}',
            'getDefaultOptions': '{:U("Admin/Settings/getDefaultOptions")}',
            'getDepartmentList': '{:U("Admin/Department/getDepartmentList")}',
            'getGroupCombobox': '{:U("Admin/Group/getGroupCombobox")}',
            'addUser': '{:U("Admin/Account/addUser")}',
            'modifyAccount': '{:U("Admin/Account/modifyAccount")}',
            'cancelAccount': '{:U("Admin/Account/cancelAccount")}',
            'deleteAccount': '{:U("Admin/Account/deleteAccount")}',
            'resetAccountPassword': '{:U("/Admin/Account/resetAccountPassword")}'
        };
        Strack.G.MenuName = "account";

    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Admin_Account}
</block>

<block name="admin-main">
    <div id="active_account" class="admin-content-account">
        <div id="page_hidden_param">
            <input name="page" type="hidden" value="{$page}">
            <input name="module_id" type="hidden" value="{$module_id}">
            <input name="module_type" type="hidden" value="{$module_type}">
            <input name="module_code" type="hidden" value="{$module_code}">
            <input name="module_name" type="hidden" value="{$module_name}">
            <input name="rule_panel_filter" type="hidden" value="{$view_rules.filter_panel}">
            <input name="rule_modify_filter" type="hidden" value="{$view_rules.filter_panel__save_filter}">
            <input name="rule_sort" type="hidden" value="{$view_rules.toolbar__sort}">
            <input name="rule_group" type="hidden" value="{$view_rules.toolbar__group}">
        </div>

        <!--assembly grid data list-->
        <div id="grid_datagrid_main" class="entity-datalist account-list" style="position: relative;width: calc(100% - 200px);">
            <div id="tb_grid" class="proj-tb tb-padding-grid grid-toolbar" data-tab="grid" data-grid="main_datagrid_box" data-page="admin_account" data-schemapage="admin_account" data-moduleid="34" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="0">

                <eq name="view_rules.toolbar__create" value="yes">
                    <div class="st-buttons-sig aign-left">
                        <a href='javascript:;' onclick="obj.user_add(this);"  data-lang="{$Think.lang.User_Add_Title}">
                            <i class="icon plus"></i>
                            <span class="stp-title">{$Think.lang.Create_User}</span>
                        </a>
                    </div>
                </eq>

                <eq name="view_rules.toolbar__edit" value="yes">
                    <div class="ui dropdown st-dropdown aign-left">
                        <i class="icon-uniE684 icon-left"></i>{$Think.lang.Edit} <i class="dropdown icon"></i>
                        <div class="menu edit-menu">
                            <eq name="view_rules.toolbar__edit__batch_edit" value="yes">
                                <a href="javascript:;" class="item" onclick="obj.user_modify(this);" data-lang="{$Think.lang.Batch_Edit}">
                                    <i class="icon-uniF044 icon-left"></i>
                                    {$Think.lang.Edit_Selected}
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
                                <a href="javascript:;" class="item" onclick="Strack.open_action_slider(this);" data-from="grid" data-grid="main_datagrid_box" data-moduleid="{$module_id}" data-projectid="0">
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
                                <a href="javascript:;" class="item" onclick="Strack.grid_change_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="34">
                                    <span class="stp-title">{$Think.lang.Modify_Thumb}</span>
                                </a>
                            </eq>

                            <eq name="view_rules.toolbar__edit__clear_thumb" value="yes">
                                <a href='javascript:;' class="item" onclick="Strack.grid_clear_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="34">
                                    <span class="stp-title">{$Think.lang.Clear_Thumb}</span>
                                </a>
                            </eq>

                            <div class="divider"></div>

                            <eq name="view_rules.toolbar__edit__reset" value="yes">
                                <a href='javascript:;' class="item" onclick="obj.user_reset_default_pass(this);">
                                    <i class="icon-refresh icon-left"></i>
                                    {$Think.lang.Login_Forget_Reset_Password}
                                </a>
                            </eq>

                            <eq name="view_rules.toolbar__edit__cancel" value="yes">
                                <a href='javascript:;' class="item" onclick="obj.user_cancel(this);">
                                    <i class="icon-uniE8FB icon-left"></i>
                                    {$Think.lang.Cancel_User}
                                </a>
                            </eq>

                            <eq name="view_rules.toolbar__edit__delete" value="yes">
                                <a href='javascript:;' class="item" onclick="obj.user_delete(this);">
                                    <i class="icon-remove icon-left"></i>
                                    {$Think.lang.Delete_User}
                                </a>
                            </eq>
                        </div>
                    </div>
                </eq>

                <eq name="view_rules.toolbar__sort" value="yes">
                    <div class="ui dropdown st-dropdown">
                        <i class="icon-uniE93F icon-left"></i>{$Think.lang.Sort}<i class="dropdown icon"></i>
                        <div class="menu grid_sort data-fields">
                            <!--sort list-->
                            <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.dropdown_sort(this);" data-sort="asc" data-panel="grid"><i class="icon-uniE93F icon-left"></i>{$Think.lang.Sort_Asc}</a>
                            <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.dropdown_sort(this);"  data-sort="desc" data-panel="grid"><i class="icon-uniE946 icon-left"></i>{$Think.lang.Sort_Desc}</a>
                            <a href="javascript:;" class="item sort-bnt field-disable" onclick="Strack.advance_sort(this);" data-sort="advance" data-panel="grid"><i class="icon-uniE9C6 icon-left"></i>{$Think.lang.Sort_Adv}</a>
                            <div class="divider"></div>
                            <a href="javascript:;" class="item" onclick="Strack.sort_cancel(this);" data-panel="grid"><i class="icon-uniE682 icon-left"></i>{$Think.lang.Sort_Cancel}</a>
                        </div>
                    </div>
                </eq>

                <eq name="view_rules.toolbar__group" value="yes">
                    <div class="ui dropdown st-dropdown">
                        {$Think.lang.Group}<i class="dropdown icon"></i>
                        <div class="menu grid_group data-fields">
                            <!--group list-->
                            <a href="javascript:;" class="item" onclick="Strack.delete_group(this);" data-panel="grid"><i class="icon-uniE682 icon-left"></i>{$Think.lang.Group_Cancel}</a>
                        </div>
                    </div>
                </eq>

                <eq name="view_rules.toolbar__column" value="yes">
                    <div class="ui dropdown st-dropdown">
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
                    <div class="ui dropdown st-dropdown grid-view-bnt">
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
            <div id="grid_filter_main" class="datagrid-filter filter-full-active filter-min" data-page="admin_account" data-schemapage="admin_account" data-moduleid="34" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="0">
                <!--过滤面板-->
            </div>
        </eq>

    </div>

</block>