<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Workbench_Title}</title></block>

<block name="head-js">
    <script type="text/javascript" src="__JS__/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="__JS__/lib/free_layout.min.js"></script>
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/my_home.js"></script>
        <link rel="stylesheet" href="__COM_CSS__/src/free_layout.css">
        <else/>
        <script type="text/javascript" src="__JS__/build/home/my_home.min.js"></script>
        <link rel="stylesheet" href="__COM_CSS__/build/free_layout.min.css">
    </if>
    <div id="head_js"></div>
</block>
<block name="head-css">
    <script type="text/javascript">
        var MyHomePHP = {
            'scheduler_js' : '__JS__/build/scheduler/strack.calendar.min.js'
        };
        Strack.G.MenuName = "workbench";
    </script>
</block>

<block name="main">
    <div id="tac_myhome" class="my-home-wrap">
        <input id="module_id" type="hidden" value="{$module_id}"/>
        <input id="module_code" type="hidden" value="{$module_code}"/>
        <div class="st-project-wrap">
            <!--media page left pane-->
            <div class="st-menu-left st-media-w-l-color">
                <a href="javascript:;" class="st-menu-item-toggle st-media-m-t-w-hover" onclick="Strack.toggle_media_menu()">
                    <i class="icon-uniE903"></i>
                </a>
                <div class="st-menu-item">
                    <!--左侧菜单栏-->
                    <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="workbench" data-lang="{$Think.lang.Workbench}">
                        <i class="icon-uniE9CF media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.Workbench}</span>
                    </a>
                    <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="my_task" data-lang="{$Think.lang.My_Tasks}">
                        <i class="icon-uniF069 media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.My_Tasks}</span>
                    </a>
                    <a href="javascript:;" class="media-m-item media-m-item-w-color media-m-w-active" onclick="obj.switch_tab(this)" data-tab="my_note" data-lang="{$Think.lang.My_Notes}">
                        <i class="icon-uniE6C3 media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.My_Notes}
                            <sup id="top_msgs" class="st-tip-sup st-sup-ac">12</sup>
                        </span>
                    </a>
                    <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="my_version" data-lang="{$Think.lang.My_Versions}">
                        <i class="icon-uniE6FB media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.My_Versions}</span>
                    </a>
                    <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="my_publish" data-lang="{$Think.lang.My_Publish}">
                        <i class="icon-uniF1D9 media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.My_Publish}</span>
                    </a>
                    <a href="javascript:;" class="media-m-item media-m-item-w-color" onclick="obj.switch_tab(this)" data-tab="my_timelog" data-lang="{$Think.lang.Time_Log}">
                        <i class="icon-uniE603 media-m-icon-left"></i>
                        <span class="media-m-title">{$Think.lang.Time_Log}</span>
                    </a>
                </div>
            </div>
            <div class="st-menu-right">
                <!--myhome pane main-->
                <div class="stm-main-wrapper stm-m-w-myhome stm-m-wrapper-color">
                    <div class="ui tab pitem-wrap" data-tab="workbench">
                        <!--myhome dashboard-->
                        <div class="my-workbench-header">
                            <!--顶部个人介绍-->
                            <div class="my-workbench-row">
                                <div class="my-w-content">
                                    <div class="my-w-content-user">
                                        <div class="my-w-content-avatar">
                                            <div class="myhome-avatar">
                                                <img src="https://gw.alipayobjects.com/zos/rmsportal/BiazfanxmamNRoxxVxka.png">
                                            </div>
                                        </div>
                                        <div class="my-w-content-info">
                                            <div class="my-w-user-name">曲丽丽</div>
                                            <div>合成艺术家 | 合成组－组长</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-w-total">
                                    <div class="my-w-total-info">
                                        <div class="my-w-total-item">
                                            <p>项目数</p>
                                            <p>56</p>
                                        </div>
                                        <div class="my-w-total-item">
                                            <p>完成任务数量</p>
                                            <p>8<span> / 24</span></p>
                                        </div>
                                        <div class="my-w-total-item"><p>项目访问</p>
                                            <p>2,223</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-workbench-main">
                            <!--工作台自由控件区域-->
                            <div class="my-w-main-wrap">
                                <div class="grid-stack">
                                    <div class="grid-stack-item"
                                         data-gs-x="0" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="2">
                                        <div class="grid-stack-item-content"></div>
                                    </div>
                                    <div class="grid-stack-item"
                                         data-gs-x="4" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content"></div>
                                    </div>
                                    <div class="grid-stack-item"
                                         data-gs-x="4" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content"></div>
                                    </div>
                                    <div class="grid-stack-item"
                                         data-gs-x="4" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content"></div>
                                    </div>

                                    <div class="grid-stack-item"
                                         data-gs-x="4" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content"></div>
                                    </div>
                                    <div class="grid-stack-item"
                                         data-gs-x="4" data-gs-y="0"
                                         data-gs-width="4" data-gs-height="4">
                                        <div class="grid-stack-item-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui tab pitem-wrap" data-tab="my_task">
                        <!--myhome task-->
                        <div class="stm-main-header st-media-w-h-color">
                            <div id="media_content_title"  class="stm-header-title st-sin-font">
                                {$Think.lang.My_Tasks}
                            </div>
                        </div>
                        <div class="stm-main-content">
                            正文区域
                        </div>
                    </div>
                    <div class="ui tab pitem-wrap" data-tab="my_note">
                        <!--myhome note-->
                        <div class="stm-main-header st-media-w-h-color">
                            <div id="media_content_title"  class="stm-header-title st-sin-font">
                                {$Think.lang.My_Notes}
                            </div>
                        </div>
                        <div class="stm-main-content">
                            正文区域
                        </div>
                    </div>
                    <div class="ui tab pitem-wrap" data-tab="my_version">
                        <!--myhome version-->
                        <div class="stm-main-header st-media-w-h-color">
                            <div id="media_content_title"  class="stm-header-title st-sin-font">
                                {$Think.lang.My_Versions}
                            </div>
                        </div>
                        <div class="stm-main-content">
                            正文区域
                        </div>
                    </div>
                    <div class="ui tab pitem-wrap" data-tab="my_publish">
                        <!--myhome publish-->
                        <div class="stm-main-header st-media-w-h-color">
                            <div id="media_content_title"  class="stm-header-title st-sin-font">
                                {$Think.lang.My_Publish}
                            </div>
                        </div>
                        <div class="stm-main-content">
                            正文区域
                        </div>
                    </div>
                    <div class="ui tab pitem-wrap active" data-tab="my_timelog">
                        <!--myhome timelog-->
                        <div class="stm-main-header st-media-w-h-color">
                            <div id="media_content_title"  class="stm-header-title st-sin-font">
                                {$Think.lang.Time_Log}
                            </div>
                        </div>
                        <div class="stm-main-content">
                            <div id="my_timelog" class="my-timelog">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>