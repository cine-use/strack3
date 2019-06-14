<?php

namespace Common\Model;

use Think\Model\RelationModel;

class AuthAccessModel extends RelationModel
{

    // 自动验证
    protected $_validate = [
        ['role_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['auth_group_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['page', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['param', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['type', ['page', 'field'], '', self::EXISTS_VALIDATE, 'in'],
        ['permission', '0,32', '', self::EXISTS_VALIDATE, 'length'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}