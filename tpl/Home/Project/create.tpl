<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Add_Project_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/project_create.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/project_create.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var ProjectPHP = {
            'addProject': '{:U("Home/Project/addProject")}',
            'getTemplateList': '{:U("Home/Project/getTemplateList")}',
            'project_create': '{:U('/project/index')}'
        };
        Strack.G.MenuName = "project_create";
    </script>
</block>

<block name="main">
    <div id="page_hidden_param">
        <input name="page" type="hidden" value="{$page}">
        <input name="module_id" type="hidden" value="{$module_id}">
    </div>
    <div id="add_project_page" class="add-project-wrap">
        <div id="project_step" class="step-body">
            <div class="project-step-h">
                <div class="step-header">
                    <ul>
                        <li>
                            <span class="step-name">{$Think.lang.Add_Project_Step_Template}</span>
                        </li>
                        <li>
                            <span class="step-name">{$Think.lang.Add_Project_Step_Info}</span>
                        </li>
                        <li>
                            <span class="step-name">{$Think.lang.Add_Project_Step_Disk}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="project-step-content">
                <div class="step-content step-content-wrap">
                    <div class="step-list template-list">
                        <div class="ui segment">
                            <div class="step-template-name">
                                <i class="icon-uniE944 icon-left"></i>
                                {$Think.lang.Builtin_template}
                            </div>
                            <div class="step-template-list">
                                <div id="template_builtin_list" class="ui grid">
                                    <div class="datagrid-empty-no">{$Think.lang.No_Builtin_Templates}</div>
                                </div>
                            </div>
                        </div>
                        <div class="ui segment">
                            <div class="step-template-name">
                                <i class="icon-uniE74F icon-left"></i>
                                {$Think.lang.Project_Template}
                            </div>
                            <div class="step-template-list">
                                <div id="template_project_list"  class="ui grid">
                                    <div class="datagrid-empty-no">{$Think.lang.No_Project_Templates}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-list">
                        <form id="add_project_info" >
                            <div class="ui segment">
                                <div class="step-template-name">
                                    {$Think.lang.Required_Info}
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name required">
                                        <label>{$Think.lang.Name}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_name" class="form-control form-input text-align-center" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Project_Name}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name required">
                                        <label>{$Think.lang.Code}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_code" class="form-control form-input text-align-center" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Project_Code}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name required">
                                        <label>{$Think.lang.Status}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_status" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="status_id" wiget-name="{$Think.lang.Status}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name required">
                                        <label>{$Think.lang.Public}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_public" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="public" wiget-name="{$Think.lang.Public}">
                                    </div>
                                </div>
                            </div>
                            <div id="project_upload_thumbnail" class="ui segment">
                                <div class="step-template-name">
                                    {$Think.lang.Thumbnail}
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.File}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <div class="thumb-queue">
                                            <div id="project_thumb_queue" class="single_queue"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <div class="thumb-queue-bnt">
                                            <input id="choice_project_thumb" name="project_thumb" multiple="true" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui segment">
                                <div class="step-template-name">
                                    {$Think.lang.Project_Group}
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.Copy_Project_Group}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <div class="group-open">
                                            <input id="project_group_open" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="group_open" wiget-name="{$Think.lang.Copy_Project_Group}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui segment">
                                <div class="step-template-name">
                                    {$Think.lang.More_Info}
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.Rate}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input id="info_project_rate" class="form-control form-input text-align-center" autocomplete="off" wiget-type="input" wiget-need="no" wiget-field="rate" wiget-name="{$Think.lang.Rate}" placeholder="{$Think.lang.Input_Project_Rate}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.Start_Date}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_start" class="form-input" autocomplete="off" wiget-type="datebox" wiget-need="no" wiget-field="start_time" wiget-name="{$Think.lang.Start_Date}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.End_Date}</label>
                                    </div>
                                    <div class="proj-sinfo-input">
                                        <input  id="info_project_end" class="form-input" autocomplete="off" wiget-type="datebox" wiget-need="no" wiget-field="end_time" wiget-name="{$Think.lang.End_Date}">
                                    </div>
                                </div>
                                <div class="proj-step-info">
                                    <div class="proj-sinfo-name">
                                        <label>{$Think.lang.Description}</label>
                                    </div>
                                    <div class="proj-sinfo-input st-textarea">
                                        <textarea  id="info_project_description" class="form-control form-input" autocomplete="off" wiget-type="textarea" wiget-need="no" wiget-field="description" wiget-name="{$Think.lang.Description}" placeholder="{$Think.lang.Input_Project_Description}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="step-list">
                        <div id="add_project_disk" class="ui segment add-project-disk">
                            <div class="overview-disk-top">
                                <div class="title">
                                    {$Think.lang.Project_Disk_Settings_Title}
                                    <a href="javascript:;" class="stmh-tool-bnt margin-bnt-15" onclick="obj.nav_add_disk(this)" style="margin-left: 10px">
                                        <i class="icon-uniEA33"></i>
                                        {$Think.lang.Add_Disks_Title}
                                    </a>
                                </div>
                                <div class="main">
                                    <div class="ui grid disk-setting-item" data-code="default" data-name="{$Think.lang.Default}">
                                        <div class="two column row">
                                            <div class="five wide column">
                                                  <span class="title">
                                                      {$Think.lang.Default}
                                                  </span>
                                            </div>
                                            <div class="eleven wide column combobox">
                                                <input id="disk_global_combobox" autocomplete="off">
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
                </div>
            </div>

            <div class="project-step-bnt">
                <div class="step-bnt-footer">
                    <a id="bottom_bnt_prev" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="obj.step_prev();" style="display: none">{$Think.lang.Previous}</a>
                    <a id="bottom_bnt_next" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="obj.step_next();">{$Think.lang.Next}</a>
                    <a id="bottom_bnt_submit" href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="obj.step_submit();" style="display: none">{$Think.lang.Done}</a>
                </div>
            </div>

        </div>
    </div>
</block>