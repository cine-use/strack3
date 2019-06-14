<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Message_Setting_Title}</title></block>

<block name="head-js">
  <if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/admin/admin_message.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/admin/admin_message.min.js"></script>
  </if>
</block>
<block name="head-css">
  <script type="text/javascript">
    var MessagePHP = {
        "getMessageSetting" : '{:U("Admin/Message/getMessageSetting")}',
        'saveMessageSetting': '{:U("Admin/Message/saveMessageSetting")}'
    };
    Strack.G.MenuName="message";
  </script>
</block>

<block name="admin-main-header">
  {$Think.lang.Admin_Message}
</block>

<block name="admin-main">
  <div id="active-message" class="admin-content-wrap">
    <div class="ad-srd-wrap">
      <div class="ad-srd-title">
        {$Think.lang.Project}
      </div>
    </div>
    <div class="admin-ui-full">
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_Project_Change_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="project_change" class="open-switch" />
              <else/>
              <input id="project_change" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
    </div>
    <div class="ad-srd-wrap">
      <div class="ad-srd-title">
          {$Think.lang.Entity}
      </div>
    </div>
    <div class="admin-ui-full">
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_Entity_Change_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="entity_change" class="open-switch" />
              <else/>
              <input id="entity_change" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
    </div>
    <div class="ad-srd-wrap">
      <div class="ad-srd-title">
          {$Think.lang.Task}
      </div>
    </div>
    <div class="admin-ui-full">
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_My_Task_Change_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="my_task_change" class="open-switch" />
              <else/>
              <input id="my_task_change" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
    </div>
    <div class="ad-srd-wrap">
      <div class="ad-srd-title">
          {$Think.lang.Review}
      </div>
    </div>
    <div class="admin-ui-full">
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_Has_Review_Task_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="has_review_task" class="open-switch" />
              <else/>
              <input id="has_review_task" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_Task_Note_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="has_note" class="open-switch" />
              <else/>
              <input id="has_note" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="stcol-lg-1 control-label">{$Think.lang.Message_Note_AT_Title}</label>
        <div class="stcol-lg-2">
          <div class="bs-component">
            <if condition="$view_rules.submit == 'yes' ">
              <input id="has_note_at" class="open-switch" />
              <else/>
              <input id="has_note_at" class="form-input" data-options="disabled:true">
            </if>
          </div>
        </div>
      </div>
      <div class="form-button-full">
        <if condition="$view_rules.submit == 'yes' ">
          <a href="javascript:;" onclick="obj.save_message_setting();" >
            <div class="form-button-long form-button-hover">
              {$Think.lang.Submit}
            </div>
          </a>
        </if>
      </div>
    </div>
  </div>
</block>