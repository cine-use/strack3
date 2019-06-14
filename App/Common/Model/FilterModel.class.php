<?php

namespace Common\Model;

use Think\Model\RelationModel;

class FilterModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['color', ['red', 'orange', 'olive', 'green', 'teal', 'blue', 'violet', 'purple', 'pink', 'brown', 'grey', 'black'], '', self::EXISTS_VALIDATE, 'in'],
        ['page', '0,64', '', self::EXISTS_VALIDATE, 'length'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['stick', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['public', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}