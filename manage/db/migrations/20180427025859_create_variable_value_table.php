<?php


use Phinx\Migration\AbstractMigration;

class CreateVariableValueTable extends AbstractMigration
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
        $table = $this->table('strack_variable_value', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '自定义字段值D'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模型ID'])
            ->addColumn('variable_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属注册自定义字段ID'])
            ->addColumn('value', 'text', ['null'=>true, 'comment' => '自定义字段值'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['link_id'], ['type' => 'normal', 'name' => 'idx_value_link_id']);
        $table->addIndex(['variable_id'], ['type' => 'normal', 'name' => 'idx_value_variable_id']);

        //执行创建
        $table->create();
    }
}
