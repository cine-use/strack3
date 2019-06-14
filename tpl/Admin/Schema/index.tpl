<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Structure_Title}</title></block>

<block name="head-js">
    <script type="text/javascript" src="__JS__/lib/jsplumbtoolkit.min.js"></script>
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_schema.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_schema.min.js"></script>
    </if>
    <if condition="$is_dev == '1' ">
        <link rel="stylesheet" href="__COM_CSS__/src/jsplumbtoolkit-defaults.css">
        <else/>
        <link rel="stylesheet" href="__COM_CSS__/build/jsplumbtoolkit-defaults.min.css">
    </if>
    <if condition="$is_dev == '1' ">
        <link rel="stylesheet" href="__COM_CSS__/src/flowcharts.css">
        <else/>
        <link rel="stylesheet" href="__COM_CSS__/build/flowcharts.min.css">
    </if>
    <!-- jsplumb module template -->
    <script type="jtk" id="tmplModule">
            <div style="left:${left}px;top:${top}px;width:${w}px;height:${h}px;" class="flowchart-object flowchart-action">
                <div style="position:relative">
                    <div class="node-delete node-action">
                        <i class="icon-uniE765"/>
                    </div>
                    <svg:svg width="${w}" height="${h}">
                        <svg:rect x="0" y="0" width="${w}" height="${h}" class="outer drag-start"/>
                        <svg:rect x="10" y="10" width="${w-20}" height="${h-20}" class="inner"/>
                        <svg:text text-anchor="middle" x="${w/2}" y="${h/2}" dominant-baseline="central">${text}</svg:text>
                    </svg:svg>
                </div>
                <jtk-target port-type="target"/>
                <jtk-source port-type="source" filter=".outer"/>
            </div>
    </script>
</block>
<block name="head-css">
    <script type="text/javascript">
        var SchemaPHP = {
            'addSchema' : '{:U("Admin/Schema/addSchema")}',
            'modifySchema' : '{:U("Admin/Schema/modifySchema")}',
            'deleteSchema' : '{:U("Admin/Schema/deleteSchema")}',
            'getSchemaList' : '{:U("Admin/Schema/getSchemaList")}',
            'getSchemaModuleList' : '{:U("Admin/Schema/getSchemaModuleList")}',
            'saveModuleRelation' : '{:U("Admin/Schema/saveModuleRelation")}',
            'getSchemaConnectType': '{:U("Admin/Schema/getSchemaConnectType")}',
            'getSchemaTypeCombobox': '{:U("Admin/Schema/getSchemaTypeCombobox")}',
            'getSchemaCombobox': '{:U("Admin/Schema/getSchemaCombobox")}'
        };
        Strack.G.MenuName = "schema";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Schema}
</block>

<block name="admin-main">
    <div id="active-nation" class="admin-content-dept">
        <div class="admin-temp-left">
            <div class="dept-col-wrap">
                <div class="dept-form-wrap proj-tb">
                    <h3 class="aign-left">{$Think.lang.Schema_List}</h3>
                    <div class="st-buttons-sig aign-left" style="padding: 7px 6px 0;">
                        <a href="javascript:;" onclick="obj.schema_add(this);">
                            <i class="icon plus"></i>
                        </a>
                    </div>
                    <div class="ad-left-search">
                        <div class="ui search aign-right">
                            <div class="ui icon input">
                                <a href='javascript:;' class="st-down-filter stdown-filter" >
                                    <i class="filter icon project_filter"></i>
                                </a>
                                <input id="search_val" class="prompt" placeholder="{$Think.lang.Search_More}" type="text" autocomplete="off">
                                <a href="javascript:;" id="search_schema_bnt" class="st-filter-action" onclick="obj.schema_filter(this);">
                                    <i class="search icon"></i>
                                </a>
                            </div>
                            <div class="results"></div>
                        </div>
                    </div>
                </div>
                <div id="project_wrap" class="admin-temp-list">
                    <ul id="schema_list">
                    </ul>
                </div>
            </div>
        </div>
        <div class="admin-temp-right">

            <div class="temp-setlist-no">
                <p>{$Think.lang.Please_Select_Schema}</p>
            </div>

            <input id="hide_schema_id" type="hidden" value="" autocomplete="off">
            <input id="hide_schema_name" type="hidden" value="" autocomplete="off">
            <input id="hide_schema_code" type="hidden" value="" autocomplete="off">

            <div class="structure-m-list aign-left" style="display: none">
                <div class="structure-m-toolbar proj-tb">
                    <div class="structure-m-title aign-left">
                        {$Think.lang.Module_List}
                    </div>
                    <div class="aign-right">
                        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.schema_delete();">
                            {$Think.lang.Delete}
                        </a>
                        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.schema_modify();">
                            {$Think.lang.Modify_Name}
                        </a>
                    </div>
                </div>
                <div id="module_wrap" class="admin-temp-list">
                    <ul id="module_list">
                    </ul>
                </div>
            </div>
            <div class="structure-m-wrap aign-left" style="display: none">
                <div id="tb" class="admin-temp-tb">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="obj.schema_save();">
                        {$Think.lang.Save}
                    </a>
                </div>
                <div id="schema_graph" class="admin-temp-list">

                </div>
            </div>
        </div>
</block>