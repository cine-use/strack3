<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\FileCommitService;

class FileCommitController extends VerifyController
{
    /**
     * 获取fileCommit数据表格数据
     */
    public function getFileCommitGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $fileService = new FileCommitService();
        $resData = $fileService->getDetailGridData($param);
        return json($resData);
    }
}