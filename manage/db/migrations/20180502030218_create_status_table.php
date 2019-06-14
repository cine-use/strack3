<?php


use Phinx\Migration\AbstractMigration;

class CreateStatusTable extends AbstractMigration
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
        $table = $this->table('strack_status', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '状态名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '状态编码'])
            ->addColumn('color', 'char', ['default' => '000000', 'limit' => 6, 'comment' => '状态颜色'])
            ->addColumn('icon', 'char', ['default' => '', 'limit' => 24, 'comment' => '状态图标'])
            ->addColumn('correspond', 'enum', ['values' => 'blocked,not_started,in_progress,daily,done,hide', 'default' => 'blocked', 'comment' => '状态从属关系'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
