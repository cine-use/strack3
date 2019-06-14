<?php


use Phinx\Migration\AbstractMigration;

class CreateProjectTable extends AbstractMigration
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
        $table = $this->table('strack_project', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '项目名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '项目编码'])
            ->addColumn('is_demo', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '是否是Demo项目'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目状态ID'])
            ->addColumn('rate', 'char', ['default' => '24', 'limit' => 6, 'comment' => '项目速率'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '项目描述'])
            ->addColumn('start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目开始日期'])
            ->addColumn('end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目结束日期'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
