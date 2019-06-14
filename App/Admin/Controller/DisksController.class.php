<?php
namespace Admin\Controller;

// +----------------------------------------------------------------------
// | 系统磁盘设置数据控制层
// +----------------------------------------------------------------------

use Common\Service\DiskService;
use Common\Service\SchemaService;


class DisksController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {

        $schemaService = new SchemaService();
        $moduleId = 9;
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
     * 添加项目磁盘路径
     */
    public function addDisks()
    {
        $param = $this->request->param();
        $diskService = new DiskService();
        $resData = $diskService->addDisks($param);
        return json($resData);
    }

    /**
     * 修改项目磁盘路径
     */
    public function modifyDisks()
    {
        $param = $this->request->param();
        $diskService = new DiskService();
        $resData = $diskService->modifyDisks($param);
        return json($resData);

    }

    /**
     * 删除项目磁盘路径
     */
    public function deleteDisks()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $diskService = new DiskService();
        $resData = $diskService->deleteDisks($param);
        return json($resData);
    }


    /**
     * 获取项目磁盘路径数据
     */
    public function getDisksGridData()
    {
        $param = $this->request->param();
        $diskService = new DiskService();
        $resData = $diskService->getDisksGridData($param);
        return json($resData);
    }

}