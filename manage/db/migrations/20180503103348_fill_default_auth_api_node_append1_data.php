<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthApiNodeAppend1Data extends AbstractMigration
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
     * Migrate Up.
     */
    public function up()
    {
        // 初始化table
        $table = $this->table('strack_auth_node');
        $rows = [
            [
                'name' => '创建模式结构',
                'code' => 'create_schema_structure',
                'lang' => 'Create_Schema_Structure',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/createSchemaStructure',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '修改模式结构',
                'code' => 'update_schema_structure',
                'lang' => 'Update_Schema_Structure',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/updateSchemaStructure',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获得模式结构',
                'code' => 'get_schema_structure',
                'lang' => 'Get_Schema_Structure',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/getSchemaStructure',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取所有模式',
                'code' => 'get_all_schema',
                'lang' => 'Get_All_Schema',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/getAllSchema',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取模块',
                'code' => 'get_module_data',
                'lang' => 'Get_Module_Data',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Core/getModuleData',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '删除模式结构',
                'code' => 'delete_schema_structure',
                'lang' => 'Delete_Schema_Structure',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/deleteSchemaStructure',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '创建实体模块',
                'code' => 'create_entity_module',
                'lang' => 'Create_Entity_Module',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/Schema/createEntityModule',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联单条查找',
                'code' => 'reviewlink_find',
                'lang' => 'Reviewlink_Find',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/find',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联多条查找',
                'code' => 'reviewlink_select',
                'lang' => 'ReviewLink_Select',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/select',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联修改',
                'code' => 'reviewlink_update',
                'lang' => 'ReviewLink_Update',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/update',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联删除',
                'code' => 'reviewlink_delete',
                'lang' => 'ReviewLink_delete',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/delete',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联字段',
                'code' => 'reviewlink_fields',
                'lang' => 'ReviewLink_fields',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/fields',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据关联单条查找',
                'code' => 'onsetlink_find',
                'lang' => 'OnsetLink_Find',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/find',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据关联多条查找',
                'code' => 'onsetlink_select',
                'lang' => 'OnsetLink_Select',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/select',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据关联修改',
                'code' => 'onsetlink_update',
                'lang' => 'OnsetLink_Update',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/update',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据创建',
                'code' => 'onsetlink_create',
                'lang' => 'OnsetLink_Create',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/create',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据关联删除',
                'code' => 'onsetlink_delete',
                'lang' => 'OnsetLink_Delete',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/delete',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '现场数据关联字段',
                'code' => 'onsetlink_fields',
                'lang' => 'OnsetLink_Fields',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/OnsetLink/fields',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '添加父节点权限',
                'code' => 'create_parent_auth',
                'lang' => 'Create_Parent_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/createParentAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '添加子节点权限',
                'code' => 'create_child_auth',
                'lang' => 'Create_Child_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/createChildAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获得节点权限',
                'code' => 'get_node_auth',
                'lang' => 'Get_Node_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/getNodeAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],

            [
                'name' => '更新节点权限',
                'code' => 'update_node_auth',
                'lang' => 'Update_Node_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/updateNodeAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '删除节点权限',
                'code' => 'delete_node_auth',
                'lang' => 'Delete_Node_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/deleteNodeAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '查找多条权限节点',
                'code' => 'select_node_auth',
                'lang' => 'Select_Node_Auth',
                'type' => 'route',
                'module' => 'api',
                'project_id' => '0',
                'module_id' => '0',
                'rules' => 'api/auth/selectNodeAuth',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '审核关联创建',
                'code' => 'reviewlink_create',
                'lang' => 'ReviewLink_create',
                'type' => 'route',
                'module' => 'api',
                'module_id' => '0',
                'project_id' => '0',
                'rules' => 'api/ReviewLink/create',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $table->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_node');
    }
}
