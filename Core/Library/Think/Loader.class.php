<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace Think;

use Think\Exception\ClassNotFoundException;

class Loader
{
    protected static $_instance = [];

    // 类名映射
    protected static $_map = [];

    // 命名空间别名
    protected static $namespaceAlias = [];

    // PSR-4
    private static $prefixLengthsPsr4 = [];
    private static $prefixDirsPsr4 = [];
    private static $fallbackDirsPsr4 = [];

    // PSR-0
    private static $prefixesPsr0 = [];
    private static $fallbackDirsPsr0 = [];

    /**
     * 需要加载的文件
     * @var array
     */
    private static $files = [];

    /**
     * 框架类自动加载
     * @param $class
     */
    public static function autoload($class)
    {
        // 检查是否存在映射
        if (isset(self::$_map[$class])) {
            include self::$_map[$class];
        } elseif (false !== strpos($class, '\\')) {
            $name = strstr($class, '\\', true);
            if (in_array($name, array('Think', 'Org', 'Behavior', 'Com', 'Vendor')) || is_dir(LIB_PATH . $name)) {
                // Library目录下面的命名空间自动定位
                $path = LIB_PATH;
            } else {
                // 检测自定义命名空间 否则就以模块为命名空间
                $namespace = C('AUTOLOAD_NAMESPACE');
                $path = isset($namespace[$name]) ? dirname($namespace[$name]) . '/' : APP_PATH;
            }
            $filename = $path . str_replace('\\', '/', $class) . EXT;
            if (is_file($filename)) {
                // Win环境下面严格区分大小写
                if (IS_WIN && false === strpos(str_replace('/', '\\', realpath($filename)), $class . EXT)) {
                    return;
                }
                include $filename;
            }
        } elseif (!C('APP_USE_NAMESPACE')) {
            // 自动加载的类库层
            foreach (explode(',', C('APP_AUTOLOAD_LAYER')) as $layer) {
                if (substr($class, -strlen($layer)) == $layer) {
                    if (require_cache(MODULE_PATH . $layer . '/' . $class . EXT)) {
                        return;
                    }
                }
            }
            // 根据自动加载路径设置进行尝试搜索
            foreach (explode(',', C('APP_AUTOLOAD_PATH')) as $path) {
                if (import($path . '.' . $class)) // 如果加载类成功则返回
                {
                    return;
                }

            }
        }
    }

    /**
     * 查找文件
     * @param $class
     * @return bool
     */
    private static function findFile($class)
    {
        if (!empty(self::$_map[$class])) {
            // 类库映射
            return self::$_map[$class];
        }

        // 查找 PSR-4
        $logicalPathPsr4 = strtr($class, '\\', DS) . EXT;

        $first = $class[0];
        if (isset(self::$prefixLengthsPsr4[$first])) {
            foreach (self::$prefixLengthsPsr4[$first] as $prefix => $length) {
                if (0 === strpos($class, $prefix)) {
                    foreach (self::$prefixDirsPsr4[$prefix] as $dir) {
                        if (is_file($file = $dir . DS . substr($logicalPathPsr4, $length))) {
                            return $file;
                        }
                    }
                }
            }
        }

        // 查找 PSR-4 fallback dirs
        foreach (self::$fallbackDirsPsr4 as $dir) {
            if (is_file($file = $dir . DS . $logicalPathPsr4)) {
                return $file;
            }
        }

        // 查找 PSR-0
        if (false !== $pos = strrpos($class, '\\')) {
            // namespaced class name
            $logicalPathPsr0 = substr($logicalPathPsr4, 0, $pos + 1)
                . strtr(substr($logicalPathPsr4, $pos + 1), '_', DS);
        } else {
            // PEAR-like class name
            $logicalPathPsr0 = strtr($class, '_', DS) . EXT;
        }

        if (isset(self::$prefixesPsr0[$first])) {
            foreach (self::$prefixesPsr0[$first] as $prefix => $dirs) {
                if (0 === strpos($class, $prefix)) {
                    foreach ($dirs as $dir) {
                        if (is_file($file = $dir . DS . $logicalPathPsr0)) {
                            return $file;
                        }
                    }
                }
            }
        }

        // 查找 PSR-0 fallback dirs
        foreach (self::$fallbackDirsPsr0 as $dir) {
            if (is_file($file = $dir . DS . $logicalPathPsr0)) {
                return $file;
            }
        }

        return self::$_map[$class] = false;
    }

    /**
     * 注册classmap
     * @param $class
     * @param string $map
     */
    public static function addClassMap($class, $map = '')
    {
        if (is_array($class)) {
            self::$_map = array_merge(self::$_map, $class);
        } else {
            self::$_map[$class] = $map;
        }
    }

    /**
     * 注册命名空间
     * @param $namespace
     * @param string $path
     */
    public static function addNamespace($namespace, $path = '')
    {
        if (is_array($namespace)) {
            foreach ($namespace as $prefix => $paths) {
                self::addPsr4($prefix . '\\', rtrim($paths, DS), true);
            }
        } else {
            self::addPsr4($namespace . '\\', rtrim($path, DS), true);
        }
    }

    /**
     * 添加Ps0空间
     * @param $prefix
     * @param $paths
     * @param bool $prepend
     */
    private static function addPsr0($prefix, $paths, $prepend = false)
    {
        if (!$prefix) {
            if ($prepend) {
                self::$fallbackDirsPsr0 = array_merge(
                    (array)$paths,
                    self::$fallbackDirsPsr0
                );
            } else {
                self::$fallbackDirsPsr0 = array_merge(
                    self::$fallbackDirsPsr0,
                    (array)$paths
                );
            }

            return;
        }

        $first = $prefix[0];
        if (!isset(self::$prefixesPsr0[$first][$prefix])) {
            self::$prefixesPsr0[$first][$prefix] = (array)$paths;

            return;
        }
        if ($prepend) {
            self::$prefixesPsr0[$first][$prefix] = array_merge(
                (array)$paths,
                self::$prefixesPsr0[$first][$prefix]
            );
        } else {
            self::$prefixesPsr0[$first][$prefix] = array_merge(
                self::$prefixesPsr0[$first][$prefix],
                (array)$paths
            );
        }
    }

    /**
     * 添加Psr4空间
     * @param $prefix
     * @param $paths
     * @param bool $prepend
     */
    private static function addPsr4($prefix, $paths, $prepend = false)
    {
        if (!$prefix) {
            // Register directories for the root namespace.
            if ($prepend) {
                self::$fallbackDirsPsr4 = array_merge(
                    (array)$paths,
                    self::$fallbackDirsPsr4
                );
            } else {
                self::$fallbackDirsPsr4 = array_merge(
                    self::$fallbackDirsPsr4,
                    (array)$paths
                );
            }
        } elseif (!isset(self::$prefixDirsPsr4[$prefix])) {
            // Register directories for a new namespace.
            $length = strlen($prefix);
            if ('\\' !== $prefix[$length - 1]) {
                throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            self::$prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
            self::$prefixDirsPsr4[$prefix] = (array)$paths;
        } elseif ($prepend) {
            // Prepend directories for an already registered namespace.
            self::$prefixDirsPsr4[$prefix] = array_merge(
                (array)$paths,
                self::$prefixDirsPsr4[$prefix]
            );
        } else {
            // Append directories for an already registered namespace.
            self::$prefixDirsPsr4[$prefix] = array_merge(
                self::$prefixDirsPsr4[$prefix],
                (array)$paths
            );
        }
    }

    /**
     * 读取应用模式文件
     */
    private static function readModeFile()
    {
        // 读取应用模式
        $mode = include_once is_file(CONF_PATH . 'core.php') ? CONF_PATH . 'core.php' : MODE_PATH . APP_MODE . '.php';

        // 加载核心文件
        foreach ($mode['core'] as $file) {
            if (is_file($file)) {
                include $file;
            }
        }

        // 加载应用模式配置文件
        foreach ($mode['config'] as $key => $file) {
            is_numeric($key) ? C(load_config($file)) : C($key, load_config($file));
        }

        // 读取当前应用模式对应的配置文件
        if ('common' != APP_MODE && is_file(CONF_PATH . 'config_' . APP_MODE . CONF_EXT)) {
            C(load_config(CONF_PATH . 'config_' . APP_MODE . CONF_EXT));
        }

        // 加载模式别名定义
        if (isset($mode['alias'])) {
            self::addClassMap(is_array($mode['alias']) ? $mode['alias'] : include $mode['alias']);
        }

        // 加载应用别名定义文件
        if (is_file(CONF_PATH . 'alias.php')) {
            self::addClassMap(include CONF_PATH . 'alias.php');
        }

        // 加载模式行为定义
        if (isset($mode['tags'])) {
            Hook::import(is_array($mode['tags']) ? $mode['tags'] : include $mode['tags']);
        }

        // 加载应用行为定义
        if (is_file(CONF_PATH . 'tags.php')) // 允许应用增加开发模式配置定义
        {
            Hook::import(include CONF_PATH . 'tags.php');
        }
    }

    /**
     * 加载语言包文件
     */
    private static function loadConfigFile()
    {
        // 加载框架底层语言包
        L(include THINK_PATH . 'Lang/' . strtolower(C('DEFAULT_LANG')) . '.php');

        // 调试模式加载系统默认的配置文件
        C(include THINK_PATH . 'Conf/debug.php');

        // 读取应用调试配置文件
        if (is_file(CONF_PATH . 'debug' . CONF_EXT)) {
            C(include CONF_PATH . 'debug' . CONF_EXT);
        }

        // 读取当前应用状态对应的配置文件
        if (APP_STATUS && is_file(CONF_PATH . APP_STATUS . CONF_EXT)) {
            C(include CONF_PATH . APP_STATUS . CONF_EXT);
        }

        // 设置系统时区
        date_default_timezone_set(C('DEFAULT_TIMEZONE'));
    }

    /**
     * 初始化文件存储方式
     */
    private static function initStorage()
    {
        Storage::connect(STORAGE_TYPE);
    }

    /**
     * 检查应用目录结构 如果不存在则自动创建
     */
    private static function checkAppDir()
    {
        if (C('CHECK_APP_DIR')) {
            $module = defined('BIND_MODULE') ? BIND_MODULE : C('DEFAULT_MODULE');
            if (!is_dir(APP_PATH . $module) || !is_dir(LOG_PATH)) {
                // 检测应用目录结构
                Build::checkDir($module);
            }
        }
    }

    /**
     * 注册命名空间别名
     * @param $namespace
     * @param string $original
     */
    public static function addNamespaceAlias($namespace, $original = '')
    {
        if (is_array($namespace)) {
            self::$namespaceAlias = array_merge(self::$namespaceAlias, $namespace);
        } else {
            self::$namespaceAlias[$namespace] = $original;
        }
    }


    /**
     * 注册自动加载机制
     * @param string $autoload
     */
    public static function register($autoload = '')
    {
        // 注册系统自动加载
        spl_autoload_register($autoload ?: 'Think\\Loader::autoload', true, true);

        // 初始化文件存储方式
        self::initStorage();

        // 读取应用模式配置数据
        self::readModeFile();

        // 引入 composer 第三方包自加载
        require ROOT_PATH . 'vendor/autoload.php';

        // 读取配置文件
        self::loadConfigFile();

        // 检查应用目录文件夹
        self::checkAppDir();

        // 注册命名空间定义
        self::addNamespace([
            'Think' => LIB_PATH . 'Think' . DS,
            'Behavior' => LIB_PATH . 'Behavior' . DS,
        ]);

        // 记录加载文件时间
        G('loadTime');
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string $name 字符串
     * @param integer $type 转换类型
     * @param bool $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    public static function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }

    /**
     * 解析应用类的类名
     * @param string $module 模块名
     * @param string $layer 层名 controller model ...
     * @param string $name 类名
     * @param bool $appendSuffix
     * @return string
     */
    public static function parseClass($module, $layer, $name, $appendSuffix = false)
    {
        $name  = str_replace(['/', '.'], '\\', $name);
        $array = explode('\\', $name);
        $class = self::parseName(array_pop($array), 1) . (App::$suffix || $appendSuffix ? ucfirst($layer) : '');
        $path  = $array ? implode('\\', $array) . '\\' : '';
        return App::$namespace . '\\' . ($module ? $module . '\\' : '') . $layer . '\\' . $path . $class;
    }

    /**
     * 实例化（分层）控制器 格式：[模块名/]控制器名
     * @param string $name         资源地址
     * @param string $layer        控制层名称
     * @param bool   $appendSuffix 是否添加类名后缀
     * @param string $empty        空控制器名称
     * @return Object|false
     * @throws ClassNotFoundException
     */
    public static function controller($name, $layer = 'controller', $appendSuffix = false, $empty = '')
    {
        if (false !== strpos($name, '\\')) {
            $class  = $name;
            $module = MODULE_NAME;
        } else {
            if (strpos($name, '/')) {
                list($module, $name) = explode('/', $name);
            } else {
                $module = MODULE_NAME;
            }
            $class = self::parseClass($module, $layer, $name, $appendSuffix);
        }
        if (class_exists($class)) {
            return App::invokeClass($class);
        } elseif ($empty && class_exists($emptyClass = self::parseClass($module, $layer, $empty, $appendSuffix))) {
            return new $emptyClass(Request::instance());
        }
    }


    /**
     * 远程调用模块的操作方法 参数格式 [模块/控制器/]操作
     * @param string       $url          调用地址
     * @param string|array $vars         调用参数 支持字符串和数组
     * @param string       $layer        要调用的控制层名称
     * @param bool         $appendSuffix 是否添加类名后缀
     * @return mixed
     */
    public static function action($url, $vars = [], $layer = 'controller', $appendSuffix = false)
    {
        $info   = pathinfo($url);
        $action = $info['basename'];
        $module = '.' != $info['dirname'] ? $info['dirname'] : CONTROLLER_NAME;
        $class  = self::controller($module, $layer, $appendSuffix);
        if ($class) {
            if (is_scalar($vars)) {
                if (strpos($vars, '=')) {
                    parse_str($vars, $vars);
                } else {
                    $vars = [$vars];
                }
            }
            return App::invokeMethod([$class, $action . C('ACTION_SUFFIX')], $vars);
        }
    }


    /**
     * 取得对象实例 支持调用类的静态方法
     * @param string $class 对象类名
     * @param string $method 类的静态方法名
     * @return object
     */
    public static function instance($class, $method = '')
    {
        $identify = $class . $method;
        if (!isset(self::$_instance[$identify])) {
            if (class_exists($class)) {
                $o = new $class();
                if (!empty($method) && method_exists($o, $method)) {
                    self::$_instance[$identify] = call_user_func(array(&$o, $method));
                } else {
                    self::$_instance[$identify] = $o;
                }

            } else {
                throw new ClassNotFoundException('class not exists:' . $class, $class);
            }

        }
        return self::$_instance[$identify];
    }

    /**
     * 初始化类的实例
     * @return void
     */
    public static function clearInstance()
    {
        self::$_instance = [];
    }
}
