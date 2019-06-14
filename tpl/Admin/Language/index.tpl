<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Language_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_language.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_language.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var LanguagePHP = {
      'getLangList' : '{:U("Home/Widget/getLangList")}',
      'getLanguageModuleData' : '{:U("Admin/Language/getLanguageModuleData")}',
      'generateLanguagePackage': '{:U("Admin/Language/generateLanguagePackage")}'
    };
    Strack.G.MenuName = "language";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Language}
</block>

<block name="admin-main">
  <div id="active-language" class="admin-page-right">
    <div id="tb" style="padding:5px;">
      <div class="st-tools-left">
        <if condition="$view_rules.build_language_package == 'yes' ">
          <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-uniE690" plain="true" onclick="obj.build_lang_package();">
            {$Think.lang.Build_Language_Package}
          </a>
        </if>
      </div>
    </div>
    <table id="datagrid_box"></table>
  </div>
</block>