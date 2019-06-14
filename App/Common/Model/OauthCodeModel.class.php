<?php

// +----------------------------------------------------------------------
// | Oauth Code 数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class OauthCodeModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['client_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['client_id', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['user_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['user_id', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,40', '', self::EXISTS_VALIDATE, 'length'],
        ['redirect_uri', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['redirect_uri', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['expires', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['scope', '0,255', '', self::EXISTS_VALIDATE, 'length']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}