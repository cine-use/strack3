<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.About_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_about.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_about.min.js"></script>
    </if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var AboutPHP = {
            'getSystemAbout' : '{:U("Admin/About/getSystemAbout")}',
            'updateLicense' : '{:U("Admin/About/updateLicense")}'
		};
		Strack.G.MenuName="about";
	</script>
</block>

<block name="admin-main-header">
	{$Think.lang.Admin_About}
</block>

<block name="admin-main">
	<div id="active-about" class="admin-content-wrap">
		<div class="admin-ui-full admin-ab-wrap">
            <div class="admin-ab-ver">
                <div class="about-ver-name">
                    <switch name="show_theme">
                        <case value="oem">{$Think.lang.Strack_Version_OEM}</case>
                        <default />{$Think.lang.Strack_Version}
                    </switch>
                </div>
                <div id="strack_version" class="about-ver-num version">
                    <!--about version-->
                </div>
            </div>
            <!--<div id="update_system" class="admin-ab-ver" style="display: none">
                <div class="about-ver-name">
                    {$Think.lang.Have_New_Version}
                </div>
                <div class="about-ver-num">
                    <a href="javascript:;" id="last_version" class="st-dialog-button st-button-base button-dgcel" onclick="obj.upgrade_system();">
                        3.0.0 Release
                    </a>
                </div>
            </div>
             -->
            <div class="admin-ab-ver">
                <div class="about-ver-name">
                    {$Think.lang.Server_Status}
                </div>
                <div id="server_list" class="admin-server-sta">
                    <!--服务器状态列表-->
                    <div class="datagrid-empty-no">{$Think.lang.No_Server_Available}</div>
                </div>
            </div>
            <div class="admin-ab-ver">
                <div class="about-ver-name">
                    {$Think.lang.License}
                </div>
                <div class="about-ver-num">
                    <input id="request_data" type="text" style="position: absolute;top:-9999px"/>
                    <li id="about_lic"></li>
                    <li id="about_lic_nc"></li>

                    <div class="about-bnt">
                        <eq name="view_rules.copy_license_request" value="yes">
                            <a href="javascript:;" id="copy_request" class="st-dialog-button st-button-base button-dgcel" data-clipboard-action="copy" data-clipboard-target="#request_data" onclick="obj.copy_request();">
                                {$Think.lang.Copy_License_Request}
                            </a>
                        </eq>
                        <eq name="view_rules.license_update" value="yes">
                            <a href="javascript:;" class="st-dialog-button st-button-base button-dgcel" onclick="obj.update_license();">
                                {$Think.lang.License_Update}
                            </a>
                        </eq>
                    </div>

                </div>
            </div>
		</div>
	</div>
</block>