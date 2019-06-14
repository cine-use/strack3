<?php

namespace Test\Controller;

use Common\Model\FileModel;
use JJG\InvalidArgumentException;
use Think\Controller;

use StrackAuth\Manager\RuleManager;
use StrackAuth\Rules\Rule;
use Dms\Server;
use PHPMailer\PHPMailer\PHPMailer;


use Think\Request;
use PragmaRX\Google2FA\Google2FA;
use Common\Model\ModuleRelationModel;

use Common\Middleware\MessageMiddleware;

class IndexController extends Controller
{

    public function testMassageHook()
    {
        MessageMiddleware::register(["test" => 11111]);
    }

    public function testModify()
    {
        $fileModel = new FileModel();
        $response = $fileModel->modifyItem([
            'id' => 1111111,
            'name' => 'wwwwwwwww'
        ]);

        dump($response);
        dump(22222333);
        dump($fileModel->getError());
    }

    /**
     * @throws \Exception
     */
    public function testUuid(){
        var_dump(create_uuid());
    }



    public function checkField()
    {
        $result = D("Field")->checkTableField("strack_base", "project_id");
        var_dump($result);
    }

    public function moduleRelation()
    {
        $moduleRelationOptions = [
            'filter' => ["schema_id" => 1]
        ];
        $moduleRelationModule = new ModuleRelationModel();
        $moduleRelationData = $moduleRelationModule->selectData($moduleRelationOptions);
        $schemaList = [
            "nodes" => [],
            "edges" => [],
            "ports" => [],
            "groups" => [],
        ];
        foreach ($moduleRelationData["rows"] as $moduleRelationItem) {
            $nodeConfig = json_decode($moduleRelationItem['node_config'], true);
            array_push($schemaList["nodes"], $nodeConfig["node_data"]['source']);
            array_push($schemaList["nodes"], $nodeConfig["node_data"]['target']);
            array_push($schemaList["edges"], $nodeConfig['edges']);
        }
        dump($schemaList);
    }

    public function mfa_test()
    {
        $google2fa = new Google2FA();

        $secretKey = $google2fa->generateSecretKey();

        $inlineUrl = $google2fa->getQRCodeInline(
            'cineuse',
            'weijer@foxmail.com',
            $secretKey
        );

        var_dump('<img src="' . $inlineUrl . '">');
    }

    public function request_test()
    {
//        $request = Request::instance();
//        $param = $request->param();
//        var_dump($param);

        $pageNumber = 1;
        $pageSize = 100;
        $resData = D('Common/Status', 'Service');

        $allowModel = [
            "User" => [
                "grid_func" => "getUserGridData"
            ],
            "Note" => [
                "grid_func" => "getUserGridData"
            ],
            "Disk" => [
            ],
            "Base" => [
                "grid_func" => "getUserGridData"
            ],
            "Project" => [
                "grid_func" => "getUserGridData"
            ]
        ];

        if(array_key_exists("grid_func", $allowModel[$moduleName])){
            call_user_func();
        }
    }

    /**
     * 检测密码强度
     */
    public function password_strength2($string)
    {
        $h = 0;
        $size = strlen($string);

        $strength = 0;

        if ($size >= 8) {
            foreach (count_chars($string, 1) as $v) {   //count_chars：返回字符串所用字符的信息
                $p = $v / $size;
                $h -= $p * log($p) / log(2);
            }
            $strength = ($h / 4) * 100;
            if ($strength > 100) {
                $strength = 100;
            }
        }

        return ["size" => $size, "strength" => $strength];
    }


    /**
     * o   制定由以下内容组成的密码政策：
     * o   最小密码长度为 8 个字符
     * o   以下参数至少需包含 3 个：大写字母、小写字母、数字及特殊字符
     * o   密码最多可用 90 天
     * o   密码最少可用 1 天
     * o   最多 3 到 5 次无效登录尝试
     * o   如果用户账户因无效登录尝试而被锁定，应手动解除锁定，不得在一段时间后自动解除锁定
     * o   之前 10 个密码的密码使用记录
     */

    /**
     * 检查密码是否符合指定强度，必须大于8位，并且必须包含数字，字母和特殊字符
     * @param $password
     * @return array|bool
     */
    function password_strength($password)
    {
        if (strlen($password) < 8) {
            // 密码长度必须大于8位
            return false;
        }

        $score = 0;

        if (preg_match('/[0-9]+/', $password) === 1) {
            //包含数字
            $score++;
        }

        if (preg_match('/[a-z]+/', $password) === 1) {
            //包含小写字母
            $score++;
        }

        if (preg_match('/[A-Z]+/', $password) === 1) {
            //包含大写写字母
            $score++;
        }

        if (preg_match('/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/', $password) === 1) {
            //包含特殊字符
            $score++;
        }

        //判断密码强度，必须大于三分
        if ($score < 3) {
            return false;
        } else {
            return true;
        }
    }

    function checkTeleNumber($number, $type = 'phone')
    {
        $regxArr = array(
            'phone' => '/^(\+?86-?)?(18|15|13)[0-9]{9}$/',
            'telephone' => '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',
            '400' => '/^400(-\d{3,4}){2}$/',
        );
        if ($type && isset($regxArr[$type])) {
            return preg_match($regxArr[$type], $number) ? true : false;
        }
        foreach ($regxArr as $regx) {
            if (preg_match($regx, $number)) {
                return true;
            }
        }
        return false;
    }


    public function check_email()
    {
        $phone = '+8618210589458';
        if ($this->checkTeleNumber($phone)) {
            echo '正确手机号码';
        } else {
            echo '错误手机号码';
        }
    }


    public function check_password_strength()
    {
        $value = "1234567_a";

        $result = $this->password_strength($value);

        var_dump($result);
    }


    //测试前后端分离
    public function test_webapp()
    {
        $test = [
            "text" => "测试前后端分离,后端数据返回！",
        ];
        json($test);
    }

    //测试composer文件自动加载
    public function test_composer()
    {
//        $excel = \PHPExcel_IOFactory::createReader('csv');
//        var_dump($excel);

//        $mpdf = new \Mpdf\Mpdf();
//        $mpdf->WriteHTML('<h1>Hello world!</h1>');
//        $mpdf->Output();

        //$mail = new PHPMailer(true);

//        $client = new \Predis\Client();
//
//        var_dump($client);
    }

    public function testFilter()
    {
        $filter = [
            "group" => ["field" => "", "module_code" => "", "table" => ""],
            "sort" => [
                ["field" => "", "order" => "asc", "module_code" => "", "table" => ""],
                ["field" => "", "order" => "desc", "module_code" => "", "table" => ""]
            ],
            "request" => [//and 关系
                ["field" => "user_id", "value" => "1,2", "condition" => "NOT IN", "module_code" => "", "table" => ""]
            ],
            "filter_input" => [// or关系
//                ["field" => "name", "editor" => "text", "value" => "niu22", "condition" => "LIKE", "module_code" => "user", "module_type" => "", "table" => "User"],
//                ["field" => "name", "editor" => "text", "value" => "Co", "condition" => "LIKE", "module_code" => "user_department", "module_type" => "", "table" => "UserDepartment"],
//                ["field" => "name", "editor" => "text", "value" => "Film", "condition" => "LIKE", "module_code" => "user_scope", "module_type" => "", "table" => "UserScope"],
            ],
            "filter_panel" => [//and关系
//                ["field" => "name", "editor" => "text", "value" => "3332", "condition" => "NEQ", "module_code" => "user", "module_type" => "user", "table" => "User"],
//                ["field" => "name", "editor" => "text", "value" => "Co", "condition" => "LIKE", "module_code" => "user_department", "module_type" => "user_department", "table" => "UserDepartment"],
//                ["field" => "status", "editor" => "combobox", "value" => "in_service", "condition" => "EQ", "module_code" => "user", "module_type" => "user", "table" => "User"],
//                ["field" => "created", "editor" => "datebox", "value" => "2018-01-19", "condition" => "GT", "module_code" => "user", "module_type" => "user", "table" => "User"],
//                ["field" => "name", "editor" => "text", "value" => "Film", "condition" => "EQ", "module_code" => "user_scope", "module_type" => "user_scope", "table" => "UserScope"],
//                ["field" => "last_visit", "editor" => "datebox", "value" => "2018-01-05,2018-01-31", "condition" => "BETWEEN", "module_code" => "user", "module_type" => "user", "table" => "User"]
            ],
            "filter_advance" => [//根据情况来反应

            ]
        ];

        //一层高级查询条件
        $filter["filter_advance"] = [
            ["field" => "status", "module_code" => "user", "module_type" => "user", "table" => "User", "condition" => "IN", "value" => "departing,in_service", "editor" => "combobox"],
            ["field" => "name", "module_code" => "user_department", "module_type" => "user_department", "table" => "UserDepartment", "condition" => "LIKE", "value" => "Co", "editor" => "text"],
            ["field" => "name", "module_code" => "user_scope", "module_type" => "user_scope", "table" => "UserScope", "condition" => "LIKE", "value" => "Film", "editor" => "text"],
            "logic" => "and",
            "number" => 1
        ];
        //多层
        $filter["filter_advance"] = [
            [
                ["field" => "status", "module_code" => "user", "module_type" => "user", "table" => "User", "condition" => "IN", "value" => "departing,in_service", "editor" => "combobox"],
                ["field" => "name", "module_code" => "user_department", "module_type" => "user_department", "table" => "UserDepartment", "condition" => "LIKE", "value" => "Co", "editor" => "text"],
                ["field" => "name", "module_code" => "user_scope", "module_type" => "user_scope", "table" => "UserScope", "condition" => "LIKE", "value" => "Film", "editor" => "text"],
                "logic" => "or",
            ],
            [
                ["field" => "status", "module_code" => "user", "module_type" => "user", "table" => "User", "condition" => "IN", "value" => "departing,in_service", "editor" => "combobox"],
                ["field" => "name", "module_code" => "user_department", "module_type" => "user_department", "table" => "UserDepartment", "condition" => "LIKE", "value" => "Co", "editor" => "text"],
                ["field" => "name", "module_code" => "user_scope", "module_type" => "user_scope", "table" => "UserScope", "condition" => "LIKE", "value" => "Film", "editor" => "text"],
                "logic" => "and",
            ],
            "logic" => "and",
            "number" => 3
        ];
        D("User")->testBuildFilter($filter);
    }

    public function testCloumn()
    {
        $resData = A('WebApp/View')->getGridFieldConfig('user', 'user');
        dump($resData);
    }

    public function testNote()
    {
        $filter = [
            "link_id" => 1,
            "module_id" => 2,
            "module_type" => "assembly",
        ];
        D("Note")->getNoteList($filter, 1, 100);
    }

    public function testStructure()
    {
//        $structureId = 3;
//        $moduleCode = "episode";
//        $moduleType = "assembly";
//        $page = "episode_main_grid";
//        $projectId = 1;
//        $structureId = 4;
//        $moduleCode = "sequence";
//        $moduleType = "assembly";
//        $page = "sequence_main_grid";
//        $projectId = 1;


//        $structureId = 13;
//        $moduleCode = "task";
//        $moduleType = "base";
//        $page = "task_main_grid_1";
//        $projectId = 1;


        $structureId = 0;
        $moduleCode = "user";
        $moduleType = "user";
        $page = "admin_account";
        $projectId = 1;

        $resData = A("WebApp/View")->generateColumnConfig($page, $moduleCode, $moduleType, [], $projectId, $structureId);
        // dump($resData);


    }

    public function editField()
    {
        $moduleId = 9;
        $moduleType = "base";
        $moduleCode = "task";
        $structureId = 13;
        $projectId = 1;
        $mode = "create";
        $page = "task_main_grid_1";
        $resData = A('WebApp/View')->testGetEditFields($page, $moduleId, $moduleType, $moduleCode, $structureId, $projectId, $mode);
    }

    public function testQuery()
    {
        $filterInput = [
            "field" => "custom_text",
            "field_type" => "custom",
            "variable_id" => 7,
            "editor" => "text",
            "value" => "2",
            "condition" => "LIKE",
            "module_code" => "episode_custom",
            "table" => "variable_value"
        ];

        $filterAdvance = [
            [
                "field" => "custom_checkbox",
                "field_type" => "custom",
                "variable_id" => 15,
                "module_code" => "episode_custom",
                "module_type" => "assembly",
                "remote" => "episode",
                "value_show" => "episode_custom_checkbox",
                "table" => "variable_value",
                "condition" => "EQ",
                "value" => "off",
                "editor" => "checkbox"
            ],
            "logic" => "and",
            "number" => 1
        ];

        $page = "episode_main_grid_1";
        $moduleCode = "episode";
        $moduleType = "assembly";
        $filter = [
            "fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [["field" => "project_id", "value" => "1", "condition" => "EQ", "module_code" => "episode", "table" => "Entity"]],
            "filter_input" => [
            ],
            "filter_panel" => [],
            "filter_advance" => $filterAdvance
        ];

        $projectId = 1;
        $structureId = 3;
        $moduleId = 1;

        $queryConfig = A('WebApp/View')->getGridFieldConfig($page, $moduleCode, $moduleType, ["fields" => $filter["fields"], "group" => $filter["group"]], $projectId, $structureId);
        $resData = D('Entity')->getAssemblyGridData($moduleId, 'episode', $queryConfig, $filter, 1, 100);

    }

    public function testGetListViewConfig()
    {
        $userId = 1;
        $page = "episode_main_list_1";
        $moduleCode = "episode";
        $moduleType = "assembly";
        $projectId = 1;
        $structureId = 3;
        $resData = A('WebApp/View')->testGetListViewConfig($projectId, $userId, $page, $moduleCode, $moduleType, $structureId);
    }


    public function testPanelData()
    {
        $userId = session("user_id");
        $page = "episode_main_grid_1";
        $moduleCode = "episode";
        $moduleType = "assembly";
        $projectId = 1;
        $structureId = 3;

        $resData = A('WebApp/View')->testGetGridPanelData($userId, $page, $moduleCode, $moduleType, $projectId, $structureId);
        //dump($resData);
    }

    public function testGetTable()
    {
        $all = D("Field")->getTables();
        dump($all);
        $filed = D("Field")->getFields("strack_user");
        dump($filed);
    }

    public function testUploadVideo()
    {
        echo md5("sssss") . PHP_EOL;
        echo md5("6K2VHv9RhYQeh20H96ClO43rO" . "9GqQnvlQxmDpJpJKYDS3LwbOc");
    }

    public function homeLogin()
    {
        $param = [
            "user_login_name" => "strack_admin",
            "password" => "chengwei5566"
        ];
        $resData = D('User')->homeLogin($param);
        dump($resData);
    }

    public function testGetUpload()
    {
        $param = [
            "name" => "1a7146f72eec2df52117a56bcbeb21d6"
        ];
        $Image = new Server([
            "request_address" => 'http://192.168.1.109:8106',
            "access_key" => "6K2VHv9RhYQeh20H96ClO43rO",
            "secret_key" => "9GqQnvlQxmDpJpJKYDS3LwbOc",
            "provider" => "local"
        ]);

        $data = $Image->getPath($param);
        dump($data);
    }

    public function testUpload()
    {
        $param = [
            "file" => [
                "media" => "/strack/wwwroot/default/strack/Public/images/excel/bid_excel.png"
            ],
            "data" => [
                "name" => "1a7146f72eec2df52117a56bcbeb21d6",
                "size" => "100x100",
                "extension" => "jpg"
            ]
        ];
        $Image = new Server([
            "request_address" => 'http://192.168.1.128:8106',
            "access_key" => "6K2VHv9RhYQeh20H96ClO43rO",
            "secret_key" => "9GqQnvlQxmDpJpJKYDS3LwbOc",
            "provider" => "local"
        ]);

        $data = $Image->uploadImage($param);
        dump($data);
    }

    //
    public function testRequest()
    {
        $Image = new Server([
            "request_address" => 'http://192.168.1.103:8106',
            "access_key" => "6K2VHv9RhYQeh20H96ClO43rO",
            "secret_key" => "9GqQnvlQxmDpJpJKYDS3LwbOc",
            "provider" => "local"]);
        $data = $Image->getPath(["name" => "1a7146f72e5c2df52117a56bcbeb21d6", "size" => "90x90", "extension" => "jpg"]);
        dump($data);
    }

    public function getAssemblyData()
    {
        $page = "episode_main_grid_1";
        $moduleId = 1;
        $moduleCode = "episode";
        $structureId = 3;
        $moduleType = "assembly";
        $projectId = 1;

        $pageNumber = 1;
        $pageSize = 100;
        $filter = ["fields" => ["add" => [], "cut" => []], "group" => "", "sort" => [], "request" => [["field" => "project_id", "value" => "1", "condition"
        => "EQ", "module_code" => "episode", "table" => "Entity"]], "filter_input" => [], "filter_panel" => [], "filter_advance"
        => []];

        $queryConfig = A('WebApp/View')->getGridFieldConfig($page, $moduleCode, $moduleType, ["fields" => $filter["fields"], "group" => $filter["group"]], $projectId, $structureId);
        $resData = D('Entity')->getAssemblyGridData($moduleId, $moduleCode, $queryConfig, $filter, $pageNumber, $pageSize);
    }


    public function getUserGridData()
    {
        $pageNumber = 1;
        $pageSize = 100;
        $filter = [
            "fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [
                ["field" => "user_id", "value" => "1,2", "condition" => "NOT IN", "module_code" => "user", "table" => "User"]
            ],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance"
            => []];


        $queryConfig = A('WebApp/View')->getGridFieldConfig('admin_account', 'user', 'user', ["fields" => $filter["fields"], "group" => $filter["group"]]);


        $resData = D('User')->getUserGridData(0, 'user', $queryConfig, $filter, $pageNumber, $pageSize);

//        dump($resData);

    }

    public function getEntityBaseData()
    {
        $page = "shot_main_list_1";
        $moduleId = 9;
        $moduleCode = "task";
        $structureId = 6;
        $moduleType = "base";
        $projectId = 1;

        $pageNumber = 1;
        $pageSize = 100;
        $filter = [
            "fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [
                ["field" => "project_id", "value" => "1", "condition" => "EQ", "module_code" => "task", "table" => "Base"],
                ["field" => "module_id", "value" => "9", "condition" => "EQ", "module_code" => "task", "table" => "Base"],
                ["field" => "module_id", "value" => "6", "condition" => "EQ", "module_code" => "shot", "table" => "Entity"]
            ],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance"
            => []];

        $queryConfig = A('WebApp/View')->getGridFieldConfig($page, $moduleCode, $moduleType, ["fields" => $filter["fields"], "group" => $filter["group"]], $projectId, $structureId);
        $resData = D('Base')->getBaseGridData($moduleId, $moduleCode, $queryConfig, $filter, $pageNumber, $pageSize);

//        dump($resData);
    }

    public function getBaseData()
    {
        $page = "task_main_grid_1";
        $moduleId = 9;
        $moduleCode = "task";
        $structureId = 13;
        $moduleType = "base";
        $projectId = 1;

        $pageNumber = 1;
        $pageSize = 100;
        $filter = [
            "fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [
                ["field" => "project_id", "value" => "1", "condition" => "EQ", "module_code" => "task", "table" => "Base"],
                ["field" => "module_id", "value" => "9", "condition" => "EQ", "module_code" => "task", "table" => "Base"]
            ],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance"
            => []
        ];

        $queryConfig = A('WebApp/View')->getGridFieldConfig($page, $moduleCode, $moduleType, ["fields" => $filter["fields"], "group" => $filter["group"]], $projectId, $structureId);
        $resData = D('Base')->getBaseGridData($moduleId, $moduleCode, $queryConfig, $filter, $pageNumber, $pageSize);

//        dump($resData);
    }


    public function getEntityata()
    {
        $page = "shot_main_grid_1";
        $moduleId = 6;
        $moduleCode = "shot";
        $structureId = 5;
        $moduleType = "entity";
        $projectId = 1;

        $pageNumber = 1;
        $pageSize = 100;
        $filter = [
            "fields" => ["add" => [], "cut" => []],
            "group" => "",
            "sort" => [],
            "request" => [
                ["field" => "project_id", "value" => "1", "condition" => "EQ", "module_code" => "shot", "table" => "Entity"],
                ["field" => "module_id", "value" => "6", "condition" => "EQ", "module_code" => "shot", "table" => "Entity"]
            ],
            "filter_input" => [],
            "filter_panel" => [],
            "filter_advance"
            => []
        ];

        $queryConfig = A('WebApp/View')->getGridFieldConfig($page, $moduleCode, $moduleType, ["fields" => $filter["fields"], "group" => $filter["group"]], $projectId, $structureId);


        $resData = D('Entity')->getEntityGridData($moduleId, $moduleCode, $queryConfig, $filter, $pageNumber, $pageSize);

        dump($resData);
    }

    //测试集数据
    public function testAssembly()
    {
        $param = [
            "name" => "test_assembly2",
            "code" => "test_assembly2",
            "module_id" => 5020,
            "project_id" => 1,
            "status_id" => 2
        ];
        $resData = D("Assembly")->addAssembly($param);
        json($resData);
    }

    public function testGetGridColumns()
    {
//        $structureId = 4;
//        $moduleCode = 'sequence';
//        $moduleType = 'assembly';
//        $page = 'sequence_main_grid_1';
//        $projectId = 1;

//        $structureId = 5;
//        $moduleCode = 'shot';
//        $moduleType = 'entity';
//        $page = 'shot_main_grid_1';
//        $projectId = 1;

//        $structureId = 0;
//        $moduleCode = 'note';
//        $moduleType = 'note';
//        $page = 'note_main_grid_1';
//        $projectId = 1;


        $structureId = 0;
        $moduleCode = 'version';
        $moduleType = 'version';
        $page = 'version_main_grid_1';
        $projectId = 1;

        $resData = A('WebApp/View')->testGetGridColumns($structureId, $moduleCode, $moduleType, $page, $projectId);

        dump($resData);

    }

    public function testModuleBaseColumns()
    {
        $structureId = 3;
        $moduleId = 1;
        $from = 'episode_column';
        $category = 'assembly_column';
        $resData = A('WebApp/View')->getModuleBaseColumns($moduleId, $structureId, $category, $from);

    }

    public function index()
    {
        $statusModel = D('Common/Status');

        $resData = $statusModel->addItem(['name' => 'test_status32w2', 'code' => 'test_status32w2', 'correspond' => 'wwww']);
        dump($resData);
        dump($statusModel->getError());
        dump($statusModel->getSuccessMassege());

        $modifyData = $statusModel->modifyItem(['status_id' => 4, 'name' => 'test_status3ww23', 'code' => 'test_status_322']);
        dump($modifyData);
        dump($statusModel->getError());
        dump($statusModel->getSuccessMassege());

        $deleteData = $statusModel->deleteItem(['status_id' => 15]);
        dump($deleteData);
        dump($statusModel->getError());
        dump($statusModel->getSuccessMassege());
    }

    protected function printTest($name, $target, $result)
    {
        dump($name . '--[目标]--' . $target . '--[结果]--' . json_encode($result));
    }

    public function testAuth()
    {
        $ruleManager = new RuleManager();

        // {"category": "project", "uuid": "*", "permission":"view"}
        $ruleManager->addRules('[{"category": "project", "uuid": "rrr", "permission":"view"}]');
        $projectCheck = $ruleManager->projectRuleMgr->checkAccess('rrr', Rule::View);
        $this->printTest('项目权限测试', 'true', $projectCheck);

        // {"category": "column", "$entity_type_uuid": "1111111111", "permission":"view", "column_uuid":"123", "column_code":"123"}
        $ruleManager->addRules('[{"category": "column", "entity_type_uuid": "1111111111", "permission":"view", "column_uuid":"123", "column_code":"123"}]');
        $columnCheck = $ruleManager->columnRuleMgr->checkAccess('1111111111', "123", Rule::View);
        $this->printTest('字段权限测试', 'true', $columnCheck);

        // {"category": "view", "name": "1111111111", "permission":"view'}
        $ruleManager->addRules('[{"category": "view", "name": "11111111112", "permission":"view"}]');
        $viewCheck = $ruleManager->viewRuleMgr->checkAccess('11111111112', Rule::View);
        $this->printTest('视图权限测试', 'true', $viewCheck);
    }




    public function detailsUrl()
    {
        $url = generate_details_page_url(1, 1, 1);
        dump($url);
    }
}