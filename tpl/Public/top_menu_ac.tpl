<eq name="account_top_menu.personal_account" value="yes">
  <div class="item">
    <a href="{:U('/account')}">{$Think.lang.My_Account_Config}</a>
  </div>
</eq>
<div class="item">
  <a href="{:U('/help')}" >{$Think.lang.Help_Site}</a>
</div>
<if condition="$account_top_menu.admin_manage == 'yes' AND $default_mode.visit_system_admin == 'yes'">
<div class="divider"></div>
  <div class="item">
    <a href="{:U('/admin/index')}" >{$Think.lang.System_Setting}</a>
  </div>
</if>
<div class="divider"></div>
<div class="item">
  <a href="{:U('/Login/logout')}" >{$Think.lang.Logout}</a>
</div>