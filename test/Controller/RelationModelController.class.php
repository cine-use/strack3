<?php

namespace Test\Controller;

use Think\Controller;

use Common\Model\ModuleModel;
use Common\Model\UserModel;
use Common\Model\ModuleRelationModel;

class RelationModelController extends Controller
{

    /**
     * 测试关联结构查询
     */
    public function test_module_relation()
    {
        $prefix = C("DB_PREFIX");
        $sourceModuleId = 34;//测试数据

        //查询当前模块数据
        $moduleModel = new ModuleModel();
        $sourceModuleData = $moduleModel->findData(["filter" => ["module_id" => $sourceModuleId]]);

        $tableName = $sourceModuleData["type"] === 'fixed' ? $sourceModuleData['code'] : $sourceModuleData['type'];
        $table_alias = $sourceModuleData["type"] === 'fixed' ? $sourceModuleData['code'] : $sourceModuleData['code'] . '_' . $sourceModuleData['type'];

        $relationStructure = [
            'table_name' => $tableName,
            'table_alias' => $table_alias,
            'field' => '*',
            'filter' => ["fields" => ["add" => [], "cut" => []],
                "group" => "",
                "sort" => [],
                "request" => [
                    //["field" => "user_id", "value" => "2", "condition" => "EQ", "module_code" => "user", "table" => "user"],
//                    ["field" => "type", "value" => "system", "condition" => "EQ", "module_code" => "user_config", "table" => "user_config"],
                ],
                "filter_input" => [],
                "filter_panel" => [],
                "filter_advance"
                => []],
            'relation_join' => [],
            'relation_has_many' => []
        ];


        $options = ['filter' => ['schema_id' => 2, "src_module_id" => $sourceModuleId]];

        $moduleRelationModel = new ModuleRelationModel();

        $schemaRelationModule = $moduleRelationModel->selectData($options);

        $relationModuleList = [];

        foreach ($schemaRelationModule['rows'] as $moduleItem) {
            if ($moduleItem["node_config"]["node_data"]['target']['module_type'] === 'fixed') {
                $key = $moduleItem["node_config"]["node_data"]['target']['module_code'];
            } else {
                $key = $moduleItem["node_config"]["node_data"]['target']['module_code'] . '_entity';
            }
            $relationModuleList[$key] = [
                'mapping_type' => $moduleItem["type"],
                'module_id' => $moduleItem["dst_module_id"],
                'foreign_key' => $moduleItem["link_id"],
                'module_code' => $moduleItem["node_config"]["node_data"]['target']['module_code'],
                'module_type' => $moduleItem["node_config"]["node_data"]['target']['module_type'],
                'field' => '*'
            ];
        }
        unset($schemaRelationModule);

        foreach ($relationModuleList as $key => $moduleItem) {
            switch ($moduleItem["mapping_type"]) {
                case "has_one":
                case "belong_to":
                    $relationStructure["relation_join"][$key] = $moduleItem;
                    break;
                case "has_many":
                case "many_to_many":
                    $relationStructure["relation_has_many"][$key] = $moduleItem;
                    break;
            }
        }

        dump($relationStructure);

        $model = new UserModel();
        $data = $model->moduleRelationSelectData($prefix, $relationStructure);

        dump($data);

    }
}