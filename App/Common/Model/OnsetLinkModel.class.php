<?php

// +----------------------------------------------------------------------
// | 现场数据关联数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class OnsetLinkModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['onset_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['onset_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}