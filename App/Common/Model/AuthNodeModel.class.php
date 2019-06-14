<?php

namespace Common\Model;

use Think\Model\RelationModel;

class AuthNodeModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['lang', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['lang', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['type', ['route', 'view'], '', self::EXISTS_VALIDATE, 'in'],
        ['module', ['page', 'api'], '', self::EXISTS_VALIDATE, 'in'],
        ['parent_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['rules', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}