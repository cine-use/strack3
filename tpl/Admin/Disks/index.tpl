<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Disks_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_disks.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_disks.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var DisksPHP = {
            'addDisks': '{:U("Admin/Disks/addDisks")}',
            'modifyDisks': '{:U("Admin/Disks/modifyDisks")}',
            'deleteDisks': '{:U("Admin/Disks/deleteDisks")}',
            'getDisksGridData': '{:U("Admin/Disks/getDisksGridData")}'
        };
        Strack.G.MenuName = "disks";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Disks}
</block>

<block name="admin-main">
    <div id="active-disks" class="admin-content-dept">

        <div id="page_hidden_param">
            <input name="page" type="hidden" value="{$page}">
            <input name="module_id" type="hidden" value="{$module_id}">
            <input name="module_code" type="hidden" value="{$module_code}">
            <input name="module_name" type="hidden" value="{$module_name}">
        </div>

        <div class="admin-dept-left">
            <div class="dept-col-wrap">
                <div class="dept-form-wrap">
                    <h3>{$Think.lang.Add_Disks_Title}</h3>
                    <form id="add_disks" >
                        <div class="form-field form-required required term-name-wrap">
                            <label for="disks_name">{$Think.lang.Name}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="disks_name" class="form-control form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Disks_Name}">
                                <else/>
                                <input id="disks_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Disks_Name}">
                            </if>
                        </div>

                        <div class="form-field form-required required term-name-wrap">
                            <label for="disks_name">{$Think.lang.Code}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="disks_code" class="form-control form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Disks_Code}">
                                <else/>
                                <input id="disks_code" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Disks_Code}">
                            </if>
                        </div>

                        <div class="form-required required term-name-wrap">
                            <label for="disks_config">{$Think.lang.Config}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <div id="json_editor" class="form-input" type="text" wiget-type="json" wiget-need="yes" wiget-field="config" wiget-name="{$Think.lang.Config}"></div>
                            </if>
                        </div>

                        <div class="form-button-full">
                            <if condition="$view_rules.submit == 'yes' ">
                                <a href="javascript:;" onclick="obj.disks_add();">
                                    <div class="form-button-long form-button-hover">
                                        {$Think.lang.Submit}
                                    </div>
                                </a>
                            </if>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="admin-dept-right">
            <table id="datagrid_box"></table>
            <div id="tb" style="padding:5px;">
                <if condition="$view_rules.modify == 'yes' ">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.disks_modify();">
                        {$Think.lang.Modify}
                    </a>
                </if>
                <if condition="$view_rules.delete == 'yes' ">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.disks_delete();">
                        {$Think.lang.Delete}
                    </a>
                </if>
            </div>
        </div>
    </div>
</block>