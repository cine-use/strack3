<?php

// +----------------------------------------------------------------------
// | Oauth Client 数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class OauthClientModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['client_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['client_id', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['client_secret', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['client_secret', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['redirect_uri', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['redirect_uri', '0,255', '', self::EXISTS_VALIDATE, 'length']
    ];

    //自动完成
    protected $_auto = [
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}