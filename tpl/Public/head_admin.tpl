<meta charset="UTF-8">
<link rel="shortcut icon" href="__COM_IMG__/favicon.ico" />
<block name="head-title"></block>
<include file="tpl/Public/head_variable.tpl" />
<if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__COM_JS__/src/admin/admin.js"></script>
    <else/>
    <script type="text/javascript" src="__COM_JS__/build/admin/admin.min.js"></script>
</if>
<block name="head-js"></block>
<if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__COM_CSS__/src/strak.main.css">
    <else/>
    <link rel="stylesheet" href="__COM_CSS__/build/strak.main.min.css">
</if>
<if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__UI_CSS__/white/strack.ui.css">
    <else/>
    <link rel="stylesheet" href="__UI_CSS__/white/strack.ui.min.css">
</if>
<if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__COM_CSS__/src/strackfont.css">
    <else/>
    <link rel="stylesheet" href="__COM_CSS__/build/strackfont.min.css">
</if>
<if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__COM_CSS__/src/lightgallery.css">
    <else/>
    <link rel="stylesheet" href="__COM_CSS__/build/lightgallery.min.css">
</if>
<link rel="stylesheet" href="__COM_CSS__/build/animation.min.css">
<block name="head-css"></block>