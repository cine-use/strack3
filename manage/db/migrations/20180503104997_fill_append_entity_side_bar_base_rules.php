<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class fillAppendEntitySideBarBaseRules extends AbstractMigration
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
     * @throws Exception
     */
    public function up()
    {
        $authNode = [
            'name' => '获取边侧栏数据表格配置',
            'code' => 'get_data_grid_slider_table_config',
            'lang' => 'Get_Data_Grid_Slider_Table_Config',
            'type' => 'route',
            'module' => 'page',
            'project_id' => 0,
            'module_id' => 0,
            'rules' => 'Home/View/getDataGridSliderTableConfig',
            'uuid' => Webpatser\Uuid\Uuid::generate()->string
        ];

        $this->table('strack_auth_node')->insert($authNode)->save();

        $authGroupData = $this->fetchRow('SELECT id FROM strack_auth_group WHERE code="base" and type="view"');
        $authGroupNode = [
            "auth_group_id" => $authGroupData["id"],
            "auth_node_id" => 729,
            "uuid" => Webpatser\Uuid\Uuid::generate()->string
        ];
        $this->table('strack_auth_group_node')->insert($authGroupNode)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group_node');
        $this->execute('DELETE FROM strack_auth_node');
        $this->execute('DELETE FROM strack_auth_group');
    }
}
