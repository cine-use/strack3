<extend name="tpl/Base/common_media.tpl"/>

<block name="head-title"><title>{$Think.lang.Media_Title}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__JS__/lib/three.min.js"></script>
  <script type="text/javascript" src="__JS__/lib/strack.media.controls.js"></script>
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/strack.paint.js"></script>
    <script type="text/javascript" src="__JS__/src/home/media.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/strack.paint.min.js"></script>
    <script type="text/javascript" src="__JS__/build/home/media.min.js"></script>
  </if>
  <if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__COM_CSS__/src/media.css">
    <else/>
    <link rel="stylesheet" href="__COM_CSS__/build/media.min.css">
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
      var MediaPHP = {
          'getMediaGridData': '{:U('Home/Media/getMediaGridData')}',
          'deleteFileCommit': '{:U('Home/File/deleteFileCommit')}',
          'savePlaylist': '{:U("Home/Media/savePlaylist")}',
          'getReviewPlaylist': '{:U("Home/Media/getReviewPlaylist")}',
          'deleteReviewPlaylist': '{:U("Home/Media/deleteReviewPlaylist")}',
          'getReviewTaskList': '{:U("Home/Media/getReviewTaskList")}',
          'deleteReviewTask': '{:U("Home/Media/deleteReviewTask")}',
          'getReviewFollowPlaylist': '{:U("Home/Media/getReviewFollowPlaylist")}',
          'followReviewPlaylist': '{:U("Home/Media/followReviewPlaylist")}',
          'getTimeLineFileCommitData': '{:U("Home/File/getTimeLineFileCommitData")}',
          'getPlaylistTimeLineData': '{:U("Home/File/getPlaylistTimeLineData")}',
          'getReviewTaskTimeLineData': '{:U("Home/File/getReviewTaskTimeLineData")}',
          'getPlayEntityInfo': '{:U("Home/Entity/getPlayEntityInfo")}',
          'getReviewTaskInfoData': '{:U("Home/Base/getReviewTaskInfoData")}',
          'getReviewEntityProgress': '{:U("Home/Media/getReviewEntityProgress")}'
      };
      Strack.G.MenuName = "project_inside";
      Strack.G.ModuleId = {$module_id};
      Strack.G.ModuleType = '{$module_type}';
      Strack.G.ProjectId = {$project_id};
  </script>
</block>
<block name="main">

  <div id="page_hidden_param">
    <input name="url_scene" type="hidden" value="{$url_tag.url_scene}">
    <input name="url_tab" type="hidden" value="{$url_tag.url_tab}">
    <input name="url_id" type="hidden" value="{$url_tag.url_id}">
    <input name="url_item_name" type="hidden" value="{$url_tag.url_item_name}">
    <input name="project_id" type="hidden" value="{$project_id}">
    <input name="page" type="hidden" value="{$page}">
    <input name="template_id" type="hidden" value="{$template_id}">
    <input name="module_id" type="hidden" value="{$module_id}">
    <input name="module_type" type="hidden" value="{$module_type}">
    <input name="task_module_id" type="hidden" value="{$task_module_id}">
    <input name="review_module_id" type="hidden" value="{$review_module_id}">
    <input name="file_commit_module_id" type="hidden" value="{$file_commit_module_id}">
    <input name="module_code" type="hidden" value="{$module_code}">
    <input name="module_name" type="hidden" value="{$module_name}">
    <input name="rule_palylist" type="hidden" value="{$view_rules.left_panel}">
    <input name="rule_review" type="hidden" value="{$view_rules.right_panel}">
    <input name="rule_thumb_modify" type="hidden" value="{$view_rules.right_panel__base_info__modify_thumb}">
    <input name="rule_thumb_clear" type="hidden" value="{$view_rules.right_panel__base_info__clear_thumb}">
    <input name="rule_file_commit" type="hidden" value="{$view_rules.file_commit}">
    <input name="rule_web_player" type="hidden" value="{$view_rules.player}">
    <input name="rule_web_player_painter" type="hidden" value="{$view_rules.player__player_painter}">
    <input name="rule_web_player_metadata" type="hidden" value="{$view_rules.player__metadata}">
    <input name="rule_web_player_drag" type="hidden" value="{$view_rules.player__drag}">
    <input name="rule_task_delete" type="hidden" value="{$view_rules.left_panel__tab_review_task}">
    <input name="rule_playlist_delete" type="hidden" value="{$view_rules.left_panel__tab_playlist__delete}">
    <input name="rule_playlist_modify" type="hidden" value="{$view_rules.left_panel__tab_playlist__modify}">
    <input name="rule_playlist_follow" type="hidden" value="{$view_rules.left_panel__tab_playlist__follow}">
    <input name="rule_file_commit_panel_filter" type="hidden" value="{$view_rules.file_commit__filter_panel}">
    <input name="rule_file_commit_modify_filter" type="hidden" value="{$view_rules.file_commit__filter_panel__save_filter}">
    <input name="rule_file_commit_sort" type="hidden" value="{$view_rules.file_commit__toolbar__sort}">
    <input name="rule_file_commit_group" type="hidden" value="{$view_rules.file_commit__toolbar__group}">
  </div>

  <div id="st_media_wrap" class="st-media-wrap ui grid">

    <div id="st_media_left" class="st-media-left three wide column">
      <if condition="$view_rules.left_panel == 'yes' ">
        <!--media 页面左侧播放列表管理-->
        <div class="media-left-wrap">

          <div class="info-head">
            <a href='javascript:;' id="top_bnt_left"  class="button" onclick="obj.hidden_panel(this)" data-pos="left">
              <i class="icon-uniF100"></i>
            </a>
          </div>

          <div class="info-tab ui grid">
            <div class="center aligned two column row title">
              <if condition="$view_rules.left_panel__tab_review_task == 'yes' ">
                <a href='javascript:;' class="wide column tab playlist-tab" onclick="obj.toggle_playlist_tab(this)" data-tab="task">
                  {$Think.lang.Review_Task}
                </a>
              </if>
              <if condition="$view_rules.left_panel__tab_playlist == 'yes' ">
                <a href='javascript:;' class="wide column tab playlist-tab active" onclick="obj.toggle_playlist_tab(this)" data-tab="playlist">
                  {$Think.lang.Playlist}
                </a>
              </if>
            </div>
          </div>

          <!--左侧面板 搜索框-->
          <div class="st-media-search">
            <div class="ui search">
              <div class="ui icon input">
                <a href='javascript:;' class="st-down-filter">
                  <i class="filter icon"></i>
                </a>
                <input id="left_search_val" class="prompt" placeholder="{$Think.lang.Search_More}" type="text" autocomplete="off">
                <a href="javascript:;" id="left_search_bnt" class="st-filter-action" onclick="obj.search_left_panel(this);">
                  <i class="search icon"></i>
                </a>
              </div>
              <div class="results"></div>
            </div>
          </div>

          <div class="media-review-list">

            <if condition="$view_rules.left_panel__tab_review_task == 'yes' ">
              <!--左侧面板 列表区域-->
              <div id="media_review_task" class="ui tab pitem-wrap">
                <!--审核任务列表-->

                <div class="media-inside-tab">
                  <div class="inside-tab ui grid">
                    <div class="center aligned two column row title">
                      <a href='javascript:;' class="wide column tab playlist-inside-tab" onclick="obj.toggle_playlist_inside_tab(this)" data-tab="my_review">
                        {$Think.lang.My_Review}
                      </a>
                      <a href='javascript:;' class="wide column tab playlist-inside-tab" onclick="obj.toggle_playlist_inside_tab(this)" data-tab="all_task">
                        {$Think.lang.Whole}
                      </a>
                    </div>
                  </div>
                </div>
                <div id="playlist_inside_my_review" class="ui tab media-task-list inside-wrap-playlist">
                  <!--播放列表内标签，我创建的列表-->
                  <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                </div>
                <div id="playlist_inside_all_task" class="ui tab media-task-list inside-wrap-playlist">
                  <!--播放列表内标签，所有列表-->
                  <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                </div>
              </div>
            </if>

            <if condition="$view_rules.left_panel__tab_playlist == 'yes' ">
              <div id="media_review_playlist" class="ui tab pitem-wrap active">
                <!--播放列表-->
                <div class="media-playlist-title">
                  <eq name="view_rules.left_panel__tab_playlist__create" value="yes">
                    <a href="javascript:;" id="add_playlist_bnt" class="m-playlist-bnt aign-left" onclick="obj.add_playlist(this)">
                      <i class="icon plus"></i>
                      {$Think.lang.Playlist}
                    </a>
                  </eq>
                  <div class="m-playlist-name aign-right">
                  </div>
                </div>
                <div class="media-inside-tab">
                  <div class="inside-tab ui grid">
                    <div class="center aligned three column row title">
                      <a href='javascript:;' class="wide column tab playlist-inside-tab" onclick="obj.toggle_playlist_inside_tab(this)" data-tab="my_create">
                        {$Think.lang.My_Created}
                      </a>
                      <a href='javascript:;' class="wide column tab playlist-inside-tab" onclick="obj.toggle_playlist_inside_tab(this)" data-tab="follow">
                        {$Think.lang.My_Followed}
                      </a>
                      <a href='javascript:;' class="wide column tab playlist-inside-tab" onclick="obj.toggle_playlist_inside_tab(this)" data-tab="all_playlist">
                        {$Think.lang.Whole}
                      </a>
                    </div>
                  </div>
                </div>
                <div id="playlist_inside_my_create" class="ui tab st-media-playlist inside-wrap-playlist">
                  <!--播放列表内标签，我创建的列表-->
                  <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                </div>
                <div id="playlist_inside_all_playlist" class="ui tab st-media-playlist inside-wrap-playlist">
                  <!--播放列表内标签，所有列表-->
                  <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                </div>
                <div id="playlist_inside_follow" class="ui tab st-media-playlist inside-wrap-playlist">
                  <!--播放列表内标签，我关注的列表-->
                  <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                </div>
              </div>
            </if>
          </div>

          <div class="add-review-entity" style="display: none">
            <!--添加播放列表面板-->
            <div class="head-bnt ui grid">
              <div class="center aligned two column row title">
                <div id="add_playlist_title" href='javascript:;' class="wide column tab name">
                  {$Think.lang.Add_Playlist}
                </div>
                <a href='javascript:;' class="wide column tab close" onclick="obj.close_review_add_playlist(this)">
                  <i class="icon-uniE6DF"></i>
                </a>
              </div>
            </div>
            <div id="add_playlist_form" class="item">
              <!--未保存播放列表-->
              <div class="playlist-group-title">
                <div class="playlist-g-name aign-left">
                  {$Think.lang.Review_Entity_Info}
                </div>
              </div>
              <div class="title required">
                <label>{$Think.lang.Name}</label>
              </div>
              <div class="input">
                <input id="review_entity_name" class="form-input text" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Review_Entity_Name}">
              </div>
              <div class="title required">
                <label>{$Think.lang.Code}</label>
              </div>
              <div class="input">
                <input id="review_entity_code" class="form-input text" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Review_Entity_Code}">
              </div>
              <div class="title required">
                <label>{$Think.lang.Status}</label>
              </div>
              <div class="input">
                <input id="review_entity_status" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="status_id" wiget-name="{$Think.lang.Status}">
              </div>
            </div>
            <div class="task">
              <!--新增step任务-->
              <div class="playlist-group-title">
                <div class="playlist-g-name aign-left required">
                  <label>{$Think.lang.Distribute_Review_Task}</label>
                </div>
              </div>
              <div class="input">
                <input id="review_entity_step" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="step_id" wiget-name="{$Think.lang.Step}">
              </div>
              <div id="review_entity_step_task" class="list">
                <div class="datagrid-empty-no">{$Think.lang.Please_Select_Step}</div>
              </div>

            </div>
          </div>

          <div id="step_task_details" class="task-details" style="display: none">
            <div class="edit-panel">
              <div class="title ui grid">
                <div class="center aligned two column row title">
                  <div href='javascript:;' class="wide column tab name">
                    {$Think.lang.Review_Task}
                  </div>
                  <a href='javascript:;' class="wide column tab close" onclick="obj.close_review_task_details(this)">
                    <i class="icon-uniE6DF"></i>
                  </a>
                </div>
              </div>
              <div class="etask-right-main" style="display: block;">
                <div class="etask-right-input">
                  <div class="st-dialog-items">
                    <div class="st-dialog-name">{$Think.lang.Field}</div>
                    <div class="st-dialog-input">
                      <input id="m_review_task_fields" class="dialog-widget-val" data-widget="widget" data-name="fields" data-valid="1">
                    </div>
                  </div>
                </div>
                <div class="st-dialog-up">
                  <ul id="m_review_task_item" class="dg-report-list">
                    <!--媒体审核任务字段修改面板-->
                    <div class="etask-right-null">
                      <div class="datagrid-empty-no">{$Think.lang.Please_Select_Base}</div>
                    </div>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
      </if>
    </div>



    <div id="st_media_mid" class="st-media-center nine wide column">


      <!--播放器视图区域-->
      <div class="media-player">

        <!--绘制工具栏区域-->
        <div id="preview_paint" class="left-paint">
          <div id="paint_menu" class="paint-main"></div>
          <a href="javascript:;" class="bnt-icon" onclick="obj.toggle_paint_tools(this)">
            <i class="icon-uniE76A"></i>
          </a>
        </div>

        <!--画布区域-->
        <div id="media_player_view" class="right-view">
          <div class="view-main">
            <!--播放区域-->
            <div class="bg-icon">
              <i class="icon-strack_logo"></i>
            </div>
            <div id="video_main" class="video-main">
              <!--video canvas-->
            </div>
            <div id="vp_canvas_wrap" class="vp-canvas-wrap">
              <div id="video_paint" class="video-paint-canvas">
                <!--paint canvas-->
              </div>
            </div>
          </div>

          <!--left media metadata-->
          <eq name="view_rules.player__metadata" value="yes">
            <div id="media_metadata_wrap" class="media-metadata">
              <div class="mc-meta-name aign-left">
                <ul id="metadata_name">
                  <!--media metadata title-->
                </ul>
              </div>
              <div class="mc-meta-info aign-left">
                <ul id="metadata_show">
                  <!--media metadata show-->
                </ul>
              </div>
            </div>
          </eq>
        </div>

      </div>

      <!--播放器数据表格区域呼出按钮-->
      <div class="media-file-grid">
        <if condition="$view_rules.file_commit == 'yes' ">

          <div class="file-toolbar">
            <!--新增修改播放列表工具栏-->
            <div class="left-pos aign-left ui grid">
              <div class="ui grid row">
                <a href="javascript:;" class="eight wide column button">
                  <div class="timeline-playlist-name" style="padding: 0 20px;text-align: left">
                    {$Think.lang.Playlist_Name}
                  </div>
                </a>
                <a href="javascript:;" class="four wide column button" onclick="obj.add_file_to_timeline(this)">
                  <i class="icon-uniE986 icon-left"></i>{$Think.lang.Add_To_Timeline}
                </a>
                <a href="javascript:;" id="save_playlist_bnt" class="four wide column button" onclick="obj.save_playlist(this)" data-mode="add" data-id="0">
                  <i class="icon-uniF0C7 icon-left"></i><span>{$Think.lang.Save_Timeline}</span>
                </a>
              </div>
            </div>
          </div>

          <div class="media-file-grid-bnt grid-bnt-top">
            <a href="javascript:;" id="grid_button_center" class="grid-button" onclick="obj.show_file_grid_panel(this)" data-pos="top">
              {$Think.lang.Review_file}<i class="icon-uniF103 icon-right"></i>
            </a>
          </div>

          <div id="show_bnt_left" class="show-bnt-top grid-bnt-left">
            <a href="javascript:;" id="grid_button_left" class="grid-button" onclick="obj.show_panel(this)" data-pos="left">
              <span>{$Think.lang.Playlist}</span><i class="icon-uniF101 icon-right"></i>
            </a>
          </div>

          <div id="show_bnt_right"  class="show-bnt-top grid-bnt-right">
            <a href="javascript:;" id="grid_button_right" class="grid-button" onclick="obj.show_panel(this)" data-pos="right">
              <i class="icon-uniF100 icon-left"></i><span>{$Think.lang.Feedback}</span>
            </a>
          </div>

          <!--播放器数据表格区域-->
          <div id="file_grid_panel" class="grid-wrap">
            <div class="info-head">
              {$Think.lang.File_Commit}
            </div>
            <!--grid data list-->
            <div id="grid_datagrid_main" class="entity-datalist base-m-grid">
              <div id="tb_grid" class="proj-tb tb-padding-grid grid-toolbar" data-grid="main_datagrid_box" data-page="{$page}" data-schemapage="{$page}" data-moduleid="{$file_commit_module_id}" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">

                <eq name="view_rules.file_commit__toolbar__edit" value="yes">
                  <div class="ui dropdown st-dropdown aign-left">
                    {$Think.lang.Edit}<i class="dropdown icon"></i>
                    <div class="menu edit-menu">

                      <eq name="view_rules.file_commit__toolbar__edit__batch_edit" value="yes">
                        <a href="javascript:;" class="item" onclick="obj.media_edit(this);" data-lang="{$Think.lang.Batch_Edit}">
                          <i class="icon-uniF044 icon-left"></i>
                          {$Think.lang.Modify}
                        </a>
                      </eq>

                      <div class="divider"></div>

                      <eq name="view_rules.file_commit__toolbar__edit__import_excel" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.import_excel_data(this);">
                          <i class="icon-uniE986 icon-left"></i>
                          <span class="stp-title">{$Think.lang.Import_Excel}</span>
                        </a>
                      </eq>

                      <eq name="view_rules.file_commit__toolbar__edit__export_excel" value="yes">
                        <a href='javascript:;' class="item" onclick="Strack.export_excel_file(this);">
                          <i class="icon-uniE6082 icon-left"></i>
                          <span class="stp-title">{$Think.lang.Export_Excel}</span>
                        </a>
                      </eq>

                      <eq name="view_rules.file_commit__toolbar__edit__action" value="yes">
                        <div class="divider"></div>
                        <a href="javascript:;" class="item" onclick="Strack.open_action_slider(this);" data-from="grid" data-grid="main_datagrid_box" data-moduleid="{$file_commit_module_id}" data-projectid="{$project_id}">
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

                      <eq name="view_rules.file_commit__toolbar__edit__batch_delete" value="yes">
                        <div class="divider"></div>
                        <a href="javascript:;" class="item" onclick="obj.media_delete(this);">
                          <i class="icon-uniE9D5 icon-left"></i>
                          {$Think.lang.Delete}
                        </a>
                      </eq>
                    </div>
                  </div>
                </eq>

                <eq name="view_rules.file_commit__toolbar__sort" value="yes">
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

                <eq name="view_rules.file_commit__toolbar__group" value="yes">
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

                <eq name="view_rules.file_commit__toolbar__column" value="yes">
                  <div class="ui dropdown st-dropdown aign-left">
                    {$Think.lang.Display_Column}<i class="dropdown icon"></i>
                    <div class="menu grid_fields">
                      <!--fields list-->
                      <eq name="view_rules.file_commit__toolbar__column__manage_custom_fields" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.manage_fields(this);" data-lang="{$Think.lang.Manage_Custom_Fields}">
                          <i class="icon-uniE71D icon-left"></i>{$Think.lang.Manage_Custom_Fields}
                        </a>
                      </eq>
                    </div>
                  </div>
                </eq>

                <eq name="view_rules.file_commit__toolbar__view" value="yes">
                  <div class="ui dropdown st-dropdown aign-left grid-view-bnt">
                    {$Think.lang.View}<i class="dropdown icon"></i>
                    <div class="menu grid_view">
                      <!--view list-->
                      <eq name="view_rules.file_commit__toolbar__view__save_view" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.save_view(this);" data-panel="grid">
                          <i class="icon-uniF0C7 icon-left"></i>{$Think.lang.Save}
                        </a>
                      </eq>
                      <eq name="view_rules.file_commit__toolbar__view__save_as_view" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.save_as_view(this);" data-panel="grid">
                          <i class="icon-uniF0C5 icon-left"></i>{$Think.lang.SaveAs}
                        </a>
                      </eq>
                      <eq name="view_rules.file_commit__toolbar__view__modify_view" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.modify_view(this);" data-panel="grid">
                          <i class="icon-uniEA9B icon-left"></i>{$Think.lang.Modify}
                        </a>
                      </eq>
                      <eq name="view_rules.file_commit__toolbar__view__delete_view" value="yes">
                        <a href="javascript:;" class="item" onclick="Strack.delete_view(this);" data-panel="grid">
                          <i class="icon-uniE9D5 icon-left"></i>{$Think.lang.Delete}
                        </a>
                      </eq>
                    </div>
                    <span class="current_view">（{$Think.lang.Default_View}）</span>
                  </div>
                </eq>

                <eq name="view_rules.file_commit__filter_panel" value="yes">
                  <div class="ui search aign-right">
                    <input id="main_grid_search" autocomplete="off"/>
                  </div>
                </eq>

              </div>
              <table id="main_datagrid_box" class="datagrid-table"></table>
            </div>

            <eq name="view_rules.file_commit__filter_panel" value="yes">
              <div id="grid_filter_main" class="datagrid-filter filter-full-active filter-min" data-grid="main_datagrid_box" data-page="{$page}" data-schemapage="{$page}" data-moduleid="{$file_commit_module_id}" data-maindom="grid_datagrid_main" data-bardom="grid_filter_main" data-projectid="{$project_id}">
                <!--过滤面板-->
              </div>
            </eq>

          </div>
        </if>
      </div>


      <!--webplayer center handle-->
      <div class="center-handle">
        <a href="javascript:;" class="center-handle-icon" onclick="obj.toggle_track(this)" data-pos="top">
          <i class="icon-uniE76B"></i>
        </a>
      </div>

      <!--播放器控制区域-->
      <div class="media-player-bottom">
        <div id="media_player_disabled" class="player-disabled">
          <div class="datagrid-empty-no">{$Think.lang.Select_Review_Task_Or_Playlist}</div>
        </div>
        <div class="preview-m-control">
          <!--播放器控件-->
          <div class="m-control-play mc-button-base aign-left">
            <a href="javascript:;" id="m_controller_player" class="mc-button" onclick="obj.player_control(this)" data-status="play" data-bnt="play" title="{$Think.lang.Play_Or_Pause}"  / {$Think.lang.Space} >
            <i class="icon-uniEA45"></i>
            </a>
          </div>
          <div class="preview-slider">
            <div id="media_view_slider">
              <!--播放进度条-->
              <div class="default-show slider slider-h">
                <div class="slider-inner"></div>
              </div>
            </div>
          </div>
          <div id="preview_frame" class="preview-frame">
            <span>000</span>/<span>000</span>
          </div>

          <div class="preview-painter mc-button-base-small">
            <!--显示媒体元数据-->
            <a href="javascript:;" id="m_controller_metadata" class="mc-button" onclick="obj.player_control(this)" data-active="off" data-bnt="metadata" title="{$Think.lang.Metadata} / {$Think.lang.Shortcut} i">
              <i class="icon-uniE613"></i>
            </a>
          </div>
          <div class="preview-fullscreen mc-button-base-small">
            <!--全屏媒体视图区域-->
            <a href="javascript:;" id="m_controller_fullscreen" class="mc-button" onclick="obj.player_control(this)" data-active="off" data-bnt="fullscreen" title="{$Think.lang.Fullscreen}">
              <i class="icon-uniE9B4"></i>
            </a>
          </div>
          <if condition="$view_rules.right_panel__note == 'yes' AND $view_rules.player__player_painter == 'yes'">
            <div id="preview_painter_bnt"  class="preview-painter mc-button-base-small">
              <!--媒体截屏绘制-->
              <a href="javascript:;" id="m_controller_painter" class="mc-button" onclick="obj.player_control(this)" data-active="off" data-bnt="painter" title="{$Think.lang.Player_Painter} / {$Think.lang.Shortcut} p">
                <i class="icon-uniE6502"></i>
              </a>
            </div>
          </if>
          <div class="preview-painter mc-button-base-small">
            <!--媒体循环播放设置-->
            <a href="javascript:;" id="m_controller_loop" class="mc-button" onclick="obj.player_control(this)" data-loop="all_loop" data-bnt="loop" title="{$Think.lang.Player_Loop}">
              <i class="icon-uniEA56"></i>
            </a>
          </div>
          <div class="preview-fullscreen mc-button-base-small">
            <!--媒体音量设置-->
            <a href="javascript:;" id="m_controller_voice" class="mc-button" onclick="obj.player_control(this)" data-voice="on" data-bnt="voice" title="{$Think.lang.Turn_On_Or_Off_Sound}">
              <i class="icon-uniEA50"></i>
            </a>
          </div>
        </div>

        <div class="video-bnt">
          <!--时间线控制按钮-->
          <div class="left aign-left">
            <div class="ten wide column playlist-name text-ellipsis">
              <input id="timeline_entity_id" type="hidden">
              <span class="timeline-playlist-name" >{$Think.lang.Playlist_Name}</span>
            </div>
          </div>
          <div class="right aign-left ui grid">
            <div class="ui grid row">
              <if condition="$view_rules.left_panel__tab_playlist__follow == 'yes'">
                <div class="four wide column button">
                  <a href="javascript:;" id="timeline_playlist_follow" onclick="obj.timeline_playlist_follow(this)" data-follow="follow">
                    {$Think.lang.Follow}
                  </a>
                </div>
              </if>
              <if condition="$view_rules.player__save_timeline == 'yes'">
                <div class="four wide column button">
                  <a href="javascript:;" id="timeline_playlist_save" onclick="obj.save_timeline_change(this)">
                    {$Think.lang.Save}
                  </a>
                </div>
              </if>
              <if condition="$view_rules.player__reload_timeline == 'yes'">
                <div class="start-now eight wide column button" >
                  <a href="javascript:;"onclick="obj.reload_timeline(this)">
                    <i class="icon icon-uniE682"></i>
                    <span>{$Think.lang.Reload_Timeline}</span>
                  </a>
                </div>
              </if>
            </div>
          </div>
        </div>

        <div class="video-timeline">
          <!--时间线-->
          <div class="p-time-wrap">
            <ul id="timeline_track" class="time-track">
              <!--timeline items-->
              <div class="datagrid-empty-no">{$Think.lang.Timeline_Is_Empty}</div>
            </ul>
          </div>
        </div>
      </div>
    </div>


    <div id="st_media_right" class="st-media-right grid-right-wrap four wide column">
      <if condition="$view_rules.right_panel == 'yes' ">
        <div class="media-right-wrap">
          <div class="info-head">
            <a href='javascript:;' id="top_bnt_right" class="button" onclick="obj.hidden_panel(this)" data-pos="right">
              <i class="icon-uniF101"></i>
            </a>
          </div>
          <div class="info-tab ui grid">
            <div class="center aligned three column row title">
              <if condition="$view_rules.right_panel__note == 'yes' ">
                <a href='javascript:;' class="wide column tab media-info-tab active" onclick="obj.toggle_info_tab(this)" data-tab="note">
                  {$Think.lang.Notes}
                </a>
              </if>
              <if condition="$view_rules.right_panel__review_progress == 'yes' ">
                <a href='javascript:;' class="wide column tab media-info-tab" onclick="obj.toggle_info_tab(this)" data-tab="progress">
                  {$Think.lang.Review_Progress}
                </a>
              </if>
              <if condition="$view_rules.right_panel__base_info == 'yes' ">
                <a href='javascript:;' class="wide column tab media-info-tab" onclick="obj.toggle_info_tab(this)" data-tab="details">
                  {$Think.lang.Base_Info}
                </a>
              </if>
            </div>
          </div>

          <div id="media_info_note" class="ui tab pitem-wrap note-editor-slider" data-baseh="135">
            <!--媒体信息Note页面-->
            <div class="pyn-screenshot">
              <div id="screenshot_list"  class="pyn-st-wrap">
                <!--screenshot list-->
                <div class="pyn-st-null">{$Think.lang.Screenshot_Null}</div>
              </div>
            </div>

            <div class="pyn-editor task-editor-wrap">
              <!--editor-->
              <textarea id="comments_editor" autocomplete="off"></textarea>
            </div>
            <div class="pyn-fd-wrap">
              <div class="pyn-fd-list task-mainwrap-footer">
                <div id="comments_list" class="ui threaded comments note-comments">
                  <!--反馈note list-->
                  <div class="note-stick">
                  </div>
                  <div class="note-no-stick">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <if condition="$view_rules.right_panel__review_progress == 'yes' ">
            <div id="media_info_progress" class="ui tab pitem-wrap overflow-auto">
              <!--媒体信息反馈进度页面-->
              <div class="progress-wrap">
                <div class="ui one column grid">
                  <div id="review_entity_progress" class="column">
                    <div class="etask-right-null">
                      <div class="datagrid-empty-no">{$Think.lang.Datagird_No_Data}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </if>

          <div id="media_info_details" class="ui tab pitem-wrap overflow-auto">
            <!--媒体信息详情页面-->
            <div id="media_base_thumb" class="project-thumb-wrap">
              <!--缩略图-->
            </div>
            <div id="media_base_info" class="project-info-wrap task-info-mainwrap">
              <!--基本信息-->
            </div>
          </div>

        </div>
      </if>
    </div>


  </div>
</block>