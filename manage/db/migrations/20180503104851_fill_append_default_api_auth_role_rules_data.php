<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultApiAuthRoleRulesData extends AbstractMigration
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
         * auth_node添加
         */
        $rows = [
            [
                'name' => '角色创建',
                'code' => 'role_create',
                'lang' => 'Role_create',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/create',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '角色修改',
                'code' => 'role_update',
                'lang' => 'Role_Update',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/update',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '角色删除',
                'code' => 'role_delete',
                'lang' => 'Role_Delete',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/delete',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '角色单条查找',
                'code' => 'role_find',
                'lang' => 'Role_Find',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/find',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '角色多条查找',
                'code' => 'role_select',
                'lang' => 'Role_Select',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/select',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '角色字段',
                'code' => 'role_fields',
                'lang' => 'Role_fields',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/role/fields',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($rows)->save();

        /**
         * 角色单条查找
         */
        $roleFindRouteRows = [
            'group' => [
                'name' => '角色单条查找',
                'code' => 'role_find',
                'lang' => 'Role_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 682,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleFindRouteRows);

        /**
         * 角色多条查找
         */
        $roleSelectRouteRows = [
            'group' => [
                'name' => '角色多条查找',
                'code' => 'role_select',
                'lang' => 'Role_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 683,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleSelectRouteRows);

        /**
         * 角色修改
         */
        $roleUpdateRouteRows = [
            'group' => [
                'name' => '角色修改',
                'code' => 'role_update',
                'lang' => 'Role_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 684,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleUpdateRouteRows);

        /**
         * 角色创建
         */
        $roleCreateRouteRows = [
            'group' => [
                'name' => '角色创建',
                'code' => 'role_create',
                'lang' => 'Role_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 685,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleCreateRouteRows);

        /**
         * 角色删除
         */
        $roleUpdateRouteRows = [
            'group' => [
                'name' => '角色删除',
                'code' => 'role_delete',
                'lang' => 'Role_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 686,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleUpdateRouteRows);

        /**
         * 角色字段
         */
        $roleFieldsRouteRows = [
            'group' => [
                'name' => '角色字段',
                'code' => 'role_fields',
                'lang' => 'Role_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 687,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($roleFieldsRouteRows);

        /**
         * 角色模块
         */
        $roleModuleRows = [
            'page' => [
                'name' => '角色模块',
                'code' => 'role',
                'lang' => 'Role',
                'page' => 'api_role',
                'menu' => 'api',
                'category' => 'API_Module',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '角色单条查找',
                        'code' => 'role_find',
                        'lang' => 'Find',
                        'page' => 'api_role',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 450,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '角色多条查找',
                        'code' => 'role_select',
                        'lang' => 'Select',
                        'page' => 'api_role',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 451,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '角色修改',
                        'code' => 'role_update',
                        'lang' => 'Update',
                        'page' => 'api_role',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 452,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '角色创建',
                        'code' => 'role_create',
                        'lang' => 'Create',
                        'page' => 'api_role',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 453,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '角色删除',
                        'code' => 'role_delete',
                        'lang' => 'Delete',
                        'page' => 'api_role',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 454,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '角色字段',
                        'code' => 'role_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_role',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 455,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($roleModuleRows);

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
