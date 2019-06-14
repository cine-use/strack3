<?php

// +----------------------------------------------------------------------
// | 字段表达式数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model;

class FieldExpressModel extends Model
{

    //自动验证
    protected $_validate = [
        ['field', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];


    /**
     * 获取实体模块ID
     * @param $filter
     * @return mixed
     */
    private function getEntityModuleId($filter)
    {
        $moduleId = M("Entity")->where($filter)->getField("module_id");
        return $moduleId;
    }

    /**
     * 处理字段表达式
     * @param $filed
     * @param $filter
     * @param array $param
     */
    public function handleFieldExpress($filed, $filter, $param = [])
    {
        $expressConfigJson = $this->where(["field" => $filed])->getField("config");
        $expressConfig = json_decode($expressConfigJson, true);
        if ($expressConfig["type"] === "system") {
            $filedData = explode(".", $filed);
            $update = [];
            switch ($expressConfig["express"]) {
                case "duration":
                    // 期间与开始结束时间相互计算处理
                    switch ($filedData[1]) {
                        case "duration":
                        case "plan_duration":
                            $prefix = str_replace('duration', '', $filedData[1]);
                            $update = [

                            ];
                            break;
                        case "start_time":
                        case "plan_start_time":
                            $prefix = str_replace('start_time', '', $filedData[1]);

                            break;
                        case "end_time":
                        case "plan_end_time":
                            $prefix = str_replace('end_time', '', $filedData[1]);

                            break;
                    }
                    break;
                case "base_entity_module":
                    // 更新任务 module_id
                    $moduleId = $this->getEntityModuleId([
                        $filedData[1] => $param["vale"]
                    ]);
                    $update = [
                        "entity_module_id" => $moduleId
                    ];
                    break;
                case "entity_parent_module":
                    // 更新实体父级 module_id
                    $moduleId = $this->getEntityModuleId([
                        $filedData[1] => $param["vale"]
                    ]);
                    $update = [
                        "parent_module_id" => $moduleId
                    ];
                    break;
            }

            $class = '\\Common\\Model\\' . string_initial_letter($filedData[0]) . 'Model';
            $modelObject = new $class();

            $modelObject->where($filter)->save($update);
        }
    }
}