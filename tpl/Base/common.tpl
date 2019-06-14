<!DOCTYPE html>
<html>
<head>
<include file="tpl/Public/head.tpl" />
</head>
<body class="{$page_identity.identity_id}" data-identity="{$page_identity.identity_id}" data-created="{$page_identity.created}">
<if condition="$new_login == 'yes' ">
    <include file="tpl/Public/global_loading.tpl" />
</if>
<include file="tpl/Public/header.tpl" />
<include file="tpl/Public/body.tpl" />
</body>
</html>