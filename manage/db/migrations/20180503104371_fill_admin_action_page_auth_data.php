<?php


use Phinx\Migration\AbstractMigration;

class FillAdminActionPageAuthData extends AbstractMigration
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
         * 后台动作页面
         */
        $adminActionPageRows = [
            'page' => [
                'name' => '动作',
                'code' => 'action',
                'lang' => 'Action',
                'page' => 'admin_action_index',
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
                    'auth_group_id' => 89,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '动作访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'admin_action_index',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 89,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工具栏',
                        'code' => 'toolbar',
                        'lang' => 'Toolbar',
                        'page' => 'admin_action_index',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '删除动作',
                                'code' => 'delete',
                                'lang' => 'Delete',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 186,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '排序',
                                'code' => 'sort',
                                'lang' => 'Sort',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 8,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '分组',
                                'code' => 'group',
                                'lang' => 'Group',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 9,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '字段',
                                'code' => 'column',
                                'lang' => 'Field',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '管理自定义字段',
                                        'code' => 'manage_custom_fields',
                                        'lang' => 'Manage_Custom_Fields',
                                        'page' => 'admin_action_index',
                                        'param' => '',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 10,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [ // 过滤面板
                    'page' => [
                        'name' => '过滤面板',
                        'code' => 'filter_panel',
                        'lang' => 'Filter_Panel',
                        'page' => 'admin_action_index',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '保存过滤条件',
                                'code' => 'save_filter',
                                'lang' => 'Save_Filter',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 16,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '保持显示',
                                'code' => 'keep_display',
                                'lang' => 'Keep_Display',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 187,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '置顶过滤',
                                'code' => 'stick_filter',
                                'lang' => 'Stick_Filter',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 191,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '删除过滤',
                                'code' => 'delete',
                                'lang' => 'Delete',
                                'page' => 'admin_action_index',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 192,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '右键菜单',
                        'code' => 'right_button_menu',
                        'lang' => 'Right_Button_Menu',
                        'page' => 'admin_action_index',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ]
            ]
        ];

        $this->savePageAuth($adminActionPageRows);

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_page_auth');
        $this->execute('DELETE FROM strack_page_link_auth');
    }
}
