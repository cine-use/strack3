<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class fillAppendSideBarRules extends AbstractMigration
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
     * @throws Exception
     */
    public function up()
    {
        $queryList = $this->fetchAll('SELECT id,page,param FROM strack_page_auth WHERE page in ("home_project_base","home_project_entity") and code="tab_bar"');

        foreach ($queryList as $item) {
            $filePageRows = [
                'page' => [
                    'name' => '文件',
                    'code' => 'file',
                    'lang' => 'File',
                    'page' => $item['page'],
                    'param' => $item['param'],
                    'type' => 'children',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 173,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                'list' => []
            ];
            $this->savePageAuth($filePageRows, $item["id"]);

            $fileCommitPageRows = [
                'page' => [
                    'name' => '文件提交批次',
                    'code' => 'commit',
                    'lang' => 'File_Commit',
                    'page' => $item['page'],
                    'param' => $item['param'],
                    'type' => 'children',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 148,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                'list' => []
            ];
            $this->savePageAuth($fileCommitPageRows, $item["id"]);
            $correlationTaskPageRows = [
                'page' => [
                    'name' => '相关任务',
                    'code' => 'correlation_task',
                    'lang' => 'Correlation_Task',
                    'page' => $item['page'],
                    'param' => $item['param'],
                    'type' => 'children',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 174,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                'list' => []
            ];
            $this->savePageAuth($correlationTaskPageRows, $item["id"]);

            $horizontalRelationshipPageRows = [
                'page' => [
                    'name' => '水平关联表格',
                    'code' => 'horizontal_relationship',
                    'lang' => 'Horizontal_Relationship',
                    'page' => $item['page'],
                    'param' => $item['param'],
                    'type' => 'children',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 175,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                'list' => []
            ];
            $this->savePageAuth($horizontalRelationshipPageRows, $item["id"]);
        }
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
