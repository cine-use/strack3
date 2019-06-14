<?php

namespace Common\Model;

use Think\Model\RelationModel;

class AuthGroupNodeModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['auth_group_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['auth_node_id', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}