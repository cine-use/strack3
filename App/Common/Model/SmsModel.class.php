<?php

// +----------------------------------------------------------------------
// | 短信数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class SmsModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['type', ['register', 'login'], '', self::EXISTS_VALIDATE, 'in'],
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['phone', '1,20', '', self::EXISTS_VALIDATE, 'length'],
        ['validate_code', '1,64', '', self::EXISTS_VALIDATE, 'length'],
        ['deadline', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

}