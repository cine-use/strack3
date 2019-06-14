<?php
// +----------------------------------------------------------------------
// | Ldap域服务层
// +----------------------------------------------------------------------
// | 主要服务于Ldap域用户登录处理
// +----------------------------------------------------------------------
// | 错误编码头 234xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\DepartmentModel;
use Common\Model\LdapModel;
use Common\Model\UserModel;
use StrackOauth\Oauth;

class LdapService
{
    //错误信息
    protected $errorMessage = "";
    //LDAP配置必须是Administrator账号
    protected $config = [];
    //LDAP中拿到的字段
    protected $ldapFields = ["title", "department", "memberof", "mail", "givenname", "userprincipalname", "sn"];
    //DN白名单
    protected $allowedLoginDN = [];
    //DN下所有成员
    protected $ldapDnMemberDate = [];
    //用户的所有信息
    protected $ldapUserData = [];

    /**
     * 对象转数组
     * @param $ldapUserData
     */
    protected function formatLdapUserData($ldapUserData)
    {
        //对象转数组
        $ldapUserDataArray = json_decode(json_encode($ldapUserData), true);

        $ldapUserData = [];
        //取ldapFields中的对应值
        foreach ($ldapUserDataArray as $key => $val) {
            if (in_array((string)$key, $this->ldapFields)) {
                $ldapUserData[$key] = $val;
            }
        }
        $this->ldapUserData = $ldapUserData;
    }


    /**
     * 获取指定的Ldap服务器配置数据
     * @param $ldapId
     * @return array|mixed
     */
    public function getLdapServerData($ldapId)
    {
        $ldapModel = new LdapModel();
        $ldapConfig = $ldapModel->findData([
            "filter" => ["id" => $ldapId],
        ]);
        return $ldapConfig;
    }

    /**
     * 初始化域相关配置
     * @param $ldapId
     */
    public function initConfig($ldapId)
    {
        //获取ldap配置
        $ldapConfig = $this->getLdapServerData($ldapId);
        if (empty($ldapConfig)) {
            throw_strack_exception(L("LDAP_Server_Not_Exist"), 234001);
        }
        // 检测SSL
        $this->config["use_ssl"] = array_key_exists("ssl", $ldapConfig) && $ldapConfig["ssl"] == 1 ? true : false;
        //检测TLS
        $this->config["use_tls"] = array_key_exists("tls", $ldapConfig) && $ldapConfig["tls"] == 1 ? true : false;
        // 域服务器地址
        $this->config["domain_controllers"] = $ldapConfig["domain_controllers"];
        // 基准DN
        $this->config["base_dn"] = empty($ldapConfig["base_dn"]) ? $this->getBaseDn() : $ldapConfig["base_dn"];
        // 域服务器端口
        $this->config["port"] = empty($ldapConfig["port"]) ? 389 : $ldapConfig["port"];
        // 域管理员名
        $this->config["admin_username"] = $ldapConfig["admin_username"];
        // 域管理员密码
        $this->config["admin_password"] = $ldapConfig["admin_password"];
        // 配置DN白名单
        foreach ($ldapConfig["dn_whitelist"] as $key => $item) {
            //去除DN白名单中的空值
            if (empty($item)) {
                unset($ldapConfig["dn_whitelist"][$key]);
            }
        }
        $this->allowedLoginDN = $ldapConfig["dn_whitelist"];
    }

    /**
     * 测试LDAP Config
     * @param array $config
     * @return bool
     */
    public function testConfig($config = [])
    {
        if (empty($config)) {
            $config = $this->config;
        }
        // 必要参数检测
        $testConfig = [];
        $requireParam = ["domain_controllers", "base_dn", "admin_username", "admin_password"];
        foreach ($requireParam as $key) {
            if (array_key_exists($key, $config) && isset($config[$key])) {
                //config参数拼装
                $testConfig[$key] = $config[$key];
            } else {
                // 必须包含Ldap 必须参数
                throw_strack_exception(L("LDAP_Require_Param_Not_Exist"), 234002);
            }
        }


        // 测试LDAP配置
        $oauth = new Oauth(['provider' => 'Ldap']);
        $result = $oauth::$provider->testConfig($testConfig);
        if (!$result) {
            throw_strack_exception($oauth::$provider->getError(), 234003);
        }
        if (array_key_exists("dn_whitelist", $config) && !empty($config["dn_whitelist"])) {
            // 测试LDAP白名单
            foreach ($config["dn_whitelist"] as $dnWhite) {
                if (!empty($dnWhite)) {
                    $this->testDnConfig($testConfig, $dnWhite);
                }
            }
        }
        return true;
    }

    /**
     * 测试DN
     * @param $config
     * @param $dn
     * @return bool
     */
    public function testDnConfig($config, $dn)
    {
        return $this->getDnMember($config, $dn);
    }

    /**
     * 获取DN下的所有成员
     * @param $dn
     * @param $config
     * @return mixed
     */
    public function getDnMember($config, $dn)
    {
        $config["base_dn"] = $dn;
        $strackOauth = new Oauth(['provider' => 'Ldap']);
        $dnConfigData = $strackOauth::$provider->getDnMember($config);
        if (count($dnConfigData) == 0) {
            throw_strack_exception($dn . L("LDAP_DN_Config_Error"));
        } else {
            //取出DN下的成员信息
            return json_decode(json_encode($dnConfigData), true)[0]["member"];
        }
    }

    /**
     * 添加LDAP
     * @param $param
     * @return array
     */
    public function addLdap($param)
    {
        $ldapModel = new LdapModel();
        $resData = $ldapModel->addItem($param);
        if (!$resData) {
            throw_strack_exception($ldapModel->getError());
        }

        return ["status" => 200, "message" => $ldapModel->getSuccessMassege(), "data" => $resData];
    }

    /**
     * 修改LDAP
     * @param $param
     * @return array
     */
    public function modifyLdap($param)
    {
        $ldapModel = new LdapModel();
        $resData = $ldapModel->modifyItem($param);
        if (!$resData) {
            throw_strack_exception($ldapModel->getError());
        }
        return ["status" => 200, "message" => $ldapModel->getSuccessMassege(), "data" => $resData];
    }

    /**
     * 删除LDAP
     * @param $param
     * @return array
     */
    public function deleteLdap($param)
    {
        $ldapModel = new LdapModel();
        $resData = $ldapModel->deleteItem($param);
        if (!$resData) {
            throw_strack_exception($ldapModel->getError(), 234009);
        }
        return ["status" => 200, "message" => $ldapModel->getSuccessMassege(), "data" => []];
    }

    /**
     * 获取域服务表格数据
     * @param $param
     * @return array
     */
    public function getLdapGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $ldapModel = new LdapModel();
        $ldapData = $ldapModel->selectData($options);
        return $ldapData;
    }

    /**
     * 获取域服务列表
     * @return array
     */
    public function getLdapList()
    {
        $ldapModel = new LdapModel();
        $ldapData = $ldapModel->selectData();
        return $ldapData;
    }

    /**
     * 获取DN下的所有用户并创建用户
     * @param $dn
     * @return array|bool
     */
    public function createAllDnUser($dn)
    {
        //测试DN是否正常
        $this->testDnConfig($this->config, $dn);
        //获取DN下所有用户
        $dnMember = $this->getDnMember($this->config, $dn);
        foreach ($dnMember as $val) {
            //拼装用户参数
            $member = explode(",", $val)[0];
            $param["login_name"] = explode("=", $member)[1];
            //验证用户信息
            $this->ldapVerify($param, "DnCreate");
            //更新用户信息
            $this->updateUserData($param);
        }
        return true;
    }

    /**
     * 域验证
     * @param $param
     * @param string $type
     * @return bool
     */
    public function ldapVerify($param, $type = "")
    {
        //初始化配置
        $oauth = new Oauth(['provider' => 'Ldap']);
        $ldapVerify = $type == "DnCreate" ? true : $oauth::$provider->verify($this->config, $param);
        if ($ldapVerify) {
            //获取用户信息
            $ldapUserData = $oauth::$provider->getUserData($this->config, $param);
            //检查是否开启指定DN登录
            if (!empty($this->allowedLoginDN)) {
                //检查用户是否在允许登录的DN中
                foreach ($ldapUserData["memberof"] as $val) {
                    if (in_array($val, $this->allowedLoginDN)) {
                        $this->formatLdapUserData($ldapUserData);
                    } else {
                        throw_strack_exception(L("LDAP_Forbidden_Login"), 234004);
                    }
                }
            } else {
                $this->formatLdapUserData($ldapUserData);
            }
            return true;
        } else {
            throw_strack_exception(L("LDAP_User_Not_Exist"), 234005);
        }
    }


    /**
     * 获取base DN
     * @return mixed
     */
    public function getBaseDn()
    {

        $strackOauth = new Oauth(['provider' => 'Ldap']);
        $baseDn = $strackOauth::$provider->getBaseDn($this->config);
        if (!$baseDn) {
            throw_strack_exception($strackOauth::$provider->getError(), 234003);
        }
        return $baseDn;
    }


    /**
     * 更新用户信息
     * @param $param
     * @return array|bool|mixed
     */
    public function updateUserData($param)
    {
        // 写入管理员session
        session("user_id", 1);
        //获取用户信息
        $UserService = new UserModel();
        $userData = $UserService->findData([
            "filter" => [
                "login_name" => $param["login_name"],
            ],
        ]);
        if (!empty($userData)) {
            // 销毁session
            session("user_id", null);
            return $userData;
        }
        // 查找新增部门
        $departmentResult = $this->findOrCreateDepartment();
        $departmentId = $departmentResult;

        // 获取默认密码
        $userService = new UserService();
        $defaultPassword = $userService->getUserDefaultPassword();
        // 获取邮箱参数
        if (array_key_exists("mail", $this->ldapUserData) && !empty($this->ldapUserData["mail"])) {
            $userEmail = $this->ldapUserData['mail'][0];
        } else {
            // 获取默认邮箱后缀
            $optionsService = new OptionsService();
            $systemDefaultSetting = $optionsService->getOptionsData("default_settings");
            $userEmail = $param["login_name"] . $systemDefaultSetting["default_emailsuffix"];
        }

        $addUserParam = [
            "user" => [
                'login_name' => $param["login_name"],
                'password' => $defaultPassword,
                'name' => $param["login_name"],
                'nickname' => $param["login_name"],
                'email' => $userEmail,
                'department_id' => $departmentId,
            ]
        ];
        $addData = $userService->addAccount($addUserParam, "user");
        $userData = $addData["data"];
        // 销毁session
        session("user_id", null);

        return $userData;
    }


    /**
     * 登录名前缀
     * @return mixed
     */
    public function getPrefix()
    {
        $oauth = new Oauth(['provider' => 'Ldap']);
        $prefix = $oauth::$provider->getDcName($this->config);
        if (!$prefix) {
            throw_strack_exception($oauth::$provider->getError(), 234003);
        }
        return $prefix;
    }

    /**
     * 查找或创建部门
     * @return bool|int
     */
    public function findOrCreateDepartment()
    {
        if (empty($this->ldapUserData['department'])) {
            // 默认给部门为0
            $departmentId = 0;
        } else {
            //获取登录名前缀
            $prefix = $this->getPrefix();
            $departmentParam = [
                "name" => $prefix . "-" . $this->ldapUserData['department'][0],
                "code" => $prefix . "-" . $this->ldapUserData['department'][0],
            ];

            // 查找部门
            $departmentModel = new DepartmentModel();
            $departmentData = $departmentModel->findData([
                "filter" => $departmentParam
            ]);
            if (empty($departmentData)) {
                //添加部门
                $userService = new UserService();
                $addDepartmentData = $userService->addDepartment($departmentParam);
                $departmentId = $addDepartmentData["data"]["id"];
            } else {
                $departmentId = $departmentData["id"];
            }
        }
        return $departmentId;
    }

}