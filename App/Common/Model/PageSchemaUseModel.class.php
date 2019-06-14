<?php

namespace Common\Model;

use Think\Model\RelationModel;

class PageSchemaUseModel extends RelationModel
{
    //自动验证
    protected $_validate = [
        ['page', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['page', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['page', '', '', self::EXISTS_VALIDATE, 'unique'],
        ['schema_id', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['schema_id', '', '', self::EXISTS_VALIDATE, 'integer']
    ];

    // 自动完成
    protected $_auto = [
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];

    /**
     * 判断当前模块是否存在关联模型
     * @param $page
     * @return bool|int
     */
    public function checkModuleSchemaExit($page)
    {
        $schemaId = $this->where(["page" => $page])->getField("schema_id");
        if ($schemaId > 0) {
            return (int)$schemaId;
        } else {
            return false;
        }
    }
}