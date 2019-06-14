<?php

namespace Common\Model;

use Think\Model\RelationModel;

class FileCommitModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['json', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['json', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['check_list', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['description', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}