<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Project_Manage_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/project_manage.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/project_manage.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var ProjectPHP = {
            'getProjectList': '{:U("Home/Project/getProjectList")}',
            'getProjectToolbarSettings': '{:U("Home/Project/getProjectToolbarSettings")}',
            'project_overview': '{:U("/project/overview")}'
        };
        Strack.G.MenuName = "project_manage";
    </script>
</block>

<block name="main">
    <div class="add-project-wrap">
        <div class="add-project-header">
            <div class="ui three column stackable grid">
                <div class="column">
                    <div class="add-project-filter">
                        <div class="ui dropdown proj-search-margin project_status">
                            {$Think.lang.Status} <i class="dropdown icon"></i>
                            <div id="project_toolbar_status" class="menu">
                              <!--组装项目状态菜单选项DOM-->
                            </div>
                        </div>
                        <div class="ui dropdown proj-search-margin project_time">
                            {$Think.lang.Time} <i class="dropdown icon"></i>
                            <div id="project_toolbar_time" class="menu">
                                <!--组装项目时间范围菜单选项DOM-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="add-project-search">
                        <div class="proj-search-box">
                            <input id="proj_search_box" autocomplete="off" placeholder="{$Think.lang.Search_Project_Or_CreateBy}"/>
                        </div>
                        <a href="javascript:;" class="proj-search-icon" onclick="obj.search_project(this)">
                            <i class="icon-uniE646"></i>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <if condition="$view_rules.add_project == 'yes' AND $default_mode.add_project == 'yes'">
                        <div class="add-project-bnt">
                            <a href="{:U("/project/create")}" class="st-dialog-button st-button-base button-dgsub" target="_self">{$Think.lang.Add_Project}</a>
                        </div>
                    </if>
                </div>
            </div>
        </div>
        <div id="project_list" class="add-project-main">

            <!--
            <a href="javascript:;" class="proj-search-title" onclick="obj.toggle_group(this)" data-groupid="1">
                分组标题
                <i class="triangle down icon"></i>
            </a>
            <div id="proj_group_1" class="proj-search-group">
                <div class="proj-search-rows">
                    <div class="ui six column doubling grid">
                        <?php for($i=0; $i<6; $i++){ ?>
                        <div class="column">
                            <div class="proj-list-card">
                                <div class="card">
                                    <div class="image">
                                        <img src="__COM_IMG__/project_thumb_test.jpg">
                                    </div>
                                    <div class="content">
                                        <div class="header"><strong>神奇女侠2</strong></div>
                                        <div class="description">《神奇女侠1984》的时间线将跳转到80年代美苏冷战时期。该片将于2019年11月1日在美国上映。</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-base"></div>
                                        <div class="progress-current"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="proj-search-rows">
                    <div class="ui six column doubling grid">
                        <?php for($i=0; $i<6; $i++){ ?>
                        <div class="column">
                            <div class="proj-list-card">
                                <div class="card">
                                    <div class="image">
                                        <img src="__COM_IMG__/project_thumb_default2.jpg">
                                    </div>
                                    <div class="content">
                                        <div class="header"><strong>神奇女侠2</strong></div>
                                        <div class="description">《神奇女侠1984》的时间线将跳转到80年代美苏冷战时期。该片将于2019年11月1日在美国上映。</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-base"></div>
                                        <div class="progress-current"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <a href="javascript:;" class="proj-search-title" onclick="obj.toggle_group(this)" data-groupid="2">
                其他
                <i class="triangle up icon"></i>
            </a>
            <div id="proj_group_2" class="proj-search-group">
                <div class="proj-search-rows">
                    <div class="ui six column doubling grid">
                        <?php for($i=0; $i<6; $i++){ ?>
                        <div class="column">
                            <div class="proj-list-card">
                                <div class="card">
                                    <div class="image">
                                        <img src="__COM_IMG__/project_thumb_test.jpg">
                                    </div>
                                    <div class="content">
                                        <div class="header"><strong>神奇女侠2</strong></div>
                                        <div class="description">《神奇女侠1984》的时间线将跳转到80年代美苏冷战时期。该片将于2019年11月1日在美国上映。</div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-base"></div>
                                        <div class="progress-current"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div> -->

        </div>
    </div>
</block>