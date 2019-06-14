<?php

// +----------------------------------------------------------------------
// | 标签关联数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class TagLinkModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['tag_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['tag_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

    // has many 关联数据显示配置
    public $_hasManyDataShowFormat = [
        'primary_key' => 'id',
        'foreign_key' => 'tag_id',
        "middle_key" => 'link_id',
        'format' => [
            'table' => 'tag',
            'fields' => 'id,name'
        ]
    ];
}