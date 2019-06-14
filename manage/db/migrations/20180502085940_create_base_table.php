<?php


use Phinx\Migration\AbstractMigration;

class CreateBaseTable extends AbstractMigration
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
        $table = $this->table('strack_base', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '基础数据ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '基础数据名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '基础数据编码'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('entity_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '实体ID'])
            ->addColumn('entity_module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '实体模块ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('step_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '工序ID'])
            ->addColumn('priority', 'enum', ['values' => 'normal,urgent,high,medium,low', 'default' => 'normal', 'comment' => '优先级'])
            ->addColumn('start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '制作开始时间'])
            ->addColumn('end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '制作截至时间'])
            ->addColumn('duration', 'char', ['default' => '', 'limit' => 8, 'comment' => '制作时长'])
            ->addColumn('plan_start_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '计划制作开始时间'])
            ->addColumn('plan_end_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '计划制作截至时间'])
            ->addColumn('plan_duration', 'char', ['default' => '', 'limit' => 8, 'comment' => '计划制作时长'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('json', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['entity_id'], ['type' => 'normal', 'name' => 'idx_entity_id']);
        $table->addIndex(['status_id'], ['type' => 'normal', 'name' => 'idx_status_id']);
        $table->addIndex(['project_id'], ['type' => 'normal', 'name' => 'idx_project_id']);

        //执行创建
        $table->create();
    }
}
