<?php


use Phinx\Migration\AbstractMigration;

class CreateRoleUserTable extends AbstractMigration
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
        $table = $this->table('strack_role_user', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '角色权限ID'])
            ->addColumn('user_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '用户ID'])
            ->addColumn('role_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '角色ID'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['role_id'], ['type' => 'normal', 'name' => 'idx_auth_role_id']);

        //执行创建
        $table->create();
    }
}
