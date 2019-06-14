<extend name="tpl/Base/common_error.tpl"/>
<block name="head-title"><title>{$Think.lang.System_Error}</title></block>

<block name="head-js">
  <script type="text/javascript" src="__JS__/error/sys_error.js"></script>
</block>
<block name="head-css">
  <link rel="stylesheet" href="__CSS__/build/error.min.css">
  <script type="text/javascript">
    var ErrorPHP = {
      'User_Illegal_Number' : '{$Think.lang.User_Illegal_Number}',
    };
  </script>
</block>
<block name="main">
  <div class="error-wrap error-size-2">
    <div class="error-title">
      <i class="icon-uniEA30"></i>
      {$Think.lang.TSystem_Error} -- {$error_type}
    </div>
    <div class="error-item" style="min-height: 130px">
      <div id="sys_error_notice" class="error-i-notice">
      </div>
    </div>
    <div class="error-item">
      <div class="error-bnt">
        <a href="{:U("Empty/Licnull")}" class="error-submit" >{$Think.lang.License_Update}</a>
      </div>
    </div>
  </div>
</block>