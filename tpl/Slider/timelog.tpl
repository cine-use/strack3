<div id="side_timelog_hidden_param">
    <input name="rule_add" type="hidden" value="{$side_timelog_rules.add}">
    <input name="rule_delete" type="hidden" value="{$side_timelog_rules.delete}">
    <input name="rule_start_stop" type="hidden" value="{$side_timelog_rules.start_stop}">
</div>
<div class="ui grid slider-header">
    <div class="two column row">
        <div class="eight wide column">
            <span class="title">
                {$Think.lang.Time_Log}
            </span>
        </div>
        <div class="eight wide column button-wrap">
            <a id="slider_tg_refresh" href="javascript:;" class="button" onclick="Strack.refresh_timelog_slider(this)" data-tab="">
                {$Think.lang.Refresh}
                <i class="icon-uniEA57 icon-right"></i>
            </a>
        </div>
    </div>
</div>
<div id="slider_timelog_wrap" class="slider-main">
    <div class="ui grid slider-menu-wrap" style="margin-bottom: 16px;">
        <div class="center aligned two column row" style="padding: 15px 20px;">
            <a href="javascript:;" class="wide column" onclick="Strack.toggle_slider_tab(this)" data-panel="timelog" data-tab="active">
                <span id="slider_tg_tab_active" class="name sd-tg-tab">
                    {$Think.lang.Progressive}
                </span>
            </a>
            <a href="javascript:;" class="wide column" onclick="Strack.toggle_slider_tab(this)" data-panel="timelog" data-tab="history">
                <span id="slider_tg_tab_history" class="name sd-tg-tab">
                    {$Think.lang.My_Record}
                </span>
            </a>
        </div>
    </div>
    <div id="slider_tg_main_active" class="slider-menu-main" data-tab="active">
        <eq name="side_timelog_rules.add" value="yes">
            <div class="slider-tg-bnt-wrap">

                <a href="javascript:;" class="slider-tg-bnt" onclick="Strack.add_side_timer(this)">
                    <i class="icon-uniEA33"></i>
                </a>

            </div>
        </eq>
        <div id="slider_timer_list" class="slider-tg-ac-list">
            <div class="datagrid-empty-no text-center">{$Think.lang.Datagird_No_Data}</div>
        </div>
    </div>
    <div id="slider_tg_main_history"  class="slider-menu-main" data-tab="history">
        <div id="slider_tg_history_list" class="time-show-list">
            <div class="datagrid-empty-no text-center">{$Think.lang.Datagird_No_Data}</div>
        </div>
    </div>
</div>

