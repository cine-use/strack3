<?php


use Phinx\Migration\AbstractMigration;

class CreateOauthCodeTable extends AbstractMigration
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
        $table = $this->table('strack_oauth_code', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => 'Oauth服务器ID'])
            ->addColumn('client_id', 'char', ['default' => '', 'limit' => 36, 'comment' => '客户ID'])
            ->addColumn('user_id', 'char', ['default' => '', 'limit' => 36, 'comment' => '用户ID'])
            ->addColumn('code', 'char', ['default' => '', 'limit' => 40, 'comment' => '编码'])
            ->addColumn('redirect_uri', 'string', ['default' => '', 'limit' => 255, 'comment' => '回调地址'])
            ->addColumn('expires', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '失效时间'])
            ->addColumn('scope', 'string', ['default' => '', 'limit' => 255, 'comment' => '范围'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
