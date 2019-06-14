<?php

namespace Admin\Controller;

use Common\Service\SchemaService;
use Common\Service\TagService;

// +----------------------------------------------------------------------
// | 标签数据控制层
// +----------------------------------------------------------------------

class TagController extends AdminController
{
    /**
     * 显示页面
     */
    public function index()
    {
        $schemaService = new SchemaService();
        $moduleId = 29;
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
     * 添加标签
     */
    public function addTag()
    {
        $param = $this->request->param();
        $param["type"] = !empty($param["type"]) ? $param["type"] : "custom";
        $tagService = new TagService();
        $resData = $tagService->addTag($param);
        return json($resData);
    }

    /**
     * 修改标签
     */
    public function modifyTag()
    {
        $param = $this->request->param();
        $tagService = new TagService();
        $resData = $tagService->modifyTag($param);
        return json($resData);
    }

    /**
     * 删除标签
     */
    public function deleteTag()
    {
        $param = $this->request->param();
        $param = [
            'id' => ['IN', $param["primary_ids"]]
        ];
        $tagService = new TagService();
        $resData = $tagService->deleteTag($param);
        return json($resData);
    }

    /**
     * 获取标签表格数据
     */
    public function getTagGridData()
    {
        $param = $this->request->param();
        $tagService = new TagService();
        $resData = $tagService->getTagGridData($param);
        return json($resData);
    }
}