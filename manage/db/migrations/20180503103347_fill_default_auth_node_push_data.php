<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthNodePushData extends AbstractMigration
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
        // 初始化table
        $table = $this->table('strack_auth_node');
        $rows = [
            [
                'name' => '获取关联查询数据',
                'code' => 'get_has_many_relation_data',
                'lang' => 'Get_Has_Many_Relation_Data',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Widget/getHasManyRelationData',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $table->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_node');
    }
}
