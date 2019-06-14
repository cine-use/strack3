<?php

namespace Test\Controller;

use Common\Model\EntityModel;
use Common\Service\CommonService;
use Common\Service\SchemaService;
use Think\Controller;

class ApiController extends Controller
{
    public function testTaskSelect()
    {
        $requestArrayParam = [
            "filter" => [
                "sort" => [],
                "request" => [],
                "filter_advance" => [],
            ],
            "master" => [
                "module_code" => "base",
                "pagination" => [
                    "page_size" => 10000,
                    "page_number" => 1
                ],
                "fields" => "id,name,code,project_id,entity_id,entity_module_id,status_id,step_id,priority,start_time,end_time,duration,plan_start_time,plan_end_time,plan_duration,description,json,created_by,created,uuid"
            ],
            "relation" => [
                [
                    "module_code" => "tag_link",
                    "fields" => "id,tag_id,link_id,module_id,uuid"
                ],
                [
                    "module_code" => "entity",
                    "fields" => "id,name,code,project_id,module_id,status_id,description,parent_id,parent_module_id,start_time,end_time,duration,workflow_id,json,created_by,created,uuid"
                ]
            ],
            "project_id" => 0
        ];
        $resData = (new CommonService("Base"))->relation($requestArrayParam);
        dump($resData);
    }

    public function testEntitySelect()
    {

        $requestArrayParam = [
            "filter" => [
                "sort" => [],
                "request" => [],
                "filter_advance" => [],
            ],
            "master" => [
                "module_code" => "shot",
                "pagination" => [
                    "page_size" => 10000,
                    "page_number" => 1
                ],
                "fields" => "id,name,code,project_id,module_id,status_id,description,parent_id,parent_module_id,start_time,end_time,duration,workflow_id,json,created_by,created,uuid"
            ],
            "relation" => [
                [
                    "module_code" => "base",
                    "fields" => "id,name,code,project_id,entity_id,entity_module_id,status_id,step_id,priority,start_time,end_time,duration,plan_start_time,plan_end_time,plan_duration,description,json,created_by,created,uuid"
                ]
            ],
            "project_id" => 1
        ];
        $schemaService = new SchemaService();
        $schemaFields = $schemaService->generateModuleRelation($requestArrayParam);
        $resData = (new EntityModel())->getRelationData($schemaFields,"api");
//        $resData = (new CommonService("Entity"))->relation($requestArrayParam);
        dump($resData);
    }
}