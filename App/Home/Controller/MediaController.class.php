<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\BaseService;
use Common\Service\EntityService;
use Common\Service\FollowService;
use Common\Service\MediaService;

class MediaController extends VerifyController
{

    /**
     * 保存媒体信息
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function saveMediaData()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->saveMediaData($param);
        return json($resData);
    }

    /**
     * 获取媒体服务器信息
     * @return \Think\Response
     */
    public function getMediaUploadServer()
    {
        $mediaService = new MediaService();
        $resData = $mediaService->getMediaUploadServer();
        return json(success_response('', $resData));
    }

    /**
     * 清除媒体缩略图
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function clearMediaThumbnail()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->batchClearMediaThumbnail($param);
        return json($resData);
    }

    /**
     * 获取详情页面顶部数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getDetailTopThumb()
    {
        $param = $this->request->param();
        // 获取用户头像
        $mediaService = new MediaService();
        $mediaData = $mediaService->getMediaData(['link_id' => $param['item_id'], 'module_id' => $param['module_id'], 'relation_type' => 'direct', 'type' => 'thumb']);
        return json(success_response('', $mediaData));
    }

    /**
     * 获取详情页面顶部数据
     */
    public function getMediaGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $mediaService = new MediaService();
        $resData = $mediaService->getMediaGridData($param);
        return json($resData);
    }


    /**
     * 保存播放列表
     */
    public function savePlaylist()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->savePlaylist($param);
        return json($resData);
    }

    /**
     * 获取审核页面所有播放列表数据
     */
    public function getReviewPlaylist()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->getReviewPlaylist($param);
        return json($resData);
    }

    /**
     * 获取审核页面我关注的播放列表数据
     */
    public function getReviewFollowPlaylist()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->getReviewFollowPlaylist($param);
        return json($resData);
    }

    /**
     * 获取审核页面审核任务列表数据
     */
    public function getReviewTaskList()
    {
        $param = $this->request->param();
        $baseService = new BaseService();
        $resData = $baseService->getReviewTaskList($param);
        return json($resData);
    }

    /**
     * 删除指定的审核任务
     */
    public function deleteReviewTask()
    {
        $param = $this->request->param();
        $baseService = new BaseService();
        $resData = $baseService->deleteReviewTask($param);
        return json($resData);
    }

    /**
     * 删除指定的审核实体播放列表
     */
    public function deleteReviewPlaylist()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->deleteReviewPlaylist($param);
        return json($resData);
    }

    /**
     * 关注指定的审核实体播放列表
     */
    public function followReviewPlaylist()
    {
        $param = $this->request->param();
        $followService = new FollowService();
        $resData = $followService->followReviewPlaylist($param);
        return json($resData);
    }

    /**
     * 获取审核实体审核进度
     */
    public function getReviewEntityProgress()
    {
        $param = $this->request->param();
        $entityService = new EntityService();
        $resData = $entityService->getReviewEntityProgress($param["base_id"]);
        return json($resData);
    }
}