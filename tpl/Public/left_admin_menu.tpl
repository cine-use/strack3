<header class="sidebar-header">
    <!-- Sidebar Widget - Author -->
    <div class="sidebar-widget author-widget">
        <div class="media" style="overflow: hidden">
            <div id="padmin_avatar" class="admin-avatar aign-left" href="javascript:;">
                <!--Admin Top Avatar-->
            </div>
            <div class="media-body">
                <div class="media-links">
                    <p class="sidebar-menu-toggle">{$Think.lang.Admin_Menu} -</p>
                    <a href="{:U('/admin/index/logoutAdmin')}">{$Think.lang.Admin_logout}</a>
                </div>
                <div id="padmin_name" class="media-author">
                    <!--Admin Top UserName-->
                </div>
            </div>
        </div>
    </div>
</header>
<ul class="nav sidebar-menu">
    <!-- General Settings -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="10" data-type="status">
        {$Think.lang.Admin_System_Status}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-10" class="sidebar-nav nav-show">
        <if condition="$admin_menu.about == 'yes' ">
            <li id="admin_about">
                <a href="{:U('/admin/about')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE9CF"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_About}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.cache == 'yes' ">
            <li id="admin_cache">
                <a href="{:U('/admin/cache')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE91B"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Cache}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.eventlog == 'yes' ">
            <li id="admin_eventLog">
                <a href="{:U('/admin/eventlog')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE9AE"></span>
                    <span class="sidebar-title">{$Think.lang.EventLog}</span>
                </a>
            </li>
        </if>
    </div>
    <!-- General Settings -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="20" data-type="system">
        {$Think.lang.Admin_General}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-20" class="sidebar-nav nav-show">
        <if condition="$admin_menu.settings == 'yes' ">
            <li id="admin_settings">
                <a href="{:U('/admin/settings')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE9BD"></span>
                    <span class="sidebar-title">{$Think.lang.Default_Setting}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.mediaServer == 'yes' ">
            <li id="admin_mediaServer">
                <a href="{:U('/admin/mediaServer')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE9ED"></span>
                    <span class="sidebar-title">{$Think.lang.Media_Server_Setting}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.logServer == 'yes' ">
            <li id="admin_logServer">
                <a href="{:U('/admin/logServer')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF05A"></span>
                    <span class="sidebar-title">{$Think.lang.Log_Server_Setting}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.email == 'yes' ">
            <li id="admin_email">
                <a href="{:U('/admin/email')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE953"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Email}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.message == 'yes' ">
            <li id="admin_message">
                <a href="{:U('/admin/message')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF0A1"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Message}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.schedule == 'yes' ">
            <li id="admin_schedule">
                <a href="{:U('/admin/schedule')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE603"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Scheduling}</span>
                </a>
            </li>
        </if>
    </div>
    <!-- Third party login mode -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="31" data-type="login_settings">
        {$Think.lang.Login_Settings}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-31" class="sidebar-nav nav-show">
        <if condition="$admin_menu.signMethod == 'yes' ">
            <li id="admin_signMethod">
                <a href="{:U('/admin/signMethod')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE65E"></span>
                    <span class="sidebar-title">{$Think.lang.Sign_Method}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.ldap == 'yes' ">
            <li id="admin_ldap">
                <a href="{:U('/admin/ldap')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE615"></span>
                    <span class="sidebar-title">{$Think.lang.Ldap_Setting}</span>
                </a>
            </li>
        </if>
    </div>
    <!-- user Settings -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="30" data-type="user">
        {$Think.lang.Admin_User}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-30" class="sidebar-nav nav-show">
        <if condition="$admin_menu.department == 'yes' ">
            <li id="admin_dept">
                <a href="{:U('/admin/department')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE652"></span>
                    <span class="sidebar-title">{$Think.lang.Department}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.role == 'yes' ">
            <li id="admin_role">
                <a href="{:U('/admin/role')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE64A"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Auth_Role}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.account == 'yes' ">
            <li id="admin_account">
                <a href="{:U('/admin/account')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE723"></span>
                    <span class="sidebar-title">{$Think.lang.Admin_Account}</span>
                </a>
            </li>
        </if>
    </div>
    <!-- scene setting -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="40" data-type="scene">
        {$Think.lang.Admin_Scene}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-40" class="sidebar-nav nav-show">
        <if condition="$admin_menu.mode == 'yes' AND $user_id == 1">
            <li id="admin_mode">
                <a href="{:U('/admin/mode')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE66D2"></span>
                    <span class="sidebar-title">{$Think.lang.Mode}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.field == 'yes' AND $user_id == 1">
            <li id="admin_field">
                <a href="{:U('/admin/field')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE676"></span>
                    <span class="sidebar-title">{$Think.lang.Field}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.module == 'yes' AND $user_id == 1">
            <li id="admin_module">
                <a href="{:U('/admin/module')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE741"></span>
                    <span class="sidebar-title">{$Think.lang.Module}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.schema == 'yes' AND $user_id == 1">
            <li id="admin_schema">
                <a href="{:U('/admin/schema')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE624"></span>
                    <span class="sidebar-title">{$Think.lang.Schema}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.pageSchemaUse == 'yes' AND $user_id == 1">
            <li id="admin_page_schema_use">
                <a href="{:U('/admin/pageSchemaUse')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE944"></span>
                    <span class="sidebar-title">{$Think.lang.Page_Schema_Use}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.language == 'yes'">
            <li id="admin_language">
                <a href="{:U('/admin/language')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniEABB"></span>
                    <span class="sidebar-title">{$Think.lang.Language_Setting}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.action == 'yes' ">
            <li id="admin_action">
                <a href="{:U('/admin/action')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE6BB"></span>
                    <span class="sidebar-title">{$Think.lang.Action}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.step == 'yes' ">
            <li id="admin_steps">
                <a href="{:U('/admin/step')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE8B9"></span>
                    <span class="sidebar-title">{$Think.lang.Step}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.status == 'yes' ">
            <li id="admin_status">
                <a href="{:U('/admin/status')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF21E"></span>
                    <span class="sidebar-title">{$Think.lang.Status}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.tag == 'yes' ">
            <li id="admin_tags">
                <a href="{:U('/admin/tag')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF02C"></span>
                    <span class="sidebar-title">{$Think.lang.Tag}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.disks == 'yes' ">
            <li id="admin_disks">
                <a href="{:U('/admin/disks')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF01C"></span>
                    <span class="sidebar-title">{$Think.lang.Disks}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.cloudDisk == 'yes' AND $module_status.cloud_disk == 'active'">
            <li id="admin_cloudDisk">
                <a href="{:U('/admin/cloudDisk')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE6D7"></span>
                    <span class="sidebar-title">{$Think.lang.Cloud_Disk}</span>
                </a>
            </li>
        </if>
    </div>
    <!-- Project Settings -->
    <li class="sidebar-label pt20 sidebar_hide" data-hide="50" data-type="project">
        {$Think.lang.Admin_Project}
        <i class="icon-uniF106 sidebar-icon"></i>
    </li>
    <div id="sidebar-admin-50" class="sidebar-nav nav-show">
        <if condition="$admin_menu.template == 'yes' ">
            <li id="admin_template">
                <a href="{:U('/admin/template')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniF12E"></span>
                    <span class="sidebar-title">{$Think.lang.Project_Template}</span>
                </a>
            </li>
        </if>
        <if condition="$admin_menu.manage == 'yes' ">
            <li id="admin_manage">
                <a href="{:U('/admin/manage')}" onclick="Strack.click_admin_menu(this)">
                    <span class="icon-uniE633"></span>
                    <span class="sidebar-title">{$Think.lang.Project_Setting}</span>
                </a>
            </li>
        </if>
    </div>
</ul>