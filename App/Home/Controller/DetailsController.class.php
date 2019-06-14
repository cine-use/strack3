<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Model\EntityModel;
use Common\Model\ProjectTemplateModel;
use Common\Service\DiskService;
use Common\Service\MemberService;
use Common\Service\OnsetService;
use Common\Service\SchemaService;

class DetailsController extends VerifyController
{
    /**
     * 显示详情页面
     */
    public function index()
    {
        $getUrlParam = get_url_param();
        $param = $this->request->param();

        // 获取当前模块设置
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(["id" => $getUrlParam[0]]);
        $moduleCode = string_initial_letter($moduleData["code"]);

        //获取项目模板ID
        $projectTemplateModel = new ProjectTemplateModel();
        $templateId = $projectTemplateModel->where(["project_id" => $getUrlParam[1]])->getField("id");

        // 处理当前指定场景Url锚点数据
        $urlAnchorsGetParam = get_page_url_anchors_param("tab", $param);

        if (count($urlAnchorsGetParam) === 2) {
            $urlAnchorsParam = array_combine(["type", "tab"], $urlAnchorsGetParam);
        } else {
            $urlAnchorsParam = ["type" => "", "tab" => ""];
        }

        $this->assign('url_tag', $urlAnchorsParam);


        // 获取Base详情页面entity_id
        $entityId = 0;

        //获取当前 Item name
        $hasEntityChild = "no";
        switch ($moduleData["type"]) {
            case "entity":
                // 实体
                $entityModel = new EntityModel();
                $itemData = $entityModel->field("name,uuid")->where(['id' => $getUrlParam[2]])->find();
                $itemName = $itemData["name"];

                // 判断是否有子集
                $childrenData = $schemaService->getEntityBelongParentModule(["module_code" => $moduleData["code"]], "children");
                if (!empty($childrenData)) {
                    $hasEntityChild = "yes";
                    $this->assignMorePageAuthRules("entity_child_view_rules", "home_project_entity", $childrenData["id"]);
                }
                break;
            default:
                // 固定模块
                $class = '\\Common\\Model\\' . $moduleCode . 'Model';
                $fixedModel = new $class();
                $itemData = $fixedModel->field("name,uuid")->where(['id' => $getUrlParam[2]])->find();
                $itemName = $itemData["name"];
                if (strtolower($moduleData["code"]) === "base") {
                    $entityId = $fixedModel->where(['id' => $getUrlParam[2]])->getField("entity_id");
                }
                break;
        }


        $this->assign("has_entity_child", $hasEntityChild);

        // 如果是base类型判断是否是我的任务
        $isMyTask = "no";
        if ($moduleData["code"] === "base") {
            $memberService = new MemberService();
            $isMyTaskStatus = $memberService->getBelongMyTaskMember(["src_module_id" => $moduleData["id"], "src_link_id" => $getUrlParam[2]]);
            $isMyTask = $isMyTaskStatus["status"];
        }

        $page = 'details_' . $moduleData["code"];

        // 生成页面唯一信息
        $this->generatePageIdentityID($page, $getUrlParam[1]);

        // 查询onset信息
        $onsetService = new OnsetService();
        $onsetData = $onsetService->getLinkOnsetId([
            'link_id' => $getUrlParam[2],
            'module_id' => $moduleData["id"]
        ]);

        // 获取云盘地址
        $diskService = new DiskService();
        $cloudDiskConfig = $diskService->getCloudDiskUrl($getUrlParam[1], "{$moduleData["code"]}_{$itemData["uuid"]}");

        $param = [
            "is_my_task" => $isMyTask,
            "project_id" => $getUrlParam[1],
            "template_id" => $templateId,
            "parent_id" => 0,
            "module_id" => $moduleData["id"],
            'module_name' => $moduleData["name"],
            'module_code' => $moduleData["code"],
            'module_type' => $moduleData["type"],
            'onset_param' => [
                "module_id" => C("MODULE_ID")["onset"],
                "id" => $onsetData["id"]
            ],
            "page" => $page,
            "item_id" => $getUrlParam[2],
            "entity_id" => $entityId,
            "item_name" => $itemName,
            'lang' => [
                'details_title' => L(string_initial_letter($moduleData["code"], '_') . '_Details'),
                'module_name' => L(string_initial_letter($moduleData["code"], '_') . '_Name')
            ],
            "cloud_disk_url" => $cloudDiskConfig["cloud_disk_url"],
            "cloud_disk_request_url" => $cloudDiskConfig["cloud_disk_request_url"]
        ];

        $this->assign($param);
        return $this->display();
    }
}