<?php
// +----------------------------------------------------------------------
// | Step 工序服务
// +----------------------------------------------------------------------
// | 主要服务于Step数据处理
// +----------------------------------------------------------------------
// | 错误编码头 225xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\StepModel;
use Common\Model\ViewModel;
use Common\Model\ViewUseModel;

class StepService
{
    /**
     * 获取工序表格数据
     * @param $param
     * @return mixed
     */
    public function getStepGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $stepModel = new StepModel();
        return $stepModel->selectData($options);
    }

    /**
     * 新增工序
     * @param $param
     * @return array
     */
    public function addStep($param)
    {
        $stepModel = new StepModel();
        $resData = $stepModel->addItem($param);
        if (!$resData) {
            // 添加工序失败错误码 001
            throw_strack_exception($stepModel->getError(), 225001);
        } else {
            // 返回成功数据
            return success_response($stepModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改工序
     * @param $param
     * @return array
     */
    public function modifyStep($param)
    {
        $stepModel = new StepModel();
        $resData = $stepModel->modifyItem($param);
        if (!$resData) {
            // 修改工序失败错误码 002
            throw_strack_exception($stepModel->getError(), 225002);
        } else {
            // 返回成功数据
            return success_response($stepModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除工序
     * @param $param
     * @return array
     */
    public function deleteStep($param)
    {
        $stepModel = new StepModel();
        $baseModel = new BaseModel();
        $baseData = $baseModel->selectData(['filter' => ['step_id' => ['IN', $param["primary_ids"]]]]);
        if ($baseData["total"] > 0) {
            // 当前工序有任务正在使用，请修改后再来操作错误码 004
            throw_strack_exception(L('Current_Step_Is_In_Use'), 225004);
        } else {
            $resData = $stepModel->deleteItem([
                'id' => ['IN', $param["primary_ids"]]
            ]);
            if (!$resData) {
                // 删除工序失败错误码 003
                throw_strack_exception($stepModel->getError(), 225003);
            } else {
                // 返回成功数据
                return success_response($stepModel->getSuccessMassege(), $resData);
            }
        }

    }

    /**
     * 获取工序列表
     * @return array
     */
    public function getStepList()
    {
        $stepModel = new StepModel();
        $options = [
            'fields' => 'id as step_id,name,code,color'
        ];
        $resData = $stepModel->selectData($options);
        return $resData;
    }

    /**
     * 获取工序列表并判断是否选中
     * @param $projectId
     * @param $userId
     * @param $page
     * @param $moduleId
     * @return array
     */
    public function getStepCheckList($projectId, $userId, $page, $moduleId)
    {
        $stepCheckList = [];
        // 获取Module信息
        $schemaService = new SchemaService();
        $moduleData = $schemaService->getModuleFindData(['id' => $moduleId]);

        if ($moduleData["type"] === "entity") {
            // 获取模版中的step
            $templateService = new TemplateService();
            $templateStepConfig = $templateService->getTemplateConfig(['filter' => ["project_id" => $projectId], 'module_code' => $moduleData["code"], 'category' => 'step']);

            // 如果模版step不为空 与 view视图对比
            if (!empty($templateStepConfig)) {
                // 获取当前使用视图
                $viewUseModel = new ViewUseModel();
                $viewId = $viewUseModel->where(['page' => $page, 'project_id' => $projectId, 'user_id' => $userId])->getField("view_id");
                if ($viewId > 0) {
                    $viewModel = new ViewModel();
                    $viewData = $viewModel->findData([
                        'filter' => ['id' => $viewId]
                    ]);

                    foreach ($templateStepConfig as &$stepItem) {
                        $stepItem['is_checked'] = false;
                        if (count($viewData["config"]["fields"]) > 1) {
                            foreach ($viewData["config"]["fields"][0] as $viewItem) {
                                if (array_key_exists("hidden_status", $viewItem) && $viewItem['hidden_status'] === "no" && $stepItem['code'] === $viewItem['fname']) {
                                    $stepItem['is_checked'] = true;
                                }
                            }
                        }
                        array_push($stepCheckList, $stepItem);
                    }
                } else {
                    foreach ($templateStepConfig as $stepItem) {
                        $stepItem['is_checked'] = true;
                        array_push($stepCheckList, $stepItem);
                    }
                }
            }
        }
        return $stepCheckList;
    }

    /**
     * 获取模版工序列表
     * @param $param
     * @return array
     */
    public function getTemplateStepList($param)
    {
        $class = '\\Common\\Model\\' . string_initial_letter($param["frozen_module"]) . 'Model';
        $moduleId = 0;
        if (array_key_exists("primary", $param) && $param["primary"] > 0) {
            $modelObj = new $class();
            $moduleId = $modelObj->where(["id" => $param["primary"]])->getField("entity_module_id");
        }

        $stepModel = new StepModel();
        $stepList = [
            [
                "id" => 0,
                "name" => L("Empty_Default")
            ]
        ];

        if ($moduleId > 0) {
            $schemaService = new SchemaService();
            $moduleData = $schemaService->getModuleFindData(["id" => $moduleId]);
            // 获取项目模板状态配置
            $templateService = new TemplateService();
            $stepData = $templateService->getTemplateConfig([
                'filter' => ["project_id" => $param['project_id']], 'module_code' => $moduleData['code'],
                'category' => 'step'
            ]);

            $stepListData = ["rows" => []];
            if (!empty($stepData)) {
                // 获取工序数据
                $stepIds = unique_arr(array_column($stepData, "id"));
                $stepListData = $stepModel->selectData([
                    "filter" => ["id" => ["IN", join(",", $stepIds)]]
                ]);
            }
        } else {
            $stepListData = $stepModel->selectData([]);
        }

        foreach ($stepListData["rows"] as $stepItem) {
            // 将模板中存在的id名称赋给新的数据
            array_push($stepList, [
                'id' => $stepItem["id"],
                'name' => $stepItem["name"]
            ]);
        }

        return $stepList;
    }
}