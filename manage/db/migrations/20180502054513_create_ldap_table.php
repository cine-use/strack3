<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateLdapTable extends AbstractMigration
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
        $table = $this->table('strack_ldap', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '域ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '域名称'])
            ->addColumn('domain_controllers', 'json', ['null' => true, 'comment' => '域服务器地址配置'])
            ->addColumn('base_dn', 'string', ['default' => '', 'limit' => 255, 'comment' => '基准DN'])
            ->addColumn('admin_username', 'string', ['default' => '', 'limit' => 255, 'comment' => '域管理员名'])
            ->addColumn('admin_password', 'string', ['default' => '', 'limit' => 255, 'comment' => '域管理员密码'])
            ->addColumn('port', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '端口（默认389）'])
            ->addColumn('ssl', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_TINY, 'comment' => '开启SSL'])
            ->addColumn('tls', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_TINY, 'comment' => '开启TSL'])
            ->addColumn('dn_whitelist', 'json', ['null' => true, 'comment' => 'DN白名单'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
