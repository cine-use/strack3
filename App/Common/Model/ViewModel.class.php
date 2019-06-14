<?php

// +----------------------------------------------------------------------
// | 视图数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class ViewModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['project_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['project_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['page', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['page', '1,64', '', self::EXISTS_VALIDATE, 'length'],
        ['name,project_id,page', '', '{%View_Name_Exist}', self::MUST_VALIDATE, 'unique'],
        ['public', ['yes', 'no'], '', self::EXISTS_VALIDATE, 'in'],
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['user_id', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

}