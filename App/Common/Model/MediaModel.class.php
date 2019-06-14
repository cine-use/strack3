<?php

namespace Common\Model;

use Think\Model\RelationModel;

class MediaModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['link_id', '', '', self::EXISTS_VALIDATE, 'require'],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'require'],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['md5_name', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['size', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['media_server_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['type', ['thumb', 'attachment'], '', self::EXISTS_VALIDATE, 'in'],
        ['relation_type', ['direct', 'horizontal'], '', self::EXISTS_VALIDATE, 'in'],
        ['param', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['param', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function'],
        ['thumb', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];


}