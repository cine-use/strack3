<?php


use Phinx\Migration\AbstractMigration;

class CreateFileTable extends AbstractMigration
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
        $table = $this->table('strack_file', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '文件ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件名称'])
            ->addColumn('md5_name', 'string', ['default' => '', 'limit' => 128, 'comment' => 'MD5文件名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件编码'])
            ->addColumn('md5', 'string', ['default' => '', 'limit' => 128, 'comment' => 'md5验证码'])
            ->addColumn('file_commit_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联批次ID'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('file_type_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '文件类型ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联模型ID'])
            ->addColumn('status_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '状态ID'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '爸爸ID'])
            ->addColumn('version', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '版本号'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('diagram', 'json', ['null' => true, 'comment' => '文件引用关系'])
            ->addColumn('frame_range', 'string', ['default' => '', 'limit' => 255, 'comment' => '帧数'])
            ->addColumn('json', 'json', ['null' => true, 'comment' => '预留json字段（方便用户随意存储）'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
