<?php


use Phinx\Migration\AbstractMigration;

class FillAppendApiViewRules extends AbstractMigration
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
         * api视图 node
         */
        $apiViewNodeRows = [
            [
                'name' => '视图单条查找',
                'code' => 'view_find',
                'lang' => 'View_Find',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Find',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图多条查找',
                'code' => 'view_select',
                'lang' => 'View_Select',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Select',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图修改',
                'code' => 'view_update',
                'lang' => 'View_Update',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Update',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图创建',
                'code' => 'view_create',
                'lang' => 'View_Create',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Create',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图删除',
                'code' => 'view_delete',
                'lang' => 'View_Delete',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Delete',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图字段',
                'code' => 'view_fields',
                'lang' => 'View_Fields',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/View/Fields',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用单条查找',
                'code' => 'view_use_find',
                'lang' => 'View_Use_Find',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Find',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用多条查找',
                'code' => 'view_use_select',
                'lang' => 'View_Use_Select',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Select',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用修改',
                'code' => 'view_update',
                'lang' => 'View_Update',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Update',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用创建',
                'code' => 'view_use_create',
                'lang' => 'View_Use_Create',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Create',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用删除',
                'code' => 'view_use_delete',
                'lang' => 'View_Use_Delete',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Delete',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '视图使用字段',
                'code' => 'view_use_fields',
                'lang' => 'View_Use_Fields',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/ViewUse/Fields',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
        ];
        $this->table('strack_auth_node')->insert($apiViewNodeRows)->save();


        /**
         * 视图单条查找
         */
        $viewFindRouteRows = [
            'group' => [
                'name' => '视图单条查找',
                'code' => 'view_find',
                'lang' => 'View_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 706,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewFindRouteRows);

        /**
         * 视图多条查找
         */
        $viewSelectRouteRows = [
            'group' => [
                'name' => '视图多条查找',
                'code' => 'view_select',
                'lang' => 'View_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 707,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewSelectRouteRows);

        /**
         * 视图修改
         */
        $viewUpdateRouteRows = [
            'group' => [
                'name' => '视图修改',
                'code' => 'view_update',
                'lang' => 'View_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 708,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUpdateRouteRows);

        /**
         * 视图创建
         */
        $viewCreateRouteRows = [
            'group' => [
                'name' => '视图创建',
                'code' => 'view_create',
                'lang' => 'View_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 709,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewCreateRouteRows);

        /**
         * 视图删除
         */
        $viewUpdateRouteRows = [
            'group' => [
                'name' => '视图删除',
                'code' => 'view_delete',
                'lang' => 'View_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 710,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUpdateRouteRows);

        /**
         * 视图字段
         */
        $viewFieldsRouteRows = [
            'group' => [
                'name' => '视图字段',
                'code' => 'view_fields',
                'lang' => 'View_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 711,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewFieldsRouteRows);

        /**
         * 视图使用单条查找
         */
        $viewUseFindRouteRows = [
            'group' => [
                'name' => '视图使用单条查找',
                'code' => 'view_use_find',
                'lang' => 'View_Use_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 712,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseFindRouteRows);

        /**
         * 视图使用多条查找
         */
        $viewUseSelectRouteRows = [
            'group' => [
                'name' => '视图使用多条查找',
                'code' => 'view_use_select',
                'lang' => 'View_Use_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 713,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseSelectRouteRows);

        /**
         * 视图使用修改
         */
        $viewUseUpdateRouteRows = [
            'group' => [
                'name' => '视图使用修改',
                'code' => 'view_use_update',
                'lang' => 'View_Use_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 714,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseUpdateRouteRows);

        /**
         * 视图使用创建
         */
        $viewUseCreateRouteRows = [
            'group' => [
                'name' => '视图使用创建',
                'code' => 'view_use_create',
                'lang' => 'View_Use_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 715,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseCreateRouteRows);

        /**
         * 视图使用删除
         */
        $viewUseDeleteRouteRows = [
            'group' => [
                'name' => '视图使用删除',
                'code' => 'view_use_delete',
                'lang' => 'View_Use_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 716,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseDeleteRouteRows);

        /**
         * 视图使用字段
         */
        $viewUseFieldsRouteRows = [
            'group' => [
                'name' => '视图使用字段',
                'code' => 'view_use_fields',
                'lang' => 'View_Use_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 视图使用字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 717,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewUseFieldsRouteRows);

        /**
         * 视图单条查找
         */
        $viewFindPageRows = [
            'page' => [
                'name' => '视图单条查找',
                'code' => 'view_find',
                'lang' => 'Find',
                'page' => 'api_view',
                'param' => 'find',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 468,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($viewFindPageRows, 944);

        /**
         * 视图多条查找
         */
        $ViewSelectPageRows = [
            'page' => [
                'name' => '视图多条查找',
                'code' => 'view_select',
                'lang' => 'Select',
                'page' => 'api_view',
                'param' => 'select',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 469,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($ViewSelectPageRows, 944);

        /**
         * 视图修改
         */
        $viewUpdatePageRows = [
            'page' => [
                'name' => '视图修改',
                'code' => 'view_create',
                'lang' => 'Update',
                'page' => 'api_view',
                'param' => 'update',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 470,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($viewUpdatePageRows, 944);

        /**
         * 视图创建
         */
        $viewCreatePageRows = [
            'page' => [
                'name' => '视图创建',
                'code' => 'view_create',
                'lang' => 'Create',
                'page' => 'api_view',
                'param' => 'create',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 471,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($viewCreatePageRows, 944);

        /**
         * 视图删除
         */
        $viewDeletePageRows = [
            'page' => [
                'name' => '视图删除',
                'code' => 'view_delete',
                'lang' => 'Delete',
                'page' => 'api_view',
                'param' => 'delete',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 472,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($viewDeletePageRows, 944);

        /**
         * 视图字段
         */
        $viewFieldsPageRows = [
            'page' => [
                'name' => '视图字段',
                'code' => 'view_fields',
                'lang' => 'Get_Fields',
                'page' => 'api_view',
                'param' => 'fields',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 473,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($viewFieldsPageRows, 944);


        /**
         * 视图使用模块
         */
        $viewUseModuleRows = [
            'page' => [
                'name' => '视图使用模块',
                'code' => 'view_use',
                'lang' => 'View_Use',
                'page' => 'api_view_use',
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
                        'name' => '视图使用单条查找',
                        'code' => 'view_use_find',
                        'lang' => 'Find',
                        'page' => 'api_view_use',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 474,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '视图使用多条查找',
                        'code' => 'view_use_select',
                        'lang' => 'Select',
                        'page' => 'api_view_use',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 475,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '视图使用修改',
                        'code' => 'view_use_update',
                        'lang' => 'Update',
                        'page' => 'api_view_use',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 476,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '视图使用创建',
                        'code' => 'view_use_create',
                        'lang' => 'Create',
                        'page' => 'api_view_use',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 477,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '视图使用删除',
                        'code' => 'view_use_delete',
                        'lang' => 'Delete',
                        'page' => 'api_view_use',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 478,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '视图使用字段',
                        'code' => 'view_use_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_view_use',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 479,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($viewUseModuleRows, 0);

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
