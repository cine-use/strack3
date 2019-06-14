<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ViewUseModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['view_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['view_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['project_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['page', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['page', '1,64', '', self::EXISTS_VALIDATE, 'length'],
        ['project_id,page,user_id', '', '{%View_Use_Exist}', self::MUST_VALIDATE, 'unique']
    ];

    //自动完成
    protected $_auto = [
        ['user_id', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}