<extend name="tpl/Base/common_account.tpl" />

<block name="head-title"><title>{$Think.lang.My_Account_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/my_account.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/my_account.min.js"></script>
    </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var AccountPHP = {
        'getMyAccountData' : '{:U("Home/User/getMyAccountData")}',
        'modifyMyAccount'  : '{:U("Home/User/modifyMyAccount")}',
        'uploadUserAvatar': '{:U("Home/User/uploadUserAvatar")}'
    };
    Strack.G.AccMenu="my";
    Strack.G.MenuName="my_account";
  </script>
</block>
<block name="account-main">

    <div id="page_hidden_param">
        <input name="page" type="hidden" value="{$page}">
        <input name="module_id" type="hidden" value="{$module_id}">
        <input name="rule_save" type="hidden" value="{$view_rules.edit}">
        <input name="rule_modify_thumb" type="hidden" value="{$view_rules.upload_avatar}">
    </div>

      <div id="account-my-main" class="account-my-warp">
          <div class="account-my-top">
              <!---account thumb uopload-->
              <div class="account-my-topwrap account-my-hover">
                  <div id="ac_my_avatar" class="ac-my-avatar">
                      <!--account my infor avatar-->
                  </div class="account-my-avatar">
                  <if condition="$view_rules.upload_avatar == 'yes' ">
                      <a href="javascript:;" onclick="Strack.upload_avatar_dialog(this)" data-avatarid="ac_my_avatar" data-userid="{$user_id}" data-moduleid="{$module_id}">
                      <span class="ac-my-avatar-hover">
                          <p>{$Think.lang.Modify_Avatar}</p>
                      </span>
                      </a>
                  </if>
              </div>
          </div>
          <div class="account-my-bottom">
              <form id="modify_account">
                  <div class="account-my-base account-my-bline">
                      <!---account my infor base-->
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.User_Login}
                          </div>
                          <div class="account-my-input">
                              <input id="my_user_login" class="form-control input-disabled" type="text" disabled="disabled">
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.User_Name}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="my_user_name" class="form-control myacinput form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.User_Name}" autocomplete="off" placeholder="{$Think.lang.Input_User_Name}">
                                  <else/>
                                  <input id="my_user_name" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.Nickname}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="my_user_nick_name" class="form-control myacinput form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="nickname" wiget-name="{$Think.lang.Nickname}" autocomplete="off" placeholder="{$Think.lang.Input_User_Nickname}">
                                  <else/>
                                  <input id="my_user_nick_name" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.Email}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="my_user_email" class="form-control myacinput form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="email" wiget-name="{$Think.lang.Email}" autocomplete="off" placeholder="{$Think.lang.Input_User_Email}">
                                  <else/>
                                  <input id="my_user_email" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.Phone}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="my_user_phone" class="form-control myacinput form-input" type="text" wiget-type="input" wiget-need="no" wiget-field="phone" wiget-name="{$Think.lang.Phone}" autocomplete="off" placeholder="{$Think.lang.Input_User_Phone}">
                                  <else/>
                                  <input id="my_user_phone" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                  </div>
                  <!---account my infor password-->
                  <div class="account-my-pass account-my-bline">
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.Old_Password}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="old_password" class="form-control myacinput form-input" type="password" wiget-type="input" wiget-need="no" wiget-field="old_password" wiget-name="{$Think.lang.Old_Password}" autocomplete="off">
                                  <else/>
                                  <input id="old_password" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.New_Password}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="new_password" class="form-control myacinput form-input" type="password"  wiget-type="input" wiget-need="no" wiget-field="new_password" wiget-name="{$Think.lang.New_Password}" autocomplete="off">
                                  <else/>
                                  <input id="new_password" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                      <div class="account-my-item">
                          <div class="account-my-iname">
                              {$Think.lang.Confirm_Password}
                          </div>
                          <div class="account-my-input">
                              <if condition="$view_rules.edit == 'yes' ">
                                  <input id="new_password_repeat" class="form-control myacinput form-input" type="password" wiget-type="input" wiget-need="no" wiget-field="new_password_repeat" wiget-name="{$Think.lang.Confirm_Password}" autocomplete="off">
                                  <else/>
                                  <input id="new_password_repeat" class="form-control form-input input-disabled" type="text" disabled="disabled">
                              </if>
                          </div>
                      </div>
                  </div>
                  <if condition="$view_rules.edit == 'yes' ">
                      <div class="account-my-savebnt display-hide">
                          <a href="javascript:;" class="st-dialog-button button-dgsub ah_userac_modify" onclick="obj.modify_my_account();">{$Think.lang.Save}</a>
                          <span style="line-height: 30px">{$Think.lang.Need_Save}</span>
                      </div>
                  </if>
              </form>
          </div>
      </div>
</block>