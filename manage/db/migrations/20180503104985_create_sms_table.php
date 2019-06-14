<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateSmsTable extends AbstractMigration
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
        $table = $this->table('strack_sms', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '短信ID'])
            ->addColumn('type', 'enum', ['values' => 'register,login', 'default' => 'register', 'comment' => '短信类型'])
            ->addColumn('active', 'enum', ['values' => 'yes,no', 'default' => 'yes', 'comment' => '是否有效'])
            ->addColumn('user_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '用户ID'])
            ->addColumn('batch', 'char', ['default' => '', 'limit' => 20, 'comment' => '批次'])
            ->addColumn('ip', 'char', ['default' => '', 'limit' => 32, 'comment' => 'IP地址'])
            ->addColumn('phone', 'char', ['default' => '', 'limit' => 20, 'comment' => '手机号码'])
            ->addColumn('validate_code', 'string', ['default' => '', 'limit' => 64, 'comment' => '验证码'])
            ->addColumn('deadline', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '过期时间'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
