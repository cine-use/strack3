<?php


use Phinx\Migration\AbstractMigration;

class FillAppendAdminCloudDiskRules extends AbstractMigration
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
                'name' => '云磁盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/cloudDisk/index',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取云磁盘配置',
                'code' => 'get_cloud_disk_config',
                'lang' => 'Get_Cloud_Disk_Config',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/CloudDisk/getCloudDiskConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '修改云磁盘配置',
                'code' => 'update_cloud_disk_config',
                'lang' => 'Update_Cloud_Disk_Config',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/CloudDisk/updateCloudDiskConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($adminCloudDiskNodeRows)->save();

        /**
         * 云磁盘分组
         */
        $adminCloudDiskGroupRows = [
            'group' => [
                'name' => '云磁盘',
                'code' => 'cloud_disk',
                'lang' => 'Cloud_Disk',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 云磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 698,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取云磁盘配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 699,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminCloudDiskGroupRows);

        // 后台工序提交按钮
        $adminCloudDiskSubmitRows = [
            'group' => [
                'name' => '云磁盘提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改云磁盘配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 700,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminCloudDiskSubmitRows);

        /**
         * 后台-云磁盘页面
         */
        $adminCloudDiskRows = [
            'page' => [
                'name' => '后台云磁盘页面',
                'code' => 'cloudDisk',
                'lang' => 'Admin_Cloud_Disk',
                'page' => 'admin_cloudDisk_index',
                'menu' => 'admin_menu',
                'category' => 'Admin_Scene',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 464,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '后台云磁盘页面',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'admin_cloudDisk_index',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 465,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '云磁盘提交',
                        'code' => 'submit',
                        'lang' => 'Submit',
                        'page' => 'admin_cloudDisk_index',
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

        $this->savePageAuth($adminCloudDiskRows);

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
