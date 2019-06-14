<extend name="tpl/Base/common_admin.tpl"/>

<block name="head-title"><title>{$Think.lang.Ldap_Setting_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_ldap.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_ldap.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var LdapPHP = {
            'addLdap' : '{:U("Admin/Ldap/addLdap")}',
            'modifyLdap': '{:U("Admin/Ldap/modifyLdap")}',
            'deleteLdap': '{:U("Admin/Ldap/deleteLdap")}',
            'getLdapGridData' : '{:U("Admin/Ldap/getLdapGridData")}'
        };
        Strack.G.MenuName = "ldap";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Ldap_Setting}
</block>

<block name="admin-main">
    <div id="active-email" class="admin-content-wrap admin-content-dept">

        <div id="page_hidden_param">
            <input name="page" type="hidden" value="{$page}">
            <input name="module_id" type="hidden" value="{$module_id}">
            <input name="module_code" type="hidden" value="{$module_code}">
            <input name="module_name" type="hidden" value="{$module_name}">
        </div>

        <div class="admin-dept-left">
            <div class="dept-col-wrap">
                <div class="dept-form-wrap">
                    <h3>{$Think.lang.Ldap_Base_Setting}</h3>
                    <form id="add_ldap" >
                        <div class="form-field form-required term-name-wrap required">
                            <label for="ldap_name">{$Think.lang.Ldap_Name}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="ldap_name" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Ldap_Name}" placeholder="{$Think.lang.Input_Ldap_Name}">
                                <else/>
                                <input id="ldap_name" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Ldap_Name}">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap required">
                            <label for="domain_controllers">{$Think.lang.Ldap_Server_Address}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <textarea id="domain_controllers" class="form-control form-input" autocomplete="off" wiget-type="textarea" wiget-need="yes" wiget-field="domain_controllers" wiget-name="{$Think.lang.Ldap_Server_Address}" placeholder="{$Think.lang.Ldap_Server_Address_Notice}"></textarea>
                                <else/>
                                <textarea id="domain_controllers" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Ldap_Server_Address_Notice}"></textarea>
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap required">
                            <label for="base_dn">{$Think.lang.Ldap_Base_DN}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="base_dn" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="base_dn" wiget-name="{$Think.lang.Ldap_Base_DN}" placeholder="{$Think.lang.Input_Ldap_Base_DN}">
                                <else/>
                                <input id="base_dn" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Ldap_Base_DN}">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap required">
                            <label for="admin_username">{$Think.lang.Ldap_Admin_Name}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="admin_username" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="admin_username" wiget-name="{$Think.lang.Ldap_Admin_Name}" placeholder="{$Think.lang.Input_Ldap_Admin_Name}">
                                <else/>
                                <input id="admin_username" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Ldap_Admin_Name}">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap required">
                            <label for="admin_password">{$Think.lang.Ldap_Admin_Password}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="admin_password" class="form-control form-input" type="password" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="admin_password" wiget-name="{$Think.lang.Ldap_Admin_Password}" placeholder="{$Think.lang.Input_Ldap_Admin_Password}">
                                <else/>
                                <input id="admin_password" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Ldap_Admin_Password}">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap">
                            <label for="ldap_port">{$Think.lang.Ldap_Port}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="ldap_port" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="no" wiget-field="port" wiget-name="{$Think.lang.Ldap_Port}" placeholder="{$Think.lang.Input_Ldap_Port}">
                                <else/>
                                <input id="ldap_port" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Ldap_Port}">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap">
                            <label for="ldap_ssl">{$Think.lang.Ldap_Open_Ssl}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="ldap_ssl" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="ssl" wiget-name="{$Think.lang.Ldap_Open_Ssl}">
                                <else/>
                                <input id="ldap_ssl" class="form-input" data-options="disabled:true">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap">
                            <label for="ldap_tsl">{$Think.lang.Ldap_Open_Tls}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <input id="ldap_tsl" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="tsl" wiget-name="{$Think.lang.Ldap_Open_Tls}">
                                <else/>
                                <input id="ldap_tsl" class="form-input" data-options="disabled:true">
                            </if>
                        </div>
                        <div class="form-field form-required term-name-wrap">
                            <label for="dn_whitelist">{$Think.lang.Ldap_DN_Whitelist}</label>
                            <if condition="$view_rules.submit == 'yes' ">
                                <textarea id="dn_whitelist" class="form-control form-input" autocomplete="off" wiget-type="textarea" wiget-need="no" wiget-field="dn_whitelist" wiget-name="{$Think.lang.Ldap_DN_Whitelist}" placeholder="{$Think.lang.Ldap_DN_Whitelist_Notice}"></textarea>
                                <else/>
                                <textarea id="dn_whitelist" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Ldap_DN_Whitelist_Notice}"></textarea>
                            </if>
                        </div>

                        <div class="form-submit">
                            <if condition="$view_rules.submit == 'yes' ">
                                <a href="javascript:;" onclick="obj.ldap_add(this);" >
                                    <div class="form-button-long form-button-hover">
                                        {$Think.lang.Submit}
                                    </div>
                                </a>
                            </if>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="admin-dept-right">
            <table id="datagrid_box"></table>
            <div id="tb" style="padding:5px;">
                <if condition="$view_rules.modify == 'yes' ">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.ldap_modify();">
                        {$Think.lang.Modify}
                    </a>
                </if>
                <if condition="$view_rules.delete == 'yes' ">
                    <a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.ldap_delete();">
                        {$Think.lang.Delete}
                    </a>
                </if>
            </div>
        </div>
    </div>
</block>