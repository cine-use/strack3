<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthGroupPushData extends AbstractMigration
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
     * 保存权限组
     * @param $data
     */
    protected function saveAuthGroup($data)
    {
        // 初始化table
        $authGroupTable = $this->table('strack_auth_group');
        $authGroupNodeTable = $this->table('strack_auth_group_node');

        $authGroupTable->insert($data["group"])->save();
        $query = $this->fetchRow('SELECT max(`id`) as id FROM strack_auth_group');

        foreach ($data["rules"] as $authGroupNode) {
            $authGroupNode["auth_group_id"] = $query["id"];
            $authGroupNodeTable->insert($authGroupNode)->save();
        }
    }

    /**
     * Migrate Up.
     */
    public function up()
    {
        /**
         * 删除时间日志按钮
         */
        $deleteTimeLogButtonRows = [
            'group' => [
                'name' => '删除时间日志',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除时间日志按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除时间日志路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 217,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteTimeLogButtonRows);

        /**
         * 开始时间日志按钮
         */
        $startTimeLogButtonRows = [
            'group' => [
                'name' => '开始时间日志',
                'code' => 'start_stop',
                'lang' => 'Start_Stop',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 开始时间日志按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 361,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($startTimeLogButtonRows);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group');
        $this->execute('DELETE FROM strack_auth_group_node');
    }
}
