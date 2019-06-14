<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Project_Template_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_templates.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_templates.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var TemplatePHP = {
            'addProjectTemplate': '{:U("Admin/Template/addProjectTemplate")}',
            'modifyProjectTemplate': '{:U("Admin/Template/modifyProjectTemplate")}',
            'deleteProjectTemplate': '{:U("Admin/Template/deleteProjectTemplate")}',
            'getTemplateList': '{:U("Admin/Template/getTemplateList")}',
            'getProjectTemplateModuleList': '{:U("Admin/Template/getProjectTemplateModuleList")}',
            'getEntitySchemaComboboxList': '{:U("Admin/Template/getEntitySchemaComboboxList")}',
            'getProjectNavModuleList': '{:U("Admin/Template/getProjectNavModuleList")}',
            'getTemplateConfig': '{:U("Admin/Template/getTemplateConfig")}',
            'getStatusDataList': '{:U("Admin/Template/getStatusDataList")}',
            'modifyTemplateConfig': '{:U("Admin/Template/modifyTemplateConfig")}',
            'resetTemplateConfig': '{:U("Admin/Template/resetTemplateConfig")}',
            'getModuleBaseColumns': '{:U("Admin/Template/getModuleBaseColumns")}',
            'getModuleRelationColumns': '{:U("Admin/Template/getModuleRelationColumns")}',
            'getTemplateDataList': '{:U("Admin/Template/getTemplateDataList")}',
            'getProjectBuiltinTemplateList': '{:U("Admin/Template/getProjectBuiltinTemplateList")}',
            'getTemplateStepList': '{:U("Admin/Template/getTemplateStepList")}',
            'getModuleTabList': '{:U("Admin/Template/getModuleTabList")}',
            'getModuleRelationConfig': '{:U("Admin/Template/getModuleRelationConfig")}',
            'getTagDataList': '{:U("Admin/Template/getTagDataList")}'
        };
        Strack.G.MenuName = "template";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Project_Template}
</block>

<block name="admin-main">

    <div id="page_hidden_param">
        <input name="rule_modify" type="hidden" value="{$view_rules.modify}">
        <input name="rule_reset" type="hidden" value="{$view_rules.reset}">
        <input name="rule_delete" type="hidden" value="{$view_rules.delete}">
    </div>

    <div id="active-template" class="admin-content-dept">
        <div class="admin-temp-left">
            <div class="dept-col-wrap">

                <div class="dept-form-wrap proj-tb">
                    <h3 class="aign-left">{$Think.lang.Project_Template_List}</h3>
                    <div class="st-buttons-sig aign-left" style="padding: 7px 6px 0;">
                        <if condition="$view_rules.create == 'yes' ">
                            <a href="javascript:;" onclick="obj.template_add(this);">
                                <i class="icon plus"></i>
                            </a>
                        </if>
                    </div>
                    <div class="ad-left-search">
                        <div class="ui search aign-right">
                            <div class="ui icon input">
                                <a href='javascript:;' class="st-down-filter stdown-filter" >
                                    <i class="filter icon project_filter"></i>
                                </a>
                                <input id="search_val" class="prompt" placeholder="{$Think.lang.Search_More}" type="text" autocomplete="off">
                                <a href="javascript:;" id="search_template_bnt" class="st-filter-action" onclick="obj.template_filter(this);">
                                    <i class="search icon"></i>
                                </a>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-temp-list">
                    <ul id="template_list">
                    </ul>
                </div>
            </div>
        </div>
        <div class="admin-temp-right">
            <table id="template-column"></table>
            <input id="hide_temp_id" type="hidden" autocomplete="off">
            <input id="hide_temp_name"  type="hidden" autocomplete="off">
            <input id="hide_temp_code" type="hidden" autocomplete="off">
            <input id="hide_project_id" type="hidden" autocomplete="off">
            <div class="temp-setlist-wrap">
                <div class="temp-setlist-no">
                    <p>{$Think.lang.Please_Select_One_Template}</p>
                </div>
                <div class="temp-setlists">
                    <div class="admin-temp-content">
                        <div id="temp_module" class="temp-content-left admin-temp-list">
                            <ul id="module_list" class="temp-module-list">
                            </ul>
                        </div>
                        <div class="temp-content-right">
                            <input id="hide_module_id" type="hidden" autocomplete="off">
                            <input id="hide_module_name" type="hidden" autocomplete="off">
                            <input id="hide_module_code" type="hidden" autocomplete="off">

                            <div id="module_temp_set" class="temp-set-wrap">

                                <div class="temp-content-right-no">
                                    <p>{$Think.lang.Please_Select_One_Module}</p>
                                </div>

                                <!--项目模板基础设置-->
                                <div id="temp_set_project" class="temp-set-main">

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE624 icon-left"></i>
                                                {$Think.lang.Current_Use_Schema}
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p id="project_schema_name"></p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF135 icon-left"></i>
                                                {$Think.lang.Navigation}
                                            </div>
                                            <div class="st-property-button">
                                                <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.project_set_nav(this);" data-category="navigation" data-title="{$Think.lang.Template_Project_Nav}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Project_Nav_Desc}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF06E icon-left"></i>
                                                {$Think.lang.Status}
                                            </div>
                                            <div class="st-property-button">
                                                <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_status(this);" data-category="status" data-title="{$Think.lang.Template_Project_Status}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Status_Setting}</p>
                                        </div>
                                    </div>
                                </div>

                                <!--项目模板固定模块设置-->
                                <div id="temp_set_fixed" class="temp-set-main">

                                    <div id="temp_fixed_status" class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF06E icon-left"></i>
                                                {$Think.lang.Status}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="fixed_status" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_status(this);" data-category="status" data-title="{$Think.lang.Template_Status}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Status_Setting}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF15D icon-left"></i>
                                                {$Think.lang.Sort}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="fixed_sort" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_sort(this);" data-category="sort" data-title="{$Think.lang.Template_Base_Sort}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Base_Sort}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE9E5 icon-left"></i>
                                                {$Think.lang.Group}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="fixed_group" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_group(this);" data-category="group"  data-title="{$Think.lang.Template_Base_Group}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Base_Group}</p>
                                        </div>
                                    </div>

                                    <div id="temp_base_tfield" class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE92E icon-left"></i>
                                                {$Think.lang.Template_Details_Top_Field}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="fixed_top_field" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_field(this);" data-category="top_field" data-title="{$Think.lang.Template_Details_Top_Field}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Details_Top_Field_Notice}</p>
                                        </div>
                                    </div>

                                    <div id="temp_fixed_tab" class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE92E icon-left"></i>
                                                {$Think.lang.Tab}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="base_tab" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_tab(this);" data-category="tab" data-title="{$Think.lang.Template_Fixed_Tab}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Fixed_Tab}</p>
                                        </div>
                                    </div>

                                </div>

                                <!--项目模板 note 设置-->
                                <div id="temp_set_note" class="temp-set-main">
                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF06E icon-left"></i>
                                                {$Think.lang.Status}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="note_status" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_status(this);" data-category="status" data-title="{$Think.lang.Template_Note_Status}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Note_Status}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF06E icon-left"></i>
                                                {$Think.lang.Tag}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="note_tag" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_tag(this);" data-category="note_tag" data-from="note_tag" data-title="{$Think.lang.Template_Note_Tag}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Note_Tag}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF15D icon-left"></i>
                                                {$Think.lang.Sort}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="note_sort" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_sort(this);" data-category="sort" data-title="{$Think.lang.Template_Note_Sort}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Note_Sort}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE9E5 icon-left"></i>
                                                {$Think.lang.Group}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="note_group" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_group(this);" data-category="group"  data-title="{$Think.lang.Template_Note_Group}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Note_Group}</p>
                                        </div>
                                    </div>

                                </div>

                                <!--entity 动态模块-->
                                <div id="temp_set_entity" class="temp-set-main">

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF06E icon-left"></i>
                                                {$Think.lang.Status}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_status" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_status(this);" data-category="status" data-title="{$Think.lang.Template_Entity_Status}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Status}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniF15D icon-left"></i>
                                                {$Think.lang.Sort}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_sort" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_sort(this);" data-category="sort" data-title="{$Think.lang.Template_Entity_Sort}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Sort}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE9E5 icon-left"></i>
                                                {$Think.lang.Group}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_group" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_group(this);" data-category="group" data-title="{$Think.lang.Template_Entity_Group}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Group}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE73E icon-left"></i>
                                                {$Think.lang.Steps}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_step" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_step(this);" data-category="step" data-title="{$Think.lang.Template_Entity_Step}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Step}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE757 icon-left"></i>
                                                {$Think.lang.Entity_Step_fields}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_step_fields" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_entity_step_field(this);" data-category="step_fields"  data-title="{$Think.lang.Template_Entity_Step_fields}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Step_fields}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE92E icon-left"></i>
                                                {$Think.lang.Template_Details_Top_Field}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_top_field" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_field(this);" data-category="top_field" data-title="{$Think.lang.Template_Details_Top_Field}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Details_Top_Field_Notice}</p>
                                        </div>
                                    </div>


                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE92E icon-left"></i>
                                                {$Think.lang.Link_Onset_Switch}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_link_onset" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_link_onset(this);" data-category="link_onset"  data-title="{$Think.lang.Template_Entity_Link_Onset_Switch}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Link_Onset_Switch}</p>
                                        </div>
                                    </div>

                                    <div class="st-workflowsummary">
                                        <div class="st-property-header">
                                            <div class="st-property-name">
                                                <i class="icon-uniE92E icon-left"></i>
                                                {$Think.lang.Tab}
                                            </div>
                                            <div class="st-property-button">
                                                <a id="entity_tab" href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.template_set_tab(this);" data-category="tab"  data-title="{$Think.lang.Template_Entity_Tab}">
                                                    {$Think.lang.Edit}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="st-property-info">
                                            <p>{$Think.lang.Template_Entity_Tab}</p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</block>