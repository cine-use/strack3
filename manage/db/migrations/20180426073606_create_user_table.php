<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUserTable extends AbstractMigration
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
        $table = $this->table('strack_user', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '用户ID'])
            ->addColumn('login_name', 'string', ['default' => '', 'limit' => 64, 'comment' => '登录名'])
            ->addColumn('email', 'string', ['default' => '', 'limit' => 128, 'comment' => '用户邮箱'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'comment' => '姓名'])
            ->addColumn('nickname', 'char', ['default' => '', 'limit' => 36, 'comment' => '短名称 允许为空 不能重复'])
            ->addColumn('phone', 'char', ['default' => '', 'limit' => 20, 'comment' => '手机号码'])
            ->addColumn('department_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_SMALL, 'comment' => '所属部门ID'])
            ->addColumn('password', 'string', ['default' => '', 'limit' => 128, 'comment' => '登录密码'])
            ->addColumn('status', 'enum', ['values' => 'in_service,departing', 'default' => 'in_service', 'comment' => '员工在职状态'])
            ->addColumn('login_session', 'string', ['default' => '', 'limit' => 128, 'comment' => '登录会话'])
            ->addColumn('login_count', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '登录次数'])
            ->addColumn('token_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => 'token过期时间'])
            ->addColumn('forget_count', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_SMALL, 'comment' => '找回次数'])
            ->addColumn('forget_token', 'char', ['default' => '', 'limit' => 32, 'comment' => '找回密码请求令牌'])
            ->addColumn('last_forget', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '最后找回密码时间'])
            ->addColumn('failed_login_count', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_SMALL, 'comment' => '登录失败次数'])
            ->addColumn('last_login', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '最后登录时间'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['login_name'], ['unique' => true, 'name' => 'idx_user_login_name']);
        $table->addIndex(['email'], ['unique' => true, 'name' => 'idx_user_email']);

        //执行创建
        $table->create();
    }
}
