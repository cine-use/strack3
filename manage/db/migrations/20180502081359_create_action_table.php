<?php


use Phinx\Migration\AbstractMigration;

class CreateActionTable extends AbstractMigration
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
        $table = $this->table('strack_action', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '动作ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '动作名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '动作编码'])
            ->addColumn('engine', 'string', ['default' => 'web', 'limit' => 128, 'comment' => '动作显示区域'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('type', 'enum', ['values' => 'launcher,plugin,tool,service,schedule', 'default' => 'launcher', 'comment' => '启动项'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '字段设置配置'])
            ->addColumn('author', 'string', ['default' => '', 'limit' => 128, 'comment' => '作者名称'])
            ->addColumn('version', 'char', ['default' => '', 'limit' => 36, 'comment' => '动作版本'])
            ->addColumn('frequency', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '使用次数最大值为999999999'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
