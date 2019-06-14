<extend name="tpl/Base/common_login.tpl"/>

<block name="head-title"><title>{$Think.lang.Forget_Request_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/login/login_forget.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/login/login_forget.min.js"></script>
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
            'getForgetLoginRequest': '{:U("Home/Login/getForgetLoginRequest")}'
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
                <div class="login-flash-content">{$Think.lang.Login_Forgot}</div>
                <div class="login-flash-error"></div>
                <div class="login-content">
                    <div class="login-forgot-notice">{$Think.lang.Login_Forget_Notice}</div>
                    <form id="forgot_form" method="post" autocomplete="off">
                        <div class="login-forgot-field">
                            <input name="email" placeholder="{$Think.lang.Login_Forget_Input}" type="text" data-notice="{$Think.lang.Input_Login_Email_Require}">
                        </div>
                        <div class="login-submit-field">
                            <a href="javascript:;" class="submit-btn" onclick="obj.login_forget_request(this)">{$Think.lang.Login_Forget_Request}</a>
                        </div>
                    </form>
                    <div class="login-bottom" style="text-align: center">
                        <a href="{:U("/Login")}" class="forgot-button">{$Think.lang.Login_Forget_Back}</a>
                    </div>
                </div>
            </div>
        </div>
</block>