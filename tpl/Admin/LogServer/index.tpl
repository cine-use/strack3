<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Log_Server_Setting_Title}</title></block>

<block name="head-js">
	<if condition="$is_dev == '1' ">
		<script type="text/javascript" src="__JS__/src/admin/admin_log_server.js"></script>
		<else/>
		<script type="text/javascript" src="__JS__/build/admin/admin_log_server.min.js"></script>
	</if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var LogServerPHP = {
            'getLogServerConfig' : '{:U("Admin/LogServer/getLogServerConfig")}',
            'updateLogServerConfig' : '{:U("Admin/LogServer/updateLogServerConfig")}'
		};
		Strack.G.MenuName="logServer";
	</script>
</block>

<block name="admin-main-header">
	{$Think.lang.Log_Server_Setting}
</block>

<block name="admin-main">
	<div id="active-logServer" class="admin-content-wrap">
		<div class="admin-ui-full">
			<form id="log_setting" class="form-horizontal">
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Log_Server_Request_Address}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_request_url" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="request_url" wiget-name="{$Think.lang.Log_Server_Request_Address}" autocomplete="off" placeholder="{$Think.lang.Input_Log_Server_Request_Address}">
								<else/>
								<input id="set_request_url" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Log_Server_Request_Address}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.Log_Server_Websocket_Address}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_websocket_url" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="websocket_url" wiget-name="{$Think.lang.Log_Server_Websocket_Address}" autocomplete="off" placeholder="{$Think.lang.Input_Log_Server_Websocket_Address}">
								<else/>
								<input id="set_websocket_url" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Log_Server_Websocket_Address}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.AccessKey}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_access_key" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="access_key" wiget-name="{$Think.lang.AccessKey}" autocomplete="off" placeholder="{$Think.lang.Input_AccessKey}">
								<else/>
								<input id="set_access_key" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_AccessKey}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-group required">
					<label class="stcol-lg-1 control-label">{$Think.lang.SecretKey}</label>
					<div class="stcol-lg-2">
						<div class="bs-component">
							<if condition="$view_rules.submit == 'yes' ">
								<input id="set_secret_key" class="form-control form-input" wiget-type="input" wiget-need="yes" wiget-field="secret_key" wiget-name="{$Think.lang.SecretKey}" autocomplete="off" placeholder="{$Think.lang.Input_SecretKey}">
								<else/>
								<input id="set_secret_key" class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_SecretKey}">
							</if>
						</div>
					</div>
				</div>
				<div class="form-button-full">
					<if condition="$view_rules.submit == 'yes' ">
						<a href="javascript:;" onclick="obj.log_server_update();" >
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