<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\FileService;


class DownloadController extends VerifyController
{
    /**
     * 下载Excel文件
     * @return \think\response\Download
     */
    public function excel()
    {
        $param = $this->request->param();
        $fileService = new FileService();
        $fileData = $fileService->getDownloadFilePath($param["id"]);
        return download($fileData["path"], $fileData["name"]);
    }
}