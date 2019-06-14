<?php

namespace Common\Model;

use Think\Model\RelationModel;

class AuthFieldModel extends RelationModel
{

    // 自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['lang', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['lang', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['type', ['built_in', 'custom'], '', self::EXISTS_VALIDATE, 'in'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}