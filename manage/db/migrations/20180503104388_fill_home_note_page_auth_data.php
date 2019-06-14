<?php


use Phinx\Migration\AbstractMigration;

class FillHomeNotePageAuthData extends AbstractMigration
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
         * 前台-反馈页面
         */
        $homeNotePageRows = [
            'page' => [
                'name' => '反馈页面',
                'code' => 'project_note',
                'lang' => 'Note',
                'page' => 'home_project_note',
                'menu' => 'top_menu,project',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 181,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '反馈页面访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_project_note',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 181,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工具栏',
                        'code' => 'toolbar',
                        'lang' => 'Toolbar',
                        'page' => 'home_project_note',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '编辑',
                                'code' => 'edit',
                                'lang' => 'Edit',
                                'page' => 'home_project_note',
                                'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                ],
                                [
                                    'page' => [
                                        'name' => '修改缩略图',
                                        'code' => 'modify_thumb',
                                        'lang' => 'Modify_Thumb',
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                'name' => '排序',
                                'code' => 'sort',
                                'lang' => 'Sort',
                                'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                                        'page' => 'home_project_note',
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
                        ],
                        [
                            'page' => [
                                'name' => '视图',
                                'code' => 'view',
                                'lang' => 'View',
                                'page' => 'home_project_note',
                                'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                        'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                                'page' => 'home_project_note',
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
                        'page' => 'home_project_note',
                        'param' => '',
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
                        'page' => 'home_project_note',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '顶部面板',
                                'code' => 'top_panel',
                                'lang' => 'Top_Panel',
                                'page' => 'home_project_note',
                                'param' => '',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '字段配置',
                                        'code' => 'fields_rules',
                                        'lang' => 'Fields_rules',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 168,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '上一个/下一个',
                                        'code' => 'prev_next_one',
                                        'lang' => 'Prev_Next_One',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 169,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '动作',
                                        'code' => 'action',
                                        'lang' => 'Action',
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'name' => '记录Timelog',
                                        'code' => 'timelog',
                                        'lang' => 'Timelog',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 193,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '修改缩略图',
                                        'code' => 'modify_thumb',
                                        'lang' => 'Modify_Thumb',
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                        'page' => 'home_project_note',
                                        'param' => '',
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
                                'name' => '标签栏',
                                'code' => 'tab_bar',
                                'lang' => 'Tab_Bar',
                                'page' => 'home_project_note',
                                'param' => '',
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '反馈',
                                        'code' => 'note',
                                        'lang' => 'Note',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 124,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ],
                                    'list' => [
                                        [
                                            'page' => [
                                                'name' => '反馈',
                                                'code' => 'note',
                                                'lang' => 'note',
                                                'page' => 'home_project_note',
                                                'param' => '',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            [
                                                'page' => [
                                                    'name' => '反馈提交',
                                                    'code' => 'submit',
                                                    'lang' => 'Submit',
                                                    'page' => 'home_project_note',
                                                    'param' => '',
                                                    'type' => 'belong',
                                                    'parent_id' => 0,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ],
                                                'auth_group' => [
                                                    [
                                                        'page_auth_id' => 0,
                                                        'auth_group_id' => 125,
                                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ], [
                                    'page' => [
                                        'name' => '信息',
                                        'code' => 'info',
                                        'lang' => 'Info',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 170,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ],
                                    'list' => [
                                        [
                                            'page' => [
                                                'name' => '修改单个组件信息',
                                                'code' => 'modify',
                                                'lang' => 'Modify',
                                                'page' => 'home_project_note',
                                                'param' => '',
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 171,
                                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '现场数据',
                                        'code' => 'onset',
                                        'lang' => 'Onset',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 172,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '历史记录',
                                        'code' => 'history',
                                        'lang' => 'History',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 176,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '设置标签栏',
                                        'code' => 'template_fixed_tab',
                                        'lang' => 'Template_Fixed_Tab',
                                        'page' => 'home_project_note',
                                        'param' => '',
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 177,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($homeNotePageRows);

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
