<?php


/**
 * 处理插件钩子
 * @param string $hook 钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook, $params = array())
{
    \Think\Hook::listen($hook, $params);
}

/**
 * 获取插件类的类名
 * @param $name
 * @return string
 */
function get_addon_class($name)
{
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param $name
 * @return array
 */
function get_addon_config($name)
{
    $class = get_addon_class($name);
    if (class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    } else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param $url
 * @param array $param
 * @return string
 */
function addons_url($url, $param = array())
{
    $url = parse_url($url);
    $case = C('URL_CASE_INSENSITIVE');
    $addons = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if (isset($url['query'])) {
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons' => $addons,
        '_controller' => $controller,
        '_action' => $action,
    );
    $params = array_merge($params, $param); //添加额外参数
    return U('Addons/execute', $params);
}

/**
 * 自动验证,检测验证码
 * @param  string
 * @param  int
 * @return int
 */
function check_verify($code, $id = 1)
{
    $Verify = new \Think\Verify();
    $Verify->reset = false;
    return $Verify->check($code, $id);
}

/**
 * 自动验证,检测是否为空
 * @param  string
 * @return bool
 */
function check_empty($string)
{
    if (empty($string)) {
        return false;
    } else {
        return true;
    }
}

/**
 * 验证过期时间
 * @param $tokenTime
 * @return bool
 */
function check_token_time($tokenTime)
{
    if (!isset($tokenTime)) {
        return true;
    }
    $expireTime = $tokenTime + C("token_expire_time");
    return time() - $expireTime > 0 ? true : false;
}

/**
 * 生成api token
 * @param $userId
 * @param $tokenTime
 * @return String
 */
function generate_api_token($userId, $tokenTime)
{
    $tokenData = [
        "user_id" => $userId,
        "token_time" => $tokenTime
    ];
    return _encrypt(json_encode($tokenData));
}

/**
 * 检查url是否可以访问
 * @param $url
 * @return array
 */
function check_http_code($url)
{
    $ch = curl_init();
    $timeout = 200; // http请求超时200ms
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeout);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode === 200) {
        // 转换成毫秒
        $connectTime = curl_getinfo($ch, CURLINFO_CONNECT_TIME) * 1000;
    } else {
        $connectTime = -1;
    }
    // 关闭cURL资源，并且释放系统资源
    return ["http_code" => $httpCode, "connect_time" => $connectTime];
}

/**
 * 填充当前用户id
 * @return mixed
 */
function fill_created_by()
{
    return session("user_id");
}

/**
 * 设置项目id session
 * @param $projectId
 */
function set_project_id_session($projectId)
{
    session("project_id", $projectId);
}

/**
 * 判断字符串是否为纯字母
 * @param $str
 * @return bool
 */
function string_is_component($str)
{
    if (preg_match("/^[A-Za-z]/", $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 把数组转换成Json
 * @param $arr
 * @return string
 */
function array_to_json($arr)
{
    if (is_array($arr)) {
        $res_arr = json_encode($arr);
    } else {
        $res_arr = $arr;
    }
    return $res_arr;
}

/**
 * 检测元素是否为json
 * @param $string
 * @return bool
 */
function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * 判断数组是否为有重复元素
 * @param $arr
 * @return bool
 */
function check_arrunique($arr)
{
    if (count($arr) != count(array_unique($arr))) {
        return false;
    } else {
        return true;
    }
}

/**
 * 自动验证,检测cc是否超过6个
 * @param  string
 * @return bool
 */
function check_ccnumber($cc)
{
    $cc_arr = explode(',', $cc);
    if (count($cc_arr) > 6) {
        return false;
    } else {
        return true;
    }
}

/**
 * 加密密码
 * @param string $pass
 * @return bool|string
 */
function create_pass($pass = "")
{
    $PassHash = new \Org\Util\Phpass();
    $PassHash->PasswordHash(8, TRUE);
    return $PassHash->HashPassword($pass);
}

/**
 * 填充默认密码
 * @param string $pass
 * @return mixed|string
 */
function fill_default_pass($pass = "")
{
    // 获取默认密码
    if (empty($pass)) {
        $userService = new \Common\Service\UserService();
        $pass = $userService->getUserDefaultPassword();
    }
    return $pass;
}

/**
 * 验证密码
 * @param  string
 * @return bool
 */
function check_pass($password, $phpassword)
{
    $PassHash = new \Org\Util\Phpass();
    $PassHash->PasswordHash(8, TRUE);
    return $PassHash->CheckPassword($password, $phpassword);
}

/**
 * 判断登录名是否是邮箱地址
 * @param $login
 * @return bool
 */
function check_login_is_email($login)
{
    $checkmail = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
    if (preg_match($checkmail, $login)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 生成im登录验证密码
 * @param $password
 * @param $login
 * @return string
 */
function create_im_pass($password, $login)
{
    return md5(md5($password) . $login);
}

/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param Bool $isarry 是否是数组
 * @param String $skey 加密EKY
 * @return String
 */
function _encrypt($string = '', $isarry = false, $skey = null)
{
    $skey = $skey === null ? C('COOKIE_KEY') : $skey;
    $string = $isarry === true ? json_encode($string) : $string;
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value) {
        $key < $strCount && $strArr[$key] .= $value;
    }
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}

/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param Bool $isarry 是否是数组
 * @param String $skey 解密KEY
 * @return String
 */
function _decrypt($string = '', $isarry = false, $skey = null)
{
    try {
        $skey = $skey === null ? C('COOKIE_KEY') : $skey;
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value) {
            //$key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
            if ($key <= $strCount && array_key_exists($key, $strArr)) {
                if (strlen($strArr[$key]) === 2 && $strArr[$key][1] === $value) {
                    $strArr[$key] = $strArr[$key][0];
                } else {
                    throw new \Exception("error");
                }
            } else {
                throw new \Exception("error");
            }

        }
        $decode = base64_decode(join('', $strArr));
        $decode = $isarry === true ? json_decode($decode, true) : $decode;
    } catch (\Exception $e) {
        $decode = [];
    }
    return $decode;
}

/**
 * 返回语言包类型
 * @param  string
 * @return string
 */
function get_lang_type($lang)
{
    switch ($lang) {
        case 'zh-cn':
            $lang_type = 'zh-cn';
            break;
        case 'en-us':
            $lang_type = 'en-us';
            break;
        default:
            $lang_type = 'en-us';
    }
    return $lang_type;
}

/**
 * 返回当前语言设置
 * @return string
 */
function get_cookies_Lang()
{
    $lang = strtolower(cookie('think_language'));
    if ($lang == 'en-us') {
        return 'ui.lang.en';
    } else if ($lang == 'zh-cn') {
        return 'ui.lang.zh_CN';
    } else {
        return 'ui.lang.en';
    }
}

/**
 * 判断日期是否为今天
 * @param $date
 * @return int
 */
function is_today($date)
{
    $c_date = date('Y-m-d', $date);
    $today = date('Y-m-d');
    if ($c_date == $today) {
        return 1;
    } else {
        return 0;
    }
}

/**
 * 判断任务截至日期是否在捉急
 * @param $date
 * @param $days
 * @return string
 */
function is_hurry_date($date, $days)
{
    $section = $days * 86400;
    $now = time();
    $cnow = $date + $section;
    if ($cnow < $now) {
        $isHurry = 'hurry';
    } else {
        $isHurry = 'nohurry';
    }
    return $isHurry;
}

/**
 * 获取当前页面完整URL地址
 * @return string
 */
function get_full_url()
{
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 获取当前页面URL参数，并分组存储
 * @return array
 */
function get_url_param()
{
    $url = get_full_url();
    $urlArray = explode('/', $url);
    $length = count($urlArray) - 1;
    $paramArray = explode('.', $urlArray[$length]);
    if (strpos($paramArray[0], '-')) {
        $param = explode('-', $paramArray[0]);
    } else {
        $param = $paramArray[0];
    }
    return $param;
}

/**
 * 获取url页面锚点参数
 * @param $key
 * @param $getParam
 * @return array
 */
function get_page_url_anchors_param($key, $getParam)
{
    if (array_key_exists($key, $getParam)) {
        return explode("-", $getParam[$key]);
    } else {
        return [];
    }
}

/**
 * 拆分url地址参数
 * @param $urlParam
 * @return array
 */
function split_ajax_url_param($urlParam)
{
    $queryParts = explode('&', $urlParam);
    $params = [];
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }

    return $params;
}

/**
 * 将参数变为字符串
 * @param $arrayQuery
 * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
 */
function build_url_query($arrayQuery)
{
    $tmp = [];
    foreach ($arrayQuery as $k => $param) {
        $tmp[] = $k . '=' . $param;
    }
    $params = implode('&', $tmp);
    return $params;
}

/**
 * 判断是否是tab param
 * @param $page
 * @param $param
 * @param string $type
 * @return array
 */
function get_url_auth_param($page, $param, $type = "page")
{
    $urlParam = ["tab" => [], "param" => "", "project_id" => 0];
    switch ($page) {
        case "home_project_base":
        case "home_project_note":
        case "home_project_onset":
        case "home_project_file":
        case "home_project_file_commit":
        case "home_project_timelog":
        case "home_project_page":
            $getUrlParam = get_url_param();
            $urlParam["project_id"] = $getUrlParam[0];
            break;
        case "home_project_overview":
            $getUrlParam = get_url_param();
            $urlParam["project_id"] = $getUrlParam[0];
            $urlAnchorsGetParam = get_page_url_anchors_param("tab", $param);
            if (!empty($urlAnchorsGetParam)) {
                $urlParam["tab"] = $urlAnchorsGetParam[0];
            }
            break;
        case "home_project_media":
            $getUrlParam = get_url_param();
            $urlParam["project_id"] = $getUrlParam[0];
            $urlAnchorsGetParam = get_page_url_anchors_param("scene", $param);
            if (count($urlAnchorsGetParam) >= 2) {
                $urlParam["tab"] = $urlAnchorsGetParam[1];
            }
            break;
        case "home_details_index":
            $getUrlParam = get_url_param();
            $urlAnchorsGetParam = get_page_url_anchors_param("tab", $param);
            $urlParam["project_id"] = $getUrlParam[1];
            break;
        case "home_project_entity":
            if ($type === "page") {
                $getUrlParam = get_url_param();
                if (count($getUrlParam) >= 2) {
                    $urlParam["param"] = $getUrlParam[0];
                }
                $urlParam["project_id"] = $getUrlParam[1];
            } else {
                $urlParam["param"] = $param[0];
            }
            break;
    }

    return $urlParam;
}

/**
 * 获取ajax来源地址
 * @param $currentModule
 * @param $referer
 * @return array
 */
function get_ajax_url_referer($referer)
{
    $baseUrl = U('/', '', true, true);
    $refererParam = str_replace($baseUrl, '', $referer);
    $refererArray = explode("/", $refererParam);
    $methodArray = explode(".", $refererArray[count($refererArray) - 1]);

    $refererPageData = ["page" => "", "param" => "", "tab" => []];

    $getParam = [];

    // 判断端当前连接所属模块
    if (strpos($refererParam, 'admin') !== false) {
        $currentModule = "admin";
    } else {
        $currentModule = "home";
    }

    // 默认路由处理
    switch (count($refererArray)) {
        case 1:
            if ($methodArray[0] === "admin") {
                $refererPageData["page"] = "{$currentModule}_index_index";
            } else {
                $refererPageData["page"] = "{$currentModule}_{$methodArray[0]}_index";
            }
            break;
        case 2:
            if ($currentModule === "admin") {
                $refererPageData["page"] = "{$refererArray[0]}_{$methodArray[0]}_index";
            } else {
                if ($refererArray[0] !== "details") {
                    if (!empty($methodArray[0])) {
                        $refererPageData["page"] = "{$currentModule}_{$refererArray[0]}_{$methodArray[0]}";
                    } else {
                        $refererPageData["page"] = "{$currentModule}_{$refererArray[0]}_index";
                    }
                } else {
                    $refererPageData["page"] = "home_details_index";
                }
            }
            break;
        case 3:
            $projectUrlActions = ['overview', 'media', 'base', 'entity', 'onset', 'timelog', 'file', 'file_commit', 'note'];
            $isProjectUrl = false;
            foreach ($projectUrlActions as $action) {
                if (strpos($refererParam, "project/{$action}") !== false) {
                    // 项目页面
                    $refererPageData["page"] = "home_{$refererArray[0]}_{$refererArray[1]}";
                    $isProjectUrl = true;
                    break;
                }
            }
            if (!$isProjectUrl) {
                $refererPageData["page"] = "{$refererArray[0]}_{$refererArray[1]}_{$methodArray[0]}";
            }
            break;
    }

    if (strpos($refererParam, '.html')) {
        if (strpos($methodArray[1], '?') !== false && empty($getParam)) {
            $getParam = split_ajax_url_param(explode("?", $methodArray[1])[1]);
        }
    }

    if ($refererPageData["page"] === "home_project_entity") {
        $getParam = explode("-", $methodArray[0]);
    }

    $urlParam = get_url_auth_param($refererPageData["page"], $getParam, 'ajax');
    $refererPageData["tab"] = $urlParam["tab"];
    $refererPageData["param"] = $urlParam["param"];

    return $refererPageData;
}

/**
 *  生成详情页面访问full url
 * @param $projectId
 * @param $moduleId
 * @param $itemId
 * @return string
 */
function generate_details_page_url($projectId, $moduleId, $itemId)
{
    $detailsUrl = U('/details');
    $baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('.html', '', $detailsUrl);
    $url = "{$baseUrl}/{$moduleId}-{$projectId}-{$itemId}.html";
    return $url;
}

/**
 * 找回密码url
 * @param $data
 * @return string
 */
function generate_forget_page_url($data)
{
    $detailsUrl = U('login/resetPassword');
    $param = $data["id"] . "," . $data["last_forget"] . "," . $data["forget_token"];
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $detailsUrl . "?token=" . _encrypt($param);
    return $url;
}

/**
 * 组装详情页面Tab权限
 * @param $param
 * @param array $tabAllowList
 * @return array
 */
function generate_details_tab_auth($param, $tabAllowList = [])
{
    if (!empty($tabAllowList)) {
        return [
            "base" => $param["rule_tab_base"],
            "note" => $param["rule_tab_notes"],
            "info" => $param["rule_tab_info"],
            "history" => $param["rule_tab_history"],
            "onset" => $param["rule_tab_onset"],
            "cloud_disk" => $param["rule_tab_cloud_disk"]
        ];
    } else {
        return [
            "base" => $param["rule_tab_base"],
            "note" => $param["rule_tab_notes"],
            "info" => $param["rule_tab_info"],
            "history" => $param["rule_tab_history"],
            "onset" => $param["rule_tab_onset"],
            "file" => $param["rule_tab_file"],
            "file_commit" => $param["rule_tab_file_commit"],
            "correlation_base" => $param["rule_tab_correlation_task"],
            "horizontal_relationship" => $param["rule_tab_horizontal_relationship"],
            "cloud_disk" => $param["rule_tab_cloud_disk"]
        ];
    }
}

/**
 * 去除文件名后缀
 * @param $filename
 * @return string
 */
function remove_file_suffix($filename)
{
    $FileExt = substr(strrchr($filename, '.'), 1);
    $newname = basename($filename, "." . $FileExt);
    return $newname;
}

/**
 * base64图片保存到临时路径
 * @param $img
 * @param $tpye
 * @return mixed
 * @throws Exception
 */
function create_base64_Img($img, $tpye)
{
    $fileNameRandom = string_random(8) . time(); //产生一个随机文件名
    $resdata = fill_imgfile_content($img, $tpye, $fileNameRandom);
    return $resdata["full_path"];
}

/**
 * 创建临时图片文件
 * @param $img
 * @param $tpye
 * @return array
 * @throws Exception
 */
function create_temp_img($img, $tpye)
{
    $baseName = string_random(8) . time();
    $fileNameRandom = $baseName . "_temp"; //产生一个随机文件名
    $resData = fill_imgfile_content($img, $tpye, $fileNameRandom);
    $resData["base_name"] = $baseName;
    return $resData;
}

/**
 * 保存图片Base64图片
 * @param $img
 * @param $tpye
 * @param $fileNameRandom
 * @return array
 */
function fill_imgfile_content($img, $tpye, $fileNameRandom)
{
    //图片解码
    $base64Body = substr(strstr($img, ','), 1);
    $data = base64_decode($base64Body);
    //生成上传路径
    $imageSERVER = $_SERVER['DOCUMENT_ROOT'];
    $fileName = $imageSERVER . __ROOT__ . "/Uploads/temp/" . $fileNameRandom . '.' . $tpye;
    file_put_contents($fileName, $data);
    $response = array(
        "full_path" => $fileName,
        "file_name" => $fileNameRandom,
        "ext" => $tpye
    );
    return $response;
}

/**
 * 读取图片文件，转换成base64编码格式
 * @param $image
 * @return string
 */
function transcode_to_base64_Img($image)
{
    $IMG_SERVER = $_SERVER['DOCUMENT_ROOT'];
    $image_file = $IMG_SERVER . '/' . $image;
    $image_info = getimagesize($image_file);
    $base64_image = "data:{$image_info['mime']};base64," . chunk_split(base64_encode(file_get_contents($image_file)));
    return $base64_image;
}

/**
 * 随机字符串加数字
 * @param $length
 * @return string
 * @throws Exception
 */
function string_random($length)
{
    $int = $length / 2;
    $bytes = random_bytes($int);
    $string = bin2hex($bytes);
    return $string;
}

/**
 * 生成短信验证码
 * @param int $length
 * @return int
 */
function create_sms_code($length = 6)
{
    $min = pow(10, ($length - 1));
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}

/*
 * secret key 密钥生成 32位
 */
function random_hash_keys($string, $created)
{
    $data = $string . $created . string_random(10);
    $key = hash('md5', $data);
    return $key;
}

/**
 * 按照指定长度对字符串进行折行处理
 * @param $string
 * @param $Length
 * @return string
 */
function string_wordwrap($string, $Length)
{
    $Arry = explode(" ", $string);
    $NewString = '';
    foreach ($Arry as $Line) {
        if (strlen($Line) > $Length)
            $NewString .= wordwrap($Line, $Length, " ", true);
        else
            $NewString .= " " . $Line;
    }
    return $NewString;
}

/**
 * select返回的数组进行整数映射转换
 * @param array $map 映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 * @param $data
 * @param array $map
 * @return array
 */
function int_to_string(&$data, $map = array('status' => array(1 => '正常', -1 => '删除', 0 => '禁用', 2 => '未审核', 3 => '草稿')))
{
    if ($data === false || $data === null) {
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row) {
        foreach ($map as $col => $pair) {
            if (isset($row[$col]) && isset($pair[$row[$col]])) {
                $data[$key][$col . '_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}


/**
 * 对查询结果集进行排序，asc正向排序 desc逆向排序 nat自然排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * @return array|bool
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer[$i] = &$data[$field];
        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc':// 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val)
            $resultSet[] = &$list[$key];
        return $resultSet;
    }
    return false;
}

/**
 * 转换二维数组为一维数组
 * @param $field
 * @param $array
 * @param string $indexKey
 * @return array
 */
function convert_select_data($field, $array, $indexKey = '')
{
    $convertData = [];
    if (!empty($indexKey)) {
        $useIndexKey = $indexKey;
    } else {
        $useIndexKey = $field;
    }
    foreach ($array as $item) {
        array_push($convertData, $item[$useIndexKey]);
    }
    return $convertData;
}

/*
 * 去除数组重复
 */
function unique_arr($filterData)
{
    $filterData = array_flip(array_flip($filterData));
    $newFilterData = array();
    foreach ($filterData as $k => $v) {
        if ($v == '') {
            unset($filterData[$k]);
        }
        $newFilterData[] = $filterData[$k];
    }
    return $newFilterData;
}

/**
 * 批量更新数据预处理
 * @param $up_data
 * @return array
 */
function batch_handle_data($up_data)
{
    $innate_data = array();
    $custom_data = array();
    foreach ($up_data as $value) {
        switch ($value["part"]) {
            case "innate":
                $innate_data[$value["field"]] = $value["value"];
                break;
            case "custom":
                switch ($value["edit"]) {
                    case 20://datebox
                        $pval = strtotime($value["value"]);
                        break;
                    default:
                        $pval = $value["value"];
                        break;
                }
                $temp = array(
                    "fid" => $value["fid"],
                    "alias" => $value["field"],
                    "value" => $pval,
                    "edit" => $value["edit"],
                    "pos" => "batch",
                );
                array_push($custom_data, $temp);
                break;
        }
    }
    $response = array(
        "innate" => $innate_data,
        "custom" => $custom_data,
    );
    return $response;
}

/**
 * 强制转换字符串为整型, 对数字或数字字符串无效
 * @param  mixed
 */
function intval_string(&$value)
{
    if (!is_numeric($value)) {
        $value = intval($value);
    }
}

/**
 * 生成uuid
 * @param string $prefix
 * @return mixed
 * @throws Exception
 */
function create_uuid($prefix = '')
{
    if (function_exists("uuid_create")) {
        return uuid_create();
    } else {
        return Webpatser\Uuid\Uuid::generate()->string;
    }
}

/**
 * 填充mysql文本类型字段默认值
 * @param $value
 * @return string
 */
function fill_text_default_val($value = '')
{
    if (!isset($value)) {
        return '';
    }
    return $value;
}

/**
 * 格式化版本号
 * @param $version
 * @return string
 */
function version_format($version)
{
    if (!strpos($version, 'V')) {
        return "V" . sprintf("%03d", $version);
    } else {
        return $version;
    }
}

/**
 * 获取时间md5
 * @param $date
 * @param bool $is_full
 * @return string
 */
function get_date_group_md5($date, $is_full = false)
{
    if ($is_full) {
        return md5($date);
    } else {
        $dateFormat = date('Y-m-d', strtotime($date));
        return md5($dateFormat);
    }
}

/**
 * 下划线单个字母大写返回分隔符自定义
 * @param $string
 * @param string $prefix
 * @return string
 */
function string_initial_letter($string, $prefix = '')
{
    if (strpos($string, '_')) {
        $stringArray = explode('_', $string);
        $doneString = [];
        foreach ($stringArray as $item) {
            array_push($doneString, ucfirst($item));
        }
        return join($prefix, $doneString);
    } else {
        return ucfirst($string);
    }
}

/**
 *  下划线转驼峰
 * 思路:
 * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
 * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
 * @param $uncamelized_words
 * @param string $separator
 * @return string
 */
function camelize($uncamelized_words, $separator = '_')
{
    $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
    return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
}

/**
 * 获取table名称
 * @param $code
 * @return string
 */
function get_table_name($code)
{
    return ucwords(camelize($code));
}


/**
 * 驼峰命名转下划线命名
 * 思路:
 * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
 * @param $camelCaps
 * @param string $separator
 * @return string
 */
function un_camelize($camelCaps, $separator = '_')
{
    return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
}

/**
 * 获取媒体资源类型
 * @param $mtype
 * @return mixed
 */
function get_media_type($mtype)
{
    $mtype_name = "";
    switch ($mtype) {
        case 10://图片
            $mtype_name = L("Images");
            break;
        case 20://视频
            $mtype_name = L("Video");
            break;
        case 30://模型
            $mtype_name = L("Model");
            break;
    }
    return $mtype_name;
}

/**
 * 获取版本状态
 * @param $statusId
 * @return mixed
 */
function get_version_status($statusId)
{
    switch ($statusId) {
        case "no_review":
            //未审核
            return [
                "id" => "no_review",
                "name" => L("NoReview")
            ];
        case "reviewed":
            //已审核
            return [
                "id" => "reviewed",
                "name" => L("Reviewed")
            ];
    }
}

/**
 * 判断目录是否存在,不存在则创建
 * @param $path
 * @param $mode
 * @return string
 */
function create_directory($path, $mode = 0777)
{
    if (is_dir($path)) {
        //判断目录存在否，存在不创建
        return "目录'" . $path . "'已经存在";
        //已经存在则输入路径
    } else { //不存在则创建目录
        $re = mkdir($path, $mode, true);
        //第三个参数为true即可以创建多极目录
        if ($re) {
            return "目录创建成功";
        } else {
            return "目录创建失败";
        }
    }
}

/**
 * 删除指定目录下所有文件及其本身
 * @param $dir
 * @return bool
 */
function delete_directory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

/**
 * 删除指定目录下的文件，不删除目录文件夹
 * @param $dir
 */
function empty_folder($dir)
{
    //删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                empty_folder($fullpath);
            }
        }
    }
    closedir($dh);
}

/**
 * 清空指定目录下的文件内容，不删除目录文件夹
 * @param $dir
 */
function bath_empty_file_content($dir)
{
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                file_put_contents($fullpath, "");
            } else {
                bath_empty_file_content($fullpath);
            }
        }
    }
    closedir($dh);
}

/**
 * 文件夹大小
 * @param $dir
 * @return int
 */
function get_directory_size($dir)
{
    $handle = opendir($dir);
    if (empty($sizeResult)) {
        $sizeResult = 0;
    }
    while (false !== ($FolderOrFile = readdir($handle))) {
        if ($FolderOrFile != "." && $FolderOrFile != "..") {
            if (is_dir("$dir/$FolderOrFile")) {
                $sizeResult += get_directory_size("$dir/$FolderOrFile");
            } else {
                $sizeResult += filesize("$dir/$FolderOrFile");
            }
        }
    }
    closedir($handle);
    return $sizeResult;
}

/**
 * 获取星期方法
 * @param $time
 * @return mixed
 */
function get_week($time)
{
    $weekarray = array("sun", "mon", "tue", "wed", "thu", "fri", "sat");
    return $weekarray[date('w', $time)];
}

/**
 * 时间友好型提示风格化（即微博中的XXX小时前、昨天等等）
 * 即微博中的 XXX 小时前、昨天等等, 时间超过 $time_limit 后返回按 out_format 的设定风格化时间戳
 * @param  string
 * @param  int
 * @param  int
 * @param  string
 * @param  array
 * @param  int
 * @return string
 *
 */
function date_friendly($time_style, $timestamp, $time_limit = 604800, $out_format = 'Y-m-d H:i', $formats = null, $time_now = null)
{
    if ($time_style == 'N') {
        return date($out_format, $timestamp);
    }

    if (!$timestamp) {
        return false;
    }

    if ($formats == null) {
        $formats = array('YEAR' => '%s ' . L('Year_ago'),
            'MONTH' => '%s ' . L('Month_ago'),
            'DAY' => '%s ' . L('Day_ago'),
            'HOUR' => '%s ' . L('Hours_ago'),
            'MINUTE' => '%s ' . L('Minutes_ago'),
            'SECOND' => '%s ' . L('Seconds_ago')
        );
    }

    $time_now = $time_now == null ? time() : $time_now;
    $seconds = $time_now - $timestamp;

    if ($seconds == 0) {
        $seconds = 1;
    }

    if (!$time_limit OR $seconds > $time_limit) {
        return date($out_format, $timestamp);
    }

    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $days = floor($hours / 24);
    $months = floor($days / 30);
    $years = floor($months / 12);

    if ($years > 0) {
        $diffFormat = 'YEAR';
    } else {
        if ($months > 0) {
            $diffFormat = 'MONTH';
        } else {
            if ($days > 0) {
                $diffFormat = 'DAY';
            } else {
                if ($hours > 0) {
                    $diffFormat = 'HOUR';
                } else {
                    $diffFormat = ($minutes > 0) ? 'MINUTE' : 'SECOND';
                }
            }
        }
    }

    $dateDiff = null;

    switch ($diffFormat) {
        case 'YEAR' :
            $dateDiff = sprintf($formats[$diffFormat], $years);
            break;
        case 'MONTH' :
            $dateDiff = sprintf($formats[$diffFormat], $months);
            break;
        case 'DAY' :
            $dateDiff = sprintf($formats[$diffFormat], $days);
            break;
        case 'HOUR' :
            $dateDiff = sprintf($formats[$diffFormat], $hours);
            break;
        case 'MINUTE' :
            $dateDiff = sprintf($formats[$diffFormat], $minutes);
            break;
        case 'SECOND' :
            $dateDiff = sprintf($formats[$diffFormat], $seconds);
            break;
    }
    return $dateDiff;
}

/**
 * 获取当前时间所在星期的开始时间与结束时间戳
 * @return array
 */
function get_current_week_range()
{
    $ret = array();
    $timestamp = mktime(0, 0, 0);
    $w = strftime('%u', $timestamp);
    $ret['sdate'] = $timestamp - ($w - 1) * 86400;
    $ret['edate'] = strtotime('+1 day', $timestamp + (7 - $w) * 86400 - 1);
    return $ret;
}

/**
 * 获取当前时间所在天的开始时间与结束时间戳
 * @param $timestamp
 * @return array
 */
function get_current_day_range($timestamp)
{
    $ret = array();
    $ret['sdate'] = strtotime(date('Y-m-d', $timestamp));
    $ret['edate'] = $ret['sdate'] + 86399;
    return $ret;
}

/**
 * 获取当前时间所在星期的每天时间戳
 */
function get_current_week_each_day()
{
    $ret = array();
    $timestamp = mktime(0, 0, 0);
    $w = strftime('%u', $timestamp);
    $ret['Mon'] = $timestamp - ($w - 1) * 86400;
    $ret['Tue'] = $timestamp - ($w - 2) * 86400;
    $ret['Wed'] = $timestamp - ($w - 3) * 86400;
    $ret['Thu'] = $timestamp - ($w - 4) * 86400;
    $ret['Fri'] = $timestamp - ($w - 5) * 86400;
    $ret['Sta'] = $timestamp - ($w - 6) * 86400;
    $ret['Sun'] = $timestamp - ($w - 7) * 86400;
    $ret['sdate'] = $ret['Mon'];
    $ret['edate'] = strtotime('+1 day', $ret['Sun'] - 1);
    return $ret;
}


/**
 * 获取指定日期所在星期的开始时间与结束时间(时间戳)
 * @param $date
 * @return array
 */
function get_week_time_range($date)
{
    $ret = array();
    $timestamp = strtotime($date . " 00:00:00");
    $w = strftime('%u', $timestamp);
    $ret['sdate'] = $timestamp - ($w - 1) * 86400;
    $ret['edate'] = $timestamp + (7 - $w) * 86400;
    return $ret;
}

/**
 * 获取指定日期所在星期的开始时间与结束时间
 * @param $date
 * @return array
 */
function get_week_range($date)
{
    $ret = array();
    $timestamp = strtotime($date);
    $w = strftime('%u', $timestamp);
    $ret['sdate'] = date('Y-m-d 00:00:00', $timestamp - ($w - 1) * 86400);
    $ret['edate'] = date('Y-m-d 23:59:59', $timestamp + (7 - $w) * 86400);
    return $ret;
}

/**
 * 获取指定日期所在月的开始日期与结束日期
 * @param $date
 * @return array
 */
function get_month_range($date)
{
    $ret = array();
    $timestamp = strtotime($date);
    $mdays = date('t', $timestamp);
    $ret['sdate'] = date('Y-m-1 00:00:00', $timestamp);
    $ret['edate'] = date('Y-m-' . $mdays . ' 23:59:59', $timestamp);
    return $ret;
}

/**
 * 获取指定日期所在月的开始日期与结束日期(时间戳)
 * @param $date
 * @return array
 */
function get_month_time($date)
{
    $ret = array();
    $timestamp = strtotime($date);
    $mdays = date('t', $timestamp);
    $ret['sdate'] = strtotime(date('Y-m-1 00:00:00', $timestamp));
    $ret['edate'] = strtotime(date('Y-m-' . $mdays . ' 23:59:59', $timestamp));
    return $ret;
}

/**
 * 获得一个月有多少周
 * @param $month
 * @return array
 */
function get_month_weeks($month)
{
    $weekinfo = array();
    $end_date = date('d', strtotime($month . ' +1 month -1 day'));
    for ($i = 1; $i < $end_date; $i = $i + 7) {
        $w = date('N', strtotime($month . '-' . $i));

        $weekinfo[] = array(date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 1) . ' days')), date('Y-m-d', strtotime($month . '-' . $i . ' +' . (7 - $w) . ' days')));
    }
    return $weekinfo;
}

/**
 * 获取当前时间之后第N个自然月最后一天的日期(时间戳)
 * @param $num
 * @return false|string
 */
function get_interval_month($time, $num)
{
    $result_day = "";
    $start = intval(date("m", $time));
    for ($i = 0; $i < $num; $i++) {
        if (($start + $i) > 12) {
            $result_day = date("Y-" . (($start + $i) - 12) . "-01", strtotime("+1 year"));
        } else {
            $result_day = date("Y-" . ($start + $i) . "-01", $time);
        }
        $day = date("t", strtotime($result_day));
        $result_day = date("Y-m-d 23:59:59", (strtotime($result_day) + ($day - 1) * 24 * 3600));
    }
    $result_time = strtotime($result_day) + 1;
    return $result_time;
}

/**
 * 获得某个时间段内，所有的自然月
 * @param array $data
 * @return array
 */
function get_all_month(array $data)
{
    $firstdate = $data[0];
    $lastdate = $data[1];
    $start = intval(date("m", strtotime($firstdate)));
    $end = intval(date("m", strtotime($lastdate)));
    $result = array();
    for ($i = $start; $i <= $end; $i++) {
        $firstday = date("Y-" . $i . "-01", strtotime($firstdate));
        $lastday = date("Y-m-d", strtotime("$firstday +1 month -1 day"));
        array_push($result, array('firstday' => $i == $start ? $firstdate : $firstday, 'lastday' => $i == $end ? $lastdate : $lastday));
    }
    return $result;
}

/**
 * 给定日期之间的周末天数
 * @param $start_date
 * @param $end_date
 * @param bool $is_workday
 * @return float|int
 */
function get_weekend_days($start_date, $end_date, $is_workday = false)
{
    if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
    $start_reduce = $end_add = 0;
    $start_N = date('N', strtotime($start_date));
    $start_reduce = ($start_N == 7) ? 1 : 0;
    $end_N = date('N', strtotime($end_date));
    in_array($end_N, array(6, 7)) && $end_add = ($end_N == 7) ? 2 : 1;
    $alldays = abs(strtotime($end_date) - strtotime($start_date)) / 86400 + 1;
    $weekend_days = floor(($alldays + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;
    if ($is_workday) {
        $workday_days = $alldays - $weekend_days;
        return $workday_days;
    }
    return $weekend_days;
}

/**
 * 获取指定日期所在年的开始日期与结束日期(时间戳)
 * @param $date
 * @return array
 */
function get_year_time($date)
{
    $year = date("Y", strtotime($date));
    $ret = array();
    $ret["sdate"] = strtotime($year . "-01-01 00:00:00");
    $ret["edate"] = strtotime($year . "-12-31 23:59:59") + 1;
    return $ret;
}

/**
 * 一年月份
 * @param $month
 * @return array
 */
function year_month_list($month)
{
    switch ($month) {
        case 1:
            return [
                "id" => 1,
                "name" => L('PleaseSelect')
            ];
        default:
            return [
                "id" => $month,
                "name" => ($month / 10) . L('Month')
            ];
    }
}

/**
 * 判断是否是合法日期
 * @param $date
 * @param string $format
 * @return bool
 */
function validate_date_format($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * 判断是不是时间戳
 * @param $timestamp
 * @return bool
 */
function is_timestamp($timestamp)
{
    $check = (is_int($timestamp) OR is_float($timestamp))
        ? $timestamp
        : (string)(int)$timestamp;
    return ($check === $timestamp)
        AND ((int)$timestamp <= PHP_INT_MAX)
        AND ((int)$timestamp >= ~PHP_INT_MAX);
}

/**
 * 获取Progress 颜色
 * @param $progress
 * @return string
 */
function get_progress_color($progress)
{
    $procolor = "";
    switch ($progress) {
        case 'blocked'://Blocked 暂停 #e94310 红色
            $procolor = 'e94310';
            break;
        case 'not_started'://NotStarted 未开始 #cacaca 灰色
            $procolor = 'cacaca';
            break;
        case 'in_progress'://InProgress 进行中 #11b0e9 蓝色
            $procolor = '11b0e9';
            break;
        case 'daily'://Daily 审片  #afd440 淡蓝色
            $procolor = '23ddeb';
            break;
        case 'done'://Done 完成  #afd440 绿色
            $procolor = 'afd440';
            break;
        case 'hide'://Hide 隐藏  #000000 黑色
            $procolor = '000000';
            break;
    }
    return $procolor;
}

/**
 * 事项完成状态
 * @param $job_id
 * @return array
 */
function get_job_status($job_id)
{
    $status_arr = array();
    switch ($job_id) {
        case 10://Done
            $status_arr["name"] = L("Done");
            $status_arr["color"] = "#13CE66";
            break;
        case 20://Deleted
            $status_arr["name"] = L("Downloaded");
            $status_arr["color"] = "#99A9BF";
            break;
        case 30://Deleted
            $status_arr["name"] = L("Deleted");
            $status_arr["color"] = "#FF4949";
            break;
    }
    return $status_arr;
}

/**
 * 货币类型
 * @param $currencyId
 * @return array
 */
function currency_list($currencyId)
{
    $currencyData = [];
    switch ($currencyId) {
        case 10://人民币 CNY
            $currencyData = [
                "currency_id" => 10,
                "currency_name" => L("CNY"),
                "currency_code" => "CNY",
            ];
            break;
        case 20://美元 USD
            $currencyData = [
                "currency_id" => 20,
                "currency_name" => L("USD"),
                "currency_code" => "USD",
            ];
            break;
        case 30://日元 JPY
            $currencyData = [
                "currency_id" => 30,
                "currency_name" => L("JPY"),
                "currency_code" => "JPY",
            ];
            break;
        case 40://欧元 EUR
            $currencyData = [
                "currency_id" => 40,
                "currency_name" => L("EUR"),
                "currency_code" => "EUR",
            ];
            break;
        case 50://英镑 GBP
            $currencyData = [
                "currency_id" => 50,
                "currency_name" => L("GBP"),
                "currency_code" => "GBP",
            ];
            break;
        case 60://韩元 KRW
            $currencyData = [
                "currency_id" => 60,
                "currency_name" => L("KRW"),
                "currency_code" => "KRW",
            ];
            break;
        case 70://港元 HKD
            $currencyData = [
                "currency_id" => 70,
                "currency_name" => L("HKD"),
                "currency_code" => "HKD",
            ];
            break;
        case 80://澳元 AUD
            $currencyData = [
                "currency_id" => 80,
                "currency_name" => L("AUD"),
                "currency_code" => "AUD",
            ];
            break;
        case 90://加元 CAD
            $currencyData = [
                "currency_id" => 90,
                "currency_name" => L("CAD"),
                "currency_code" => "CAD",
            ];
            break;
    }
    return $currencyData;
}

/**
 * 获取货币符号
 * @param $currency_id
 * @return string
 */
function currency_sign($currency_id)
{
    $icon = "";
    switch ($currency_id) {
        case 10://人民币
        case 30://日元
            $icon = "¥";
            break;
        case 20://美元
        case 80://加元
        case 90://加元
            $icon = "$";
            break;
        case 40://欧元
            $icon = "€";
            break;
        case 50://英镑
            $icon = "￡";
            break;
        case 70://韩元
            $icon = "₩";
            break;
    }
    return $icon;
}

/**
 * 二维数组根据键值排序, 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 * @param $arr
 * @param $sort
 * @param $v
 * @return mixed
 */
function two_dimension_sort($arr, $sort, $v)
{
    if ($sort == "0") {
        $sort = "SORT_ASC";
    } elseif ($sort == "1") {
        $sort = "SORT_DESC";
    }
    foreach ($arr as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrsort[$key][$uniqid] = $value;
        }
    }
    if ($sort) {
        array_multisort($arrsort[$v], constant($sort), $arr);
    }
    return $arr;
}

/**
 * 项目priority 转换 L()调用语言包
 * @param $id
 * @return mixed
 */
function get_priority($id)
{
    switch ($id) {
        case 'normal':
            return [
                'id' => 'normal',
                'name' => L('Normal')
            ];
        case 'urgent':
            return [
                'id' => 'urgent',
                'name' => L('Urgent')
            ];
        case 'high':
            return [
                'id' => 'high',
                'name' => L('High')
            ];
        case 'medium':
            return [
                'id' => 'medium',
                'name' => L('Medium')
            ];
        case 'low':
            return [
                'id' => 'low',
                'name' => L('Low')
            ];
    }
}

/**
 * 动态type 转换 L()调用语言包
 * @param $type
 * @return array
 */
function get_note_type($type)
{
    switch ($type) {
        case 'audio':
            return [
                'id' => 'audio',
                'name' => L('audio')
            ];
        case 'text':
            return [
                'id' => 'text',
                'name' => L('text')
            ];
        case 'video':
            return [
                'id' => 'video',
                'name' => L('video')
            ];
    }
}

/**
 * 动作type 转换 L()调用语言包
 * @param $type
 * @return array
 */
function get_action_type($type)
{
    switch ($type) {
        case 'launcher':
            return [
                'id' => 'launcher',
                'name' => L('launcher')
            ];
        case 'plugin':
            return [
                'id' => 'plugin',
                'name' => L('plugin')
            ];
        case 'tool':
            return [
                'id' => 'tool',
                'name' => L('tool')
            ];
        case 'service':
            return [
                'id' => 'service',
                'name' => L('service')
            ];
    }
}

/**
 * 总做type 转换 L()调用语言包
 * @param $type
 * @return array
 */
function get_tag_type($type)
{
    switch ($type) {
        case 'system':
            return [
                'id' => 'system',
                'name' => L('system')
            ];
        case 'review':
            return [
                'id' => 'review',
                'name' => L('review')
            ];
        case 'publish':
            return [
                'id' => 'publish',
                'name' => L('publish')
            ];
        case 'approve':
            return [
                'id' => 'approve',
                'name' => L('approve')
            ];
        case 'custom':
            return [
                'id' => 'custom',
                'name' => L('custom')
            ];
    }
}

/**
 * 获取邮件安全链接下拉列表
 * @param $secureId
 * @return array
 */
function get_smtp_secure($secureId)
{
    switch ($secureId) {
        case 'ssl':
            return [
                'id' => 'ssl',
                'name' => 'SSL'
            ];
        case 'tls':
            return [
                'id' => 'tls',
                'name' => 'TLS'
            ];
    }
}


/**
 * 获取用户状态列表
 * @param $statusId
 * @return mixed|string
 */
function get_user_status($statusId)
{
    switch ($statusId) {
        case "in_service":
            return [
                "id" => "in_service",
                "name" => L('In_Service'),
            ];
        case "departing":
            return [
                "id" => "departing",
                "name" => L('Dimission'),
            ];
    }
}

/**
 * 获取选择框语言包
 * @param $checkStatus
 * @return mixed
 */
function get_checkbox_lang($checkStatus)
{
    switch ($checkStatus) {
        case "off":
            return L("UnChecked");
        case "on":
            return L("Checked");
    }
}

/**
 * 获取onset unit名
 *
 * @param $unit
 * @return mixed
 */
function check_onset_unit($letter)
{
    return [
        'id' => $letter,
        'name' => L('Unit_' . $letter)
    ];
}

/**
 * 自定义字段类型
 * @param $type_id
 * @return mixed|string
 */
function custom_field_type($type_id)
{
    $type_name = '';
    switch ($type_id) {
        case 5://input
            $type_name = L("Input");
            break;
        case 10://Combobox
            $type_name = L("Combobox");
            break;
        case 15://Checkbox
            $type_name = L("Checkbox");
            break;
        case 20://Datebox
            $type_name = L("Datebox");
            break;
        case 30://Text
            $type_name = L("Text");
            break;
        case 60://Text
            $type_name = L("Summarize");
            break;
    }
    return $type_name;
}

/**
 * 判断性别
 * @param $id
 * @return array
 */
function get_user_sex($id)
{
    switch ($id) {
        case "male":
            return [
                'id' => "male",
                'name' => L('Male')
            ];
        case "female":
            return [
                'id' => "female",
                'name' => L('Female')
            ];
        case "secret":
            return [
                'id' => "secret",
                'name' => L('secret')
            ];
    }
}

/**
 * 判断语言包
 * @param $id
 * @return array
 */
function get_lang_package($id)
{
    switch ($id) {
        case "zh-cn":
            return [
                'id' => "zh-cn",
                'name' => "中文（简体）"
            ];
        case "en-us":
            return [
                'id' => "en-us",
                'name' => 'English'
            ];
    }
}


/**
 * 判断语言
 * @param $langId
 * @return mixed|string
 */
function get_userinfo_lang($langId)
{
    $langName = "";
    switch ($langId) {
        case "zh-cn":
            $langName = L('Lang_Chinese');
            break;
        case "en-us":
            $langName = L('Lang_English');
            break;
//        case 30:
//            $langName = L('Lang_Spanish');
//            break;
//        case 40:
//            $langName = L('Lang_Japanese');
//            break;
//        case 50:
//            $langName = L('Lang_Korean');
//            break;
//        case 60:
//            $langName = L('Lang_Cantonese');
//            break;
    }
    return $langName;
}

/**
 * 格式化用户使用语言
 * @param $lang
 * @return string
 */
function format_userinfo_lang($lang)
{
    $langIds = explode(",", $lang);
    $langString = [];
    foreach ($langIds as $langId) {
        array_push($langString, get_userinfo_lang($langId));
    }
    return join(",", $langString);
}

/**
 * 获取当前用户所在时差
 * @param $userId
 * @return int|mixed
 */
function get_user_timezone_inter($userId)
{
    $userService = new \Common\Service\UserService();
    $userSystemConfig = $userService->getUserSystemConfig($userId);
    if (empty($userSystemConfig["timezone"])) {
        $inter = C("DEFAULT_TIMEZONE_CUSTOM");//默认时区
    } else {
        $inter = get_timezone_inter($userSystemConfig["timezone"]);
    }
    session("user_timezone_inter", $inter);
    return $inter;
}

/**
 * string格式化用户使用语言
 * @param $time
 * @param int $type
 * @param bool $isGantt
 * @return false|string
 */
function get_format_date($time, $type = 0, $isGantt = false)
{
    if (!empty($time) && is_numeric($time)) {
        if (!session("?user_timezone_inter")) {
            $inter = get_user_timezone_inter(session("user_id"));
        } else {
            $inter = session("user_timezone_inter");
        }

        $timestamp = $time + (3600 * $inter);

        switch ($type) {
            case 0:
                if ($isGantt) {
                    $date = gmdate("d-m-Y", $timestamp);
                } else {
                    $date = gmdate("Y-m-d", $timestamp);
                }
                break;
            case 2:
                $date = gmdate("Y-m-d H:i", $timestamp);
                break;
            case 1:
            default:
                $date = gmdate("Y-m-d H:i:s", $timestamp);
                break;
        }

        return $date;
    } else {
        return '';
    }
}

/**
 * @param $month
 * @return int
 */
function get_work_month($month)
{
    switch ($month) {
        case 10:
            return $month / 10;
        default:
            return 0;
    }
}

/**
 * 获取Degree 名称
 * @param $degree
 * @return mixed
 */
function get_degree_name($degree)
{
    switch ($degree) {
        case 'high_school':
            $degree_name = L("High_School");
            break;
        case 'associate':
            $degree_name = L("Associate_Degree");
            break;
        case 'bachelor':
            $degree_name = L("Bachelor_Degree");
            break;
        case 'master':
            $degree_name = L("Master_Degree");
            break;
        case 'mba':
            $degree_name = L("MBA_Degree");
            break;
        case 'jd':
            $degree_name = L("JD_Degree");
            break;
        case 'md':
            $degree_name = L("MD_Degree");
            break;
        case 'phd':
            $degree_name = L("PH_Degree");
            break;
        case 'egd':
            $degree_name = L("EG_Degree");
            break;
        case 'other':
        default:
            $degree_name = L("Other");
            break;
    }
    return $degree_name;
}

/**
 * Calendar 日历事项类型
 * @param $type
 * @return array
 */
function get_calendar_type($type)
{
    switch ($type) {
        case 'holiday':
            return [
                "id" => 'holiday',
                "name" => L('Holiday')
            ];
        case 'event':
            return [
                "id" => 'event',
                "name" => L('Event')
            ];
        case 'overtime':
            return [
                "id" => 'overtime',
                "name" => L('Overtime')
            ];
        case 'non_workday':
            return [
                "id" => 'non_workday',
                "name" => L('noWorkday')
            ];

    }
}

/**
 * 排期类型
 * @param $type
 * @return array
 */
function plan_type($type)
{
    switch ($type) {
        case 'vacation':
            return [
                "id" => 'vacation',
                "name" => L('Vacation')
            ];
        case 'project':
            return [
                "id" => 'project',
                "name" => L('Project')
            ];
    }
}

/**
 * 排期类型
 * @param $type
 * @return array
 */
function datebox_type($type)
{
    switch ($type) {
        case 'datebox':
            return [
                "id" => 'datebox',
                "name" => L('Date_Input_Box')
            ];
        case 'datetimebox':
            return [
                "id" => 'datetimebox',
                "name" => L('DateTime_Input_Box')
            ];
    }
}

/**
 * tag 类型
 * @param $type
 * @return array
 */
function tag_type($type)
{
    switch ($type) {
        case 'system':
            return [
                "id" => 'system',
                "name" => L('System')
            ];
        case 'file':
            return [
                "id" => 'file',
                "name" => L('File')
            ];
        case 'review':
            return [
                "id" => 'review',
                "name" => L('Review')
            ];
        case 'approve':
            return [
                "id" => 'approve',
                "name" => L('Approve')
            ];
        case 'publish':
            return [
                "id" => 'publish',
                "name" => L('Publish')
            ];
        case 'dir_template':
            return [
                "id" => 'dir_template',
                "name" => L('Dir_Template')
            ];
        case 'custom':
            return [
                "id" => 'custom',
                "name" => L('Custom')
            ];
    }
}


/**
 * 系统模式 类型
 * @param $type
 * @return array
 */
function system_mode_type($type)
{
    switch ($type) {
        case 'strack':
            return [
                "id" => 'strack',
                "name" => 'Strack'
            ];
        case 'liber':
            return [
                "id" => 'liber',
                "name" => 'Liber'
            ];
    }
}

/**
 * Calendar 日历事项类型
 * @param $type
 * @return array
 */
function get_scope_action($id)
{
    switch ($id) {
        case 'all':
            return [
                "id" => 'all',
                "name" => L('All_Active_Project')
            ];
        case 'current':
            return [
                "id" => 'current',
                "name" => L('Current_Project')
            ];
    }
}


/**
 * 获取job类型
 * @param $type
 * @return array
 */
function check_job_type($type)
{
    switch ($type) {
        case 10:
            return [
                "id" => 10,
                "name" => L('Excel')
            ];
        case 20:
            return [
                "id" => 20,
                "name" => L('PDF')
            ];
        case 30:
            return [
                "id" => 20,
                "name" => L('XML')
            ];
    }
}

/**
 * 判断onset 是内景还是外景
 * @param $intExt
 * @return mixed
 */
function onset_int_ext($intExt)
{
    switch ($intExt) {
        case 10:
            return [
                'id' => 10,
                'intExt' => L('intExt_int')
            ];
        case 20:
            return [
                'id' => 20,
                'intExt' => L('intExt_ext')
            ];
    }
}


/**
 * 判断onset 是夜戏还是日戏
 * @param $intExt
 * @return mixed
 */
function onset_day_night($id)
{
    switch ($id) {
        case 10:
            return [
                "id" => 10,
                "name" => L('dayNight_day')
            ];
        case 20:
            return [
                "id" => 20,
                "name" => L('dayNight_dusk')
            ];
        case 30:
            return [
                "id" => 30,
                "name" => L('dayNight_night')
            ];
        case 40:
            return [
                "id" => 40,
                "name" => L('dayNight_dawn')
            ];
    }
}

/**
 * 获取时区差值
 * @param $id
 * @return int
 */
function get_timezone_inter($id)
{
    switch ($id) {
        case "Etc/GMT+12":
            return 0;
        case "Etc/GMT+11":
            return -11;
        case "Etc/GMT+10":
            return -10;
        case "Etc/GMT+9":
            return -9;
        case "Etc/GMT+8":
            return -8;
        case "Etc/GMT+7":
            return -7;
        case "Etc/GMT+6":
            return -6;
        case "Etc/GMT+5":
            return -5;
        case "Etc/GMT+4":
            return -4;
        case "Canada/Newfoundland":
            return -3.3;
        case "Etc/GMT+3":
            return -3;
        case "Etc/GMT+2":
            return -2;
        case "Etc/GMT+1":
            return -1;
        case "Etc/GMT":
            return 0;
        case "Etc/GMT-1":
            return 1;
        case "Etc/GMT-2":
            return 2;
        case "Etc/GMT-3":
            return 3;
        case "Iran":
            return 3.3;
        case "Etc/GMT-4":
            return 4;
        case "Asia/Kabul":
            return 4.3;
        case "Etc/GMT-5":
            return 5;
        case "Asia/Kolkata":
            return 5.3;
        case "Etc/GMT-6":
            return 6;
        case "Etc/GMT-7":
            return 7;
        case "Etc/GMT-8":
        case "PRC":
            return 8;
        case "Etc/GMT-9":
            return 9;
        case "Etc/GMT-10":
            return 10;
        case "Etc/GMT-11":
            return 11;
        case "Etc/GMT-12":
            return 12;
        case "Etc/GMT-13":
            return 13;
        case "Etc/GMT-14":
            return 14;
    }
}

/**
 * 时区数据
 * @return array
 */
function timezone_data()
{
    $timezoneData = [
        [
            "val" => "Etc/GMT+12",
            "zone" => L("Timezone_Kwajalein")
        ],
        [
            "val" => "Etc/GMT+11",
            "zone" => L("Timezone_Midway")
        ],
        [
            "val" => "Etc/GMT+10",
            "zone" => L("Timezone_Hawaii")
        ],
        [
            "val" => "Etc/GMT+9",
            "zone" => L("Timezone_Alaska")
        ],
        [
            "val" => "Etc/GMT+8",
            "zone" => L("Timezone_Pacific")
        ],
        [
            "val" => "Etc/GMT+7",
            "zone" => L("Timezone_American_Mountain")
        ],
        [
            "val" => "Etc/GMT+6",
            "zone" => L("Timezone_Central_USA")
        ],
        [
            "val" => "Etc/GMT+5",
            "zone" => L("Timezone_EST_USA")
        ],
        [
            "val" => "Etc/GMT+4",
            "zone" => L("Timezone_Atlantic")
        ],
        [
            "val" => "Canada/Newfoundland",
            "zone" => L("Timezone_Newfoundland")
        ],
        [
            "val" => "Etc/GMT+3",
            "zone" => L("Timezone_Brazil")
        ],
        [
            "val" => "Etc/GMT+2",
            "zone" => L("Timezone_Central_Atlantic")
        ],
        [
            "val" => "Etc/GMT+1",
            "zone" => L("Timezone_Azores")
        ],
        [
            "val" => "Etc/GMT",
            "zone" => L("Timezone_Casablanca")
        ],
        [
            "val" => "Etc/GMT-1",
            "zone" => L("Timezone_Brussels")
        ],
        [
            "val" => "Etc/GMT-2",
            "zone" => L("Timezone_Kaliningrad")
        ],
        [
            "val" => "Etc/GMT-3",
            "zone" => L("Timezone_Baghdad")
        ],
        [
            "val" => "Iran",
            "zone" => L("Timezone_Teheran")
        ],
        [
            "val" => "Etc/GMT-4",
            "zone" => L("Timezone_Abu_Dhab")
        ],
        [
            "val" => "Asia/Kabul",
            "zone" => L("Timezone_Kabul")
        ],
        [
            "val" => "Etc/GMT-5",
            "zone" => L("Timezone_Tashkent")
        ],
        [
            "val" => "Asia/Kolkata",
            "zone" => L("Timezone_Kolkata")
        ],
        [
            "val" => "Etc/GMT-6",
            "zone" => L("Timezone_Colomba")
        ],
        [
            "val" => "Etc/GMT-7",
            "zone" => L("Timezone_Bangkok")
        ],
        [
            "val" => "Etc/GMT-8",
            "zone" => L("Timezone_Beijing")
        ],
        [
            "val" => "Etc/GMT-9",
            "zone" => L("Timezone_Tokyo")
        ],
        [
            "val" => "Etc/GMT-10",
            "zone" => L("Timezone_Melbourne")
        ],
        [
            "val" => "Etc/GMT-11",
            "zone" => L("Timezone_Caledonia")
        ],
        [
            "val" => "Etc/GMT-12",
            "zone" => L("Timezone_Zealand")
        ],
        [
            "val" => "Etc/GMT-13",
            "zone" => L("Timezone_Kamchatka")
        ],
        [
            "val" => "Etc/GMT-14",
            "zone" => L("Timezone_Christmas")
        ]
    ];
    return $timezoneData;
}

/**
 * 项目milestone 转换 L()调用语言包
 * @param $id
 * @return mixed
 */
function get_milestone_lang($id)
{
    switch ($id) {
        case 1:
            return L('True');
        case 0:
            return L('False');
    }
}

/**
 * 图标数据
 * @return array
 */
function icon_data()
{
    return [
        ['id' => '0', 'icon' => 'icon-uniE675'],
        ['id' => '1', 'icon' => 'icon-uniEA7D'],
        ['id' => '2', 'icon' => 'icon-uniEA7E'],
        ['id' => '3', 'icon' => 'icon-uniEAB1'],
        ['id' => '4', 'icon' => 'icon-uniEACC'],
        ['id' => '5', 'icon' => 'icon-uniEAB0'],
        ['id' => '6', 'icon' => 'icon-uniEAAF'],
        ['id' => '7', 'icon' => 'icon-uniEA46'],
        ['id' => '8', 'icon' => 'icon-uniEA3E'],
        ['id' => '9', 'icon' => 'icon-uniEA3F'],
        ['id' => '10', 'icon' => 'icon-uniEA40'],
        ['id' => '11', 'icon' => 'icon-uniEA36'],
        ['id' => '12', 'icon' => 'icon-uniEA37'],
        ['id' => '13', 'icon' => 'icon-uniF00D'],
        ['id' => '14', 'icon' => 'icon-uniEA39'],
        ['id' => '15', 'icon' => 'icon-uniEA30'],
        ['id' => '16', 'icon' => 'icon-uniEA03'],
        ['id' => '17', 'icon' => 'icon-uniEA04'],
        ['id' => '18', 'icon' => 'icon-uniEA00'],
        ['id' => '19', 'icon' => 'icon-uniEA01'],
        ['id' => '20', 'icon' => 'icon-uniEA02'],
        ['id' => '21', 'icon' => 'icon-uniE9FD'],
        ['id' => '22', 'icon' => 'icon-uniE9FC'],
        ['id' => '23', 'icon' => 'icon-uniE9EC'],
        ['id' => '24', 'icon' => 'icon-uniE9F5'],
        ['id' => '25', 'icon' => 'icon-uniE9DF'],
        ['id' => '26', 'icon' => 'icon-uniE9E0'],
        ['id' => '27', 'icon' => 'icon-uniE9DC'],
        ['id' => '28', 'icon' => 'icon-uniE9D5'],
        ['id' => '29', 'icon' => 'icon-uniE9D0'],
        ['id' => '30', 'icon' => 'icon-uniE9C2'],
        ['id' => '31', 'icon' => 'icon-uniE9A7'],
        ['id' => '32', 'icon' => 'icon-uniE994'],
        ['id' => '33', 'icon' => 'icon-uniE986'],
        ['id' => '34', 'icon' => 'icon-uniE96C'],
        ['id' => '35', 'icon' => 'icon-uniE922'],
        ['id' => '36', 'icon' => 'icon-uniE91E'],
        ['id' => '37', 'icon' => 'icon-uniE739'],
        ['id' => '38', 'icon' => 'icon-uniE721'],
        ['id' => '39', 'icon' => 'icon-uniE6A9'],
        ['id' => '40', 'icon' => 'icon-uniE6AA'],
        ['id' => '41', 'icon' => 'icon-uniE682'],
        ['id' => '42', 'icon' => 'icon-uniE67D'],
        ['id' => '43', 'icon' => 'icon-uniE67E'],
        ['id' => '44', 'icon' => 'icon-uniE677'],
        ['id' => '45', 'icon' => 'icon-uniE663'],
        ['id' => '46', 'icon' => 'icon-uniE64C'],
        ['id' => '47', 'icon' => 'icon-uniE645'],
        ['id' => '48', 'icon' => 'icon-uniE61E'],
        ['id' => '49', 'icon' => 'icon-uniE61F'],
        ['id' => '50', 'icon' => 'icon-uniE60C'],
        ['id' => '51', 'icon' => 'icon-uniE60F'],
        ['id' => '52', 'icon' => 'icon-uniE605'],
        ['id' => '53', 'icon' => 'icon-uniE68C'],
        ['id' => '54', 'icon' => 'icon-uniE69B'],
        ['id' => '55', 'icon' => 'icon-uniE6A5'],
        ['id' => '56', 'icon' => 'icon-uniE69A'],
        ['id' => '57', 'icon' => 'icon-uniE6A7'],
        ['id' => '58', 'icon' => 'icon-uniE6B9'],
        ['id' => '59', 'icon' => 'icon-uniE6BF'],
        ['id' => '60', 'icon' => 'icon-uniE8C8'],
        ['id' => '61', 'icon' => 'icon-uniE8AC'],
        ['id' => '62', 'icon' => 'icon-uniE8BD'],
        ['id' => '63', 'icon' => 'icon-uniE8C9'],
        ['id' => '64', 'icon' => 'icon-uniF01E'],
        ['id' => '65', 'icon' => 'icon-uniF025'],
        ['id' => '66', 'icon' => 'icon-uniF032'],
        ['id' => '67', 'icon' => 'icon-uniF045'],
        ['id' => '68', 'icon' => 'icon-uniF046'],
        ['id' => '69', 'icon' => 'icon-uniF044'],
        ['id' => '70', 'icon' => 'icon-uniF042'],
        ['id' => '71', 'icon' => 'icon-uniF041'],
        ['id' => '72', 'icon' => 'icon-uniF055'],
        ['id' => '73', 'icon' => 'icon-uniF056'],
        ['id' => '74', 'icon' => 'icon-uniF057'],
        ['id' => '75', 'icon' => 'icon-uniF069'],
        ['id' => '76', 'icon' => 'icon-uniF071'],
        ['id' => '77', 'icon' => 'icon-uniF0AD'],
        ['id' => '78', 'icon' => 'icon-uniF0C0'],
        ['id' => '79', 'icon' => 'icon-uniF0ED'],
        ['id' => '80', 'icon' => 'icon-uniF192'],
        ['id' => '81', 'icon' => 'icon-uniF191'],
        ['id' => '82', 'icon' => 'icon-uniF1DB'],
        ['id' => '83', 'icon' => 'icon-uniF1E7'],
        ['id' => '84', 'icon' => 'icon-uniF209'],
        ['id' => '85', 'icon' => 'icon-uniF20A'],
        ['id' => '86', 'icon' => 'icon-uniF20C'],
        ['id' => '87', 'icon' => 'icon-uniF219'],
        ['id' => '88', 'icon' => 'icon-uniE6482'],
        ['id' => '89', 'icon' => 'icon-uniE6162'],
        ['id' => '90', 'icon' => 'icon-uniF21D'],
        ['id' => '91', 'icon' => 'icon-uniEACF'],
        ['id' => '92', 'icon' => 'icon-uniF1F8'],
        ['id' => '93', 'icon' => 'icon-uniF1DA'],
        ['id' => '94', 'icon' => 'icon-uniF1C0'],
        ['id' => '95', 'icon' => 'icon-uniF1B8'],
        ['id' => '96', 'icon' => 'icon-uniF1A6'],
        ['id' => '97', 'icon' => 'icon-uniF199'],
        ['id' => '98', 'icon' => 'icon-uniF190'],
        ['id' => '99', 'icon' => 'icon-uniF04A'],
        ['id' => '100', 'icon' => 'icon-uniF04E'],
        ['id' => '101', 'icon' => 'icon-uniF068'],
        ['id' => '102', 'icon' => 'icon-uniF1B2'],
        ['id' => '103', 'icon' => 'icon-small_shots'],
        ['id' => '104', 'icon' => 'icon-icon_shots'],
        ['id' => '105', 'icon' => 'icon-uniF1E9']
    ];
}


/**
 * 状态从属关系
 * @return array
 */
function status_corresponds_data()
{
    return [
        ['id' => 'blocked', 'name' => L('Blocked')],
        ['id' => 'not_started', 'name' => L('NotStarted')],
        ['id' => 'in_progress', 'name' => L('InProgress')],
        ['id' => 'daily', 'name' => L('Daily')],
        ['id' => 'done', 'name' => L('Done')],
        ['id' => 'hide', 'name' => L('Hide')]
    ];
}


/**
 * 时间范围列表
 * @return array
 */
function time_range_data()
{
    return [
        ['id' => 'all', 'name' => L('All_Time')],
        ['id' => 'current_week', 'name' => L('Current_Week')],
        ['id' => 'current_month', 'name' => L('Current_Month')],
        ['id' => 'within_six_months', 'name' => L('Within_Six_Months')],
        ['id' => 'within_a_year', 'name' => L('Within_A_Year')],
        ['id' => 'a_year_ago', 'name' => L('A_Year_Ago')]
    ];
}

function transfer_time_data($id)
{
    $time = time();
    $date = [];
    switch ($id) {
        case "current_week":
            $beginThisWeek = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
            $date = ["BETWEEN", [$beginThisWeek, $time]];
            break;
        case "current_month":
            $beginThisMonths = strtotime(date('Y-m-d 0:0:0', mktime(0, 0, 0, date('n'), 1, date('Y'))));
            $date = ["BETWEEN", [$beginThisMonths, $time]];
            break;
        case "within_six_months":
            $beginThisSixMonths = mktime(0, 0, 0, date('m', strtotime("-6 month")), 1, date('Y', strtotime("-6 month")));
            $date = ["BETWEEN", [$beginThisSixMonths, $time]];
            break;
        case "within_a_year":
            $beginThisYear = strtotime(date("Y", time()) . "-1" . "-1");
            $date = ["BETWEEN", [$beginThisYear, $time]];
            break;
        case "a_year_ago":
            $beginThisYear = strtotime(date("Y", time()) . "-1" . "-1");
            $beginYearAgo = strtotime("-1 year");
            $date = ["BETWEEN", [$beginYearAgo, $beginThisYear]];
            break;
    }
    return $date;
}

/**
 * 数据结构类型
 * @return array
 */
function schema_type_data()
{
    return [
        ['id' => 'system', 'name' => L('System')],
        ['id' => 'project', 'name' => L('Project')]
    ];
}

/**
 * 状态从属关系
 * @return array
 */
function schema_connect_type_data()
{
    return [
        ['id' => 'has_one', 'name' => L('Has_One')],//一对一关联，HAS_ONE
        ['id' => 'belong_to', 'name' => L('Belong_To')],//一对一关联，BELONGS_TO
        ['id' => 'has_many', 'name' => L('Has_Many')],//一对多关联 HAS_MANY
        ['id' => 'many_to_many', 'name' => L('Many_To_Many')]//多对多关联
    ];
}

/**
 * 状态从属关系语言包
 */
function status_corresponds_lang($statusId)
{
    switch ($statusId) {
        case 'blocked':
            return L('Blocked');
        case 'not_started':
            return L('NotStarted');
        case 'in_progress':
            return L('InProgress');
        case 'daily':
            return L('Daily');
        case 'done':
            return L('Done');
        case 'hide':
            return L('Hide');
    }
}

/**
 * 权限分类
 * @return array
 */
function auth_category_data()
{
    return [
        ['category_id' => 'project', 'category_name' => L('Project')],
        ['category_id' => 'view', 'category_name' => L('View')],
        ['category_id' => 'column', 'category_name' => L('Column')]
    ];
}


/**
 * tab 标签栏配置
 * @param $id
 * @return array
 */
function tab_config($id)
{
    switch ($id) {
        case 'base'://任务
            return [
                'tab_id' => 'base',
                'name' => L('Task')
            ];
        case 'note'://动态
            return [
                'tab_id' => 'note',
                'name' => L('Notes')
            ];
        case 'info'://信息
            return [
                'tab_id' => 'info',
                'name' => L('Info')
            ];
        case 'file'://文件
            return [
                'tab_id' => 'file',
                'name' => L('File')
            ];
        case 'file_commit'://文件提交批次
            return [
                'tab_id' => 'file_commit',
                'name' => L('File_Commit')
            ];
        case 'history'://历史记录
            return [
                'tab_id' => 'history',
                'name' => L('History')
            ];
        case 'onset'://Onset 现场数据信息
            return [
                'tab_id' => 'onset',
                'name' => L('OnSet')
            ];
        case 'onset_att'://Onset 现场数据附件信息
            return [
                'tab_id' => 'onset_att',
                'name' => L('OnSet_Att')
            ];
        case 'reference':// 现场参考
            return [
                'tab_id' => 'reference',
                'name' => L('Reference')
            ];
        case 'version'://版本 task可以选择
            return [
                'tab_id' => 'version',
                'name' => L('Version')
            ];
        case 'publish'://版本 task可以选择
            return [
                'tab_id' => 'publish',
                'name' => L('Publish')
            ];
        case 'correlation_base'://关联任务 task可以选择
            return [
                'tab_id' => 'correlation_base',
                'name' => L('Correlation_Task')
            ];
        case 'entity_child'://关联任务 task可以选择
            return [
                'tab_id' => 'entity_child',
                'name' => L('Entity_Child')
            ];
    }
}

/**
 * 生成实体Tab列表
 * @param $childData
 * @param $parentModuleId
 * @return array
 */
function generate_entity_child_tab_data($childData, $parentModuleId)
{
    return [
        'tab_id' => "entity_child_{$childData["code"]}",
        'name' => L(string_initial_letter($childData["code"], '_')),
        'module_id' => $childData["id"],
        'src_module_id' => $childData["id"],
        'dst_module_id' => $parentModuleId,
        'type' => 'entity_child',
        'module_type' => $childData["type"],
        'table' => 'Entity',
        'group' => L("Child"),
        'module_code' => $childData["code"]
    ];
}

/**
 * 获取云盘菜单配置
 * @param string $active
 * @param int $projectId
 * @return array
 */
function build_cloud_disk_menu_data($active = "no", $projectId = 0)
{
    if ($projectId > 0) {
        $url = rebuild_url(U('/project/page'), 'cloud_disk-' . $projectId);
    } else {
        $url = U('/page/cloud_disk');
    }

    $menuData = [
        "module_id" => 'cloud_disk',
        "name" => L("Cloud_Disk"),
        "code" => 'cloud_disk',
        "type" => 'other_page',
        'url' => $url,
        'active' => $active
    ];
    return $menuData;
}

/**
 * 获取其他内嵌页面的图标
 * @param $moduleCode
 * @return string
 */
function get_other_page_icon($moduleCode)
{
    $icon = '';
    switch ($moduleCode) {
        case "cloud_disk":
            $icon = 'icon-uniE6D7';
            break;
    }
    return $icon;
}


/**
 * 或者/并且
 */
function or_and($id)
{
    switch ($id) {
        case 'and':
            return [
                'id' => 'and',
                'name' => L("L_AND")
            ];
        case 'or':
            return [
                'id' => 'or',
                'name' => L("L_OR")
            ];
    }
}

/**
 * 是或者否
 */
function yse_no($id)
{
    switch ($id) {
        case 'no':
            return [
                'id' => 'no',
                'name' => L('TNo')
            ];
        case 'yes':
            return [
                'id' => 'yes',
                'name' => L('TYes')
            ];
    }
}


/**
 * 排序类型
 */
function sort_type($id)
{
    switch ($id) {
        case 'asc':
            return [
                'id' => 'asc',
                'name' => L("Sort_Asc")
            ];
        case 'desc':
            return [
                'id' => 'desc',
                'name' => L("Sort_Desc")
            ];
    }
}

/**
 * 过滤条件标签颜色
 * @param $id
 * @return array
 */
function filter_color($id)
{
    return [
        'id' => $id,
        'name' => L('Color_' . ucwords($id))
    ];
}

/**
 * 是否置顶
 */
function stick_type($id)
{
    switch ($id) {
        case 'no':
            return [
                'id' => 'no',
                'name' => L('No_Stick')
            ];
        case 'yes':
            return [
                'id' => 'yes',
                'name' => L('Stick'),
            ];
    }
}

/**
 * 输入掩码规则
 * @param $id
 * @return array
 */
function input_mask_rule($id)
{
    switch ($id) {
        case "arbitrary":
            // 任意值 *
            return [
                'id' => 'arbitrary',
                'name' => L('Arbitrary_Mask')
            ];
        case "integer_no_range":
            // 正整数不限制范围
            return [
                'id' => 'integer_no_range',
                'name' => L('Integer_No_Range_Mask')
            ];
        case "letter_no_range":
            // 字母不限制范围
            return [
                'id' => 'letter_no_range',
                'name' => L('Letter_No_Range_Mask')
            ];
        case "url":
            // 网络地址
            return [
                'id' => 'url',
                'name' => L('URL_Mask')
            ];
        case "ip":
            // ip地址
            return [
                'id' => 'ip',
                'name' => L('IP_Mask')
            ];
        case "email":
            // 邮箱地址
            return [
                'id' => 'email',
                'name' => L('Email_Mask')
            ];
        case "mac":
            // MAC地址
            return [
                'id' => 'mac',
                'name' => L('MAC_Mask')
            ];
        case "decimal":
            // 小数
            return [
                'id' => 'decimal',
                'name' => L('Decimal_Mask')
            ];
        case "integer":
            // 整数
            return [
                'id' => 'integer',
                'name' => L('Integer_Mask')
            ];
        case "percentage":
            // 百分比
            return [
                'id' => 'percentage',
                'name' => L('Percentage_Mask')
            ];
        case "phone":
            // 手机号码
            return [
                'id' => 'phone',
                'name' => L('Phone_Mask')
            ];
        case "range":
            // 数字范围（支持负数）
            return [
                'id' => 'range',
                'name' => L('Range_Mask')
            ];
        case "alphaDash":
            // 值是否为字母和数字，下划线_及破折号-
            return [
                'id' => 'alphaDash',
                'name' => L('alphaDash_Mask')
            ];
        case "resolution":
            // 分辨率
            return [
                'id' => 'resolution',
                'name' => L('Resolution_Mask')
            ];
        case "timecode":
            // 时间码
            return [
                'id' => 'timecode',
                'name' => L('Timecode_Mask')
            ];
        case "cropping":
            // 长宽比
            return [
                'id' => 'cropping',
                'name' => L('Cropping_Mask')
            ];
    }
}


/**
 * 公共还是私有
 */
function public_type($id)
{
    switch ($id) {
        case 'no':
            return [
                'id' => 'no',
                'name' => L('Private')
            ];
        case 'yes':
            return [
                'id' => 'yes',
                'name' => L('Public')
            ];
    }
}

/**
 * 获取动态模型对应表名
 * @param $type
 * @return string
 */
function get_module_model($type)
{
    switch ($type) {
        case "assembly":
        case "entity":
            return "Entity";
        case "task":
            return "Task";
    }
}

/**
 * 获取表全名
 * @param $tableName
 * @return string
 */
function get_table_full($tableName)
{
    switch (strtolower($tableName)) {
        case "assembly":
        case "entity":
            return 'strack_entity';
        case "task":
            return 'strack_task';
    }
}

/**
 * 重新组装生成url
 * @param $url
 * @param $ext
 * @return string
 */
function rebuild_url($url, $ext)
{
    $urlBase = str_replace('.html', '', $url);
    return $urlBase . '/' . $ext . '.html';
}

/**
 * 对二维数组进行分组
 * @param $arr
 * @param $key
 * @return array
 */
function array_group_by($arr, $key)
{
    $grouped = [];
    foreach ($arr as $value) {
        $grouped[$value[$key]][] = $value;
    }

    if (func_num_args() > 2) {
        $args = func_get_args();
        foreach ($grouped as $key => $value) {
            $param = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$key] = call_user_func_array('array_group_by', $param);
        }
    }
    return $grouped;
}

/**
 * 数组排序
 * @param $arr
 * @param $key
 * @param string $type
 * @return array
 */
function array_sort_by($arr, $key, $type = 'asc')
{
    $keyValue = [];
    foreach ($arr as $k => $value) {
        $keyValue[$k] = $value[$key];
    }
    if ($type == 'asc') {
        asort($keyValue);
    } else {
        arsort($keyValue);
    }
    reset($keyValue);

    $sortData = [];
    foreach ($keyValue as $k => $value) {
        $sortData[$k] = $arr[$k];
    }
    return $sortData;
}

/**
 * 对象转数组
 * @param $object
 * @return mixed
 */
function object_to_array(&$object)
{
    $object = json_decode(json_encode($object), true);
    return $object;
}

/**
 * 下载远程图片
 * @param $fileUrl
 * @param $saveTo
 * @param int $timeout
 * @param string $types
 * @return bool|int
 */
function download_remote_picture($fileUrl, $saveTo, $timeout = 1000, $types = "'.gif|.jpeg|.jpg.|.png|.bmp'")
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fileUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);    //注意，毫秒超时一定要设置这个
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
    $fileContent = curl_exec($ch);
    curl_close($ch);
    $downloadedFile = fopen($saveTo, 'w');
    fwrite($downloadedFile, $fileContent);
    fclose($downloadedFile);
    if (file_exists($saveTo)) {
        if ($info = @getimagesize($saveTo)) {
            return true;
        }
        $ext = image_type_to_extension($info['2']);
        return stripos($types, $ext);
    } else {
        return false;
    }

}

/**
 * 替换字符串为指定的值
 * @param $string
 * @param $beReplaceList (替换列表)
 * @return mixed
 */
function replace_string_to_specified_value($string, array $beReplaceList)
{
    foreach ($beReplaceList as $key => $value) {
        $string = str_replace($key, $value, $string);
    }
    return $string;
}

/**
 * 检查字段是否在
 * @param $fields
 * @return bool
 */
function check_table_fields($fields)
{
    $tableFields = [
        "id",
        "name",
        "code",
        "engine",
        "module_id",
        "project_id",
        "type",
        "config",
        "author",
        "version",
        "frequency",
        "created_by",
        "created",
        "uuid",
        "role_id",
        "auth_id",
        "page",
        "param",
        "permission",
        "lang",
        "variable_id",
        "module_code",
        "auth_group_id",
        "auth_node_id",
        "module",
        "public",
        "rules",
        "entity_id",
        "entity_module_id",
        "status_id",
        "step_id",
        "priority",
        "start_time",
        "end_time",
        "duration",
        "plan_start_time",
        "plan_end_time",
        "plan_duration",
        "description",
        "json",
        "link_id",
        "stick",
        "parent_id",
        "link_note_ids",
        "text",
        "file_commit_id",
        "last_updated",
        "token",
        "action_id",
        "pattern",
        "disk_id",
        "rule",
        "record",
        "path",
        "parent_module_id",
        "workflow_id",
        "table",
        "field",
        "md5_name",
        "md5",
        "file_type_id",
        "diagram",
        "frame_range",
        "check_list",
        "ext",
        "dir_template_code",
        "color",
        "user_id",
        "src_link_id",
        "src_module_id",
        "dst_link_id",
        "dst_module_id",
        "project_template_id",
        "domain_controllers",
        "base_dn",
        "admin_username",
        "admin_password",
        "port",
        "ssl",
        "tls",
        "dn_whitelist",
        "thumb",
        "size",
        "media_server_id",
        "request_url",
        "upload_url",
        "access_key",
        "secret_key",
        "active",
        "icon",
        "number",
        "node_config",
        "schema_id",
        "client_id",
        "client_secret",
        "redirect_uri",
        "expires",
        "scope",
        "access_token",
        "refresh_token",
        "clip_name",
        "frames",
        "source_file_date",
        "registration_date",
        "tc_in_point",
        "tc_out_point",
        "in_out_duration",
        "audio_tc_offsets",
        "tc_start",
        "tc_end",
        "reel",
        "look_source",
        "look_source_name",
        "cdl_nodes",
        "sat_nodes",
        "lut_nodes",
        "codec",
        "file_type",
        "resolution",
        "color_space",
        "iso",
        "whitepoint",
        "tint",
        "f_shot",
        "t_stop",
        "shutter",
        "shutter_degree",
        "lens",
        "filter",
        "recorder_model",
        "serial_number",
        "episode",
        "scene",
        "shot",
        "take",
        "camera",
        "shot_descriptors",
        "shootting_data",
        "director",
        "production",
        "producer",
        "cinematographer",
        "camera_assistant",
        "dit",
        "data_manager",
        "script_supervisor",
        "sound_mixer",
        "location",
        "file_size",
        "burn_ins",
        "source_audio_tc_offset",
        "audio_tc_offset",
        "onset_id",
        "category",
        "menu",
        "page_auth_id",
        "password",
        "is_demo",
        "rate",
        "index",
        "correspond",
        "tag_id",
        "complete",
        "login_name",
        "email",
        "nickname",
        "phone",
        "department_id",
        "status",
        "login_session",
        "login_count",
        "token_time",
        "forget_count",
        "forget_token",
        "last_forget",
        "failed_login_count",
        "last_login",
        "template_id",
        "action_scope",
        "value",
        "view_id",
        "note_id",
        "client_session_id",
        "playlist_id"
    ];

    if (in_array($fields, $tableFields)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 替换过滤条件中的方法名
 * @param $val
 * @return mixed
 */
function parserFilterCondition($val)
{
    $map = [
        'EQ' => '-eq', // 等于
        'NEQ' => '-neq', // 不等于
        'GT' => '-gt', // 大于
        'EGT' => '-egt', // 大于等于
        'LT' => '-lt', // 小于
        'ELT' => '-elt', // 小于等于
        'LIKE' => '-lk', // 模糊查询（像）
        'NOTLIKE' => '-not-lk', // 模糊查询（不像）
        'BETWEEN' => '-bw', // 在之间
        'NOT BETWEEN' => '-not-bw', // 不在之间
        'IN' => '-in', // 在里面
        'NOT IN' => '-not-in', // 不在里面
    ];
    if (array_key_exists($val, $map)) {
        return $map[$val];
    }
}

