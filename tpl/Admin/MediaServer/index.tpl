<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Media_Server_Setting_Title}</title></block>

<block name="head-js">
	<if condition="$is_dev == '1' ">
		<script type="text/javascript" src="__JS__/src/admin/admin_media_server.js"></script>
		<else/>
		<script type="text/javascript" src="__JS__/build/admin/admin_media_server.min.js"></script>
	</if>
</block>
<block name="head-css">
	<script type="text/javascript">
		var MediaServerPHP = {
            'addMediaServer' : '{:U("Admin/MediaServer/addMediaServer")}',
            'modifyMediaServer' : '{:U("Admin/MediaServer/modifyMediaServer")}',
            'deleteMediaServer' : '{:U("Admin/MediaServer/deleteMediaServer")}',
            'getMediaServerGridData' : '{:U("Admin/MediaServer/getMediaServerGridData")}'
		};
		Strack.G.MenuName="mediaServer";
	</script>
</block>

<block name="admin-main-header">
	{$Think.lang.Media_Server_Setting}
</block>

<block name="admin-main">
	<div id="active-mediaServer" class="admin-content-dept">

		<div id="page_hidden_param">
			<input name="page" type="hidden" value="{$page}">
			<input name="module_id" type="hidden" value="{$module_id}">
			<input name="module_code" type="hidden" value="{$module_code}">
			<input name="module_name" type="hidden" value="{$module_name}">
		</div>

		<div class="admin-dept-left">
			<div class="dept-col-wrap">
				<div class="dept-form-wrap">
					<h3>{$Think.lang.Add_Media_Server}</h3>
					<form id="add_media_server" >
						<div class="form-field form-required required term-name-wrap">
							<label for="name">{$Think.lang.Name}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_name" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="name" wiget-name="{$Think.lang.Name}" placeholder="{$Think.lang.Input_Media_Server_Name}">
								<else/>
								<input class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Media_Server_Name}">
							</if>
						</div>
						<div class="form-field form-required required term-name-wrap">
							<label for="code">{$Think.lang.Code}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_code" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="code" wiget-name="{$Think.lang.Code}" placeholder="{$Think.lang.Input_Media_Server_Code}">
								<else/>
								<input  class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Media_Server_Code}">
							</if>
						</div>
						<div class="form-field form-required required term-name-wrap">
							<label for="request_url">{$Think.lang.Media_Server_Request_Address}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_request_url" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="request_url" wiget-name="{$Think.lang.Media_Server_Request_Address}" placeholder="{$Think.lang.Input_Media_Server_Request_Address}">
								<else/>
								<input  class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Media_Server_Request_Address}">
							</if>
						</div>
						<div class="form-field form-required required term-name-wrap">
							<label for="upload_url">{$Think.lang.Media_Server_Upload_Address}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_upload_url" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="upload_url" wiget-name="{$Think.lang.Media_Server_Upload_Address}" placeholder="{$Think.lang.Input_Media_Server_Upload_Address}">
								<else/>
								<input  class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_Media_Server_Upload_Address}">
							</if>
						</div>

						<div class="form-field form-required required term-name-wrap">
							<label for="access_key">{$Think.lang.AccessKey}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_access_key" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="access_key" wiget-name="{$Think.lang.AccessKey}" placeholder="{$Think.lang.Input_AccessKey}">
								<else/>
								<input  class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_AccessKey}">
							</if>
						</div>
						<div class="form-field form-required required term-name-wrap">
							<label for="secret_key">{$Think.lang.SecretKey}</label>
							<if condition="$view_rules.submit == 'yes' ">
								<input  id="media_server_secret_key" class="form-control form-input" autocomplete="off" wiget-type="input" wiget-need="yes" wiget-field="secret_key" wiget-name="{$Think.lang.SecretKey}" placeholder="{$Think.lang.Input_SecretKey}">
								<else/>
								<input  class="form-control form-input input-disabled" disabled="disabled" placeholder="{$Think.lang.Input_SecretKey}">
							</if>
						</div>
						<if condition="$view_rules.submit == 'yes' ">
							<div class="form-submit">
								<a href="javascript:;" onclick="obj.media_server_add();" >
									<div class="form-button-long form-button-hover">
										{$Think.lang.Submit}
									</div>
								</a>
							</div>
						</if>
					</form>
				</div>
			</div>
		</div>
		<div class="admin-dept-right">
			<table id="datagrid_box"></table>
			<div id="tb" style="padding:5px;">
				<if condition="$view_rules.modify == 'yes' ">
					<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="obj.media_server_modify();">
						{$Think.lang.Modify}
					</a>
				</if>
				<if condition="$view_rules.delete == 'yes' ">
					<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="obj.media_server_delete();">
						{$Think.lang.Delete}
					</a>
				</if>
			</div>
		</div>
	</div>
</block>