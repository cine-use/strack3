<?php

namespace Common\Model;

use Think\Model\RelationModel;

class FileTypeModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['type', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['type', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['ext', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['step_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['dir_template_code', '0,255', '', self::EXISTS_VALIDATE, 'length']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}