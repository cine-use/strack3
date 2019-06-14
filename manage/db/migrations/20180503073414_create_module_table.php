<?php


use Phinx\Migration\AbstractMigration;

class CreateModuleTable extends AbstractMigration
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
        $table = $this->table('strack_module', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('type', 'enum', ['values' => 'entity,fixed', 'default' => 'entity', 'comment' => '模块类型（实体、项目固定模块，顶层固定模块）'])
            ->addColumn('active', 'enum', ['values' => 'yes,no', 'default' => 'yes', 'comment' => '模块激活状态'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '模块名'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '模块编码'])
            ->addColumn('icon', 'char', ['default' => '', 'limit' => 24, 'comment' => '模块图标'])
            ->addColumn('number', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块数字'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
