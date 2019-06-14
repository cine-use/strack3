<?php


use Phinx\Migration\AbstractMigration;

class FillHomeMediaPageAuthData extends AbstractMigration
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
         * 前台-媒体页面
         */
        $homeMediaPageRows = [
            'page' => [
                'name' => '媒体页面',
                'code' => 'project_media',
                'lang' => 'Media',
                'page' => 'home_project_media',
                'menu' => 'top_menu,project',
                'param' => '',
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 130,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '媒体访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_project_media',
                        'param' => '',
                        'category' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 130,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '左侧面板',
                        'code' => 'left_panel',
                        'lang' => 'Left_Panel',
                        'page' => 'home_project_media',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '审核任务',
                                'code' => 'tab_review_task',
                                'lang' => 'Review_Task',
                                'page' => 'home_project_media',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 131,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '我的审核',
                                        'code' => 'my_review',
                                        'lang' => 'My_Review',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 132,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '全部审核',
                                        'code' => 'whole',
                                        'lang' => 'Whole',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 133,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '删除审核任务',
                                        'code' => 'delete',
                                        'lang' => 'Delete',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 152,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '播放列表',
                                'code' => 'tab_playlist',
                                'lang' => 'Playlist',
                                'page' => 'home_project_media',
                                'param' => '',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 134,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '我创建的',
                                        'code' => 'my_created',
                                        'lang' => 'My_Created',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_create',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 135,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '我关注的',
                                        'code' => 'my_followed',
                                        'lang' => 'My_Followed',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_follow',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 136,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '全部播放列表',
                                        'code' => 'whole',
                                        'lang' => 'Whole',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_all_playlist',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 137,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '播放创建',
                                        'code' => 'create',
                                        'lang' => 'Create',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 138,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '播放修改',
                                        'code' => 'modify',
                                        'lang' => 'Modify',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 139,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '播放删除',
                                        'code' => 'delete',
                                        'lang' => 'Delete',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 140,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '播放关注',
                                        'code' => 'follow',
                                        'lang' => 'Follow',
                                        'category' => 'tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 141,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '右侧面板',
                        'code' => 'right_panel',
                        'lang' => 'Right_Panel',
                        'page' => 'home_project_media',
                        'param' => '',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '反馈',
                                'code' => 'note',
                                'lang' => 'note',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_note,tab_all_task,tab_my_review',
                                'type' => 'belong',
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
                                        'name' => '反馈提交',
                                        'code' => 'submit',
                                        'lang' => 'Submit',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_note,tab_all_task,tab_my_review',
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
                        ],
                        [
                            'page' => [
                                'name' => '审核进度',
                                'code' => 'review_progress',
                                'lang' => 'Review_Progress',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_progress,tab_all_task,tab_my_review',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 149,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '基本信息',
                                'code' => 'base_info',
                                'lang' => 'Base_Info',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_details,tab_all_task,tab_my_review',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 150,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '修改缩略图',
                                        'code' => 'modify_thumb',
                                        'lang' => 'Modify_Thumb',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_details,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_details,tab_all_task,tab_my_review',
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
                                ],
                                [
                                    'page' => [
                                        'name' => '修改基本信息',
                                        'code' => 'modify',
                                        'lang' => 'Modify',
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_details,tab_all_task,tab_my_review',
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 151,
                                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '播放器',
                        'code' => 'player',
                        'lang' => 'Webplayer',
                        'page' => 'home_project_media',
                        'param' => '',
                        'category' => 'tab_player',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '元数据',
                                'code' => 'metadata',
                                'lang' => 'Metadata',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_player',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 140,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '截屏绘制',
                                'code' => 'player_painter',
                                'lang' => 'Player_Painter',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_player',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 141,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '拖动时间线',
                                'code' => 'drag',
                                'lang' => 'Drag',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_player',
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
                                'name' => '保存播放时间线',
                                'code' => 'save_timeline',
                                'lang' => 'Save',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_player',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 142,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '重载时间线',
                                'code' => 'reload_timeline',
                                'lang' => 'Reload_Timeline',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_player',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 145,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '文件提交',
                        'code' => 'file_commit',
                        'lang' => 'File_Commit',
                        'page' => 'home_project_media',
                        'param' => '',
                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist',
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string,
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 148,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '添加到时间线',
                                'code' => 'add_to_timeline',
                                'lang' => 'Add_To_Timeline',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 143,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '保存时间线',
                                'code' => 'save_timeline',
                                'lang' => 'Save_Timeline',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => Webpatser\Uuid\Uuid::generate()->string
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 144,
                                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '工具栏',
                                'code' => 'toolbar',
                                'lang' => 'Toolbar',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                                'page' => 'home_project_media',
                                                'param' => '',
                                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                        [
                            'page' => [
                                'name' => '过滤面板',
                                'code' => 'filter_panel',
                                'lang' => 'Filter_Panel',
                                'page' => 'home_project_media',
                                'param' => '',
                                'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                                        'page' => 'home_project_media',
                                        'param' => '',
                                        'category' => 'tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review',
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
                        ]
                    ]
                ]
            ]
        ];

        $this->savePageAuth($homeMediaPageRows);

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
