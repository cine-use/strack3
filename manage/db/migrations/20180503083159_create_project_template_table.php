<?php


use Phinx\Migration\AbstractMigration;

class CreateProjectTemplateTable extends AbstractMigration
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
        $table = $this->table('strack_project_template', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '项目模板ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '项目模板名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '项目模板编码'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属项目ID，默认为0'])
            ->addColumn('schema_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属数据结构ID'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '模板配置'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
