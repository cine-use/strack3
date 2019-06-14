<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ModuleRelationModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['type', ['has_one', 'belong_to', 'has_many', 'many_to_many'], '', self::EXISTS_VALIDATE, 'in'],
        ['src_module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['src_module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['dst_module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['dst_module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '1,64', '', self::EXISTS_VALIDATE, 'length'],
        ['schema_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['schema_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['node_config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['node_config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}