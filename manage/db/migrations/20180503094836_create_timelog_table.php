<?php


use Phinx\Migration\AbstractMigration;

class CreateTimelogTable extends AbstractMigration
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
        $table = $this->table('strack_timelog', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '时间日志ID'])
            ->addColumn('complete', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '时间日志完成状态'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '制作开始时间'])
            ->addColumn('end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '制作截至时间'])
            ->addColumn('description', 'text', ['null'=>true, 'comment' => '描述'])
            ->addColumn('user_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '用户ID'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['user_id'], ['type' => 'normal', 'name' => 'idx_user_id']);

        //执行创建
        $table->create();
    }
}
