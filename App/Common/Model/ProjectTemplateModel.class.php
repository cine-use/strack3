<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ProjectTemplateModel extends RelationModel
{
    // 自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['schema_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['schema_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}