<?php


use Phinx\Migration\AbstractMigration;

class CreateEntityTable extends AbstractMigration
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
        $table = $this->table('strack_entity', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '实体ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '动作名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '动作编码'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级ID'])
            ->addColumn('parent_module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级模块ID'])
            ->addColumn('start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '开始时间'])
            ->addColumn('end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '结束时间'])
            ->addColumn('duration', 'char', ['default' => '', 'limit' => 8, 'comment' => '制作时长'])
            ->addColumn('workflow_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所使用任务流ID'])
            ->addColumn('json', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);


        //添加索引
        $table->addIndex(['module_id'], ['type' => 'normal', 'name' => 'idx_module_id']);
        $table->addIndex(['status_id'], ['type' => 'normal', 'name' => 'idx_status_id']);
        $table->addIndex(['project_id'], ['type' => 'normal', 'name' => 'idx_project_id']);

        //执行创建
        $table->create();
    }
}
