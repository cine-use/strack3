<?php

// +----------------------------------------------------------------------
// | 自定义字段数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class VariableModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['project_id,module_id,code', '', '{%Variable_Code_Exist}', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH],
        ['type', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['type', ['text', 'checkbox', 'textarea', 'combobox', 'datebox', 'datetimebox', 'belong_to', 'expression', 'horizontal_relationship'], '', self::EXISTS_VALIDATE, 'in'],
        ['action_scope', ['all', 'current'], '', self::EXISTS_VALIDATE, 'in'],
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['config', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}