<?php

namespace Common\Model;

use Think\Model\RelationModel;

class MemberModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['type', ['cc', 'assign', 'producer', 'coordinator', 'at'], '', self::EXISTS_VALIDATE, 'in'],
        ['user_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}