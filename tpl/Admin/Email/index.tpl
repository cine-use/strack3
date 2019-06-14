<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Email_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_email.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_email.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var EmailPHP = {
            'getEmailSetting': '{:U("Admin/Email/getEmailSetting")}',
            'saveEmailSetting': '{:U("Admin/Email/saveEmailSetting")}',
            'testSendEmail': '{:U("Admin/Email/testSendEmail")}'
        };
        Strack.G.MenuName = "email";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Admin_Email}
</block>

<block name="admin-main">
    <div id="active-email" class="admin-content-wrap admin-content-dept">
        <div class="admin-dept-left">
            <div class="admin-ui-full">
                <form id="add_email" class="form-horizontal">
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Open}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_open" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="open_email" wiget-name="{$Think.lang.Mail_Open}">
                                    <else/>
                                    <input id="email_open" class="form-input" data-options="disabled:true">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Charset}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_charset" class="form-control form-input"  type="text" wiget-type="input" wiget-need="yes" wiget-field="charset" wiget-name="{$Think.lang.Mail_Charset}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_Charset}">
                                    <else/>
                                    <input id="email_charset" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_Charset}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Server}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_server" class="form-control form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="server" wiget-name="{$Think.lang.Mail_Server}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_Server}">
                                    <else/>
                                    <input id="email_server" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_Server}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Smtp_Auth}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_open_security" class="form-input"  wiget-type="switch" wiget-need="no" wiget-field="open_security" wiget-name="{$Think.lang.Mail_Smtp_Auth}">
                                    <else/>
                                    <input id="email_open_security" class="form-input" data-options="disabled:true">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Smtp_Secure}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_smtp_secure" class="form-input" autocomplete="off" wiget-type="combobox" wiget-need="yes" wiget-field="smtp_secure" wiget-name="{$Think.lang.Mail_Smtp_Secure}">
                                    <else/>
                                    <input id="email_smtp_secure" class="form-input" data-options="disabled:true">
                                </if>
                            </div>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Port}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_port" class="form-control form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="port" wiget-name="{$Think.lang.Mail_Port}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_Port}">
                                    <else/>
                                    <input id="email_port" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_Port}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_User}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_user" class="form-control form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="username" wiget-name="{$Think.lang.Mail_User}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_User}">
                                    <else/>
                                    <input id="email_user" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_User}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Pass}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_pass" class="form-control form-input" type="password" wiget-type="input" wiget-need="yes" wiget-field="password" wiget-name="{$Think.lang.Mail_Pass}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_Pass}">
                                    <else/>
                                    <input id="email_pass" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_User}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="stcol-lg-1 control-label">{$Think.lang.Mail_Header}</label>
                        <div class="stcol-lg-2">
                            <div class="bs-component">
                                <if condition="$view_rules.submit == 'yes' ">
                                    <input id="email_addresser_name" class="form-control form-input" type="text" wiget-type="input" wiget-need="yes" wiget-field="addresser_name" wiget-name="{$Think.lang.Mail_Header}" autocomplete="off" placeholder="{$Think.lang.Input_Mail_Header}">
                                    <else/>
                                    <input id="email_addresser_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Mail_Header}">
                                </if>
                            </div>
                        </div>
                    </div>
                    <div class="form-button-full">
                        <if condition="$view_rules.submit == 'yes' ">
                            <a href="javascript:;" onclick="obj.save_config();">
                                <div class="form-button-long form-button-hover">
                                    {$Think.lang.Submit}
                                </div>
                            </a>
                        </if>
                    </div>
                </form>
            </div>
        </div>
        <div class="admin-dept-right ad-email-test">
            <div class="st-textarea ad-email-textarea">
                <if condition="$view_rules.test_email_send == 'yes' ">
                    <textarea id="test_email" placeholder="{$Think.lang.Email_Test_Content}" autocomplete="off"></textarea>
                    <else/>
                    <textarea id="test_email" class="input-disabled" placeholder="{$Think.lang.Email_Test_Content}" disabled="disabled" autocomplete="off"></textarea>
                </if>
            </div>
            <div class="ad-email-input">
                <if condition="$view_rules.test_email_send == 'yes' ">
                    <input id="test_account" class="form-control"  placeholder="{$Think.lang.Email_Test_Account}" autocomplete="off">
                    <else/>
                    <input id="test_account" class="form-control input-disabled" disabled="disabled" placeholder="{$Think.lang.Email_Test_Account}">
                </if>
            </div>
            <div class="ad-email-button">
                <if condition="$view_rules.test_email_send == 'yes' ">
                    <a href="javascript:;" onclick="obj.send_test_email();">
                        <div class="form-button-long form-button-hover">
                            {$Think.lang.Send_Test_Email}
                        </div>
                    </a>
                </if>
            </div>
            <div class="ad-email-result">
                <div class="ade-result-show">
                    <div id="test_email_result" style="padding: 20px;word-wrap: break-word">

                    </div>
                </div>
            </div>
        </div>
    </div>
</block>