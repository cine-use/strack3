<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\FilterService;
use Common\Service\OtherService;
use Common\Service\ViewService;

class FilterController extends VerifyController
{

    /**
     * 保存过滤条件
     */
    public function saveFilter()
    {
        $param = $this->request->param();
        $saveData = [
            "name" => $param['name'],
            "color" => $param['color'],
            "stick" => $param['stick'],
            "public" => $param['public'],
            "project_id" => $param['project_id'],
            "page" => $param['page'],
            "config" => json_decode(htmlspecialchars_decode($param["filter"]), true),
            "user_id" => session("user_id"),
        ];
        $filterService = new FilterService();
        $resData = $filterService->saveFilter($saveData);
        return json($resData);
    }

    /**
     * 置顶选择的过滤条件
     */
    public function stickFilter()
    {
        $param = $this->request->param();
        $filterService = new FilterService();
        $resData = $filterService->stickFilter($param);
        return json($resData);
    }

    /**
     * 删除过滤条件
     */
    public function deleteFilter()
    {
        $param = $this->request->param();
        $filterService = new FilterService();
        $resData = $filterService->deleteFilter($param);
        return json($resData);
    }

    /**
     * 获取单个过滤条件信息
     */
    public function getFilterSingle()
    {
        $param = $this->request->param();
        $filterService = new FilterService();
        $resData = $filterService->getFilterSingle($param);
        return json($resData);
    }

    /**
     * 获取过滤条件数据
     */
    public function getGridFilterBarData()
    {
        $param = $this->request->param();
        $userId = session("user_id");
        $filterService = new FilterService();
        $filterBarData = $filterService->getFilterList($userId, $param['page'], $param["project_id"]);
        return json($filterBarData);
    }
}