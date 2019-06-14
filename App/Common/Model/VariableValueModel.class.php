<?php

// +----------------------------------------------------------------------
// | 自定义字段值数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class VariableValueModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['variable_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['variable_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['value', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];

}