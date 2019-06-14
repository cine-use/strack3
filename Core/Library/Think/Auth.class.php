<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <weibo.com/luofei614>
// +----------------------------------------------------------------------
namespace Think;

class Auth
{
    // auth_rule 表
    protected $authRule = "auth_rule";

    // auth_role_auth 表
    protected $authRoleAuth = "auth_role_auth";

    // auth_role_access 表
    protected $authRoleAccess = "auth_role_access";

    public function __construct()
    {
        $prefix = C('DB_PREFIX');
        $this->authRule = $prefix . $this->authRule;
        $this->authRoleAuth = $prefix . $this->authRoleAuth;
        $this->authRoleAccess = $prefix . $this->authRoleAccess;
    }

    /**
     * 检查路由权限
     * @param $user_id
     * @param $mode
     * @param $rule
     * @param $projectId
     * @return bool
     */
    public function checkAccess($user_id, $mode, $rule, $projectId = 0)
    {
        $authList = $this->getUserAuthList($user_id, $mode); // 获取用户需要验证的所有有效规则列表
        switch ($mode) {
            case "url":
                $authModeList = $authList["auth_url"];
                foreach ($authModeList as $key => $auth) {
                    if ($auth["permission"] !== "deny") {
                        foreach ($auth["second_list"] as $item) {
                            if (strtolower($rule) === $item["rule_config"] && $item["permission"] === "view") {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
                break;
            case "action":
                $authModeList = $authList["action"];
                foreach ($authModeList as $key => $auth) {
                    $authModeList[$key]["rule_config"] = strtolower($auth["rule_config"]);
                }
                // 检查当前规则是否等于当前权限下面的规则
                foreach ($authModeList as $key => $item) {
                    if (strtolower($rule) === $item["rule_config"] && $item["permission"] === "view") {
                        return true;
                    } else {
                        return false;
                    }
                }
                break;
        }
    }

    /**
     * 获取用户权限
     * @param $user_id
     * @param $mode
     * @param string $tableName
     * @return array
     */
    public function getUserAuthList($user_id, $mode, $tableName = "")
    {
        // 获取角色ID
        $authRoleId = $this->getAuthRoleAccess($user_id);
        // 获取当前角色下所有的权限
        $authRoleList = M()->table($this->authRoleAuth)->where(["auth_role_id" => $authRoleId["auth_role_id"]])->select();
        // 循环处理 将权限规则的信息赋给当前数组
        foreach ($authRoleList as $key => $item) {
            $authRuleData = $this->getAuthConfig($item['auth_rule_id']);
            $authRoleList[$key]['parent_id'] = $authRuleData['parent_id'];
            $authRoleList[$key]['rule_name'] = $authRuleData['name'];
            $authRoleList[$key]['rule_code'] = $authRuleData['code'];
            $authRoleList[$key]['rule_type'] = $authRuleData['type'];
            $authRoleList[$key]['rule_config'] = $authRuleData['config'];
        }

        // 以类型为键值分组
        $authGroup = array_group_by($authRoleList, "rule_type");

        // 组装数据
        $authRuleParentData = [];
        $authRuleChildData = [];
        $authConfigData = $authGroup[$mode];
        foreach ($authConfigData as $key => $item) {
            if ($item['parent_id'] != 0) {
                $authRuleChildData[$item['parent_id']][] = $item;
            } else {
                $authRuleParentData[] = $item;
            }
        }

        foreach ($authRuleParentData as $key => &$parentItem) {
            if (array_key_exists($parentItem['auth_rule_id'], $authRuleChildData)) {
                $parentItem['second_list'] = $authRuleChildData[$parentItem['auth_rule_id']];
            } else {
                $parentItem['second_list'] = [];
            }
        }

        // 返回数据初始化
        $authConfig = ["auth_url" => [], "auth_view" => [], "auth_column" => []];
        // 根据类型分别返回数据
        switch ($mode) {
            case "url":
                $authConfig["auth_url"] = $authRuleParentData;
                break;
            case "action":
                $authConfig["auth_action"] = $authRuleParentData;
                break;
            case "view":
                $viewModeConfig = [];
                $urlConfig = $authGroup["url"];
                $viewConfig = $authGroup[$mode];
                foreach ($viewConfig as $key => $item) {
                    $viewModeConfig[$item["parent_id"]][] = $item;
                }
                foreach ($urlConfig as $key => $item) {
                    if (array_key_exists($item["id"], $viewModeConfig)) {
                        $authConfig["auth_view"][$item["rule_code"]] = $viewModeConfig[$item["id"]];
                    }
                }
                break;
            case "column":
                $data = array_column($authRuleParentData, NULL, 'rule_config');
                if (!empty($tableName)) {
                    foreach ($data as $key => $parentItem) {
                        foreach ($parentItem["second_list"] as $secondKey => $item) {
                            $authConfig["auth_column"][$key][$item["rule_config"]][$item["permission"]] = true;
                        }
                        break;
                    }
                } else {
                    foreach ($data as $key => $parentItem) {
                        foreach ($parentItem["second_list"] as $secondKey => $item) {
                            $authConfig["auth_column"][$key][$item["rule_config"]][$item["permission"]] = true;
                        }
                    }
                }
                break;
        }
        return $authConfig;
    }

    /**
     * 获取用户组角色
     * @param $user_id
     * @return mixed
     */
    public function getAuthRoleAccess($user_id)
    {
        // 获取用户所在的角色组
        $authRoleAccess = M()->table($this->authRoleAccess)->field("auth_role_id")->where(["user_id" => $user_id])->find();

        return $authRoleAccess;
    }

    /**
     * 获取权限配置
     * @param $auth_rule_id
     * @return mixed
     */
    public function getAuthConfig($auth_rule_id)
    {
        $authConfig = M()->table($this->authRule)->where(["id" => $auth_rule_id])->find();
        return $authConfig;
    }
}
