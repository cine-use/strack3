<extend name="tpl/Base/common_login.tpl"/>

<block name="head-title"><title>{$Think.lang.Register_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/login/login_register.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/login/login_register.min.js"></script>
    </if>
</block>
<block name="head-css">
    <if condition="$is_dev == '1' ">
        <link rel="stylesheet" href="__CSS__/src/login.css">
        <else/>
        <link rel="stylesheet" href="__CSS__/build/login.min.css">
    </if>
    <script type="text/javascript">
        var LoginPHP = {
            'LoginPage': '{:U("/Login")}',
            'verifyCodeUrl': '{:U("/Login/verifyCode")}',
            'sendSMS': '{:U("Home/Login/sendSMS")}',
            'registerUser': '{:U("Home/Login/registerUser")}',
        };
    </script>
</block>

<block name="main">
    <div id="login-main" class="login-main">
        <div id="login-container" class="login-container">
            <div id="login-forgot-dom">
                <div class="login-container-title">
                    <switch name="show_theme">
                        <case value="oem"><img src="__PUBLIC__/images/strack_logo_oem.png"></case>
                        <default /><img src="__PUBLIC__/images/strack_logo_2.0.png">
                    </switch>
                </div>
                <div class="login-flash-content">{$Think.lang.Register_User_From_Phone}</div>
                <div class="login-flash-error"></div>
                <div class="login-content">
                    <input id="register_batch" type="hidden" value="">
                    <input id="register_sms_id" type="hidden" value="">
                    <form id="register_form" method="post" autocomplete="off">
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE997"></i>
                            </div>
                            <div class="login-input-text">
                                <input id="input_login_name" class="login-username" name="login_name" placeholder="{$Think.lang.Login_Name}" type="text" data-notice="{$Think.lang.Input_Login_Login_Name_Require}" >
                            </div>
                        </div>
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniF10A"></i>
                            </div>
                            <div class="login-input-text">
                                <input id="input_cell_phone" class="login-password" name="phone" placeholder="{$Think.lang.Cell_Phone}" type="text" data-notice="{$Think.lang.Input_Login_Cell_Phone_Require}" >
                            </div>
                        </div>
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE9DD"></i>
                            </div>
                            <div class="login-input-short">
                                <input id="input_system_verify_code" class="login-password" name="system_verify_code" placeholder="{$Think.lang.Verify_Code}" type="text" data-notice="{$Think.lang.Input_Login_Verify_Code_Require}" >
                            </div>
                            <div class="login-verify-code">
                                <img id="change_verify_code" src="{:U("/Login/verifyCode")}">
                            </div>
                        </div>
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE6C3"></i>
                            </div>
                            <div class="login-input-short">
                                <input class="login-password" name="sms_verify_code" placeholder="{$Think.lang.SMS_Verify_Code}" type="text" data-notice="{$Think.lang.Input_Login_SMS_Verify_Code_Require}" >
                            </div>
                            <div class="login-verify-sms">
                                <div id="resend_sms_notice" class="resend-sms">
                                    <span id="resend_timer" class="timer">60S</span>{$Think.lang.Resend_SMS_Notice}
                                </div>
                                <a id="send_sms_bnt" href="javascript:;" onclick="obj.send_sms(this)">{$Think.lang.Send_SMS}</a>
                            </div>
                        </div>
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE9B7"></i>
                            </div>
                            <div class="login-input-text">
                                <input class="login-password" name="password" placeholder="{$Think.lang.Password}" type="password" data-notice="{$Think.lang.Input_Login_Password_Require}" >
                            </div>
                        </div>
                        <div class="login-register-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE685"></i>
                            </div>
                            <div class="login-input-text">
                                <input class="login-username" name="email" placeholder="{$Think.lang.Email}" type="text" data-notice="{$Think.lang.Input_Login_Email_Require}" >
                            </div>
                        </div>
                        <div class="login-submit-field">
                            <a href="javascript:;" class="submit-btn" onclick="obj.register_submit(this)">{$Think.lang.Register_Button}</a>
                        </div>
                    </form>
                    <div class="login-bottom" style="text-align: center">
                        <a href="{:U("/Login")}" class="forgot-button">{$Think.lang.Login_Forget_Back}</a>
                    </div>
                </div>
            </div>
        </div>
</block>