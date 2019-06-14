<?php

namespace Test\Controller;

use Common\Model\ProjectTemplateModel;
use Common\Service\ProjectService;

class ProjectApiController
{



    public function find()
    {
        $param = [
            "name" => 1,
        ];

        $projectService = new ProjectService();
        $data           = $projectService->getAdminProjectList($param);
        $resData        = ["status" => 200, "message" => "", "data" => $data];
        dump($data);
    }

    public function create()
    {
        $param = [
            "info" => ["name"        => 4,
                       "project_id"  => 4,

            ],
            "template_id"=>1,
        ];

        $projectService = new ProjectService();
        $data           = $projectService->addProject($param);
        $resData        = ["status" => 200, "message" => "", "data" => $data];
        dump($data);
    }

    public function  test()
    {
        try{
        $projectTemplateModel = new ProjectTemplateModel();
        $param=[
            "template_id"=>1,
            "name"=>"bbbb22",
            "project_id"=>333,
            "code"=>233,
            "schema_id"=>2,
            "config"=>["a"=>"b"],
        ];
        $projectTemplateData = $projectTemplateModel->modifyItem($param);
        dump($projectTemplateData);
            if (!$projectTemplateData) {
                dump($projectTemplateModel->getError());
                throw new \Exception($projectTemplateModel->getError());
            }

        }catch (\Exception $e) {

        }
    }

}