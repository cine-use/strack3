<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Default_Setting_Title}</title></block>

<block name="head-js">
	<if condition="$is_dev == '1' ">
		<script type="text/javascript" src="__JS__/src/admin/admin_settings.js"></script>
		<else/>
		<script type="text/javascript" src="__JS__/build/admin/admin_settings.min.js"></script>
	</if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var SettingsPHP = {
			'getDefaultOptions' : '{:U("Admin/Settings/getDefaultOptions")}',
			'updateDefaultSetting' : '{:U("Admin/Settings/updateDefaultSetting")}',
            'getLangList' : '{:U("Home/Widget/getLangList")}',
			'getTimezoneData' : '{:U("Admin/Settings/getTimezoneData")}'
		};
		Strack.G.MenuName="settings";
	</script>
</block>

<block name="admin-main-header">
	{$Think.lang.Default_Setting}
</block>

<block name="admin-main">
	<div id="active-settings" class="admin-content-wrap">
		<div class="admin-ui-full">
			<form id="save_setting" class="form-horizontal">
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.System_Lang}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_default_lang" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="default_lang" wiget-name="{$Think.lang.System_Lang}">
								<else/>
								<input id="set_default_lang" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.System_Timezone}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_default_timezone" class="form-input" wiget-type="combobox" wiget-need="yes" wiget-field="default_timezone" wiget-name="{$Think.lang.System_Timezone}">
								<else/>
								<input id="set_default_timezone" class="form-input" data-options="disabled:true">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.System_Email}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_email" class="form-control form-input" type="text" wiget-type="input" wiget-need="yse" wiget-field="default_emailsuffix" wiget-name="{$Think.lang.System_Email}" autocomplete="off" placeholder="{$Think.lang.Input_Email_Suffix}">
								<else/>
								<input id="set_email" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Status_Name}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.System_PassWord}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_password" class="form-control form-input" type="text" wiget-type="input" wiget-need="yse" wiget-field="default_password" wiget-name="{$Think.lang.System_PassWord}" autocomplete="off" placeholder="{$Think.lang.Input_Default_Password}">
								<else/>
								<input id="set_password" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Status_Name}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="stcol-lg-1 control-label">{$Think.lang.BeiAn_Number_Title}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_beian_number" class="form-control form-input" type="text" wiget-type="input" wiget-need="yse" wiget-field="default_beian_number" wiget-name="{$Think.lang.BeiAn_Number}" autocomplete="off" placeholder="{$Think.lang.Input_BeiAn_Number}">
								<else/>
								<input id="set_beian_number" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_BeiAn_Number}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="stcol-lg-1 control-label">{$Think.lang.MFA_Verify_Open}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="open_mfa_verify" class="form-input" wiget-type="switch" wiget-need="no" wiget-field="open_mfa_verify" wiget-name="{$Think.lang.MFA_Verify_Open}">
								<else/>
								<input id="open_mfa_verify" class="form-input" data-options="disabled:true">
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