<extend name="tpl/Base/common_account.tpl" />

<block name="head-title"><title>{$Think.lang.Security_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/home/my_security.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/home/my_security.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var AccountPHP = {
        'getUserSecurity': '{:U('Home/User/getUserSecurity')}',
        'saveUserSecurity': '{:U('Home/User/saveUserSecurity')}'
    };
    Strack.G.AccMenu="security";
    Strack.G.MenuName="my_account";
  </script>
</block>
<block name="account-main">

  <div id="page_hidden_param">
    <input name="page" type="hidden" value="{$page}">
    <input name="rule_save" type="hidden" value="{$view_rules.edit}">
  </div>

  <div id="account-pre-main">
    <div class="account-my-bottom">
      <form id="account-security">
        <div class="account-my-base account-my-bline">
          <div class="account-my-title">
            <div class="account-my-iname">
              <i class="icon-uniE9BD icon-left"></i>
              {$Think.lang.My_Account_Security}
            </div>
          </div>
        </div>
        <div class="account-my-base">
          <div class="account-my-qrcode">
            <div id="qrcode_url" class="img-item-left aign-left">

            </div>
            <div class="img-item-right aign-left">
              <img src="__IMG__/mfa_xiaochengxu.jpg">
            </div>
          </div>
        </div>
        <div class="account-my-base">
          <!---account my infor base-->
          <div class="account-my-item">
            <div class="account-my-iname">
              {$Think.lang.Notice}
            </div>
            <div class="account-my-input">
              {$Think.lang.Mfa_Security_Notice1}
            </div>
          </div>
          <div class="account-my-item">
            <div class="account-my-iname">
            </div>
            <div class="account-my-input">
              {$Think.lang.Mfa_Security_Notice2}
            </div>
          </div>
          <div class="account-my-item">
            <div class="account-my-iname">
            </div>
            <div class="account-my-input">
              <strong style="color: #f5222d">
                {$Think.lang.Mfa_Security_Notice3}
              </strong>
            </div>
          </div>
          <div class="account-my-item">
            <div class="account-my-iname">
              {$Think.lang.Admin_2fa}
            </div>
            <div class="account-my-input">
              <input  id="open_mfa" class="form-control" type="text" name="mfa">
            </div>
          </div>
        </div>
        <if condition="$view_rules.edit == 'yes' ">
          <div class="account-my-savebnt">
            <a href="javascript:;" class="st-dialog-button button-dgsub ah_userinfo_pref" onclick="obj.security_save();">{$Think.lang.Save}</a>
          </div>
        </if>
      </form>
    </div>
  </div>
</block>