<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ClientSessionModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
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
        ['token', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}