<?php

// +----------------------------------------------------------------------
// | 状态数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class MediaServerModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['request_url', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['request_url', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['upload_url', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['upload_url', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['access_key', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['access_key', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['secret_key', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['secret_key', '0,128', '', self::EXISTS_VALIDATE, 'length']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}