<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultAuthGroupNoteRulesData extends AbstractMigration
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

        /**
         * 反馈分组
         */
        $rows = [
            [ // 删除反馈
                'auth_group_id' => 124,
                'auth_node_id' => 192,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [ // 获取一条Note数据
                'auth_group_id' => 124,
                'auth_node_id' => 193,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
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
