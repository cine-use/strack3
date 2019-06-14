<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\CommonService;
use Common\Service\DiskService;
use Common\Service\EventLogService;
use Common\Service\HorizontalService;
use Common\Service\ProjectService;
use Common\Service\TemplateService;
use Common\Service\VariableService;
use Common\Service\ViewService;
use Common\Service\SchemaService;

class ViewController extends VerifyController
{

    /**
     * 动态加载数据表格列字段
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getGridColumns()
    {
        $param = $this->request->param();
        if ($param["page"] == "details_correlation_base") {
            $param["module_id"] = C("MODULE_ID")["base"];
        }
        $viewService = new ViewService();
        $viewData = $viewService->getGirdViewConfig($param);

        return json($viewData);
    }

    /**
     * 获取过滤面板数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getGridPanelData()
    {
        $param = $this->request->param();
        if ($param["page"] == "details_correlation_base") {
            $param["module_id"] = C("MODULE_ID")["base"];
        }
        if ($param["page"] !== "admin_eventlog") {
            $viewService = new ViewService();
            $resData = $viewService->getGridPanelData($param);
        } else {
            $eventLogService = new EventLogService();
            $resData = $eventLogService->getEventLogGridPanelData($param);
        }
        return json($resData);
    }

    /**
     * 获取显示字段
     */
    public function getFields()
    {
        $param = $this->request->param();
        $viewService = new ViewService();
        $resData = $viewService->getFields($param);
        return json($resData);

    }

    /**
     * 获取高级过滤字段列表
     */
    public function getAdvanceFilterFields()
    {
        $param = $this->request->param();
        $viewService = new ViewService();
        $resData = $viewService->getAdvanceFilterFields($param);
        return json($resData);
    }

    /**
     * 切换显示视图
     */
    public function toggleView()
    {
        $param = $this->request->param();
        $viewService = new ViewService();
        $resData = $viewService->toggleView($param);
        return json($resData);
    }

    /**
     * 保存视图修改
     * @return \Think\Response
     * @throws \Exception
     */
    public function saveView()
    {
        $param = $this->request->param();
        $param['config'] = json_decode(htmlspecialchars_decode($param["view_data"]), true);
        $param['user_id'] = session("user_id");
        $viewService = new ViewService();
        $resData = $viewService->saveView($param);
        return json($resData);
    }

    /**
     * 另存为视图修改
     * @return \Think\Response
     * @throws \Exception
     */
    public function saveAsView()
    {
        $param = $this->request->param();
        $param['config'] = json_decode(htmlspecialchars_decode($param["view_data"]), true);
        $param['user_id'] = session("user_id");
        $viewService = new ViewService();
        $resData = $viewService->saveAsView($param);
        return json($resData);
    }

    /**
     * 修改视图
     */
    public function modifyView()
    {
        $param = $this->request->param();
        $viewService = new ViewService();
        $param["id"] = $param["view_id"];
        $resData = $viewService->modifyView($param);
        return json($resData);
    }

    /**
     * 删除视图
     */
    public function deleteView()
    {
        $param = $this->request->param();
        $param['user_id'] = session("user_id");
        $viewService = new ViewService();
        $resData = $viewService->deleteView($param);
        return json($resData);
    }

    /**
     * 获取排序字段
     */
    public function getSortFields()
    {
        $param = $this->request->param();
        $viewService = new ViewService();
        $resData = $viewService->getSortFields($param);
        return json($resData);
    }

    /**
     * 添加自定义字段
     */
    public function addCustomFields()
    {
        $param = $this->request->param();
        $variableService = new VariableService();
        $resData = $variableService->addCustomFields($param);
        return json($resData);
    }

    /**
     * 修改自定义字段配置
     */
    public function modifyCustomFields()
    {
        $param = $this->request->param();
        $variableService = new VariableService();
        $resData = $variableService->modifyCustomFields($param);
        return json($resData);
    }

    /**
     * 删除自定义字段
     */
    public function deleteCustomField()
    {
        $param = $this->request->param();
        $deleteData = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $variableService = new VariableService();
        $resData = $variableService->deleteCustomField($deleteData, $param["param"]);
        return json($resData);
    }

    /**
     * 获取自定义字段
     */
    public function getCustomFieldsList()
    {
        $param = $this->request->param();
        $variableService = new VariableService();
        $resData = $variableService->getCustomFieldsList($param);
        return json($resData);
    }

    /**
     * 获取顶部菜单数据
     */
    public function getTopMenuData()
    {
        $param = $this->request->param();

        // 固定菜单
        $fixedMenuData = [
            "workbench" => [
                'url' => U('/index'),
                'code' => 'workbench',
                'name' => L("Workbench"),
                'active' => 'no'
            ],
            "project_manage" => [
                'url' => U('/project/index'),
                'code' => 'project_manage',
                'name' => L("Project"),
                'active' => 'no'
            ],
            "project_create" => [
                'url' => U('/project/create'),
                'code' => 'project_create',
                'name' => L("Add_Project"),
                'active' => 'no'
            ],
            "admin" => [
                'url' => U('/admin/index'),
                'code' => 'admin',
                'name' => L("Admin"),
                'active' => 'no'
            ],
            "my_account" => [
                'url' => U('/account'),
                'code' => 'my_account',
                'name' => L("My_Account_Config"),
                'active' => 'no'
            ],
            "help" => [
                'url' => U('/help'),
                'code' => 'help',
                'name' => L("Help"),
                'active' => 'no'
            ],
        ];

        // 获取当前页面顶部菜单
        $menuList = [];
        $projectData = [];
        switch ($param["menu_name"]) {
            case "project_manage":
                foreach (["project_manage"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "project_manage") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                $this->appendCloudDiskMenu($menuList);
                break;
            case "project_create":
                foreach (["project_manage", "project_create"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "project_create") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                break;
            case "cloud_disk":
                $this->appendCloudDiskMenu($menuList, 'yes');
                foreach (["project_manage"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    array_push($menuList, $menuData);
                }
                break;
            case "workbench":
                foreach (["workbench", "project_manage"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "workbench") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                $this->appendCloudDiskMenu($menuList);
                break;
            case "my_account":
                foreach (["project_manage", "my_account"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "my_account") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                $this->appendCloudDiskMenu($menuList);
                break;
            case "help":
                foreach (["project_manage", "help"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "help") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                break;
            case "project_inside":
            case "project_detail":
                // project 内部页面
                $templateService = new TemplateService();
                $menuList = $templateService->getProjectNavigation($param["project_id"], $param["module_id"], $param["menu_name"]);

                // 获取当项目信息
                $projectService = new ProjectService();
                $projectData["current_project"] = $projectService->getProjectDetails($param);

                // 获取当前激活的项目列表
                $projectData["active_project_list"] = $projectService->getActiveProjectList($param["project_id"]);

                // 返回项目切换URL后面参数
                if ($param["module_type"] !== "other_page") {
                    $schemaService = new SchemaService();
                    $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
                    if ($moduleData["code"] === "project") {
                        $projectData["project_last_url"] = "overview/";
                    } else {
                        if ($moduleData["type"] === "fixed") {
                            $projectData["project_last_url"] = "{$moduleData["code"]}/";
                        } else {
                            $projectData["project_last_url"] = "entity/{$param["module_id"]}-";
                        }
                    }
                }
                break;
            case "error":
                // 错误显示页面
                foreach (["project_manage"] as $item) {
                    array_push($menuList, $fixedMenuData[$item]);
                }
                break;
            default:
                // 默认都是后台页面
                foreach (["project_manage", "admin"] as $item) {
                    $menuData = $fixedMenuData[$item];
                    if ($item == "admin") {
                        $menuData['active'] = 'yes';
                        $menuData['url'] = '#';
                    }
                    array_push($menuList, $menuData);
                }
                $this->appendCloudDiskMenu($menuList);
                break;
        }

        return json(["project_data" => $projectData, "menu_data" => $menuList]);
    }

    /**
     * 追加云盘菜单
     * @param $menuList
     * @param string $active
     */
    private function appendCloudDiskMenu(&$menuList, $active = "no")
    {
        $diskService = new DiskService();
        $couldDiskSettings = $diskService->getCloudDiskConfig();
        if ($couldDiskSettings["open_cloud_disk"] == 1) {
            array_push($menuList, build_cloud_disk_menu_data($active, 0));
        }
    }

    /**
     * 获取当前模块tab设置
     */
    public function getTabConfig()
    {
        $param = $this->request->param();
        if ($param["module_code"] == "correlation_base") {
            $param["module_code"] = "base";
        }
        $templateService = new TemplateService();
        $resData = $templateService->getConfigTargetSetting($param["template_id"], $param["module_code"], 'tab');
        $newTabList = [];
        // 判断权限
        $tabAuth = generate_details_tab_auth($param);
        foreach ($resData as $tabItem) {

            if ($tabItem["module_code"] === "correlation_base") {
                $tabItem["module_id"] = C("MODULE_ID")["base"];
            }

            switch ($tabItem["type"]) {
                case "fixed":
                    if ($tabAuth[$tabItem["module_code"]] === "yes") {
                        array_push($newTabList, $tabItem);
                        if ($param["position"] === "grid_slider" && $tabItem["module_code"] === "onset") {
                            array_push($newTabList, [
                                'name' => L('OnSet_Att'),
                                'type' => 'fixed',
                                'group' => L("Fixed_Module"),
                                'table' => '',
                                'tab_id' => 'onset_att',
                                'module_id' => C("MODULE_ID")["onset"],
                                'module_code' => 'onset_att',
                                'module_type' => 'fixed',
                                'dst_module_code' => 'onset_att'
                            ]);
                        }
                    }
                    break;
                case "entity_child":
                    array_push($newTabList, $tabItem);
                    break;
                case "horizontal_relationship":
                case "be_horizontal_relationship":
                    if ($tabAuth["horizontal_relationship"] === "yes") {
                        array_push($newTabList, $tabItem);
                    }
                    break;
                case "other_page":
                    if ($tabAuth[$tabItem["module_code"]] === "yes") {
                        array_push($newTabList, $tabItem);
                    }
                    break;
            }
        }
        return json($newTabList);
    }

    /**
     * 判断当前模块是否支持水平扩展
     */
    public function whetherSupportHorizontalRelation()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        // 所有都允许belong_to
        $allowBelongTo = "yes";
        // 默认不允许水平关联
        $allowHorizontal = "no";

        $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
        // 现在只允许任务、实体可以水平关联
        if (in_array($moduleData["code"], ["base"]) || $moduleData["type"] === "entity") {
            $allowHorizontal = "yes";
        }

        $resData = ["status" => 200, "message" => "", "data" => [
            "allow_belong_to" => $allowBelongTo,
            "allow_horizontal" => $allowHorizontal
        ]];
        return json($resData);
    }

    /**
     * 获取当前模块面包屑导航
     */
    public function getModuleBreadcrumb()
    {
        $param = $this->request->param();
        $moduleCode = $param["module_type"] == "entity" ? $param["module_type"] : $param["module_code"];
        if ($moduleCode == "correlation_base") {
            $moduleCode = "base";
        }
        $commonService = new CommonService(string_initial_letter($moduleCode));
        $resData = $commonService->getModuleBreadcrumb($param);
        return json($resData);
    }

    /**
     * 关联模型列表
     */
    public function getRelationshipModuleList()
    {
        $param = $this->request->param();
        $horizontalService = new HorizontalService();
        switch ($param["type"]) {
            case "entity":
                $resData = $horizontalService->getEntityRelationshipModuleList($param);
                break;
            default:
                $resData = [];
                break;
        }
        return json($resData);
    }

    /**
     * 保存视图修改
     * @return \Think\Response
     * @throws \Exception
     */
    public function saveDefaultView()
    {
        $param = $this->request->param();
        $param['name'] = L('Default_View');
        $param['code'] = 'default_view';
        $param['config'] = json_decode(htmlspecialchars_decode($param["view_data"]), true);
        $viewService = new ViewService();
        $resData = $viewService->saveViewDefault($param);
        return json($resData);
    }

    /**
     * 获取边侧栏数据表格配置
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getDataGridSliderTableConfig()
    {
        $param = $this->request->param();
        if (in_array($param["tab_param"]["type"], ["be_horizontal_relationship", "horizontal_relationship"])) {
            $moduleId = $param["tab_param"]["dst_module_id"];
            $moduleCode = $param["tab_param"]["dst_module_code"];
        } else {
            $moduleId = $param["tab_param"]["module_id"];
            $moduleCode = $param["tab_param"]["module_code"];
        }
        $gridParam = [
            "module_id" => $moduleId,
            "page" => "project_{$moduleCode}",
            "schema_page" => "project_{$moduleCode}",
            "template_id" => $param["grid_param"]["template_id"],
            "project_id" => $param["grid_param"]['project_id'],
            "side_bar" => true
        ];
        $viewService = new ViewService();
        $resData = $viewService->getDataGridSliderTableConfig($gridParam);
        return json($resData);
    }
}