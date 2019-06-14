<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultAuthBatchAddNoteRulesData extends AbstractMigration
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
        /**
         * auth_node添加
         */
        $rows = [
            [
                'name' => '批量添加反馈',
                'code' => 'batch_add_note',
                'lang' => 'Batch_Add_Note',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Note/batchAddNote',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($rows)->save();

        /**
         * 批量添加反馈按钮
         */
        $batchAddNoteRows = [
            'group' => [
                'name' => '批量添加反馈',
                'code' => 'batch_add_note',
                'lang' => 'Batch_Add_Note',
                'type' => 'view',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [ // 批量添加反馈路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 681,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 添加按钮
                    'auth_group_id' => 0,
                    'auth_node_id' => 344,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取被At用户列表路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 189,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取反馈置顶数据路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 254,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取获取媒体上传服务路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 178,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($batchAddNoteRows);


        /**
         * 批量添加反馈任务页面权限
         */
        $batchAddNotePageAuthBaseRows = [
            'page' => [
                'name' => '批量添加反馈',
                'code' => 'batch_add_note',
                'lang' => 'Batch_Add_Note',
                'page' => 'home_project_base',
                'param' => '',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [
                    'page_auth_id' => 0,
                    'auth_group_id' => 449,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            "list" => []
        ];

        $this->savePageAuth($batchAddNotePageAuthBaseRows, 437);

        /**
         * 获取所有已存在的实体，增加权限
         */
        $entityPageList = $this->fetchAll('SELECT id,param FROM strack_page_auth where `page`="home_project_entity" and `code`="edit"');
        foreach ($entityPageList as $item) {
            /**
             * 批量添加反馈审核页面权限
             */
            $batchAddNotePageAuthReviewRows = [
                'page' => [
                    'name' => '批量添加反馈',
                    'code' => 'batch_add_note',
                    'lang' => 'Batch_Add_Note',
                    'page' => 'home_project_entity',
                    'param' => $item["param"],
                    'type' => 'belong',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 449,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ],
                "list" => []
            ];
            $this->savePageAuth($batchAddNotePageAuthReviewRows, $item["id"]);
        }
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
