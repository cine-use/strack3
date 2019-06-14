<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\EntityService;

class EntityController extends VerifyController
{
    /**
     * 获取 Entity 类型 grid 数据
     */
    public function getEntityGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $entityService = new EntityService();
        $resData = $entityService->getEntityGridData($param);
        return json($resData);
    }

    /**
     * 批量添加任务
     * @return \Think\Response
     */
    public function batchSaveEntityBase()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->batchSaveEntityBase($param);
        return json($resData);
    }

    /**
     * 获取播放列表下的实体详情信息
     * @return \Think\Response
     */
    public function getPlayEntityInfo()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->getPlayEntityInfo($param);
        return json($resData);
    }
}