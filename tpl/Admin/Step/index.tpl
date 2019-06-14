<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Step_Title}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__COLPICK__/colpick.min.js"></script>
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_steps.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_steps.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var StepsPHP = {
      'addStep' : '{:U("Admin/Step/addStep")}',
      'modifyStep' : '{:U("Admin/Step/modifyStep")}',
      'deleteStep' : '{:U("Admin/Step/deleteStep")}',
      'getStepGridData' : '{:U("Admin/Step/getStepGridData")}'
    };
    Strack.G.MenuName="steps";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Step}
</block>

<block name="admin-main">
  <div id="active-steps" class="admin-content-dept">

    <div id="page_hidden_param">
      <input name="page" type="hidden" value="{$page}">
      <input name="module_id" type="hidden" value="{$module_id}">
      <input name="module_code" type="hidden" value="{$module_code}">
      <input name="module_name" type="hidden" value="{$module_name}">
    </div>

    <div class="admin-dept-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Add_Step}</h3>
          <form id="add_step" >
            <div class="form-field form-required required term-name-wrap">
              <label for="step_name">{$Think.lang.Name}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="step_name" class="form-control form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Step_Name}">
                <else/>
                <input id="step_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Step_Name}">
              </if>
            </div>
            <div class="form-field form-required required term-name-wrap">
              <label for="step_code">{$Think.lang.Code}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="step_code" class="form-control form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Step_code}">
                <else/>
                <input id="step_code" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Step_code}">
              </if>
            </div>
            <div class="form-field-2 form-required required term-name-wrap">
              <label for="step_color">{$Think.lang.Color}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="step_color" class="form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="color" wiget-name="{$Think.lang.Color}">
                <else/>
                <input id="step_color" class="form-control form-input input-disabled" disabled="disabled">
              </if>
            </div>
            <div class="form-submit">
              <if condition="$view_rules.submit == 'yes' ">
                <a href="javascript:;" onclick="obj.step_add();" >
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
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.step_modify();">
            {$Think.lang.Modify}
          </a>
        </if>
        <if condition="$view_rules.delete == 'yes' ">
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.step_delete();">
            {$Think.lang.Delete}
          </a>
        </if>
      </div>
    </div>
  </div>
</block>