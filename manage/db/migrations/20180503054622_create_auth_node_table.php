<?php


use Phinx\Migration\AbstractMigration;


class CreateAuthNodeTable extends AbstractMigration
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
        $table = $this->table('strack_auth_node', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '权限资源ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '权限资源名'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '权限资源编码'])
            ->addColumn('lang', 'string', ['default' => '', 'limit' => 128, 'comment' => '语言包'])
            ->addColumn('type', 'enum', ['values' => 'route,view', 'default' => 'view', 'comment' => '权限资源类型'])
            ->addColumn('module', 'enum', ['values' => 'page,api', 'default' => 'page', 'comment' => '权限所属模块'])
            ->addColumn('public', 'enum', ['values' => 'yes,no', 'default' => 'no', 'comment' => '权限资源是否是公共类型'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '模块ID'])
            ->addColumn('rules', 'text', ['null' => true, 'comment' => '规则配置'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
