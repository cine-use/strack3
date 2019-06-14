<?php

use Think\Env;

return array(

    //*************************************系统基础信息***********************************
    'COMPANY_NAME' => Env::get("company_name"),    //系统版权
    "STRACK_INSTALL_VERSION" => Env::get("version"),    //系统安装版本版本
    "STRACK_VERSION" => "3.1.3 Released",    //当前系统版本
    'SHOW_THEME' => Env::get("show_theme"),    //系统版权
    'LOAD_EXT_CONFIG' => ['JOBS' => 'swoole_jobs', 'SMS'=> 'sms'],

    //开启语言包
    'LANG_SWITCH_ON' => true,
    'LANG_AUTO_DETECT' => true,
    'DEFAULT_LANG' => 'en-us',
    'LANG_LIST' => 'zh-cn,en-us',
    'VAR_LANGUAGE' => 'lang',

    //缓存文件前缀
    'DATA_CACHE_KEY' => 'cineuse@weijer_2018',

    //设置模版替换变量
    'TMPL_PARSE_STRING' => array(
        '__COM_IMG__' => __ROOT__ . '/Public/images',
        '__COM_CSS__' => __ROOT__ . '/Public/css',
        '__COM_JS__' => __ROOT__ . '/Public/js',
        '__CSS__' => __ROOT__ . '/Public/css',
        '__JS__' => __ROOT__ . '/Public/js',
        '__JS_LIB__' => __ROOT__ . '/Public/js/lib',
        '__IMG__' => __ROOT__ . '/Public/images',
        '__UI_CSS__' => __ROOT__ . '/Public/themes',
        '__JSUI_LANG__' => __ROOT__ . '/Public/lang',
        '__COLPICK__' => __ROOT__ . '/Public/js/colpick',
        '__UPLOADS__' => __ROOT__ . '/Uploads',
        '__PROJ_THUMB__' => __ROOT__ . '/Uploads/ProjectThumb',
        '__TASK_THUMB__' => __ROOT__ . '/Uploads/TaskThumb',
        '__ITEM_THUMB__' => __ROOT__ . '/Uploads/ItemThumb'
    ),

    //Trace调试
    //'SHOW_PAGE_TRACE' =>true,

    "WHOOPS" => "auto",

    //设置可访问目录
    'MODULE_ALLOW_LIST' => ['Home', 'Admin', 'Api', 'Queue'],

    //设置默认目录
    'DEFAULT_MODULE' => 'Home',

    //URL模式
    'URL_MODEL' => '2',

    //开启伪静态
    'URL_HTML_SUFFIX' => '.html',

    //url 不区分大小写
    'URL_CASE_INSENSITIVE' => true,

    //开启路由
    'URL_ROUTER_ON' => true,

    //路由规则
    'URL_ROUTE_RULES' => array(
        'details/:id' => 'Home/Details/index'
    ),

    //设置模版后缀
    'TMPL_TEMPLATE_SUFFIX' => '.tpl',

    //加密key
    'COOKIE_KEY' => 'strack.login_2020',

    //用户默认密码
    'DEFAULT_PASSWORD' => Env::get("default_password"),

    //用户默认邮箱后缀
    'Default_EmailExt' => Env::get("default_email_suffix"),

    //允许上传图片后缀
    "Image_Allow_Ext" => ["gif", "jpeg", "jpg", "bmp", "png"],

    //允许上传视频格式后缀
    "Video_Allow_Ext" => ["mov", "mp4", "avi", "wav", "flv"],

    //允许上传EXcel格式后缀
    "Excel_File_Allow_Ext" => ["xlsx", "xls"],

    //数据库配置信息
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => Env::get("database_host"), // 服务器地址
    'DB_NAME' => Env::get("database_name"), // 数据库名
    'DB_USER' => Env::get("database_user"), // 用户名
    'DB_PWD' => Env::get("database_password"), // 密码
    'DB_PORT' => Env::get("database_port"), // 端口
    'DB_PREFIX' => 'strack_', // 数据库表前缀
    'DB_CHARSET' => 'utf8mb4', // 字符集
    'DB_DEBUG' => false, // 数据库调试模式 开启后可以记录SQL日志
    'READ_DATA_MAP' => true,//开启数据库字段映射
    'DB_MAX_SELECT_ROWS' => Env::get("database_max_select_rows"), // 数据库调试模式 开启后可以记录SQL日志

    //Redis S方法配置
    'DATA_CACHE_PREFIX' => 'Redis_',//缓存前缀
    'DATA_CACHE_TYPE' => 'Redis',//默认动态缓存为Redis
    'REDIS_RW_SEPARATE' => false, //Redis读写分离 true 开启
    'REDIS_HOST' => Env::get("redis_host"), //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT' => Env::get("redis_port"),//端口号
    'REDIS_TIMEOUT' => '300',//超时时间
    'REDIS_PERSISTENT' => false,//是否长连接 false=短连接
    'REDIS_PASSWORD' => Env::get("redis_password"),//Redis认证密码
    'DATA_CACHE_TIME' => 0,// 数据缓存有效期 0表示永久缓存

    // 使用redis缓存数据
    'cache' => [
        'type' => 'redis',
        // 服务器地址
        'host' => Env::get("redis_host"),
        'port' => Env::get("redis_port"),
        'password' => Env::get("redis_password"),
        'select' => 0,
        'timeout' => 300,
        'expire' => 0,
        'persistent' => true,
        'prefix' => 'strack_',
    ],

    //设置默认时区
    'DEFAULT_TIMEZONE_CUSTOM' => 8,//默认中国时区

    // OAuth 2.0 配置
    'OAUTH2_CODES_TABLE' => 'strack_oauth_code',
    'OAUTH2_CLIENTS_TABLE' => 'strack_oauth_client',
    'OAUTH2_TOKEN_TABLE' => 'strack_oauth_token',

    // 管理员密码
    'Administrator_Password' => 'Strack@Admin',
    //token 过期时间
    'token_expire_time' => 3600,

    // 固定module id
    'MODULE_ID' => [
        'action' => 1,
        'project_member' => 3,
        'base' => 4,
        'status' => 27,
        'media' => 14,
        'onset_att' => 10,
        'note' => 17,
        'onset' => 18,
        'project' => 20,
        'file' => 24,
        'timelog' => 31,
        'user' => 34,
        'file_commit' => 36,
        'review' => 54,
    ],

    // module应用状态
    'MODULE_STATUS' => [
        'cloud_disk' => Env::get("module_cloud_disk")
    ]
);