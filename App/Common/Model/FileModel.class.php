<?php

namespace Common\Model;

use Think\Model\RelationModel;

class FileModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['md5_name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['md5_name', '', '', self::EXISTS_VALIDATE, 'unique'], //文件md5 name 全局唯一
        ['code', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['code', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['code', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['md5', '1,128', '', self::EXISTS_VALIDATE, 'length'], //文件
        ['link_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['module_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['version', '', '', self::EXISTS_VALIDATE, 'integer'], // 文件版本号
        ['path_rule', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['frame_range', '1,255', '', self::EXISTS_VALIDATE, 'length'],
        ['status_id', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];

    //自动完成
    protected $_auto = [
        ['json', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['created_by', 'fill_created_by', self::MODEL_INSERT, 'function'],
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}