<?php


use Phinx\Migration\AbstractMigration;

class FillAppendAdminGridAdvFilterRules extends AbstractMigration
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
        $rows = [
            [
                "auth_group_id" => 68,
                "auth_node_id" => 226,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                "auth_group_id" => 25,
                "auth_node_id" => 226,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                "auth_group_id" => 89,
                "auth_node_id" => 226,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_group_node')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group_node');
    }
}
