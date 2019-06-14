<?php


use Phinx\Migration\AbstractMigration;

class CreateCalendarTable extends AbstractMigration
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
        $table = $this->table('strack_calendar', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '日历ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '日历名'])
            ->addColumn('start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '开始时间'])
            ->addColumn('end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '结束时间'])
            ->addColumn('type', 'enum', ['values' => 'holiday,event,overtime', 'default' => 'holiday', 'comment' => '日历类型'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
