<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\BaseService;
use Common\Service\CommonService;

class BaseController extends VerifyController
{
    /**
     * 获取 Base 类型 grid 数据
     */
    public function getBaseGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $baseService = new BaseService();
        $resData = $baseService->getBaseGridData($param);
        return json($resData);
    }

    /**
     * 加载当前审核任务详细信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getReviewTaskInfoData()
    {
        $param = $this->request->param();
        $commonService = new CommonService(string_initial_letter($param["module_code"]));
        $resData = $commonService->getModuleItemInfo($param, $param["module_code"]);
        return json($resData);
    }

}