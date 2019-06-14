<extend name="tpl/Base/common_login.tpl"/>

<block name="head-title"><title>{$Think.lang.Admin_2fa_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/login/login_2fa.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/login/login_2fa.min.js"></script>
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
            'verify2faCode': '{:U("Home/Login/verify2faCode")}',
            'backToLoginPage': '{:U("Home/Login/backToLoginPage")}',
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
                <div class="login-flash-content">{$Think.lang.Admin_2fa_Code}</div>
                <div class="login-flash-error"></div>
                <div class="login-content">
                    <eq name="user_id" value="1">
                        <div class="login-forgot-notice">{$Think.lang.Login_Admin_2fa_Notice}</div>
                    </eq>
                    <form id="verify_form" method="post" autocomplete="off">
                        <div class="login-forgot-field">
                            <input name="login_2fa_code" placeholder="{$Think.lang.Admin_2fa_Code}" type="text" data-notice="{$Think.lang.Input_Admin_2fa_Code_Require}">
                        </div>
                        <div class="login-submit-field">
                            <a href="javascript:;" class="submit-btn" onclick="obj.submit_2fa_code(this)">{$Think.lang.Login_Forget_Request}</a>
                        </div>
                    </form>
                    <div class="login-bottom" style="text-align: center">
                        <a href="javascript:;" class="forgot-button" onclick="obj.back_login_page(this)">{$Think.lang.Login_Forget_Back}</a>
                    </div>
                </div>
            </div>
        </div>
</block>