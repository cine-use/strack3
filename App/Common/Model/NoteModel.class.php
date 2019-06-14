<?php

namespace Common\Model;

use Think\Model\RelationModel;

class NoteModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['type', ['text', 'audio', 'video'], '', self::EXISTS_VALIDATE, 'in'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['link_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['stick', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['parent_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['version_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['playlist_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['last_updated', 'time', self::MODEL_BOTH, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function'],
        ['text', 'fill_text_default_val', self::MODEL_INSERT, 'function']
    ];
}