<?php

namespace Admin\Controller;

use Common\Service\LdapService;
use Common\Service\OptionsService;
use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | Ldap预控配置页面
// +----------------------------------------------------------------------

class LdapController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $moduleId = 13;
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        // 把数据发送到前端页面
        $param = [
            "page" => 'admin_' . $moduleData["code"],
            "module_id" => $moduleId,
            "module_code" => $moduleData["code"],
            "module_name" => $moduleData["name"],
            "module_icon" => $moduleData["icon"]
        ];

        $this->assign($param);

        return $this->display();
    }

    /**
     * 添加LDAP
     */
    public function addLdap()
    {
        $param = $this->request->param();
        $ldapService = new LdapService();
        $resData = $ldapService->addLdap($param);
        return json($resData);
    }

    /**
     * 修改LDAP
     */
    public function modifyLdap()
    {
        $param = $this->request->param();
        $ldapService = new LdapService();
        $resData = $ldapService->modifyLdap($param);
        return json($resData);
    }

    /**
     * 删除LDAP
     */
    public function deleteLdap()
    {
        $param = $this->request->param();
        $deleteIds = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $ldapService = new LdapService();
        $resData = $ldapService->deleteLdap($deleteIds);

        if($resData["status"] === 200){
            // 同时移除 ldap options
            $optionsService = new OptionsService();
            try{
                $optionsService->updateLdapSetting(explode(",", $param["primary_ids"]));
            }catch (\Exception $e){}
        }

        return json($resData);
    }


    /**
     * 保存域登录服务配置
     */
    public function saveLdapSetting()
    {
        $param = $this->request->param();
        $optionsService = new  OptionsService();
        $resData = $optionsService->saveLdapSetting($param);
        return json($resData);
    }

    /**
     * 获取域服务器配置列表
     */
    public function getLdapServerSettingList()
    {
        $optionsService = new  OptionsService();
        $ldapLoginSetting = $optionsService->getOptionsData("ldap_login_setting");
        $ldapService = new LdapService();
        $ldapAllServerList =  $ldapService->getLdapList();
        foreach ($ldapAllServerList["rows"] as &$item){
            if(in_array($item["id"], $ldapLoginSetting["ldap_server_list"])){
                $item["ldap_switch"] = "on";
            }else{
                $item["ldap_switch"] = "off";
            }
        }
        if($ldapLoginSetting["ldap_open"]){
            $ldapAllServerList["ldap_open"] = $ldapLoginSetting["ldap_open"];
        }
        return json($ldapAllServerList);
    }

    /**
     * 项目域数据表格
     */
    public function getLdapGridData()
    {
        $param = $this->request->param();
        $ldapService = new LdapService();
        $resData = $ldapService->getLdapGridData($param);
        return json($resData);
    }

}