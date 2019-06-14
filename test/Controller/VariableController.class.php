<?php

namespace Test\Controller;

use Common\Model\ModuleModel;
use Common\Model\UserModel;
use Common\Service\VariableService;
use Think\Controller;
use Common\Service\ViewService;

class VariableController extends Controller
{
    public function checkVariableField()
    {
        $variableService = new VariableService();
        $resData = $variableService->checkVariableFields(4,"ggg");
        dump($resData);
    }
}