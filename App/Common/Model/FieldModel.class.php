<?php

namespace Common\Model;

use Think\Model;

class FieldModel extends Model
{

    //自动验证
    protected $_validate = [
        ['table', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['table', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];

    /**
     * 关联表配置
     * [
     *   "module" => 所属模块,
     *   "table" => 所属表名,
     *   "fields" => 字段名,
     *   "lang" => 字段语言包,
     *   "type" => 字段类型,
     *   "editor" => 编辑器类型（none, input, textarea, combobox, date, datetime, radio, url_link）,
     *   "edit" => 是否可以编辑（allow, deny）,
     *   "show" => 是否在前台显示 （yes, no）,
     *   "value_show" => 前台显示值key名称
     *   "filter" => 是否可以过滤（allow, deny）,
     *   "sort" => 是否可以过滤（allow, deny）,
     *   "validate" => 验证方法,
     *   "mask" => input 输入掩码,
     *   "multiple" => combobox专属 是否可以多选,
     *   "group" => combobox专属 是否分组显示,
     *   "allow_group" => 是否为可以作为分组字段,
     *   "field_type" => 字段是内置字段还是自定义字段
     * ]
     * @param $tableModuleName
     * @param $field
     * @return array
     */
    protected function defaultFieldConfig($tableModuleName, $field)
    {
        return [
            "id" => $field["name"],
            "module" => $tableModuleName, //模块名
            "table" => string_initial_letter($tableModuleName), //表名
            "fields" => $field["name"],
            "lang" => string_initial_letter($field["name"], '_'),
            "type" => $field["type"],
            "editor" => "none",
            "edit" => "deny",
            "show" => "no",
            "value_show" => $field["name"],
            "filter" => "deny",
            "sort" => "deny",
            "validate" => "",
            "mask" => "",
            "multiple" => "no",
            "group" => "",
            "allow_group" => "deny",
            "field_type" => "built_in"
        ];
    }

    /**
     * 获取数据库的所有表
     * @param string $dbName
     * @return array
     */
    public function getTables($dbName = '')
    {
        return $this->db()->getTables($dbName);
    }

    /**
     * 取得数据表的字段信息
     * @param $tableName
     * @return mixed
     */
    public function getFields($tableName)
    {
        return $this->db()->getFields($tableName);
    }

    /**
     * 判断当前表是否存在指定字段
     * @param $tableName
     * @param $field
     * @return bool
     */
    public function checkTableField($tableName, $field)
    {
        $fields = $this->getFields($tableName);
        if (array_key_exists($field, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 保存当前字段配置修改
     * @param $tableName
     * @param $config
     * @return mixed
     */
    public function modifyFieldConfig($tableName, $config)
    {
        $tableModuleName = str_replace(C("DB_PREFIX"), "", $tableName);
        $count = $this->where(["table" => $tableModuleName])->count();
        if ($count > 0) {
            $this->where(["table" => $tableModuleName])->setField("config", $config);
        } else {
            $addData = [
                "table" => $tableModuleName,
                "config" => $config
            ];
            $this->add($addData);
        }
        return ["status" => 200, "message" => L("Field_Config_Modify_SC")];
    }

    /**
     * 获取指定表字段控件设置
     * @param $tableName
     * @return array
     */
    public function getTableFields($tableName)
    {
        $tableModuleName = str_replace(C("DB_PREFIX"), "", $tableName);
        $count = $this->where(["table" => $tableModuleName])->count();

        //获取当前表存在字段
        $fields = $this->db()->getFields($tableName);

        $config = [];
        if ($count > 0) {
            $configJson = $this->where(["table" => $tableModuleName])->getField("config");
            $existFieldConfig = json_decode($configJson, true);
            $existFieldIndex = [];
            foreach ($existFieldConfig as $existItem) {
                $existFieldIndex[$existItem["id"]] = $existItem;
            }
            //判断当前存储字段是否在数据表中，不存在忽略，数据库表中新增字段增加进来
            foreach ($fields as $key => $field) {
                if (array_key_exists($key, $existFieldIndex)) {
                    array_push($config, $existFieldIndex[$key]);
                } else {
                    array_push($config, $this->defaultFieldConfig($tableModuleName, $field));
                }
            }
        } else {
            foreach ($fields as $key => $field) {
                array_push($config, $this->defaultFieldConfig($tableModuleName, $field));
            }
        }
        return $config;
    }

    /**
     * 获取当前表的字段配置
     * @param string $tableName
     * @param array $moduleData
     * @return mixed
     */
    public function getTableFieldsConfig($tableName = '', $moduleData = [])
    {
        $tableModuleName = str_replace(C("DB_PREFIX"), "", $tableName);
        $configJson = $this->where(["table" => $tableModuleName])->getField("config");
        $fieldConfig = json_decode($configJson, true);
        // 给内置字段加上module_code标识
        foreach ($fieldConfig as &$fieldsItem) {
            if (!empty($moduleData)) {
                $fieldsItem["module_code"] = $moduleData["code"];
                $fieldsItem["module_type"] = $moduleData["type"];
                // 判断是不是外联字段
                if (array_key_exists("is_foreign_key", $fieldsItem) && $fieldsItem["is_foreign_key"] === "yes") {
                    $fieldsItem["foreign_key"] = $fieldsItem["fields"];
                    $fieldsItem["frozen_module"] = $fieldsItem["module_code"];
                }
            }
        }
        return $fieldConfig;
    }
}