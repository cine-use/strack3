<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Module_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_module.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_module.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var ModulePHP = {
            'getModuleTypeList': '{:U("Admin/Module/getModuleTypeList")}',
            'getModuleData': '{:U("Admin/Module/getModuleData")}',
            'getFixedModuleList': '{:U("Admin/Module/getFixedModuleList")}',
            'addModule': '{:U("Admin/Module/addModule")}',
            'modifyModule': '{:U("Admin/Module/modifyModule")}',
            'deleteModule': '{:U("Admin/Module/deleteModule")}'
        };
        Strack.G.MenuName = "module";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Module}
</block>

<block name="admin-main">
    <div id="active-module" class="admin-content-dept">
        <div class="admin-dept-left">
            <div class="dept-col-wrap">
                <div class="dept-form-wrap">
                    <h3>{$Think.lang.Add_Module}</h3>
                    <form id="add_module">
                        <div class="form-field-2 form-required required term-name-wrap">
                            <label for="type">{$Think.lang.Type}</label>
                            <input id="type" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="type" wiget-name="{$Think.lang.Type}">
                        </div>
                        <div id="fixed_module" style="display: none">
                            <div class="form-field-2 form-required required term-name-wrap">
                                <label for="type">{$Think.lang.Fixed_Module}</label>
                                <input id="fixmodule_list" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="no" wiget-field="fixmodule" wiget-name="{$Think.lang.Fixmodule}">
                            </div>
                        </div>
                        <div class="form-field-2 form-required required term-name-wrap">
                            <label for="module_icon">{$Think.lang.Icon}</label>
                            <input id="module_icon" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="icon" wiget-name="{$Think.lang.Icon}">
                        </div>
                        <div class="form-field form-required required term-name-wrap">
                            <label for="module-name">{$Think.lang.Name}</label>
                            <input id="module_name" class="form-input form-control" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" autocomplete="off" type="text" placeholder="{$Think.lang.Input_Module_Name}">
                        </div>
                        <div class="form-field form-required required term-name-wrap">
                            <label for="module-code">{$Think.lang.Code}</label>
                            <input id="module_code" class="form-input form-control" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" autocomplete="off" type="text" placeholder="{$Think.lang.Input_Module_Code}">
                        </div>
                        <div class="form-field form-required required term-name-wrap">
                            <label for="module-number">{$Think.lang.Number}</label>
                            <input id="module_number" class="form-input form-control" wiget-type="input" wiget-need="yes" wiget-field="number" wiget-name="{$Think.lang.Number}" autocomplete="off" type="text" placeholder="{$Think.lang.Input_Module_Number}">
                        </div>
                        <div class="form-submit">
                            <a href="javascript:;" onclick="obj.module_add();">
                                <div class="form-button-long form-button-hover">
                                    {$Think.lang.Submit}
                                </div>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="admin-dept-right">
            <div id="tb" style="padding:5px;">
                <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.module_modify();">
                    {$Think.lang.Modify}
                </a>
                <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.module_delete();">
                    {$Think.lang.Delete}
                </a>
            </div>
            <table id="datagrid_box"></table>
        </div>
    </div>
</block>