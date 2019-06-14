<div class="grid-slider-wrap grid-slider-bgc">
    <!--数据表格边侧栏主页面-->
    <div class="grid-slider-header st-border-bottom">
        <div class="item-breadcrumb ui grid">
            <div class="center aligned two column row title">
                <div class="wide column tab">
                    <!--详情头显示 面包屑导航-->
                    <div id="datagrid_slider_breadcrumb" class="item-breadcrumb-left">
                        <!--动态生成面包屑导航-->
                    </div>
                </div>
                <div class="wide column tab">
                    <div class="item-breadcrumb-right">
                        <a href="javascript:;" id="datagrid_slider_action" class="ui button" onclick="Strack.open_action_slider(this);" data-from="details" data-moduleid="" data-projectid="" data-linkid="">
                            <i class="icon-uniE6BB icon-left"></i>
                            {$Think.lang.Action}
                        </a>
                        <a href="javascript:;" id="grid_slider_tg_bnt" class="ui button" onclick="Strack.item_start_timelog(this)" data-linkid="" data-timelogid="0" data-moduleid="" title="" data-id="grid_slider_tg_bnt" >
                            <i class="icon-uniE974 icon-left"></i>
                        </a>
                        <a href="javascript:;" class="slider-close" onclick="Strack.close_datagrid_slider(this)" data-grid="">
                            <i class="toptool-icon icon-uniE6D5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-slider-topinfo">
            <!--数据表格边侧栏顶部信息栏-->
            <div class="slider-topinfo-left">
                <div id="grid_slider_thumb" class="st-pthumb-warp">

                </div>
            </div>
            <div class="slider-topinfo-right">
                <div id="grid_slider_top_info"  class="item-mid-list">

                </div>
                <!--数据表格边侧栏设置头显示fields-->
                <div class="item-mid-bottom overflow-hide">
                    <a href="javascript:;" id="datagrid_top_fields_config" onclick="Strack.top_fields_config(this)" data-pos="slider" data-id="" data-page=""  data-moduleid="" data-modulecode="" data-projectid="" data-templateid ="">{$Think.lang.Fields_Config}</a>
                </div>
            </div>
        </div>
    </div>
    <!--数据表格边侧栏头 底部 导航-->
    <div class="grid-slider-tab">
        <div id="grid_slider_tab" class="projitem-footer" data-pos="slider">
            <span class="tabs-tab-prev tabs-tab-btn-disabled"><i class="icon-uniF104"></i></span>
            <span class="tabs-tab-next"><i class="icon-uniF105"></i></span>
            <div class="tabs-tab-list ui secondary pointing menu">
                <!--动态生成数据表格边侧栏Tab-->
            </div>
        </div>
    </div>
    <div class="grid-slider-main">
        <!--数据表格边侧栏主要区域-->
        <div id="grid_slider_tab_note" class="ui tab pitem-wrap note-editor-slider" data-tab="note" data-baseh="68">
            <div class="pyn-editor task-editor-wrap">
                <!--editor-->
                <textarea id="grid_slider_comments_editor" autocomplete="off"></textarea>
            </div>
            <div id="slider_note_list" class="pyn-fd-wrap">
                <div class="pyn-fd-list task-mainwrap-footer">
                    <div id="grid_slider_comments_list" class="ui threaded comments note-comments">
                        <!--反馈note list-->
                        <div class="note-stick">
                        </div>
                        <div class="note-no-stick">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="grid_slider_tab_info" class="ui tab pitem-wrap overflow-auto" data-tab="info">
            <div id="grid_slider_info_main" class="task-info-mainwrap">
                <!--info main-->
            </div>
        </div>
        <div id="grid_slider_tab_onset" class="ui tab pitem-wrap overflow-auto" data-tab="onset">
            <div id="grid_slider_onset_entity_not_exit" style="display: none">
                <div class="datagrid-empty-no">{$Think.lang.Task_Not_Belong_Entity}</div>
            </div>
            <div id="grid_slider_onset_link_not_exit" class="onset-select" style="display: none">
                <!--不存在onset管理数据，选择一个Onset关联-->
                <form id="grid_slider_onset_add_link_onset" >
                    <div class="form-group required">
                        <input id="grid_slider_onset_select_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="onset_module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                        <input id="grid_slider_onset_select_entity_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="link_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                        <input id="grid_slider_onset_select_entity_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">
                            {$Think.lang.Select_One_OnSet_Link}
                        </label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <input id="grid_slider_onset_select_list" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="onset_id" wiget-name="{$Think.lang.Select_One_OnSet_Link}">
                            </div>
                        </div>
                    </div>
                    <div class="form-button-full">
                        <a href="javascript:;" onclick="Strack.add_link_onset(this);" data-tab="info">
                            <div class="form-button-long form-button-hover">
                                {$Think.lang.Submit}
                            </div>
                        </a>
                    </div>
                </form>
            </div>
            <div id="grid_slider_onset_info_main" class="task-info-mainwrap" style="display: none">
                <!--onset main-->
                <div class="onset-camera-show">
                    <div class="onset_show_cam onset_camera_infor_p">_</div>
                    <div class="onset_camera_infor_L">{$Think.lang.Film_Back}</div>
                    <div class="onset_camera_infor_C">{$Think.lang.Field_Of_View}</div>
                    <div class="onset_camera_infor_R">{$Think.lang.Frame_Size}<span class="onset_show_res"></span></div>
                    <div class="onset_camera_infor_B">{$Think.lang.Focal_Length}</div>
                    <div class="onset_show_focal onset_camera_infor_Bb"></div>
                </div>
                <div id="grid_slider_onset_info" class="onset-info-edit">
                    <!--onset info-->
                </div>
            </div>
        </div>
        <div id="grid_slider_tab_onset_att" class="ui tab pitem-wrap overflow-auto" data-tab="onset_att">
            <div id="grid_slider_onset_att_entity_not_exit" style="display: none">
                <div class="datagrid-empty-no">{$Think.lang.Task_Not_Belong_Entity}</div>
            </div>
            <div id="grid_slider_onset_att_link_not_exit" class="onset-select" style="display: none">
                <!--不存在onset管理数据，选择一个Onset关联-->
                <form id="grid_slider_onset_att_add_link_onset" >
                    <div class="form-group required">
                        <input id="grid_slider_onset_att_select_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="onset_module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                        <input id="grid_slider_onset_att_select_entity_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="link_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                        <input id="grid_slider_onset_att_select_entity_module_id" type="hidden" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="module_id" wiget-name="{$Think.lang.ID}" placeholder="{$Think.lang.ID}">
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">
                            {$Think.lang.Select_One_OnSet_Link}
                        </label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <input id="grid_slider_onset_att_select_list" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="onset_id" wiget-name="{$Think.lang.Select_One_OnSet_Link}">
                            </div>
                        </div>
                    </div>
                    <div class="form-button-full">
                        <a href="javascript:;" onclick="Strack.add_link_onset(this);" data-tab="reference">
                            <div class="form-button-long form-button-hover">
                                {$Think.lang.Submit}
                            </div>
                        </a>
                    </div>
                </form>
            </div>
            <div id="grid_slider_onset_att_link_main" class="page-onset-wrap" style="display: none">
                <div class="table-header">
                    <div class="st-buttons-sig aign-left">
                        <a id="grid_slider_onset_att_bnt" href="javascript:;" onclick="Strack.upload_onset_att(this)" data-linkid="" data-moduleid="" data-from="slider">
                            <i class="icon plus icon-left"></i>
                            <span class="stp-title">{$Think.lang.Onset_Reference}</span>
                        </a>
                    </div>
                </div>
                <div id="grid_slider_onset_att_wrap" class="slider-onset-reference">
                    <!--onset att main-->
                </div>
            </div>
        </div>
        <div id="grid_slider_tab_table" class="ui tab pitem-wrap" data-tab="table">
            <div class="grid-slider-tab-table">
                <table id="grid_slider_datagrid_box"></table>
                <div id="grid_slider_tb" style="padding:5px;">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="obj.status_modify();">
                        {$Think.lang.Add}
                    </a>
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.status_delete();">
                        {$Think.lang.Delete}
                    </a>
                </div>
            </div>
        </div>
        <div id="grid_slider_tab_history" class="ui tab pitem-wrap overflow-auto" data-tab="history">
            <div class="pitem-history history-line">
                <div id="grid_slider_history" class="pitem-history-list">
                    <!--表格边侧栏历史记录-->
                </div>
            </div>
        </div>
        <div id="grid_slider_tab_iframe_page" class="ui tab pitem-wrap" data-tab="iframe_page">
            <!--iframe 页面-->
        </div>
    </div>
</div>
<div class="grid-slider-dotted"></div>
<div class="x-resizable-handle"></div>