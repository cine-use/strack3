<?php

namespace Admin\Controller;

use Common\Service\ProjectService;
use Common\Service\StatusService;

// +----------------------------------------------------------------------
// | 后台项目管理数据控制层
// +----------------------------------------------------------------------

class ManageController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 后台项目列表
     */
    public function getAdminProjectList()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getAdminProjectList($param["filter"]);
        return json($resData);
    }

    /**
     * 选定项目详情数据
     */
    public function getProjectDetails()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->getProjectDetails($param);
        return json($resData);
    }

    /**
     * 更新项目信息
     */
    public function modifyProject()
    {
        $param = $this->request->param();
        $projectService = new ProjectService();
        $resData = $projectService->modifyProject($param);
        return json($resData);
    }

    /**
     * 删除项目
     */
    public function deleteProject()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $projectService = new ProjectService();
        $resData = $projectService->deleteProject($param);
        return json($resData);
    }

    /**
     * 获取项目状态列表
     */
    public function getProjectStatusList()
    {
        $statusService = new StatusService();
        $resData = $statusService->getStatusDataList();
        return json($resData['rows']);
    }
}