<?php

// 记录开始运行时间
$GLOBALS['_beginTime'] = microtime(true);

// 记录内存初始使用
define('MEMORY_LIMIT_ON', function_exists('memory_get_usage'));
if (MEMORY_LIMIT_ON) {
    $GLOBALS['_startUseMems'] = memory_get_usage();
}

// 版本信息（Strack定制版本）
const THINK_VERSION = '6.6.6';

// URL 模式定义
const URL_COMMON = 0; //普通模式
const URL_PATHINFO = 1; //PATHINFO模式
const URL_REWRITE = 2; //REWRITE模式
const URL_COMPAT = 3; // 兼容模式

// 类文件后缀
define('EXT', '.class.php');

define('DS', DIRECTORY_SEPARATOR);

// 系统常量定义
defined('THINK_PATH') or define('THINK_PATH', __DIR__ . DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('APP_STATUS') or define('APP_STATUS', ''); // 应用状态 加载对应的配置文件
defined('APP_DEBUG') or define('APP_DEBUG', false); // 是否调试模式
defined('APP_MODE') or define('APP_MODE', 'common'); // 应用模式 默认为普通模式
defined('STORAGE_TYPE') or define('STORAGE_TYPE', 'File'); // 存储类型 默认为File
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'Runtime' . DS); // 系统运行时目录
defined('LIB_PATH') or define('LIB_PATH', realpath(THINK_PATH . 'Library') . DS); // 系统核心类库目录
defined('CORE_PATH') or define('CORE_PATH', LIB_PATH . 'Think' . DS); // Think类库目录
defined('BEHAVIOR_PATH') or define('BEHAVIOR_PATH', LIB_PATH . 'Behavior' . DS); // 行为类库目录
defined('MODE_PATH') or define('MODE_PATH', THINK_PATH . 'Mode' . DS); // 系统应用模式目录
defined('VENDOR_PATH') or define('VENDOR_PATH', LIB_PATH . 'Vendor' . DS); // 第三方类库目录
defined('COMMON_PATH') or define('COMMON_PATH', APP_PATH . 'Common' . DS); // 应用公共目录
defined('CONF_PATH') or define('CONF_PATH', COMMON_PATH . 'Conf' . DS); // 应用配置目录
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . DS);
defined('COMMON_VENDOR_PATH') or define('COMMON_VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('LANG_PATH') or define('LANG_PATH', COMMON_PATH . 'Lang' . DS); // 应用语言目录
defined('HTML_PATH') or define('HTML_PATH', APP_PATH . 'Html' . DS); // 应用静态目录
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'Logs' . DS); // 应用日志目录
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'Temp' . DS); // 应用缓存目录
defined('DATA_PATH') or define('DATA_PATH', RUNTIME_PATH . 'Data' . DS); // 应用数据目录
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'Cache' . DS); // 应用模板缓存目录
defined('CONF_EXT') or define('CONF_EXT', '.php'); // 配置文件后缀
defined('CONF_PARSE') or define('CONF_PARSE', ''); // 配置文件解析方法
defined('ADDON_PATH') or define('ADDON_PATH', APP_PATH . 'Addon');
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀

defined('MAGIC_QUOTES_GPC') or define('MAGIC_QUOTES_GPC', false);

// 环境常量
define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);


// 载入Loader类
require CORE_PATH . 'Loader' . EXT;

// 加载环境变量配置文件
if (is_file(ROOT_PATH . '.env')) {
    $env = parse_ini_file(ROOT_PATH . '.env', true);
    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);
        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}

// 模板文件根地址
if (!IS_CLI) {
    // 当前文件名
    if (!defined('_PHP_FILE_')) {
        if (IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp = explode('.php', $_SERVER['PHP_SELF']);
            define('_PHP_FILE_', rtrim(str_replace($_SERVER['HTTP_HOST'], '', $_temp[0] . '.php'), '/'));
        } else {
            define('_PHP_FILE_', rtrim($_SERVER['SCRIPT_NAME'], '/'));
        }
    }
    if (!defined('__ROOT__')) {
        $_root = rtrim(dirname(_PHP_FILE_), '/');
        define('__ROOT__', (('/' == $_root || '\\' == $_root) ? '' : $_root));
    }
} else {
    define('__ROOT__', '');
    define('_PHP_FILE_', '');
}

// 注册自动加载
\Think\Loader::register();

// 注册错误和异常处理机制
\Think\Error::register();


