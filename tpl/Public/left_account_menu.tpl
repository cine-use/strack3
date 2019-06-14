<div class="account-ifo-header hbox">
  <div class="account_img">
    <div id="acinfo_avatar" class="my_avatar">
      <!--accunt avatar-->
    </div>
  </div>
  <div class="account_title">
    <div id="acinfo_name" class="account_title_name">
      <!--accunt username-->
    </div>
    <div class="account_title_hover">
      {$Think.lang.My_Account_Title}
    </div>
  </div>
</div>
<div id="acinfo_menu" class="account-info-menu">
  <ul>
    <li id="account-my" class="account-menu-items">
      <a href="{:U('/account')}" >
        {$Think.lang.My_Account}
      </a>
    </li>
    <li id="account-preferences" class="account-menu-items">
      <a href="{:U('/account/preferences')}" >
        {$Think.lang.My_Account_Preference}
      </a>
    </li>
    <gt name="user_id" value="1">
      <li id="account-security" class="account-menu-items">
        <a href="{:U('/account/security')}" >
          {$Think.lang.My_Account_Security}
        </a>
      </li>
    </gt>
  </ul>
</div>