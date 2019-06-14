<extend name="tpl/Base/common_login.tpl"/>
<block name="head-title"><title>{$Think.lang.Active_License}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__JS__/lib/layer.js"></script>
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/login/jquery.dataTable.js"></script>
    <script type="text/javascript" src="__JS__/src/login/license.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/login/jquery.dataTable.min.js"></script>
    <script type="text/javascript" src="__JS__/build/login/license.min.js"></script>
  </if>
</block>
<block name="head-css">
  <link rel="stylesheet" href="__CSS__/build/layer.min.css">
  <if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__CSS__/src/error.css">
    <else/>
    <link rel="stylesheet" href="__CSS__/build/error.min.css">
  </if>

  <script type="text/javascript">
    var ErrorPHP = {
        'getRequestFile': '{:U("Home/License/getRequestFile")}',
        'getLicenseRequestData' : '{:U("Home/License/getLicenseRequestData")}',
        'validationLicense': '{:U("Home/License/validationLicense")}',
        'getActiveUserGridData': '{:U("Home/License/getActiveUserGridData")}',
        'cancelAccount': '{:U("Home/License/cancelAccount")}',
        'login_page' : '{:U("Login/index")}'
    };
  </script>
</block>
<block name="main">
    <div class="error-wrap error-size-1">
      <div class="error-title">
        <i class="icon-uniEA30"></i>
        {$Think.lang.Activation_System_License}
      </div>
      <div class="error-item">
        <div class="error-i-tilte">
            {$Think.lang.Old_License_Information}
        </div>
        <div id="lic_request"  class="error-i-content">
          <div class="lic-number-show">
            <div id="old_lic_user_number" class="current-lic-number">
              {$Think.lang.Number_Of_Authorized_Users} <span>0</span>
            </div>
            <div id="old_lic_expire_date" class="current-lic-number">
              {$Think.lang.License_Expire_Time} <span>1971-01-01 00:00:00</span>
            </div>
            <div id="old_lic_expire_days" class="current-lic-number">
              {$Think.lang.License_Expire_Days} <span>0</span>
            </div>
          </div>
        </div>
      </div>
      <div class="error-item">
        <div class="error-i-tilte">
          {$Think.lang.License_Request_Notice}:
        </div>
        <div class="error-i-content">
          <div class="error-bnt">
            <a class="error-download-bnt" onclick="obj.download_file()">
                {$Think.lang.Download_File}
            </a>
          </div>
        </div>
      </div>
      <div class="error-item">
        <div class="error-i-tilte">
          {$Think.lang.License_Update}:
        </div>
        <div class="error-i-content">
          <textarea id="lic_text" autocomplete="off" placeholder="{$Think.lang.Copy_Content_To_TextArea}"></textarea>
        </div>
      </div>
      <div class="error-item">
        <div class="user-list">
            <table id="user_datagrid"></table>
        </div>
      </div>
      <div class="error-item">
        <div class="error-bnt">
          <a class="error-submit" onclick="obj.submit()">
              {$Think.lang.Activation_System_License}
          </a>
        </div>
      </div>
      <div id="adjust_active_user" class="error-item" style="display: none">
        <div class="error-i-tilte">
          {$Think.lang.Adjust_Active_Users}
        </div>
        <div class="lic-number-show">
          <div id="cancel_current_user_number" class="current-lic-number">
            {$Think.lang.Number_Of_Current_License} <span>0</span>
          </div>
          <div id="cancel_lic_user_number"  class="current-lic-number">
            {$Think.lang.Number_Of_Users_To_Log_Off} <span>0</span>
          </div>
        </div>
        <div class="error-i-content lic-user-manage">
          <div id="datagrid_box"></div>
        </div>
      </div>
    </div>
</block>