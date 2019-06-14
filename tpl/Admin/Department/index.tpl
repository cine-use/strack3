<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Department_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_department.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_department.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var DeptPHP = {
      'addDepartment' : '{:U("Admin/Department/addDepartment")}',
      'modifyDepartment': '{:U("Admin/Department/modifyDepartment")}',
      'deleteDepartment': '{:U("Admin/Department/deleteDepartment")}',
      'getDepartmentGridData' : '{:U("Admin/Department/getDepartmentGridData")}'
    };
    Strack.G.MenuName="dept";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Department}
</block>

<block name="admin-main">
  <div id="active-dept" class="admin-content-dept">
    
    <div id="page_hidden_param">
      <input name="page" type="hidden" value="{$page}">
      <input name="module_id" type="hidden" value="{$module_id}">
      <input name="module_code" type="hidden" value="{$module_code}">
      <input name="module_name" type="hidden" value="{$module_name}">
    </div>

    <div class="admin-dept-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Add_Department}</h3>
          <form id="add_dept" >
            <div class="form-field form-required term-name-wrap required">
              <label for="dept-name">{$Think.lang.Name}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="dept_name" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" autocomplete="off" type="text" placeholder="{$Think.lang.Input_Department_Name}">
                <else/>
                <input id="dept_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Department_Name}">
              </if>
            </div>
            <div class="form-field form-required term-name-wrap required">
              <label for="dept_code">{$Think.lang.Code}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="dept_code" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Name}" autocomplete="off" type="text" placeholder="{$Think.lang.Input_Department_Code}">
                <else/>
                <input id="dept_code" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Department_Code}">
              </if>
            </div>
            <div class="form-submit">
              <if condition="$view_rules.submit == 'yes' ">
                <a href="javascript:;" onclick="obj.dept_add();" >
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
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.dept_modify();">
            {$Think.lang.Modify}
          </a>
        </if>
        <if condition="$view_rules.delete == 'yes' ">
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.dept_delete();">
            {$Think.lang.Delete}
          </a>
        </if>
      </div>
    </div>
  </div>
</block>