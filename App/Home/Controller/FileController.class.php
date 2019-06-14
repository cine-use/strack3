<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\FileService;

class FileController extends VerifyController
{
    /**
     * 获取 File 表格信息
     */
    public function getFileGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $fileService = new FileService();
        $resData = $fileService->getFileGridData($param);
        return json($resData);
    }

    /**
     * 获取媒体时间线文件提交数据
     * @return \Think\Response
     * @throws \Exception
     */
    public function getTimeLineFileCommitData()
    {
        $param = $this->request->param();
        $filter = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $fileService = new FileService();
        $resData = $fileService->getTimeLineFileCommitData($filter, $param);
        return json($resData);
    }

    /**
     * 获取播放列表媒体时间线数据
     * @return \Think\Response
     * @throws \Exception
     */
    public function getPlaylistTimeLineData()
    {
        $param = $this->request->param();
        $fileService = new FileService();
        $resData = $fileService->getPlaylistTimeLineData($param);
        return json($resData);
    }

    /**
     * 获取指定审核任务时间线数据
     * @return \Think\Response
     * @throws \Exception
     */
    public function getReviewTaskTimeLineData()
    {
        $param = $this->request->param();
        $fileService = new FileService();
        $resData = $fileService->getReviewTaskTimeLineData($param);
        return json($resData);
    }
}