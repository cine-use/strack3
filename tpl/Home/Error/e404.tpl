<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.E404_Title}</title></block>

<block name="head-css">
  <script type="text/javascript">
      Strack.G.MenuName = "error";
  </script>
</block>

<block name="main">
  <div class="error-404-layout">
    <div class="error-404-icon" >
      <div class="error-img-icon error-404-img"></div>
    </div>
    <div class="error-404-notice">
      <div style="color: #434e59;font-size: 72px; font-weight: 600;line-height: 72px;margin-bottom: 24px;">404</div>
      <div style="color: rgba(0, 0, 0, 0.45);font-size: 20px;line-height: 28px;margin-bottom: 16px;">{$Think.lang.Page_Not_Exist_Notice}</div>
    </div>
  </div>
</block>