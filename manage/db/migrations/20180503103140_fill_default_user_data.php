<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultUserData extends AbstractMigration
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

    /**
     * Migrate Up.
     */
    public function up()
    {
        $rows = [
            [
                'login_name' => 'strack_admin',
                'email' => 'admin@strack.com',
                'name' => 'administrator',
                'nickname' => 'admin',
                'phone' => '88888888888',
                'department_id' => 0,
                'password' => '$P$BRpF99iQ4yAtVa2364s9aJVCga7yJY.',
                'status' => 'in_service',
                'login_session' => '',
                'login_count' => 0,
                'token_time' => 0,
                'forget_count' => 0,
                'forget_token' => '',
                'last_forget' => 0,
                'failed_login_count' => 0,
                'last_login' => 0,
                'created' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string,
            ],
            [
                'login_name' => 'strack',
                'email' => 'client@strack.com',
                'name' => 'strack',
                'nickname' => 'strack',
                'phone' => '88888888888',
                'department_id' => 0,
                'password' => '$P$BB0ZJe5KfVnsY4pxiBRwK/PYekgFSE1',
                'status' => 'in_service',
                'login_session' => '',
                'login_count' => 0,
                'token_time' => 0,
                'forget_count' => 0,
                'forget_token' => '',
                'last_forget' => 0,
                'failed_login_count' => 0,
                'last_login' => 0,
                'created' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string,
            ]
        ];

        $this->table('strack_user')->insert($rows)->save();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_user');
    }
}
