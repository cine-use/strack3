<?php

namespace Test\Controller;

use Common\Service\ProjectService;
use Think\Controller;


class ProjectTemplateController extends Controller
{
    public function getTaskData()
    {
        $jsonData = [
            'task' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [55, 54, 53, 52, 51, 50],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'disk' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'media' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'field_data' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'project' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'publish' => [
                'status' => ['final', 'in_progress'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'time_log' => [
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'version' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'episode' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [4, 45, 51],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'shot' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [4, 45],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'sequence' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [4, 45],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'pre-production' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [4, 45],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'asset_type' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [54, 4, 45],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ],
            'asset' => [
                'status' => ['final', 'in_progress', 'active'],
                'show_list' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'sort' => ['status'],
                'group' => ['status'],
                'step' => ['status'],
                'step_fields' => ['status'],
                'detail_top_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'detail_info_show_field' => ['thumbnail', 'project_name', 'name', 'status', 'asset'],
                'relation' => [4, 45],
                'tag_bar' => ['task', 'shot_info', 'asset', 'history']
            ]
        ];
        return $jsonData;

    }

    public function addProject()
    {

        $param =
            ['info'=>[

            'name' => '项目1',
            'code' => 'test_project_11',
            'status_id' => 1,
            'rate' => '40',
            'description' => '这是测试项目啊',
            'start_time' => '2018-06-20',
            'end_time' => '2018-06-23',
            'project_template_id' => '1',
            'project_template_config' => ['{"id": "field_id", "edit": "deny"}'],
            'project_disk_config' => ['{"id": "field_id", "edit": "deny"}'],
            'project_group_name' => 'test_group11',
            'auth_role_id' => 1,
            'user_id' => 1,
            'type' => 'super'
        ]];
        $projectService = new ProjectService();
        $resData = $projectService->addProject($param);
        var_dump($resData);
        json($resData);
    }

    public function getShowFields(){
        $param = [
            'page'=>'project_template',
            'module_id'=> 4,
            'project_id'=> 22,
            'template_id'=> 1,
            'category'=>'sort'
        ];
        $projectService = new ProjectService();
        $resData = $projectService->getTemplateDataList($param);
        dump($resData);
    }
}