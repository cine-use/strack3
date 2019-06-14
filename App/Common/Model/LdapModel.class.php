<?php

// +----------------------------------------------------------------------
// | 状态数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class LdapModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['domain_controllers', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['domain_controllers', '', '', self::EXISTS_VALIDATE, 'array'],
        ['base_dn', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['base_dn', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['admin_username', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['admin_username', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['admin_password', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['admin_password', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['port', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['ssl', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['tls', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['dn_whitelist', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    // 自动完成
    protected $_auto = [
        ['domain_controllers', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['dn_whitelist', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

}