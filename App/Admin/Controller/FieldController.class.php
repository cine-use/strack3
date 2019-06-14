<?php
namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 系统数据表字段设置数据控制层
// +----------------------------------------------------------------------

class FieldController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        return $this->display();
    }

    /**
     * 获取系统所有表列表
     */
    public function getTableList()
    {
        $resData = D("Common/Field")->getTables();
        return json($resData);
    }


    /**
     * 获取字段配置
     */
    public function getFieldConfig()
    {
        $table = I("post.table");
        if (empty($table)) {
            $resData = ["total" => 0, "rows" => []];
        } else {
            $resData = D("Common/Field")->getTableFields($table);
        }
        return json($resData);
    }

    /**
     * 保存字段配置
     */
    public function modifyFieldConfig()
    {
        $tableName = I("post.table");
        $config = $_POST["config"];
        $resData = D("Common/Field")->modifyFieldConfig($tableName, $config);
        return json($resData);
    }
}