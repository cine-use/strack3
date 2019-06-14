<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Page_Schema_Use_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_page_schema_use.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_page_schema_use.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var PageSchemaUsePHP = {
      'addPageSchemaUse' : '{:U("Admin/PageSchemaUse/addPageSchemaUse")}',
      'modifyPageSchemaUse' : '{:U("Admin/PageSchemaUse/modifyPageSchemaUse")}',
      'deletePageSchemaUse' : '{:U("Admin/PageSchemaUse/deletePageSchemaUse")}',
      'getPageSchemaUseGridData' : '{:U("Admin/PageSchemaUse/getPageSchemaUseGridData")}',
      'getSchemaCombobox' : '{:U("Admin/Schema/getSchemaCombobox")}'
    };
    Strack.G.MenuName="page_schema_use";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Page_Schema_Use}
</block>

<block name="admin-main">
  <div id="active-page_schema_use" class="admin-content-dept">
    <div class="admin-dept-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Add_Page_Schema_Use}</h3>
          <form id="add_page_schema_use" >
            <div class="form-field form-required required term-name-wrap">
              <label for="page">{$Think.lang.Page_Name}</label>
              <input  id="page" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="page" wiget-name="{$Think.lang.Page_Name}" placeholder="{$Think.lang.Input_Page_Name}">
            </div>
            <div class="form-field form-required required term-name-wrap">
              <label for="schema_list">{$Think.lang.Schema_List}</label>
              <input  id="schema_list" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="schema_id" wiget-name="{$Think.lang.Schema}">
            </div>
            <div class="form-submit">
              <a href="javascript:;" onclick="obj.page_schema_use_add();" >
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
      <table id="datagrid_box"></table>
      <div id="tb" style="padding:5px;">
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.page_schema_use_modify();">
          {$Think.lang.Modify}
        </a>
        <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.page_schema_use_delete();">
          {$Think.lang.Delete}
        </a>
      </div>
    </div>
  </div>
</block>