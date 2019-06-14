<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.System_Mode_Title}</title></block>

<block name="head-js">
	<if condition="$is_dev == '1' ">
		<script type="text/javascript" src="__JS__/src/admin/admin_mode.js"></script>
		<else/>
		<script type="text/javascript" src="__JS__/build/admin/admin_mode.min.js"></script>
	</if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var ModePHP = {
            'getSystemModeList' : '{:U("Home/Widget/getSystemModeList")}',
			'getRoleList' : '{:U("Home/Widget/getRoleList")}',
            'getProjectList' : '{:U("Home/Widget/getProjectList")}',
			'getModeConfig' : '{:U("Admin/Mode/getModeConfig")}',
			'saveModeConfig' : '{:U("Admin/Mode/saveModeConfig")}'
		};
		Strack.G.MenuName="mode";
	</script>
</block>

<block name="admin-main-header">
	{$Think.lang.System_Mode}
</block>

<block name="admin-main">
	<div id="active-mode" class="admin-content-wrap">
		<div class="admin-ui-full">
			<form id="save_setting" class="form-horizontal">
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Mode}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="system_mode" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="mode" wiget-name="{$Think.lang.Mode}">
								<else/>
								<input id="system_mode" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Register_Open}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="open_register" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="open_register" wiget-name="{$Think.lang.Register_Open}">
								<else/>
								<input id="open_register" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Visit_System_Admin}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="visit_system_admin" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="visit_system_admin" wiget-name="{$Think.lang.Visit_System_Admin}">
								<else/>
								<input id="visit_system_admin" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Default_Role}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="default_role" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="default_role" wiget-name="{$Think.lang.Default_Role}">
								<else/>
								<input id="default_role" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Clone_Project_Open}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="open_clone_project" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="open_clone_project" wiget-name="{$Think.lang.Clone_Project_Open}">
								<else/>
								<input id="open_clone_project" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Allow_Create_Project_Open}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="open_create_project" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="open_create_project" wiget-name="{$Think.lang.Allow_Create_Project_Open}">
								<else/>
								<input id="open_create_project" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Default_Clone_Project}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="default_clone_project" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="default_clone_project" wiget-name="{$Think.lang.Default_Clone_Project}">
								<else/>
								<input id="default_clone_project" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Default_Project_Public}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="default_project_public" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="default_project_public" wiget-name="{$Think.lang.Default_Project_Public}">
								<else/>
								<input id="default_project_public" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-button-full">
					<if condition="$view_rules.submit == 'yes' ">
						<a href="javascript:;" onclick="obj.save_setting();" >
							<div class="form-button-long form-button-hover">
								{$Think.lang.Submit}
							</div>
						</a>
					</if>
				</div>
			</form>
		</div>
	</div>
</block>