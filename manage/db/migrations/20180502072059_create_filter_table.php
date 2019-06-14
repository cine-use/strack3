<?php


use Phinx\Migration\AbstractMigration;

class CreateFilterTable extends AbstractMigration
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
        $table = $this->table('strack_filter', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '过滤设置ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '过滤设置名称'])
            ->addColumn('color', 'enum', ['values' => 'red,orange,olive,green,teal,blue,violet,purple,pink,brown,grey,black', 'default' => 'grey', 'comment' => '过滤设置标记颜色'])
            ->addColumn('page', 'string', ['default' => '', 'limit' => 64, 'comment' => '所属页面'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('stick', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '是否置顶'])
            ->addColumn('public', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '是否公开'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '过滤设置配置'])
            ->addColumn('user_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属用户'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
