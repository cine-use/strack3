<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultApiAuthGroupData extends AbstractMigration
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
         * 动作单条查找
         */
        $actionFindRouteRows = [
            'group' => [
                'name' => '动作单条查找',
                'code' => 'action_find',
                'lang' => 'Action_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 431,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionFindRouteRows);

        /**
         * 动作多条查找
         */
        $actionSelectRouteRows = [
            'group' => [
                'name' => '动作多条查找',
                'code' => 'action_select',
                'lang' => 'Action_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 432,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionSelectRouteRows);

        /**
         * 动作修改
         */
        $actionUpdateRouteRows = [
            'group' => [
                'name' => '动作修改',
                'code' => 'action_update',
                'lang' => 'Action_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 433,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionUpdateRouteRows);

        /**
         * 动作创建
         */
        $actionCreateRouteRows = [
            'group' => [
                'name' => '动作创建',
                'code' => 'action_create',
                'lang' => 'Action_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 434,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionCreateRouteRows);

        /**
         * 动作删除
         */
        $actionUpdateRouteRows = [
            'group' => [
                'name' => '动作删除',
                'code' => 'action_delete',
                'lang' => 'Action_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 435,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionUpdateRouteRows);

        /**
         * 动作字段
         */
        $actionFieldsRouteRows = [
            'group' => [
                'name' => '动作字段',
                'code' => 'action_fields',
                'lang' => 'Action_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 动作字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 436,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($actionFieldsRouteRows);

        /**
         * 日历单条查找
         */
        $calendarFindRouteRows = [
            'group' => [
                'name' => '日历单条查找',
                'code' => 'calendar_find',
                'lang' => 'Calendar_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 437,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarFindRouteRows);

        /**
         * 日历多条查找
         */
        $calendarSelectRouteRows = [
            'group' => [
                'name' => '日历多条查找',
                'code' => 'calendar_select',
                'lang' => 'Calendar_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 438,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarSelectRouteRows);

        /**
         * 日历修改
         */
        $calendarUpdateRouteRows = [
            'group' => [
                'name' => '日历修改',
                'code' => 'calendar_update',
                'lang' => 'Calendar_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 439,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarUpdateRouteRows);

        /**
         * 日历创建
         */
        $calendarCreateRouteRows = [
            'group' => [
                'name' => '日历创建',
                'code' => 'calendar_create',
                'lang' => 'Calendar_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 440,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarCreateRouteRows);

        /**
         * 日历删除
         */
        $calendarUpdateRouteRows = [
            'group' => [
                'name' => '日历删除',
                'code' => 'calendar_delete',
                'lang' => 'Calendar_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 441,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarUpdateRouteRows);

        /**
         * 日历字段
         */
        $calendarFieldsRouteRows = [
            'group' => [
                'name' => '日历字段',
                'code' => 'calendar_fields',
                'lang' => 'Calendar_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 日历字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 442,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($calendarFieldsRouteRows);

        /**
         * 部门单条查找
         */
        $departmentFindRouteRows = [
            'group' => [
                'name' => '部门单条查找',
                'code' => 'department_find',
                'lang' => 'Department_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 443,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentFindRouteRows);

        /**
         * 部门多条查找
         */
        $departmentSelectRouteRows = [
            'group' => [
                'name' => '部门多条查找',
                'code' => 'department_select',
                'lang' => 'Department_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 444,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentSelectRouteRows);

        /**
         * 部门修改
         */
        $departmentUpdateRouteRows = [
            'group' => [
                'name' => '部门修改',
                'code' => 'department_update',
                'lang' => 'Department_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 445,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentUpdateRouteRows);

        /**
         * 部门创建
         */
        $departmentCreateRouteRows = [
            'group' => [
                'name' => '部门创建',
                'code' => 'department_create',
                'lang' => 'Department_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 446,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentCreateRouteRows);

        /**
         * 部门删除
         */
        $departmentUpdateRouteRows = [
            'group' => [
                'name' => '部门删除',
                'code' => 'department_delete',
                'lang' => 'Department_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 447,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentUpdateRouteRows);

        /**
         * 部门字段
         */
        $departmentFieldsRouteRows = [
            'group' => [
                'name' => '部门字段',
                'code' => 'department_fields',
                'lang' => 'Department_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 部门字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 448,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($departmentFieldsRouteRows);

        /**
         * 目录模板单条查找
         */
        $dirTemplateFindRouteRows = [
            'group' => [
                'name' => '目录模板单条查找',
                'code' => 'dir_template_find',
                'lang' => 'Dir_template_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 449,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateFindRouteRows);

        /**
         * 目录模板多条查找
         */
        $dirTemplateSelectRouteRows = [
            'group' => [
                'name' => '目录模板多条查找',
                'code' => 'dir_template_select',
                'lang' => 'Dir_template_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 450,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateSelectRouteRows);

        /**
         * 目录模板修改
         */
        $dirTemplateUpdateRouteRows = [
            'group' => [
                'name' => '目录模板修改',
                'code' => 'dir_template_update',
                'lang' => 'Dir_template_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 451,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateUpdateRouteRows);

        /**
         * 目录模板创建
         */
        $dirTemplateCreateRouteRows = [
            'group' => [
                'name' => '目录模板创建',
                'code' => 'dir_template_create',
                'lang' => 'Dir_template_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 452,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateCreateRouteRows);

        /**
         * 目录模板删除
         */
        $dirTemplateUpdateRouteRows = [
            'group' => [
                'name' => '目录模板删除',
                'code' => 'dir_template_delete',
                'lang' => 'Dir_template_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 453,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateUpdateRouteRows);

        /**
         * 目录模板字段
         */
        $dirTemplateFieldsRouteRows = [
            'group' => [
                'name' => '目录模板字段',
                'code' => 'dir_template_fields',
                'lang' => 'Dir_template_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录模板字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 454,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirTemplateFieldsRouteRows);

        /**
         * 目录变量单条查找
         */
        $dirVariableFindRouteRows = [
            'group' => [
                'name' => '目录变量单条查找',
                'code' => 'dir_variable_find',
                'lang' => 'Dir_variable_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 455,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableFindRouteRows);

        /**
         * 目录变量多条查找
         */
        $dirVariableSelectRouteRows = [
            'group' => [
                'name' => '目录变量多条查找',
                'code' => 'dir_variable_select',
                'lang' => 'Dir_variable_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 456,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableSelectRouteRows);

        /**
         * 目录变量修改
         */
        $dirVariableUpdateRouteRows = [
            'group' => [
                'name' => '目录变量修改',
                'code' => 'dir_variable_update',
                'lang' => 'Dir_variable_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 457,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableUpdateRouteRows);

        /**
         * 目录变量创建
         */
        $dirVariableCreateRouteRows = [
            'group' => [
                'name' => '目录变量创建',
                'code' => 'dir_variable_create',
                'lang' => 'Dir_variable_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 458,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableCreateRouteRows);

        /**
         * 目录变量删除
         */
        $dirVariableUpdateRouteRows = [
            'group' => [
                'name' => '目录变量删除',
                'code' => 'dir_variable_delete',
                'lang' => 'Dir_variable_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 459,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableUpdateRouteRows);

        /**
         * 目录变量字段
         */
        $dirVariableFieldsRouteRows = [
            'group' => [
                'name' => '目录变量字段',
                'code' => 'dir_variable_fields',
                'lang' => 'Dir_variable_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 目录变量字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 460,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($dirVariableFieldsRouteRows);

        /**
         * 磁盘单条查找
         */
        $diskFindRouteRows = [
            'group' => [
                'name' => '磁盘单条查找',
                'code' => 'disk_find',
                'lang' => 'Disk_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 461,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskFindRouteRows);

        /**
         * 磁盘多条查找
         */
        $diskSelectRouteRows = [
            'group' => [
                'name' => '磁盘多条查找',
                'code' => 'disk_select',
                'lang' => 'Disk_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 462,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskSelectRouteRows);

        /**
         * 磁盘修改
         */
        $diskUpdateRouteRows = [
            'group' => [
                'name' => '磁盘修改',
                'code' => 'disk_update',
                'lang' => 'Disk_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 463,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskUpdateRouteRows);

        /**
         * 磁盘创建
         */
        $diskCreateRouteRows = [
            'group' => [
                'name' => '磁盘创建',
                'code' => 'disk_create',
                'lang' => 'Disk_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 464,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskCreateRouteRows);

        /**
         * 磁盘删除
         */
        $diskUpdateRouteRows = [
            'group' => [
                'name' => '磁盘删除',
                'code' => 'disk_delete',
                'lang' => 'Disk_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 465,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskUpdateRouteRows);

        /**
         * 磁盘字段
         */
        $diskFieldsRouteRows = [
            'group' => [
                'name' => '磁盘字段',
                'code' => 'disk_fields',
                'lang' => 'Disk_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 磁盘字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 466,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($diskFieldsRouteRows);

        /**
         * 实体单条查找
         */
        $entityFindRouteRows = [
            'group' => [
                'name' => '实体单条查找',
                'code' => 'entity_find',
                'lang' => 'Entity_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 467,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entityFindRouteRows);

        /**
         * 实体多条查找
         */
        $entitySelectRouteRows = [
            'group' => [
                'name' => '实体多条查找',
                'code' => 'entity_select',
                'lang' => 'Entity_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 468,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entitySelectRouteRows);

        /**
         * 实体修改
         */
        $entityUpdateRouteRows = [
            'group' => [
                'name' => '实体修改',
                'code' => 'entity_update',
                'lang' => 'Entity_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 469,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entityUpdateRouteRows);

        /**
         * 实体创建
         */
        $entityCreateRouteRows = [
            'group' => [
                'name' => '实体创建',
                'code' => 'entity_create',
                'lang' => 'Entity_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 470,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entityCreateRouteRows);

        /**
         * 实体删除
         */
        $entityUpdateRouteRows = [
            'group' => [
                'name' => '实体删除',
                'code' => 'entity_delete',
                'lang' => 'Entity_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 471,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entityUpdateRouteRows);

        /**
         * 实体字段
         */
        $entityFieldsRouteRows = [
            'group' => [
                'name' => '实体字段',
                'code' => 'entity_fields',
                'lang' => 'Entity_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 实体字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 472,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($entityFieldsRouteRows);

        /**
         * 文件单条查找
         */
        $fileFindRouteRows = [
            'group' => [
                'name' => '文件单条查找',
                'code' => 'file_find',
                'lang' => 'File_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 473,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileFindRouteRows);

        /**
         * 文件多条查找
         */
        $fileSelectRouteRows = [
            'group' => [
                'name' => '文件多条查找',
                'code' => 'file_select',
                'lang' => 'File_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 474,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileSelectRouteRows);

        /**
         * 文件修改
         */
        $fileUpdateRouteRows = [
            'group' => [
                'name' => '文件修改',
                'code' => 'file_update',
                'lang' => 'File_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 475,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileUpdateRouteRows);

        /**
         * 文件创建
         */
        $fileCreateRouteRows = [
            'group' => [
                'name' => '文件创建',
                'code' => 'file_create',
                'lang' => 'File_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 476,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCreateRouteRows);

        /**
         * 文件删除
         */
        $fileUpdateRouteRows = [
            'group' => [
                'name' => '文件删除',
                'code' => 'file_delete',
                'lang' => 'File_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 477,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileUpdateRouteRows);

        /**
         * 文件字段
         */
        $fileFieldsRouteRows = [
            'group' => [
                'name' => '文件字段',
                'code' => 'file_fields',
                'lang' => 'File_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 478,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileFieldsRouteRows);

        /**
         * 关注单条查找
         */
        $followFindRouteRows = [
            'group' => [
                'name' => '关注单条查找',
                'code' => 'follow_find',
                'lang' => 'Follow_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 479,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followFindRouteRows);

        /**
         * 关注多条查找
         */
        $followSelectRouteRows = [
            'group' => [
                'name' => '关注多条查找',
                'code' => 'follow_select',
                'lang' => 'Follow_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 480,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followSelectRouteRows);

        /**
         * 关注修改
         */
        $followUpdateRouteRows = [
            'group' => [
                'name' => '关注修改',
                'code' => 'follow_update',
                'lang' => 'Follow_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 481,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followUpdateRouteRows);

        /**
         * 关注创建
         */
        $followCreateRouteRows = [
            'group' => [
                'name' => '关注创建',
                'code' => 'follow_create',
                'lang' => 'Follow_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 482,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followCreateRouteRows);

        /**
         * 关注删除
         */
        $followUpdateRouteRows = [
            'group' => [
                'name' => '关注删除',
                'code' => 'follow_delete',
                'lang' => 'Follow_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 483,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followUpdateRouteRows);

        /**
         * 关注字段
         */
        $followFieldsRouteRows = [
            'group' => [
                'name' => '关注字段',
                'code' => 'follow_fields',
                'lang' => 'Follow_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 关注字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 484,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($followFieldsRouteRows);

        /**
         * 水平关联配置单条查找
         */
        $horizontalConfigFindRouteRows = [
            'group' => [
                'name' => '水平关联配置单条查找',
                'code' => 'horizontal_config_find',
                'lang' => 'Horizontal_Config_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 485,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigFindRouteRows);

        /**
         * 水平关联配置多条查找
         */
        $horizontalConfigSelectRouteRows = [
            'group' => [
                'name' => '水平关联配置多条查找',
                'code' => 'horizontal_config_select',
                'lang' => 'Horizontal_Config_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 486,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigSelectRouteRows);

        /**
         * 水平关联配置修改
         */
        $horizontalConfigUpdateRouteRows = [
            'group' => [
                'name' => '水平关联配置修改',
                'code' => 'horizontal_config_update',
                'lang' => 'Horizontal_Config_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 487,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigUpdateRouteRows);

        /**
         * 水平关联配置创建
         */
        $horizontalConfigCreateRouteRows = [
            'group' => [
                'name' => '水平关联配置创建',
                'code' => 'horizontal_config_create',
                'lang' => 'Horizontal_Config_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 488,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigCreateRouteRows);

        /**
         * 水平关联配置删除
         */
        $horizontalConfigUpdateRouteRows = [
            'group' => [
                'name' => '水平关联配置删除',
                'code' => 'horizontal_config_delete',
                'lang' => 'Horizontal_Config_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 489,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigUpdateRouteRows);

        /**
         * 水平关联配置字段
         */
        $horizontalConfigFieldsRouteRows = [
            'group' => [
                'name' => '水平关联配置字段',
                'code' => 'horizontal_config_fields',
                'lang' => 'Horizontal_Config_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联配置字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 490,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalConfigFieldsRouteRows);

        /**
         * 水平关联单条查找
         */
        $horizontalFindRouteRows = [
            'group' => [
                'name' => '水平关联单条查找',
                'code' => 'horizontal_find',
                'lang' => 'Horizontal_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 491,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalFindRouteRows);

        /**
         * 水平关联多条查找
         */
        $horizontalSelectRouteRows = [
            'group' => [
                'name' => '水平关联多条查找',
                'code' => 'horizontal_select',
                'lang' => 'Horizontal_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 492,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalSelectRouteRows);

        /**
         * 水平关联置修改
         */
        $horizontalUpdateRouteRows = [
            'group' => [
                'name' => '水平关联修改',
                'code' => 'horizontal_update',
                'lang' => 'Horizontal_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 493,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalUpdateRouteRows);

        /**
         * 水平关联配置创建
         */
        $horizontalCreateRouteRows = [
            'group' => [
                'name' => '水平关联创建',
                'code' => 'horizontal_create',
                'lang' => 'Horizontal_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 494,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalCreateRouteRows);

        /**
         * 水平关联删除
         */
        $horizontalUpdateRouteRows = [
            'group' => [
                'name' => '水平关联删除',
                'code' => 'horizontal_delete',
                'lang' => 'Horizontal_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 495,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalUpdateRouteRows);

        /**
         * 水平关联字段
         */
        $horizontalFieldsRouteRows = [
            'group' => [
                'name' => '水平关联字段',
                'code' => 'horizontal_fields',
                'lang' => 'Horizontal_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 496,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($horizontalFieldsRouteRows);

        /**
         * 水平关联创建
         */
        $createHorizontalRouteRows = [
            'group' => [
                'name' => '水平关联创建',
                'code' => 'create_horizontal',
                'lang' => 'Create_Horizontal',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 水平关联创建
                    'auth_group_id' => 0,
                    'auth_node_id' => 643,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createHorizontalRouteRows);

        /**
         * 媒体单条查找
         */
        $mediaFindRouteRows = [
            'group' => [
                'name' => '媒体单条查找',
                'code' => 'media_find',
                'lang' => 'Media_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 497,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaFindRouteRows);

        /**
         * 媒体多条查找
         */
        $mediaSelectRouteRows = [
            'group' => [
                'name' => '媒体多条查找',
                'code' => 'media_select',
                'lang' => 'Media_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 498,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaSelectRouteRows);

        /**
         * 媒体修改
         */
        $mediaUpdateRouteRows = [
            'group' => [
                'name' => '媒体修改',
                'code' => 'media_update',
                'lang' => 'Media_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 499,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaUpdateRouteRows);

        /**
         * 媒体创建
         */
        $mediaCreateRouteRows = [
            'group' => [
                'name' => '媒体创建',
                'code' => 'media_create',
                'lang' => 'Media_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 500,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaCreateRouteRows);

        /**
         * 媒体删除
         */
        $mediaUpdateRouteRows = [
            'group' => [
                'name' => '媒体删除',
                'code' => 'media_delete',
                'lang' => 'Media_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 501,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaUpdateRouteRows);

        /**
         * 媒体关联字段
         */
        $mediaFieldsRouteRows = [
            'group' => [
                'name' => '媒体字段',
                'code' => 'media_fields',
                'lang' => 'Media_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 媒体字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 502,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($mediaFieldsRouteRows);

        /**
         * 指定的媒体服务器
         */
        $getMediaServerItemRouteRows = [
            'group' => [
                'name' => '指定的媒体服务器',
                'code' => 'get_media_server_item',
                'lang' => 'Get_Media_Server_Item',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 指定的媒体服务器
                    'auth_group_id' => 0,
                    'auth_node_id' => 635,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getMediaServerItemRouteRows);

        /**
         * 获取媒体指定上传服务器配置信息
         */
        $getMediaServerItemRouteRows = [
            'group' => [
                'name' => '获取媒体指定上传服务器配置信息',
                'code' => 'get_media_upload_server',
                'lang' => 'Get_Media_Upload_Server',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取媒体指定上传服务器配置信息
                    'auth_group_id' => 0,
                    'auth_node_id' => 636,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getMediaServerItemRouteRows);

        /**
         * 获取所有媒体服务器状态
         */
        $getMediaServerStatusRouteRows = [
            'group' => [
                'name' => '获取所有媒体服务器状态',
                'code' => 'get_media_server_status',
                'lang' => 'Get_Media_Server_Status',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取所有媒体服务器状态
                    'auth_group_id' => 0,
                    'auth_node_id' => 637,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getMediaServerStatusRouteRows);

        /**
         * 创建媒体
         */
        $createMediaRouteRows = [
            'group' => [
                'name' => '创建媒体',
                'code' => 'create_media',
                'lang' => 'Create_Media',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建媒体
                    'auth_group_id' => 0,
                    'auth_node_id' => 638,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createMediaRouteRows);


        /**
         * 更新媒体
         */
        $updateMediaRouteRows = [
            'group' => [
                'name' => '更新媒体',
                'code' => 'update_media',
                'lang' => 'Update_Media',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 更新媒体
                    'auth_group_id' => 0,
                    'auth_node_id' => 639,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateMediaRouteRows);

        /**
         * 查找媒体
         */
        $getMediaRouteRows = [
            'group' => [
                'name' => '查找媒体',
                'code' => 'get_media',
                'lang' => 'Get_Media',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 查找媒体
                    'auth_group_id' => 0,
                    'auth_node_id' => 640,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getMediaRouteRows);

        /**
         * 获取指定尺寸的缩率图路径
         */
        $getSpecifySizeThumbPathRouteRows = [
            'group' => [
                'name' => '获取指定尺寸的缩率图路径',
                'code' => 'get_specify_size_thumb_path',
                'lang' => 'Get_Specify_Size_Thumb_Path',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取指定尺寸的缩率图路径
                    'auth_group_id' => 0,
                    'auth_node_id' => 641,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getSpecifySizeThumbPathRouteRows);

        /**
         * 多媒体信息获取
         */
        $selectMediaDataRouteRows = [
            'group' => [
                'name' => '多媒体信息获取',
                'code' => 'select_media_data',
                'lang' => 'Select_Media_Data',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 多媒体信息获取
                    'auth_group_id' => 0,
                    'auth_node_id' => 642,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($selectMediaDataRouteRows);

        /**
         * 成员单条查找
         */
        $memberFindRouteRows = [
            'group' => [
                'name' => '成员单条查找',
                'code' => 'member_find',
                'lang' => 'Member_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 503,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberFindRouteRows);

        /**
         * 成员多条查找
         */
        $memberSelectRouteRows = [
            'group' => [
                'name' => '成员多条查找',
                'code' => 'member_select',
                'lang' => 'Member_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 504,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberSelectRouteRows);

        /**
         * 成员修改
         */
        $memberUpdateRouteRows = [
            'group' => [
                'name' => '成员修改',
                'code' => 'member_update',
                'lang' => 'Member_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 505,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberUpdateRouteRows);

        /**
         * 成员创建
         */
        $memberCreateRouteRows = [
            'group' => [
                'name' => '成员创建',
                'code' => 'member_create',
                'lang' => 'Member_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 506,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberCreateRouteRows);

        /**
         * 成员删除
         */
        $memberUpdateRouteRows = [
            'group' => [
                'name' => '成员删除',
                'code' => 'member_delete',
                'lang' => 'Member_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 507,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberUpdateRouteRows);

        /**
         * 成员字段
         */
        $memberFieldsRouteRows = [
            'group' => [
                'name' => '成员字段',
                'code' => 'member_fields',
                'lang' => 'Member_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 成员字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 508,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberFieldsRouteRows);

        /**
         * 反馈单条查找
         */
        $noteFindRouteRows = [
            'group' => [
                'name' => '反馈单条查找',
                'code' => 'note_find',
                'lang' => 'Note_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 509,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteFindRouteRows);

        /**
         * 反馈多条查找
         */
        $noteSelectRouteRows = [
            'group' => [
                'name' => '反馈多条查找',
                'code' => 'note_select',
                'lang' => 'Note_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 510,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteSelectRouteRows);

        /**
         * 反馈修改
         */
        $noteUpdateRouteRows = [
            'group' => [
                'name' => '反馈修改',
                'code' => 'note_update',
                'lang' => 'Note_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 511,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteUpdateRouteRows);

        /**
         * 反馈创建
         */
        $noteCreateRouteRows = [
            'group' => [
                'name' => '反馈创建',
                'code' => 'note_create',
                'lang' => 'Note_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 512,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteCreateRouteRows);

        /**
         * 反馈删除
         */
        $noteUpdateRouteRows = [
            'group' => [
                'name' => '反馈删除',
                'code' => 'note_delete',
                'lang' => 'Note_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 513,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteUpdateRouteRows);

        /**
         * 反馈字段
         */
        $noteFieldsRouteRows = [
            'group' => [
                'name' => '反馈字段',
                'code' => 'note_fields',
                'lang' => 'Note_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 反馈字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 514,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($noteFieldsRouteRows);

        /**
         * 现场数据单条查找
         */
        $onsetFindRouteRows = [
            'group' => [
                'name' => '现场数据单条查找',
                'code' => 'onset_find',
                'lang' => 'Onset_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 515,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetFindRouteRows);

        /**
         * 现场数据多条查找
         */
        $onsetSelectRouteRows = [
            'group' => [
                'name' => '现场数据多条查找',
                'code' => 'onset_select',
                'lang' => 'Onset_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 516,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetSelectRouteRows);

        /**
         * 现场数据修改
         */
        $onsetUpdateRouteRows = [
            'group' => [
                'name' => '现场数据修改',
                'code' => 'onset_update',
                'lang' => 'Onset_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 517,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetUpdateRouteRows);

        /**
         * 现场数据创建
         */
        $onsetCreateRouteRows = [
            'group' => [
                'name' => '现场数据创建',
                'code' => 'onset_create',
                'lang' => 'Onset_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 518,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetCreateRouteRows);

        /**
         * 现场数据删除
         */
        $onsetUpdateRouteRows = [
            'group' => [
                'name' => '现场数据删除',
                'code' => 'onset_delete',
                'lang' => 'Onset_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 519,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetUpdateRouteRows);

        /**
         * 现场数据字段
         */
        $onsetFieldsRouteRows = [
            'group' => [
                'name' => '现场数据字段',
                'code' => 'onset_fields',
                'lang' => 'Onset_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 520,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetFieldsRouteRows);

        /**
         * 项目磁盘单条查找
         */
        $projectDiskFindRouteRows = [
            'group' => [
                'name' => '项目磁盘单条查找',
                'code' => 'project_disk_find',
                'lang' => 'Project_Disk_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 521,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskFindRouteRows);

        /**
         * 项目磁盘多条查找
         */
        $projectDiskSelectRouteRows = [
            'group' => [
                'name' => '项目磁盘多条查找',
                'code' => 'project_disk_select',
                'lang' => 'Project_Disk_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 522,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskSelectRouteRows);

        /**
         * 项目磁盘修改
         */
        $projectDiskUpdateRouteRows = [
            'group' => [
                'name' => '项目磁盘修改',
                'code' => 'project_disk_update',
                'lang' => 'Project_Disk_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 523,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskUpdateRouteRows);

        /**
         * 项目磁盘创建
         */
        $projectDiskCreateRouteRows = [
            'group' => [
                'name' => '项目磁盘创建',
                'code' => 'project_disk_create',
                'lang' => 'Project_Disk_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 524,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskCreateRouteRows);

        /**
         * 项目磁盘删除
         */
        $projectDiskDeleteRouteRows = [
            'group' => [
                'name' => '项目磁盘删除',
                'code' => 'project_disk_delete',
                'lang' => 'Project_Disk_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 525,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskDeleteRouteRows);

        /**
         * 项目磁盘字段
         */
        $projectDiskFieldsRouteRows = [
            'group' => [
                'name' => '项目磁盘字段',
                'code' => 'project_disk_fields',
                'lang' => 'Project_Disk_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目磁盘字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 526,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectDiskFieldsRouteRows);

        /**
         * 项目成员单条查找
         */
        $projectMemberFindRouteRows = [
            'group' => [
                'name' => '项目成员单条查找',
                'code' => 'project_member_find',
                'lang' => 'Project_Member_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 527,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberFindRouteRows);

        /**
         * 项目成员多条查找
         */
        $projectMemberSelectRouteRows = [
            'group' => [
                'name' => '项目成员多条查找',
                'code' => 'project_member_select',
                'lang' => 'Project_Member_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 528,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberSelectRouteRows);

        /**
         * 项目成员修改
         */
        $projectMemberUpdateRouteRows = [
            'group' => [
                'name' => '项目成员修改',
                'code' => 'project_member_update',
                'lang' => 'Project_Member_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 529,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberUpdateRouteRows);

        /**
         * 项目成员创建
         */
        $projectMemberCreateRouteRows = [
            'group' => [
                'name' => '项目成员创建',
                'code' => 'project_member_create',
                'lang' => 'Project_Member_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 530,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberCreateRouteRows);

        /**
         * 项目成员删除
         */
        $projectMemberUpdateRouteRows = [
            'group' => [
                'name' => '项目成员删除',
                'code' => 'project_member_delete',
                'lang' => 'Project_Member_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 531,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberUpdateRouteRows);

        /**
         * 项目成员字段
         */
        $projectMemberFieldsRouteRows = [
            'group' => [
                'name' => '项目成员字段',
                'code' => 'project_member_fields',
                'lang' => 'Project_Member_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目成员字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 532,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectMemberFieldsRouteRows);

        /**
         * 项目单条查找
         */
        $projectFindRouteRows = [
            'group' => [
                'name' => '项目单条查找',
                'code' => 'project_find',
                'lang' => 'Project_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 533,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectFindRouteRows);

        /**
         * 项目多条查找
         */
        $projectSelectRouteRows = [
            'group' => [
                'name' => '项目多条查找',
                'code' => 'project_select',
                'lang' => 'Project_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 534,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectSelectRouteRows);

        /**
         * 项目修改
         */
        $projectUpdateRouteRows = [
            'group' => [
                'name' => '项目修改',
                'code' => 'project_update',
                'lang' => 'Project_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 535,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectUpdateRouteRows);

        /**
         * 项目创建
         */
        $projectCreateRouteRows = [
            'group' => [
                'name' => '项目创建',
                'code' => 'project_create',
                'lang' => 'Project_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 536,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectCreateRouteRows);

        /**
         * 项目删除
         */
        $projectUpdateRouteRows = [
            'group' => [
                'name' => '项目删除',
                'code' => 'project_delete',
                'lang' => 'Project_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 537,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectUpdateRouteRows);

        /**
         * 项目字段
         */
        $projectFieldsRouteRows = [
            'group' => [
                'name' => '项目字段',
                'code' => 'project_fields',
                'lang' => 'Project_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 538,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projectFieldsRouteRows);

        /**
         * 状态单条查找
         */
        $statusFindRouteRows = [
            'group' => [
                'name' => '状态单条查找',
                'code' => 'status_find',
                'lang' => 'Status_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 545,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusFindRouteRows);

        /**
         * 状态多条查找
         */
        $statusSelectRouteRows = [
            'group' => [
                'name' => '状态多条查找',
                'code' => 'status_select',
                'lang' => 'Status_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 546,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusSelectRouteRows);

        /**
         * 状态修改
         */
        $statusUpdateRouteRows = [
            'group' => [
                'name' => '状态修改',
                'code' => 'status_update',
                'lang' => 'Status_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 547,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusUpdateRouteRows);

        /**
         * 状态创建
         */
        $statusCreateRouteRows = [
            'group' => [
                'name' => '状态创建',
                'code' => 'status_create',
                'lang' => 'Status_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 548,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusCreateRouteRows);

        /**
         * 状态删除
         */
        $statusUpdateRouteRows = [
            'group' => [
                'name' => '状态删除',
                'code' => 'status_delete',
                'lang' => 'Status_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 549,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusUpdateRouteRows);

        /**
         * 状态字段
         */
        $statusFieldsRouteRows = [
            'group' => [
                'name' => '状态字段',
                'code' => 'status_fields',
                'lang' => 'Status_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 状态字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 560,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($statusFieldsRouteRows);

        /**
         * 工序单条查找
         */
        $stepFindRouteRows = [
            'group' => [
                'name' => '工序单条查找',
                'code' => 'step_find',
                'lang' => 'Step_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 551,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepFindRouteRows);

        /**
         * 工序多条查找
         */
        $stepSelectRouteRows = [
            'group' => [
                'name' => '工序多条查找',
                'code' => 'step_select',
                'lang' => 'Step_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 552,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepSelectRouteRows);

        /**
         * 工序修改
         */
        $stepUpdateRouteRows = [
            'group' => [
                'name' => '工序修改',
                'code' => 'step_update',
                'lang' => 'Step_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 553,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepUpdateRouteRows);

        /**
         * 工序创建
         */
        $stepCreateRouteRows = [
            'group' => [
                'name' => '工序创建',
                'code' => 'step_create',
                'lang' => 'Step_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 554,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepCreateRouteRows);

        /**
         * 工序删除
         */
        $stepUpdateRouteRows = [
            'group' => [
                'name' => '工序删除',
                'code' => 'step_delete',
                'lang' => 'Step_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 555,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepUpdateRouteRows);

        /**
         * 工序字段
         */
        $stepFieldsRouteRows = [
            'group' => [
                'name' => '工序字段',
                'code' => 'step_fields',
                'lang' => 'Step_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 工序字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 556,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stepFieldsRouteRows);

        /**
         * 标签关联单条查找
         */
        $tagLinkFindRouteRows = [
            'group' => [
                'name' => '标签关联单条查找',
                'code' => 'tag_link_find',
                'lang' => 'Tag_Link_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 557,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkFindRouteRows);

        /**
         * 标签关联多条查找
         */
        $tagLinkSelectRouteRows = [
            'group' => [
                'name' => '标签关联多条查找',
                'code' => 'tag_link_select',
                'lang' => 'Tag_Link_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 558,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkSelectRouteRows);

        /**
         * 标签关联修改
         */
        $tagLinkUpdateRouteRows = [
            'group' => [
                'name' => '标签关联修改',
                'code' => 'tag_link_update',
                'lang' => 'Tag_Link_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 559,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkUpdateRouteRows);

        /**
         * 标签关联创建
         */
        $tagLinkCreateRouteRows = [
            'group' => [
                'name' => '标签关联创建',
                'code' => 'tag_link_create',
                'lang' => 'Tag_Link_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 560,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkCreateRouteRows);

        /**
         * 标签关联删除
         */
        $tagLinkUpdateRouteRows = [
            'group' => [
                'name' => '标签关联删除',
                'code' => 'tag_link_delete',
                'lang' => 'Tag_Link_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 561,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkUpdateRouteRows);

        /**
         * 标签关联字段
         */
        $tagLinkFieldsRouteRows = [
            'group' => [
                'name' => '标签关联字段',
                'code' => 'tag_link_fields',
                'lang' => 'Tag_Link_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签关联字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 562,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagLinkFieldsRouteRows);

        /**
         * 标签单条查找
         */
        $tagFindRouteRows = [
            'group' => [
                'name' => '标签单条查找',
                'code' => 'tag_find',
                'lang' => 'Tag_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 563,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagFindRouteRows);

        /**
         * 标签多条查找
         */
        $tagSelectRouteRows = [
            'group' => [
                'name' => '标签多条查找',
                'code' => 'tag_select',
                'lang' => 'Tag_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 564,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagSelectRouteRows);

        /**
         * 标签修改
         */
        $tagUpdateRouteRows = [
            'group' => [
                'name' => '标签修改',
                'code' => 'tag_update',
                'lang' => 'Tag_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 565,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagUpdateRouteRows);

        /**
         * 标签创建
         */
        $tagCreateRouteRows = [
            'group' => [
                'name' => '标签创建',
                'code' => 'tag_create',
                'lang' => 'Tag_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 566,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagCreateRouteRows);

        /**
         * 标签删除
         */
        $tagUpdateRouteRows = [
            'group' => [
                'name' => '标签删除',
                'code' => 'tag_delete',
                'lang' => 'Tag_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 567,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagUpdateRouteRows);

        /**
         * 标签字段
         */
        $tagFieldsRouteRows = [
            'group' => [
                'name' => '标签字段',
                'code' => 'tag_fields',
                'lang' => 'Tag_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 标签字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 568,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($tagFieldsRouteRows);

        /**
         * 时间日志注意事项单条查找
         */
        $timelogIssueFindRouteRows = [
            'group' => [
                'name' => '时间日志注意事项单条查找',
                'code' => 'timelog_issue_find',
                'lang' => 'Timelog_Issue_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 569,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueFindRouteRows);

        /**
         * 时间日志注意事项多条查找
         */
        $timelogIssueSelectRouteRows = [
            'group' => [
                'name' => '时间日志注意事项多条查找',
                'code' => 'timelog_issue_select',
                'lang' => 'Timelog_Issue_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 570,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueSelectRouteRows);

        /**
         * 时间日志注意事项修改
         */
        $timelogIssueUpdateRouteRows = [
            'group' => [
                'name' => '时间日志注意事项修改',
                'code' => 'timelog_issue_update',
                'lang' => 'Timelog_Issue_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 571,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueUpdateRouteRows);

        /**
         * 时间日志注意事项创建
         */
        $timelogIssueCreateRouteRows = [
            'group' => [
                'name' => '时间日志注意事项创建',
                'code' => 'timelog_issue_create',
                'lang' => 'Timelog_Issue_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 572,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueCreateRouteRows);

        /**
         * 时间日志注意事项删除
         */
        $timelogIssueUpdateRouteRows = [
            'group' => [
                'name' => '时间日志注意事项删除',
                'code' => 'timelog_issue_delete',
                'lang' => 'Timelog_Issue_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 573,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueUpdateRouteRows);

        /**
         * 时间日志注意事项字段
         */
        $timelogIssueFieldsRouteRows = [
            'group' => [
                'name' => '时间日志注意事项字段',
                'code' => 'timelog_issue_fields',
                'lang' => 'Timelog_Issue_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志注意事项字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 574,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogIssueFieldsRouteRows);

        /**
         * 时间日志单条查找
         */
        $timelogFindRouteRows = [
            'group' => [
                'name' => '时间日志单条查找',
                'code' => 'timelog_find',
                'lang' => 'Timelog_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 575,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogFindRouteRows);

        /**
         * 时间日志多条查找
         */
        $timelogSelectRouteRows = [
            'group' => [
                'name' => '时间日志多条查找',
                'code' => 'timelog_select',
                'lang' => 'Timelog_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 576,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogSelectRouteRows);

        /**
         * 时间日志修改
         */
        $timelogUpdateRouteRows = [
            'group' => [
                'name' => '时间日志修改',
                'code' => 'timelog_update',
                'lang' => 'Timelog_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 577,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogUpdateRouteRows);

        /**
         * 时间日志创建
         */
        $timelogCreateRouteRows = [
            'group' => [
                'name' => '时间日志创建',
                'code' => 'timelog_create',
                'lang' => 'Timelog_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 578,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogCreateRouteRows);

        /**
         * 时间日志删除
         */
        $timelogUpdateRouteRows = [
            'group' => [
                'name' => '时间日志删除',
                'code' => 'timelog_delete',
                'lang' => 'Timelog_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 579,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogUpdateRouteRows);

        /**
         * 时间日志字段
         */
        $timelogFieldsRouteRows = [
            'group' => [
                'name' => '时间日志字段',
                'code' => 'timelog_fields',
                'lang' => 'Timelog_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 时间日志字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 580,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($timelogFieldsRouteRows);

        /**
         * 开启计时器
         */
        $startTimerRouteRows = [
            'group' => [
                'name' => '开启计时器',
                'code' => 'start_timer',
                'lang' => 'Start_Timer',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 开启计时器
                    'auth_group_id' => 0,
                    'auth_node_id' => 647,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($startTimerRouteRows);

        /**
         * 开启计时器
         */
        $stopTimerRouteRows = [
            'group' => [
                'name' => '停止计时器',
                'code' => 'stop_timer',
                'lang' => 'Stop_Timer',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 开启计时器
                    'auth_group_id' => 0,
                    'auth_node_id' => 648,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($stopTimerRouteRows);

        /**
         * 用户配置单条查找
         */
        $userConfigFindRouteRows = [
            'group' => [
                'name' => '用户配置单条查找',
                'code' => 'user_config_find',
                'lang' => 'User_Config_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 581,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigFindRouteRows);

        /**
         * 用户配置多条查找
         */
        $userConfigSelectRouteRows = [
            'group' => [
                'name' => '用户配置多条查找',
                'code' => 'user_config_select',
                'lang' => 'User_Config_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 582,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigSelectRouteRows);

        /**
         * 用户配置修改
         */
        $userConfigUpdateRouteRows = [
            'group' => [
                'name' => '用户配置修改',
                'code' => 'user_config_update',
                'lang' => 'User_Config_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 583,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigUpdateRouteRows);

        /**
         * 用户配置创建
         */
        $userConfigCreateRouteRows = [
            'group' => [
                'name' => '用户配置创建',
                'code' => 'user_config_create',
                'lang' => 'User_Config_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 584,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigCreateRouteRows);

        /**
         * 用户配置删除
         */
        $userConfigUpdateRouteRows = [
            'group' => [
                'name' => '用户配置删除',
                'code' => 'user_config_delete',
                'lang' => 'User_Config_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 585,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigUpdateRouteRows);

        /**
         * 用户配置字段
         */
        $userConfigFieldsRouteRows = [
            'group' => [
                'name' => '用户配置字段',
                'code' => 'user_config_fields',
                'lang' => 'User_Config_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户配置字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 586,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userConfigFieldsRouteRows);

        /**
         * 自定义字段单条查找
         */
        $variableFindRouteRows = [
            'group' => [
                'name' => '自定义字段单条查找',
                'code' => 'variable_find',
                'lang' => 'Variable_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 587,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableFindRouteRows);

        /**
         * 自定义字段多条查找
         */
        $variableSelectRouteRows = [
            'group' => [
                'name' => '自定义字段多条查找',
                'code' => 'variable_select',
                'lang' => 'Variable_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 588,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableSelectRouteRows);

        /**
         * 自定义字段修改
         */
        $variableUpdateRouteRows = [
            'group' => [
                'name' => '自定义字段修改',
                'code' => 'variable_update',
                'lang' => 'Variable_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 589,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableUpdateRouteRows);

        /**
         * 自定义字段创建
         */
        $variableCreateRouteRows = [
            'group' => [
                'name' => '自定义字段创建',
                'code' => 'variable_create',
                'lang' => 'Variable_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 590,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableCreateRouteRows);

        /**
         * 自定义字段删除
         */
        $variableUpdateRouteRows = [
            'group' => [
                'name' => '自定义字段删除',
                'code' => 'variable_delete',
                'lang' => 'Variable_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 591,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableUpdateRouteRows);

        /**
         * 自定义字段字段
         */
        $variableFieldsRouteRows = [
            'group' => [
                'name' => '自定义字段字段',
                'code' => 'variable_fields',
                'lang' => 'Variable_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 592,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableFieldsRouteRows);

        /**
         * 自定义字段值单条查找
         */
        $variableValueFindRouteRows = [
            'group' => [
                'name' => '自定义字段值单条查找',
                'code' => 'variable_value_find',
                'lang' => 'Variable_Value_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 593,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueFindRouteRows);

        /**
         * 自定义字段值多条查找
         */
        $variableValueSelectRouteRows = [
            'group' => [
                'name' => '自定义字段值多条查找',
                'code' => 'variable_value_select',
                'lang' => 'Variable_Value_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 594,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueSelectRouteRows);

        /**
         * 自定义字段值修改
         */
        $variableValueUpdateRouteRows = [
            'group' => [
                'name' => '自定义字段值修改',
                'code' => 'variable_value_update',
                'lang' => 'Variable_Value_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 595,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueUpdateRouteRows);

        /**
         * 自定义字段值创建
         */
        $variableValueCreateRouteRows = [
            'group' => [
                'name' => '自定义字段值创建',
                'code' => 'variable_value_create',
                'lang' => 'Variable_Value_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 596,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueCreateRouteRows);

        /**
         * 自定义字段值删除
         */
        $variableValueUpdateRouteRows = [
            'group' => [
                'name' => '自定义字段值删除',
                'code' => 'variable_value_delete',
                'lang' => 'Variable_Value_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 597,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueUpdateRouteRows);

        /**
         * 自定义字段值字段
         */
        $variableValueFieldsRouteRows = [
            'group' => [
                'name' => '自定义字段值字段',
                'code' => 'variable_value_fields',
                'lang' => 'Variable_Value_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 自定义字段值字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 598,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($variableValueFieldsRouteRows);

        /**
         * 用户单条查找
         */
        $userFindRouteRows = [
            'group' => [
                'name' => '用户单条查找',
                'code' => 'user_find',
                'lang' => 'User_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 599,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userFindRouteRows);

        /**
         * 用户多条查找
         */
        $userSelectRouteRows = [
            'group' => [
                'name' => '用户多条查找',
                'code' => 'user_select',
                'lang' => 'User_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 600,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userSelectRouteRows);

        /**
         * 用户修改
         */
        $userUpdateRouteRows = [
            'group' => [
                'name' => '用户修改',
                'code' => 'user_update',
                'lang' => 'User_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 601,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userUpdateRouteRows);

        /**
         * 用户创建
         */
        $userCreateRouteRows = [
            'group' => [
                'name' => '用户创建',
                'code' => 'user_create',
                'lang' => 'User_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 602,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userCreateRouteRows);

        /**
         * 用户删除
         */
        $userUpdateRouteRows = [
            'group' => [
                'name' => '用户删除',
                'code' => 'user_delete',
                'lang' => 'User_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 603,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userUpdateRouteRows);

        /**
         * 用户字段
         */
        $userFieldsRouteRows = [
            'group' => [
                'name' => '用户字段',
                'code' => 'user_fields',
                'lang' => 'User_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 604,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($userFieldsRouteRows);

        /**
         * 提交文件单条查找
         */
        $fileCommitFindRouteRows = [
            'group' => [
                'name' => '提交文件单条查找',
                'code' => 'file_commit_find',
                'lang' => 'file_Commit_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 605,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitFindRouteRows);

        /**
         * 提交文件多条查找
         */
        $fileCommitSelectRouteRows = [
            'group' => [
                'name' => '提交文件多条查找',
                'code' => 'file_commit_select',
                'lang' => 'file_Commit_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 606,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitSelectRouteRows);

        /**
         * 提交文件修改
         */
        $fileCommitUpdateRouteRows = [
            'group' => [
                'name' => '提交文件修改',
                'code' => 'file_commit_update',
                'lang' => 'file_Commit_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 607,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitUpdateRouteRows);

        /**
         * 提交文件创建
         */
        $fileCommitCreateRouteRows = [
            'group' => [
                'name' => '提交文件创建',
                'code' => 'file_commit_create',
                'lang' => 'file_Commit_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 608,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitCreateRouteRows);

        /**
         * 提交文件删除
         */
        $fileCommitUpdateRouteRows = [
            'group' => [
                'name' => '提交文件删除',
                'code' => 'file_commit_delete',
                'lang' => 'file_Commit_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 609,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitUpdateRouteRows);

        /**
         * 提交文件字段
         */
        $fileCommitFieldsRouteRows = [
            'group' => [
                'name' => '提交文件字段',
                'code' => 'file_commit_fields',
                'lang' => 'file_Commit_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 提交文件字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 610,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileCommitFieldsRouteRows);

        /**
         * 文件类型单条查找
         */
        $fileTypeFindRouteRows = [
            'group' => [
                'name' => '文件类型单条查找',
                'code' => 'file_type_find',
                'lang' => 'File_Type_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 611,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeFindRouteRows);

        /**
         * 文件类型多条查找
         */
        $fileTypeSelectRouteRows = [
            'group' => [
                'name' => '文件类型多条查找',
                'code' => 'file_type_select',
                'lang' => 'File_Type_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 612,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeSelectRouteRows);

        /**
         * 文件类型修改
         */
        $fileTypeUpdateRouteRows = [
            'group' => [
                'name' => '文件类型修改',
                'code' => 'file_type_update',
                'lang' => 'File_Type_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 613,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeUpdateRouteRows);

        /**
         * 文件类型创建
         */
        $fileTypeCreateRouteRows = [
            'group' => [
                'name' => '文件类型创建',
                'code' => 'file_type_create',
                'lang' => 'File_Type_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 614,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeCreateRouteRows);

        /**
         * 文件类型删除
         */
        $fileTypeUpdateRouteRows = [
            'group' => [
                'name' => '文件类型删除',
                'code' => 'file_type_delete',
                'lang' => 'File_Type_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 615,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeUpdateRouteRows);

        /**
         * 文件类型字段
         */
        $fileTypeFieldsRouteRows = [
            'group' => [
                'name' => '文件类型字段',
                'code' => 'file_type_fields',
                'lang' => 'File_Type_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 文件类型字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 616,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($fileTypeFieldsRouteRows);

        /**
         * 任务单条查找
         */
        $taskFindRouteRows = [
            'group' => [
                'name' => '任务单条查找',
                'code' => 'task_find',
                'lang' => 'Task_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 617,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskFindRouteRows);

        /**
         * 任务多条查找
         */
        $taskSelectRouteRows = [
            'group' => [
                'name' => '任务多条查找',
                'code' => 'task_select',
                'lang' => 'Task_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 618,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskSelectRouteRows);

        /**
         * 任务修改
         */
        $taskUpdateRouteRows = [
            'group' => [
                'name' => '任务修改',
                'code' => 'task_update',
                'lang' => 'Task_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 619,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskUpdateRouteRows);

        /**
         * 任务创建
         */
        $taskCreateRouteRows = [
            'group' => [
                'name' => '任务创建',
                'code' => 'task_create',
                'lang' => 'Task_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 620,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskCreateRouteRows);

        /**
         * 任务删除
         */
        $taskUpdateRouteRows = [
            'group' => [
                'name' => '任务删除',
                'code' => 'task_delete',
                'lang' => 'Task_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 621,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskUpdateRouteRows);

        /**
         * 任务字段
         */
        $taskFieldsRouteRows = [
            'group' => [
                'name' => '任务字段',
                'code' => 'task_fields',
                'lang' => 'Task_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 任务字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 622,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($taskFieldsRouteRows);

        /**
         * 通用动作单条查找
         */
        $commonActionFindRouteRows = [
            'group' => [
                'name' => '通用动作单条查找',
                'code' => 'common_action_find',
                'lang' => 'Common_Action_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 623,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionFindRouteRows);

        /**
         * 通用动作多条查找
         */
        $commonActionSelectRouteRows = [
            'group' => [
                'name' => '通用动作多条查找',
                'code' => 'common_action_select',
                'lang' => 'Common_Action_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 624,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionSelectRouteRows);

        /**
         * 通用动作修改
         */
        $commonActionUpdateRouteRows = [
            'group' => [
                'name' => '通用动作修改',
                'code' => 'common_action_update',
                'lang' => 'Common_Action_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 625,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionUpdateRouteRows);

        /**
         * 通用动作创建
         */
        $commonActionCreateRouteRows = [
            'group' => [
                'name' => '通用动作创建',
                'code' => 'common_action_create',
                'lang' => 'Common_Action_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 626,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionCreateRouteRows);

        /**
         * 通用动作删除
         */
        $commonActionUpdateRouteRows = [
            'group' => [
                'name' => '通用动作删除',
                'code' => 'common_action_delete',
                'lang' => 'Common_Action_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 627,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionUpdateRouteRows);

        /**
         * 通用动作字段
         */
        $commonActionFieldsRouteRows = [
            'group' => [
                'name' => '通用动作字段',
                'code' => 'common_action_fields',
                'lang' => 'Common_Action_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 628,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($commonActionFieldsRouteRows);

        /**
         * 数据结构创建
         */
        $schemaCreateRouteRows = [
            'group' => [
                'name' => '数据结构创建',
                'code' => 'schema_create',
                'lang' => 'Schema_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 632,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($schemaCreateRouteRows);

        /**
         * 数据结构获取
         */
        $getSchemaRouteRows = [
            'group' => [
                'name' => '数据结构获取',
                'code' => 'get_schema',
                'lang' => 'Get_Schema',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 633,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getSchemaRouteRows);

        /**
         * 数据结构修改
         */
        $updateSchemaRouteRows = [
            'group' => [
                'name' => '数据结构修改',
                'code' => 'update_schema',
                'lang' => 'Update_Cchema',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 通用动作字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 634,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateSchemaRouteRows);

        /**
         * 指定选项配置获取
         */
        $getOptionsRouteRows = [
            'group' => [
                'name' => '指定选项配置获取',
                'code' => 'get_options',
                'lang' => 'Get_Options',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 指定选项配置获取
                    'auth_group_id' => 0,
                    'auth_node_id' => 644,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getOptionsRouteRows);

        /**
         * 指定选项配置更新
         */
        $updateOptionsRouteRows = [
            'group' => [
                'name' => '指定选项配置更新',
                'code' => 'update_options',
                'lang' => 'Update_Options',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 指定选项配置更新
                    'auth_group_id' => 0,
                    'auth_node_id' => 645,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateOptionsRouteRows);

        /**
         * 指定选项配置添加
         */
        $addOptionsRouteRows = [
            'group' => [
                'name' => '指定选项配置添加',
                'code' => 'add_options',
                'lang' => 'Add_Options',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 指定选项配置添加
                    'auth_group_id' => 0,
                    'auth_node_id' => 646,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($addOptionsRouteRows);

        /**
         * 获取websocket服务器
         */
        $socketServerRouteRows = [
            'group' => [
                'name' => '获取websocket服务器',
                'code' => 'get_event_log_web_socket_server',
                'lang' => 'Get_Event_Log_Web_Socket_Server',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取websocket服务器
                    'auth_group_id' => 0,
                    'auth_node_id' => 651,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($socketServerRouteRows);

        /**
         * 获取Email服务器
         */
        $emailServerRouteRows = [
            'group' => [
                'name' => '获取Email服务器',
                'code' => 'get_email_server',
                'lang' => 'Get_Email_Server',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取Email服务器
                    'auth_group_id' => 0,
                    'auth_node_id' => 652,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($emailServerRouteRows);

        /**
         * 获取log服务器
         */
        $logServerRouteRows = [
            'group' => [
                'name' => '获取log服务器',
                'code' => 'get_event_log_server',
                'lang' => 'Get_Event_Log_Server',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取log服务器
                    'auth_group_id' => 0,
                    'auth_node_id' => 653,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($logServerRouteRows);

        /**
         * 用户成员信息
         */
        $memberDataRouteRows = [
            'group' => [
                'name' => '用户成员信息',
                'code' => 'get_member_data',
                'lang' => 'Get_Member_Data',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 用户成员信息
                    'auth_group_id' => 0,
                    'auth_node_id' => 629,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($memberDataRouteRows);

        /**
         * 模板路径
         */
        $templatePathRouteRows = [
            'group' => [
                'name' => '模板路径',
                'code' => 'get_template_path',
                'lang' => 'Get_Template_Path',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模板路径
                    'auth_group_id' => 0,
                    'auth_node_id' => 630,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($templatePathRouteRows);

        /**
         * 项目路径
         */
        $itemPathRouteRows = [
            'group' => [
                'name' => '项目路径',
                'code' => 'get_item_path',
                'lang' => 'Get_Item_Path',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目路径
                    'auth_group_id' => 0,
                    'auth_node_id' => 630,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($itemPathRouteRows);


        /**
         * 默认视图创建
         */
        $viewModuleRows = [
            'group' => [
                'name' => '默认视图创建',
                'code' => 'create_default_view',
                'lang' => 'Create_Default_View',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 默认视图创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 649,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($viewModuleRows);

        /**
         * 模块获取
         */
        $moduleRows = [
            'group' => [
                'name' => '模块获取',
                'code' => 'get_module_data',
                'lang' => 'Get_Module_Data',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模块获取路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 650,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($moduleRows);
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
