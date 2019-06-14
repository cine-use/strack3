<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Sign_Method_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_sign_method.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_sign_method.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var SignMethodPHP = {
            'getLdapServerSettingList' : '{:U("Admin/Ldap/getLdapServerSettingList")}',
            'saveLdapSetting' : '{:U("Admin/Ldap/saveLdapSetting")}'
        };
        Strack.G.MenuName = "signMethod";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Sign_Method}
</block>

<block name="admin-main">

    <div id="page_hidden_param">
        <input name="rule_switch" type="hidden" value="{$view_rules.switch}">
    </div>

    <div id="active-email" class="admin-content-wrap">
        <div class="ad-srd-wrap">
            <div class="ad-srd-title">
                {$Think.lang.Ldap_Setting}
            </div>
        </div>
        <div class="admin-ui-full">
            <div class="form-group">
                <label class="stcol-lg-1 control-label">{$Think.lang.Open_Ldap_Login}</label>
                <div class="stcol-lg-2">
                    <div class="bs-component">
                        <if condition="$view_rules.switch == 'yes' ">
                            <input id="open_ldap_login" autocomplete="off"/>
                            <else/>
                            <input id="open_ldap_login" class="form-input" data-options="disabled:true">
                        </if>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="stcol-lg-1 control-label">{$Think.lang.Allow_Use_Ldap_Server}</label>
                <div class="stcol-lg-2">
                    <div class="bs-component">
                        <div id="ldap_server_list" style="width: 600px;height: 280px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>