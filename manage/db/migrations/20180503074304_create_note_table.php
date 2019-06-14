<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateNoteTable extends AbstractMigration
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
        $table = $this->table('strack_note', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '动态ID'])
            ->addColumn('type', 'enum', ['values' => 'text,audio', 'default' => 'text', 'comment' => '动态类型'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('stick', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '是否置顶'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('link_note_ids', 'text', ['null' => true, 'comment' => 'feedback note 解决了那几条 note'])
            ->addColumn('text', 'text', ['null' => true, 'limit'=> MysqlAdapter::TEXT_LONG, 'comment' => '动态内容'])
            ->addColumn('file_commit_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '记录关联的file_commit_id'])
            ->addColumn('last_updated', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '最后更新时间'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['type'], ['type' => 'normal', 'name' => 'idx_note_type']);
        $table->addIndex(['link_id'], ['type' => 'normal', 'name' => 'idx_link_id']);

        //执行创建
        $table->create();
    }
}
