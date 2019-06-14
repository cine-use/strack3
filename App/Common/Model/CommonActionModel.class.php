<?php
namespace Common\Model;

use Think\Model\RelationModel;

class CommonActionModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['action_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['action_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'require'],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}