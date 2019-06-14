<?php

namespace Common\Model;

use Think\Model\RelationModel;

class RoleUserModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['role_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}