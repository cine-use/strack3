<?php

namespace Common\Model;

use Think\Model\RelationModel;

class BaseModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['entity_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['entity_module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['step_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['priority', ['normal', 'urgent', 'high', 'medium', 'low'], '', self::EXISTS_VALIDATE, 'in'],
        ['start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['end_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['duration', '0,8', '', self::EXISTS_VALIDATE, 'length'],
        ['duration', '', '', self::EXISTS_VALIDATE, 'number'],
        ['plan_start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['plan_end_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['plan_duration', '0,8', '', self::EXISTS_VALIDATE, 'length'],
        ['plan_duration', '', '', self::EXISTS_VALIDATE, 'number'],
        ['json', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['plan_start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['plan_end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['json', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}