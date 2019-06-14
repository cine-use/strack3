<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Project_Setting_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_project.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_project.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
      var ProjectPHP = {
          'getAdminProjectList'  : '{:U("Admin/Manage/getAdminProjectList")}',
          'getProjectDetails' : '{:U("Admin/Manage/getProjectDetails")}',
          'modifyProject' : '{:U("Admin/Manage/modifyProject")}',
          'deleteProject': '{:U("Admin/Manage/deleteProject")}'
      };
      Strack.G.MenuName="manage";
  </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Project_Setting}
</block>

<block name="admin-main">
  <div id="active-manage" class="admin-content-dept">
    <div class="admin-temp-left">
      <div class="dept-col-wrap">

        <div class="dept-form-wrap proj-tb">
          <h3 class="aign-left">{$Think.lang.Project_List}</h3>
          <div class="ad-left-search">
            <div class="ui search aign-right">
              <div class="ui icon input">
                <a href='javascript:;' class="st-down-filter stdown-filter" >
                  <i class="filter icon"></i>
                </a>
                <input id="search_val" class="prompt" placeholder="{$Think.lang.Search_More}" type="text" autocomplete="off">
                <a href="javascript:;" id="search_project_bnt" class="st-filter-action" onclick="obj.project_filter(this);">
                  <i class="search icon"></i>
                </a>
              </div>
              <div class="results"></div>
            </div>
          </div>
        </div>

        <div class="admin-temp-list">
          <div id="project_list" class="ui middle aligned divided list">
          </div>
        </div>

      </div>
    </div>
    <div class="admin-temp-right">
      <input id="active_project_id" name="project_id" type="hidden" autocomplete="off">
      <div class="temp-setlist-wrap">
        <div class="temp-setlist-no">
          <p>{$Think.lang.Please_Select_One_Project}</p>
        </div>
        <div class="admin-temp-rheader hide-rheader">
          <if condition="$view_rules.save_project == 'yes' ">
            <a href="javascript:;" class="easyui-linkbutton easyui-icon-save" iconCls="icon-save" plain="true" onclick="obj.project_save();">
              {$Think.lang.Save_Project}
            </a>
          </if>
          <if condition="$view_rules.delete_project == 'yes' ">
            <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.project_delete();">
              {$Think.lang.Delete_Project}
            </a>
          </if>
        </div>
        <div id="project_details" class="dept-form-wrap pform-wrap hide-rheader">

          <div id="project_thumb" class="item-thumb-warp">
              <!--后台项目管理缩略图 缩略图-->
          </div>


          <div class="project-info-form">
            <form id="modify_project" >
              <div class="form-field form-required term-name-wrap required">
                <label for="name">{$Think.lang.Name}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_name" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Project_Name}">
                  <else/>
                  <input id="project_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Project_Name}">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap required">
                <label for="code">{$Think.lang.Code}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_code" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Project_Code}">
                  <else/>
                  <input id="project_code" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Project_Code}">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap required">
                <label for="status">{$Think.lang.Status}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_status" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="status_id" wiget-name="{$Think.lang.Status}">
                  <else/>
                  <input id="project_status" class="form-input" data-options="disabled:true">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap">
                <label for="rate">{$Think.lang.Rate}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_rate" class="form-control form-input text-align-center" autocomplete="off" wiget-type="input" wiget-need="no" wiget-field="rate" wiget-name="{$Think.lang.Rate}" placeholder="{$Think.lang.Input_Project_Rate}">
                  <else/>
                  <input id="project_rate" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Project_Rate}">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap">
                <label for="start_date">{$Think.lang.Start_Date}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_start" class="form-input" autocomplete="off" wiget-type="datebox" wiget-need="no" wiget-field="start_time" wiget-name="{$Think.lang.Start_Date}">
                  <else/>
                  <input id="project_start" class="form-input" data-options="disabled:true">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap">
                <label for="end_date">{$Think.lang.End_Date}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <input id="project_end" class="form-input" autocomplete="off" wiget-type="datebox" wiget-need="no" wiget-field="end_time" wiget-name="{$Think.lang.End_Date}">
                  <else/>
                  <input id="project_end" class="form-input" data-options="disabled:true">
                </if>
              </div>
              <div class="form-field form-required term-name-wrap">
                <label for="description">{$Think.lang.Description}</label>
                <if condition="$view_rules.save_project == 'yes' ">
                  <textarea id="project_description" class="form-control form-input" autocomplete="off" wiget-type="textarea" wiget-need="no" wiget-field="description" wiget-name="{$Think.lang.Description}" placeholder="{$Think.lang.Input_Project_Description}"></textarea>
                  <else/>
                  <textarea id="project_description" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Project_Description}"></textarea>
                </if>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
</block>