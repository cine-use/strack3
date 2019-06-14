<?php
// +----------------------------------------------------------------------
// | Options服务服务层
// +----------------------------------------------------------------------
// | 主要服务于Options数据处理
// +----------------------------------------------------------------------
// | 错误编码头 214xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\OptionsModel;
use Common\Model\LdapModel;

class OptionsService
{

    /**
     * 获取指定Options设置
     * @param $optionName
     * @return mixed
     */
    public function getOptionsData($optionName)
    {
        $optionsModel = new OptionsModel();
        $options = [
            'fields' => "config",
            'filter' => ['name' => $optionName]
        ];
        $resData = $optionsModel->findData($options);
        return array_key_exists("config", $resData) ? $resData['config'] : [];
    }

    /**
     * 获取系统模式配置
     * @param bool $isPageAuth
     * @return array
     */
    public function getSystemModeConfig($isPageAuth = true)
    {
        $defaultModeConfig = $this->getOptionsData("default_mode");
        if (empty($defaultModeConfig)) {
            $defaultModeConfig = [
                "mode" => "strack",
                "open_create_project" => "1",
                "visit_system_admin" => "1",
                "open_clone_project" => "0",
                "open_register" => "0",
                "default_role" => "0",
                "default_clone_project" => "0",
                "default_project_public" => "yes"
            ];
        }

        if ($isPageAuth) {
            $pageAuth = [
                'add_project' => 'yes',
                'visit_system_admin' => 'yes',
            ];
            if ($defaultModeConfig["open_register"] == 1 && $defaultModeConfig["open_create_project"] == 0) {
                $pageAuth["add_project"] = 'no';
            }
            if ($defaultModeConfig["open_register"] == 1 && $defaultModeConfig["visit_system_admin"] == 0) {
                $pageAuth["visit_system_admin"] = 'no';
            }

            return $pageAuth;
        } else {
            return $defaultModeConfig;
        }
    }

    /**
     * 获取指定Options设置项值
     * @param $optionName
     * @param $itemName
     * @return string
     */
    public function getOptionsConfigItemData($optionName, $itemName)
    {
        $configData = $this->getOptionsData($optionName);
        if (!empty($configData) && array_key_exists($itemName, $configData)) {
            return $configData["$itemName"];
        } else {
            return "";
        }
    }

    /**
     * 通用更新修改Options
     * @param $optionName
     * @param $data
     * @param string $message
     * @return array
     */
    public function updateOptionsData($optionName, $data, $message = '')
    {
        $optionsModel = new OptionsModel();
        $updateOptionResult = $optionsModel->updateOptionsData($optionName, $data);
        if ($updateOptionResult) {
            if (empty($message)) {
                $message = L("Modify_Options_SC");
            }
            // 返回成功数据
            return success_response($message);
        } else {
            // 添加更新系统配置失败错误码 001
            throw_strack_exception($optionsModel->getError(), 214001);
        }
    }

    /**
     * 通用添加配置
     * @param $optionName
     * @param $data
     * @param string $message
     * @return array
     */
    public function addOptionsData($optionName, $data, $message = '')
    {
        $optionsModel = new OptionsModel();
        $findOptionsResult = $optionsModel->findData(["filter" => ["name" => $optionName]]);
        if (empty($findOptionsResult)) {
            $addOptionsResult = $optionsModel->updateOptionsData($optionName, $data);
            if ($addOptionsResult) {
                if (empty($message)) {
                    $message = $optionsModel->getSuccessMassege();
                }
                // 返回成功数据
                return success_response($message);
            }

        } else {
            return $this->updateOptionsData($optionName, $data);
        }
    }


    /**
     * 新增国家设置
     * @param $nationId
     * @return array|bool|mixed
     */
    public function addNation($nationId)
    {
        $oldNationData = $this->getOptionsData("nation_settings");

        if (!in_array($nationId, $oldNationData["nation"])) {
            array_push($oldNationData["nation"], $nationId);
            return $this->updateOptionsData("nation_settings", ["nation" => $oldNationData["nation"]], L('Nation_Add_SC'));
        }
        return success_response(L('Nation_Add_SC'));
    }

    /**
     * 删除国家设置
     * @param $delNationIds
     * @return array
     */
    public function deleteNation($delNationIds)
    {
        $oldNationData = $this->getOptionsData("nation_settings");
        $newNationData = [];
        foreach ($oldNationData["nation"] as $code) {
            if (!in_array($code, $delNationIds)) {
                array_push($newNationData, $code);
            }
        }
        return $this->updateOptionsData("nation_settings", ["nation" => $newNationData], L('Nation_Delete_SC'));
    }

    /**
     * 保存域登录服务配置
     * @param $param
     * @return mixed
     */
    public function saveLdapSetting($param)
    {
        $oldConfig = $this->getOptionsData("ldap_login_setting");
        switch ($param["type"]) {
            case "ldap_open":
                // 域服务登录开启
                if ($param["status"] == 1) {
                    $oldConfig["ldap_open"] = true;
                } else {
                    $oldConfig["ldap_open"] = false;
                }
                break;
            case "ldap_server_list":
                // 域服务器列表
                if (array_key_exists("ldap_server_list", $oldConfig)) {
                    switch ($param["status"]) {
                        case "on":
                            if (!in_array($param["ldap_id"], $oldConfig["ldap_server_list"])) {
                                array_push($oldConfig["ldap_server_list"], $param["ldap_id"]);
                            }
                            break;
                        case "off":
                            $newLdapServerList = [];
                            foreach ($oldConfig["ldap_server_list"] as $item) {
                                if ($item != $param["ldap_id"]) {
                                    array_push($newLdapServerList, $item);
                                }
                            }
                            $oldConfig["ldap_server_list"] = $newLdapServerList;
                            break;
                    }

                } else {
                    $oldConfig["ldap_server_list"] = [$param["ldap_id"]];
                }
                break;
        }

        // 更新域服务器配置
        $this->updateOptionsData("ldap_login_setting", $oldConfig);
        return success_response(L('Ldap_Login_Setting_Modify_SC'));
    }

    /**
     * 更新Ldap配置
     * @param $ids
     * @param string $mode
     */
    public function updateLdapSetting($ids, $mode = "delete")
    {
        $ldapOptions = $this->getOptionsData("ldap_login_setting");
        if (array_key_exists("ldap_server_list", $ldapOptions)) {
            $ldapOptionsIds = [];
            switch ($mode) {
                case "delete":
                    foreach ($ldapOptions["ldap_server_list"] as $ldapId) {
                        if (!in_array($ldapId, $ids)) {
                            array_push($ldapOptionsIds, $ldapId);
                        }
                    }

                    $ldapOptions["ldap_server_list"] = $ldapOptionsIds;

                    if (empty($ldapOptionsIds)) {
                        $ldapOptions["ldap_open"] = false;
                    }

                    break;
            }

            $this->updateOptionsData("ldap_login_setting", $ldapOptions);
        }
    }

    /**
     * 获取第三方登录服务列表
     */
    public function getThirdServerList()
    {
        // 目前就支持域服务
        $ldapLpginsConfig = $this->getOptionsData("ldap_login_setting");

        $thirdServerList = [
            "third_server_status" => "off",
            "third_server_list" => [],
            "third_server_total" => 0
        ];
        if ($ldapLpginsConfig["ldap_open"] && count($ldapLpginsConfig["ldap_server_list"]) > 0) {
            $thirdServerList["third_server_status"] = "on";
            $ldapModel = new LdapModel();
            foreach ($ldapLpginsConfig["ldap_server_list"] as $ldapId) {
                $ldapData = $ldapModel->field("id,name")->where(["id" => $ldapId])->find();
                $ldapData["type"] = "ldap";
                array_push($thirdServerList["third_server_list"], $ldapData);
            }
        }
        $thirdServerList["third_server_total"] = count($thirdServerList["third_server_list"]);
        return $thirdServerList;
    }

    /**
     * 获取日志服务器状态
     * @return array
     */
    public function getLogServerStatus()
    {
        $logServerConfig = $this->getOptionsData("log_settings");
        if (!empty($logServerConfig["request_url"])) {
            $getServerStatus = check_http_code($logServerConfig["request_url"]);
            return [
                'status' => $getServerStatus['http_code'],
                'connect_time' => $getServerStatus['connect_time'],
                'name' => L("Log_Server"),
                'request_url' => $logServerConfig['request_url'],
                'websocket_url' => $logServerConfig['websocket_url'],
                'access_key' => $logServerConfig['access_key'],
                'secret_key' => $logServerConfig['secret_key']
            ];
        } else {
            return [];
        }
    }
}