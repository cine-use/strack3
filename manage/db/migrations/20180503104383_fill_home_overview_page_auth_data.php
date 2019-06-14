<?php


use Phinx\Migration\AbstractMigration;

class FillHomeOverviewPageAuthData extends AbstractMigration
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
         * 前台-设置页面
         */
        $homeOverviewPageRows = [
            'page' => [
                'name' => '设置页面',
                'code' => 'project_overview',
                'lang' => 'Overview',
                'page' => 'home_project_overview',
                'menu' => 'top_menu,project',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 153,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '设置页面访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 153,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '详情',
                        'code' => 'details',
                        'lang' => 'Details',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_details',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 154,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '修改缩略图',
                                'code' => 'modify_thumb',
                                'lang' => 'Modify_Thumb',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_details',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 6,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '清除缩略图',
                                'code' => 'clear_thumb',
                                'lang' => 'Clear_Thumb',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_details',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 7,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '团队',
                        'code' => 'team',
                        'lang' => 'Team',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_team',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 155,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '工具栏',
                                'code' => 'toolbar',
                                'lang' => 'Toolbar',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_team',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '创建团队',
                                        'code' => 'create',
                                        'lang' => 'Create',
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 1,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '编辑',
                                        'code' => 'edit',
                                        'lang' => 'Edit',
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'list' => [
                                        [
                                            'page' => [
                                                'name' => '批量编辑',
                                                'code' => 'batch_edit',
                                                'lang' => 'Batch_Edit',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 2,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '批量删除',
                                                'code' => 'batch_delete',
                                                'lang' => 'Batch_Delete',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 123,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '动作',
                                                'code' => 'action',
                                                'lang' => 'Action',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 3,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '导入Excel',
                                                'code' => 'import_excel',
                                                'lang' => 'Import_Excel',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 4,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '导出Excel',
                                                'code' => 'export_excel',
                                                'lang' => 'Export_Excel',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 5,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '排序',
                                        'code' => 'sort',
                                        'lang' => 'Sort',
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'list' => [

                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '视图',
                                        'code' => 'view',
                                        'lang' => 'View',
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'list' => [
                                        [
                                            'page' => [
                                                'name' => '保存视图',
                                                'code' => 'save_view',
                                                'lang' => 'Save_View',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 11,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '另存为视图',
                                                'code' => 'save_as_view',
                                                'lang' => 'Save_As_View',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 12,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '修改视图',
                                                'code' => 'modify_view',
                                                'lang' => 'Modify_View',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 13,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ],
                                        [
                                            'page' => [
                                                'name' => '删除视图',
                                                'code' => 'delete_view',
                                                'lang' => 'Delete_View',
                                                'page' => 'home_project_overview',
                                                'param' => '',
                                                'category' => 'tab_team',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 14,
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
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                        'page' => 'home_project_overview',
                                        'param' => '',
                                        'category' => 'tab_team',
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
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_team',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '边侧栏',
                                'code' => 'side_bar',
                                'lang' => 'Side_Bar',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_team',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '导航设置',
                        'code' => 'navigation_setting',
                        'lang' => 'Navigation_Setting',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_navigation',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 156,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '保存导航设置',
                                'code' => 'save',
                                'lang' => 'Save',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_navigation',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 157,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '拖动导航',
                                'code' => 'drag',
                                'lang' => 'Drag',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_navigation',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 126,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '开关按钮',
                                'code' => 'switch_button',
                                'lang' => 'Switch',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_navigation',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 184,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '状态设置',
                        'code' => 'status_setting',
                        'lang' => 'Status_Setting',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_status',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 158,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '创建状态',
                                'code' => 'create',
                                'lang' => 'Create',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_status',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 159,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '状态保存',
                                'code' => 'save',
                                'lang' => 'Save',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_status',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 160,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '状态拖动',
                                'code' => 'drag',
                                'lang' => 'Drag',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_status',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 126,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工序设置',
                        'code' => 'step_setting',
                        'lang' => 'Step_Setting',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_step',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 161,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '工序创建',
                                'code' => 'create',
                                'lang' => 'Create',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_step',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 163,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '工序保存',
                                'code' => 'save',
                                'lang' => 'Save',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_step',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 162,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '工序拖动',
                                'code' => 'drag',
                                'lang' => 'Drag',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_step',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 126,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '磁盘设置',
                        'code' => 'disk_setting',
                        'lang' => 'Disk_Setting',
                        'page' => 'home_project_overview',
                        'param' => '',
                        'category' => 'tab_disk',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 164,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '磁盘创建',
                                'code' => 'create',
                                'lang' => 'Create',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_disk',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 165,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '磁盘修改',
                                'code' => 'modify',
                                'lang' => 'Modify',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_disk',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 185,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '创建项目磁盘',
                                'code' => 'project_disk_create',
                                'lang' => 'Project_Disk_Create',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_disk',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 166,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '删除项目磁盘',
                                'code' => 'delete_disk_create',
                                'lang' => 'Project_Disk_Delete',
                                'page' => 'home_project_overview',
                                'param' => '',
                                'category' => 'tab_disk',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 419,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($homeOverviewPageRows);

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
