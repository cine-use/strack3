<meta charset="UTF-8">
<link rel="shortcut icon" href="__COM_IMG__/favicon.ico" />
<block name="head-title"></block>
<include file="tpl/Public/lang.tpl" />
<script type="text/javascript" src="__COM_JS__/jquery.min.js"></script>
<script type="text/javascript" src="__JS__/lib/layer.js"></script>
<if condition="$is_dev == '1' ">
    <script type="text/javascript" src="__JS__/src/login/login_main.js"></script>
    <else/>
    <script type="text/javascript" src="__JS__/build/login/login_main.min.js"></script>
</if>
<block name="head-js"></block>
<if condition="$is_dev == '1' ">
    <link rel="stylesheet" href="__COM_CSS__/src/strackfont.css">
    <link rel="stylesheet" href="__COM_CSS__/src/layer.css">
    <else/>
    <link rel="stylesheet" href="__COM_CSS__/build/strackfont.min.css">
    <link rel="stylesheet" href="__COM_CSS__/build/layer.min.css">
</if>
<block name="head-css"></block>
<script type="text/javascript">
	var StrackLogin = {
		'ROOT' : '__ROOT__',
		'MODULE' : '__MODULE__',
		'IMG' : '__PUBLIC__/Common/images',
		'INDEX' : '{:U("/index")}',
        'LOGIN_INDEX' : '{:U("login/index")}'
	};
</script>