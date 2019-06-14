<?php

namespace Test\Controller;

use Common\Service\ProjectService;
use Common\Service\TemplateService;
use Think\Controller;


class ProjectController extends Controller
{
    /**
     * 添加项目磁盘
     */
    public function addProjectDisk()
    {
        $param = [
            "name" => "test",
            "code" => "test",
            "win_path" => "test",
            "mac_path" => "test",
            "linux_path" => "test",
        ];
        $projectService = new ProjectService();
        $resData = $projectService->addProjectDisk($param);
        dump($resData);
    }
}