<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ClientNoteModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['email', '', '', self::EXISTS_VALIDATE, 'email'],
        ['email', '0,255', '', self::EXISTS_VALIDATE, 'length'],
        ['note_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['note_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['client_session_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['playlist_id', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}