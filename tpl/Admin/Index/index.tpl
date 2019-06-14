<extend name="tpl/Base/common.tpl" />

<block name="head-title"><title>{$Think.lang.Admin_login_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_login.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_login.min.js"></script>
    </if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var ADLoginPHP = {
            'LoginAdmin': '{:U("Admin/Index/loginAdmin")}',
            'Input_Login_Password' : '{$Think.lang.Input_Login_Password}',
            'Login_Password_Error' : '{$Think.lang.Login_Password_Error}'
		};
        Strack.G.MenuName = "admin_login";
	</script>
</block>

<block name="main">
    <div class="ad-login-wrap">
        <div class="admin-login-bg">
            <div class="admin-login-main">
                <div class="ad-login-input">
                    <div class="aign-left">
                        <input id="admin_pass" type="password" autocomplete="off" placeholder="{$Think.lang.Login_Verify_Password}">
                    </div>
                    <div class="aign-left" style="margin-left: 30px">
                        <a href="javascript:;" class="ad-login-bnt" onclick="obj.admin_login()">
                            {$Think.lang.Login_Button}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>