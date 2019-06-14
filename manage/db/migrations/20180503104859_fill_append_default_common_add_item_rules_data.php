<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultCommonAddItemRulesData extends AbstractMigration
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
     * 保存权限组
     * @param $data
     * @param int $parentId
     */
    protected function savePageAuth($data, $parentId = 0)
    {
        $pageAuthTable = $this->table('strack_page_auth');
        $pageLinkAuthTable = $this->table('strack_page_link_auth');

        $data["page"]["parent_id"] = $parentId;

        $pageAuthTable->insert($data["page"])->save();
        $query = $this->fetchRow('SELECT max(`id`) as id FROM strack_page_auth');

        if (!empty($data["auth_group"])) {
            foreach ($data["auth_group"] as $authGroup) {
                $authGroup["page_auth_id"] = $query["id"];
                $pageLinkAuthTable->insert($authGroup)->save();
            }
        }

        if (!empty($data["list"])) {
            foreach ($data["list"] as $children) {
                $this->savePageAuth($children, $query["id"]);
            }
        }
    }

    /**
     * Migrate Up.
     */
    public function up()
    {
        /**
         * 添加公共数据
         */
        $commonAddItemNodeRows = [
            [
                'name' => '添加公共数据',
                'code' => 'common_add_item',
                'lang' => 'Common_Add_Item',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Widget/commonAddItem',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($commonAddItemNodeRows)->save();

        /**
         * 获取状态列表分组
         */
        $commonAddItemGroupNodeRows = [
            [
                'auth_group_id' => 68,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 89,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 148,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 155,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 167,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 178,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 179,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 180,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 181,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 182,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 183,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'auth_group_id' => 194,
                'auth_node_id' => 690,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];

        $this->table('strack_auth_group_node')->insert($commonAddItemGroupNodeRows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_node');
        $this->execute('DELETE FROM strack_auth_group_node');
    }
}
