<?php


use Phinx\Migration\AbstractMigration;

class FillAppendApiFieldRules extends AbstractMigration
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
        $nodeRows = [
            [
                'name' => '获取单个表配置',
                'code' => 'get_table_config',
                'lang' => 'Get_Table_Config',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/getTableConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取所有表名',
                'code' => 'get_all_table_name',
                'lang' => 'Get_All_Table_Name',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/getAllTableName',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '修改表配置',
                'code' => 'update_table_config',
                'lang' => 'Update_Table_Config',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/updateTableConfig',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($nodeRows)->save();

        /**
         * 获取单个表配置
         */
        $getTableConfigGroupRows = [
            'group' => [
                'name' => '获取单个表配置',
                'code' => 'get_table_config',
                'lang' => 'Get_Table_Config',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取单个表配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 692,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getTableConfigGroupRows);

        /**
         * 获取所有表名
         */
        $getAllTableGroupRows = [
            'group' => [
                'name' => '获取所有表名',
                'code' => 'get_table_config',
                'lang' => 'Get_Table_Config',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取所有表名路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 693,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getAllTableGroupRows);

        /**
         * 修改表配置
         */
        $updateTableConfigGroupRows = [
            'group' => [
                'name' => '修改表配置',
                'code' => 'update_table_config',
                'lang' => 'Update_Table_Config',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改表配置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 694,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($updateTableConfigGroupRows);

        /**
         * 获取单个表配置
         */
        $getTableConfigPageRows = [
            'page' => [
                'name' => '获取单个表配置',
                'code' => 'get_table_config',
                'lang' => 'Get_Table_Config',
                'page' => 'api_schema',
                'param' => 'gettableconfig',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 458,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($getTableConfigPageRows, 927);

        /**
         * 获取单个表配置
         */
        $getAllTablePageRows = [
            'page' => [
                'name' => '获取所有表名',
                'code' => 'get_table_config',
                'lang' => 'Get_Table_Config',
                'page' => 'api_schema',
                'param' => 'gettableconfig',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 459,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($getAllTablePageRows, 927);

        /**
         * 获取单个表配置
         */
        $updateTableConfigPageRows = [
            'page' => [
                'name' => '修改表配置',
                'code' => 'update_table_config',
                'lang' => 'Update_Table_Config',
                'page' => 'api_schema',
                'param' => 'updatetableconfig',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 460,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];
        $this->savePageAuth($updateTableConfigPageRows, 927);

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
