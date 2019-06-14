<?php

// +----------------------------------------------------------------------
// | 标签数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class TagModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['color', '6', '', self::EXISTS_VALIDATE, 'length'],
        ['type', ['system', 'review', 'approve', 'publish', 'custom'], '', self::EXISTS_VALIDATE, 'in']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}