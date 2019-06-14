<?php

namespace Api\Controller;


use Common\Service\DirTemplateService;

class DirTemplateController extends BaseController

{
    /**
     * 目录模板对象
     * @var \Common\Service\DirTemplateService;
     */
    protected $dirTemplateService;


    /**
     * DirTemplateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->dirTemplateService = new DirTemplateService();
    }

    /**
     * 获得模板路径
     * @return \Think\Response
     */
    public function getTemplatePath()
    {
        $resData = $this->dirTemplateService->getTemplatePath($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 获得目录
     * @return \Think\Response
     */
    public function getItemPath()
    {
        $resData = $this->dirTemplateService->getFilePath($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 获得指定项目模板路径
     * @return \Think\Response
     */
    public function findTemplatePath()
    {
        $resData = $this->dirTemplateService->getFilterTemplatePath($this->requestParam);
        return $this->responseApiData($resData);
    }

}
