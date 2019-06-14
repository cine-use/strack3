<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthApiGroupAppend2Data extends AbstractMigration
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
         * 删除模式结构
         */
        $getModuleDataRows = [
            'group' => [
                'name' => '删除模式结构',
                'code' => 'Delete_Schema_Structure',
                'lang' => 'delete_schema_structure',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除模式结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 660,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getModuleDataRows);

        /**
         * 创建实体模块
         */
        $getModuleDataRows = [
            'group' => [
                'name' => '创建实体模块',
                'code' => 'create_entity_module',
                'lang' => 'Create_Entity_Module',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建实体模块路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 661,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getModuleDataRows);

        /**
         * 项目模板单条查找
         */
        $projecttemplateFindRouteRows = [
            'group' => [
                'name' => '项目模板单条查找',
                'code' => 'projecttemplate_find',
                'lang' => 'ProjectTemplate_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 539,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateFindRouteRows);

        /**
         * 项目模板多条查找
         */
        $projecttemplateSelectRouteRows = [
            'group' => [
                'name' => '项目模板多条查找',
                'code' => 'projecttemplate_select',
                'lang' => 'ProjectTemplate_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 540,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateSelectRouteRows);

        /**
         * 项目模板修改
         */
        $projecttemplateUpdateRouteRows = [
            'group' => [
                'name' => '项目模板修改',
                'code' => 'projecttemplate_update',
                'lang' => 'ProjectTemplate_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 541,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateUpdateRouteRows);

        /**
         * 项目模板创建
         */
        $projecttemplateCreateRouteRows = [
            'group' => [
                'name' => '项目模板创建',
                'code' => 'projecttemplate_create',
                'lang' => 'ProjectTemplate_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 542,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateCreateRouteRows);

        /**
         * 项目模板删除
         */
        $projecttemplateUpdateRouteRows = [
            'group' => [
                'name' => '项目模板删除',
                'code' => 'projecttemplate_delete',
                'lang' => 'ProjectTemplate_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 543,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateUpdateRouteRows);

        /**
         * 项目模板字段
         */
        $projecttemplateFieldsRouteRows = [
            'group' => [
                'name' => '项目模板字段',
                'code' => 'projecttemplate_fields',
                'lang' => 'ProjectTemplate_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目模板字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 544,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($projecttemplateFieldsRouteRows);

        /**
         * 模板路径
         */
        $getTemplatePathRouteRows = [
            'group' => [
                'name' => '模板路径',
                'code' => 'get_template_path',
                'lang' => 'Get_Template_Path',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 模板路径路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 630,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getTemplatePathRouteRows);

        /**
         * 项目路径
         */
        $getItemPathRouteRows = [
            'group' => [
                'name' => '项目路径',
                'code' => 'get_item_path',
                'lang' => 'Get_Item_Path',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 项目路径路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 631,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getItemPathRouteRows);

        /**
         * 审核关联单条查找
         */
        $reviewlinkFindRouteRows = [
            'group' => [
                'name' => '审核关联单条查找',
                'code' => 'reviewlink_find',
                'lang' => 'ReviewLink_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 662,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkFindRouteRows);

        /**
         * 审核关联多条查找
         */
        $reviewlinkSelectRouteRows = [
            'group' => [
                'name' => '审核关联多条查找',
                'code' => 'reviewlink_select',
                'lang' => 'ReviewLink_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 663,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkSelectRouteRows);

        /**
         * 审核关联修改
         */
        $reviewlinkUpdateRouteRows = [
            'group' => [
                'name' => '审核关联修改',
                'code' => 'reviewlink_update',
                'lang' => 'ReviewLink_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核关联修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 664,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkUpdateRouteRows);

        /**
         * 审核关联删除
         */
        $reviewlinkUpdateRouteRows = [
            'group' => [
                'name' => '审核关联删除',
                'code' => 'reviewlink_delete',
                'lang' => 'ReviewLink_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核关联删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 665,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkUpdateRouteRows);

        /**
         * 审核关联字段
         */
        $reviewlinkFieldsRouteRows = [
            'group' => [
                'name' => '审核关联字段',
                'code' => 'reviewlink_fields',
                'lang' => 'ReviewLink_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 审核关联字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 666,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkFieldsRouteRows);

        /**
         * 现场数据关联单条查找
         */
        $onsetlinkFindRouteRows = [
            'group' => [
                'name' => '现场数据关联单条查找',
                'code' => 'onsetlink_find',
                'lang' => 'OnsetLink_Find',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 667,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkFindRouteRows);

        /**
         * 现场数据关联多条查找
         */
        $onsetlinkSelectRouteRows = [
            'group' => [
                'name' => '现场数据关联多条查找',
                'code' => 'onsetlink_select',
                'lang' => 'OnsetLink_Select',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联单条查找路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 668,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkSelectRouteRows);

        /**
         * 现场数据关联修改
         */
        $onsetlinkUpdateRouteRows = [
            'group' => [
                'name' => '现场数据关联修改',
                'code' => 'onsetlink_update',
                'lang' => 'OnsetLink_Update',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联修改路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 669,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkUpdateRouteRows);

        /**
         * 现场数据关联创建
         */
        $onsetlinkCreateRouteRows = [
            'group' => [
                'name' => '现场数据关联创建',
                'code' => 'onsetlink_create',
                'lang' => 'OnsetLink_Create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联创建路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 670,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkCreateRouteRows);

        /**
         * 现场数据关联删除
         */
        $onsetlinkUpdateRouteRows = [
            'group' => [
                'name' => '现场数据关联删除',
                'code' => 'onsetlink_delete',
                'lang' => 'OnsetLink_Delete',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联删除路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 671,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkUpdateRouteRows);

        /**
         * 现场数据关联字段
         */
        $onsetlinkFieldsRouteRows = [
            'group' => [
                'name' => '现场数据关联字段',
                'code' => 'onsetlink_fields',
                'lang' => 'OnsetLink_Fields',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 现场数据关联字段路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 672,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($onsetlinkFieldsRouteRows);

        /**
         * 添加父节点权限
         */
        $createParentAuthRouteRows = [
            'group' => [
                'name' => '添加父节点权限',
                'code' => 'create_parent_auth',
                'lang' => 'Create_Parent_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加父节点权限路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 673,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createParentAuthRouteRows);

        /**
         * 添加子节点权限权限
         */
        $createChildAuthRouteRows = [
            'group' => [
                'name' => '添加子节点权限',
                'code' => 'create_child_auth',
                'lang' => 'Create_Child_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 添加子节点权限路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 674,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createChildAuthRouteRows);

        /**
         * 获得节点权限
         */
        $getNodeAuthRouteRows = [
            'group' => [
                'name' => '获得节点权限',
                'code' => 'get_node_auth',
                'lang' => 'Get_Node_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获得节点权限路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 675,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getNodeAuthRouteRows);

        /**
         * 更新节点权限
         */
        $updateNodeAuthRouteRows = [
            'group' => [
                'name' => '更新节点权限',
                'code' => 'update_node_auth',
                'lang' => 'Update_Node_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 更新节点权限路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 676,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateNodeAuthRouteRows);

        /**
         * 删除节点权限
         */
        $deleteNodeAuthRouteRows = [
            'group' => [
                'name' => '删除节点权限',
                'code' => 'delete_node_auth',
                'lang' => 'Delete_Node_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 删除节点权限路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 677,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($deleteNodeAuthRouteRows);

        /**
         * 查找多条权限节点
         */
        $selectNodeAuthRouteRows = [
            'group' => [
                'name' => '查找多条权限节点',
                'code' => 'select_node_auth',
                'lang' => 'Select_Node_Auth',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 查找多条权限节点路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 678,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($selectNodeAuthRouteRows);

        /**
         * 审核关联创建
         */
        $reviewlinkCreateRouteRows = [
            'group' => [
                'name' => '审核关联创建',
                'code' => 'reviewlink_create',
                'lang' => 'ReviewLink_create',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 查找多条权限节点路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 679,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($reviewlinkCreateRouteRows);
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
