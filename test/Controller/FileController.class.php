<?php

namespace Test\Controller;


use Common\Service\FileService;
use Think\Controller;

class FileController extends Controller
{
    public function getTimeLineFileCommitData()
    {
        $param["primary_ids"] = '1,2';
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $fileService = new FileService();
        $resData = $fileService->getTimeLineFileCommitData($param);
        dump($resData);
    }

}