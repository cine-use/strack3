<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Help_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/home/help.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/home/help.min.js"></script>
  </if>
  <div id="head_js"></div>
</block>
<block name="head-css">
  <script type="text/javascript">
    var HelpPHP = {

    };
    Strack.G.MenuName="help";
  </script>
</block>

<block name="main">
  <div class="page-wrap">
    <div class="help-top">
      <div class="help-title">
        <i class="icon-uniE60F"></i>
        {$Think.lang.Help_Center}
      </div>
    </div>
    <div class="help-main">
      <div class="help-item-wrap">
        <div class="col-lg-6 no-box-sizing">
          <div class="help-items">
            <div class="help-items-icon">
              <i class="icon-uniF02D"></i>
            </div>
            <div class="help-items-title">
              {$Think.lang.User_Guides}
            </div>
            <div class="help-items-content">
              {$Think.lang.User_Guides_Describe}
            </div>
            <div class="help-items-bnt">
              <a href="__ROOT__/doc/quick_start/" target="_blank">
                <div class="form-button-long form-button-hover">
                  {$Think.lang.Learn_Management}
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 no-box-sizing">
          <div class="help-items">
            <div class="help-items-icon">
              <i class="icon-uniE94B"></i>
            </div>
            <div class="help-items-title">
              {$Think.lang.Developer_Documentation}
            </div>
            <div class="help-items-content">
              {$Think.lang.Developer_Document_Describe}
            </div>
            <div class="help-items-bnt">
              <a href="__ROOT__/doc/python_api/" target="_blank">
                <div class="form-button-long form-button-hover">
                  {$Think.lang.Learn_Api}
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="hlep-video-list">
        <div class="hlep-video-wrap">
          <div class="col-lg-3 no-box-sizing">
            <div class="portfolio-item-inner">
              <img class="img-responsive" src="__PUBLIC__/images/support_video.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-3 no-box-sizing">
            <div class="portfolio-item-inner">
              <img class="img-responsive" src="__PUBLIC__/images/support_video.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-3 no-box-sizing">
            <div class="portfolio-item-inner">
              <img class="img-responsive" src="__PUBLIC__/images/support_video.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-3 no-box-sizing">
            <div class="portfolio-item-inner">
              <img class="img-responsive" src="__PUBLIC__/images/support_video.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
      -->
    </div>
  </div>
</block>