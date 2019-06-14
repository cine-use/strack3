<?php

namespace Common\Model;

use Think\Model\RelationModel;

class DirTemplateModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['code', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['pattern', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['parent_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['disk_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['type', ['dir', 'file'], '', self::EXISTS_VALIDATE, 'in'],
        ['rule', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['rule', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['pattern', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];


}