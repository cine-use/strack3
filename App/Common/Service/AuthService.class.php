<?php
// +----------------------------------------------------------------------
// | 基于 RBAC 模型的权限管理
// +----------------------------------------------------------------------
// | 主要服务于权限管理处理
// +----------------------------------------------------------------------
// | 错误编码头 218xxx
// +----------------------------------------------------------------------

namespace Common\Service;

use Common\Model\AuthAccessModel;
use Common\Model\AuthFieldModel;
use Common\Model\AuthGroupModel;
use Common\Model\AuthGroupNodeModel;
use Common\Model\AuthNodeModel;
use Common\Model\FieldModel;
use Common\Model\HorizontalConfigModel;
use Common\Model\ModuleModel;
use Common\Model\PageAuthModel;
use Common\Model\PageLinkAuthModel;
use Common\Model\ProjectMemberModel;
use Common\Model\ProjectModel;
use Common\Model\RoleModel;
use Common\Model\RoleUserModel;
use Common\Model\VariableModel;

class AuthService
{
    // 获取权限节点数据字典
    protected $allAuthNodeDataDict = [];

    // 获取权限组数据字典
    protected $allAuthGroupDataDict = [];

    // 获取所有页面关联权限数据字典
    protected $allPageLinkAuthDataDict = [];

    // 获取所有用户权限设置
    protected $allUserAuthAccessDataDict = [];

    // 角色id
    protected $roleId = 0;

    // 用户id
    protected $userId = 0;

    // 错误信息
    protected $errorMsg = '';

    // 只允许超级管理员访问模块
    protected $onlyAdministratorAllowVisit = ['field', 'module', 'schema', 'page_schema_use'];

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->allAuthGroupDataDict = $this->generateAuthGroupNodeDict();
        $this->allPageLinkAuthDataDict = $this->getAllPageLinkAuthDataDict();
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->errorMsg;
    }

    /**
     * 设置指定角色
     * @param $roleId
     */
    public function setRole($roleId)
    {
        $this->roleId = $roleId;
        $this->allUserAuthAccessDataDict = $this->getAllUserAuthAccessDataDict($roleId);
    }

    /**
     * 设置指定用户
     * @param $userId
     * @param int $projectId
     */
    public function setUser($userId, $projectId = 0)
    {
        $this->userId = (int)$userId;
        $roleData = $this->getUserRoleData($userId, $projectId);
        if (!empty($roleData)) {
            $this->setRole($roleData["id"]);
        }
    }

    /**
     * 获取所有权限节点数据字典
     * @return array
     */
    protected function getAllAuthNodeDataDict()
    {
        $authNodeModel = new AuthNodeModel();
        $allNodeData = $authNodeModel->select();
        $allAuthNodeDataDict = [];
        foreach ($allNodeData as $item) {
            $allAuthNodeDataDict[$item["id"]] = $item;
            $this->allAuthNodeDataDict[md5(strtolower($item["rules"]))] = $item;
        }
        return $allAuthNodeDataDict;
    }

    /**
     * 获取所有权限组和权限关联字典
     * @return array
     */
    protected function getAllAuthGroupNodeDataDict()
    {
        $authNodeGroupModel = new AuthGroupNodeModel();
        $allNodeGroupData = $authNodeGroupModel->select();
        $allAuthNodeGroupDataDict = [];
        foreach ($allNodeGroupData as $item) {
            $allAuthNodeGroupDataDict[$item["auth_group_id"]][] = $item["auth_node_id"];
        }
        return $allAuthNodeGroupDataDict;
    }

    /**
     * 获取权限组数据字典
     * @return array
     */
    protected function generateAuthGroupNodeDict()
    {
        // 获取所有权限节点数据字典
        $allAuthNodeDataDict = $this->getAllAuthNodeDataDict();

        // 获取所有权限组和权限关联字典
        $allAuthNodeGroupDataDict = $this->getAllAuthGroupNodeDataDict();

        // 获取所有权限分组字典
        $authGroupModel = new AuthGroupModel();
        $allGroupData = $authGroupModel->select();
        $allAuthGroupDataDict = [];
        foreach ($allGroupData as $item) {
            foreach ($allAuthNodeGroupDataDict[$item["id"]] as $nodeId) {
                $allAuthGroupDataDict[$item["id"]]["group"] = $item;
                $allAuthGroupDataDict[$item["id"]]["rules"][] = $allAuthNodeDataDict[$nodeId];
            }
        }

        return $allAuthGroupDataDict;
    }

    /**
     * 获取所有页面关联权限数据字典
     * @return array
     */
    protected function getAllPageLinkAuthDataDict()
    {
        $pageLinkAuthModel = new PageLinkAuthModel();
        $allPageLinkAuthData = $pageLinkAuthModel->select();
        $allPageLinkAuthDataDict = [];
        foreach ($allPageLinkAuthData as $item) {
            $allPageLinkAuthDataDict[$item["page_auth_id"]][] = $item["auth_group_id"];
        }
        return $allPageLinkAuthDataDict;
    }

    /**
     * 获取所有用户权限设置
     * @param int $roleId
     * @return array
     */
    protected function getAllUserAuthAccessDataDict($roleId = 0)
    {
        $authAccessModel = new AuthAccessModel();
        if ($roleId > 0) {
            $authAccessModel->where([
                "role_id" => $roleId
            ]);
        }
        $authAccessData = $authAccessModel->select();
        $allUserAuthAccessDataDict = [];
        foreach ($authAccessData as $item) {
            $allUserAuthAccessDataDict[$item["auth_id"] . "_" . $item["type"]] = $item;
        }
        return $allUserAuthAccessDataDict;
    }

    /**
     * 获取所有权限字段权限映射
     * @param array $filter
     * @return array
     */
    protected function allAuthFieldDataDict($filter = [])
    {
        $authFieldModel = new  AuthFieldModel();
        $authFieldModel->field("id,name,lang,type,project_id,module_id,module_code");

        if (!empty($filter)) {
            $authFieldModel->where($filter);
        }

        $allFields = $authFieldModel->select();
        $allAuthFieldDataDict = [];
        foreach ($allFields as $field) {
            $allAuthFieldDataDict[$field["module_code"]][] = $field;
        }
        return $allAuthFieldDataDict;
    }

    /**
     * 生成字段权限
     * @param $moduleCodeList
     * @param bool $onlyJudgeRole
     * @return array
     */
    protected function generateAuthFieldPermission($moduleCodeList, $onlyJudgeRole = false)
    {
        $fieldPermission = [];
        $authFieldPermissionData = [];
        $allAuthFieldDataDict = $this->allAuthFieldDataDict([
            "module_code" => ["IN", join(",", $moduleCodeList)],
            "project_id" => 0
        ]);
        foreach ($moduleCodeList as $moduleCode) {
            foreach ($allAuthFieldDataDict[$moduleCode] as $field) {
                $permissionList = ["view", "create", "modify", "delete", "clear"];
                foreach ($permissionList as $permissionKey) {
                    $fieldPermission[$permissionKey] = $this->checkAuthFieldPermission($field["id"], $permissionKey, $onlyJudgeRole);
                }
                $field["permission"] = $fieldPermission;
                $authFieldPermissionData[$moduleCode][$field["name"]] = $field;
            }
        }

        return $authFieldPermissionData;
    }

    /**
     * 获取指定项目自定义字段按模块分组
     * @param $projectId
     * @param bool $onlyJudgeRole
     * @return mixed
     */
    protected function getProjectCustomFields($projectId, $onlyJudgeRole = false)
    {
        $authFieldModel = new  AuthFieldModel();
        $projectCustomFields = $authFieldModel->field("id,name,lang,type,project_id,module_id,module_code")
            ->where([
                "project_id" => $projectId,
                "type" => "custom"
            ])
            ->select();

        $moduleIds = array_column($projectCustomFields, "module_id");
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->field("id,code")->where(["id" => ["IN", join(",", $moduleIds)]])->select();
        $moduleMap = array_column($moduleData, "code", "id");

        $fieldPermission = [];
        $authFieldPermissionData = [];
        foreach ($projectCustomFields as $field) {
            $permissionList = ["view", "create", "modify", "delete", "clear"];
            foreach ($permissionList as $permissionKey) {
                $fieldPermission[$permissionKey] = $this->checkAuthFieldPermission($field["id"], $permissionKey, $onlyJudgeRole);
            }
            $field["permission"] = $fieldPermission;
            $authFieldPermissionData[$moduleMap[$field["module_id"]]][$field["name"]] = $field;
        }

        return $authFieldPermissionData;
    }

    /**
     * 组装字段权限表格数据结构
     * @param $data
     * @return array
     */
    protected function generateAuthFieldGridData($data)
    {
        $authFieldGirdData = [];
        foreach ($data as $key => $moduleData) {
            $authFieldGirdData[$key] = [
                "lang" => string_initial_letter($key, '_'),
                "code" => $key,
                "permission" => [
                    "view" => 'deny',
                    "create" => 'deny',
                    "modify" => 'deny',
                    "delete" => 'deny',
                    "clear" => 'deny',
                ],
                "list" => []
            ];
            foreach ($moduleData as $field) {
                $authFieldGirdData[$key]["list"][] = $field;
            }
        }
        return $authFieldGirdData;
    }

    /**
     * 获取页面权限许可
     * @param $pageAuthData
     * @param bool $onlyJudgeRole
     * @param bool $returnString
     * @param string $moduleName
     * @return string
     */
    protected function getPageAuthPermission($pageAuthData, $onlyJudgeRole = false, $returnString = false, $moduleName = '')
    {
        if (!$onlyJudgeRole && (in_array($pageAuthData["code"], $this->onlyAdministratorAllowVisit) || in_array($moduleName, $this->onlyAdministratorAllowVisit))) {
            // 仅仅允许 strack 超级管理员访问模块
            $permission = $this->userId === 1 ? true : false;
        } else {
            if (!$onlyJudgeRole && in_array($this->userId, [1, 2])) {
                // client 客户超级管理员拥有所有权限
                $permission = true;
            } else {
                // 普通用户
                $authPermissionKey = $pageAuthData["id"] . "_page";
                if (array_key_exists($authPermissionKey, $this->allUserAuthAccessDataDict)) {
                    if ($onlyJudgeRole) {
                        $permission = $this->allUserAuthAccessDataDict[$authPermissionKey]["permission"] === 'allow' ? true : false;
                    } else {
                        // 对于页面 allow 和 indeterminate 类型都是可以访问
                        $permission = in_array($this->allUserAuthAccessDataDict[$authPermissionKey]["permission"], ['allow', 'indeterminate']) ? true : false;
                    }
                } else {
                    $permission = false;
                }
            }
        }

        return $this->checkPermissionReturn($permission, $returnString);
    }

    /**
     * 检测字段权限
     * @param $id
     * @param $category
     * @param bool $onlyJudgeRole
     * @return string
     */
    protected function checkAuthFieldPermission($id, $category, $onlyJudgeRole = false)
    {
        $authPermissionKey = $id . "_field";
        if (array_key_exists($authPermissionKey, $this->allUserAuthAccessDataDict)) {
            if (strpos($this->allUserAuthAccessDataDict[$authPermissionKey]["permission"], $category) !== false) {
                return "allow";
            }
        }

        if (!$onlyJudgeRole && in_array($this->userId, [1, 2])) {
            // 超级管理员和客户管理员
            return "allow";
        }

        return "deny";
    }


    /**
     * 判断权限返回数据
     * @param $permission
     * @param bool $returnString
     * @return string
     */
    protected function checkPermissionReturn($permission, $returnString = false)
    {
        // 判断返回类型
        if ($returnString) {
            return $permission ? 'yes' : 'no';
        } else {
            return $permission;
        }
    }

    /**
     * 生成嵌套格式的树形数组
     * @param $OriginalList
     * @param int $root
     * @param bool $onlyJudgeRole
     * @return array
     */
    protected function generatePageAuthTree($OriginalList, $root = 0, $onlyJudgeRole = false)
    {
        $tree = [];//最终数组
        $refer = [];//存储主键与数组单元的引用关系

        // 建立主键与数组单元的引用关系
        foreach ($OriginalList as $key => $value) {
            if (!isset($value["id"]) || !isset($value["parent_id"]) || isset($value["children"])) {
                unset($OriginalList[$key]);
                continue;
            }
            $refer[$value["id"]] =& $OriginalList[$key];//为每个数组成员建立引用关系
        }


        // 生成树
        foreach ($OriginalList as $key => $value) {

            // 获取语言包
            if ($value["type"] === "client") {
                $OriginalList[$key]["text"] = $OriginalList[$key]["lang"];
            } else {
                $OriginalList[$key]["text"] = L($OriginalList[$key]["lang"]);
            }

            if (in_array($value["type"], ["none", "client"])) {
                $OriginalList[$key]["checked"] = $this->getPageAuthPermission($value, $onlyJudgeRole);
            } else {
                if (array_key_exists($value["id"], $this->allPageLinkAuthDataDict)) {
                    foreach ($this->allPageLinkAuthDataDict[$value["id"]] as $groupId) {
                        $OriginalList[$key]["checked"] = $this->getPageAuthPermission($value, $onlyJudgeRole);
                        $OriginalList[$key]["group"] = $this->allAuthGroupDataDict[$groupId]["group"];
                        $OriginalList[$key]["rules"] = $this->allAuthGroupDataDict[$groupId]["rules"];
                    }
                } else {
                    $OriginalList[$key]["checked"] = $this->getPageAuthPermission($value, $onlyJudgeRole);
                }
            }

            if ($value["parent_id"] == $root) {//根分类直接添加引用到tree中
                $tree[] =& $OriginalList[$key];
            } else {
                if (isset($refer[$value["parent_id"]])) {
                    $parent =& $refer[$value["parent_id"]];//获取父分类的引用
                    $parent["children"][] =& $OriginalList[$key];//在父分类的children中再添加一个引用成员
                }
            }
        }
        return $tree;
    }

    /**
     * 获取指定页面所有权限规则
     * @param $pageLinkAuthData
     * @return array
     */
    protected function getPageAllNodeRules($pageLinkAuthData)
    {
        $allNodeRules = [];

        foreach ($pageLinkAuthData as $key => $value) {
            if ($value["type"] !== "none" && array_key_exists($value["id"], $this->allPageLinkAuthDataDict)) {
                foreach ($this->allPageLinkAuthDataDict[$value["id"]] as $groupId) {
                    foreach ($this->allAuthGroupDataDict[$groupId]["rules"] as $rules) {
                        $allNodeRules[md5(strtolower($rules["rules"]))] = $value;
                    }
                }
            }
        }

        return $allNodeRules;
    }

    /**
     * 判断是不是顶部工具栏路由
     * @param $param
     * @return array
     */
    protected function checkWhetherTopToolPanel($param)
    {
        // 获取顶部工具栏相关的路由字典
        $pageAuthModel = new PageAuthModel();
        $topPanelData = $pageAuthModel->where(["menu" => "top_panel"])->select();

        $topPanelPermission = [
            "is_top_panel" => false,
            "permission" => false
        ];
        foreach ($topPanelData as $value) {
            if (array_key_exists($value["id"], $this->allPageLinkAuthDataDict)) {
                foreach ($this->allPageLinkAuthDataDict[$value["id"]] as $groupId) {
                    foreach ($this->allAuthGroupDataDict[$groupId]["rules"] as $rules) {
                        if (md5(strtolower($rules["rules"])) === $param["source_node"]) {
                            $topPanelPermission["is_top_panel"] = true;
                            $topPanelPermission["permission"] = $this->getPageAuthPermission($rules);
                            break;
                        }
                    }
                }
            }
        }

        return $topPanelPermission;
    }

    /**
     * 递归生成页面权限
     * @param $viewRules
     * @param $data
     * @param $prefix
     * @return mixed
     */
    protected function generateViewRules(&$viewRules, $data, &$prefix = '')
    {
        foreach ($data as $rulesItem) {

            if (isset($rulesItem["children"])) {
                if (empty($prefix)) {
                    // 第一层前缀不记录
                    if ($rulesItem["parent_id"] > 0) {
                        $prefix = "{$rulesItem['code']}";
                    }
                    $keyName = "{$rulesItem['code']}";
                } else {
                    $prefix = "{$prefix}__{$rulesItem['code']}";
                    $keyName = $prefix;
                }
                $viewRules[$keyName] = $this->checkPermissionReturn($rulesItem["checked"], true);
                $this->generateViewRules($viewRules, $rulesItem["children"], $prefix);
                // 销毁最后一层前缀
                $prefix = substr($prefix, 0, strripos($prefix, "__"));
            } else {
                $keyName = !empty($prefix) ? "{$prefix}__{$rulesItem['code']}" : $rulesItem['code'];
                $viewRules[$keyName] = $this->checkPermissionReturn($rulesItem["checked"], true);
            }
        }
        return $viewRules;
    }


    /**
     * 获取指定用户角色数据
     * @param $userId
     * @param int $projectId
     * @return array
     */
    public function getUserRoleData($userId, $projectId = 0)
    {

        $notInProjectMember = true;
        $roleData = [];

        if ($projectId > 0) {
            // 查找用户是否在当前项目团队里面
            $projectMemberModel = new ProjectMemberModel();
            $roleId = $projectMemberModel->where(["project_id" => $projectId, "user_id" => $userId])->getField("role_id");
            if ($roleId > 0) {
                $notInProjectMember = false;
                $roleModel = new RoleModel();
                $roleData = $roleModel->field("id,name,code,type")->where(["id" => $roleId])->find();
            }else{
                // 查询当前项目是否公有
                $projectModel = new ProjectModel();
                $public = $projectModel->where(["id"=> $projectId])->getField("public");
                if($public === "no"){
                    $notInProjectMember = false;
                }
            }
        }

        if ($notInProjectMember) {
            $roleUserModel = new RoleUserModel();
            $roleData = $roleUserModel->alias("role_link")
                ->join("LEFT JOIN strack_role role ON role.id = role_link.role_id")
                ->where(["role_link.user_id" => $userId])
                ->field("
                role.id,
                role.name,
                role.code,
                role.type
            ")
                ->find();
        }

        if (!empty($roleData)) {
            return $roleData;
        }
        return [];
    }

    /**
     * 获取指定页面权限数据配置
     * @param $page
     * @param string $param
     * @param bool $onlyJudgeRole
     * @return array
     */
    public function getPageAuthConfig($page, $param = '', $onlyJudgeRole = false)
    {
        // 获取当前页面所有权限
        $pageAuthModel = new PageAuthModel();

        $filter = [
            "page" => $page
        ];
        if (!empty($param)) {
            $filter["param"] = $param;
        }
        $allPageLinkAuthData = $pageAuthModel->where($filter)
            ->order("parent_id asc")
            ->select();

        // 生成权限树
        $pageAuthTree = $this->generatePageAuthTree($allPageLinkAuthData, 0, $onlyJudgeRole);

        return $pageAuthTree;
    }

    /**
     * 验证页面访问权限
     * @param $param
     * @return bool|string
     */
    public function verifyPagePermission($param)
    {
        $pageAuthModel = new PageAuthModel();
        switch ($param["type"]) {
            case "page": // 判断指定页面访问权限
                $pageAuthData = $pageAuthModel->where([
                    "page" => $param["referer_page"],
                    "param" => $param["referer_param"],
                    "parent_id" => 0
                ])->field("id,code")
                    ->find();

                if (array_key_exists($pageAuthData["id"], $this->allPageLinkAuthDataDict)) {
                    $rootPageAuth = $this->getPageAuthPermission($pageAuthData);
                    if ($rootPageAuth && !empty($param["referer_tab_param"])) {
                        // 验证下面 tab权限
                        $category = "tab_{$param["referer_tab_param"]}";
                        $pageTabAuthData = $pageAuthModel->where([
                            "page" => $param["referer_page"],
                            "param" => $param["referer_param"],
                            '_string' => "FIND_IN_SET('{$category}',category)"
                        ])->field("id,code")
                            ->find();

                        if (array_key_exists($pageTabAuthData["id"], $this->allPageLinkAuthDataDict)) {
                            return $this->getPageAuthPermission($pageTabAuthData);
                        }

                        return false;
                    }

                    return $rootPageAuth;
                }

                return false;
                break;
            case "ajax":
                // 先判断是不是顶部工具栏
                $topPanelPermission = $this->checkWhetherTopToolPanel($param);

                if ($topPanelPermission["is_top_panel"]) {
                    return $topPanelPermission["permission"];
                }

                // 判断当前页面下子权限
                $filter = [
                    "page" => $param["referer_page"],
                    "param" => $param["referer_param"],
                ];

                if (!empty($param["referer_tab_param"])) {
                    $filter["_string"] = "FIND_IN_SET('tab_{$param["referer_tab_param"]}',category) OR category = 'tab_{$param["referer_tab_param"]}'";
                }

                $allPageLinkAuthData = $pageAuthModel->where($filter)
                    ->order("parent_id asc")
                    ->select();

                $allNodeRules = $this->getPageAllNodeRules($allPageLinkAuthData);

                if (array_key_exists($param["source_node"], $allNodeRules)) {
                    return $this->getPageAuthPermission($allNodeRules[$param["source_node"]]);
                } else {
                    return false;
                }
                break;
            case "api": //验证api路由权限
                $pageAuthData = $pageAuthModel->where([
                    "page" => $param["referer_page"],
                    "param" => $param["referer_param"]
                ])->field("id,code,param")
                    ->find();

                if (array_key_exists($pageAuthData["id"], $this->allPageLinkAuthDataDict)) {
                    return $this->getPageAuthPermission($pageAuthData, false, false, $param["controller"]);
                }

                return false;
                break;
        }

        return false;
    }

    /**
     * 验证Ajax请求访问权限
     * @param $param
     * @return bool
     */
    public function verifyAjaxPermission($param)
    {
        // 先判断路由所属类型是否是public
        if (array_key_exists($param["source_node"], $this->allAuthNodeDataDict)) {
            $sourceNode = $this->allAuthNodeDataDict[$param["source_node"]];
            if ($sourceNode["public"] === "yes") {
                return true;
            } else {
                // 判断所属页面权限
                return $this->verifyPagePermission($param);
            }
        } else {
            return false;
        }
    }

    /**
     * 获取页面权限
     * @param $page
     * @param string $param
     * @return array|mixed
     */
    public function getPageAuthRules($page, $param = '')
    {
        $pageAuthTree = $this->getPageAuthConfig($page, $param);
        $viewRules = [];
        $viewRules = $this->generateViewRules($viewRules, $pageAuthTree);
        return $viewRules;
    }

    /**
     * 获取指定菜单权限配置
     * @param $menuName
     * @return mixed
     */
    public function getMenuAuthConfig($menuName)
    {
        $pageAuthModel = new PageAuthModel();
        if (strpos($menuName, ",") !== false) {
            $filterOr = [];
            $menuArray = explode(",", $menuName);
            foreach ($menuArray as $menuItem) {
                $filterOr[] = "FIND_IN_SET('{$menuItem}',menu)";
            }
            $filter = join(" OR ", $filterOr);
        } else {
            $filter = "FIND_IN_SET('{$menuName}',menu)";
        }

        $allMenuAuthData = $pageAuthModel->where([
            '_string' => $filter,
        ])->select();

        // 获取权限
        foreach ($allMenuAuthData as &$menuItem) {
            $menuItem["permission"] = $this->getPageAuthPermission($menuItem, false, true);
        }

        return $allMenuAuthData;
    }

    /**
     * 获取多个目录权限列表
     * @param $menuName
     * @return array
     */
    public function getMenuPermission($menuName)
    {
        $pageViewAuth = [];
        $menuPermission = $this->getMenuAuthConfig($menuName);
        foreach ($menuPermission as $item) {
            $pageViewAuth[$item["code"]] = $item["permission"];
        }
        return $pageViewAuth;
    }

    /**
     * 获取指定用户可用访问的项目IDS
     * @param $userId
     */
    public function getAllowAccessProjectIds($userId)
    {

    }

    /**
     * 获取页面权限模块数据
     * @param $menuName
     * @return array
     */
    public function getAuthPageModuleData($menuName)
    {
        $moduleList = [];
        $menuPermission = $this->getMenuAuthConfig($menuName);
        foreach ($menuPermission as $menuItem) {
            if ($menuName === "project") {
                switch ($menuItem["page"]) {
                    case "home_project_entity":
                        $categoryName = L("Entity_Module");
                        $lowerCategory = "entity_module";
                        break;
                    default:
                        $categoryName = L("Fixed_Module");
                        $lowerCategory = "fixed_module";
                        break;
                }
            } else {
                $categoryName = L($menuItem["category"]);
                $lowerCategory = strtolower($menuItem["category"]);
            }
            $menuItem["lang"] = L($menuItem["lang"]);
            if (array_key_exists($lowerCategory, $moduleList)) {
                $moduleList[$lowerCategory]["list"][] = $menuItem;
            } else {
                $moduleList[$lowerCategory] = [
                    "lang" => $categoryName,
                    "list" => [$menuItem]
                ];
            }
        }
        return $moduleList;
    }

    /**
     * 获取字段权限模块数据
     * @return array
     */
    public function getAuthFieldModuleData()
    {
        // 固定页面需要设置字段权限页面
        $needRestrictPages = [
            "fixed_module" => [
                "lang" => L("Fixed_Module"),
                "list" => [
                    ["id" => "fixed_project", "type" => "single", "lang" => L("Project_Setting"), "page" => "project_overview", "param" => ["module_code" => "project"]],
                    ["id" => "fixed_base", "type" => "schema", "lang" => L("Base"), "page" => "project_base", "param" => ["module_code" => "base"]],
                    ["id" => "fixed_note", "type" => "schema", "lang" => L("Note"), "page" => "project_note", "param" => ["module_code" => "note"]],
                    ["id" => "fixed_file", "type" => "schema", "lang" => L("File"), "page" => "project_file", "param" => ["module_code" => "file"]],
                    ["id" => "fixed_file_commit", "type" => "schema", "lang" => L("File_Commit"), "page" => "project_file_commit", "param" => ["module_code" => "file_commit"]],
                    ["id" => "fixed_media", "type" => "schema", "lang" => L("Media"), "page" => "project_media", "param" => ["module_code" => "media"]],
                    ["id" => "fixed_onset", "type" => "schema", "lang" => L("OnSet"), "page" => "project_onset", "param" => ["module_code" => "onset"]],
                    ["id" => "fixed_timelog", "type" => "schema", "lang" => L("Timelog"), "page" => "project_timelog", "param" => ["module_code" => "timelog"]],
                    ["id" => "fixed_member", "type" => "schema", "lang" => L("Project_Member"), "page" => "project_member", "param" => ["module_code" => "project_member"]],
                    ["id" => "fixed_action", "type" => "schema", "lang" => L("Action"), "page" => "admin_action", "param" => ["module_code" => "action"]],
                    ["id" => "fixed_account", "type" => "schema", "lang" => L("User"), "page" => "admin_account", "param" => ["module_code" => "user"]]
                ]
            ]
        ];

        // entity类型需要设置字段权限页面
        $moduleModel = new ModuleModel();

        // 获取系统所有entity模块
        $allEntityModules = $moduleModel->field("id,code")
            ->where(["type" => "entity"])
            ->select();

        $entityModuleList = [];
        foreach ($allEntityModules as $entityModule) {
            $entityModuleList[] = [
                "id" => "entity_{$entityModule['code']}",
                "page" => "project_{$entityModule['code']}",
                "type" => "schema",
                "lang" => L(string_initial_letter($entityModule["code"], '_')),
                "param" => [
                    "module_id" => $entityModule["id"],
                    "module_code" => $entityModule["code"]
                ]
            ];
        }

        $needRestrictPages["entity_module"] = [
            "lang" => L("Entity_Module"),
            "list" => $entityModuleList
        ];

        // 自定义字段按项目来分组
        $variableModel = new VariableModel();
        $projectData = $variableModel->field("project_id")
            ->select();

        $projectIds = array_unique(array_column($projectData, "project_id"));

        // 获取含有自定义字段的项目列表
        $ProjectModel = new ProjectModel();
        $projectData = $ProjectModel->field("id,code,name")
            ->where(["id" => ["IN", join(",", $projectIds)]])
            ->select();

        $projectList = [];
        foreach ($projectData as $projectItem) {
            $projectList[] = [
                "id" => "project_{$projectItem['code']}",
                "page" => '',
                "type" => "custom",
                "lang" => $projectItem["name"],
                "param" => $projectItem
            ];
        }

        // 全局自定义字段
        array_unshift($projectList, [
            "id" => "global_custom_field",
            "page" => '',
            "type" => "custom",
            "lang" => L("Global_Custom_Fields"),
            "param" => [
                "id" => 0
            ]
        ]);

        $needRestrictPages["custom_field"] = [
            "lang" => L("Custom_Fields"),
            "list" => $projectList
        ];

        return $needRestrictPages;
    }

    /**
     * 获取指定模块的权限树
     * @param $param
     * @return array
     */
    public function getAuthModuleRules($param)
    {
        $moduleRules = [];
        $moduleRules["view"] = $this->getPageAuthConfig($param["page"], $param["param"], true);
        return $moduleRules;
    }

    /**
     * 获取字段权限设置
     * @param $param
     * @return array
     */
    public function getAuthFieldRules($param)
    {
        $authFieldPermission = [];
        switch ($param["type"]) {
            case "single":
                // 获取单表字段
                $authFieldPermission = $this->generateAuthFieldPermission([$param["param"]["module_code"]], true);
                break;
            case "schema":
                // 先获取schema配置
                $schemaService = new SchemaService();
                $moduleList = $schemaService->getSchemaRelationModule($param);
                $authFieldPermission = $this->generateAuthFieldPermission($moduleList, true);
                break;
            case "custom":
                // 获取指定项目的自定义字段配置
                $authFieldPermission = $this->getProjectCustomFields($param["param"]["id"], true);
                break;
        }
        $moduleRules = [];
        $moduleRules["column"] = $this->generateAuthFieldGridData($authFieldPermission);
        return $moduleRules;
    }

    /**
     * 获取指定用户所有字段权限
     * @param $userId
     * @return array
     */
    public function getUserAllFieldPermission($userId)
    {
        // 设置用户id
        $this->setUser($userId);

        $fieldPermission = [];
        $authFieldPermissionData = [];
        $allAuthFieldDataDict = $this->allAuthFieldDataDict();
        foreach ($allAuthFieldDataDict as $moduleCode => $fileds) {
            foreach ($fileds as $field) {
                $permissionList = ["view", "create", "modify", "delete", "clear"];
                foreach ($permissionList as $permissionKey) {
                    $fieldPermission[$permissionKey] = $this->checkAuthFieldPermission($field["id"], $permissionKey, false);
                }
                $field["permission"] = $fieldPermission;
                $authFieldPermissionData[$moduleCode][$field["name"]] = $field;
            }
        }

        return $authFieldPermissionData;
    }

    /**
     * 保存角色权限
     * @param $param
     * @return array
     */
    public function saveAuthAccess($param)
    {
        $authAccessModel = new AuthAccessModel();
        if (array_key_exists($param["param"]["role_rule_tab"], $param["config"])) {
            // 保存处理页面权限
            $authAccessModel->startTrans();
            try {
                foreach ($param["config"][$param["param"]["role_rule_tab"]] as $authItem) {

                    if ($param["param"]["role_rule_tab"] === "view") {
                        $filter = [
                            "role_id" => $authItem["role_id"],
                            "auth_id" => $authItem["auth_id"],
                            "page" => $authItem["page"],
                            "type" => "page"
                        ];
                    } else {
                        $filter = [
                            "role_id" => $authItem["role_id"],
                            "auth_id" => $authItem["auth_id"],
                            "page" => $authItem["page"],
                            "param" => $authItem["param"],
                            "module_id" => $authItem["module_id"],
                            "project_id" => $authItem["project_id"],
                            "type" => "field"
                        ];
                    }

                    $authAccessId = $authAccessModel->where($filter)->getField("id");

                    if ($authAccessId > 0) {
                        // 存在则更新
                        $authItem["id"] = $authAccessId;
                        $authAccessModel->modifyItem($authItem);
                    } else {
                        // 不存则在新增
                        $resData = $authAccessModel->addItem($authItem);
                        if (!$resData) {
                            throw new \Exception($authAccessModel->getError());
                        }
                    }
                }

                $authAccessModel->commit(); // 提交事物
            } catch (\Exception $e) {
                $authAccessModel->rollback(); // 事物回滚
                // 修改或新增角色权限失败错误码 001
                throw_strack_exception($e->getMessage(), 218001);
            }
        }

        // 返回成功数据
        return success_response(L("AuthRoleAuth_Add_SC"));
    }

    /**
     * 添加客户端权限节点
     * @param $param ["name"=>"","code"=>"","lang"=>"","parent_id"=>""]
     * @param bool $isRoot
     * @return array
     */
    public function addClientPageAuth($param, $isRoot = false)
    {
        $addData = [
            "name" => $param["name"],
            "code" => $param["code"],
            "lang" => $param["lang"],
            "page" => "api_client_{$param["code"]}",
            "type" => "client",
            "parent_id" => $param["parent_id"],
        ];

        if ($isRoot) {
            // 根节点
            $addData["parent_id"] = 0;
            $addData["menu"] = "client";
            $addData["category"] = "Client_Module";
        }

        $pageAuthModel = new PageAuthModel();
        $resData = $pageAuthModel->addItem($addData);
        if (!$resData) {
            // 添加客户端权限错误码 001
            throw_strack_exception($pageAuthModel->getError(), 218002);
        } else {
            // 返回成功数据
            return success_response($pageAuthModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改客户端权限节点
     * @param $param
     * @return array
     */
    public function updateClientPageAuth($param)
    {
        $param["type"] = "client";
        $pageAuthModel = new PageAuthModel();
        $resData = $pageAuthModel->modifyItem($param);
        if (!$resData) {
            // 添加客户端权限错误码 001
            throw_strack_exception($pageAuthModel->getError(), 218003);
        } else {
            // 返回成功数据
            return success_response($pageAuthModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除客户端节点
     * @param $param
     * @return array
     */
    public function deleteClientPageAuth($param)
    {
        $pageAuthModel = new PageAuthModel();
        $param["type"] = "client";
        $currentData = $pageAuthModel->findData(["filter" => $param]);
        if (empty($currentData)) {
            throw_strack_exception("Illegal_Operation", 218004);
        }
        //查找子节点信息
        $filterParam = ["filter" => ["parent_id" => $param["id"], "type" => "client"]];
        $childNodeData = $pageAuthModel->selectData($filterParam);
        $deleteIds = empty($childNodeData["rows"]) ? [$param["id"]] : array_merge(array_column($childNodeData["rows"], "id"), [$param["id"]]);
        $resData = $pageAuthModel->deleteItem(["id" => ["IN", join(",", $deleteIds)], "type" => "client"]);
        if (!$resData) {
            // 删除客户端权限错误码 005
            throw_strack_exception($pageAuthModel->getError(), 218005);
        } else {
            // 返回成功数据
            return success_response($pageAuthModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 查找多条客户端节点权限
     * @param $param
     * @return array
     */
    public function selectClientPageAuth($param)
    {
        $param["filter"]["type"] = "client";
        $pageAuthModel = new PageAuthModel();
        $resData = $pageAuthModel->selectData($param);
        if (!$resData) {
            // 删除客户端权限错误码 006
            throw_strack_exception($pageAuthModel->getError(), 218006);
        } else {
            // 返回成功数据
            return success_response($pageAuthModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 保存实体权限
     * @param $moduleData
     * @throws \Exception
     */
    public function addEntityAuthData($moduleData)
    {
        // 获取权限模版 保存路由权限
        $data = $this->authEntityTemplate($moduleData);
        $this->savePageAuth($data);
        // 保存字段权限
        $this->saveFieldAuth($moduleData);
    }

    /**
     * 删除实体相关的权限
     * @param $moduleId
     * @return array
     */
    public function deleteEntityAuthData($moduleId)
    {
        $pageAuthModel = new PageAuthModel();
        $pageLinkAuthModel = new PageLinkAuthModel();
        $authFieldModel = new AuthFieldModel();

        $pageAuthListData = $pageAuthModel->selectData([
            "filter" => ["param" => $moduleId],
            "fields" => "id"
        ]);
        $authPageIds = array_column($pageAuthListData["rows"], "id");

        $pageLinkAuthModel->startTrans();
        try {

            $pageLinkResult = $pageLinkAuthModel->deleteItem(["page_auth_id" => ["IN", join(",", $authPageIds)]]);
            if (!$pageLinkResult) {
                throw new \Exception($pageLinkAuthModel->getError());
            } else {

                // 删除页面权限
                $pageAuthResult = $pageAuthModel->deleteItem(["param" => '' . $moduleId . '']);
                if (!$pageAuthResult) {
                    throw new \Exception($pageAuthModel->getError());
                }

                // 删除字段权限
                $authFieldResult = $authFieldModel->deleteItem(["module_id" => $moduleId]);
                if (!$authFieldResult) {
                    throw new \Exception($authFieldModel->getError());
                }

                // 删除水平关联配置数据
                $horizontalConfigModel = new HorizontalConfigModel();
                $horizontalConfigResult = $horizontalConfigModel->deleteItem([
                    ["src_module_id" => $moduleId],
                    ["dst_module_id" => $moduleId],
                    '_logic' => "OR"
                ]);
                if (!$horizontalConfigResult) {
                    throw new \Exception($horizontalConfigModel->getError());
                }
            }
            $pageLinkAuthModel->commit();
            // 返回成功数据
            return success_response($pageLinkAuthModel->getSuccessMassege());
        } catch (\Exception $e) {
            $pageLinkAuthModel->rollback();
            // 删除Schema失败错误码 007
            throw_strack_exception($e->getMessage(), 223017);
        }
    }

    /**
     * 实体权限模版
     * @param $moduleData
     * @return array
     * @throws \Exception
     */
    protected function authEntityTemplate($moduleData)
    {
        $moduleId = $moduleData["id"];

        // 权限数据
        $homeEntityPageRows = [
            'page' => [
                'name' => L($moduleData["code"]) . '页面',
                'code' => $moduleData["code"],
                'lang' => string_initial_letter($moduleData["code"], '_'),
                'page' => 'home_project_entity',
                'menu' => 'top_menu,project',
                'param' => $moduleId,
                'type' => 'children',
                'parent_id' => 0,
                'uuid' => create_uuid()
            ],
            'auth_group' => [
                [ // 页面路由
                    'page_auth_id' => 0,
                    'auth_group_id' => 194,
                    'uuid' => create_uuid()
                ]
            ],
            'list' => [
                [
                    'page' => [
                        'name' => L($moduleData["code"]) . '页面访问',
                        'code' => 'visit',
                        'lang' => 'Visit',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 194,
                            'uuid' => create_uuid()
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '修改单个组件',
                        'code' => 'update_widget',
                        'lang' => 'Update_Widget',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'belong',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ],
                    'auth_group' => [
                        [ // 页面路由
                            'page_auth_id' => 0,
                            'auth_group_id' => 171,
                            'uuid' => create_uuid()
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '工具栏',
                        'code' => 'toolbar',
                        'lang' => 'Toolbar',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '创建',
                                'code' => 'create',
                                'lang' => 'Create',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 1,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '编辑',
                                'code' => 'edit',
                                'lang' => 'Edit',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '分配任务',
                                        'code' => 'add_task',
                                        'lang' => 'Add_Task',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 128,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '批量编辑',
                                        'code' => 'batch_edit',
                                        'lang' => 'Batch_Edit',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 2,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '批量删除',
                                        'code' => 'batch_delete',
                                        'lang' => 'Batch_Delete',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 123,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '批量添加反馈',
                                        'code' => 'batch_add_note',
                                        'lang' => 'Batch_Add_Note',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 449,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '动作',
                                        'code' => 'action',
                                        'lang' => 'Action',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 3,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '导入Excel',
                                        'code' => 'import_excel',
                                        'lang' => 'Import_Excel',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 4,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '导出Excel',
                                        'code' => 'export_excel',
                                        'lang' => 'Export_Excel',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 5,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '修改缩略图',
                                        'code' => 'modify_thumb',
                                        'lang' => 'Modify_Thumb',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 6,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '清除缩略图',
                                        'code' => 'clear_thumb',
                                        'lang' => 'Clear_Thumb',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 7,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '排序',
                                'code' => 'sort',
                                'lang' => 'Sort',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 8,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '分组',
                                'code' => 'group',
                                'lang' => 'Group',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 9,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '字段',
                                'code' => 'column',
                                'lang' => 'Field',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '管理自定义字段',
                                        'code' => 'manage_custom_fields',
                                        'lang' => 'Manage_Custom_Fields',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 10,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '工序',
                                'code' => 'step',
                                'lang' => 'Step',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 129,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '视图',
                                'code' => 'view',
                                'lang' => 'View',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '保存默认视图',
                                        'code' => 'save_default_view',
                                        'lang' => 'Save_Default_View',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 456,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '保存视图',
                                        'code' => 'save_view',
                                        'lang' => 'Save_View',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 11,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '另存为视图',
                                        'code' => 'save_as_view',
                                        'lang' => 'Save_As_View',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 12,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '修改视图',
                                        'code' => 'modify_view',
                                        'lang' => 'Modify_View',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 13,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '删除视图',
                                        'code' => 'delete_view',
                                        'lang' => 'Delete_View',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 14,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [ // 过滤面板
                    'page' => [
                        'name' => '过滤面板',
                        'code' => 'filter_panel',
                        'lang' => 'Filter_Panel',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '保存过滤条件',
                                'code' => 'save_filter',
                                'lang' => 'Save_Filter',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 16,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '保持显示',
                                'code' => 'keep_display',
                                'lang' => 'Keep_Display',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 187,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '置顶过滤',
                                'code' => 'stick_filter',
                                'lang' => 'Stick_Filter',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 191,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '删除过滤',
                                'code' => 'delete',
                                'lang' => 'Delete',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'belong',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'auth_group' => [
                                [
                                    'page_auth_id' => 0,
                                    'auth_group_id' => 192,
                                    'uuid' => create_uuid()
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'page' => [
                        'name' => '右键菜单',
                        'code' => 'right_button_menu',
                        'lang' => 'Right_Button_Menu',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ]
                ],
                [
                    'page' => [
                        'name' => '边侧栏',
                        'code' => 'side_bar',
                        'lang' => 'Side_Bar',
                        'page' => 'home_project_entity',
                        'param' => $moduleId,
                        'type' => 'children',
                        'parent_id' => 0,
                        'uuid' => create_uuid()
                    ],
                    'list' => [
                        [
                            'page' => [
                                'name' => '顶部面板',
                                'code' => 'top_panel',
                                'lang' => 'Top_Panel',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => create_uuid(),
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '字段配置',
                                        'code' => 'fields_rules',
                                        'lang' => 'Fields_rules',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 168,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '上一个/下一个',
                                        'code' => 'prev_next_one',
                                        'lang' => 'Prev_Next_One',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 169,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '动作',
                                        'code' => 'action',
                                        'lang' => 'Action',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 3,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '记录Timelog',
                                        'code' => 'timelog',
                                        'lang' => 'Timelog',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 193,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '修改缩略图',
                                        'code' => 'modify_thumb',
                                        'lang' => 'Modify_Thumb',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 6,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '清除缩略图',
                                        'code' => 'clear_thumb',
                                        'lang' => 'Clear_Thumb',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'belong',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 7,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'page' => [
                                'name' => '标签栏',
                                'code' => 'tab_bar',
                                'lang' => 'Tab_Bar',
                                'page' => 'home_project_entity',
                                'param' => $moduleId,
                                'type' => 'children',
                                'parent_id' => 0,
                                'uuid' => create_uuid()
                            ],
                            'list' => [
                                [
                                    'page' => [
                                        'name' => '反馈',
                                        'code' => 'note',
                                        'lang' => 'Note',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 124,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '信息',
                                        'code' => 'info',
                                        'lang' => 'Info',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 170,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    'list' => [
                                        [
                                            'page' => [
                                                'name' => '修改单个组件信息',
                                                'code' => 'modify',
                                                'lang' => 'Modify',
                                                'page' => 'home_project_entity',
                                                'param' => $moduleId,
                                                'type' => 'belong',
                                                'parent_id' => 0,
                                                'uuid' => create_uuid()
                                            ],
                                            'auth_group' => [
                                                [
                                                    'page_auth_id' => 0,
                                                    'auth_group_id' => 171,
                                                    'uuid' => create_uuid()
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '现场数据',
                                        'code' => 'onset',
                                        'lang' => 'Onset',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 172,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '历史记录',
                                        'code' => 'history',
                                        'lang' => 'History',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 176,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '设置标签栏',
                                        'code' => 'template_fixed_tab',
                                        'lang' => 'Template_Fixed_Tab',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 177,
                                            'uuid' => create_uuid()
                                        ]
                                    ]
                                ],
                                [
                                    'page' => [
                                        'name' => '任务',
                                        'code' => 'base',
                                        'lang' => 'Base',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 457,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '云盘',
                                        'code' => 'cloud_disk',
                                        'lang' => 'Cloud_Disk',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 467,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '文件',
                                        'code' => 'file',
                                        'lang' => 'File',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 173,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '文件提交批次',
                                        'code' => 'commit',
                                        'lang' => 'File_Commit',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 148,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '相关任务',
                                        'code' => 'correlation_task',
                                        'lang' => 'Correlation_Task',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 174,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ],
                                [
                                    'page' => [
                                        'name' => '水平关联表格',
                                        'code' => 'horizontal_relationship',
                                        'lang' => 'Horizontal_Relationship',
                                        'page' => 'home_project_entity',
                                        'param' => $moduleId,
                                        'type' => 'children',
                                        'parent_id' => 0,
                                        'uuid' => create_uuid()
                                    ],
                                    'auth_group' => [
                                        [
                                            'page_auth_id' => 0,
                                            'auth_group_id' => 175,
                                            'uuid' => create_uuid()
                                        ]
                                    ],
                                    "list" => []
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $homeEntityPageRows;
    }

    /**
     * 保存权限组
     * @param $data
     * @param int $parentId
     */
    protected function savePageAuth($data, $parentId = 0)
    {
        $pageAuthModel = new PageAuthModel();
        $pageLinkAuthModel = new PageLinkAuthModel();

        $data["page"]["parent_id"] = $parentId;

        $resData = $pageAuthModel->addItem($data["page"]);

        if (!empty($data["auth_group"])) {
            foreach ($data["auth_group"] as $authGroup) {
                $authGroup["page_auth_id"] = $resData["id"];
                $pageLinkAuthModel->addItem($authGroup);
            }
        }

        if (!empty($data["list"])) {
            foreach ($data["list"] as $children) {
                $this->savePageAuth($children, $resData["id"]);
            }
        }
    }

    /**
     * 注册权限字段
     * @param $moduleData
     * @return array|bool|mixed
     * @throws \Exception
     */
    protected function saveFieldAuth($moduleData)
    {
        $authFieldModel = new AuthFieldModel();
        $moduleCode = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];

        $fieldModel = new FieldModel();
        $fieldConfig = $fieldModel->getTableFieldsConfig($moduleCode);

        $resData = [];
        foreach ($fieldConfig as $field) {
            $fieldData = [
                "name" => $field["fields"],
                "lang" => $field["lang"],
                "type" => "built_in",
                "project_id" => 0,
                "module_id" => $moduleData["id"],
                "module_code" => $moduleData["code"],
                'uuid' => create_uuid()
            ];
            $resData = $authFieldModel->addItem($fieldData);
            if (!$resData) {
                throw new \Exception($authFieldModel->getError());
            }
        }
        return $resData;
    }

}