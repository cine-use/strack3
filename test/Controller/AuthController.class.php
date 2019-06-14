<?php

namespace Test\Controller;


use Common\Model\AuthNodeModel;
use Common\Service\AuthService;
use Common\Service\PermissionService;
use Think\Controller;

class AuthController extends Controller
{

    // 只允许超级管理员访问模块
    protected $onlyAdministratorAllowVisit = ['field', 'module', 'schema', 'page_schema_use'];

    /**
     * 添加角色
     */
    public function addRole()
    {
        $param = [
            '0' => [
                'name' => '管理员',
                'type' => 'system',
                'state' => 'active'
            ],
            '1' => [
                'name' => '组长',
                'type' => 'project',
                'state' => 'active'
            ],
            '2' => [
                'name' => '艺术家',
                'type' => 'project',
                'state' => 'active'
            ]
        ];

        foreach ($param as $item) {
            $authRoleModel = new AuthRoleModel();
            $resData = $authRoleModel->addItem($item);
            if (!$resData) {
                $message = $authRoleModel->getError();
                $status = 404;
            } else {
                $message = $authRoleModel->getSuccessMassege();
                $status = 200;
            }
        }
        $data = ['status' => $status, 'message' => $message, 'data' => []];
        json($data);
    }

    /**
     * 获取权限列表
     */
    public function getAuthList()
    {
        $permissionService = new PermissionService();
        $resData = $permissionService->checkAccess("column");
        dump($resData);
    }

    /**
     * 注册数据表字段
     */
    public function saveAuthRuleColumn()
    {
        $authService = new AuthService();
        $resData = $authService->saveAuthRuleColumn();
        dump($resData);
    }

    public function getSinglePageAuth()
    {
        $authService = new AuthService();
        $resData = $authService->getSinglePageAuth(["code" => "admin_about"]);
        dump($resData);
    }

    public function getAdminRules()
    {
        $authService = new AuthService();
        $adminMenuRulePermission = $authService->getAdminRulePermission();
        dump($adminMenuRulePermission);
    }

    public function getPageRulePermission()
    {
        $authService = new AuthService();
        $resData = $authService->getPageRulePermission("base", "project", 1, 4);
        dump($resData);
    }

    public function getColumnRulePermission()
    {
//        $authConfig = [
//            'user' => [
//                'login_name' => [
//                    'show' => true,
//                    'edit' => false
//                ],
//                'email' => [
//                    'show' => true,
//                    'edit' => true
//                ],
//                'name' => [
//                    'show' => true,
//                    'edit' => true
//                ],
//                'nickname' => [
//                    'show' => true,
//                    'edit' => true
//                ],
//                'phone' => [
//                    'show' => true,
//                    'edit' => true
//                ],
//                'department_id' => [
//                    'show' => true,
//                    'edit' => false
//                ],
//                'status' => [
//                    'show' => true,
//                    'edit' => true
//                ]
//            ],
//            'user_config' => [
//                'login_name' => [
//                    'show' => true,
//                    'edit' => false
//                ],
//            ],
//            'user_detail' => [
//
//            ],
//            'user_edu' => [
//
//            ],
//            'user_exp' => [
//
//            ],
//            'user_skill' => [
//
//            ],
//            'department' => [
//
//            ]
//        ];
//        dump($authConfig);
//        die;
        $authService = new AuthService();
        $resData = $authService->getColumnRulePermission("base", 4, 1);
        dump($resData);
        die;
    }

    public function testAddData()
    {
        dump(create_pass("strack"));
    }


    /**
     * 判断权限排除管理员 user_id = 1 为strack官方管理员账号 2 为客户管理员账号
     * @param $permissionItem
     * @return string
     */
    protected function checkRuleExcludeAdministrator($permissionItem)
    {
        if (in_array($permissionItem["code"], $this->onlyAdministratorAllowVisit)) {
            if ($this->userId === 1) {
                $permission = "yes";
            } else {
                $permission = "no";
            }
        } else {
            if (in_array($this->userId, [1, 2])) {
                // 超级管理员拥有所有权限
                $permission = "yes";
            } else {
                // 普通用户
                $permission = $permissionItem["permission"] ? 'yes' : 'no';
            }
        }
        return $permission;
    }

    /**
     * 处理生成页面权限
     * @param $controllerName
     * @param $moduleName
     */
    public function getViewRules()
    {
        $authService = new AuthService();
        $pageRules = $authService->getPageRulePermission("schedule", "admin");
        if ($this->checkRuleExcludeAdministrator($pageRules["view"]) === "no") {
            $viewRules = [];
            $viewRulesData = $this->generateViewRules($viewRules, $pageRules["view"]["list"]);
            dump($viewRulesData);
            dump(66666666666666666);
        }
    }

    /**
     * 递归生成页面权限
     * @param $viewRules
     * @param $data
     * @return mixed
     */
    public function generateViewRules(&$viewRules, $data)
    {
        foreach ($data as $rulesItem) {
            if (isset($rulesItem["list"])) {
                $viewRules[$rulesItem["code"]] = [
                    'main' => $this->checkRuleExcludeAdministrator($rulesItem)
                ];
                $this->generateViewRules($viewRules[$rulesItem["code"]], $rulesItem["list"]);
            } else {
                $viewRules[$rulesItem["code"]] = $this->checkRuleExcludeAdministrator($rulesItem);
            }
        }
        return $viewRules;
    }

    public function testAuthRoleAuth()
    {
        $param = [
            "param" => [
                "role_id" => "1",
                "role_name" => "testcccvvvv",
                "role_code" => "test",
                "role_tab" => "project",
                "role_rule_tab" => "view,column",
                "role_rule_id" => "231",
                "role_template_id" => "1",
                "role_module_id" => "4",
                "role_rule_code" => "base"
            ],
            "config" => [
                "view" => [
                    "page" => [
                        "id" => "231",
                        "lang" => "任务页面",
                        "checked" => "1",
                        "list" => [

                        ]
                    ],
                    "create" => [
                        "id" => "243",
                        "lang" => "创建",
                        "checked" => "1",
                        "list" => [

                        ]
                    ],
                    "edit" => [
                        "id" => "244",
                        "lang" => "编辑",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "编辑选定的",
                                "code" => "edit_selected",
                                "id" => "245",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "导入Excel",
                                "code" => "import_excel",
                                "id" => "246",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "导出Excel",
                                "code" => "export_excel",
                                "id" => "247",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "所有动作",
                                "code" => "all_action",
                                "id" => "248",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "常用动作",
                                "code" => "frequently_use_action",
                                "id" => "249",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "删除",
                                "code" => "delete",
                                "id" => "250",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "修改缩略图",
                                "code" => "modify_thumb",
                                "id" => "251",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "清除缩略图",
                                "code" => "clear_thumb",
                                "id" => "252",
                                "checked" => "1"
                            ]
                        ]
                    ],
                    "sort" => [
                        "id" => "254",
                        "lang" => "排序",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "升序",
                                "code" => "sort_asc",
                                "id" => "255",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "降序",
                                "code" => "sort_desc",
                                "id" => "256",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "高级排序",
                                "code" => "sort_adv",
                                "id" => "257",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "取消排序",
                                "code" => "sort_cancel",
                                "id" => "258",
                                "checked" => "1"
                            ]
                        ]
                    ],
                    "group" => [
                        "id" => "259",
                        "lang" => "分组",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "取消分组",
                                "code" => "group_cancel",
                                "id" => "260",
                                "checked" => "1"
                            ]
                        ]
                    ],
                    "display_column" => [
                        "id" => "261",
                        "lang" => "显示列",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "管理自定义字段",
                                "code" => "manage_custom_fields",
                                "id" => "262",
                                "checked" => "1"
                            ]
                        ]
                    ],
                    "view" => [
                        "id" => "266",
                        "lang" => "视图",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "保存视图",
                                "code" => "save_view",
                                "id" => "267",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "另存为视图",
                                "code" => "save_as_view",
                                "id" => "268",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "修改",
                                "code" => "modify",
                                "id" => "269",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "删除视图",
                                "code" => "delete_view",
                                "id" => "270",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "我的视图",
                                "code" => "self_view",
                                "id" => "271",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "共享视图",
                                "code" => "public_view",
                                "id" => "272",
                                "checked" => "1"
                            ]
                        ]
                    ],
                    "search_filter" => [
                        "id" => "273",
                        "lang" => "搜索框过滤",
                        "checked" => "1",
                        "list" => [

                        ]
                    ],
                    "panel_filter" => [
                        "id" => "274",
                        "lang" => "过滤面板",
                        "checked" => "1",
                        "list" => [
                            [
                                "lang" => "保持显示",
                                "code" => "keep_display",
                                "id" => "275",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "重置默认",
                                "code" => "reset_default",
                                "id" => "276",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "增加过滤",
                                "code" => "add_filter",
                                "id" => "277",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "搜索",
                                "code" => "search",
                                "id" => "278",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "保存过滤",
                                "code" => "save_filter",
                                "id" => "279",
                                "checked" => "1"
                            ],
                            [
                                "lang" => "高级过滤",
                                "code" => "advanced_filter",
                                "id" => "280",
                                "checked" => "1"
                            ]
                        ]
                    ]
                ],
                "column" => [
                    "base" => [
                        "id" => "305",
                        "lang" => "任务",
                        "list" => [
                            [
                                "lang" => "编号",
                                "code" => "id",
                                "id" => "306",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "名称",
                                "code" => "name",
                                "id" => "307",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "编码",
                                "code" => "code",
                                "id" => "308",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "项目编号",
                                "code" => "project_id",
                                "id" => "309",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "实体编号",
                                "code" => "entity_id",
                                "id" => "310",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "ENTITY_MODULE_ID",
                                "code" => "entity_module_id",
                                "id" => "311",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "状态编号",
                                "code" => "status_id",
                                "id" => "312",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "工序编号",
                                "code" => "step_id",
                                "id" => "313",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "优先级",
                                "code" => "priority",
                                "id" => "314",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "开始时间",
                                "code" => "start_time",
                                "id" => "315",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "结束时间",
                                "code" => "end_time",
                                "id" => "316",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "周期",
                                "code" => "duration",
                                "id" => "317",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "计划开始时间",
                                "code" => "plan_start_time",
                                "id" => "318",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "计划结束时间",
                                "code" => "plan_end_time",
                                "id" => "319",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "计划周期",
                                "code" => "plan_duration",
                                "id" => "320",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "描述",
                                "code" => "description",
                                "id" => "321",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "Json数据",
                                "code" => "json",
                                "id" => "322",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建者",
                                "code" => "created_by",
                                "id" => "323",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建时间",
                                "code" => "created",
                                "id" => "324",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "UUID",
                                "code" => "uuid",
                                "id" => "325",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "media" => [
                        "id" => "363",
                        "lang" => "媒体",
                        "list" => [
                            [
                                "lang" => "编号",
                                "code" => "id",
                                "id" => "364",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "关联ID",
                                "code" => "link_id",
                                "id" => "365",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "模块编号",
                                "code" => "module_id",
                                "id" => "366",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "描述",
                                "code" => "description",
                                "id" => "367",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "MD5名称",
                                "code" => "md5_name",
                                "id" => "368",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "缩略图",
                                "code" => "thumb",
                                "id" => "369",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "尺寸",
                                "code" => "size",
                                "id" => "370",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "类型",
                                "code" => "type",
                                "id" => "371",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "媒体服务器编号",
                                "code" => "media_server_id",
                                "id" => "372",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建者",
                                "code" => "created_by",
                                "id" => "373",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建时间",
                                "code" => "created",
                                "id" => "374",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "UUID",
                                "code" => "uuid",
                                "id" => "375",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "project" => [
                        "id" => "455",
                        "lang" => "项目",
                        "list" => [
                            [
                                "lang" => "编号",
                                "code" => "id",
                                "id" => "456",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "名称",
                                "code" => "name",
                                "id" => "457",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "编码",
                                "code" => "code",
                                "id" => "458",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "状态",
                                "code" => "status_id",
                                "id" => "459",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "帧速率",
                                "code" => "rate",
                                "id" => "460",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "描述",
                                "code" => "description",
                                "id" => "461",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "开始时间",
                                "code" => "start_time",
                                "id" => "462",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "结束时间",
                                "code" => "end_time",
                                "id" => "463",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建者",
                                "code" => "created_by",
                                "id" => "464",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "创建时间",
                                "code" => "created",
                                "id" => "465",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ],
                            [
                                "lang" => "UUID",
                                "code" => "uuid",
                                "id" => "466",
                                "permission" => [
                                    "view" => [
                                        "lang" => "视图",
                                        "checked" => "1"
                                    ],
                                    "create" => [
                                        "lang" => "创建",
                                        "checked" => ""
                                    ],
                                    "modify" => [
                                        "lang" => "修改",
                                        "checked" => ""
                                    ],
                                    "delete" => [
                                        "lang" => "删除",
                                        "checked" => ""
                                    ],
                                    "clear" => [
                                        "lang" => "清除",
                                        "checked" => ""
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $config = $param["config"];
        $ruleRows = [];

        dump($config);

        foreach ($config as $key => $configItem) {
            switch ($key) {
                case "view":
                    // 视图权限数据处理
                    $this->viewConfigToArray($ruleRows, $configItem, 'view');
                    break;
                case "column":
                    // 字段权限数据处理
                    $this->viewConfigToArray($ruleRows, $configItem, 'column');
                    break;
            }
        }

        dump($ruleRows);
        die;

    }


    public function viewConfigToArray(&$viewArray, $viewConfig, $type)
    {
        foreach ($viewConfig as $item) {
            if (array_key_exists("list", $item)) {
                $item["permission"] = $type;
                $tempList = $item["list"];
                unset($item["list"]);
                array_push($viewArray, $item);
                $this->viewConfigToArray($viewArray, $tempList, $type);
            } else {
                if ($type === "view") {
                    $item["permission"] = $type;
                    array_push($viewArray, $item);
                } else {
                    $tempBase = $item;
                    unset($tempBase["permission"]);
                    foreach ($item["permission"] as $key => $value) {
                        $tempBase["permission"] = $key;
                        $tempBase = array_merge($tempBase, $value);
                        array_push($viewArray, $tempBase);
                    }
                }
            }
        }
        return $viewArray;
    }

    /**
     * 获取模块下所有的控制器和方法写入到权限表
     */
    public function initPerm()
    {
        $modules = array('Home');  //模块名称
        $i = 0;
        $saveNodeData = [];
        foreach ($modules as $module) {
            $allController = $this->getController($module);
            foreach ($allController as $controller) {
                $all_action = $this->getAction($module, $controller);
                foreach ($all_action as $action) {
                    $controller = str_replace('Controller.class', '', $controller);
                    $data[$i]['module'] = $module;
                    $data[$i]['controller'] = $controller;
                    $data[$i]['action'] = $action;

                    if (!empty($module) && !empty($controller) && !empty($action)) {

                        $ruleName = $module . "/" . $controller . "/" . $action;

                        $code = toUnderScore($action);

                        $lang = underlineToUppercase($code);

                        $authNodeModel = new AuthNodeModel();
                        $nodeData = $authNodeModel->where(["module" => "page", "type" => "route", "rules" => $ruleName])->find();

                        if (empty($nodeData)) {
                            $rules = [
                                'name' => '前台方法',
                                'code' => $code,
                                'lang' => $lang,
                                'type' => 'route',
                                'module' => 'page',
                                'project_id' => 0,
                                'module_id' => 0,
                                'rules' => $ruleName,
                                'uuid' => create_uuid()
                            ];
                            array_push($saveNodeData, $rules);
                        }
                    }

                    $i++;
                }
            }
        }

        dump(json_encode($saveNodeData));
    }


    // 获取所有控制器名称
    private function getController($module)
    {
        if (empty($module)) {
            return null;
        }
        $module_path = APP_PATH . '/' . $module . '/Controller/';  //控制器路径
        if (!is_dir($module_path)) {
            return null;
        }
        $files = [];
        $module_path .= '/*.php';
        $aryFiles = glob($module_path);
        foreach ($aryFiles as $file) {
            if (is_dir($file)) {
                continue;
            } else {
                $files[] = basename($file, '.php');
            }
        }
        return $files;
    }

    // 获取所有方法名称
    protected function getAction($module, $controller)
    {
        if (empty($controller)) {
            return null;
        }
        $file = APP_PATH . $module . '/Controller/' . $controller . '.php';

        if (file_exists($file)) {
            $content = file_get_contents($file);
            preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
            $functions = $matches[1];
            // 排除部分方法
            $excludeCustomerFunctions = ['_initialize', '__construct', 'getActionName', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get', '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty'];
            $customerFunctions = [];
            foreach ($functions as $func) {
                $func = trim($func);
                if (!in_array($func, $excludeCustomerFunctions)) {
                    $customerFunctions[] = $func;
                }
            }
            return $customerFunctions;
        } else {
            \ticky\Log::record('is not file ' . $file, Log::INFO);
        }
        return null;
    }


    public function testAdd()
    {
        $authNodeModel = new AuthNodeModel();
        $authNodeModel->addItem([
            'name' => 'test22222',
            'code' => 'test22222',
            'lang' => 'test22222',
            'type' => 'route',
            'module' => 'page',
            'rules' => '2222222222'
        ]);
    }
}