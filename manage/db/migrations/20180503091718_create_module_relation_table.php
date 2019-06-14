<?php


use Phinx\Migration\AbstractMigration;

class CreateModuleRelationTable extends AbstractMigration
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
        $table = $this->table('strack_module_relation', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '模型关联ID'])
            ->addColumn('type', 'enum', ['values' => 'has_one,belong_to,has_many,many_to_many', 'default' => 'has_one', 'comment' => '关联类型'])
            ->addColumn('src_module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '来自实体模型ID'])
            ->addColumn('dst_module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '目标实体ID'])
            ->addColumn('link_id', 'string', ['default' => '', 'limit' => 64, 'comment' => '关联外键'])
            ->addColumn('node_config', 'json', ['null' => true, 'comment' => '节点配置'])
            ->addColumn('schema_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '数据结构ID'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
