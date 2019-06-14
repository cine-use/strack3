<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthGroupData extends AbstractMigration
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
     * Migrate Up.
     */
    public function up()
    {
        /**
         * 创建按钮
         */
        $createButtonRows = [
            'group' => [
                'name' => '创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 269,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户个人组件数据设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 164,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createButtonRows);

        /**
         * 批量编辑按钮
         */
        $batchEditRows = [
            'group' => [
                'name' => '批量编辑',
                'code' => 'batch_edit',
                'lang' => 'Batch_Edit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 批量编辑路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 269,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户个人组件数据设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 164,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 批量编辑按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($batchEditRows);

        /**
         * 动作按钮
         */
        $actionButtonRows = [
            'group' => [
                'name' => '动作',
                'code' => 'action',
                'lang' => 'Action',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取当前触发Action模块详细信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 255,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块Action面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 256,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 设置或者取消Action常用属性路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 257,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 动作按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 338,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionButtonRows);

        /**
         * 导入Excel按钮
         */
        $importExcelButtonRows = [
            'group' => [
                'name' => '导入Excel',
                'code' => 'import_excel',
                'lang' => 'Import_Excel',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 格式化Excel粘贴路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 274,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 上传Excel文件处理路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 275,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 提交导入Excel路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 276,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 导入Excel按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 353,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($importExcelButtonRows);

        /**
         * 导出Excel按钮
         */
        $exportExcelButtonRows = [
            'group' => [
                'name' => '导出Excel',
                'code' => 'export_excel',
                'lang' => 'Export_Excel',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 导出Excel路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 273,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 导出Excel按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 354,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($exportExcelButtonRows);

        /**
         * 修改缩略图按钮
         */
        $changeThumbButtonRows = [
            'group' => [
                'name' => '修改缩略图',
                'code' => 'change_thumb',
                'lang' => 'Change_Thumb',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存媒体信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 179,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改缩略图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 355,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($changeThumbButtonRows);

        /**
         * 清除缩略图按钮
         */
        $clearThumbButtonRows = [
            'group' => [
                'name' => '清除缩略图',
                'code' => 'clear_thumb',
                'lang' => 'Clear_Thumb',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 清除媒体缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 180,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 清除缩略图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 356,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($clearThumbButtonRows);

        /**
         * 表格排序按钮
         */
        $sortGridRows = [
            'group' => [
                'name' => '排序',
                'code' => 'sort',
                'lang' => 'Sort',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取排序字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 232,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取排序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 264,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 排序按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 359,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($sortGridRows);

        /**
         * 表格分组按钮
         */
        $groupGridRows = [
            'group' => [
                'name' => '分组',
                'code' => 'group',
                'lang' => 'group',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 分组按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 360,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($groupGridRows);

        /**
         * 管理自定义字段按钮
         */
        $mangeCustomFieldRows = [
            'group' => [
                'name' => '管理自定义字段',
                'code' => 'manage_custom_fields',
                'lang' => 'Manage_Custom_Fields',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取自定义字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 235,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 判断当前模块是否支持水平扩展路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 238,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取掩码规则列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 248,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 249,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存自定义字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 233,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除自定义字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 234,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改自定义字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 管理自定义字段按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 362,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mangeCustomFieldRows);

        /**
         * 保存视图按钮
         */
        $saveViewRows = [
            'group' => [
                'name' => '保存视图',
                'code' => 'save_view',
                'lang' => 'Save_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 是否分享路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 246,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 228,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存视图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 366,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($saveViewRows);

        /**
         * 另存为视图按钮
         */
        $saveAsViewRows = [
            'group' => [
                'name' => '另存为视图',
                'code' => 'save_as_view',
                'lang' => 'Save_As_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 是否分享路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 246,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 另存为视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 229,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 另存为视图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 367,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($saveAsViewRows);

        /**
         * 修改视图按钮
         */
        $modifyViewRows = [
            'group' => [
                'name' => '修改视图',
                'code' => 'modify_view',
                'lang' => 'Modify_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 是否分享路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 246,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 230,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改视图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 368,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($modifyViewRows);

        /**
         * 删除视图
         */
        $deleteViewRows = [
            'group' => [
                'name' => '删除视图',
                'code' => 'delete_view',
                'lang' => 'Delete_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 231,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除视图按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 369,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteViewRows);

        /**
         * 搜索框过滤按钮
         */
        $searchFilterRows = [
            'group' => [
                'name' => '搜索框过滤',
                'code' => 'search_filter',
                'lang' => 'Search_Filter',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 搜索框过滤按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 370,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($searchFilterRows);

        /**
         * 保存过滤条件按钮
         */
        $searchFilterRows = [
            'group' => [
                'name' => '保存过滤条件',
                'code' => 'save_filter',
                'lang' => 'Save_Filter',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保存过滤条件按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 363,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取过滤标签颜色列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 244,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 是否置顶路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 245,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存过滤条件路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 277,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取过滤条件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 281,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($searchFilterRows);

        /**
         * 后台管理
         */
        $adminManagePageRows = [
            'group' => [
                'name' => '后台管理',
                'code' => 'admin_manage',
                'lang' => 'Admin_Manage',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台管理路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 168,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 后台登录路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 391,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminManagePageRows);

        /**
         * 后台-关于页面
         */
        $adminAboutPageRows = [
            'group' => [
                'name' => '后台关于',
                'code' => 'admin_about',
                'lang' => 'Admin_About',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取系统授权许可路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 1,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取系统关于信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 2,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminAboutPageRows);

        // 复制授权许可按钮
        $copyLicenseRequestRows = [
            'group' => [
                'name' => '复制授权许可',
                'code' => 'copy_license_request',
                'lang' => 'Copy_License_Request',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 复制授权许可按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 296,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($copyLicenseRequestRows);

        // 更新许可按钮
        $updateLicenseRequestRows = [
            'group' => [
                'name' => '更新许可证',
                'code' => 'license_update',
                'lang' => 'License_Update',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 更新许可证路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 3,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新许可证按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 295,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateLicenseRequestRows);


        /**
         * 后台-缓存页面
         */
        $adminCachePageRows = [
            'group' => [
                'name' => '后台缓存',
                'code' => 'admin_cache',
                'lang' => 'Admin_Cache',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 缓存页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 4,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取缓存统计路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 5,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminCachePageRows);

        // 清空系统缓存按钮
        $clearSystemCacheRequestRows = [
            'group' => [
                'name' => '清空系统缓存',
                'code' => 'clear_system_cache',
                'lang' => 'Clear_System_Cache',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 清空系统缓存路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 6,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 清空系统缓存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 371,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($clearSystemCacheRequestRows);

        // 清空日志缓存按钮
        $clearSystemLogsCacheRequestRows = [
            'group' => [
                'name' => '清空日志缓存',
                'code' => 'clear_system_logs_cache',
                'lang' => 'Clear_System_Logs_Cache',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 清空日志缓存路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 7,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 清空日志缓存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 372,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($clearSystemLogsCacheRequestRows);

        // 清空上传文件缓存按钮
        $clearUploadsTempCacheRequestRows = [
            'group' => [
                'name' => '清空上传文件缓存',
                'code' => 'clear_uploads_temp_cache',
                'lang' => 'Clear_Uploads_Temp_Cache',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 清空上传文件缓存路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 8,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 清空上传文件缓存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 372,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($clearUploadsTempCacheRequestRows);

        // 访问事件日志页面
        $adminEventLogPageRows = [
            'group' => [
                'name' => '后台事件日志',
                'code' => 'admin_eventlog',
                'lang' => 'Admin_Eventlog',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 事件日志页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 9,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取事件日志列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 10,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminEventLogPageRows);

        /**
         * 后台-默认设置页面
         */
        $adminDefaultSettingsPageRows = [
            'group' => [
                'name' => '后台默认设置',
                'code' => 'default_settings',
                'lang' => 'Default_Settings',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 默认设置页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 11,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取默认设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 12,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时区列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 13,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取语言包列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 241,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDefaultSettingsPageRows);

        // 默认设置提交
        $defaultSettingsSubmitRows = [
            'group' => [
                'name' => '默认设置提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 默认设置提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新默认设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 381,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($defaultSettingsSubmitRows);

        // 访问媒体服务器设置页面
        $adminMediaServerSettingPageRows = [
            'group' => [
                'name' => '后台媒体服务器设置',
                'code' => 'media_server_setting',
                'lang' => 'Media_Server_Setting',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 默认设置页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 14,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取媒体服务器表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 15,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminMediaServerSettingPageRows);

        // 媒体服务器设置提交按钮
        $mediaServerSettingSubmitRows = [
            'group' => [
                'name' => '媒体服务器设置提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体服务器设置提交按钮路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存媒体服务器设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 16,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaServerSettingSubmitRows);

        // 媒体服务器设置修改按钮
        $mediaServerSettingModifyRows = [
            'group' => [
                'name' => '媒体服务器设置修改',
                'code' => 'modify',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改媒体服务器设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 382,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaServerSettingModifyRows);

        // 媒体服务器设置删除按钮
        $mediaServerSettingModifyRows = [
            'group' => [
                'name' => '删除媒体服务器设置',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除媒体服务器设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 383,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaServerSettingModifyRows);

        // 后台日志务器设置访问
        $adminLogServerSettingPageRows = [
            'group' => [
                'name' => '日志服务器设置',
                'code' => 'log_server_setting',
                'lang' => 'Log_Server_Setting',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日志务器设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 17,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取日志服务器配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 18,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminLogServerSettingPageRows);

        // 日志务器设置提交按钮
        $logServerSettingSubmitRows = [
            'group' => [
                'name' => '日志服务器设置提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日志务器设置提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改日志服务器配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 19,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($logServerSettingSubmitRows);

        // 后台邮件设置页面访问
        $adminEmailPageRows = [
            'group' => [
                'name' => '邮件设置',
                'code' => 'admin_email',
                'lang' => 'Admin_Email',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台邮件设置页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 20,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取邮件设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 21,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取Smtp列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 261,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminEmailPageRows);

        // 邮件设置提交按钮
        $adminEmailSubmitRows = [
            'group' => [
                'name' => '邮件设置提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 邮件设置提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存邮件设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 22,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminEmailSubmitRows);

        // 发送邮件测试按钮
        $testEmailSendSubmitRows = [
            'group' => [
                'name' => '发送邮件测试',
                'code' => 'test_email_send',
                'lang' => 'Test_Email_Send',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 发送邮件测试按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 420,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存邮件设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 396,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($testEmailSendSubmitRows);

        // 后台消息设置页面
        $adminMessagePageRows = [
            'group' => [
                'name' => '后台消息设置',
                'code' => 'admin_message',
                'lang' => 'Admin_Message',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台消息设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 23,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取消息设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 24,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminMessagePageRows);

        // 消息设置提交按钮
        $adminMessageSubmitRows = [
            'group' => [
                'name' => '消息设置按钮',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 消息设置提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存消息设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 25,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminMessageSubmitRows);

        // 后台日程设置页面
        $adminSchedulePageRows = [
            'group' => [
                'name' => '日程设置',
                'code' => 'admin_scheduling',
                'lang' => 'Admin_Scheduling',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台日程设置页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 26,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchedulePageRows);

        // 工作时间按钮
        $workHoursRows = [
            'group' => [
                'name' => '工作时间',
                'code' => 'work_hours',
                'lang' => 'Work_Hours',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工作时间按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 297,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取日程工作时间设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 27,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取排除日期设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 28,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
            ]
        ];

        $this->saveAuthGroup($workHoursRows);

        // 工作日按钮
        $workdayRows = [
            'group' => [
                'name' => '工作日',
                'code' => 'work_day',
                'lang' => 'Work_Day',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工作日按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 329,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($workdayRows);

        // 工作时间提交按钮
        $workHoursSubmitRows = [
            'group' => [
                'name' => '工作时间提交',
                'code' => 'work_hours_submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工作时间提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存工作日设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 29,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($workHoursSubmitRows);

        // 工作提醒按钮
        $remindersButtonRows = [
            'group' => [
                'name' => '工作提醒',
                'code' => 'reminders',
                'lang' => 'Reminders',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工作提醒按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 298,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取工作提醒设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 30,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($remindersButtonRows);

        // 工作提醒提交按钮
        $remindersSubmitRows = [
            'group' => [
                'name' => '工作提醒提交',
                'code' => 'reminders_submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工作提醒提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存工作提醒设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 31,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($remindersSubmitRows);

        // 自定义时间日志项按钮
        $customTimelogButtonRows = [
            'group' => [
                'name' => '自定义时间日志项',
                'code' => 'custom_timelog',
                'lang' => 'Custom_Timelog',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义时间日志项按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 299,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时间日志项路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 32,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($customTimelogButtonRows);

        // 添加时间日志项按钮
        $addTimelogItemRows = [
            'group' => [
                'name' => '添加时间日志项',
                'code' => 'timelog_item_add',
                'lang' => 'Add',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加时间日志项按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 344,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存时间日志项路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 33,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addTimelogItemRows);

        // 修改时间日志项按钮
        $modifyTimelogItemRows = [
            'group' => [
                'name' => '修改时间日志项',
                'code' => 'timelog_item_modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改时间日志项按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改时间日志项路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 34,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($modifyTimelogItemRows);

        // 删除时间日志项按钮
        $deleteTimelogItemRows = [
            'group' => [
                'name' => '删除时间日志项',
                'code' => 'timelog_item_delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除时间日志项按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除时间日志项路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 35,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteTimelogItemRows);

        // 日历设置按钮
        $calendarButtonRows = [
            'group' => [
                'name' => '日历设置',
                'code' => 'calendar',
                'lang' => 'Calendar',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历设置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 300,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取日历设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 36,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarButtonRows);

        // 添加日志事项按钮
        $calendarButtonRows = [
            'group' => [
                'name' => '添加日志事项',
                'code' => 'time_calendar_add',
                'lang' => 'Add',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加日志事项按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 344,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取日历事项列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 385,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarButtonRows);

        // 添加日志事项提交按钮
        $calendarButtonRows = [
            'group' => [
                'name' => '日志事项提交',
                'code' => 'calendar_submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加日志事项提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加日历设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 37,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarButtonRows);

        // 日志事项修改按钮
        $calendarModifyRows = [
            'group' => [
                'name' => '修改日志事项',
                'code' => 'calendar_modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日志事项修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改日历设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 38,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarModifyRows);

        // 日志事项删除按钮
        $calendarModifyRows = [
            'group' => [
                'name' => '删除日志事项',
                'code' => 'calendar_delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日志事项删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除日历设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 39,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarModifyRows);

        // 后台登录方式访问
        $signMethodPageRows = [
            'group' => [
                'name' => '登录方式设置',
                'code' => 'sign_method',
                'lang' => 'Sign_Method',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 登录方式设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 40,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取ldap列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 42,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($signMethodPageRows);

        // 后台登录方式开关按钮
        $switchRows = [
            'group' => [
                'name' => '后台登录方式开/关',
                'code' => 'switch',
                'lang' => 'Switch',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 开关按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 388,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存Ldap设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 43,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($switchRows);

        // 后台Ldap域设置
        $adminLdapSettingPageRows = [
            'group' => [
                'name' => '后台Ldap域设置',
                'code' => 'ldap_setting',
                'lang' => 'Ldap_Setting',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台Ldap域设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 41,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取Ldap列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 44,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminLdapSettingPageRows);


        // 后台Ldap域设置
        $ldapSubmitRows = [
            'group' => [
                'name' => 'Ldap域设置提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存Ldap域设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 45,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($ldapSubmitRows);

        // 后台Ldap域设置
        $ldapModifyRows = [
            'group' => [
                'name' => 'Ldap域设置修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改Ldap域设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 46,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($ldapModifyRows);

        // 后台Ldap域设置删除按钮
        $ldapDeleteRows = [
            'group' => [
                'name' => 'Ldap域设置删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除Ldap域设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 47,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($ldapDeleteRows);


        // 后台部门访问
        $adminDepartmentPageRows = [
            'group' => [
                'name' => '后台部门',
                'code' => 'admin_department',
                'lang' => 'Admin_Department',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 48,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取部门列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 49,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDepartmentPageRows);

        // 后台部门提交按钮
        $adminDepartmentSubmitRows = [
            'group' => [
                'name' => '部门提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //添加部门路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 50,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDepartmentSubmitRows);

        // 后台部门修改按钮
        $adminDepartmentModifyRows = [
            'group' => [
                'name' => '部门修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 338,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改部门路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 51,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDepartmentModifyRows);

        // 后台部门删除按钮
        $adminDepartmentDeleteRows = [
            'group' => [
                'name' => '部门删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //删除部门路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 52,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDepartmentDeleteRows);

        // 后台角色访问
        $adminRolePageRows = [
            'group' => [
                'name' => '后台角色',
                'code' => 'admin_role',
                'lang' => 'Admin_Role',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 53,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取角色列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 54,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取后台权限规则路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 389,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取权限规则子集路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 306,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存角色权限设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 419,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取权限页面数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 430,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取权限字段数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 357,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminRolePageRows);

        // 后台角色提交按钮
        $adminRoleSubmitRows = [
            'group' => [
                'name' => '角色提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //提交角色路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 55,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminRoleSubmitRows);

        // 后台角色修改按钮
        $adminRoleModifyRows = [
            'group' => [
                'name' => '角色修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改角色路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 56,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminRoleModifyRows);

        // 后台角色删除按钮
        $adminRoleDeleteRows = [
            'group' => [
                'name' => '角色删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 角色删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //删除角色路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 57,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminRoleDeleteRows);

        // 后台账户访问
        $adminAccountPageRows = [
            'group' => [
                'name' => '后台账户',
                'code' => 'admin_account',
                'lang' => 'Admin_Account',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 账户访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 58,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取账户列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 59,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminAccountPageRows);

        // 删除用户按钮
        $deleteUserRows = [
            'group' => [
                'name' => '删除用户',
                'code' => 'delete',
                'lang' => 'Delete_Account',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除用户路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 287,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除用户按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteUserRows);

        // 注销用户按钮
        $cancelUserRows = [
            'group' => [
                'name' => '注销用户',
                'code' => 'cancel_account',
                'lang' => 'Cancel_Account',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 注销用户路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 288,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //注销用户按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 289,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($cancelUserRows);

        // 重置用户密码按钮
        $resetAccountPasswordRows = [
            'group' => [
                'name' => '重置用户密码',
                'code' => 'reset',
                'lang' => 'Reset_Account_Password',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 重置用户密码路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 290,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //重置用户密码按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 308,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($resetAccountPasswordRows);

        /**
         * 后台-字段页面
         */
        $adminFieldPageRows = [
            'group' => [
                'name' => '后台字段',
                'code' => 'admin_field',
                'lang' => 'Admin_Field',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 字段页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 60,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取系统所有表列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 397,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取字段配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 61,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminFieldPageRows);

        // 字段保存按钮
        $adminFieldSaveButtonRows = [
            'group' => [
                'name' => '字段保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 字段保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改字段配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 62,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminFieldSaveButtonRows);

        /**
         * 后台-模块页面
         */
        $adminModulePageRows = [
            'group' => [
                'name' => '后台模块',
                'code' => 'admin_module',
                'lang' => 'Admin_Module',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台模块页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 63,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取模块类型列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 64,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取固定模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 65,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取模块数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 66,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取图标列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 262,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModulePageRows);

        // 模块提交按钮
        $adminModuleSubmitButtonRows = [
            'group' => [
                'name' => '模块提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模块提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加模块路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 67,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModuleSubmitButtonRows);

        // 模块修改按钮
        $adminModuleModifyButtonRows = [
            'group' => [
                'name' => '模块修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模块修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改模块路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 68,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModuleModifyButtonRows);

        // 模块修改按钮
        $adminModuleDeleteButtonRows = [
            'group' => [
                'name' => '模块删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模块删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除模块路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 69,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminModuleDeleteButtonRows);

        /**
         * 后台-数据结构
         */
        $adminSchemaPageRows = [
            'group' => [
                'name' => '后台数据结构',
                'code' => 'admin_schema',
                'lang' => 'Admin_Schema',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台模块页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 71,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据结构模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 72,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据结构列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 74,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取Schema连接类型路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 401,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchemaPageRows);

        // 数据结构修改按钮
        $adminSchemaCreateButtonRows = [
            'group' => [
                'name' => '数据结构创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 数据结构创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 创建数据结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 75,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据结构类型列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 73,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据结构列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 74,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchemaCreateButtonRows);

        // 数据结构修改按钮
        $adminSchemaModifyButtonRows = [
            'group' => [
                'name' => '数据结构修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 数据结构修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改数据结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 76,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchemaModifyButtonRows);

        // 数据结构修改按钮
        $adminSchemaDeleteButtonRows = [
            'group' => [
                'name' => '数据结构修改',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 数据结构修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改数据结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 77,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchemaDeleteButtonRows);

        // 数据结构保存按钮
        $adminSchemaSaveButtonRows = [
            'group' => [
                'name' => '数据结构保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 数据结构保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存数据结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 78,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminSchemaSaveButtonRows);

        /**
         * 后台-页面数据结构设置
         */
        $adminPageSchemaUsePageRows = [
            'group' => [
                'name' => '页面数据结构设置',
                'code' => 'admin_page_schema_use',
                'lang' => 'Page_Schema_Use',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 后台模块页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 79,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取页面数据结构列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 80,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据结构Combobox路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 74,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminPageSchemaUsePageRows);

        // 页面数据结构设置添加按钮
        $adminPageSchemaUseSaveButtonRows = [
            'group' => [
                'name' => '页面数据结构设置保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 页面数据结构设置添加按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加页面数据结构设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 81,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminPageSchemaUseSaveButtonRows);

        // 页面数据结构设置修改按钮
        $adminPageSchemaUseModifyButtonRows = [
            'group' => [
                'name' => '页面数据结构设置修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 页面数据结构设置修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改页面数据结构设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 82,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminPageSchemaUseModifyButtonRows);

        // 页面数据结构设置删除按钮
        $adminPageSchemaUseDeleteButtonRows = [
            'group' => [
                'name' => '页面数据结构设置删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 页面数据结构设置删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除页面数据结构设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 83,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminPageSchemaUseDeleteButtonRows);

        /**
         * 后台-多语言设置
         */
        $adminLanguagePageRows = [
            'group' => [
                'name' => '后台多语言设置',
                'code' => 'admin_language',
                'lang' => 'Admin_Language',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 多语言设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 84,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取语言包列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 241,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取多语言模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 85,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminLanguagePageRows);

        // 生成语言包按钮
        $buildLanguagePackageRows = [
            'group' => [
                'name' => '生成语言包',
                'code' => 'build_language_package',
                'lang' => 'Build_Language_Package',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 生成语言包路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 86,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 生成语言包按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 390,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($buildLanguagePackageRows);

        /**
         * 后台-动作访问
         */
        $adminActionPageRows = [
            'group' => [
                'name' => '后台动作',
                'code' => 'admin_action',
                'lang' => 'Admin_Action',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 账户访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 87,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取动作列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 88,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存媒体信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 179,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminActionPageRows);

        /**
         * 后台-后台工序页面
         */
        $adminStepPageRows = [
            'group' => [
                'name' => '后台工序',
                'code' => 'admin_step',
                'lang' => 'Admin_Step',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 89,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取工序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 90,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStepPageRows);


        // 后台工序提交按钮
        $adminStepSubmitRows = [
            'group' => [
                'name' => '工序提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加工序路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 91,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStepSubmitRows);

        // 后台工序修改按钮
        $adminStepModifyRows = [
            'group' => [
                'name' => '工序修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改工序路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 92,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStepModifyRows);

        // 后台工序删除按钮
        $adminStepDeleteRows = [
            'group' => [
                'name' => '工序删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //删除工序路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 292,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStepDeleteRows);

        /**
         * 后台-状态页面
         */
        $adminStatusPageRows = [
            'group' => [
                'name' => '后台状态',
                'code' => 'admin_status',
                'lang' => 'Admin_Status',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 93,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取状态列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 94,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取图标列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 262,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //获取状态分组路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 263,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStatusPageRows);

        // 后台状态提交按钮
        $adminStatusSubmitRows = [
            'group' => [
                'name' => '状态提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 95,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStatusSubmitRows);

        // 后台状态修改按钮
        $adminStatusModifyRows = [
            'group' => [
                'name' => '状态修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 96,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStatusModifyRows);

        // 后台状态删除按钮
        $adminStatusDeleteRows = [
            'group' => [
                'name' => '状态删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //删除状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 97,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminStatusDeleteRows);

        /**
         * 后台-标签页面
         */
        $adminTagPageRows = [
            'group' => [
                'name' => '后台标签',
                'code' => 'admin_tag',
                'lang' => 'Admin_Tag',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 98,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取标签列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 99,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取标签类型列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 243,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTagPageRows);

        // 后台标签提交按钮
        $adminTagSubmitRows = [
            'group' => [
                'name' => '标签提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加标签路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 100,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTagSubmitRows);

        // 后台标签修改按钮
        $adminTagModifyRows = [
            'group' => [
                'name' => '标签修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改标签路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 101,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTagModifyRows);

        // 后台标签删除按钮
        $adminTagDeleteRows = [
            'group' => [
                'name' => '标签删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //删除标签路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 102,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTagDeleteRows);

        /**
         * 后台-磁盘页面
         */
        $adminDisksPageRows = [
            'group' => [
                'name' => '后台磁盘',
                'code' => 'admin_disks',
                'lang' => 'Admin_Disks',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 103,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取磁盘列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 104,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDisksPageRows);

        // 后台磁盘提交按钮
        $adminDisksSubmitRows = [
            'group' => [
                'name' => '磁盘提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 105,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDisksSubmitRows);

        // 后台磁盘修改按钮
        $adminDisksModifyRows = [
            'group' => [
                'name' => '磁盘修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //修改磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 106,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDisksModifyRows);

        // 后台磁盘删除按钮
        $adminDisksDeleteRows = [
            'group' => [
                'name' => '磁盘删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 107,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminDisksDeleteRows);

        /**
         * 后台-项目模版页面
         */
        $adminTemplatePageRows = [
            'group' => [
                'name' => '后台项目模版',
                'code' => 'admin_template',
                'lang' => 'Project_Template',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模版访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 108,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模版列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 109,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 114,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板导航模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 115,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 116,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 121,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板状态列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 117,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板数据列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 118,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取排序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 264,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板关联字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 119,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取任务模块字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 120,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取模块标签栏列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 122,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //获取项目模板工序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 123,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板工序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 123,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 127,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取标签数据列表
                    'auth_group_id' => 0,
                    'auth_node_id' => 404,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplatePageRows);

        // 后台项目模版创建按钮
        $adminTemplateCreateRows = [
            'group' => [
                'name' => '项目模版创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模版创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取实体数据结构列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 110,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplateCreateRows);

        // 后台项目模版提交按钮
        $adminTemplateSubmitRows = [
            'group' => [
                'name' => '项目模版提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模版提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 343,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加项目模版路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 111,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplateSubmitRows);

        // 后台项目模板修改按钮
        $adminTemplateModifyRows = [
            'group' => [
                'name' => '项目模板修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目模板路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 112,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplateModifyRows);

        // 后台项目模版删除按钮
        $adminTemplateDeleteRows = [
            'group' => [
                'name' => '项目模版删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除项目模板路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 113,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplateDeleteRows);

        // 后台项目模板重置按钮
        $adminTemplateResetRows = [
            'group' => [
                'name' => '项目模板重置',
                'code' => 'reset',
                'lang' => 'Reset',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 重置项目模板按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 308,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目内置模板路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 293,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 重置项目模板路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 294,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminTemplateResetRows);

        /**
         * 后台-项目设置页面
         */
        $adminProjectPageRows = [
            'group' => [
                'name' => '后台项目设置',
                'code' => 'admin_project',
                'lang' => 'Project_Setting',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目设置访问路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 124,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目设置列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 125,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目详情路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 126,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目状态列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 265,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminProjectPageRows);

        // 后台项目设置提交按钮
        $adminManageModifyProjectRows = [
            'group' => [
                'name' => '保存项目',
                'code' => 'save_project',
                'lang' => 'Save_Project',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保存项目按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存项目路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 128,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminManageModifyProjectRows);

        // 后台项目设置删除按钮
        $adminManageDeleteProjectRows = [
            'group' => [
                'name' => '删除项目',
                'code' => 'delete_project',
                'lang' => 'Delete_Project',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除项目按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除项目路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 129,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($adminManageDeleteProjectRows);

        /**
         * 个人账户页面
         */
        $myAccountPageRows = [
            'group' => [
                'name' => '个人账户',
                'code' => 'my_account',
                'lang' => 'My_Account',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 157,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前用户信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 159,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myAccountPageRows);

        // 上传头像按钮
        $uploadThumbRows = [
            'group' => [
                'name' => '上传头像',
                'code' => 'upload_thumb',
                'lang' => 'Upload_Thumb',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 上传头像按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 302,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 保存媒体信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 179,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($uploadThumbRows);

        // 编辑用户信息按钮
        $myAccountSaveRows = [
            'group' => [
                'name' => '编辑用户信息',
                'code' => 'edit',
                'lang' => 'Edit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 个人账户编辑按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 350,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改当前用户信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 163,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myAccountSaveRows);

        // 偏好设置页面
        $myAccountPreferencePageRows = [
            'group' => [
                'name' => '偏好设置',
                'code' => 'my_account_preference',
                'lang' => 'My_Account_Preference',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 158,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取个人偏好设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 160,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取语言包列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 241,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取时区列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 247,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myAccountPreferencePageRows);

        // 偏好设置编辑按钮
        $preferenceSaveRows = [
            'group' => [
                'name' => '编辑偏好设置',
                'code' => 'edit',
                'lang' => 'Edit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 编辑按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 350,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 更新个人偏好设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 161,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($preferenceSaveRows);

        /**
         * 项目首页
         */
        $homeProjectPageRows = [
            'group' => [
                'name' => '项目首页',
                'code' => 'project',
                'lang' => 'Project',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目首页路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 130,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目工作栏设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 131,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 132,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($homeProjectPageRows);

        // 新建项目按钮
        $addProjectButtonRows = [
            'group' => [
                'name' => '新建项目',
                'code' => 'add_project',
                'lang' => 'Add_Project',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 新建项目按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 301,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addProjectButtonRows);

        /**
         * 新建项目页面
         */
        $addProjectPageRows = [
            'group' => [
                'name' => '新建项目',
                'code' => 'add_project',
                'lang' => 'Add_Project',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 新建项目路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 133,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取模板列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 134,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目状态列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 265,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取磁盘列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 266,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存项目路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 135,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加项目磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 138,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加更多磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 140,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addProjectPageRows);

        /**
         * common-批量删除按钮
         */
        $batchDeleteRows = [
            'group' => [
                'name' => '批量删除',
                'code' => 'batch_delete',
                'lang' => 'Batch_Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 批量删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 270,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 批量删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 344,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($batchDeleteRows);

        /**
         * common-反馈按钮
         */
        $noteTabRows = [
            'group' => [
                'name' => '反馈',
                'code' => 'note',
                'lang' => 'note',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取反馈列表数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 194,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取被At用户列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 189,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 反馈按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 331,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 254,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加反馈路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 190,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改反馈路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 191,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteTabRows);

        /**
         * common-反馈提交按钮
         */
        $noteTabRows = [
            'group' => [
                'name' => '反馈提交',
                'code' => 'submit',
                'lang' => 'Submit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈提交按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 335,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 254,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加反馈路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 190,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteTabRows);

        /**
         * common-拖动按钮
         */
        $dragButtonRows = [
            'group' => [
                'name' => '拖动',
                'code' => 'drag',
                'lang' => 'Drag',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 拖动按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 348,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
            ]
        ];

        $this->saveAuthGroup($dragButtonRows);

        /**
         * common-查看按钮
         */
        $authViewButtonRows = [
            'group' => [
                'name' => '查看',
                'code' => 'auth_view',
                'lang' => 'Auth_View',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 查看按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 342,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
            ]
        ];

        $this->saveAuthGroup($authViewButtonRows);

        /**
         * Entity-新增实体任务按钮
         */
        $addEntityTaskRows = [
            'group' => [
                'name' => '分配任务',
                'code' => 'entity_add_task',
                'lang' => 'Entity_Add_Task',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取工序Combobox列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 251,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取面板字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户个人组件数据设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 164,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 批量添加任务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 220,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 分配任务按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 358,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addEntityTaskRows);

        /**
         * Entity-工序按钮
         */
        $stepButtonRows = [
            'group' => [
                'name' => '工序',
                'code' => 'step',
                'lang' => 'Step',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 364,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepButtonRows);

        /*================================================分割线=============================================*/

        /**
         * 媒体页面
         */
        $projectMediaPageRows = [
            'group' => [
                'name' => '项目媒体',
                'code' => 'project_media',
                'lang' => 'Media',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目媒体路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 170,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
            ]
        ];

        $this->saveAuthGroup($projectMediaPageRows);

        // 审核任务按钮
        $reviewTaskRows = [
            'group' => [
                'name' => '审核任务',
                'code' => 'review_task',
                'lang' => 'Review_Task',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核任务按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 312,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($reviewTaskRows);

        // 我的审核按钮
        $myReviewTaskRows = [
            'group' => [
                'name' => '我的审核',
                'code' => 'my_review',
                'lang' => 'My_Review',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 我的审核按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 308,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核任务列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 171,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定审核任务时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 206,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($myReviewTaskRows);

        // 全部审核按钮
        $wholeReviewTaskRows = [
            'group' => [
                'name' => '全部审核',
                'code' => 'whole',
                'lang' => 'Whole',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 全部审核按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 367,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核任务列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 171,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定审核任务时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 206,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($wholeReviewTaskRows);

        // 播放列表按钮
        $reviewPlayerRows = [
            'group' => [
                'name' => '播放列表',
                'code' => 'tab_playlist',
                'lang' => 'Playlist',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 播放列表按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 313,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewPlayerRows);

        // 我创建的播放列表按钮
        $myCreatedPlayerRows = [
            'group' => [
                'name' => '我创建的',
                'code' => 'my_created',
                'lang' => 'My_Created',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 我创建的播放列表按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 369,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 172,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表媒体时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 205,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myCreatedPlayerRows);

        // 我关注的播放列表按钮
        $myFollowedPlayerRows = [
            'group' => [
                'name' => '我关注的',
                'code' => 'my_followed',
                'lang' => 'My_Followed',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 我关注的播放列表按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 368,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核关注播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 173,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表媒体时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 205,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myFollowedPlayerRows);

        // 全部播放列表按钮
        $wholePlayerRows = [
            'group' => [
                'name' => '全部播放列表',
                'code' => 'whole',
                'lang' => 'Whole',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 我关注的播放列表按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 367,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 172,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表媒体时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 205,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($wholePlayerRows);

        // 创建播放按钮
        $createPlayerRows = [
            'group' => [
                'name' => '播放创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前审核实体状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 154,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目审核模块工序配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 153,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取媒体表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 181,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createPlayerRows);

        // 修改播放按钮
        $modifyPlaylistRows = [
            'group' => [
                'name' => '播放修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表下的实体详情信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 221,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表媒体时间线数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 205,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目审核模块工序配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 153,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前审核实体状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 154,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取媒体表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 181,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [
                    // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取面板字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($modifyPlaylistRows);

        // 删除播放按钮
        $deletePlaylistRows = [
            'group' => [
                'name' => '播放删除',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取播放列表下的实体详情信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 176,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核任务列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 171,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deletePlaylistRows);

        // 关注播放按钮
        $followPlaylistButtonRows = [
            'group' => [
                'name' => '播放关注',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 319,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 关注指定的审核实体播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 174,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followPlaylistButtonRows);

        // 播放保存时间线按钮
        $addPlayTimeLineRows = [
            'group' => [
                'name' => '保存播放时间线',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保存时间线按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addPlayTimeLineRows);

        // 添加到时间线按钮
        $addToTimeLineRows = [
            'group' => [
                'name' => '添加到时间线',
                'code' => 'add_to_timeline',
                'lang' => 'Add_To_Timeline',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加到时间线按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 378,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取媒体时间线文件提交数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 204,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addToTimeLineRows);

        // 保存时间线按钮
        $saveTimeLineRows = [
            'group' => [
                'name' => '保存时间线',
                'code' => 'save_timeline',
                'lang' => 'Save_Timeline',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加到时间线按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 379,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 182,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($saveTimeLineRows);

        // 重载时间线按钮
        $reloadTimeLineRows = [
            'group' => [
                'name' => '重载时间线',
                'code' => 'reload_timeline',
                'lang' => 'Reload_Timeline',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 重载时间线按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 318,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存播放列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 182,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reloadTimeLineRows);

        // 元数据按钮
        $metadataButtonRows = [
            'group' => [
                'name' => '元数据',
                'code' => 'metadata',
                'lang' => 'Metadata',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 元数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 324,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取反馈列表数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 194,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取被At用户列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 189,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($metadataButtonRows);

        // 截屏绘制按钮
        $playerPainterButtonRows = [
            'group' => [
                'name' => '截屏绘制',
                'code' => 'player_painter',
                'lang' => 'Player_Painter',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 截屏绘制按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 325,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取反馈列表数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 194,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取被At用户列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 189,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($playerPainterButtonRows);

        // 审核文件按钮
        $fileCommitButtonRows = [
            'group' => [
                'name' => '审核文件',
                'code' => 'file_commit',
                'lang' => 'File_Commit',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 315,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取媒体表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 181,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存媒体信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 179,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 批量编辑路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 269,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 225,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户个人组件数据设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 164,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitButtonRows);

        // 审核进度按钮
        $reviewProgressRows = [
            'group' => [
                'name' => '审核进度',
                'code' => 'review_progress',
                'lang' => 'Review_Progress',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核进度按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 319,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取审核实体审核进度路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 177,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewProgressRows);

        // 基本信息按钮
        $baseInfoRows = [
            'group' => [
                'name' => '基本信息',
                'code' => 'base_info',
                'lang' => 'Base_Info',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 基本信息按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 320,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //  获取当前审核任务详细信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 186,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($baseInfoRows);

        // 修改基本信息按钮
        $modifyBaseInfoRows = [
            'group' => [
                'name' => '修改基本信息',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改基本信息按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //  修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($modifyBaseInfoRows);

        // 删除审核任务按钮
        $deleteReviewTaskButtonRows = [
            'group' => [
                'name' => '删除审核任务',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除审核任务按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除指定的审核任务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 175,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteReviewTaskButtonRows);


        /**
         * 项目-设置页面
         */
        $projectOverviewPageRows = [
            'group' => [
                'name' => '设置页面',
                'code' => 'overview',
                'lang' => 'Overview',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 设置页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 169,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectOverviewPageRows);

        /**
         * 设置页面-详情按钮
         */
        $detailsButtonRows = [
            'group' => [
                'name' => '详情',
                'code' => 'details',
                'lang' => 'Details',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 详情按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 309,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 136,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面字段配置
                    'auth_group_id' => 0,
                    'auth_node_id' => 374,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据配置
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取组件数据配置
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($detailsButtonRows);

        /**
         * 设置页面-团队按钮
         */
        $teamButtonRows = [
            'group' => [
                'name' => '团队',
                'code' => 'team',
                'lang' => 'Team',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 团队按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 310,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目团队列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 137,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 267,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($teamButtonRows);

        /**
         * 设置页面-导航设置按钮
         */
        $navigationButtonRows = [
            'group' => [
                'name' => '导航设置',
                'code' => 'navigation_setting',
                'lang' => 'Navigation_Setting',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 导航设置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 311,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 146,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($navigationButtonRows);

        // 导航保存按钮
        $navigationSaveButtonRows = [
            'group' => [
                'name' => '导航保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目导航配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 147,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($navigationSaveButtonRows);

        /**
         * 设置页面-状态设置按钮
         */
        $statusSettingButtonRows = [
            'group' => [
                'name' => '状态设置',
                'code' => 'status_setting',
                'lang' => 'Status_Setting',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态设置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 312,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 148,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目状态列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 149,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusSettingButtonRows);

        // 状态创建按钮
        $statusCreateButtonRows = [
            'group' => [
                'name' => '状态创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取图标列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 262,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取状态分组路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 263,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 新增项目状态路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 144,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusCreateButtonRows);

        // 状态保存按钮
        $statusSaveButtonRows = [
            'group' => [
                'name' => '状态保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改指定模块状态设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 151,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusSaveButtonRows);

        /**
         * 设置页面-工序设置按钮
         */
        $stepSettingButtonRows = [
            'group' => [
                'name' => '工序设置',
                'code' => 'step_setting',
                'lang' => 'step_Setting',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序设置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 313,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模块列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 148,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改指定模块工序设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 152,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目工序列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 150,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepSettingButtonRows);

        // 工序保存按钮
        $stepSaveButtonRows = [
            'group' => [
                'name' => '工序保存',
                'code' => 'save',
                'lang' => 'Save',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序保存按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 345,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存工序配置修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 151,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepSaveButtonRows);

        // 工序创建按钮
        $stepCreateButtonRows = [
            'group' => [
                'name' => '工序创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 新增项目工序路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 145,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepCreateButtonRows);

        // 磁盘设置按钮
        $diskSettingButtonRows = [
            'group' => [
                'name' => '磁盘设置',
                'code' => 'disk_setting',
                'lang' => 'Disk_Setting',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘设置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 314,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目磁盘配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 143,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取磁盘列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 266,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
            ]
        ];

        $this->saveAuthGroup($diskSettingButtonRows);

        // 磁盘创建按钮
        $diskCreateButtonRows = [
            'group' => [
                'name' => '磁盘创建',
                'code' => 'create',
                'lang' => 'Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘创建按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 349,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加项目磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 138,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskCreateButtonRows);

        // 创建项目磁盘按钮
        $diskMoreSettingsRows = [
            'group' => [
                'name' => '创建项目磁盘',
                'code' => 'project_disk_create',
                'lang' => 'Project_Disk_Create',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建项目磁盘按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 380,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取磁盘列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 266,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加更多磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 140,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskMoreSettingsRows);

        /**
         * 项目-详情页面
         */
        $detailsPageRows = [
            'group' => [
                'name' => '详情页面',
                'code' => 'details',
                'lang' => 'details',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 222,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($detailsPageRows);

        /**
         * 详情页面-字段配置按钮
         */
        $fieldConfigButtonRows = [
            'group' => [
                'name' => '字段配置',
                'code' => 'fields_rules',
                'lang' => 'Fields_rules',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取用户配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 156,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面字段配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 366,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 字段配置按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 332,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面模块字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 374,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 425,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fieldConfigButtonRows);

        /**
         * 详情页面-上一个下一个按钮
         */
        $prevNextOneButtonRows = [
            'group' => [
                'name' => '上一个/下一个',
                'code' => 'prev_next_one',
                'lang' => 'Prev_Next_One',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 上一个下一个按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 337,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($prevNextOneButtonRows);

        // 信息按钮
        $infoTabRows = [
            'group' => [
                'name' => '信息',
                'code' => 'info',
                'lang' => 'Info',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 信息按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 324,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ //  获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($infoTabRows);

        // 修改单个组件信息按钮
        $updateWidgetRows = [
            'group' => [
                'name' => '修改单个组件信息',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件信息按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 338,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateWidgetRows);

        // 现场数据按钮
        $onsetTabRows = [
            'group' => [
                'name' => '现场数据',
                'code' => 'onset',
                'lang' => 'Onset',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取实体或者任务现场数据关联关系数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 197,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目现场数据列表数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 198,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取现场数据详情数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 200,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取现场数据关联附件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 201,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 现场数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 326,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存媒体信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 179,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetTabRows);

        // 文件按钮
        $fileTabRows = [
            'group' => [
                'name' => '文件',
                'code' => 'file',
                'lang' => 'File',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 328,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面表格数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 253,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTabRows);

        // 相关任务按钮
        $correlationTaskTabRows = [
            'group' => [
                'name' => '相关任务',
                'code' => 'correlation_task',
                'lang' => 'Correlation_Task',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 相关任务按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 327,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面表格数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 253,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($correlationTaskTabRows);

        // 水平关联按钮
        $correlationTaskTabRows = [
            'group' => [
                'name' => '水平关联',
                'code' => 'horizontal_relationship',
                'lang' => 'Horizontal_Relationship',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 330,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面表格数据按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 253,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($correlationTaskTabRows);

        // 历史记录按钮
        $historyTabRows = [
            'group' => [
                'name' => '历史记录',
                'code' => 'history',
                'lang' => 'History',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 历史记录按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 325,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块下面某项的历史操作记录
                    'auth_group_id' => 0,
                    'auth_node_id' => 271,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($historyTabRows);

        // 设置标签栏按钮
        $templateFixedTabRows = [
            'group' => [
                'name' => '设置标签栏',
                'code' => 'template_fixed_tab',
                'lang' => 'Template_Fixed_Tab',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取模块标签栏列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 122,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 116,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块标签栏列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 422,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 423,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 421,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目模板配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 121,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 设置标签栏按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 333,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($templateFixedTabRows);

        /**
         * 项目-任务页面
         */
        $projectBasePageRows = [
            'group' => [
                'name' => '项目任务',
                'code' => 'project_base',
                'lang' => 'Project_Base',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务页面路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 184,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取Base表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 185,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectBasePageRows);

        /**
         * 项目-文件页面
         */
        $projectFilePageRows = [
            'group' => [
                'name' => '项目文件',
                'code' => 'project_file',
                'lang' => 'Project_File',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 202,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取文件表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 203,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectFilePageRows);

        /**
         * 项目-文件提交页面
         */
        $projectFileCommitPageRows = [
            'group' => [
                'name' => '项目文件提交',
                'code' => 'project_file_commit',
                'lang' => 'Project_File_Commit',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 207,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取文件提交表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 208,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectFileCommitPageRows);

        /**
         * 项目-反馈页面
         */
        $projectNotePageRows = [
            'group' => [
                'name' => '项目反馈',
                'code' => 'project_note',
                'lang' => 'Project_Note',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 187,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取反馈表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 188,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectNotePageRows);

        /**
         * 项目-现场数据页面
         */
        $projectOnsetPageRows = [
            'group' => [
                'name' => '项目现场数据',
                'code' => 'project_onset',
                'lang' => 'Project_Onset',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 195,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取现场数据表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 196,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectOnsetPageRows);

        /**
         * 项目-时间日志页面
         */
        $projectTimeLogPageRows = [
            'group' => [
                'name' => '项目项目时间日志',
                'code' => 'project_timelog',
                'lang' => 'Project_Timelog',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 209,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时间日志事表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 210,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectTimeLogPageRows);

        /**
         * 导航设置-开关按钮
         */
        $navigationSwitchButtonRows = [
            'group' => [
                'name' => '导航开关按钮',
                'code' => 'switch_button',
                'lang' => 'Switch',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 导航开关按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 388,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($navigationSwitchButtonRows);

        /**
         * 磁盘设置-修改按钮
         */
        $diskModifyButtonRows = [
            'group' => [
                'name' => '磁盘修改',
                'code' => 'modify',
                'lang' => 'Modify',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 导航开关按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 346,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改项目磁盘路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 139,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($diskModifyButtonRows);

        /**
         * 删除动作按钮
         */
        $deleteActionButtonRows = [
            'group' => [
                'name' => '删除动作',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除动作路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 291,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($deleteActionButtonRows);

        /**
         * 保持显示按钮
         */
        $filterKeepButtonRows = [
            'group' => [
                'name' => '保持显示',
                'code' => 'keep_display',
                'lang' => 'Keep_Display',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 保持显示按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 305,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 保存用户过滤面板设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 162,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($filterKeepButtonRows);

        /**
         * 时间日志添加按钮
         */
        $timelogAddButtonRows = [
            'group' => [
                'name' => '时间日志添加',
                'code' => 'add',
                'lang' => 'Top_Panel',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 344,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($timelogAddButtonRows);

        /**
         * 消息盒子按钮
         */
        $messageBoxButtonRows = [
            'group' => [
                'name' => '消息盒子',
                'code' => 'message_box',
                'lang' => 'Inbox',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 消息盒子按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 387,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取消息盒子数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 285,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 标记已读消息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 286,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($messageBoxButtonRows);

        /**
         * 时间日志按钮
         */
        $timelogButtonRows = [
            'group' => [
                'name' => '时间日志',
                'code' => 'timelog',
                'lang' => 'Timelog',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 339,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时间日志边侧栏-激活计时器路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 211,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时间日志边侧栏-个人记录路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 212,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取时间日志事项列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 213,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除时间日志路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 217,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加时间日志计时器路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 214,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 停止时间日志计时器路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 215,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 停止开启时间日志路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 216,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($timelogButtonRows);

        /**
         * 置顶过滤按钮
         */
        $stickFilterButtonRows = [
            'group' => [
                'name' => '置顶过滤',
                'code' => 'stick_filter',
                'lang' => 'Stick_Filter',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 置顶过滤按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 429,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 置顶选择的过滤条件路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 278,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($stickFilterButtonRows);

        /**
         * 删除过滤按钮
         */
        $deleteFilterButtonRows = [
            'group' => [
                'name' => '删除过滤',
                'code' => 'delete',
                'lang' => 'Delete',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除过滤按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 347,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 删除过滤条件路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 279,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取过滤条件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 281,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($deleteFilterButtonRows);

        /**
         * 记录Timelog按钮
         */
        $timelogButtonRows = [
            'group' => [
                'name' => '记录Timelog',
                'code' => 'timelog',
                'lang' => 'Timelog',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 记录Timelog按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 339,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->saveAuthGroup($timelogButtonRows);

        /**
         *  项目-实体页面
         */
        $projectEntityPageRows = [
            'group' => [
                'name' => '项目实体',
                'code' => 'project_entity',
                'lang' => 'Project_Entity',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 218,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 组装表格列数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 223,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取表格面板数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 224,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取实体表格数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 219,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取高级过滤字段列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 226,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改单个组件数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 268,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取水平关联目标数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 258,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 更新水平关联数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 259,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取详情页面顶部缩略图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 183,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取指定模块详细信息数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 252,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 239,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取当前模块面包屑导航路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 237,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取数据表格边侧栏历史数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 272,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 切换视图路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 227,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取单个过滤条件信息路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 280,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 修改关联查询数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 680,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectEntityPageRows);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group');
        $this->execute('DELETE FROM strack_auth_group_node');
    }
}
