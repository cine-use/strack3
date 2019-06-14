<?php

namespace Common\Model;

use Think\Model\RelationModel;

class DownloadModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length']
    ];

    //自动完成
    protected $_auto = [
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['path', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}