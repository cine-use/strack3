<?php


use Phinx\Migration\AbstractMigration;

class CreateViewDefaultTable extends AbstractMigration
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
        $table = $this->table('strack_view_default', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '默认视图ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '默认视图名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '默认视图编码'])
            ->addColumn('page', 'string', ['default' => '', 'limit' => 64, 'comment' => '所属页面'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '默认视图设置'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
