<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\HorizontalService;
use Common\Service\SchemaService;
use Common\Service\ProjectService;
use Common\Service\StatusService;
use Common\Service\TemplateService;

class TemplateController extends VerifyController
{

    /**
     * 生成项目导航配置数据
     * @param $param
     * @return array
     */
    protected function generateProjectNavSetting($param)
    {
        $templateService = new TemplateService();
        $allModuleList = $templateService->getProjectNavModuleList($param["template_id"]);
        $templateNavigationConfig = $templateService->getTemplateConfig($param);


        // 已经选择的模块字典
        $templateNavExit = array_column($templateNavigationConfig, "code");

        // 判断哪些模块被选中
        $exitModuleSettingList = [];
        $notExitModuleSettingList = [];
        foreach ($allModuleList as $item) {
            $item["code"] = $item["code"] === "project" ? "overview" : $item["code"];
            // 模块类型名称
            if ($item["type"] == "fixed") {
                $item["type_name"] = L("Fixed_Module");
            } else {
                $item["type_name"] = L("Dynamic_Module");
            }

            if (in_array($item["code"], $templateNavExit)) {
                $item["checked"] = "yes";
                $exitModuleSettingList[$item["code"]] = $item;
            } else {
                $item["checked"] = "no";
                array_push($notExitModuleSettingList, $item);
            }
        }

        // 重置排序
        $sortExitModuleSettingList = array_merge(array_flip($templateNavExit), $exitModuleSettingList);
        $sortExitModuleSettingValues = array_values($sortExitModuleSettingList);
        foreach ($notExitModuleSettingList as $notExitItem){
            array_push($sortExitModuleSettingValues, $notExitItem);
        }

        return $sortExitModuleSettingValues;
    }

    /**
     * 获取项目导航设置
     */
    public function getProjectNavSetting()
    {
        $param = $this->request->param();
        $allModuleList = $this->generateProjectNavSetting($param);
        return json($allModuleList);
    }

    /**
     * 项目配置页面保存导航设置
     */
    public function modifyProjectNavTemplateConfig()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->modifyTemplateConfig($param);
        if ($resData["status"] === 200) {
            $resData["data"] = $this->generateProjectNavSetting($param);
            $resData["menu_data"] = $templateService->getProjectNavigation($param["project_id"], $param["module_id"]);
        }
        return json($resData);
    }

    /**
     * 更新项目模板配置
     * @return \Think\Response
     */
    public function modifyTemplateConfig()
    {
        $param = $this->request->param();
        switch ($param["category"]) {
            case "relationship":
                // 写入水平关联配置表
                $horizontalService = new HorizontalService();
                $resData = $horizontalService->addHorizontalConfig($param);
                break;
            default:
                $projectService = new TemplateService();
                $resData = $projectService->modifyTemplateConfig($param);
                break;
        }
        return json($resData);
    }

    /**
     * 获取项目首页状态和工序设置模块列表
     */
    public function getProjectOverviewModuleList()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $moduleList = $schemaService->getProjectTemplateModuleList($param["template_id"]);
        switch ($param["tab_name"]) {
            case "status":
                return json($moduleList);
            case "step":
                // 只返回 entity 动态模块
                $entityModuleList = [
                    "entity" => $moduleList["entity"]
                ];
                return json($entityModuleList);
        }
    }

    /**
     * 获取制定模块状态列表
     */
    public function getProjectOverviewStatusList()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getProjectOverviewStatusList($param);
        return json($resData);
    }

    /**
     * 获取制定模块工序列表
     */
    public function getProjectOverviewStepList()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getProjectOverviewStepList($param);
        return json($resData);
    }

    /**
     * 获取项目审核模块工序配置
     */
    public function getReviewStepConfig()
    {
        $param = $this->request->param();
        $filter = [
            "template_id" => $param["template_id"],
            "category" => "step",
            "module_code" => "review",
        ];
        $projectTemplateService = new TemplateService();
        $resData = $projectTemplateService->getTemplateConfig($filter);
        return json($resData);
    }

    /**
     * 获取当前审核实体
     */
    public function getReviewStatusCombobox()
    {
        $param = $this->request->param();
        $options = [
            'frozen_module' => 'review',
            'project_id' => $param['project_id']
        ];

        $statusService = new StatusService();
        $resData = $statusService->getTemplateStatusList($options);

        return json($resData);
    }

    /**
     * 获取详情页面字段配置
     */
    public function getDetailsModuleColumns()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getModuleBaseGroupColumns($param, true);
        return json($resData);
    }

    /**
     * 获取指定模块标签栏列表
     * @return \Think\Response
     */
    public function getModuleTabList()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getModuleTabList($param);
        return json($resData);
    }

    /**
     * 获取项目模板配置
     * @return \Think\Response
     */
    public function getTemplateConfig()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getTemplateConfig($param);
        return json($resData);
    }

    /**
     * 获取用户配置
     * @return \Think\Response
     */
    public function getTemplateUserConfig()
    {
        $param = $this->request->param();
        $userId = session("user_id");
        $templateService = new TemplateService();
        $resData = $templateService->getUserCustomConfig($param, $userId);
        return json($resData);
    }
}