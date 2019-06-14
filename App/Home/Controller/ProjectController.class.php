<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\CommonService;
use Common\Service\DiskService;
use Common\Service\ProjectService;
use Common\Service\SchemaService;
use Common\Service\StatusService;
use Common\Service\StepService;
use Common\Service\TemplateService;

class ProjectController extends VerifyController
{


    /**
     * 显示项目管理首页
     */
    public function index()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID("project_manage");

        return $this->display();
    }

    /**
     * 显示添加项目页面
     */
    public function create()
    {
        $moduleId = C("MODULE_ID")["project"];
        $param = [
            "module_id" => $moduleId,
            "page" => 'project_create'
        ];

        // 生成页面唯一信息
        $this->generatePageIdentityID("project_create");
        $this->assign($param);
        return $this->display();
    }

    /**
     * 项目管理首页
     */
    public function overview()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        $param = $this->request->param();

        // 生成页面唯一信息
        $this->generatePageIdentityID("project_overview", $projectId);

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["project"];
        $projectMemberModuleId = C("MODULE_ID")["project_member"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        // 处理当前指定场景Url锚点数据
        $urlAnchorsGetParam = get_page_url_anchors_param("tab", $param);

        if (count($urlAnchorsGetParam) > 0) {
            $urlAnchorsParam = array_combine(["tab"], $urlAnchorsGetParam);
        } else {
            $urlAnchorsParam = ["tab" => ""];
        }

        $this->assign('url_tag', $urlAnchorsParam);

        // 获取当前项目磁盘id
        $projectService = new ProjectService();
        $diskId = $projectService->getProjectDiskId($projectId);

        $param = [
            "project_id" => $projectId,
            "disk_id" => $diskId,
            "template_id" => $templateId,
            "page" => 'project_overview',
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"]), '_'),
            "module_icon" => $moduleData["icon"],
            "project_member_module_id" => $projectMemberModuleId
        ];

        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示实体类型页面
     */
    public function entity()
    {
        $getUrlParam = get_url_param();
        if (count($getUrlParam) == 2) {
            $projectId = $getUrlParam[1];
            $moduleId = $getUrlParam[0];
        } else {
            $projectId = $getUrlParam;
            $moduleId = 0;
        }

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，Entity模块ID 是动态的
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        // 把数据发送到前端页面
        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_title" => L("Strack_" . string_initial_letter($moduleData["code"], '_')),
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "task_module_id" => C("MODULE_ID")["base"],
            "template_id" => $templateId
        ];

        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示基础类型页面（任务页面）
     */
    public function base()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["base"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 把数据发送到前端页面
        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];

        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示动态（Note）页面
     */
    public function note()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["note"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示 OnSet 现场数据
     */
    public function onset()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["onset"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示文件页面
     */
    public function file()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["file"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示文件提交页面
     */
    public function file_commit()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["file_commit"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示时间日志
     */
    public function timelog()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["timelog"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "template_id" => $templateId
        ];
        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示Media页面
     */
    public function media()
    {
        $projectId = get_url_param();

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        $param = $this->request->param();

        // 活动当前模块信息，固定模块ID 是写死的
        $schemaService = new SchemaService();
        $moduleId = C("MODULE_ID")["media"];
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        $page = 'project_' . $moduleData["code"];

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        // 处理当前指定场景Url锚点数据
        $urlAnchorsGetParam = get_page_url_anchors_param("scene", $param);

        // 获取项目模板ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($projectId);

        $urlAnchorsParam = ["url_scene" => "", "url_tab" => "", "url_id" => "", "url_item_name" => ""];

        if (count($urlAnchorsGetParam) >= 1) {
            $urlAnchorsParam["url_scene"] = $urlAnchorsGetParam[0];
        }
        if (count($urlAnchorsGetParam) >= 2) {
            $urlAnchorsParam["url_tab"] = $urlAnchorsGetParam[1];
        }
        if (count($urlAnchorsGetParam) >= 3) {
            $urlAnchorsParam["url_id"] = $urlAnchorsGetParam[2];
            switch ($urlAnchorsParam["url_tab"]) {
                case 'my_review':
                case 'all_task':
                    $urlAnchorsParam["url_item_name"] = M("Base")->where(["id" => $urlAnchorsParam["url_id"]])->getField("name");
                    break;
                case 'my_create':
                case 'all_playlist':
                case 'follow':
                    $urlAnchorsParam["url_item_name"] = M("Entity")->where(["id" => $urlAnchorsParam["url_id"]])->getField("name");
                    break;
            }
        }

        $this->assign('url_tag', $urlAnchorsParam);


        // 页面基本参数
        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "template_id" => $templateId,
            "module_id" => $moduleId,
            "module_type" => $moduleData["type"],
            "module_code" => $moduleData["code"],
            "module_name" => L(string_initial_letter($moduleData["code"], '_')),
            "module_icon" => $moduleData["icon"],
            "task_module_id" => C("MODULE_ID")["base"],
            "file_commit_module_id" => C("MODULE_ID")["file_commit"],
            "review_module_id" => C("MODULE_ID")["review"] // 写死的review entity
        ];

        $this->assign($param);
        return $this->display();
    }

    /**
     * 显示项目云盘页面
     */
    public function page()
    {
        $pagePram = get_url_param();

        $projectId = $pagePram[1];
        $moduleCode= $pagePram[0];

        // 验证项目ID传参是否合法
        $this->verifyProjectId($projectId);

        $page = 'project_' . $moduleCode;
        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $projectId);

        // 获取云盘地址
        $diskService = new DiskService();
        $cloudDiskConfig = $diskService->getCloudDiskUrl($projectId);

        $param = [
            "project_id" => $projectId,
            "page" => $page,
            "module_id" => $moduleCode,
            "module_type" => "other_page",
            "module_code" => $moduleCode,
            "module_name" => L(string_initial_letter($moduleCode, '_')),
            "module_icon" => get_other_page_icon($moduleCode),
            "template_id" => 0,
            "cloud_disk_url" => $cloudDiskConfig["cloud_disk_url"],
            "cloud_disk_request_url" => $cloudDiskConfig["cloud_disk_request_url"]
        ];
        $this->assign($param);

        return $this->display();
    }

    /**
     * 获取项目模板列表
     */
    public function getTemplateList()
    {
        $templateService = new TemplateService();
        $resData = $templateService->getTemplateList('');
        return json($resData);
    }

    /**
     * 获取项目模块Combobox列表
     */
    public function getProjectModuleCombobox()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getProjectNavModuleList($param["template_id"]);
        return json($resData);
    }

    /**
     * 获取项目磁盘配置
     */
    public function getProjectDiskConfig()
    {
        $param = $this->request->param();
        // 获取项目磁盘配置
        $projectService = new ProjectService();
        $diskConfig = $projectService->getProjectDiskConfig($param["project_id"]);
        $resData = array_key_exists("config", $diskConfig) ? $diskConfig["config"] : [];
        return json($resData);
    }

    /**
     * 添加磁盘
     */
    public function addProjectDisk()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->addProjectDisk($param);
        return json($resData);
    }

    /**
     * 添加项目更多磁盘设置
     */
    public function addProjectMoreDisk()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->addProjectMoreDisk($param);
        return json($resData);
    }

    /**
     * 删除项目更多磁盘设置
     */
    public function deleteProjectMoreDisk()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->deleteProjectMoreDisk($param);
        return json($resData);
    }

    /**
     * 修改项目磁盘设置
     */
    public function modifyProjectDisk()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->modifyProjectDisk($param);
        return json($resData);
    }

    /**
     * 添加项目
     */
    public function addProject()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->addProject($param);
        return json($resData);
    }

    /**
     * 获取项目详细信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getProjectInfo()
    {
        $param = $this->request->param();
        $commonService = new CommonService(string_initial_letter($param["module_code"]));
        $resData = $commonService->getModuleItemInfo($param, $param["module_code"]);
        return json($resData);
    }

    /**
     * 获取项目列表
     */
    public function getProjectList()
    {
        $param = $this->request->param();
        $param['module_id'] = C("MODULE_ID")["project"];
        $projectService = new ProjectService();
        $resData = $projectService->getProjectList($param);
        return json($resData);
    }

    /**
     * 获取项目页面工具栏设置
     */
    public function getProjectToolbarSettings()
    {
        // 获取状态大类
        $statusCorresponds = status_corresponds_data();
        // 加入全部状态选项
        array_unshift($statusCorresponds, ['id' => 'all', 'name' => L('All_Status')]);
        // 时间范围列表
        $timeDataList = time_range_data();

        $resData = [
            'status_corresponds_list' => $statusCorresponds,
            'time_data_list' => $timeDataList
        ];

        return json($resData);
    }

    /**
     * 获取项目团队列表
     */
    public function getProjectTeamList()
    {
        return json([]);
    }

    /**
     * 获取项目团队成员
     */
    public function getProjectTeamMembers()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $projectService = new ProjectService();
        $resData = $projectService->getProjectMemberGridData($param);
        return json($resData);
    }

    /**
     * 新增项目状态
     */
    public function addStatus()
    {
        $param = $this->request->param();
        $statusService = new StatusService();
        $resData = $statusService->addStatus($param);
        return json($resData);
    }

    /**
     * 新增项目工序
     */
    public function addStep()
    {
        $param = $this->request->param();
        $stepService = new StepService();
        $resData = $stepService->addStep($param);
        return json($resData);
    }

    /**
     * 修改指定模块状态设置
     */
    public function modifyModuleStatusConfig()
    {
        $param = $this->request->param();
        $addData = [
            "category" => "status",
            "module_code" => $param["module_code"],
            "template_id" => $param["template_id"],
            "config" => $param["new_status_config"]
        ];
        $templateService = new TemplateService();
        $resData = $templateService->modifyTemplateConfig($addData);
        return json($resData);
    }

    /**
     * 修改指定模块工序设置
     */
    public function modifyModuleStepConfig()
    {
        $param = $this->request->param();
        $addData = [
            "category" => "step",
            "module_code" => $param["module_code"],
            "template_id" => $param["template_id"],
            "config" => $param["new_step_config"]
        ];
        $templateService = new TemplateService();
        $resData = $templateService->modifyTemplateConfig($addData);
        return json($resData);
    }
}