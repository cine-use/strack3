<?php

namespace Api\Controller;


use Common\Service\VariableService;

class VariableController extends BaseController
{
    /**
     * 创建自定义字段
     * @return \Think\Response
     */
    public function create()
    {
        if (!isset($this->commonService)) {
            $this->_empty();
        }

        $extraData = $this->requestParam["extra_data"];
        $queryParam = $this->requestParam["query_param"];
        $authData = $this->check($this->param, "createVariable");
        //添加字段
        $resData = $this->commonService->addItemDialog($queryParam, $extraData);
        if ($resData["status"] == 200) {
            $variableService = new VariableService();
            $authData["variable_id"] = $resData["data"]["id"];
            $variableService->changeAuthFieldConfig($authData, "add");
        }
        return $this->responseApiData($resData);
    }
}
