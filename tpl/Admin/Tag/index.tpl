<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Tag_Title}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__COLPICK__/colpick.min.js"></script>
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_tags.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_tags.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var TagsPHP = {
      'addTag' : '{:U("Admin/Tag/addTag")}',
      'modifyTag' : '{:U("Admin/Tag/modifyTag")}',
      'deleteTag': '{:U("Admin/Tag/deleteTag")}',
      'getTagGridData' : '{:U("Admin/Tag/getTagGridData")}'
    };
    Strack.G.MenuName="tags";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Tag}
</block>

<block name="admin-main">
  <div id="active-tags" class="admin-content-dept">

    <div id="page_hidden_param">
      <input name="page" type="hidden" value="{$page}">
      <input name="module_id" type="hidden" value="{$module_id}">
      <input name="module_code" type="hidden" value="{$module_code}">
      <input name="module_name" type="hidden" value="{$module_name}">
    </div>

    <div class="admin-dept-left">
      <div class="dept-col-wrap">
        <div class="dept-form-wrap">
          <h3>{$Think.lang.Add_Tag}</h3>
          <form id="add_tags" >
            <div class="form-field form-required required term-name-wrap">
              <label for="tags_name">{$Think.lang.Name}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="tags_name" class="form-control form-input" autocomplete="off" type="text" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Tag_Name}" data-inputmask="'alias': '*{1,40}'">
                <else/>
                <input id="tags_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Tag_Name}">
              </if>
            </div>
            <div class="form-field-2 form-required required term-name-wrap">
              <label for="tags_color">{$Think.lang.Color}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="tags_color" name="tags-color" class="form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="color" wiget-name="{$Think.lang.Color}">
                <else/>
                <input id="tags_color" class="form-control form-input input-disabled" disabled="disabled">
              </if>
            </div>
            <!--<div class="form-field-2 form-required term-name-wrap">
              <label for="tags_type">{$Think.lang.Type}</label>
              <if condition="$view_rules.submit == 'yes' ">
                <input id="tags_type" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="no" wiget-field="type" wiget-name="{$Think.lang.Type}">
                <else/>
                <input id="tags_type" class="form-input" data-options="disabled:true">
              </if>
            </div>-->
            <div class="form-submit">
              <if condition="$view_rules.submit == 'yes' ">
                <a href="javascript:;" onclick="obj.tags_add();" >
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
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.tags_modify();">
            {$Think.lang.Modify}
          </a>
        </if>
        <if condition="$view_rules.delete == 'yes' ">
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.tags_delete();">
            {$Think.lang.Delete}
          </a>
        </if>
      </div>
    </div>
  </div>
</block>