<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ProjectModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['status_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['rate', '0,6', '', self::EXISTS_VALIDATE, 'length'],
        ['rate', '', '', self::EXISTS_VALIDATE, 'number'],
        ['start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['end_time', '', '', self::EXISTS_VALIDATE, 'date']
    ];

    //自动完成
    protected $_auto = [
        ['start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];


}