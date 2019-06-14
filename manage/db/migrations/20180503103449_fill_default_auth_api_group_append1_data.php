<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthApiGroupAppend1Data extends AbstractMigration
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
         * 创建模式结构
         */
        $createSystemSchemaRows = [
            'group' => [
                'name' => '创建模式结构',
                'code' => 'create_schema_structure',
                'lang' => 'Create_Schema_Structure',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 创建模式结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 654,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createSystemSchemaRows);

        /**
         * 修改模式结构
         */
        $createProjectSchemaRows = [
            'group' => [
                'name' => '修改模式结构',
                'code' => 'update_schema_structure',
                'lang' => 'Update_Schema_Structure',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 修改模式结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 655,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($createProjectSchemaRows);

        /**
         * 获得模式结构
         */
        $getSchemaStructureRows = [
            'group' => [
                'name' => '获得模式结构',
                'code' => 'get_schema_structure',
                'lang' => 'Get_Schema_Structure',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获得模式结构路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 656,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getSchemaStructureRows);

        /**
         * 获取所有模式
         */
        $getAllStructureRows = [
            'group' => [
                'name' => '获取所有模式',
                'code' => 'get_all_schema',
                'lang' => 'Get_All_Schema',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取所有模式路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 657,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getAllStructureRows);

        /**
         * 获取模块
         */
        $getModuleDataRows = [
            'group' => [
                'name' => '获取模块',
                'code' => 'get_module_data',
                'lang' => 'Get_Module_Data',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 获取模块路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 658,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($getModuleDataRows);
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
