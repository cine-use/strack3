<?php


use Phinx\Migration\AbstractMigration;

class FillAppendAdminModeRules extends AbstractMigration
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
         * 获取自定义字段配置node
         */
        $adminModeNodeRows = [
            [
                'name' => '模式',
                'code' => 'admin_mode',
                'lang' => 'Mode',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/Mode/index',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取系统模式配置',
                'code' => 'get_mode_config',
                'lang' => 'Get_Mode_Config',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/Mode/getModeConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '保存系统模式配置',
                'code' => 'save_mode_config',
                'lang' => 'Save_Mode_Config',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Admin/Mode/saveModeConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取系统模式列表',
                'code' => 'get_system_mode_list',
                'lang' => 'Get_System_Mode_List',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Widget/getSystemModeList',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '注册',
                'code' => 'register',
                'lang' => 'Register',
                'type' => 'route',
                'module' => 'page',
                'public' => 'yes',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Login/register',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($adminModeNodeRows)->save();

        /**
         * 分组/后台-模式页面
         */
        $adminModePageRows = [
            'group' => [
                'name' => '后台模式',
                'code' => 'admin_mode',
                'lang' => 'Mode',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模式页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 719,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取系统模式配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 720,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取系统模式列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 722,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModePageRows);

        // 模式提交按钮
        $adminModeSubmitButtonRows = [
            'group' => [
                'name' => '模式提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 字段保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存系统模式配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 721,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModeSubmitButtonRows);

        /**
         * 页面权限/后台-模式页面
         */
        $adminModePageRows = [
            'page' => [
                'name' => '模式',
                'code' => 'mode',
                'lang' => 'Mode',
                'page' => 'admin_mode_index',
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
                    'auth_group_id' => 480,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '模式访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'admin_mode_index',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 480,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '模式保存',
                        'code' => 'submit',
                        'lang' => 'Submit',
                        'page' => 'admin_mode_index',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 481,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($adminModePageRows);

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
