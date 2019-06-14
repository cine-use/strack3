<?php

namespace Common\Model;

use Think\Model\RelationModel;

class OnsetModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['unit', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['number', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['wrangler', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['location', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['take_date', '', '', self::EXISTS_VALIDATE, 'date'],
        ['int_ext', ['Interior', 'exterior'], '', self::EXISTS_VALIDATE, 'in'],
        ['day_night', ['daytime', 'dusk', 'night', 'dawn'], '', self::EXISTS_VALIDATE, 'in'],
        ['hdri', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['ref_pic', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['clip_number', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['lens', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['focal_length', '0,20', '', self::EXISTS_VALIDATE, 'length'],
        ['filter', '0,20', '', self::EXISTS_VALIDATE, 'length'],
        ['shutter', '0,12', '', self::EXISTS_VALIDATE, 'length'],
        ['stop', '0,8', '', self::EXISTS_VALIDATE, 'length'],
        ['height', '0,64', '', self::EXISTS_VALIDATE, 'length'],
        ['tilt_angle', '0,64', '', self::EXISTS_VALIDATE, 'length'],
        ['distance', '0,64', '', self::EXISTS_VALIDATE, 'length'],
        ['resolution', '0,16', '', self::EXISTS_VALIDATE, 'length'],
        ['frame_rate', '0,8', '', self::EXISTS_VALIDATE, 'length'],
        ['white_balance', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['param', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['param', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}