<?php

namespace Common\Model;

use Think\Model\RelationModel;

class HorizontalModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['src_link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['src_link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['src_module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['src_module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['dst_link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['dst_link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['dst_module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['dst_module_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}