<include file="tpl/Public/slider.tpl" />
<div class="pusher pusher-global">
    <div class="account-page-main">
        <div class="account-page-main-set">
            <div class="account-page-wrap  hbox flex">
                <div class="admin-page-left nano-content">
                    <include file="tpl/Public/left_admin_menu.tpl" />
                </div>
                <div class="admin-page-right st-flex">
                    <header class="admin-main-header">
                        <div class="topbar-left">
                            <ol class="breadcrumb">
                                <li class="crumb-icon">
                                    <a href="{:U('/admin/index')}">
                                        <span class="icon-uniE907"></span>
                                    </a>
                                </li>
                                <li class="crumb-link">
                                    <a href="{:U('/admin/index')}">{$Think.lang.Home}</a>
                                </li>
                                <li class="crumb-trail">
                                    <block name="admin-main-header"></block>
                                </li>
                            </ol>
                        </div>
                    </header>
                    <block name="admin-main"></block>
                </div>
            </div>
        </div>
    </div>
</div>

