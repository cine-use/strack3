<?php

// +----------------------------------------------------------------------
// | Oauth Client 数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class OauthTokenModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['client_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['client_id', '0,36', '', self::EXISTS_VALIDATE, 'length'],
        ['user_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['user_id', '0,36', '', self::EXISTS_VALIDATE, 'length'],
        ['access_token', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['access_token', '1,40', '', self::EXISTS_VALIDATE, 'length'],
        ['refresh_token', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['refresh_token', '1,40', '', self::EXISTS_VALIDATE, 'length'],
        ['expires', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['scope', '0,255', '', self::EXISTS_VALIDATE, 'length']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}