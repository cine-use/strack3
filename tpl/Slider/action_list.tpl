<div class="import-excel-header">
    <div class="import-excel-title">
        {$Think.lang.Action_List}
    </div>
    <div class="import-excel-close">
        <a href="javascript:;" onclick="Strack.close_action_slider(this)">
            <i class="icon-uniE6DF"></i>
        </a>
    </div>
</div>
<div class="import-excel-main">
    <div class="slider-action-search">
        <!--搜索框-->
        <div class="ui three column stackable grid">
            <div class="column">
            </div>
            <div class="column">
                <div class="add-project-search">
                    <div class="proj-search-box">
                        <input id="action_search_box" autocomplete="off" placeholder="{$Think.lang.Search_Action_Name}"/>
                    </div>
                    <a href="javascript:;" id="action_search_bnt" class="proj-search-icon" onclick="Strack.search_action(this)" data-from="" data-grid="" data-ids="" data-moduleid="" data-projectid="">
                        <i class="icon-uniE646"></i>
                    </a>
                </div>
            </div>
            <div class="column">
            </div>
        </div>
    </div>
    <div class="slider-action-list">
        <!--所有Action-->
        <div class="title">
            常用动作
        </div>
        <div class="slider-action-column">
            <div id="common_action_list"  class="ui nine column doubling grid ">
               <!--常用动作-->
                <div class="datagrid-empty-no text-center">没有数据匹配你的搜索。</div>
            </div>
        </div>
        <div class="title">
            其他
        </div>
        <div class="slider-action-column">
            <!--其他动作-->
            <div id="other_action_list"  class="ui nine column doubling grid ">
                <div class="datagrid-empty-no text-center">没有数据匹配你的搜索。</div>
            </div>
        </div>
    </div>
</div>