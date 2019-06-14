<?php

namespace Test\Controller;

use Common\Model\UserModel;
use Think\Controller\RestController;
use Common\Service\UserService;
use Api\Controller\UserController;


class UserApiController
{
    public function findTest()

    {
        $userModel = new UserController();
        $param     = [
            "filter" => [
                "user_id" => 3,
            ],
//            "fields" => ['user_id','login_name'],
//            "order"  => [
//                "user_id" => "desc",
//            ],
//            "page_num"=>"1",
//            "page_size"=>"2",
        ];

        echo json_encode($param, true);

        $userModel = new UserService();
        $userData  = $userModel->apiFind($param);

        dump($userData);
    }

    public function deleteTest()
    {
        $userModel = new UserController();
        $param     = [
            "filters" => [
                "user_id" => ["IN", "1,147"]
            ],
            "user_id" => "888",
        ];
        $userData  = $userModel->delete($param);
    }

    public function createTest()
    {
        $userModel = new UserService();
        $param     = [

            "user_id"    => 4,
            "email"      => '230610393@qq.com',
            'login_name' => 'test_gkx1',
            'password'   => 'password'

        ];
        echo json_encode($param, true);
        die;
        $userData = $userModel->apiCreate($param['filter']);
        dump($userData);

    }

    public function updateTest()
    {
        $userModel = new UserService();
        $param     = [
            "user_id"    => 7,
            "email"      => '23061039312@qq.com',
            'login_name' => 'test_gkx4',
            'password'   => 'password11'

        ];
        echo json_encode($param, true);
        $userData = $userModel->modifyAccount($param);
        dump($userData);
    }

    public function test()
    {
        $userModel = new UserModel();
        $data      = $userModel->getLastInsID();
        dump($data);
    }

}