<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultAdminUserRulesData extends AbstractMigration
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
        $this->execute('UPDATE `strack_auth_group_node` SET  `auth_node_id`=288 WHERE (`id`=177)');

        $this->execute('UPDATE `strack_auth_group_node` SET  `auth_node_id`=289 WHERE (`id`=178)');

        $this->execute('UPDATE `strack_auth_group_node` SET  `auth_node_id`=290 WHERE (`id`=179)');

        $this->execute('UPDATE `strack_auth_group_node` SET  `auth_node_id`=308 WHERE (`id`=180)');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group_node');
    }
}
