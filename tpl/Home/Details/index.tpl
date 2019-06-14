<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>Strack-{$lang.details_title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/details.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/details.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var DetailPHP = {
            'getDetailTopInfo': '{:U("Home/Widget/getDetailTopInfo")}',
            'deleteSingleGridData': '{:U("Home/Details/deleteSingleGridData")}'
        };
        // 当前页面参数
        Strack.G.MenuName = "project_detail";
        Strack.G.ModuleId = {$module_id};
        Strack.G.ModuleType = '{$module_type}';
        Strack.G.ProjectId = {$project_id};
    </script>
</block>

<block name="main">

    <div id="page_hidden_param">
        <input name="url_type" type="hidden" value="{$url_tag.type}">
        <input name="url_tab" type="hidden" value="{$url_tag.tab}">
        <input name="project_id" type="hidden" value="{$project_id}" />
        <input name="template_id" type="hidden" value="{$template_id}" />
        <input name="module_id" type="hidden" value="{$module_id}" />
        <input name="module_code" type="hidden" value="{$module_code}" />
        <input name="module_type" type="hidden" value="{$module_type}" />
        <input name="item_id" type="hidden" value="{$item_id}" />
        <input name="item_name" type="hidden" value="{$item_name}" />
        <input name="entity_id" type="hidden" value="{$entity_id}" />
        <input name="onset_module_id" type="hidden" value="{$onset_param.module_id}" />
        <input name="onset_id" type="hidden" value="{$onset_param.id}" />
        <input name="template_id" type="hidden" value="{$template_id}">
        <input name="rule_is_my_task" type="hidden" value="{$is_my_task}">
        <input name="rule_timelog" type="hidden" value="{$view_rules.top_panel__timelog}">
        <input name="rule_prev_next_one" type="hidden" value="{$view_rules.top_panel__prev_next_one}">
        <input name="rule_thumb_modify" type="hidden" value="{$view_rules.top_panel__modify_thumb}">
        <input name="rule_thumb_clear" type="hidden" value="{$view_rules.top_panel__clear_thumb}">
        <input name="rule_template_fixed_tab" type="hidden" value="{$view_rules.tab_bar__template_fixed_tab}">
        <input name="rule_tab_base" type="hidden" value="{$view_rules.tab_bar__base}">
        <input name="rule_tab_notes" type="hidden" value="{$view_rules.tab_bar__note}">
        <input name="rule_tab_info" type="hidden" value="{$view_rules.tab_bar__info}">
        <input name="rule_tab_history" type="hidden" value="{$view_rules.tab_bar__history}">
        <input name="rule_tab_onset" type="hidden" value="{$view_rules.tab_bar__onset}">
        <input name="rule_tab_correlation_task" type="hidden" value="{$view_rules.tab_bar__correlation_task}">
        <input name="rule_tab_file" type="hidden" value="{$view_rules.tab_bar__file}">
        <input name="rule_tab_file_commit" type="hidden" value="{$view_rules.tab_bar__file_commit}">
        <input name="rule_tab_horizontal_relationship" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship}">
        <input name="rule_tab_base" type="hidden" value="{$view_rules.tab_bar__base}">
        <input name="rule_tab_cloud_disk" type="hidden" value="{$view_rules.tab_bar__cloud_disk}">
        <input name="rule_base_create" type="hidden" value="{$view_rules.tab_bar__base__toolbar__create}">
        <input name="rule_base_modify" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__batch_edit}">
        <input name="rule_base_import_excel" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__import_excel}">
        <input name="rule_base_export_excel" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__export_excel}">
        <input name="rule_base_action" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__action}">
        <input name="rule_base_delete" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__batch_delete}">
        <input name="rule_base_modify_thumb" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__modify_thumb}">
        <input name="rule_base_clear_thumb" type="hidden" value="{$view_rules.tab_bar__base__toolbar__edit__clear_thumb}">
        <input name="rule_base_sort" type="hidden" value="{$view_rules.tab_bar__base__toolbar__sort}">
        <input name="rule_base_group" type="hidden" value="{$view_rules.tab_bar__base__toolbar__group}">
        <input name="rule_base_manage_custom_fields" type="hidden" value="{$view_rules.tab_bar__base__toolbar__column__manage_custom_fields}">
        <input name="rule_base_save_view" type="hidden" value="{$view_rules.tab_bar__base__toolbar__view__save_view}">
        <input name="rule_base_save_as_view" type="hidden" value="{$view_rules.tab_bar__base__toolbar__view__save_as_view}">
        <input name="rule_base_modify_view" type="hidden" value="{$view_rules.tab_bar__base__toolbar__view__modify_view}">
        <input name="rule_base_delete_view" type="hidden" value="{$view_rules.tab_bar__base__toolbar__view__delete_view}">
        <input name="rule_base_panel_filter" type="hidden" value="{$view_rules.tab_bar__base__filter_panel}">
        <input name="rule_base_modify_filter" type="hidden" value="{$view_rules.tab_bar__base__filter_panel__save_filter}">
        <input name="rule_file_create" type="hidden" value="{$view_rules.tab_bar__file__toolbar__create}">
        <input name="rule_file_modify" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__batch_edit}">
        <input name="rule_file_import_excel" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__import_excel}">
        <input name="rule_file_export_excel" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__export_excel}">
        <input name="rule_file_action" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__action}">
        <input name="rule_file_delete" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__batch_delete}">
        <input name="rule_file_modify_thumb" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__modify_thumb}">
        <input name="rule_file_clear_thumb" type="hidden" value="{$view_rules.tab_bar__file__toolbar__edit__clear_thumb}">
        <input name="rule_file_sort" type="hidden" value="{$view_rules.tab_bar__file__toolbar__sort}">
        <input name="rule_file_group" type="hidden" value="{$view_rules.tab_bar__file__toolbar__group}">
        <input name="rule_file_manage_custom_fields" type="hidden" value="{$view_rules.tab_bar__file__toolbar__column__manage_custom_fields}">
        <input name="rule_file_save_view" type="hidden" value="{$view_rules.tab_bar__file__toolbar__view__save_view}">
        <input name="rule_file_save_as_view" type="hidden" value="{$view_rules.tab_bar__file__toolbar__view__save_as_view}">
        <input name="rule_file_modify_view" type="hidden" value="{$view_rules.tab_bar__file__toolbar__view__modify_view}">
        <input name="rule_file_delete_view" type="hidden" value="{$view_rules.tab_bar__file__toolbar__view__delete_view}">
        <input name="rule_file_panel_filter" type="hidden" value="{$view_rules.tab_bar__file__filter_panel}">
        <input name="rule_file_modify_filter" type="hidden" value="{$view_rules.tab_bar__file__filter_panel__save_filter}">
        <input name="rule_file_commit_create" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__create}">
        <input name="rule_file_commit_modify" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__batch_edit}">
        <input name="rule_file_commit_import_excel" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__import_excel}">
        <input name="rule_file_commit_export_excel" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__export_excel}">
        <input name="rule_file_commit_action" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__action}">
        <input name="rule_file_commit_delete" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__batch_delete}">
        <input name="rule_file_commit_modify_thumb" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__modify_thumb}">
        <input name="rule_file_commit_clear_thumb" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__edit__clear_thumb}">
        <input name="rule_file_commit_sort" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__sort}">
        <input name="rule_file_commit_group" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__group}">
        <input name="rule_file_commit_manage_custom_fields" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__column__manage_custom_fields}">
        <input name="rule_file_commit_save_view" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__view__save_view}">
        <input name="rule_file_commit_save_as_view" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__view__save_as_view}">
        <input name="rule_file_commit_modify_view" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__view__modify_view}">
        <input name="rule_file_commit_delete_view" type="hidden" value="{$view_rules.tab_bar__file_commit__toolbar__view__delete_view}">
        <input name="rule_file_commit_panel_filter" type="hidden" value="{$view_rules.tab_bar__file_commit__filter_panel}">
        <input name="rule_file_commit_modify_filter" type="hidden" value="{$view_rules.tab_bar__file_commit__filter_panel__save_filter}">
        <input name="rule_correlation_task_create" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__create}">
        <input name="rule_correlation_task_modify" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__batch_edit}">
        <input name="rule_correlation_task_import_excel" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__import_excel}">
        <input name="rule_correlation_task_export_excel" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__export_excel}">
        <input name="rule_correlation_task_action" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__action}">
        <input name="rule_correlation_task_delete" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__batch_delete}">
        <input name="rule_correlation_task_modify_thumb" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__modify_thumb}">
        <input name="rule_correlation_task_clear_thumb" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__edit__clear_thumb}">
        <input name="rule_correlation_task_sort" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__sort}">
        <input name="rule_correlation_task_group" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__group}">
        <input name="rule_correlation_task_manage_custom_fields" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__column__manage_custom_fields}">
        <input name="rule_correlation_task_save_view" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__view__save_view}">
        <input name="rule_correlation_task_save_as_view" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__view__save_as_view}">
        <input name="rule_correlation_task_modify_view" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__view__modify_view}">
        <input name="rule_correlation_task_delete_view" type="hidden" value="{$view_rules.tab_bar__correlation_task__toolbar__view__delete_view}">
        <input name="rule_correlation_task_panel_filter" type="hidden" value="{$view_rules.tab_bar__correlation_task__filter_panel}">
        <input name="rule_correlation_task_modify_filter" type="hidden" value="{$view_rules.tab_bar__correlation_task__filter_panel__save_filter}">
        <input name="rule_horizontal_relationship_create" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__create}">
        <input name="rule_horizontal_relationship_modify" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__batch_edit}">
        <input name="rule_horizontal_relationship_import_excel" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__import_excel}">
        <input name="rule_horizontal_relationship_export_excel" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__export_excel}">
        <input name="rule_horizontal_relationship_action" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__action}">
        <input name="rule_horizontal_relationship_delete" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__batch_delete}">
        <input name="rule_horizontal_relationship_modify_thumb" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__modify_thumb}">
        <input name="rule_horizontal_relationship_clear_thumb" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__edit__clear_thumb}">
        <input name="rule_horizontal_relationship_sort" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__sort}">
        <input name="rule_horizontal_relationship_group" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__group}">
        <input name="rule_horizontal_relationship_manage_custom_fields" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__column__manage_custom_fields}">
        <input name="rule_horizontal_relationship_save_view" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__view__save_view}">
        <input name="rule_horizontal_relationship_save_as_view" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__view__save_as_view}">
        <input name="rule_horizontal_relationship_modify_view" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__view__modify_view}">
        <input name="rule_horizontal_relationship_delete_view" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__toolbar__view__delete_view}">
        <input name="rule_horizontal_relationship_panel_filter" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__filter_panel}">
        <input name="rule_horizontal_relationship_modify_filter" type="hidden" value="{$view_rules.tab_bar__horizontal_relationship__filter_panel__save_filter}">
        <eq name="has_entity_child" value="yes">
            <input name="rule_entity_child_create" type="hidden" value="{$entity_child_view_rules.toolbar__create}">
            <input name="rule_entity_child_modify" type="hidden" value="{$entity_child_view_rules.toolbar__edit__batch_edit}">
            <input name="rule_entity_child_import_excel" type="hidden" value="{$entity_child_view_rules.toolbar__edit__import_excel}">
            <input name="rule_entity_child_export_excel" type="hidden" value="{$entity_child_view_rules.toolbar__edit__export_excel}">
            <input name="rule_entity_child_action" type="hidden" value="{$entity_child_view_rules.toolbar__edit__action}">
            <input name="rule_entity_child_delete" type="hidden" value="{$entity_child_view_rules.toolbar__edit__batch_delete}">
            <input name="rule_entity_child_modify_thumb" type="hidden" value="{$entity_child_view_rules.toolbar__edit__modify_thumb}">
            <input name="rule_entity_child_clear_thumb" type="hidden" value="{$entity_child_view_rules.toolbar__edit__clear_thumb}">
            <input name="rule_entity_child_sort" type="hidden" value="{$entity_child_view_rules.toolbar__sort}">
            <input name="rule_entity_child_group" type="hidden" value="{$entity_child_view_rules.toolbar__group}">
            <input name="rule_entity_child_manage_custom_fields" type="hidden" value="{$entity_child_view_rules.toolbar__column__manage_custom_fields}">
            <input name="rule_entity_child_save_view" type="hidden" value="{$entity_child_view_rules.toolbar__view__save_view}">
            <input name="rule_entity_child_save_as_view" type="hidden" value="{$entity_child_view_rules.toolbar__view__save_as_view}">
            <input name="rule_entity_child_modify_view" type="hidden" value="{$entity_child_view_rules.toolbar__view__modify_view}">
            <input name="rule_entity_child_delete_view" type="hidden" value="{$entity_child_view_rules.toolbar__view__delete_view}">
            <input name="rule_entity_child_panel_filter" type="hidden" value="{$entity_child_view_rules.filter_panel}">
            <input name="rule_entity_child_modify_filter" type="hidden" value="{$entity_child_view_rules.filter_panel__save_filter}">
        </eq>
    </div>

    <div class="projpage-main sroll-auto">
        <!--详情页面头部-->
        <header class="projitem-header">
            <!--详情页面头 头部 面包屑导航-->
            <div class="item-breadcrumb ui grid">
                <div class="center aligned three column row title">
                    <div class="wide column tab">
                        <!--详情头显示 面包屑导航-->
                        <div id="item_breadcrumb" class="item-breadcrumb-left">
                            <!--动态生成面包屑导航-->
                        </div>
                    </div>
                    <div class="wide column tab">
                        <!--详情头显示 中间按钮-->
                        <eq name="view_rules.top_panel__prev_next_one" value="yes">
                            <div id="prev_next_bnt" class="ui buttons">
                                <!--上一个下一个切换按钮-->
                            </div>
                        </eq>
                    </div>
                    <div class="wide column tab">
                        <!--详情头显示 右边按钮-->
                        <div class="item-breadcrumb-right">
                            <eq name="view_rules.top_panel__action" value="yes">
                                <a href="javascript:;" class="ui timelog-bnt button" onclick="Strack.open_action_slider(this);" data-from="details" data-moduleid="{$module_id}" data-projectid="{$project_id}" data-linkid="{$item_id}">
                                    <i class="icon-uniE6BB icon-left"></i>
                                    {$Think.lang.Action}
                                </a>
                            </eq>

                            <if condition="($module_id eq 4) AND ($is_my_task eq 'yes') AND ($view_rules.top_panel__timelog eq 'yes') ">
                                <a href="javascript:;" id="top_timelog_bnt" class="ui timelog-bnt button" onclick="Strack.item_start_timelog(this)" data-id="top_timelog_bnt" data-linkid="{$item_id}" data-timelogid="0" data-moduleid="{$module_id}" title=" {$Think.lang.Time_Log}">
                                    <i class="icon-uniE974 icon-left"></i>
                                </a>
                            </if>
                        </div>
                    </div>
                </div>
            </div>

            <!--详情页面头 中部 缩略图-->
            <div class="projitem-mid">
                <div id="details_thumb" class="item-mid-thumb">
                   <!--详情页面缩略图-->
                </div>
                <div class="item-mid-infor">
                    <div class="item-mid-name">
                        <!--详情头显示 任务名称-->
                        {$item_name}
                    </div>
                    <div id="details_top_info" class="item-mid-list">
                        <!--详情头显示fields-->
                    </div>
                    <!--详情设置头显示fields-->
                    <eq name="view_rules.top_panel__fields_rules" value="yes">
                        <div class="item-mid-bottom overflow-hide">
                            <a href="javascript:;" onclick="Strack.top_fields_config(this)" data-pos="details" data-id="{$item_id}" data-page="{$page}"  data-moduleid="{$module_id}" data-modulecode="{$module_code}" data-projectid="{$project_id}" data-templateid ="{$template_id}">{$Think.lang.Fields_Config}</a>
                        </div>
                    </eq>
                </div>
            </div>

            <!--详情页面头 底部 导航-->
            <div id="details_tab" class="projitem-footer" data-pos="details">

                <span class="tabs-tab-prev tabs-tab-btn-disabled"><i class="icon-uniF104"></i></span>
                <span class="tabs-tab-next"><i class="icon-uniF105"></i></span>
                <div class="tabs-tab-list ui secondary pointing menu">
                    <!--动态生成详情页面Tab-->
                </div>
            </div>

            <!-- 详情页面隐藏toolbar-->
            <div  id="task_hidebar" class="projitem-hidebar">
                <div  class="projitem-hidebar-wrap">
                    <!--task top mini thumb-->
                    <div id="hidebar_thumb" class="task-hiderbar-thumb">
                    </div>
                    <!--task top link -->
                    <div class="task-hiderbar-link">
                        <div class="hidebar-breadcrumb">
                            <div id="hidebar_breadcrumb" class="ui small breadcrumb">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        <!--task页面内容区域-->
        <div class="details-page-main task-mainwrap">

            <!--note 动态面板-->
            <div id="tab_note" class="ui tab pitem-wrap" data-tab="note">
                <!--note 页面右边 list-->
                <div class="task-mainwrap-header clearfix">
                    <div id="comments_avatar" class="task-editor-thumb">
                        <!--显示当前用户头像-->
                    </div>
                    <div class="task-editor-wrap">
                        <textarea id="comments_editor" autocomplete="off"></textarea>
                    </div>
                </div>
                <div class="note-filter-wrap">

                </div>
                <div class="task-mainwrap-footer">
                    <div id="comments_list" class="ui threaded comments note-comments">
                        <!--note comments list-->
                        <div class="note-stick">
                        </div>
                        <div class="note-no-stick">
                        </div>
                    </div>
                </div>
            </div>

            <!--info 信息面板-->
            <div id="tab_info"  class="ui tab pitem-wrap" data-tab="info">
                <div id="details_info" class="task-info-mainwrap">
                    <!--info main-->
                </div>
            </div>

            <!--onset 现场数据-->
            <div id="tab_onset" class="ui tab pitem-wrap" data-tab="onset">
                <div id="onset_entity_not_exit" style="display: none">
                    <div class="datagrid-empty-no">{$Think.lang.Task_Not_Belong_Entity}</div>
                </div>
                <div id="onset_link_not_exit" class="onset-select" style="display: none">
                    <!--不存在onset管理数据，选择一个Onset关联-->
                    <form id="add_link_onset" >
                        <div class="form-group required">
                            <input id="onset_select_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="onset_module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                            <input id="onset_select_entity_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="link_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                            <input id="onset_select_entity_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                        </div>
                        <div class="form-group required">
                            <label class="stcol-lg-1 control-label">
                                {$Think.lang.Select_One_OnSet_Link}
                            </label>
                            <div class="stcol-lg-2">
                                <div class="bs-component">
                                    <input id="onset_select_list" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="onset_id" wiget-name="{$Think.lang.Select_One_OnSet_Link}">
                                </div>
                            </div>
                        </div>
                        <div class="form-button-full">
                            <a href="javascript:;" onclick="obj.add_link_onset(this);">
                                <div class="form-button-long form-button-hover">
                                    {$Think.lang.Submit}
                                </div>
                            </a>
                        </div>
                    </form>
                </div>
                <div id="onset_link_main" class="page-onset-wrap" style="display: none">
                    <!--存在onset关联数据-->
                    <div class="onset-wrap-left">
                        <div class="onset-camera-show">
                            <div class="onset_show_cam onset_camera_infor_p">_</div>
                            <div class="onset_camera_infor_L">{$Think.lang.Film_Back}</div>
                            <div class="onset_camera_infor_C">{$Think.lang.Field_Of_View}</div>
                            <div class="onset_camera_infor_R">{$Think.lang.Frame_Size}<span class="onset_show_res"></span></div>
                            <div class="onset_camera_infor_B">{$Think.lang.Focal_Length}</div>
                            <div class="onset_show_focal onset_camera_infor_Bb"></div>
                        </div>
                        <div id="onset_info" class="onset-info-edit">
                            <!--onset info-->

                        </div>
                    </div>
                    <div id="onset_att" class="onset-wrap-right">
                        <!--onset reference heaser-->
                        <div class="onset-reference-header">
                            <div class="aign-left">{$Think.lang.Onset_Reference}</div>
                            <div class="aign-right add-ref-button ah_onset_att">
                                <a id="onset_att_bnt" href="javascript:;" onclick="Strack.upload_onset_att(this)" data-linkid="" data-moduleid="" data-from="details">
                                    <i class="icon-uniF067"></i>
                                </a>
                            </div>
                        </div>
                        <div id="onset_reference" class="onset-reference">
                            <!--onset reference main-->
                        </div>
                    </div>
                </div>
            </div>

            <!--single_grid 单一表头数据表格-->
            <div id="tab_single_grid" class="ui tab pitem-wrap" data-tab="single_grid">
                <!--assembly grid data list-->
                <div id="single_datagrid_main" class="entity-datalist base-m-grid">
                    <div id="single_tb_grid" class="proj-tb tb-padding-grid grid-toolbar" data-grid="single_main_datagrid_box" data-page="" data-schemapage="" data-moduleid="" data-maindom="single_datagrid_main" data-bardom="single_filter_main" data-projectid="{$project_id}">

                        <div id="single_grid_create_bnt" class="st-buttons-sig st-buttons-blue aign-left">
                            <a href='javascript:;' class="create-bnt" onclick="obj.create_single_grid_data(this);" data-lang="">
                                <i class="icon plus"></i>
                                <span class="stp-title"></span>
                            </a>
                        </div>

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__create" value="yes">
                            <div id="single_grid_create_horizontal"  class="st-buttons-sig st-buttons-blue aign-left" style="display: none">
                                <a href='javascript:;' id="single_create_horizontal_bnt" class="create-bnt" onclick="Strack.create_horizontal_relationship(this);" data-variableid="" data-srcmoduleid="" data-dstmoduleid="" data-srclinkid="">
                                    <i class="icon plus"></i>
                                    <span class="stp-title"></span>
                                </a>
                            </div>
                        </eq>

                        <div class="ui dropdown st-dropdown aign-left">
                            {$Think.lang.Edit}<i class="dropdown icon"></i>
                            <div class="menu edit-menu">

                                <a href="javascript:;" class="item single_grid_modify_bnt" onclick="obj.modify_single_grid_data(this);" data-lang="{$Think.lang.Batch_Edit}">
                                    <i class="icon-uniF044 icon-left"></i>
                                    {$Think.lang.Modify}
                                </a>

                                <div class="divider single_grid_modify_bnt"></div>

                                <!--<a id="single_grid_import_excel_bnt" href="javascript:;" class="item" onclick="Strack.import_excel_data(this);">
                                    <i class="icon-uniE986 icon-left"></i>
                                    <span class="stp-title">{$Think.lang.Import_Excel}</span>
                                </a>-->

                                <a id="single_grid_export_excel_bnt" href='javascript:;' class="item" onclick="Strack.export_excel_file(this);">
                                    <i class="icon-uniE6082 icon-left"></i>
                                    <span class="stp-title">{$Think.lang.Export_Excel}</span>
                                </a>

                                <div class="divider single_grid_action_bnt"></div>
                                <a href="javascript:;" class="item all-action-slider single_grid_action_bnt" onclick="Strack.open_action_slider(this);" data-from="grid" data-grid="single_main_datagrid_box" data-moduleid="{$module_id}" data-projectid="{$project_id}">
                                    <i class="icon-uniE6BB icon-left"></i>
                                    {$Think.lang.All_Action}
                                </a>
                                <div class="item single_grid_action_bnt" data-lang="{$Think.lang.Frequently_Use_Action}">
                                    <i class="dropdown icon"></i> {$Think.lang.Frequently_Use_Action}
                                    <div class="common_action menu st-down-menu transition hidden">
                                        <!--常用动作-->
                                    </div>
                                </div>

                                <div class="divider"></div>
                                <a id="single_grid_modify_thumb_bnt" href="javascript:;" class="item modify-thumb-bnt" onclick="Strack.grid_change_item_thumb(this);" data-grid="single_main_datagrid_box" data-moduleid="">
                                    <span class="stp-title">{$Think.lang.Modify_Thumb}</span>
                                </a>
                                <a id="single_grid_clear_thumb_bnt" href='javascript:;' class="item clear-thumb-bnt" onclick="Strack.grid_clear_item_thumb(this);" data-grid="single_main_datagrid_box" data-moduleid="">
                                    <span class="stp-title">{$Think.lang.Clear_Thumb}</span>
                                </a>
                                <div class="divider single_grid_delete_bnt"></div>
                                <a href="javascript:;" id="single_grid_delete_item_bnt" class="item single_grid_delete_bnt" onclick="obj.delete_single_grid_data(this);" data-code="">
                                    <i class="icon-uniE9D5 icon-left"></i>
                                    {$Think.lang.Delete}
                                </a>
                            </div>
                        </div>

                        <div id="single_grid_sort_bnt" class="ui dropdown st-dropdown aign-left">
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

                        <div id="single_grid_group_bnt" class="ui dropdown st-dropdown aign-left">
                            {$Think.lang.Group}<i class="dropdown icon"></i>
                            <div class="menu grid_group data-fields">
                                <!--group list-->
                                <a href="javascript:;" class="item" onclick="Strack.delete_group(this);" data-panel="grid">
                                    <i class="icon-uniE682 icon-left"></i>{$Think.lang.Group_Cancel}
                                </a>
                            </div>
                        </div>

                        <div class="ui dropdown st-dropdown aign-left">
                            {$Think.lang.Display_Column}<i class="dropdown icon"></i>
                            <div class="menu grid_fields">
                                <!--fields list-->
                                <a id="single_grid_manage_custom_fields_bnt" href="javascript:;" class="item" onclick="Strack.manage_fields(this);" data-lang="{$Think.lang.Manage_Custom_Fields}">
                                    <i class="icon-uniE71D icon-left"></i>{$Think.lang.Manage_Custom_Fields}
                                </a>
                            </div>
                        </div>

                        <div class="ui dropdown st-dropdown aign-left grid-view-bnt">
                            {$Think.lang.View}<i class="dropdown icon"></i>
                            <div class="menu grid_view">
                                <!--view list-->
                                <a id="single_grid_save_view_bnt" href="javascript:;" class="item" onclick="Strack.save_view(this);" data-panel="grid">
                                    <i class="icon-uniF0C7 icon-left"></i>{$Think.lang.Save}
                                </a>
                                <a id="single_grid_save_as_view_bnt" href="javascript:;" class="item" onclick="Strack.save_as_view(this);" data-panel="grid">
                                    <i class="icon-uniF0C5 icon-left"></i>{$Think.lang.SaveAs}
                                </a>
                                <a id="single_grid_modify_view_bnt" href="javascript:;" class="item" onclick="Strack.modify_view(this);" data-panel="grid">
                                    <i class="icon-uniEA9B icon-left"></i>{$Think.lang.Modify}
                                </a>
                                <a id="single_grid_delete_view_bnt" href="javascript:;" class="item" onclick="Strack.delete_view(this);" data-panel="grid">
                                    <i class="icon-uniE9D5 icon-left"></i>{$Think.lang.Delete}
                                </a>
                            </div>
                            <span class="current_view">（{$Think.lang.Default_View}）</span>
                        </div>

                        <div class="ui search aign-right single_grid_panel_filter">
                            <input id="single_grid_search" autocomplete="off"/>
                        </div>

                    </div>
                    <table id="single_main_datagrid_box" class="datagrid-table"></table>
                </div>
                <div id="single_filter_main" class="datagrid-filter filter-full-active filter-min single_grid_panel_filter" data-grid="single_main_datagrid_box" data-page="" data-schemapage="" data-moduleid="" data-maindom="single_datagrid_main" data-bardom="single_filter_main" data-projectid="{$project_id}">
                    <!--过滤面板-->
                </div>
            </div>

            <!--entity_grid 两层表头数据表格-->
            <div id="tab_entity_grid" class="ui tab pitem-wrap" data-tab="entity_grid">
                <!--assembly grid data list-->
                <div id="grid_datagrid_main" class="entity-datalist base-m-grid">
                    <div id="tb_grid" class="proj-tb tb-padding-grid grid-toolbar" data-grid="main_datagrid_box" data-page="" data-schemapage="" data-moduleid="" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__create" value="yes">
                            <div class="st-buttons-sig st-buttons-blue aign-left">
                                <a href='javascript:;' id="entity_create_horizontal_bnt" class="create-bnt" onclick="Strack.create_horizontal_relationship(this);" data-variableid="" data-srcmoduleid="" data-dstmoduleid="" data-srclinkid="">
                                    <i class="icon plus"></i>
                                    <span class="stp-title"></span>
                                </a>
                            </div>
                        </eq>

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit" value="yes">
                            <div class="ui dropdown st-dropdown aign-left">
                                {$Think.lang.Edit}<i class="dropdown icon"></i>
                                <div class="menu edit-menu">

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__batch_edit" value="yes">
                                        <a href="javascript:;" class="item" onclick="obj.modify_entity_grid_data(this);"  data-lang="{$Think.lang.Batch_Edit}">
                                            <i class="icon-uniF044 icon-left"></i>
                                            {$Think.lang.Edit_Selected}
                                        </a>
                                        <div class="divider"></div>
                                    </eq>

                                    <!--<eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__import_excel" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.import_excel_data(this);">
                                            <i class="icon-uniE986 icon-left"></i>
                                            <span class="stp-title">{$Think.lang.Import_Excel}</span>
                                        </a>
                                    </eq>
                                    -->

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__export_excel" value="yes">
                                        <a href='javascript:;' class="item" onclick="Strack.export_excel_file(this);">
                                            <i class="icon-uniE6082 icon-left"></i>
                                            <span class="stp-title">{$Think.lang.Export_Excel}</span>
                                        </a>
                                    </eq>

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__action" value="yes">
                                        <div class="divider"></div>
                                        <a href="javascript:;" class="item all-action-slider" onclick="Strack.open_action_slider(this);" data-from="grid" data-grid="main_datagrid_box" data-moduleid="" data-projectid="{$project_id}">
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

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__modify_thumb" value="yes">
                                        <a href="javascript:;" class="item modify-thumb-bnt" onclick="Strack.grid_change_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="">
                                            <span class="stp-title">{$Think.lang.Modify_Thumb}</span>
                                        </a>
                                    </eq>

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__clear_thumb" value="yes">
                                        <a href='javascript:;' class="item clear-thumb-bnt" onclick="Strack.grid_clear_item_thumb(this);" data-grid="main_datagrid_box" data-moduleid="">
                                            <span class="stp-title">{$Think.lang.Clear_Thumb}</span>
                                        </a>
                                    </eq>

                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__edit__batch_delete" value="yes">
                                        <div class="divider"></div>
                                        <a href="javascript:;" id="delele_horizontal_relationship_bnt" class="item" onclick="obj.delete_entity_grid_data(this);" data-code="">
                                            <i class="icon-uniE9D5 icon-left"></i>
                                            {$Think.lang.Delete}
                                        </a>
                                    </eq>
                                </div>
                            </div>
                        </eq>

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__sort" value="yes">
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

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__group" value="yes">
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

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__column" value="yes">
                            <div class="ui dropdown st-dropdown aign-left">
                                {$Think.lang.Display_Column}<i class="dropdown icon"></i>
                                <div class="menu grid_fields">
                                    <!--fields list-->
                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__column__manage_custom_fields" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.manage_fields(this);" data-lang="{$Think.lang.Manage_Custom_Fields}">
                                            <i class="icon-uniE71D icon-left"></i>{$Think.lang.Manage_Custom_Fields}
                                        </a>
                                    </eq>
                                </div>
                            </div>
                        </eq>

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__step" value="yes">
                            <div class="ui dropdown st-dropdown aign-left">
                                {$Think.lang.Steps}<i class="dropdown icon"></i>
                                <div class="menu">
                                    <a href="javascript:;" class="item" onclick="Strack.show_all_steps(this);" data-grid="main_datagrid_box" data-maindom="grid_datagrid_main">
                                        <i class="icon-uniE8FA icon-left"></i>{$Think.lang.Show_All_Steps}
                                    </a>
                                    <a href="javascript:;" class="item" onclick="Strack.hide_all_steps(this);" data-grid="main_datagrid_box" data-maindom="grid_datagrid_main">
                                        <i class="icon-uniE8FB icon-left"></i>{$Think.lang.Hide_All_Steps}
                                    </a>
                                    <div class="scrolling menu step_view">
                                        <!--工序列表-->
                                    </div>
                                </div>
                            </div>
                        </eq>

                        <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__view" value="yes">
                            <div class="ui dropdown st-dropdown aign-left grid-view-bnt">
                                {$Think.lang.View}<i class="dropdown icon"></i>
                                <div class="menu grid_view">
                                    <!--view list-->
                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__view__save_view" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.save_view(this);" data-panel="grid">
                                            <i class="icon-uniF0C7 icon-left"></i>{$Think.lang.Save}
                                        </a>
                                    </eq>
                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__view__save_as_view" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.save_as_view(this);" data-panel="grid">
                                            <i class="icon-uniF0C5 icon-left"></i>{$Think.lang.SaveAs}
                                        </a>
                                    </eq>
                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__view__modify_view" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.modify_view(this);" data-panel="grid">
                                            <i class="icon-uniEA9B icon-left"></i>{$Think.lang.Modify}
                                        </a>
                                    </eq>
                                    <eq name="view_rules.tab_bar__horizontal_relationship__toolbar__view__delete_view" value="yes">
                                        <a href="javascript:;" class="item" onclick="Strack.delete_view(this);" data-panel="grid">
                                            <i class="icon-uniE9D5 icon-left"></i>{$Think.lang.Delete}
                                        </a>
                                    </eq>
                                </div>
                                <span class="current_view">（{$Think.lang.Default_View}）</span>
                            </div>
                        </eq>

                        <eq name="view_rules.tab_bar__horizontal_relationship__filter_panel" value="yes">
                            <div class="ui search aign-right">
                                <input id="main_grid_search" autocomplete="off"/>
                            </div>
                        </eq>

                    </div>
                    <table id="main_datagrid_box" class="datagrid-table"></table>
                </div>
                <eq name="view_rules.tab_bar__horizontal_relationship__filter_panel" value="yes">
                    <div id="grid_filter_main" class="datagrid-filter filter-full-active filter-min" data-grid="main_datagrid_box" data-page="" data-schemapage="" data-moduleid="" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">
                        <!--过滤面板-->
                    </div>
                </eq>
            </div>

            <!--history 历史记录-->
            <div id="tab_history" class="ui tab pitem-wrap" data-tab="history">
                <div class="task-history-wrap">
                    <table id="history_datagrid"></table>
                </div>
            </div>

            <!--cloud disk 云盘-->
            <div id="tab_iframe_page" class="ui tab pitem-wrap page-iframe-wrap" data-tab="iframe_page">
                <iframe src="{$cloud_disk_url}" class="page-iframe-base page-iframe-wh-100">
                </iframe>
            </div>
        </div>
    </div>
</block>