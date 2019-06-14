<?php

namespace Common\Controller;

// +----------------------------------------------------------------------
// | 系统权限验证控制层
// +----------------------------------------------------------------------

use Common\Service\OptionsService;
use Common\Service\ProjectService;
use Think\Controller;
use Think\Request;
use Common\Service\UserService;
use Common\Service\LicenseService;
use Common\Service\AuthService;

class VerifyController extends Controller
{
    /**
     * @var \Think\Request
     */
    protected $request;

    // 当前路由模块
    protected $currentModule;

    // 当前路由控制器
    protected $currentController;

    // 当前路由方法
    protected $currentAction;

    // 完整路由地址
    protected $fullController;

    /**
     * @var \Common\Service\AuthService
     */
    protected $authService;

    // 用户ID
    protected $userId;

    // 请求头信息
    protected $header;

    // 权限页名称
    protected $authPage = '';

    // 权限页额外验证参数
    protected $authPageParam = '';

    /**
     * 404页面
     */
    protected function _empty()
    {
        $this->redirect('/error/e404');
    }

    /**
     * 403页面
     */
    protected function _noPermission()
    {
        $this->redirect('/error/e403');
    }

    /**
     * 生成页面唯一信息
     * @param $page
     * @param int $projectId
     */
    protected function generatePageIdentityID($page, $projectId = 0)
    {
        $pageIdentityID = $projectId > 0 ? "{$page}_{$projectId}" : $page;
        $pageCreated = time();

        $pageIdentityData = [
            "identity_id" => $pageIdentityID,
            "created" => $pageCreated
        ];

        // 写入页面身份ID session
        session("page_identity", json_encode($pageIdentityData));

        // 发送到页面端
        $this->assign('page_identity', $pageIdentityData);
    }


    /**
     * 获取菜单权限
     */
    protected function getMenuPermission()
    {
        $menuList = ["account_top_menu", "admin_menu", "top_panel"];
        foreach ($menuList as $menuName) {
            // 发送到页面端
            $this->assign($menuName, $this->authService->getMenuPermission($menuName));
        }
    }

    /**
     * 获取边侧栏权限
     */
    protected function getSideBarPermission()
    {
        $barList = ["message_box", "timelog"];
        foreach ($barList as $barName) {
            // 发送到页面端
            $this->assign("side_{$barName}_rules", $this->authService->getPageAuthRules("top_panel_{$barName}"));
        }
    }

    /**
     * 获取页面权限
     */
    protected function getPageAuthRules()
    {
        $pageRules = $this->authService->getPageAuthRules($this->authPage, $this->authPageParam);
        $this->assign("view_rules", $pageRules);
    }

    /**
     *
     * @param $assignName
     * @param $page
     * @param $param
     */
    protected function assignMorePageAuthRules($assignName, $page, $param)
    {
        $pageRules = $this->authService->getPageAuthRules($page, $param);
        $this->assign($assignName, $pageRules);
    }

    /**
     * 验证项目ID传参是否合法
     * @param $projectId
     */
    protected function verifyProjectId($projectId)
    {
        $projectId = intval($projectId);
        if ($projectId > 0) {
            $projectService = new ProjectService();
            $checkProjectExist = $projectService->checkProjectExist($projectId);
            if (!$checkProjectExist) {
                $this->_empty();
            }
        } else {
            $this->_empty();
        }
    }

    /**
     * 设置web端访问User id权限
     * @param $projectId
     */
    protected function setWebUserId($projectId = 0)
    {
        $this->authService->setUser($this->userId, $projectId);
    }

    /**
     * 验证页面权限
     */
    protected function verifyPagePermission()
    {
        if (IS_AJAX || IS_POST) {
            $refererPageData = ["page" => "", "param" => ""];

            if (array_key_exists("referer", $this->header)) {
                $refererPageData = get_ajax_url_referer($this->header["referer"]);
            }

            $this->authPageParam = $refererPageData["param"];

            $this->setWebUserId();

            $visitPermission = $this->authService->verifyAjaxPermission([
                'source_node' => md5($this->fullController),
                'referer_page' => $refererPageData["page"],
                'referer_param' => $refererPageData["param"],
                'referer_tab_param' => $refererPageData["tab"],
                'type' => 'ajax'
            ]);

            if (!$visitPermission) {
                throw_strack_exception(L("NoPermission"), 403);
            }
        } else {
            //权限页名称
            $this->authPage = "{$this->currentModule}_{$this->currentController}_{$this->currentAction}";

            $getParam = $this->request->get();
            $urlParam = get_url_auth_param($this->authPage, $getParam);

            $this->authPageParam = $urlParam["param"];

            $this->setWebUserId($urlParam["project_id"]);

            $visitPermission = $this->authService->verifyAjaxPermission([
                'source_node' => md5($this->fullController),
                'referer_page' => $this->authPage,
                'referer_param' => $urlParam["param"],
                'referer_tab_param' => $urlParam["tab"],
                'type' => 'page'
            ]);

            if ($visitPermission) {
                // 获取菜单权限
                $this->getMenuPermission();
                // 获取页面权限
                $this->getPageAuthRules();
                // 获取边侧栏权限
                $this->getSideBarPermission();
            } else {
                $this->_noPermission();
            }
        }
    }

    /**
     * 验证API权限
     */
    protected function verifyApiPermission()
    {
        // 当前用户id
        $this->userId = (int)session("user_id");

        // 实例化权限服务对象
        $this->authService = new AuthService();
        $this->authService->setUser($this->userId);

        // 判断权限
        $this->authPage = "{$this->currentModule}_{$this->currentController}";

        $visitPermission = $this->authService->verifyAjaxPermission([
            'source_node' => md5($this->fullController),
            'referer_page' => $this->authPage,
            'referer_param' => $this->currentAction,
            'controller' => un_camelize(CONTROLLER_NAME),
            'type' => 'api'
        ]);

        if (!$visitPermission) {
            throw_strack_exception(L("NoPermission"), 403);
        }
    }

    /**
     * 检测是否是调试模式
     */
    protected function checkDebugStatus()
    {
        $systemConfig = [
            "is_dev" => APP_DEBUG,
            "user_id" => session("user_id"),
            'new_login' => 'no'
        ];

        $this->assign($systemConfig);
    }

    /**
     * 获取当前使用主题
     */
    protected function checkShowTheme()
    {
        $themeConfig = C("SHOW_THEME");
        $themeName = !empty($themeConfig) ? $themeConfig : 'default';
        $this->assign('show_theme', $themeName);
    }

    /**
     * 获取模块配置
     */
    protected function checkModuleConfig()
    {
        $moduleStatus = C("MODULE_STATUS");
        $moduleParam = [];
        foreach ($moduleStatus as $key => $value) {
            $moduleParam[$key] = !empty($value) ? $value : 'un_active';
        }
        $this->assign('module_status', $moduleParam);
    }

    /**
     * 获取系统模式配置
     */
    protected function checkSystemModeConfig()
    {
        $optionsService = new OptionsService();
        $defaultModeConfig = $optionsService->getSystemModeConfig();
        $this->assign(["default_mode" => $defaultModeConfig]);
    }

    /**
     * 获取多因子判断状态
     */
    protected function checkMfaStatus()
    {
        $userId = (int)session("user_id");
        if ($userId > 1) {
            // 获取非超级管理员二次验证配置
            $userService = new UserService();
            $mfa = $userService->getUserMfaVerifyConfig($userId);
        }

        if ($userId === 1 || $mfa) {
            // 超级管理员必须验证
            $mfaVerifyExpireTime = session("mfa_verify_expire_time");
            if (!empty($mfaVerifyExpireTime)) {
                if ($userId > 1 || $mfaVerifyExpireTime > time()) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 验证Api Token
     */
    protected function verifyApiToken()
    {
        if ($this->currentController !== "login") {

            // 请求头信息
            $this->header = $this->request->header();

            if (array_key_exists("token", $this->header) && isset($this->header["token"])) {
                // 验证token有效性
                $userService = new UserService();
                $userService->checkApiToken($this->header["token"]);

                // 验证页面权限
                $this->verifyApiPermission();
            } else {
                // token不存在
                throw_strack_exception(L("Token_Does_Not_Exist"));
            }
        }
    }

    /**
     * 验证web 页面session和权限
     */
    protected function verifyWebAccessAuthority()
    {
        // 验证session
        if (!session('?web_login_session') && $this->currentController !== "login") {
            //记录来路
            if ($this->currentController !== "error") {
                session('redirect_url', __SELF__);
            }
            $this->redirect('/login');
            return false;
        }

        // 二次验证
        if (session('?web_login_session') && $this->checkMfaStatus()) {
            if ($this->currentController !== "login" || ($this->currentController === "login" && in_array($this->currentAction, ["index", "forget", "register"]))) {
                $this->redirect('/login/identity2fa');
            }
            return false;
        }

        // 访问登录页面如果已经登录跳转到默认页面
        if (session('?web_login_session') && $this->currentController === "login" && in_array($this->currentAction, ["index", "forget", "register", "identity2fa"])) {
            $this->redirect('project/index');
            return false;
        }

        // 会话存在
        if (session('?web_login_session')) {
            if (!session('?web_admin_login_session') && $this->currentModule === "admin" && $this->currentController !== "index") {
                // 后台二次验证
                $this->redirect('/admin/index');
            } else {

                // 当前用户id
                $this->userId = (int)session("user_id");

                // 实例化权限服务对象
                $this->authService = new AuthService();

                // 验证权限
                if ($this->currentController !== "error") {
                    // 验证页面权限
                    $this->verifyPagePermission();
                } else {
                    // 获取页面菜单权限
                    $this->getMenuPermission();
                    // 获取边侧栏权限
                    $this->getSideBarPermission();
                }
            }
        }
    }

    /**
     * 验证授权许可
     * @return bool
     */
    protected function checkLicense()
    {

        $licenseService = new LicenseService();
        if (in_array($this->fullController, ["api/user/create", "api/user/update"])) {
            // api user 创建更新方法，增加许可数量 +1
            $licenseService->setUpdateUserModeActive();
        }

        if (in_array($this->fullController, ["home/widget/updateitemdialog"])) {
            // 后台用户创建更新方法，增加许可数量 +1
            if (IS_AJAX || IS_POST) {
                if (array_key_exists("referer", $this->header)) {
                    $refererPageData = get_ajax_url_referer($this->header["referer"]);
                    if ($refererPageData["page"] === "admin_account_index") {
                        $licenseService->setUpdateUserModeActive();
                    }
                }
            }
        }
        return $licenseService->checkLicense();
    }


    /**
     * 检测用户登录状态
     */
    protected function _initialize()
    {
        // 获取路由参数
        $this->currentModule = strtolower(MODULE_NAME);
        $this->currentController = strtolower(CONTROLLER_NAME);
        $this->currentAction = strtolower(ACTION_NAME);
        $this->fullController = strtolower(MODULE_NAME . DS . CONTROLLER_NAME . DS . ACTION_NAME);

        // 实例化请求对象
        $this->request = Request::instance();

        // 请求头信息
        $this->header = $this->request->header();

        // 验证授权许可
        $checkLicense = $this->checkLicense();

        // 无效许可且不在license页面
        if (!$checkLicense && $this->currentController !== "license") {
            switch ($this->currentModule) {
                case "api":
                    throw_strack_exception(L("License_Format_Error"));
                    break;
                default:
                    $this->redirect('/license');
                    break;
            }
            return false;
        }

        // 在许可期内跳转到登录页面
        if ($checkLicense && $this->currentController === "license") {
            $this->redirect('/login');
            return false;
        }

        // 验证访问权限，分api和前端模块
        switch ($this->currentModule) {
            case "api":
                // 判断api验证
                session("event_from", "strack_api");

                // 验证API访问权限
                if ($checkLicense) {
                    $this->verifyApiToken();
                }

                break;
            default:
                // 默认走web验证
                session("event_from", "strack_web");

                if (is_ssl()) {
                    $this->assign("url_ssl_on", 'yes');
                } else {
                    $this->assign("url_ssl_on", 'no');
                }

                // 验证页面访问权限
                if ($checkLicense) {
                    $this->verifyWebAccessAuthority();
                }

                // 检测是否是调试模式
                $this->checkDebugStatus();

                // 模块更多配置参数
                $this->checkModuleConfig();

                // 模式更多配置参数
                $this->checkSystemModeConfig();

                // 使用主题
                $this->checkShowTheme();
                break;
        }

    }
}