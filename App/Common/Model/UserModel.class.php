<?php

// +----------------------------------------------------------------------
// | 用户数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class UserModel extends RelationModel
{

    // 自动验证
    protected $_validate = [
        ['login_name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['login_name', '1,64', '', self::EXISTS_VALIDATE, 'length'],
        ['login_name', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['login_name', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['email', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['email', '', '', self::EXISTS_VALIDATE, 'email'],
        ['email', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['email', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['nickname', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['nickname', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['nickname', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['nickname', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['phone', '0,20', '', self::EXISTS_VALIDATE, 'length'],
        ['department_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['password', '8,96', '', self::EXISTS_VALIDATE, 'length'],
        ['password', '', '', self::EXISTS_VALIDATE, 'password_strength'],
        ['password', '', '', self::EXISTS_VALIDATE, 'password_repeat', self::MODEL_UPDATE],
        ['status', ['in_service', 'departing'], '', self::EXISTS_VALIDATE, 'in'],
        ['login_session', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['login_count', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['forget_count', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['token_time', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['forget_token', '0,32', '', self::EXISTS_VALIDATE, 'length'],
        ['last_forget', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['failed_login_count', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['last_login', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['password', 'fill_default_pass', self::MODEL_INSERT, 'function'],
        ['password', 'create_pass', self::EXISTS_VALIDATE, 'function'],
        ['last_login', 'time', self::MODEL_BOTH, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

}