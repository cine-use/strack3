<?php


use Phinx\Migration\AbstractMigration;

class CreateFileCommitTable extends AbstractMigration
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
        $table = $this->table('strack_file_commit', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '文件ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件编码'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联模型ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('version', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '批次号'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('check_list', 'json', ['null' => true, 'comment' => '检查项'])
            ->addColumn('json', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
