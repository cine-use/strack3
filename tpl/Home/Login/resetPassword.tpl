<extend name="tpl/Base/common_login.tpl" />

<block name="head-title"><title>{$Think.lang.Login_Forget_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/login/reset_password.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/login/reset_password.min.js"></script>
  </if>
</block>
<block name="head-css">
  <if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__CSS__/src/login.css">
    <else/>
    <link rel="stylesheet" href="__CSS__/build/login.min.css">
  </if>
  <script type="text/javascript">
      var resetpassPHP = {
          'modifyUserPassword':'{:U('Login/modifyUserPassword')}'
      };
  </script>
</block>
<block name="main">
  <input id="user_id" name="user_id" type="hidden" value="{$user_id}" />
  <input id="expiration_date" name="expiration_date" type="hidden" value="{$expiration_date}" />
  <div id="login-main" class="login-main">
    <if condition="$allow_reset == 'yes' ">
      <div class="login-container">
        <div id="login-main-dom">
          <div class="login-container-title">
            <switch name="show_theme">
              <case value="oem"><img src="__PUBLIC__/images/strack_logo_oem.png"></case>
              <default /><img src="__PUBLIC__/images/strack_logo_2.0.png">
            </switch>
          </div>
          <div class="login-flash-content">{$Think.lang.Login_Forget_Reset_Password}</div>
          <div class="login-flash-error"></div>
          <div class="login-content">
            <div class="login-forgot-notice">
              {$Think.lang.Login_Forget_Reset_Header}
              <span id="forgot_showtime" class="login-forgot-showtime"></span>
              {$Think.lang.Login_Forget_Reset_Tail}
            </div>
            <form id="reset_password_form" method="post" autocomplete="off">
              <div class="login-forgot-field container-field-top">
                <input name="new_password" placeholder="{$Think.lang.New_Password}" type="password" data-notice="{$Think.lang.Input_New_Password}"></div>
              <div class="login-forgot-field">
                <input name="confirm_password" placeholder="{$Think.lang.Confirm_Password}" type="password" data-notice="{$Think.lang.Confirm_New_Password}">
              </div>
              <div class="login-submit-field">
                <a href="javascript:;" class="submit-btn" onclick="obj.reset_password(this)">{$Think.lang.Modify}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <else/>
      <div class="login-error">
        <div class="login-error-title">{$Think.lang.Request_Error}</div>
        <div class="login-error-content">
          <div class="login-error-icon"><i class="icon-uniEA30"></i></div>
          <p>{$Think.lang.Login_Forget_Reset_Error1}</p>
          <p>{$Think.lang.Login_Forget_Reset_Error2}</p>
        </div>
      </div>
    </if>
  </div>
</block>