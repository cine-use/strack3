<?php


use Phinx\Migration\AbstractMigration;

use Phinx\Db\Adapter\MysqlAdapter;

class CreateAuthAccessTable extends AbstractMigration
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
        $table = $this->table('strack_auth_access', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '权限ID'])
            ->addColumn('role_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '角色ID'])
            ->addColumn('auth_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '节点ID'])
            ->addColumn('page', 'string', ['default' => '', 'limit' => 128, 'comment' => '所属页面'])
            ->addColumn('param', 'string', ['default' => '', 'limit' => 128, 'comment' => '所属页面'])
            ->addColumn('permission', 'string', ['default' => 'deny', 'limit' => 128, 'comment' => '权限状态(deny,allow,view,create,modify,delete,clear)'])
            ->addColumn('type', 'enum', ['values' => 'page,field', 'default' => 'page', 'comment' => '权限类型'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '字段所属模块ID'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '字段所属项目ID'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
