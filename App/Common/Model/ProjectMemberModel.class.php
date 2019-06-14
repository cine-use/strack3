<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ProjectMemberModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['project_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['role_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['role_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['user_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}