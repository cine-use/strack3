<?php

// +----------------------------------------------------------------------
// | 现场数据关联数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class ReviewLinkModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['entity_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['file_commit_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['index', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['json', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['json', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}