<div class="ui grid slider-header">
    <div class="two column row">
        <div class="eight wide column">
            <span class="title">
                {$Think.lang.Inbox}
            </span>
        </div>
        <div class="eight wide column button-wrap">
            <a id="slider_msg_refresh" href="javascript:;" class="button"  onclick="Strack.refresh_inbox_slider(this)" data-tab="">
                {$Think.lang.Refresh}
                <i class="icon-uniEA57 icon-right"></i>
            </a>
        </div>
    </div>
</div>
<div id="slider_inbox_wrap" class="slider-main">
    <div class="ui grid slider-menu-wrap" style="margin-bottom: 16px;">
        <div class="center aligned two column row" style="padding: 15px 20px;">
            <a href="javascript:;" class="wide column" onclick="Strack.toggle_slider_tab(this)" data-panel="inbox" data-tab="all">
                <span id="slider_msg_tab_all" class="name sd-msg-tab">
                    {$Think.lang.All_Message}
                </span>
            </a>
            <a href="javascript:;" class="wide column" onclick="Strack.toggle_slider_tab(this)" data-panel="inbox" data-tab="at_me">
                <span id="slider_msg_tab_at_me" class="name sd-msg-tab">
                    {$Think.lang.At_Me_Message}
                </span>
            </a>
        </div>
    </div>

    <div id="slider_msg_main_all" class="slider-inbox-list" data-tab="all">
        <div class="slider-inbox-main">
            <!--所有消息列表-->
            <div id="slider_msg_list_all" class="ui feed">
                <!--消息列表-->
            </div>
        </div>
    </div>

    <div id="slider_msg_main_at_me" class="slider-inbox-list" data-tab="at_me">
        <div class="slider-inbox-main">
            <!--@我的消息列表-->
            <div id="slider_msg_list_at_me" class="ui feed">
                <!--消息列表-->
            </div>
        </div>
    </div>
</div>

