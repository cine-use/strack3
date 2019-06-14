<?php

namespace Api\Controller;

use Common\Service\MediaService;

class MediaController extends BaseController
{
    protected $mediaServer;


    public function __construct()
    {
        parent::__construct();
        $this->mediaServer = new MediaService();
    }

    /**
     * 添加media
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function createMedia()
    {
        $resData = $this->mediaServer->saveMediaData($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 修改media
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function updateMedia()
    {
        $resData = $this->mediaServer->saveMediaData($this->requestParam);
        return $this->responseApiData($resData);
    }


    /**
     * 获取指定媒体信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getMediaData()
    {
        $resData = $this->mediaServer->getMediaData($this->requestParam);
        return $this->responseApiData($resData);
    }

    /**
     * 获取媒体指定上传服务器配置信息
     * @return \Think\Response
     */
    public function getMediaUploadServer()
    {
        $resData = $this->mediaServer->getMediaUploadServer();
        return $this->responseApiData($resData);
    }

    /**
     * 获取指定服务器信息
     * @return \Think\Response
     */
    public function getMediaServerItem()
    {
        $resData = $this->mediaServer->getMediaServerItem($this->requestParam);
        return $this->responseApiData($resData);
    }


    /**
     * 获取所有媒体服务器状态
     * @return \Think\Response
     */
    public function getMediaServerStatus()
    {
        $resData = $this->mediaServer->getMediaServerStatus();
        return $this->responseApiData($resData);
    }

    /**
     * 获取指定尺寸的媒体缩略图路径
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getSpecifySizeThumbPath()
    {
        $resData = $this->mediaServer->getSpecifySizeThumbPath($this->requestParam["filter"], $this->requestParam["size"]);
        return $this->responseApiData($resData);
    }

    /**
     *  获取多个媒体信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function selectMediaData()
    {
        $resData = $this->mediaServer->selectMediaData($this->requestParam["server_id"], $this->requestParam["md5_name_list"]);
        return $this->responseApiData($resData);
    }
}