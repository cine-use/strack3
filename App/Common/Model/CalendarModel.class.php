<?php
namespace Common\Model;

use Think\Model\RelationModel;

class CalendarModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['name', '', '{%Calendar_Name_Exist}', self::EXISTS_VALIDATE, 'unique'],
        ['start_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['end_time', '', '', self::EXISTS_VALIDATE, 'date'],
        ['type', ['holiday', 'event', 'overtime'], '{%Calendar_type_Validate}', self::EXISTS_VALIDATE, 'in']
    ];

    //自动完成
    protected $_auto = [
        ['start_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['end_time', 'strtotime', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}