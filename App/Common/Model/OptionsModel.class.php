<?php

namespace Common\Model;

use Think\Model\RelationModel;

class OptionsModel extends RelationModel
{

    //自动验证
    protected $_validate = [
        ['name', '', '', self::MUST_VALIDATE, 'require', self::MODEL_INSERT],//必须字段
        ['name', '1,128', '', self::EXISTS_VALIDATE, 'length'],
        ['type', '0,128', '', self::EXISTS_VALIDATE, 'length'],
        ['type', '', '', self::EXISTS_VALIDATE, 'alphaDash'],
        ['config', '', '', self::EXISTS_VALIDATE, 'array']
    ];

    //自动完成
    protected $_auto = [
        ['config', 'json_encode', self::EXISTS_VALIDATE, 'function'],
        ['uuid', 'create_uuid', self::MODEL_INSERT, 'function']
    ];


    /**
     * 更新指定Options设置
     * @param $optionName
     * @param $data
     * @return array|bool|mixed
     */
    public function updateOptionsData($optionName, $data)
    {
        $optionsId = $this->where(['name' => $optionName])->getField("id");
        if ($optionsId > 0) {
            $updateData = [
                'id' => $optionsId,
                'name' => $optionName,
                'config' => $data
            ];
            return $this->modifyItem($updateData);
        } else {
            $addData = [
                'name' => $optionName,
                'config' => $data
            ];
            return $this->addItem($addData);
        }
    }
}