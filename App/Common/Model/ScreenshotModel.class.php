<?php
namespace Common\Model;

use Think\Model;
use Think\Model\RelationModel;

class ScreenshotModel extends RelationModel {

    //自动验证
    protected $_validate = [
        ['session', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['session', '1,36', '', self::EXISTS_VALIDATE, 'length'],
        ['version_id', '', '', self::EXISTS_VALIDATE, 'integer'],
        ['path', '0,36', '', self::EXISTS_VALIDATE, 'length'],
        ['frame', '', '', self::EXISTS_VALIDATE, 'integer'],
    ];
}