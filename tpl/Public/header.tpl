<div class="header-wrap">
	<div class="header-main">
		<div class="top-bar">
			<div class="nav_item st-logo" title="首页">
				<a href="{:U('/project/index')}">
					<switch name="show_theme">
						<case value="oem"><img src="__PUBLIC__/images/strack_logo_top_oem.png"></case>
						<default /><img src="__COM_IMG__/strack_logo_top.png">
					</switch>
				</a>
			</div>
			<div class="nav-breadcrumb-project nav-project-head" title="项目管理页面" style="display: none">
				<a href="{:U('/project/index')}">
					<i class="icon-uniF1ED"></i>
				</a>
			</div>
			<div class="nav-breadcrumb nav-project-head" style="display: none">

				<div class="nav-breadcrumb-icon">
					<i class="right angle icon divider"></i>
				</div>

				<div class="ui dropdown nav-breadcrumb-name" title="project name">
					<input type="hidden" name="filters">
					<span class="text nav-breadcrumb-text text-ellipsis"><!--填充 project name--></span>
					<div class="menu" style="top: 49px;">
						<div class="ui icon search input">
							<i class="search icon"></i>
							<input type="text" placeholder="{$Think.lang.Search_More}">
						</div>
						<div class="divider"></div>
						<div class="header">
							<i class="tags icon"></i>
							{$Think.lang.Active_Projects}
						</div>
						<div id="to_menu_project_list" class="scrolling menu">
							<!--填充 project list-->
						</div>
					</div>
				</div>
			</div>
			<div id="nav_main_bar" class="nav-main-bar">
				<include file="tpl/Public/top_menu_main.tpl" />
			</div>
			<div class="top-dropdown-none top-dropdown-right">
				<div class="ui nav-item-right st-nav-user dropdown">
					<div id="top_avatar" class="nav_user_avatar">
						<!--顶部菜单头像-->
					</div>
					<div class="nav-user-down">
						<i class="icon-uniF078"></i>
					</div>
					<div id="top_menu-3" class="menu">
						<include file="tpl/Public/top_menu_ac.tpl" />
					</div>
				</div>
			</div>
			<div id="header-tools" class="nav-item-right st_nav_tools">
				<include file="tpl/Public/top_tools.tpl" />
			</div>
		</div>
	</div>
</div>
