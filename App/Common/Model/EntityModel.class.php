<?php

namespace Common\Model;

use Think\Model\RelationModel;

class EntityModel extends RelationModel
{
    // 自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['parent_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['parent_module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['end_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['duration', '0,8', '', self::EXISTS_VALIDATE, 'length'],
        ['duration', '', '', self::EXISTS_VALIDATE, 'number'],
        ['json', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    // 自动完成
    protected $_auto = [
        ['start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['json', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];

    // has many 关联数据显示配置
    public $_hasManyDataShowFormat = [
        'primary_key' => 'entity_id',
        'foreign_key' => 'dst_link_id',
        "middle_key" => 'src_link_id',
        'format' => [
            'table' => 'entity',
            'field' => 'name'
        ]
    ];
}