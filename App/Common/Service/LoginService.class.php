<?php
// +----------------------------------------------------------------------
// | 登录服务服务层
// +----------------------------------------------------------------------
// | 主要服务于登录数据处理
// +----------------------------------------------------------------------
// | 错误编码头 209xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\UserModel;

class LoginService
{

    // 错误信息
    protected $errorMessage = "";

    /**
     * 获取错误信息
     */
    public function getError()
    {
        return $this->errorMessage;
    }

    /**
     * 验证登录数据 login_name, password, from
     * @param $param
     * @return bool
     */
    private function checkLoginParam($param)
    {
        $requestKeys = ['login_name', 'password', 'from'];
        foreach ($requestKeys as $key) {
            if (!array_key_exists($key, $param)) {
                $this->errorMessage = L("Login_Param_Error") . ' : ' . $key;
                return false;
                break;
            }
        }
        return true;
    }

    /**
     * 用户登录（method：登录方式，）
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function login($param)
    {
        if ($this->checkLoginParam($param)) {

            // 验证数据参数
            $method = array_key_exists("method", $param) ? $param["method"] : '';

            // 判断登录方式
            switch ($method) {
                case 'ldap':
                    // 域用户登录方式
                    $resData = $this->ldapLogin($param);
                    break;
                case 'qq':
                    // QQ 登录方式
                    $resData = $this->qqLogin($param);
                    break;
                case'weChat':
                    // 微信登录方式
                    $resData = $this->wechatLogin($param);
                    break;
                default:
                    // 默认系统用户验证登录
                    $resData = $this->defaultLogin($param);
                    break;
            }

            // 判断返回数据
            if (!$resData) {
                // 登录存在错误
                throw_strack_exception($this->getError(), 209001);
            } else {
                // 登录成功
                return success_response(L("Login_SC"), $resData);
            }
        } else {
            // 登录参数有问题
            throw_strack_exception($this->getError(), 209002);
        }
    }

    /**
     * 系统登录方式（前端验证，后端验证）
     * @param $param
     * @return array|bool
     * @throws \Exception
     */
    private function defaultLogin($param)
    {
        // 查找当前匹配用户
        $userModel = new UserModel();

        $userData = $userModel->findData([
            "filter" => [
                "login_name" => $param["login_name"]
            ]
        ]);

        if (!empty($userData)) {
            // 判断是否是管理员
            $administratorPassword = C("Administrator_Password");

            if ($userData["id"] == 1) {
                // 超级管理员不通过数据库验证密码
                if ($param["password"] === $administratorPassword) {
                    // 登录成功
                    return $this->afterLoginSuccess($param, $userData);
                }
            } else {
                // 判断密码
                if (check_pass($param["password"], $userData["password"])) {
                    // 登录成功
                    return $this->afterLoginSuccess($param, $userData);
                }
            }

            // 密码错误
            $this->errorMessage = L("Login_Name_Or_Password_Error");
            return false;

        } else {
            // 用户不存在
            $this->errorMessage = L("Login_Name_Or_Password_Error");
            return false;
        }
    }

    /**
     * ldap登录方式
     * @param $param
     * @return array|bool
     * @throws \Exception
     */
    private function ldapLogin($param)
    {
        $ldapService = new LdapService();
        $ldapService->initConfig($param["server_id"]);
        $ldapService->ldapVerify($param);
        $userData = $ldapService->updateUserData($param);
        return $this->afterLoginSuccess($param, $userData);
    }

    /**
     * QQ登录入口 TODO
     * 第三方登录用户创建
     * 第三方登录用户注册
     * @param $param
     */
    private function qqLogin($param)
    {

    }

    /**
     * wechat登录入口 TODO
     * 第三方登录用户创建
     * 第三方登录用户注册
     * @param $param
     */
    private function weChatLogin($param)
    {

    }

    /**
     * 处理登录成功后操作
     * @param $param
     * @param $userData
     * @param string $method
     * @return array
     * @throws \Exception
     */
    private function afterLoginSuccess($param, $userData, $method = 'default')
    {

        // 获取当前用户配置
        $userService = new UserService();
        $userLangSetting = $userService->getUserDefaultLang($userData["id"]);

        $token = md5(string_random(8) . '_' . $userData["id"] . '_' . time());

        // 当前用户
        if (!(session("?user_id") && session("user_id") == $userData["id"])) {
            session("user_id", $userData["id"]);
        }

        // 获取当前用户所在时差
        get_user_timezone_inter($userData["id"]);

        $resData = [];
        switch (strtolower($param["from"])) {
            case "api":
                // api登录请求，保存当前用户token
                $token = $userService->checkTokenExpireTime($userData, true);
                break;
            case "web_admin":
                // 后台登录方式

                break;
            case "default":
            default:
                //web 浏览器方式

                $resData["url"] = session("redirect_url"); // 返回跳转地址
                session('redirect_url', null);

                // 把当前用户使用语言设置写入cookie
                cookie('think_language', $userLangSetting);

                // 当前用户信息
                S('user_data_' . $userData['id'], $userData);
                break;
        }


        // Token放入session
        session(strtolower($param["from"]) . "_login_session", $token);

        $resData["token"] = $token;
        $resData["user_id"] = $userData["id"];

        return $resData;
    }


    /**
     * 统一处理登出操作
     * @param $from
     * @param int $userId
     * @return array
     */
    public function loginOut($from, $userId = 0)
    {
        if (in_array($from, ["api", "web", "web_admin"])) {

            // 销毁session
            session($from . "_login_session", null);

            switch ($from) {
                case "api":
                    // 处理api登出，销毁token

                    break;
                case "web_admin":
                    // 处理后台登出

                    break;
                default:
                    // 默认web登出

                    // 销毁语言包cookie设置
                    cookie('think_language', null);

                    break;
            }

            return success_response(L("Login_Out_SC"));
        } else {
            //  非法操作
            throw_strack_exception(L("Illegal_Operation"), 209005);
        }
    }

}