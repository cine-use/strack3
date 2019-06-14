<?php
// +----------------------------------------------------------------------
// | 使用过密码历史记录数据表
// +----------------------------------------------------------------------

namespace Common\Model;

use Think\Model\RelationModel;

class PasswordHistoryModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['password', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['password', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['user_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['user_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    //自动完成
    protected $_auto = [
        ['created', 'time', self::MODEL_INSERT, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];
}
