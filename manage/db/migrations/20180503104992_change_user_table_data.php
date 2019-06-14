<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ChangeUserTableData extends AbstractMigration
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

    public function up()
    {

        // 添加数据字段
        $this->table('strack_user')
            ->addColumn('login_secret_key', 'string', ['default' => '', 'limit' => 32, 'comment' => '登录秘钥'])
            ->save();

        // 添加数据字段
        $this->execute('UPDATE `strack_user` SET `login_secret_key`="RFASLZAGI3GKDNNT" WHERE `login_name`= "strack_admin"');

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_user');
    }
}
