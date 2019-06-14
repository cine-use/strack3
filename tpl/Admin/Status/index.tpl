<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Status_Title}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__COLPICK__/colpick.min.js"></script>
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_status.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_status.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var StatusPHP = {
      'addStatus' : '{:U("Admin/Status/addStatus")}',
      'modifyStatus' : '{:U("Admin/Status/modifyStatus")}',
      'deleteStatus' : '{:U("Admin/Status/deleteStatus")}',
      'getStatusGridData' : '{:U("Admin/Status/getStatusGridData")}',
      'getGroupCombobox' : '{:U("Admin/Group/getGroupCombobox")}'
    };
    Strack.G.MenuName="status";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Status}
</block>

<block name="admin-main">
  <div id="active-status" class="admin-content-dept">

    <div id="page_hidden_param">
      <input name="page" type="hidden" value="{$page}">
      <input name="module_id" type="hidden" value="{$module_id}">
      <input name="module_code" type="hidden" value="{$module_code}">
      <input name="module_name" type="hidden" value="{$module_name}">
    </div>

    <div class="admin-dept-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Add_Status}</h3>
          <form id="add_status" >
            <div class="form-field form-required required term-name-wrap">
              <label for="name">{$Think.lang.Name}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="status_name" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Status_Name}">
                <else/>
                <input id="status_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Status_Name}">
              </if>
            </div>
            <div class="form-field form-required required term-name-wrap">
              <label for="code">{$Think.lang.Code}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="status_code" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Status_Code}">
                <else/>
                <input id="status_code" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Status_Code}">
              </if>
            </div>
            <div class="form-field-2 form-required required term-name-wrap">
              <label for="status_color">{$Think.lang.Color}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="status_color" name="status-color" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="color" wiget-name="{$Think.lang.Color}">
                <else/>
                <input id="status_color" class="form-control form-input input-disabled" disabled="disabled">
              </if>
            </div>
            <div class="form-field form-required required term-name-wrap">
              <label for="status_icon">{$Think.lang.Icon}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="status_icon" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="icon" wiget-name="{$Think.lang.Icon}">
                <else/>
                <input id="status_icon" class="form-input" data-options="disabled:true">
              </if>
            </div>
            <div class="form-field form-required required term-name-wrap">
              <label for="status_corresponds">{$Think.lang.Corresponds}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="status_corresponds" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="correspond" wiget-name="{$Think.lang.Corresponds}">
                <else/>
                <input id="status_corresponds" class="form-input" data-options="disabled:true">
              </if>
            </div>
            <div class="form-submit">
              <if condition="$view_rules.submit == 'yes' ">
                <a href="javascript:;" onclick="obj.status_add();" >
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
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.status_modify();">
            {$Think.lang.Modify}
          </a>
        </if>
        <if condition="$view_rules.delete == 'yes' ">
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.status_delete();">
            {$Think.lang.Delete}
          </a>
        </if>
      </div>
    </div>
  </div>
</block>