<?php

namespace Admin\Controller;

use Common\Service\MediaService;
use Common\Service\SchemaService;

// +----------------------------------------------------------------------
// | 系统媒体服务器控制层
// +----------------------------------------------------------------------

class MediaServerController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {

        $schemaService = new SchemaService();
        $moduleId = 15;
        $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);

        // 把数据发送到前端页面
        $param = [
            "page" => 'admin_' . $moduleData["code"],
            "module_id" => $moduleId,
            "module_code" => $moduleData["code"],
            "module_name" => $moduleData["name"],
            "module_icon" => $moduleData["icon"]
        ];

        $this->assign($param);

        return $this->display();
    }

    /**
     * 新增媒体服务器
     */
    public function addMediaServer()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->addMediaServer($param);
        return json($resData);
    }

    /**
     * 修改媒体服务器
     */
    public function modifyMediaServer()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->modifyMediaServer($param);
        return json($resData);
    }

    /**
     * 删除媒体服务器
     */
    public function deleteMediaServer()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $mediaService = new MediaService();
        $resData = $mediaService->deleteMediaServer($param);
        return json($resData);
    }

    /**
     * 媒体服务器列表数据
     */
    public function getMediaServerGridData()
    {
        $param = $this->request->param();
        $mediaService = new MediaService();
        $resData = $mediaService->getMediaServerGridData($param);
        return json($resData);
    }
}