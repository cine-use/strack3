<?php

namespace Test\Controller;

use Common\Model\UserConfigModel;
use Common\Model\UserModel;
use Common\Service\SchemaService;
use Think\Controller;

use Common\Service\UserService;

class UserController extends Controller
{

    public function getAccount()
    {
        $userData = M("User")->find();
        echo '<pre>';
        var_dump($userData);
        echo '</pre>';
    }

    /**
     * @throws \Linfo\Exceptions\FatalException
     */
    public function addAccount()
    {
        $userService = new UserService();
        $resData = $userService->addAccount([
            'login_name' => 'weijer2',
            'email' => 'chengwei2@strack.com',
            'name' => 'chengwei2',
            'nickname' => 'eeee2'
        ]);
        dump($resData);
    }

    /**
     * 修改用户
     * @throws \Linfo\Exceptions\FatalException
     */
    public function modifyAccount()
    {
        $userService = new UserService();
        $resData = $userService->modifyAccount([
            'user_id' => 4,
            'email' => 'client2@strack.com',
            'name' => 'chengwei2',
            'nickname' => 'eeee2',
            'password' => '22222@strackw_eeee',
        ]);
        dump($resData);
    }

    /**
     * 重置默认密码
     */
    public function resetUserDefaultPassword()
    {
        $userService = new UserService();
        $resData = $userService->resetUserDefaultPassword(4);
        dump($resData);
    }

    public function deleteAccount()
    {
        $userService = new UserService();
        $resData = $userService->deleteAccount([
            'user_id' => ['IN', '4'],
        ]);
        dump($resData);
    }

    public function getFieldConfig()
    {
        $userConfigModel = new UserConfigModel();
        $data = $userConfigModel->selectData(['fields' => 'id']);
        dump($data);
    }

    public function getFindData()
    {
        $schemaService = new SchemaService();
        $options = [

        ];
        $resData = $schemaService->getModuleCodeFindData("user", $options);
        dump($resData);
    }

    public function getUserGridData()
    {
        $param = [
//            'filter_data' => [
                'filter' => [
                    "group" => [],
                    "sort" => [],
                    "request" => [
                        [
                            'field' => 'user_id',
                            'value' => '1,2',
                            'condition' => 'IN',
                            'module_code' => 'user',
                            'table' => 'User'
                        ]
                    ],
                    "temp_fields" => ["add" => [], 'cut' => []],
                    "filter_input" => [],
                    "filter_panel" => [],
                    "filter_advance" => []
                ],
                'page' => 'admin_account',
                'module_id' => 34,
                'project_id' => 0
//            ]
        ];

//        $jsonParam = json_encode($param);
        $userService = new UserService();
        $resData = $userService->getUserGridData($param);
        dump($resData);
    }
}