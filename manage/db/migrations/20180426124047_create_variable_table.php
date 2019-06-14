<?php


use Phinx\Migration\AbstractMigration;

class CreateVariableTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('strack_variable', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '注册自定义字段ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '注册自定义字段名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '注册自定义字段编码'])
            ->addColumn('type', 'enum', ['values' => 'text,checkbox,textarea,combobox,datebox,datetimebox,belong_to,horizontal_relationship,expression', 'default' => 'text', 'comment' => ' 注册自定义字段类型'])
            ->addColumn('action_scope', 'enum', ['values' => 'all,current', 'default' => 'current', 'comment' => ' 作用范围'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '0标识作用与所有项目 大于0表示指定项目'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '自定义字段配置'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['project_id'], ['type' => 'normal', 'name' => 'idx_variable_project_id']);
        $table->addIndex(['module_id'], ['type' => 'normal', 'name' => 'idx_variable_module_id']);
        $table->addIndex(['code'], ['type' => 'normal', 'name' => 'idx_variable_code']);

        //执行创建
        $table->create();
    }
}
