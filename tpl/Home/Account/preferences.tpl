<extend name="tpl/Base/common_account.tpl" />

<block name="head-title"><title>{$Think.lang.Preferences_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/home/my_preference.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/home/my_preference.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var AccountPHP = {
        'getUserPreference': '{:U('Home/User/getUserPreference')}',
        'saveUserPreference': '{:U('Home/User/saveUserPreference')}',
        'getLangList': '{:U("Home/Widget/getLangList")}',
        'getTimezoneList': '{:U("Home/Widget/getTimezoneList")}'
    };
    Strack.G.AccMenu="preferences";
    Strack.G.MenuName="my_account";
  </script>
</block>
<block name="account-main">

  <div id="page_hidden_param">
    <input name="page" type="hidden" value="{$page}">
    <input name="module_id" type="hidden" value="{$module_id}">
    <input name="rule_save" type="hidden" value="{$view_rules.edit}">
  </div>

  <div id="account-pre-main">
    <div class="account-my-bottom">
      <form id="account-pref">
        <div class="account-my-base account-my-bline">
          <div class="account-my-title">
            <div class="account-my-iname">
              <i class="icon-uniE9BD icon-left"></i>
              {$Think.lang.My_Account_Preference}
            </div>
          </div>
        </div>
        <div class="account-my-base">
          <!---account my infor base-->
          <div class="account-my-item">
            <div class="account-my-iname">
              {$Think.lang.Language}
            </div>
            <div class="account-my-input">
              <input id="my_language" class="form-control" type="text" name="my_language">
            </div>
          </div>
          <div class="account-my-item">
            <div class="account-my-iname">
              {$Think.lang.Timezone}
            </div>
            <div class="account-my-input">
              <input  id="my_timezone" class="form-control" type="text" name="my_timezone">
            </div>
          </div>
        </div>
        <if condition="$view_rules.edit == 'yes' ">
          <div class="account-my-savebnt">
            <a href="javascript:;" class="st-dialog-button button-dgsub ah_userinfo_pref" onclick="obj.preference_save();">{$Think.lang.Save}</a>
          </div>
        </if>
      </form>
    </div>
  </div>
</block>