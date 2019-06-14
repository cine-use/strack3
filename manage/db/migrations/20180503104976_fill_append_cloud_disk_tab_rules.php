<?php


use Phinx\Migration\AbstractMigration;

class FillAppendCloudDiskTabRules extends AbstractMigration
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

    public function up()
    {
        /**
         * 云磁盘node
         */
        $adminCloudDiskNodeRows = [
            [
                'name' => '全局云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Page/cloud_disk',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '项目云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Project/page',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'view',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'cloud_disk',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($adminCloudDiskNodeRows)->save();

        /**
         * 云磁盘路由分组
         */
        $adminCloudDiskGroupRows = [
            'group' => [
                'name' => '云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 全局云磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 701,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 项目云磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 702,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminCloudDiskGroupRows);

        /**
         * 云盘按钮分组
         */
        $cloudDiskButtonGroupRows = [
            'group' => [
                'name' => '云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 云盘按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 703,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($cloudDiskButtonGroupRows);

        /**
         * 云磁盘页面权限
         */
        $cloudDiskButtonPageAuthRows = [
            'page' => [
                'name' => '云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'page' => 'home_project_page',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 466,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            "list" => [
                [
                    'page' => [
                        'name' => '云盘',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_project_page',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 466,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($cloudDiskButtonPageAuthRows, 0);


        $projectCloudDiskButtonPageAuthRows = [
            'page' => [
                'name' => '云盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'page' => 'home_page_cloud_disk',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 466,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            "list" => [
                [
                    'page' => [
                        'name' => '云盘',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_page_cloud_disk',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 466,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($projectCloudDiskButtonPageAuthRows, 0);

        /**
         * tab_bar 按钮详情页面和边侧栏页面权限
         */
        $pageAuthLinkData = $this->fetchAll('SELECT id,page,param,category FROM strack_page_auth WHERE code="tab_bar"');
        foreach ($pageAuthLinkData as $item) {
            $cloudDiskButtonPageAuthRows = [
                'page' => [
                    'name' => '云盘',
                    'code' => 'cloud_disk',
                    'lang' => 'Cloud_Disk',
                    'page' => $item['page'],
                    'param' => $item['param'],
                    'category' => $item['category'],
                    'type' => 'children',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 467,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                "list" => []
            ];

            $this->savePageAuth($cloudDiskButtonPageAuthRows, $item['id']);
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
