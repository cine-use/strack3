<?php

namespace Common\Model;

use Think\Model\RelationModel;

class TimelogModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['complete', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['end_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}