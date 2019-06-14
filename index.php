<?php
// 应用入口文件

// 检测PHP环境
if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    die('require PHP > 7.0.0 !');
}

// 定义应用目录
define('APP_PATH', __DIR__ . '/App/');

// 定义缓存目录
define('RUNTIME_PATH', __DIR__ . '/Runtime/');

// 定义模板文件默认目录
define("TMPL_PATH", __DIR__ . '/tpl/');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 引入入口文件
require __DIR__ . '/Core/Strack.php';
