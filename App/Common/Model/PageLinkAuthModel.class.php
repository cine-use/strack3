<?php

namespace Common\Model;

use Think\Model\RelationModel;

class PageLinkAuthModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['page_auth_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['auth_group_id', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}