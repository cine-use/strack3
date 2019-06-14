<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class fillAppendHomeAccountSecurityRules extends AbstractMigration
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

        $authNode = [
            [
                'name' => '安全设置',
                'code' => 'security',
                'lang' => 'Security',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/Account/security',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取用户安全设置',
                'code' => 'get_user_security',
                'lang' => 'Get_User_Security',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/User/getUserSecurity',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '获取项目列表',
                'code' => 'save_user_security',
                'lang' => 'Save_User_Security',
                'type' => 'route',
                'module' => 'page',
                'project_id' => 0,
                'module_id' => 0,
                'rules' => 'Home/User/saveUserSecurity',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_auth_node')->insert($authNode)->save();

        // 偏好设置页面
        $myAccountSecurityPageRows = [
            'group' => [
                'name' => '安全设置',
                'code' => 'my_account_security',
                'lang' => 'My_Account_Security',
                'type' => 'url',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'rules' => [
                [
                    // 安全设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 726,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                [ // 获取用户安全设置路由
                    'auth_group_id' => 0,
                    'auth_node_id' => 727,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($myAccountSecurityPageRows);

        // 安全设置编辑按钮
        $securitySaveRows = [
            'group' => [
                'name' => '编辑安全设置',
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
                    'auth_node_id' => 728,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ]
        ];

        $this->saveAuthGroup($securitySaveRows);

        /**
         * 项目镜头数据表格页面
         */
        $accountPageRows = [
            'page' => [
                'name' => '安全设置',
                'code' => 'personal_account_security',
                'lang' => 'My_Account_Security',
                'page' => 'home_account_security',
                'param' => '',
                'menu' => 'account_left_menu,front',
                'category' => 'My_Account_Config',
                'type' => 'belong',
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 482,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => '安全设置访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_account_security',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 482,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                ],
                [
                    'page' => [
                        'name' => '编辑',
                        'code' => 'edit',
                        'lang' => 'Edit',
                        'page' => 'home_account_security',
                        'param' => '',
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ],
                    'auth_group' => [
                        [
                            'page_auth_id' => 0,
                            'auth_group_id' => 483,
                            'uuid' => Webpatser\Uuid\Uuid::generate()->string
                        ]
                    ],
                ]
            ]
        ];

        $this->savePageAuth($accountPageRows);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_user');
    }
}
