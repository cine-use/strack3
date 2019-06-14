<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultViewRulesData extends AbstractMigration
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
         * 保存默认视图node
         */
        $saveDefaultViewNodeRows = [
            [
                'name' => '保存默认视图',
                'code' => 'save_default_view',
                'lang' => 'Save_Default_View',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/View/saveDefaultView',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($saveDefaultViewNodeRows)->save();

        /**
         * 保存默认视图分组
         */
        $saveDefaultViewGroupRows = [
            'group' => [
                'name' => '保存默认视图',
                'code' => 'save_default_view',
                'lang' => 'Save_Default_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保存默认视图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存默认视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 688,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($saveDefaultViewGroupRows);

        /**
         * 保存固定模块默认视图
         */
        $saveDefaultViewFixedPageAuthRows = [
            [
                'page' => 'admin_account_index',
                'parent_id' => 106,
            ],
            [
                'page' => 'home_project_media',
                'parent_id' => 280,
            ],
            [
                'page' => 'home_project_overview',
                'parent_id' => 307
            ],
            [
                'page' => 'home_details_index',
                'parent_id' => 367,
            ],
            [
                'page' => 'home_details_index',
                'parent_id' => 393,
            ],
            [
                'page' => 'home_details_index',
                'parent_id' => 421,
            ],
            [
                'page' => 'home_project_base',
                'parent_id' => 449,
            ],
            [
                'page' => 'home_project_file',
                'parent_id' => 491,
            ],
            [
                'page' => 'home_project_note',
                'parent_id' => 576,
            ],
            [
                'page' => 'home_project_onset',
                'parent_id' => 619,
            ],
            [
                'page' => 'home_project_timelog',
                'parent_id' => 662,
            ]
        ];

        foreach ($saveDefaultViewFixedPageAuthRows as $item) {
            $saveDefaultViewPageAuthFixedRows = [
                'page' => [
                    'name' => '保存默认视图',
                    'code' => 'save_default_view',
                    'lang' => 'Save_Default_View',
                    'page' => $item['page'],
                    'param' => '',
                    'type' => 'belong',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 456,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                "list" => []
            ];
            $this->savePageAuth($saveDefaultViewPageAuthFixedRows, $item['parent_id']);
        }

        /**
         * 获取所有已存在的实体，增加权限
         */
        $entityPageList = $this->fetchAll('SELECT id,param FROM strack_page_auth where `page`="home_project_entity" and `code`="view"');
        foreach ($entityPageList as $item) {
            $saveDefaultViewPageAuthEntityRows = [
                'page' => [
                    'name' => '保存默认视图',
                    'code' => 'save_default_view',
                    'lang' => 'Save_Default_View',
                    'page' => 'home_project_entity',
                    'param' => $item['param'],
                    'type' => 'belong',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 456,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                "list" => []
            ];
            $this->savePageAuth($saveDefaultViewPageAuthEntityRows, $item['id']);
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_node');
        $this->execute('DELETE FROM strack_auth_group_node');
        $this->execute('DELETE FROM strack_page_auth');
        $this->execute('DELETE FROM strack_page_link_auth');
    }
}
