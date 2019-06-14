<?php


use Phinx\Migration\AbstractMigration;

class FillApiModuleAuthData extends AbstractMigration
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
         * 动作模块
         */
        $actionModuleRows = [
            'page' => [
                'name' => '动作模块',
                'code' => 'action',
                'lang' => 'Action',
                'page' => 'api_action',
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
                        'name' => '动作单条查找',
                        'code' => 'action_find',
                        'lang' => 'Find',
                        'page' => 'api_action',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 195,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '动作多条查找',
                        'code' => 'action_select',
                        'lang' => 'Select',
                        'page' => 'api_action',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 196,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '动作修改',
                        'code' => 'action_update',
                        'lang' => 'Update',
                        'page' => 'api_action',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 197,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '动作创建',
                        'code' => 'action_create',
                        'lang' => 'Create',
                        'page' => 'api_action',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 198,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '动作删除',
                        'code' => 'action_delete',
                        'lang' => 'Delete',
                        'page' => 'api_action',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 199,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '动作字段',
                        'code' => 'action_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_action',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 200,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($actionModuleRows);

        /**
         * 日历模块
         */
        $calendarModuleRows = [
            'page' => [
                'name' => '日历模块',
                'code' => 'calendar',
                'lang' => 'Calendar',
                'page' => 'api_calendar',
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
                        'name' => '日历单条查找',
                        'code' => 'calendar_find',
                        'lang' => 'Find',
                        'page' => 'api_calendar',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 201,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '日历多条查找',
                        'code' => 'calendar_select',
                        'lang' => 'Select',
                        'page' => 'api_calendar',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 202,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '日历修改',
                        'code' => 'calendar_update',
                        'lang' => 'Update',
                        'page' => 'api_calendar',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 203,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '日历创建',
                        'code' => 'calendar_create',
                        'lang' => 'Create',
                        'page' => 'api_calendar',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 204,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '日历删除',
                        'code' => 'calendar_delete',
                        'lang' => 'Delete',
                        'page' => 'api_calendar',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 205,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '日历字段',
                        'code' => 'calendar_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_calendar',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 206,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($calendarModuleRows);

        /**
         * 部门模块
         */
        $departmentModuleRows = [
            'page' => [
                'name' => '部门模块',
                'code' => 'department',
                'lang' => 'Department',
                'page' => 'api_department',
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
                        'name' => '部门单条查找',
                        'code' => 'department_find',
                        'lang' => 'Find',
                        'page' => 'api_department',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 207,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '部门多条查找',
                        'code' => 'department_select',
                        'lang' => 'Select',
                        'page' => 'api_department',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 208,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '部门修改',
                        'code' => 'department_update',
                        'lang' => 'Update',
                        'page' => 'api_department',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 209,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '部门创建',
                        'code' => 'department_create',
                        'lang' => 'Create',
                        'page' => 'api_department',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 210,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '部门删除',
                        'code' => 'department_delete',
                        'lang' => 'Delete',
                        'page' => 'api_department',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 211,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '部门字段',
                        'code' => 'department_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_department',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 212,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($departmentModuleRows);

        /**
         * 目录模板模块
         */
        $dirTemplateModuleRows = [
            'page' => [
                'name' => '目录模板模块',
                'code' => 'dirtemplate',
                'lang' => 'Dir_Template',
                'page' => 'api_dirtemplate',
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
                        'name' => '目录模板单条查找',
                        'code' => 'dirtemplate_find',
                        'lang' => 'Find',
                        'page' => 'api_dirtemplate',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 213,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录模板多条查找',
                        'code' => 'dirtemplate_select',
                        'lang' => 'Select',
                        'page' => 'api_dirtemplate',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 214,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录模板修改',
                        'code' => 'dirtemplate_update',
                        'lang' => 'Update',
                        'page' => 'api_dirtemplate',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 215,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录模板创建',
                        'code' => 'dirtemplate_create',
                        'lang' => 'Create',
                        'page' => 'api_dirtemplate',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 216,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录模板删除',
                        'code' => 'dirtemplate_delete',
                        'lang' => 'Delete',
                        'page' => 'api_dirtemplate',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 217,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录模板字段',
                        'code' => 'dirtemplate_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_dirtemplate',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 218,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '模板路径',
                        'code' => 'get_template_path',
                        'lang' => 'Get_Template_Path',
                        'page' => 'api_dirtemplate',
                        'param' => 'gettemplatepath',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 408,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目路径',
                        'code' => 'get_item_path',
                        'lang' => 'Get_Item_Path',
                        'page' => 'api_dirtemplate',
                        'param' => 'getitempath',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 409,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($dirTemplateModuleRows);

        /**
         * 目录变量模块
         */
        $dirVariableModuleRows = [
            'page' => [
                'name' => '目录变量模块',
                'code' => 'dirvariable',
                'lang' => 'Dir_Variable',
                'page' => 'api_dirvariable',
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
                        'name' => '目录变量单条查找',
                        'code' => 'dirvariable_find',
                        'lang' => 'Find',
                        'page' => 'api_dirvariable',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 219,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录变量多条查找',
                        'code' => 'dirvariable_select',
                        'lang' => 'Select',
                        'page' => 'api_dirvariable',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 220,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录变量修改',
                        'code' => 'dirvariable_update',
                        'lang' => 'Update',
                        'page' => 'api_dirvariable',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 221,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录变量创建',
                        'code' => 'dirvariable_create',
                        'lang' => 'Create',
                        'page' => 'api_dirvariable',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 222,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录变量删除',
                        'code' => 'dirvariable_delete',
                        'lang' => 'Delete',
                        'page' => 'api_dirvariable',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 223,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '目录变量字段',
                        'code' => 'dirvariable_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_dirvariable',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 224,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($dirVariableModuleRows);

        /**
         * 磁盘模块
         */
        $diskModuleRows = [
            'page' => [
                'name' => '磁盘模块',
                'code' => 'disk',
                'lang' => 'Disks',
                'page' => 'api_disk',
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
                        'name' => '磁盘单条查找',
                        'code' => 'disk_find',
                        'lang' => 'Find',
                        'page' => 'api_disk',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 225,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘多条查找',
                        'code' => 'disk_select',
                        'lang' => 'Select',
                        'page' => 'api_disk',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 226,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘修改',
                        'code' => 'disk_update',
                        'lang' => 'Update',
                        'page' => 'api_disk',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 227,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘创建',
                        'code' => 'disk_create',
                        'lang' => 'Create',
                        'page' => 'api_disk',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 228,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘删除',
                        'code' => 'disk_delete',
                        'lang' => 'Delete',
                        'page' => 'api_disk',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 229,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘字段',
                        'code' => 'disk_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_disk',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 230,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($diskModuleRows);

        /**
         * 实体模块
         */
        $entityModuleRows = [
            'page' => [
                'name' => '实体模块',
                'code' => 'entity',
                'lang' => 'Entity',
                'page' => 'api_entity',
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
                        'name' => '实体单条查找',
                        'code' => 'entity_find',
                        'lang' => 'Find',
                        'page' => 'api_entity',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 231,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '实体多条查找',
                        'code' => 'entity_select',
                        'lang' => 'Select',
                        'page' => 'api_entity',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 232,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '实体修改',
                        'code' => 'entity_update',
                        'lang' => 'Update',
                        'page' => 'api_entity',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 233,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '实体创建',
                        'code' => 'entity_create',
                        'lang' => 'Create',
                        'page' => 'api_entity',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 234,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '实体删除',
                        'code' => 'entity_delete',
                        'lang' => 'Delete',
                        'page' => 'api_entity',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 235,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '实体字段',
                        'code' => 'entity_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_entity',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 236,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($entityModuleRows);

        /**
         * 文件模块
         */
        $fileModuleRows = [
            'page' => [
                'name' => '文件模块',
                'code' => 'file',
                'lang' => 'File',
                'page' => 'api_file',
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
                        'name' => '文件单条查找',
                        'code' => 'file_find',
                        'lang' => 'Find',
                        'page' => 'api_file',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 237,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件多条查找',
                        'code' => 'file_select',
                        'lang' => 'Select',
                        'page' => 'api_file',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 238,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件修改',
                        'code' => 'file_update',
                        'lang' => 'Update',
                        'page' => 'api_file',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 239,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件创建',
                        'code' => 'file_create',
                        'lang' => 'Create',
                        'page' => 'api_file',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 240,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件删除',
                        'code' => 'file_delete',
                        'lang' => 'Delete',
                        'page' => 'api_file',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 241,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件字段',
                        'code' => 'file_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_file',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 242,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($fileModuleRows);

        /**
         * 关注模块
         */
        $followModuleRows = [
            'page' => [
                'name' => '关注模块',
                'code' => 'follow',
                'lang' => 'Follow',
                'page' => 'api_follow',
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
                        'name' => '关注单条查找',
                        'code' => 'follow_find',
                        'lang' => 'Find',
                        'page' => 'api_follow',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 243,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '关注多条查找',
                        'code' => 'follow_select',
                        'lang' => 'Select',
                        'page' => 'api_follow',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 244,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '关注修改',
                        'code' => 'follow_update',
                        'lang' => 'Update',
                        'page' => 'api_follow',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 245,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '关注创建',
                        'code' => 'follow_create',
                        'lang' => 'Create',
                        'page' => 'api_follow',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 246,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '关注删除',
                        'code' => 'follow_delete',
                        'lang' => 'Delete',
                        'page' => 'api_follow',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 247,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '关注字段',
                        'code' => 'follow_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_follow',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 248,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($followModuleRows);

        /**
         * 水平关联配置模块
         */
        $horizontalConfigModuleRows = [
            'page' => [
                'name' => '水平关联配置模块',
                'code' => 'horizontalconfig',
                'lang' => 'Horizontal_Config',
                'page' => 'api_horizontalconfig',
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
                        'name' => '水平关联配置单条查找',
                        'code' => 'horizontalconfig_find',
                        'lang' => 'Find',
                        'page' => 'api_horizontalconfig',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 249,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联配置多条查找',
                        'code' => 'horizontalconfig_select',
                        'lang' => 'Select',
                        'page' => 'api_horizontalconfig',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 250,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联配置修改',
                        'code' => 'horizontalconfig_update',
                        'lang' => 'Update',
                        'page' => 'api_horizontalconfig',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 251,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联配置创建',
                        'code' => 'horizontalconfig_create',
                        'lang' => 'Create',
                        'page' => 'api_horizontalconfig',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 252,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联配置删除',
                        'code' => 'horizontalconfig_delete',
                        'lang' => 'Delete',
                        'page' => 'api_horizontalconfig',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 253,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联配置字段',
                        'code' => 'horizontalconfig_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_horizontalconfig',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 254,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($horizontalConfigModuleRows);

        /**
         * 水平关联模块
         */
        $horizontalModuleRows = [
            'page' => [
                'name' => '水平关联模块',
                'code' => 'horizontal',
                'lang' => 'Horizontal_Relationship',
                'page' => 'api_horizontal',
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
                        'name' => '水平关联单条查找',
                        'code' => 'horizontal_find',
                        'lang' => 'Find',
                        'page' => 'api_horizontal',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 255,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联多条查找',
                        'code' => 'horizontal_select',
                        'lang' => 'Select',
                        'page' => 'api_horizontal',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 256,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联修改',
                        'code' => 'horizontal_update',
                        'lang' => 'Update',
                        'page' => 'api_horizontal',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 257,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联创建',
                        'code' => 'horizontal_create',
                        'lang' => 'Create',
                        'page' => 'api_horizontal',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 258,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联删除',
                        'code' => 'horizontal_delete',
                        'lang' => 'Delete',
                        'page' => 'api_horizontal',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 259,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联字段',
                        'code' => 'horizontal_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_horizontal',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 260,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '水平关联创建',
                        'code' => 'create_horizontal',
                        'lang' => 'Create_Horizontal',
                        'page' => 'api_horizontal',
                        'param' => 'createhorizontal',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 261,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($horizontalModuleRows);

        /**
         * 媒体模块
         */
        $mediaModuleRows = [
            'page' => [
                'name' => '媒体模块',
                'code' => 'media',
                'lang' => 'Media',
                'page' => 'api_media',
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
                        'name' => '媒体单条查找',
                        'code' => 'media_find',
                        'lang' => 'Find',
                        'page' => 'api_media',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 262,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '媒体多条查找',
                        'code' => 'media_select',
                        'lang' => 'Select',
                        'page' => 'api_media',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 263,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '媒体修改',
                        'code' => 'media_update',
                        'lang' => 'Update',
                        'page' => 'api_media',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 264,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '媒体创建',
                        'code' => 'media_create',
                        'lang' => 'Create',
                        'page' => 'api_media',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 265,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '媒体删除',
                        'code' => 'media_delete',
                        'lang' => 'Delete',
                        'page' => 'api_media',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 266,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '媒体字段',
                        'code' => 'media_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_media',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 267,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取指定的媒体服务器',
                        'code' => 'get_media_server_item',
                        'lang' => 'Get_Media_Server',
                        'page' => 'api_media',
                        'param' => 'getmediaserveritem',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 268,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取媒体指定上传服务器配置信息',
                        'code' => 'get_media_upload_server',
                        'lang' => 'Get_Media_Upload_Server',
                        'page' => 'api_media',
                        'param' => 'getmediauploadserver',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 269,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取所有媒体服务器状态',
                        'code' => 'get_media_server_status',
                        'lang' => 'Get_Media_Server_Status',
                        'page' => 'api_media',
                        'param' => 'getmediaserverstatus',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 270,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '创建媒体',
                        'code' => 'create_media',
                        'lang' => 'Create_Media',
                        'page' => 'api_media',
                        'param' => 'createmedia',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 271,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '更新媒体',
                        'code' => 'update_media',
                        'lang' => 'Update_Media',
                        'page' => 'api_media',
                        'param' => 'updatemedia',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 272,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '查找媒体',
                        'code' => 'get_media',
                        'lang' => 'Get_Media',
                        'page' => 'api_media',
                        'param' => 'getmediadata',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 273,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取指定尺寸的缩率图路径',
                        'code' => 'get_specify_size_thumb_path',
                        'lang' => 'Get_Specify_Size_Thumb_Path',
                        'page' => 'api_media',
                        'param' => 'getspecifysizethumbpath',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 274,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取多个媒体信息',
                        'code' => 'select_media_data',
                        'lang' => 'Select_Media_Data',
                        'page' => 'api_media',
                        'param' => 'selectmediadata',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 275,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($mediaModuleRows);

        /**
         * 成员模块
         */
        $memberModuleRows = [
            'page' => [
                'name' => '成员模块',
                'code' => 'member',
                'lang' => 'Member',
                'page' => 'api_member',
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
                        'name' => '成员单条查找',
                        'code' => 'member_find',
                        'lang' => 'Find',
                        'page' => 'api_member',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 276,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '成员多条查找',
                        'code' => 'member_select',
                        'lang' => 'Select',
                        'page' => 'api_member',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 277,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '成员修改',
                        'code' => 'member_update',
                        'lang' => 'Update',
                        'page' => 'api_member',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 278,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '成员创建',
                        'code' => 'member_create',
                        'lang' => 'Create',
                        'page' => 'api_member',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 279,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '成员删除',
                        'code' => 'member_delete',
                        'lang' => 'Delete',
                        'page' => 'api_member',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 280,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '成员字段',
                        'code' => 'member_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_member',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 281,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($memberModuleRows);

        /**
         * 反馈模块
         */
        $noteModuleRows = [
            'page' => [
                'name' => '反馈模块',
                'code' => 'note',
                'lang' => 'Note',
                'page' => 'api_note',
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
                        'name' => '反馈单条查找',
                        'code' => 'note_find',
                        'lang' => 'Find',
                        'page' => 'api_note',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 282,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '反馈多条查找',
                        'code' => 'note_select',
                        'lang' => 'Select',
                        'page' => 'api_note',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 283,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '反馈修改',
                        'code' => 'note_update',
                        'lang' => 'Update',
                        'page' => 'api_note',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 284,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '反馈创建',
                        'code' => 'note_create',
                        'lang' => 'Create',
                        'page' => 'api_note',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 285,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '反馈删除',
                        'code' => 'note_delete',
                        'lang' => 'Delete',
                        'page' => 'api_note',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 286,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '反馈字段',
                        'code' => 'note_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_note',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 287,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($noteModuleRows);

        /**
         * 现场数据模块
         */
        $onsetModuleRows = [
            'page' => [
                'name' => '现场数据模块',
                'code' => 'onset',
                'lang' => 'Onset',
                'page' => 'api_onset',
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
                        'name' => '现场数据单条查找',
                        'code' => 'onset_find',
                        'lang' => 'Find',
                        'page' => 'api_onset',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 288,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据多条查找',
                        'code' => 'onset_select',
                        'lang' => 'Select',
                        'page' => 'api_onset',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 289,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据修改',
                        'code' => 'onset_update',
                        'lang' => 'Update',
                        'page' => 'api_onset',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 290,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据创建',
                        'code' => 'onset_create',
                        'lang' => 'Create',
                        'page' => 'api_onset',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 291,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据删除',
                        'code' => 'onset_delete',
                        'lang' => 'Delete',
                        'page' => 'api_onset',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 292,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据字段',
                        'code' => 'onset_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_onset',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 293,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($onsetModuleRows);

        /**
         * 项目磁盘模块
         */
        $projectDiskModuleRows = [
            'page' => [
                'name' => '项目磁盘模块',
                'code' => 'project_disk',
                'lang' => 'Project_Disk',
                'page' => 'api_projectdisk',
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
                        'name' => '项目磁盘单条查找',
                        'code' => 'project_disk_find',
                        'lang' => 'Find',
                        'page' => 'api_projectdisk',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 294,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目磁盘多条查找',
                        'code' => 'project_disk_select',
                        'lang' => 'Select',
                        'page' => 'api_projectdisk',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 295,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目磁盘修改',
                        'code' => 'project_disk_update',
                        'lang' => 'Update',
                        'page' => 'api_projectdisk',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 296,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目磁盘创建',
                        'code' => 'project_disk_create',
                        'lang' => 'Create',
                        'page' => 'api_projectdisk',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 297,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目磁盘删除',
                        'code' => 'project_disk_delete',
                        'lang' => 'Delete',
                        'page' => 'api_projectdisk',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 298,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目磁盘字段',
                        'code' => 'project_disk_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_projectdisk',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 299,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($projectDiskModuleRows);

        /**
         * 项目成员模块
         */
        $projectMemberModuleRows = [
            'page' => [
                'name' => '项目成员模块',
                'code' => 'project_member',
                'lang' => 'Project_Member',
                'page' => 'api_projectmember',
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
                        'name' => '项目成员单条查找',
                        'code' => 'project_member_find',
                        'lang' => 'Find',
                        'page' => 'api_projectmember',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 300,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目成员多条查找',
                        'code' => 'project_member_select',
                        'lang' => 'Select',
                        'page' => 'api_projectmember',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 301,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目成员修改',
                        'code' => 'project_member_update',
                        'lang' => 'Update',
                        'page' => 'api_projectmember',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 302,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目成员创建',
                        'code' => 'project_member_create',
                        'lang' => 'Create',
                        'page' => 'api_projectmember',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 303,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目成员删除',
                        'code' => 'project_member_delete',
                        'lang' => 'Delete',
                        'page' => 'api_projectmember',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 304,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目成员字段',
                        'code' => 'project_member_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_projectmember',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 305,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($projectMemberModuleRows);

        /**
         * 项目模块
         */
        $projectModuleRows = [
            'page' => [
                'name' => '项目模块',
                'code' => 'project',
                'lang' => 'Project',
                'page' => 'api_project',
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
                        'name' => '项目单条查找',
                        'code' => 'project_find',
                        'lang' => 'Find',
                        'page' => 'api_project',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 306,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目多条查找',
                        'code' => 'project_select',
                        'lang' => 'Select',
                        'page' => 'api_project',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 307,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目修改',
                        'code' => 'project_update',
                        'lang' => 'Update',
                        'page' => 'api_project',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 308,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目创建',
                        'code' => 'project_create',
                        'lang' => 'Create',
                        'page' => 'api_project',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 309,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目删除',
                        'code' => 'project_delete',
                        'lang' => 'Delete',
                        'page' => 'api_project',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 310,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目字段',
                        'code' => 'project_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_project',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 311,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($projectModuleRows);

        /**
         * 状态模块
         */
        $statusModuleRows = [
            'page' => [
                'name' => '状态模块',
                'code' => 'status',
                'lang' => 'Status',
                'page' => 'api_status',
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
                        'name' => '状态单条查找',
                        'code' => 'status_find',
                        'lang' => 'Find',
                        'page' => 'api_status',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 312,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态多条查找',
                        'code' => 'status_select',
                        'lang' => 'Select',
                        'page' => 'api_status',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 313,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态修改',
                        'code' => 'status_update',
                        'lang' => 'Update',
                        'page' => 'api_status',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 314,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态创建',
                        'code' => 'status_create',
                        'lang' => 'Create',
                        'page' => 'api_status',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 315,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态删除',
                        'code' => 'status_delete',
                        'lang' => 'Delete',
                        'page' => 'api_status',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 316,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态字段',
                        'code' => 'status_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_status',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 317,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($statusModuleRows);

        /**
         * 工序模块
         */
        $stepModuleRows = [
            'page' => [
                'name' => '工序模块',
                'code' => 'step',
                'lang' => 'Step',
                'page' => 'api_step',
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
                        'name' => '工序单条查找',
                        'code' => 'step_find',
                        'lang' => 'Find',
                        'page' => 'api_step',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 318,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序多条查找',
                        'code' => 'step_select',
                        'lang' => 'Select',
                        'page' => 'api_step',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 319,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序修改',
                        'code' => 'step_update',
                        'lang' => 'Update',
                        'page' => 'api_step',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 320,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序创建',
                        'code' => 'step_create',
                        'lang' => 'Create',
                        'page' => 'api_step',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 321,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序删除',
                        'code' => 'step_delete',
                        'lang' => 'Delete',
                        'page' => 'api_step',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 322,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序字段',
                        'code' => 'step_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_step',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 323,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($stepModuleRows);

        /**
         * 标签关联模块
         */
        $tagLinkModuleRows = [
            'page' => [
                'name' => '标签关联模块',
                'code' => 'tag_link',
                'lang' => 'Tag_Link',
                'page' => 'api_taglink',
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
                        'name' => '标签关联单条查找',
                        'code' => 'tag_link_find',
                        'lang' => 'Find',
                        'page' => 'api_taglink',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 324,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签关联多条查找',
                        'code' => 'tag_link_select',
                        'lang' => 'Select',
                        'page' => 'api_taglink',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 325,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签关联修改',
                        'code' => 'tag_link_update',
                        'lang' => 'Update',
                        'page' => 'api_taglink',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 326,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签关联创建',
                        'code' => 'tag_link_create',
                        'lang' => 'Create',
                        'page' => 'api_taglink',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 327,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签关联删除',
                        'code' => 'tag_link_delete',
                        'lang' => 'Delete',
                        'page' => 'api_taglink',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 328,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签关联字段',
                        'code' => 'tag_link_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_taglink',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 329,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($tagLinkModuleRows);

        /**
         * 标签模块
         */
        $tagModuleRows = [
            'page' => [
                'name' => '标签模块',
                'code' => 'tag',
                'lang' => 'Tag',
                'page' => 'api_tag',
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
                        'name' => '标签单条查找',
                        'code' => 'tag_find',
                        'lang' => 'Find',
                        'page' => 'api_tag',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 330,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签多条查找',
                        'code' => 'tag_select',
                        'lang' => 'Select',
                        'page' => 'api_tag',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 331,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签修改',
                        'code' => 'tag_update',
                        'lang' => 'Update',
                        'page' => 'api_tag',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 332,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签创建',
                        'code' => 'tag_create',
                        'lang' => 'Create',
                        'page' => 'api_tag',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 333,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签删除',
                        'code' => 'tag_delete',
                        'lang' => 'Delete',
                        'page' => 'api_tag',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 334,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '标签字段',
                        'code' => 'tag_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_tag',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 335,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($tagModuleRows);

        /**
         * 时间日志注意事项模块
         */
        $timelogIssueModuleRows = [
            'page' => [
                'name' => '时间日志注意事项模块',
                'code' => 'timelog_issue',
                'lang' => 'Timelog_Issue',
                'page' => 'api_timelogissue',
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
                        'name' => '时间日志注意事项单条查找',
                        'code' => 'timelog_issue_find',
                        'lang' => 'Find',
                        'page' => 'api_timelogissue',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 336,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志注意事项多条查找',
                        'code' => 'timelog_issue_select',
                        'lang' => 'Select',
                        'page' => 'api_timelogissue',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 337,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志注意事项修改',
                        'code' => 'timelog_issue_update',
                        'lang' => 'Update',
                        'page' => 'api_timelogissue',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 338,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志注意事项创建',
                        'code' => 'timelog_issue_create',
                        'lang' => 'Create',
                        'page' => 'api_timelogissue',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 339,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志注意事项删除',
                        'code' => 'timelog_issue_delete',
                        'lang' => 'Delete',
                        'page' => 'api_timelogissue',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 340,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志注意事项字段',
                        'code' => 'timelog_issue_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_timelogissue',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 341,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($timelogIssueModuleRows);

        /**
         * 时间日志模块
         */
        $timelogModuleRows = [
            'page' => [
                'name' => '时间日志模块',
                'code' => 'timelog',
                'lang' => 'Timelog',
                'page' => 'api_timelog',
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
                        'name' => '时间日志单条查找',
                        'code' => 'timelog_find',
                        'lang' => 'Find',
                        'page' => 'api_timelog',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 342,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志多条查找',
                        'code' => 'timelog_select',
                        'lang' => 'Select',
                        'page' => 'api_timelog',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 343,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志修改',
                        'code' => 'timelog_update',
                        'lang' => 'Update',
                        'page' => 'api_timelog',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 344,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志创建',
                        'code' => 'timelog_create',
                        'lang' => 'Create',
                        'page' => 'api_timelog',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 345,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志删除',
                        'code' => 'timelog_delete',
                        'lang' => 'Delete',
                        'page' => 'api_timelog',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 346,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '时间日志字段',
                        'code' => 'timelog_fields',
                        'lang' => 'Fields',
                        'page' => 'api_timelog',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 347,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '开启计时器',
                        'code' => 'start_timer',
                        'lang' => 'Start_Timer',
                        'page' => 'api_timelog',
                        'param' => 'starttimer',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 348,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '停止计时器',
                        'code' => 'stop_timer',
                        'lang' => 'Stop_Timer',
                        'page' => 'api_timelog',
                        'param' => 'stoptimer',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 349,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($timelogModuleRows);

        /**
         * 用户配置模块
         */
        $userConfigModuleRows = [
            'page' => [
                'name' => '用户配置模块',
                'code' => 'user_config',
                'lang' => 'User_Config',
                'page' => 'api_userconfig',
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
                        'name' => '用户配置单条查找',
                        'code' => 'user_config_find',
                        'lang' => 'Find',
                        'page' => 'api_userconfig',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 350,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户配置多条查找',
                        'code' => 'user_config_select',
                        'lang' => 'Select',
                        'page' => 'api_userconfig',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 351,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户配置修改',
                        'code' => 'user_config_update',
                        'lang' => 'Update',
                        'page' => 'api_userconfig',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 352,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户配置创建',
                        'code' => 'user_config_create',
                        'lang' => 'Create',
                        'page' => 'api_userconfig',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 353,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户配置删除',
                        'code' => 'user_config_delete',
                        'lang' => 'Delete',
                        'page' => 'api_userconfig',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 354,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户配置字段',
                        'code' => 'user_config_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_userconfig',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 355,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($userConfigModuleRows);

        /**
         * 自定义字段模块
         */
        $variableModuleRows = [
            'page' => [
                'name' => '自定义字段模块',
                'code' => 'variable',
                'lang' => 'Custom_Fields',
                'page' => 'api_variable',
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
                        'name' => '自定义字段单条查找',
                        'code' => 'variable_find',
                        'lang' => 'Find',
                        'page' => 'api_variable',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 356,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段多条查找',
                        'code' => 'variable_select',
                        'lang' => 'Select',
                        'page' => 'api_variable',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 357,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段修改',
                        'code' => 'variable_update',
                        'lang' => 'Update',
                        'page' => 'api_variable',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 358,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段创建',
                        'code' => 'variable_create',
                        'lang' => 'Create',
                        'page' => 'api_variable',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 359,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段删除',
                        'code' => 'variable_delete',
                        'lang' => 'Delete',
                        'page' => 'api_variable',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 360,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段字段',
                        'code' => 'variable_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_variable',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 361,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($variableModuleRows);

        /**
         * 自定义字段值模块
         */
        $variableValueModuleRows = [
            'page' => [
                'name' => '自定义字段值模块',
                'code' => 'variable_value',
                'lang' => 'Custom_Fields_Value',
                'page' => 'api_variablevalue',
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
                        'name' => '自定义字段值单条查找',
                        'code' => 'variable_value_find',
                        'lang' => 'Find',
                        'page' => 'api_variablevalue',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 362,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段值多条查找',
                        'code' => 'variable_value_select',
                        'lang' => 'Select',
                        'page' => 'api_variablevalue',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 363,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段值修改',
                        'code' => 'variable_value_update',
                        'lang' => 'Update',
                        'page' => 'api_variablevalue',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 364,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段值创建',
                        'code' => 'variable_value_create',
                        'lang' => 'Create',
                        'page' => 'api_variablevalue',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 365,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段值删除',
                        'code' => 'variable_value_delete',
                        'lang' => 'Delete',
                        'page' => 'api_variablevalue',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 366,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '自定义字段值字段',
                        'code' => 'variable_value_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_variablevalue',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 367,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($variableValueModuleRows);

        /**
         * 用户模块
         */
        $userModuleRows = [
            'page' => [
                'name' => '用户模块',
                'code' => 'user',
                'lang' => 'User',
                'page' => 'api_user',
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
                        'name' => '用户单条查找',
                        'code' => 'user_find',
                        'lang' => 'Find',
                        'page' => 'api_user',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 368,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户多条查找',
                        'code' => 'user_select',
                        'lang' => 'Select',
                        'page' => 'api_user',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 369,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户修改',
                        'code' => 'user_update',
                        'lang' => 'Update',
                        'page' => 'api_user',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 370,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户创建',
                        'code' => 'user_create',
                        'lang' => 'Create',
                        'page' => 'api_user',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 371,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户删除',
                        'code' => 'user_delete',
                        'lang' => 'Delete',
                        'page' => 'api_user',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 372,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户字段',
                        'code' => 'user_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_user',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 373,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '用户成员信息',
                        'code' => 'get_member_data',
                        'lang' => 'Get_User_Member_Data',
                        'page' => 'api_user',
                        'param' => 'getmemberdata',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 407,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($userModuleRows);

        /**
         * 提交文件模块
         */
        $fileCommitModuleRows = [
            'page' => [
                'name' => '提交文件模块',
                'code' => 'file_commit',
                'lang' => 'File_Commit',
                'page' => 'api_filecommit',
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
                        'name' => '提交文件单条查找',
                        'code' => 'file_commit_find',
                        'lang' => 'Find',
                        'page' => 'api_filecommit',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 374,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '提交文件多条查找',
                        'code' => 'file_commit_select',
                        'lang' => 'Select',
                        'page' => 'api_filecommit',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 375,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '提交文件修改',
                        'code' => 'file_commit_update',
                        'lang' => 'Update',
                        'page' => 'api_filecommit',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 376,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '提交文件创建',
                        'code' => 'file_commit_create',
                        'lang' => 'Create',
                        'page' => 'api_filecommit',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 377,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '提交文件删除',
                        'code' => 'file_commit_delete',
                        'lang' => 'Delete',
                        'page' => 'api_filecommit',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 378,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '提交文件字段',
                        'code' => 'file_commit_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_filecommit',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 379,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($fileCommitModuleRows);

        /**
         * 文件类型模块
         */
        $fileTypeModuleRows = [
            'page' => [
                'name' => '文件类型模块',
                'code' => 'file_type',
                'lang' => 'File_Type',
                'page' => 'api_filetype',
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
                        'name' => '文件类型单条查找',
                        'code' => 'file_type_find',
                        'lang' => 'Find',
                        'page' => 'api_filetype',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 380,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件类型多条查找',
                        'code' => 'file_type_select',
                        'lang' => 'Select',
                        'page' => 'api_filetype',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 381,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件类型修改',
                        'code' => 'file_type_update',
                        'lang' => 'Update',
                        'page' => 'api_filetype',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 382,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件类型创建',
                        'code' => 'file_type_create',
                        'lang' => 'Create',
                        'page' => 'api_filetype',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 383,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件类型删除',
                        'code' => 'file_type_delete',
                        'lang' => 'Delete',
                        'page' => 'api_filetype',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 384,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件类型字段',
                        'code' => 'file_type_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_filetype',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 385,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($fileTypeModuleRows);

        /**
         * 任务模块
         */
        $taskModuleRows = [
            'page' => [
                'name' => '任务模块',
                'code' => 'task',
                'lang' => 'Task',
                'page' => 'api_task',
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
                        'name' => '任务单条查找',
                        'code' => 'task_find',
                        'lang' => 'Find',
                        'page' => 'api_task',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 386,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '任务多条查找',
                        'code' => 'task_select',
                        'lang' => 'Select',
                        'page' => 'api_task',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 387,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '任务修改',
                        'code' => 'task_update',
                        'lang' => 'Update',
                        'page' => 'api_task',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 388,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '任务创建',
                        'code' => 'task_create',
                        'lang' => 'Create',
                        'page' => 'api_task',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 389,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '任务删除',
                        'code' => 'task_delete',
                        'lang' => 'Delete',
                        'page' => 'api_task',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 390,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '任务字段',
                        'code' => 'task_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_task',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 391,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($taskModuleRows);

        /**
         * 通用动作模块
         */
        $commonActionModuleRows = [
            'page' => [
                'name' => '通用动作模块',
                'code' => 'common_action',
                'lang' => 'Frequently_Use_Action',
                'page' => 'api_commonaction',
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
                        'name' => '通用动作单条查找',
                        'code' => 'common_action_find',
                        'lang' => 'Find',
                        'page' => 'api_commonaction',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 392,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '通用动作多条查找',
                        'code' => 'common_action_select',
                        'lang' => 'Select',
                        'page' => 'api_commonaction',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 393,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '通用动作修改',
                        'code' => 'common_action_update',
                        'lang' => 'Update',
                        'page' => 'api_commonaction',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 394,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '通用动作创建',
                        'code' => 'common_action_create',
                        'lang' => 'Create',
                        'page' => 'api_commonaction',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 395,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '通用动作删除',
                        'code' => 'common_action_delete',
                        'lang' => 'Delete',
                        'page' => 'api_commonaction',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 396,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '通用动作字段',
                        'code' => 'common_action_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_commonaction',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 397,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($commonActionModuleRows);

        /**
         * 数据结构模块
         */
        $schemaModuleRows = [
            'page' => [
                'name' => '数据结构模块',
                'code' => 'schema',
                'lang' => 'Schema',
                'page' => 'api_schema',
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
                        'name' => '数据结构创建',
                        'code' => 'schema_create',
                        'lang' => 'Create',
                        'page' => 'api_schema',
                        'param' => 'createschema',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 398,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取数据结构',
                        'code' => 'get_schema',
                        'lang' => 'Get_Schema_Data',
                        'page' => 'api_schema',
                        'param' => 'getschema',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 399,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '数据结构修改',
                        'code' => 'update_schema',
                        'lang' => 'Modify_Schema',
                        'page' => 'api_schema',
                        'param' => 'updateschema',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 400,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '创建模式结构',
                        'code' => 'create_schema_structure',
                        'lang' => 'Create_Schema_Structure',
                        'page' => 'api_schema',
                        'param' => 'createschemastructure',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 414,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '修改模式结构',
                        'code' => 'update_schema_structure',
                        'lang' => 'Update_Schema_Structure',
                        'page' => 'api_schema',
                        'param' => 'updateschemastructure',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 415,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获得模式结构',
                        'code' => 'get_schema_structure',
                        'lang' => 'Get_Schema_Structure',
                        'page' => 'api_schema',
                        'param' => 'getschemastructure',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 416,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取所有模式',
                        'code' => 'get_all_schema',
                        'lang' => 'Get_All_Schema',
                        'page' => 'api_schema',
                        'param' => 'getallschema',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 417,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '删除模式结构',
                        'code' => 'delete_schema_structure',
                        'lang' => 'Delete_Schema_Structure',
                        'page' => 'api_schema',
                        'param' => 'deleteschemastructure',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 420,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '创建实体模块',
                        'code' => 'create_entity_module',
                        'lang' => 'Create_Entity_Module',
                        'page' => 'api_schema',
                        'param' => 'createentitymodule',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 421,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($schemaModuleRows);

        /**
         * 默认配置模块
         */
        $optionsModuleRows = [
            'page' => [
                'name' => '默认配置模块',
                'code' => 'options',
                'lang' => 'System_Options',
                'page' => 'api_options',
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
                        'name' => '获取指定系统配置',
                        'code' => 'get_options',
                        'lang' => 'Get_Options',
                        'page' => 'api_options',
                        'param' => 'getoptions',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 401,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '更新指定系统配置',
                        'code' => 'update_options',
                        'lang' => 'Update_Options',
                        'page' => 'api_options',
                        'param' => 'updateoptions',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 402,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '添加系统配置',
                        'code' => 'add_options',
                        'lang' => 'Add_Options',
                        'page' => 'api_options',
                        'param' => 'addoptions',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 403,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取websocket服务器配置信息',
                        'code' => 'get_web_socket_server',
                        'lang' => 'Get_Web_Socket_Server',
                        'page' => 'api_options',
                        'param' => 'getwebsockectserver',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 404,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取Email服务器配置信息',
                        'code' => 'get_email_server',
                        'lang' => 'Get_Email_Server',
                        'page' => 'api_options',
                        'param' => 'getemailserver',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 405,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获取log服务器',
                        'code' => 'get_event_log_server',
                        'lang' => 'Get_Event_Log_Server',
                        'page' => 'api_options',
                        'param' => 'geteventlogserver',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 406,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($optionsModuleRows);

        /**
         * 视图模块
         */
        $viewModuleRows = [
            'page' => [
                'name' => '视图模块',
                'code' => 'view',
                'lang' => 'View',
                'page' => 'api_view',
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
                        'name' => '创建默认视图',
                        'code' => 'create_default_view',
                        'lang' => 'Create_Default_View',
                        'page' => 'api_view',
                        'param' => 'createdefaultview',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 410,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($viewModuleRows);

        /**
         * 模块
         */
        $moduleRows = [
            'page' => [
                'name' => '模块',
                'code' => 'module',
                'lang' => 'Module',
                'page' => 'api_module',
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
                        'name' => '获取模块信息',
                        'code' => 'get_module_data',
                        'lang' => 'Get_Module_Data',
                        'page' => 'api_module',
                        'param' => 'getmoduledata',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 411,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($moduleRows);

        /**
         * 模块
         */
        $coreRows = [
            'page' => [
                'name' => '核心模块',
                'code' => 'core',
                'lang' => 'Core',
                'page' => 'api_core',
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
                        'name' => '获取模块',
                        'code' => 'get_module_data',
                        'lang' => 'Get_Module_Data',
                        'page' => 'api_core',
                        'param' => 'getmoduledata',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 418,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($coreRows);

        /**
         * 项目模板模块
         */
        $projectTemplateRows = [
            'page' => [
                'name' => '项目模板模块',
                'code' => 'projecttemplate',
                'lang' => 'ProjectTemplate',
                'page' => 'api_projecttemplate',
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
                        'name' => '项目模板单条查找',
                        'code' => 'projecttemplate_find',
                        'lang' => 'Find',
                        'page' => 'api_projecttemplate',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 195,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目模板多条查找',
                        'code' => 'projecttemplate_select',
                        'lang' => 'Select',
                        'page' => 'api_projecttemplate',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 196,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目模板修改',
                        'code' => 'projecttemplate_update',
                        'lang' => 'Update',
                        'page' => 'api_projecttemplate',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 197,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目模板创建',
                        'code' => 'projecttemplate_create',
                        'lang' => 'Create',
                        'page' => 'api_projecttemplate',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 198,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目模板删除',
                        'code' => 'projecttemplate_delete',
                        'lang' => 'Delete',
                        'page' => 'api_projecttemplate',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 199,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目模板字段',
                        'code' => 'projecttemplate_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_projecttemplate',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 200,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '模板路径',
                        'code' => 'get_template_path',
                        'lang' => 'Get_Template_Path',
                        'page' => 'api_projecttemplate',
                        'param' => 'gettemplatepath',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 200,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '项目路径',
                        'code' => 'get_item_path',
                        'lang' => 'Get_Item_Path',
                        'page' => 'api_projecttemplate',
                        'param' => 'getitempath',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 200,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($projectTemplateRows);

        /**
         * 审核关联
         */
        $reviewLinkRows = [
            'page' => [
                'name' => '审核关联模块',
                'code' => 'reviewlink',
                'lang' => 'ReviewLink',
                'page' => 'api_reviewlink',
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
                        'name' => '审核关联单条查找',
                        'code' => 'reviewlink_find',
                        'lang' => 'Find',
                        'page' => 'api_reviewlink',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 430,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '审核关联多条查找',
                        'code' => 'reviewlink_select',
                        'lang' => 'Select',
                        'page' => 'api_reviewlink',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 431,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '审核关联修改',
                        'code' => 'reviewlink_update',
                        'lang' => 'Update',
                        'page' => 'api_reviewlink',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 432,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '审核关联创建',
                        'code' => 'reviewlink_create',
                        'lang' => 'Create',
                        'page' => 'api_reviewlink',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 447,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '审核关联删除',
                        'code' => 'reviewlink_delete',
                        'lang' => 'Delete',
                        'page' => 'api_reviewlink',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 433,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '审核关联字段',
                        'code' => 'reviewlink_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_reviewlink',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 434,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($reviewLinkRows);

        /**
         * 现场数据关联模块
         */
        $onsetLinkModuleRows = [
            'page' => [
                'name' => '现场数据关联模块',
                'code' => 'onsetlink',
                'lang' => 'OnsetLink',
                'page' => 'api_onsetlink',
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
                        'name' => '现场数据关联单条查找',
                        'code' => 'onsetlink_find',
                        'lang' => 'Find',
                        'page' => 'api_onsetlink',
                        'param' => 'find',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 435,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据关联多条查找',
                        'code' => 'onsetlink_select',
                        'lang' => 'Select',
                        'page' => 'api_onsetlink',
                        'param' => 'select',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 436,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据关联修改',
                        'code' => 'onsetlink_update',
                        'lang' => 'Update',
                        'page' => 'api_onsetlink',
                        'param' => 'update',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 437,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据关联创建',
                        'code' => 'onsetlink_create',
                        'lang' => 'Create',
                        'page' => 'api_onsetlink',
                        'param' => 'create',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 438,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据关联删除',
                        'code' => 'onsetlink_delete',
                        'lang' => 'Delete',
                        'page' => 'api_onsetlink',
                        'param' => 'delete',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 439,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '现场数据关联字段',
                        'code' => 'onsetlink_fields',
                        'lang' => 'Get_Fields',
                        'page' => 'api_onsetlink',
                        'param' => 'fields',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 440,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($onsetLinkModuleRows);

        /**
         * 权限模块
         */
        $onsetLinkModuleRows = [
            'page' => [
                'name' => '权限模块',
                'code' => 'auth',
                'lang' => 'auth',
                'page' => 'api_auth',
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
                        'name' => '添加父节点权限',
                        'code' => 'create_parent_auth',
                        'lang' => 'Create_Parent_Auth',
                        'page' => 'api_auth',
                        'param' => 'createparentauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 441,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '添加子节点权限',
                        'code' => 'create_child_auth',
                        'lang' => 'Create_Child_Auth',
                        'page' => 'api_auth',
                        'param' => 'createchildauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 442,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '获得节点权限',
                        'code' => 'get_node_auth',
                        'lang' => 'Get_Node_Auth',
                        'page' => 'api_auth',
                        'param' => 'getnodeauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 443,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '更新节点权限',
                        'code' => 'update_node_auth',
                        'lang' => 'Update_Node_Auth',
                        'page' => 'api_auth',
                        'param' => 'updatenodeauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 444,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '删除节点权限',
                        'code' => 'delete_node_auth',
                        'lang' => 'Delete_Node_Auth',
                        'page' => 'api_auth',
                        'param' => 'deletenodeauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 445,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '查找多条权限节点',
                        'code' => 'select_node_auth',
                        'lang' => 'Select_Node_Auth',
                        'page' => 'api_auth',
                        'param' => 'selectnodeauth',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 446,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($onsetLinkModuleRows);
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
