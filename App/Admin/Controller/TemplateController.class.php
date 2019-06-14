<?php
// +----------------------------------------------------------------------
// | 项目模板数据控制层
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Service\HorizontalService;
use Common\Service\ProjectService;
use Common\Service\SchemaService;
use Common\Service\StatusService;
use Common\Service\TagService;
use Common\Service\TemplateService;


class TemplateController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 添加项目模板
     * @return \Think\Response
     */
    public function addProjectTemplate()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->addProjectTemplate($param);
        return json($resData);
    }

    /**
     * 修改项目模板
     * @return \Think\Response
     */
    public function modifyProjectTemplate()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->modifyProjectTemplate($param);
        return json($resData);
    }

    /**
     * 删除项目模板
     * @return \Think\Response
     */
    public function deleteProjectTemplate()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $templateService = new TemplateService();
        $resData = $templateService->deleteProjectTemplate($param);
        return json($resData);
    }

    /**
     * 项目模板列表
     * @return \Think\Response
     */
    public function getTemplateList()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getTemplateList($param["filter"]);
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
            case "navigation":
                // 映射project=>overview
                foreach ($param["config"] as &$configItem) {
                    if ($configItem["code"] === "project") {
                        $configItem["code"] = "overview";
                    }
                }
                $projectService = new TemplateService();
                $resData = $projectService->modifyTemplateConfig($param);
                break;
            default:
                $projectService = new TemplateService();
                $resData = $projectService->modifyTemplateConfig($param);
                break;
        }
        return json($resData);
    }

    /**
     * 获取项目内置模板
     * @return \Think\Response
     */
    public function getProjectBuiltinTemplateList()
    {
        $projectService = new ProjectService();
        $resData = $projectService->getProjectBuiltinTemplateList();
        return json($resData);
    }

    /**
     * 重置项目模板
     * @return \Think\Response
     */
    public function resetTemplateConfig()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->resetTemplateConfig($param);
        return json($resData);
    }

    /**
     * 获取项目模板可配置模块列表
     * @return \Think\Response
     */
    public function getProjectTemplateModuleList()
    {
        $param = $this->request->param();
        $schemaService = new SchemaService();
        $resData = $schemaService->getProjectTemplateModuleList($param["template_id"]);
        return json($resData);
    }

    /**
     * 获取实体类型数据结构列表
     * @return \Think\Response
     */
    public function getEntitySchemaComboboxList()
    {
        $schemaService = new SchemaService();
        $entitySchemaList = $schemaService->getEntitySchemaList();
        $entitySchemaComboboxList = [];

        foreach ($entitySchemaList["rows"] as $entitySchemaItem) {
            array_push($entitySchemaComboboxList, [
                'id' => $entitySchemaItem["id"],
                'name' => $entitySchemaItem["name"]
            ]);
        }
        return json($entitySchemaComboboxList);
    }

    /**
     * 获取项目模块列表
     * @return \Think\Response
     */
    public function getProjectNavModuleList()
    {
        $param = $this->request->param();
        $templateService = new TemplateService();
        $resData = $templateService->getProjectNavModuleList($param["template_id"]);
        return json($resData);
    }

    /**
     * 获取项目模板状态列表
     * @return \Think\Response
     */
    public function getStatusDataList()
    {
        $statusService = new StatusService();
        $resData = $statusService->getStatusDataList();
        return json($resData);
    }

    /**
     * 获取当前模块自身基础字段
     * @return \Think\Response
     */
    public function getModuleBaseColumns()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getModuleBaseGroupColumns($param, true);
        return json($resData);
    }

    /**
     * 获取当前关联模型的字段
     * @return \Think\Response
     */
    public function getModuleRelationColumns()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getModuleRelationColumns($param);
        return json($resData);
    }

    /**
     * 获取项目模板配置基础数据
     * @return \Think\Response
     */
    public function getTemplateDataList()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getTemplateDataList($param);
        return json($resData);
    }

    /**
     * 获取指定模块水平关联配置
     * @return \Think\Response
     */
    public function getModuleRelationConfig()
    {
        $param = $this->request->param();

        // 获取当前module已经存在的关联模块信息
        $horizontalService = new HorizontalService();
        $existModuleRelationConfig = $horizontalService->getModuleRelationConfig($param);
        return json(["exist" => $existModuleRelationConfig]);
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
     * 获取模板工序列表
     * @return \Think\Response
     */
    public function getTemplateStepList()
    {
        $projectService = new TemplateService();
        $resData = $projectService->getTemplateStepList();
        return json($resData);
    }

    /**
     * 获取标签数据列表
     * @return \Think\Response
     */
    public function getTagDataList()
    {
        $param = $this->request->param();
        $tagService = new TagService();
        $resData = $tagService->getTagDataList($param);
        return json($resData);
    }
}