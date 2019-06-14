<?php


use Phinx\Migration\AbstractMigration;

class CreateReviewLinkTable extends AbstractMigration
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
        $table = $this->table('strack_review_link', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '审核实体关联ID'])
            ->addColumn('entity_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '审核实体ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('file_commit_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联批次ID'])
            ->addColumn('index', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '排序'])
            ->addColumn('json', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['project_id'], ['type' => 'normal', 'name' => 'idx_project_id']);

        //执行创建
        $table->create();
    }
}
