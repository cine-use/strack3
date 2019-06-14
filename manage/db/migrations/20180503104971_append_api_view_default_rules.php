<?php


use Phinx\Migration\AbstractMigration;

class AppendApiViewDefaultRules extends AbstractMigration
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
     * @throws Exception
     */
    public function up()
    {
        $nodeRows = [
            [
                'name' => '删除默认视图',
                'code' => 'delete_default_view',
                'lang' => 'Delete_Default_View',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/deleteDefaultView',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '查找单个默认视图',
                'code' => 'find_default_view',
                'lang' => 'Find_Default_View',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/findDefaultView',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($nodeRows)->save();

        /**
         * 删除默认视图
         */
        $deleteDefaultViewGroupRows = [
            'group' => [
                'name' => '删除默认视图',
                'code' => 'delete_default_view',
                'lang' => 'Delete_Default_View',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除默认视图
                    'auth_group_id' => 0,
                    'auth_node_id' => 696,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteDefaultViewGroupRows);

        /**
         * 查找单个默认视图
         */
        $findDefaultViewGroupRows = [
            'group' => [
                'name' => '查找单个默认视图',
                'code' => 'find_default_view',
                'lang' => 'Find_Default_View',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 查找单个默认视图
                    'auth_group_id' => 0,
                    'auth_node_id' => 697,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($findDefaultViewGroupRows);

        /**
         * 删除默认视图
         */
        $deleteDefaultViewPathPageRows = [
            'page' => [
                'name' => '删除默认视图',
                'code' => 'delete_default_view',
                'lang' => 'Delete_Default_View',
                'page' => 'api_view',
                'param' => 'deletedefaultview',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 462,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($deleteDefaultViewPathPageRows, 944);

        /**
         * 查找单个默认视图
         */
        $findDefaultViewPathPageRows = [
            'page' => [
                'name' => '查找单个默认视图',
                'code' => 'find_default_view',
                'lang' => 'Find_Default_View',
                'page' => 'api_view',
                'param' => 'finddefaultview',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 463,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($findDefaultViewPathPageRows, 944);
    }

    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group');
        $this->execute('DELETE FROM strack_auth_group_node');
        $this->execute('DELETE FROM strack_page_auth');
        $this->execute('DELETE FROM strack_page_link_auth');
    }
}
