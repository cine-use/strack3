<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Field_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_field.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_field.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var FieldPHP = {
            'getTableList': '{:U("Admin/Field/getTableList")}',
            'getFieldConfig': '{:U("Admin/Field/getFieldConfig")}',
            'modifyFieldConfig': '{:U("Admin/Field/modifyFieldConfig")}'
        };
        Strack.G.MenuName="field";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Field}
</block>

<block name="admin-main">
    <div id="active-field" class="admin-content-dept">
        <div class="admin-temp-left">
            <div class="dept-col-wrap">

                <div class="dept-form-wrap proj-tb">
                    <h3>{$Think.lang.Table_List}</h3>
                    <div class="ad-left-search">
                    </div>
                </div>

                <div class="admin-temp-list">
                    <div id="table_list" class="ui middle aligned divided list">
                    </div>
                </div>

            </div>
        </div>

        <div id="temp_list" class="admin-temp-right">
            <input id="current_table" name="current_table" type="hidden" autocomplete="off">
            <div class="temp-setlist-wrap">
                <table id="datagrid_box"></table>
                <div id="tb" style="padding:5px;">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="obj.table_save();">
                        {$Think.lang.Save}
                    </a>
                </div>
            </div>
        </div>
</block>