<extend name="tpl/Base/common_login.tpl"/>

<block name="head-title"><title>{$Think.lang.Login_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/login/login.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/login/login.min.js"></script>
    </if>
    <script type="text/javascript" src="__JS__/lib/ellipsis.min.js"></script>
</block>
<block name="head-css">
    <if condition="$is_dev == '1' ">
        <link rel="stylesheet" href="__CSS__/src/login.css">
        <else/>
        <link rel="stylesheet" href="__CSS__/build/login.min.css">
    </if>
    <script type="text/javascript">
        var LoginPHP = {
            'verifyLogin': '{:U("Home/Login/verifyLogin")}',
            'getThirdServerList': '{:U("Home/Login/getThirdServerList")}'
        };
    </script>
</block>

<block name="main">
    <div id="login-main" class="login-main">
        <div id="login-container" class="login-container">
            <div id="login-main-dom">
                <div class="login-container-title">
                    <switch name="show_theme">
                        <case value="oem"><img src="__PUBLIC__/images/strack_logo_oem.png"></case>
                        <default /><img src="__PUBLIC__/images/strack_logo_2.0.png">
                    </switch>
                </div>
                <div class="login-server-show">
                    <!--当前选择的登录服务器-->
                    <div class="login-server-title">{$Think.lang.Login_Server}</div>
                    <div class="login-server-name text-ellipsis"></div>
                    <a href="javascript:;" class="login-server-close" onclick="obj.close_login_server(this)">
                        <i class="icon-uniE6DB"></i>
                    </a>
                </div>
                <div class="login-error-show"></div>
                <div class="login-content">
                    <form id="login_form" method="post" autocomplete="off">
                        <div id="username" class="login-container-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE997"></i>
                            </div>
                            <div class="login-input-text">
                                <input class="login-username" name="login_name" placeholder="{$Think.lang.Login_Username}" type="text" data-notice="{$Think.lang.Input_Login_Login_Name_Require}" >
                            </div>
                        </div>
                        <div id="password" class="login-container-field">
                            <div class="login-input-icon">
                                <i class="icon-uniE9B7"></i>
                            </div>
                            <div class="login-input-text">
                                <input class="login-password" name="password" placeholder="{$Think.lang.Login_Password}" type="password" data-notice="{$Think.lang.Input_Login_Password_Require}">
                            </div>
                        </div>
                    </form>
                    <div class="login-submit-field">
                        <a href="javascript:;" class="submit-btn" onclick="obj.login_verify(this)">{$Think.lang.Login_Button}</a>
                    </div>
                    <if condition="$allow_register == 'yes' ">
                        <div class="login-submit-field">
                            <a href="{:U("Login/register")}" class="register-btn">{$Think.lang.Register_Button}</a>
                        </div>
                    </if>
                    <div class="login-bottom">
                        <div class="login-forgot">
                            <a href="{:U("Login/forget")}" class="forgot-button">{$Think.lang.Login_Forgot}</a>
                        </div>
                        <div id="third_party_open" class="login-ldap">
                            <a href="javascript:;" class="forgot-button" onclick="obj.login_with_ldap(this)">{$Think.lang.Third_Party_Login}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-third-party">
        <div class="third-party-main">
            <div class="third-party-header">
                <a href="javascript:;" class="third-party-back" onclick="obj.back_to_login(this)">
                    <i class="icon-uniE98D icon-left"></i>
                    {$Think.lang.Back}
                </a>
            </div>
            <div class="third-party-list">
                <!--第三方登录服务列表-->
            </div>
        </div>
    </div>
</block>