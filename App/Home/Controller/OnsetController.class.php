<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\OnsetService;

class OnsetController extends VerifyController
{
    /**
     * 获取 Onset Grid 表格信息
     */
    public function getOnsetGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $onsetService = new OnsetService();
        $resData = $onsetService->getOnsetGridData($param);
        return json($resData);
    }

    /**
     * 获取实体或者任务Onset关联关系数据
     */
    public function getItemOnsetLinkData()
    {
        $param = $this->request->param();
        $onsetService = new OnsetService();
        $resData = $onsetService->getItemOnsetLinkData($param);
        return json($resData);
    }

    /**
     * 获取项目Onset列表数据
     */
    public function getProjectOnsetList()
    {
        $param = $this->request->param();
        $onsetService = new OnsetService();
        $resData = $onsetService->getProjectOnsetList($param);
        return json($resData);
    }

    /**
     * 添加实体关联Onset
     */
    public function addEntityLinkOnset()
    {
        $param = $this->request->param();
        $onsetService = new OnsetService();
        $resData = $onsetService->addEntityLinkOnset($param);
        return json($resData);
    }

    /**
     * 获取Onset详情数据
     * @return \Think\Response
     */
    public function getOnsetInfoData()
    {
        $param = $this->request->param();
        $commonService = new OnsetService();
        $resData = $commonService->getOnsetInfoData($param);
        return json($resData);
    }


    /**
     * 获取Onset关联附件数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getOnsetAttachment()
    {
        $param = $this->request->param();
        $onsetService = new OnsetService();
        $resData = $onsetService->getOnsetAttachment($param);
        return json($resData);
    }
}