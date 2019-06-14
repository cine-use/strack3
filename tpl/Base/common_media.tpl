<!DOCTYPE html>
<html>
<head>
    <include file="tpl/Public/head_black.tpl" />
</head>
<body class="st-bg-black {$page_identity.identity_id}" data-identity="{$page_identity.identity_id}" data-created="{$page_identity.created}">
<if condition="$new_login == 'yes' ">
    <include file="tpl/Public/global_loading.tpl" />
</if>
<include file="tpl/Public/header.tpl" />
<include file="tpl/Public/body_media.tpl" />
</body>
</html>