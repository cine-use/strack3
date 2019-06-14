<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ModuleModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['code', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['type', ['entity', 'fixed'], '', self::EXISTS_VALIDATE, 'in'],
        ['active', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['icon', '0,24', '', self::EXISTS_VALIDATE, 'length'],
        ['number', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['number', '0,9', '', self::EXISTS_VALIDATE, 'length']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}