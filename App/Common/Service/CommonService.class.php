<?php
// +----------------------------------------------------------------------
// | 通用服务层
// +----------------------------------------------------------------------
// | 主要服务于API接口基类
// +----------------------------------------------------------------------
// | 错误编码头 202xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\EntityModel;
use Common\Model\FollowModel;
use Common\Model\NoteModel;
use Common\Model\OnsetLinkModel;
use Common\Model\ReviewLinkModel;
use Common\Model\RoleUserModel;

class CommonService extends EventService
{
    // model对象
    protected $modelObject;

    public function __construct($moduleName = '')
    {
        // 实例化当前model
        if(!empty($moduleName)){
            $class = '\\Common\\Model\\' . string_initial_letter($moduleName) . 'Model';
            $this->modelObject = new $class();
        }
    }

    /**
     * 查询一条基础方法
     * @param $param
     * @return array
     */
    public function find($param)
    {
        $resData = $this->modelObject->findData($param);
        return success_response($this->modelObject->getSuccessMassege(), $resData);
    }

    /**
     * 查询多条基础方法
     * @param $param
     * @return mixed
     */
    public function select($param)
    {
        $resData = $this->modelObject->selectData($param);
        return success_response($this->modelObject->getSuccessMassege(), $resData);
    }

    /**
     * 创建基础方法
     * @param $param
     * @return array
     */
    public function create($param)
    {
        $resData = $this->modelObject->addItem($param);
        if (!$resData) {
            // 通用创建失败错误码 001
            throw_strack_exception($this->modelObject->getError(), 202001);
        } else {
            // 返回成功数据
            return success_response($this->modelObject->getSuccessMassege(), $resData);
        }
    }

    /**
     * 更新基础方法
     * @param $param
     * @return array
     */
    public function update($param)
    {
        $resData = $this->modelObject->modifyItem($param);
        if (!$resData) {
            // 通用修改失败错误码 002
            throw_strack_exception($this->modelObject->getError(), 202002);
        } else {
            // 返回成功数据
            return success_response($this->modelObject->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除基础方法
     * @param $param
     * @return array
     */
    public function delete($param)
    {
        $resData = $this->modelObject->deleteItem($param);
        if (!$resData) {
            // 通用删除失败错误码 003
            throw_strack_exception($this->modelObject->getError(), 202003);
        } else {
            // 返回成功数据
            return success_response($this->modelObject->getSuccessMassege(), $resData);
        }
    }

    /**
     * 关联查询
     * @param $param
     * @return array
     */
    public function relation($param)
    {

        $schemaService = new SchemaService();

        $schemaFields = $schemaService->generateModuleRelation($param);


        $resData = $this->modelObject->getRelationData($schemaFields, 'api');


        if (!isset($resData)) {
            // 通用关联查询失败错误码 004
            throw_strack_exception($this->modelObject->getError(), 202004);
        } else {
            // 返回成功数据
            return success_response($this->modelObject->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取保存数据
     * @param $masterData
     * @param $param
     * @return mixed
     */
    protected function getMasterSaveData(&$masterData, $param)
    {
        $entityModel = new EntityModel();
        switch ($param["module"]) {
            case "project_member":
                if (!array_key_exists("role_id", $masterData)) {
                    $roleUserModel = new RoleUserModel();
                    $masterData["role_id"] = $roleUserModel->where(["user_id" => $masterData["user_id"]])->getField("role_id");
                }
                break;
            case "entity":
                if (array_key_exists("parent_id", $masterData)) {
                    $masterData["parent_module_id"] = $entityModel->where(["id" => $masterData["parent_id"]])->getField("module_id");
                }
                break;
            case "file":
            case "file_commit":
                if (array_key_exists("from_module_id", $param) && $param["from_module_id"] > 0) {
                    $masterData["module_id"] = $param["from_module_id"];
                }

                if (array_key_exists("from_item_id", $param) && $param["from_item_id"] > 0) {
                    $masterData["link_id"] = $param["from_item_id"];
                }
                break;
            case "base":
                $schemaService = new SchemaService();
                $baseModel = new BaseModel();
                if (array_key_exists("from_module_id", $param) && $param["from_module_id"] > 0 && !array_key_exists("entity_id", $masterData)) {
                    $moduleData = $schemaService->getModuleFindData(["id" => $param["from_module_id"]]);
                    if ($moduleData["code"] === "base") {
                        $baseData = $baseModel->findData([
                            "filter" => ["id" => $param["from_item_id"]],
                            "fields" => "entity_id,entity_module_id"
                        ]);
                        if (!empty($baseData)) {
                            $masterData["entity_id"] = $baseData["entity_id"];
                            $masterData["entity_module_id"] = $baseData["entity_module_id"];
                        } else {
                            $masterData["entity_id"] = 0;
                            $masterData["entity_module_id"] = 0;
                        }
                    } else {
                        $masterData["entity_id"] = $param["from_item_id"];
                        $masterData["entity_module_id"] = $param["from_module_id"];
                    }
                }

                // 如果是修改实体id
                if (array_key_exists("entity_id", $masterData)) {
                    $moduleId = $entityModel->where(["id" => $masterData["entity_id"]])->getField("module_id");
                    $masterData["entity_module_id"] = $moduleId > 0 ? $moduleId : 0;
                }
                break;
        }

        return $masterData;
    }

    /**
     * 更新数据
     * @param $dataItem
     * @param $dataRows
     * @param $column
     * @param $otherModel
     * @return array
     */
    protected function modifyItemBatchData($dataItem, $dataRows, $column, $otherModel)
    {
        $resData = [];

        $primaryIdData = explode(",", $dataItem["primary_string_ids"]);
        $relationLinkIds = array_column($dataRows, $column);

        // 如果不为空，保存数据，否则更新数据
        if (!empty($relationLinkIds)) {
            // 数组比较，取差异值
            $diffValue = array_diff($relationLinkIds, $primaryIdData);
            // 存在差异，新增数据
            if (!empty($diffValue)) {
                foreach ($diffValue as $linkIdItem) {
                    $dataItem[$column] = $linkIdItem;
                    // 执行添加数据
                    $resData = $otherModel->addItem($dataItem);
                }
            } else { // 更新数据
                $relationPrimaryIds = array_column($dataRows, "id");
                $dataItem['id'] = ["IN", join(",", $relationPrimaryIds)];
                // 执行添加数据
                $resData = $otherModel->modifyItem($dataItem);
            }
        } else {
            foreach ($primaryIdData as $linkIdItem) {
                // 如果为自定义字段表时，关联条件为link_id
                $dataItem[$column] = $linkIdItem;
                // 执行添加数据
                $resData = $otherModel->addItem($dataItem);
            }
        }

        return $resData;
    }

    /**
     * 添加数据-自定义字段和固定字段添加打平 同时还可以添加关联表信息
     * @param $updateData
     * @param $param
     * @return array
     */
    public function addItemDialog($updateData, $param)
    {
        $this->requestParam = $param;
        $moduleCode = $param["module"];

        $tagService = new TagService();
        $mediaService = new MediaService();
        $horizontalService = new HorizontalService();

        $createModel = $this->modelObject; // 实例化主模块Model
        $createModel->startTrans(); // 开启事务
        try {
            $this->getMasterSaveData($updateData["master_data"], $param);

            if (!array_key_exists("module_id", $updateData["master_data"]) && $moduleCode === "entity") {
                $updateData["master_data"]["module_id"] = $param["module_id"];
            }

            // 保存主表信息
            $masterData = $createModel->addItem($updateData["master_data"]);

            if (!$masterData) {
                throw new \Exception($createModel->getError());
            }

            // 保存关联表信息
            foreach ($updateData["relation_data"] as $key => $dataItem) {
                foreach ($dataItem as $item) {
                    $class = '\\Common\\Model\\' . string_initial_letter($item["module_code"]) . 'Model';
                    $otherModel = new $class();
                    $resData = [];
                    if ($item["field_type"] == "built_in") {
                        switch ($key) {
                            case "media":
                                $mediaServerData = $mediaService->getMediaServerItem($item["media_server_id"]);
                                $resData = $mediaService->saveMediaData([
                                    "media_data" => $item["param"],
                                    "media_server" => $mediaServerData,
                                    'link_id' => $masterData["id"],
                                    'module_id' => $item["module_id"],
                                    "mode" => "single"
                                ]);
                                break;
                            case "tag":
                                $resData = $tagService->modifyDiffTagLink([
                                    "module_id" => $item["module_id"],
                                    "link_id" => $masterData["id"],
                                    "tag_id" => $item["name"]
                                ]);
                                break;
                            default:
                                $item[$moduleCode . '_id'] = $masterData['id'];
                                $resData = $otherModel->addItem($item);
                                if (!$resData) {
                                    throw new \Exception($otherModel->getError());
                                }
                                break;
                        }
                        $masterData[$item["module_code"]] = $resData;
                    } else {
                        $item['link_id'] = $key === $moduleCode ? $masterData["id"] : $resData["id"];
                        switch ($item["type"]) {
                            case "belong_to":
                            case "horizontal_relationship":
                                if ($item["relation_module_code"] == "media") {
                                    $mediaServerData = $mediaService->getMediaServerItem($item["media_data"]["media_server_id"]);
                                    $mediaService->saveMediaData([
                                        "media_data" => $item["media_data"]["param"],
                                        "media_server" => $mediaServerData,
                                        "link_id" => $item['link_id'],
                                        "module_id" => $item["module_id"],
                                        "mode" => "single",
                                        "variable_id" => $item["variable_id"],
                                        "field_type" => "custom"
                                    ]);
                                } else {
                                    $mode = $item["type"] === "belong_to" ? "single" : "batch";
                                    $horizontalService->saveHorizontalRelationData($item, $mode);
                                }
                                $masterData[$item["fields"]] = [];
                                $ids = explode(",", $item["value"]);
                                foreach ($ids as $id) {
                                    $push = ["id" => intval($id)];
                                    array_push($masterData[$item["fields"]], $push);
                                }
                                break;
                            default:
                                if (in_array($item["type"], ["datebox", "datetimebox"])) {
                                    $item['value'] = strtotime($item['value']);
                                }

                                // 因为存在异步event队列首先判断是否存在
                                $customFilter = [
                                    "module_id" => $item["module_id"],
                                    "link_id" => $item["link_id"],
                                    "variable_id" => $item["variable_id"]
                                ];

                                if ($otherModel->where($customFilter)->count() > 0) {
                                    $resData = $otherModel->where($customFilter)->save(["value" => $item["value"]]);
                                } else {
                                    $customFilter["value"] = $item["value"];
                                    $resData = $otherModel->addItem($customFilter);
                                }

                                if (!$resData) {
                                    throw new \Exception($otherModel->getError());
                                }
                                $masterData[$item["fields"]] = $item["value"];
                                break;
                        }
                    }
                }
            }

            $createModel->commit(); // 提交事物

            $message = $createModel->getSuccessMassege();
            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $moduleFilter = ['id' => $param['module_id']];
                $this->projectId = $param['project_id'];
                $this->message = $message;
                $this->messageFromType = 'widget_grid';
                $this->messageOperate = 'add';
                return $this->afterAdd($masterData, $moduleFilter);
            } else {
                return success_response($message, $masterData);
            }
        } catch (\Exception $e) {
            $createModel->rollback(); // 事物回滚
            // 添加数据失败错误码 005
            throw_strack_exception($e->getMessage(), 202005);
        }
    }

    /**
     * 修改数据-自定义字段和固定字段修改打平 同时还可以修改关联表信息
     * @param $updateData
     * @param $param
     * @return array
     */
    public function modifyItemDialog($updateData, $param)
    {
        $this->requestParam = $param;
        $moduleCode = $param["module"];

        // api处理
        if (strtolower($moduleCode) == "task") {
            $moduleCode = "base";
        }

        $message = "";

        $tagService = new TagService();
        $mediaService = new MediaService();
        $horizontalService = new HorizontalService();

        $createModel = $this->modelObject; // 实例化主模块Model
        $createModel->startTrans(); // 开启事务
        try {
            $masterData = [];
            if (array_key_exists("master_data", $updateData) && !empty($updateData["master_data"])) {
                $this->getMasterSaveData($updateData["master_data"], $param);

                if (!array_key_exists("module_id", $updateData["master_data"]) && $moduleCode === "entity") {
                    $updateData["master_data"]["module_id"] = $param["module_id"];
                }

                // 保存主表信息
                $masterData = $createModel->modifyItem($updateData["master_data"]);
                if (!$masterData) {
                    $masterData = array_diff_key($updateData["master_data"], ["field_type" => "built_in"]);
                } else {
                    $message = $createModel->getSuccessMassege();
                }
            }

            $primaryIds = $param["primary_id"]; // 获取主键id
            foreach ($updateData["relation_data"] as $key => $dataItem) {
                // 修改关联表信息
                foreach ($dataItem as $item) {
                    $class = '\\Common\\Model\\' . string_initial_letter($item["module_code"]) . 'Model';
                    $otherModel = new $class();
                    $resData = [];
                    if ($item["field_type"] == "built_in") {
                        $masterPrimaryIds = explode(",", $primaryIds);
                        switch ($key) {
                            case "media": // media批量修改
                                $mediaServerData = $mediaService->getMediaServerItem($item["media_server_id"]);
                                foreach ($masterPrimaryIds as $primaryId) {
                                    $resData = $mediaService->saveMediaData([
                                        "media_data" => $item["param"],
                                        "media_server" => $mediaServerData,
                                        'link_id' => $primaryId,
                                        'module_id' => $item["module_id"],
                                        "mode" => "single"
                                    ]);
                                }
                                break;
                            case "tag": // tag批量修改
                                $masterPrimaryIds = explode(",", $primaryIds);
                                foreach ($masterPrimaryIds as $primaryId) {
                                    $resData = $tagService->modifyDiffTagLink([
                                        "module_id" => $item["module_id"],
                                        "tag_id" => $item["name"],
                                        "link_id" => $primaryId,
                                    ]);
                                }
                                break;
                            default:  // 批量更新数据
                                $selectData = $otherModel->selectData([
                                    "filter" => [$moduleCode . '_id' => ["IN", $primaryIds]],
                                    "fields" => "id," . $moduleCode . '_id'
                                ]);
                                $item["primary_string_ids"] = $primaryIds;
                                $resData = $this->modifyItemBatchData($item, $selectData["rows"], "{$moduleCode}_id", $otherModel);
                                break;
                        }
                    } else {
                        $primaryStringIds = $key === $moduleCode ? $primaryIds : $resData['id'];
                        $primaryLinkIds = explode(",", $primaryStringIds);
                        switch ($item["type"]) {
                            case "belong_to":
                            case "horizontal_relationship":
                                if ($item["relation_module_code"] === "media") {
                                    foreach ($primaryLinkIds as $primaryLinkId) {
                                        $mediaServerData = $mediaService->getMediaServerItem($item["media_data"]["media_server_id"]);
                                        $resData = $mediaService->saveMediaData([
                                            "media_data" => $item["media_data"]["param"],
                                            "media_server" => $mediaServerData,
                                            "link_id" => $primaryLinkId,
                                            "module_id" => $item["module_id"],
                                            "mode" => "single",
                                            "variable_id" => $item["variable_id"],
                                            "field_type" => "custom"
                                        ]);
                                    }
                                } else {
                                    $mode = $item["type"] === "belong_to" ? "single" : "batch";
                                    foreach ($primaryLinkIds as $primaryLinkId) {
                                        $item["link_id"] = $primaryLinkId;
                                        $resData = $horizontalService->saveHorizontalRelationData($item, $mode);
                                    }
                                }
                                break;
                            default:
                                // 如果为date类型 需要格式化后保存
                                if (in_array($item["type"], ["datebox", "datetimebox"])) {
                                    $item['value'] = strtotime($item['value']);
                                }
                                $linkId = $key === $moduleCode ? ["IN", $primaryIds] : ["IN", $resData['id']];
                                // 获取当前的批量编辑的自定义字段数据
                                $selectData = $otherModel->selectData([
                                    'filter' => ['link_id' => $linkId, 'module_id' => $item['module_id'], 'variable_id' => $item['variable_id']],
                                    'fields' => 'id,link_id'
                                ]);
                                // 批量更新数据
                                $item["primary_string_ids"] = $primaryStringIds;
                                $resData = $this->modifyItemBatchData($item, $selectData["rows"], "link_id", $otherModel);
                                break;
                        }
                    }

                    $message = L('Modify_' . string_initial_letter($moduleCode, '_') . '_SC');

                    if (array_key_exists("type", $item)) {
                        if (!in_array($item["type"], ["horizontal_relationship"])) {
                            $masterData[$item["fields"]] = $item["value"];
                        } else {
                            $masterData[$item["fields"]] = [];
                            $ids = explode(",", $item["value"]);
                            foreach ($ids as $id) {
                                $push = ["id" => intval($id)];
                                array_push($masterData[$item["fields"]], $push);
                            }
                        }
                    } else {
                        $masterData[$item["module_code"]] = $resData;
                    }
                }
            }

            $createModel->commit(); // 提交事物

            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $moduleFilter = ['id' => $param['module_id']];
                $this->projectId = $param['project_id'];
                $this->message = $message;
                $this->messageFromType = 'widget_grid';
                $this->messageOperate = 'update';
                $masterData['id'] = $param['primary_id'];
                return $this->afterModify($masterData, $moduleFilter);
            } else {
                return success_response($message, $masterData);
            }
        } catch (\Exception $e) {
            $createModel->rollback(); // 事物回滚
            // 修改关联数据失败错误码 002
            throw_strack_exception($e->getMessage(), 202006);
        }
    }

    /**
     * 保存新增的面板控件数据
     * @param $updateData
     * @param $param
     * @return array
     */
    public function saveNewItemDialog($updateData, $param)
    {
        $templateTable = ["status", "step"];
        $createModel = $this->modelObject;// 实例化主模块Model

        // 获取模版ID
        $templateService = new TemplateService();
        $templateId = $templateService->getProjectTemplateID($param["project_id"]);

        // 开启事务
        $createModel->startTrans();
        try {

            // 保存主表信息
            $masterData = $createModel->addItem($updateData["master_data"]);
            if (!$masterData) {
                throw new \Exception($createModel->getError());
            }

            if (in_array($param["module_code"], $templateTable)) {
                // 获取模版配置数据
                $templateConfig = $templateService->getTemplateConfig([
                    'filter' => [
                        'project_id' => $param['project_id']
                    ],
                    'module_code' => $param["form_module_data"]["code"],
                    'category' => $param["module_code"]
                ]);

                switch ($param["module_code"]) {
                    case 'status':
                        array_push($templateConfig, ["id" => $masterData["id"]]);
                        break;
                    case 'step':
                        array_push($templateConfig, $masterData);
                        break;
                }

                $templateParam = [
                    "category" => $param["module_code"],
                    "module_code" => $param["form_module_data"]["code"],
                    "template_id" => $templateId,
                    "config" => $templateConfig
                ];

                $templateService->modifyTemplateConfig($templateParam);
            }
            $createModel->commit(); // 提交事物
            return success_response($createModel->getSuccessMassege());
        } catch (\Exception $e) {
            $createModel->rollback(); // 事物回滚
            // 修改关联数据失败错误码 002
            throw_strack_exception($e->getMessage(), 202009);
        }
    }

    /**
     * 获取修改单个组件的提示信息
     * @param $module
     * @param $moduleCode
     * @param $field
     * @return mixed
     */
    private function getUpdateWidgetMessage($module, $moduleCode, $field)
    {
        switch ($module) {
            case "variable_value":
            case "variable":
                return L('Modify_Variable_SC') . ":(" . $field . ")";
            case "tag_link":
                return L('Modify_Tag_Name_Sc');
            default:
                return L('Modify_' . string_initial_letter($moduleCode, '_') . '_' . $field . '_SC');
        }

    }

    /**
     * 修改单个组件
     * @param $param
     * @param $updateData
     * @return array
     */
    public function updateWidget($param, $updateData)
    {
        $this->requestParam = $param;

        // 实例化主模块Model
        $modelObj = $this->modelObject;

        switch ($param["module"]) {
            case "tag_link":
            case "tag":
                $tagService = new TagService();
                $modifyData = $tagService->modifyDiffTagLink($updateData);

                // 格式化tagName显示
                $tagData = $tagService->getTagDataList(["filter" => ["id" => ["IN", $updateData["tag_id"]]]]);
                $updateData["name"] = $tagData;
                $updateData["tag_name"] = "";
                if ($tagData["total"] > 0) {
                    $nameList = array_column($tagData["rows"], "name");
                    $updateData["tag_name"] = join(",", $nameList);
                }

                break;
            case "role_user":
                $roleUserModel = new RoleUserModel();
                $updateData["id"] = $roleUserModel->where(["user_id" => $updateData["id"]])->getField("id");
                if (!empty($updateData["id"])) {
                    $modifyData = $modelObj->modifyItem($updateData);
                } else {
                    $modifyData = $modelObj->addItem($updateData);
                }
                break;
            case "variable_value":
                $horizontalService = new HorizontalService();
                switch ($param["data_source"]) {
                    case "horizontal_relationship":
                    case "belong_to":
                        $mode = $param["data_source"] === "belong_to" ? "single" : "batch";
                        $modifyData = $horizontalService->saveHorizontalRelationData($updateData, $mode);
                        $updateData["custom_config"] = $updateData;
                        break;
                    default:
                        // 调用修改单个组件的方法
                        $modifyData = $modelObj->modifyItem($updateData);
                        break;
                }
                break;
            default:
                // 调用修改单个组件的方法
                $modifyData = $modelObj->modifyItem($updateData);
                break;
        }

        if (!$modifyData) {
            // 修改单个组件数据失败错误码 007
            throw_strack_exception($modelObj->getError(), 202007);
        } else {
            if (array_key_exists("module_id", $updateData)) {
                $moduleFilter = ['id' => $updateData['module_id']];
            } else {
                switch ($param["module"]) {
                    case "entity":
                        $entityModel = new EntityModel();
                        $moduleId = $entityModel->where(["id" => $modifyData["id"]])->getField("module_id");
                        $moduleFilter = ["id" => $moduleId];
                        if (array_key_exists("parent_module_id", $updateData)) {
                            $name = $entityModel->where(["id" => $updateData["parent_id"]])->getField("name");
                            $updateData["name"] = $name;
                        }
                        break;
                    default :
                        $moduleFilter = ['code' => $param['module']];
                        break;
                }
            }

            $schemaService = new SchemaService();
            $moduleData = $schemaService->getModuleFindData($moduleFilter);
            $message = $this->getUpdateWidgetMessage($param["module"], $moduleData["code"], $param["field"]);
            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $this->projectId = array_key_exists('project_id', $param) ? $param['project_id'] : 0;
                $this->message = $message;
                $this->messageFromType = 'widget_common';
                $this->messageOperate = 'update';
                $updateData["id"] = $param["primary_value"];
                if (!array_key_exists("name", $updateData)) {
                    $updateData["name"] = array_key_exists("name", $modifyData) ? $modifyData["name"] : "";
                }
                return $this->afterModify($updateData, $moduleFilter);
            } else {
                return success_response($message, $modifyData);
            }
        }
    }

    /**
     * 删除共同数据
     * @param $param
     */
    protected function deleteCommonLinkData($param)
    {
        // 删除反馈
        $noteModel = new NoteModel();
        $noteData = $noteModel->where([
            'link_id' => ['IN', $param['primary_ids']],
            'module_id' => $param["module_id"]
        ])->select();

        if (!empty($noteData)) {
            $noteIds = array_column($noteData, 'id');
            $noteParam = [
                'id' => join(",", $noteIds),
                'module_id' => C("MODULE_ID")["note"],
                'type' => "attachment"
            ];
            $noteService = new NoteService();
            $noteService->deleteNote($noteParam);
        }

        try {
            // 统一删除媒体数据
            $mediaService = new MediaService();
            $mediaService->batchClearMediaThumbnail([
                'link_id' => $param['primary_ids'],
                'module_id' => $param["module_id"],
                'mode' => 'batch'
            ]);

            // 删除标签关联数据
            $tagService = new TagService();
            $tagService->deleteTagLink([
                'link_id' => ['IN', $param['primary_ids']],
                'module_id' => $param["module_id"]
            ]);

            // 删除水平关联数据
            $horizontalService = new HorizontalService();
            $horizontalService->deleteHorizontal([
                'src_link_id' => ['IN', $param['primary_ids']],
                'src_module_id' => $param["module_id"]
            ]);
        } catch (\Exception $e) {

        }
    }

    /**
     * 删除联动数据
     * @param $param
     */
    public function deleteLinkageData($param)
    {
        $module = $param["module_type"] === "entity" ? $param["module_type"] : $param["module_code"];
        switch ($module) {
            case "entity":
                $linkFilter = ["link_id" => ["IN", $param["primary_ids"]], "module_id" => $param["module_id"]];

                // 删除审核关联
                $reviewLinkModel = new ReviewLinkModel();
                $reviewLinkModel->deleteItem(["entity_id" => ["IN", $param["primary_ids"]]]);

                // 删除现场数据关联
                $onsetLinkModel = new OnsetLinkModel();
                $onsetLinkModel->deleteItem($linkFilter);

                // 删除关注信息
                $followModel = new FollowModel();
                $followModel->deleteItem($linkFilter);

                // 删除任务信息
                $baseModel = new BaseModel();
                $baseModel->deleteItem(["entity_id" => ["IN", $param["primary_ids"]]]);
                $baseData = $baseModel->selectData(["filter" => ["entity_id" => ["IN", $param["primary_ids"]]]]);
                if ($baseData["total"] > 0) {
                    $baseIds = array_column($baseData["rows"], "id");
                    $this->deleteCommonLinkData([
                        "primary_ids" => join(",", $baseIds),
                        "module_id" => C("MODULE_ID")["base"],
                    ]);
                }
                break;
        }

        $this->deleteCommonLinkData($param);
    }

    /**
     * 删除表格数据
     * @param $param
     * @return array
     */
    public function deleteGridData($param)
    {
        // 存放消息参数
        $this->requestParam = $param;

        $moduleId = $param['module_id'];
        // 存在form信息
        if (array_key_exists("from_module_id", $param) && array_key_exists("from_item_id", $param) && !in_array($param["module_code"], ["file", "file_commit", "correlation_base"])) {
            // 删除水平关联数据
            $horizontalService = new HorizontalService();
            $deleteData = $horizontalService->deleteHorizontal([
                'dst_link_id' => ['IN', $param['primary_ids']],
                'dst_module_id' => $moduleId,
                'src_module_id' => $param["from_module_id"],
                'src_link_id' => $param["from_item_id"],
            ]);
            $this->message = $deleteData["message"];
        } else {
            switch ($param['module_code']) {
                case "note":
                    $noteService = new NoteService();
                    $noteParam = [
                        'module_id' => $moduleId,
                        'id' => $param['primary_ids'],
                    ];
                    $deleteData = $noteService->deleteNote($noteParam, "widget_grid");
                    $this->message = $deleteData["message"];
                    break;
                default:
                    $modelObj = $this->modelObject;// 实例化主模块Model
                    $deleteData = $modelObj->deleteItem(['id' => ["IN", $param['primary_ids']]]);
                    if (!$deleteData) {
                        // 删除表格数据失败 008
                        throw_strack_exception($this->modelObject->getError(), 202008);
                    }
                    $this->message = $this->modelObject->getSuccessMassege();
                    break;
            }
            // 删除联动数据
            $this->deleteLinkageData($param);
        }

        if (session("event_from") === "strack_web") {
            // 获取消息返回数据
            $moduleFilter = ['id' => $moduleId];
            $this->projectId = array_key_exists('project_id', $param) ? $param['project_id'] : 0;
            $this->messageFromType = 'widget_grid';
            $this->messageOperate = 'delete';
            $this->data = ['id' => $param['primary_ids']];
            return $this->afterDelete($this->data, $moduleFilter);
        } else {
            // 返回当新增数据
            return success_response($this->message, $deleteData);
        }
    }

    /**
     * 获取指定详细信息数据
     * @param $param
     * @param $moduleCode
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getModuleItemInfo($param, $moduleCode)
    {
        $resData = [];
        $mediaData = [];
        $resFieldConfig = [
            "group" => "yes",
            "data" => []
        ];

        // 实例化主模块Model
        $modelObj = $this->modelObject;
        $viewService = new ViewService();
        $schemaService = new SchemaService();

        $moduleData = [
            "id" => $param["module_id"],
            "code" => $param["module_code"],
            "type" => $param["module_type"]
        ];

        // 当前数据结构配置
        $param["filter"] = [
            "sort" => [],
            "group" => [],
            "request" => [
                [
                    "field" => "id",
                    "value" => $param["item_id"],
                    "condition" => "EQ",
                    "module_code" => $param["module_code"],
                    "table" => string_initial_letter($moduleCode),
                ]
            ]
        ];

        // 获取查询数据
        $schemaQueryFields = $viewService->getGridQuerySchemaConfig($param);
        $getRelationData = $modelObj->getRelationData($schemaQueryFields);
        if ($getRelationData["total"] > 0) {
            $resData = $getRelationData["rows"][0];
        }

        // 组装字段数据
        $schemaViewFields = $viewService->getGridQuerySchemaConfig($param, "view");
        $schemaFieldsConfig = $schemaService->generateColumnsConfig($schemaViewFields, $moduleData, false, ["media"]);

        foreach ($schemaFieldsConfig as $key => $fieldItem) {
            $valueShowKey = $schemaService->getFieldColumnName($fieldItem, $param["module_code"]);
            $fieldItem["value_show"] = $valueShowKey;
            $fieldItem["lang"] = $fieldItem["field_type"] === "built_in" ? L($fieldItem["lang"]) : $fieldItem["lang"];
            $resFieldConfig["data"][string_initial_letter($fieldItem["module_code"], "_")][] = $fieldItem;
        }

        // 获取缩略图
        if ($param["category"] !== "main_field") {
            $mediaService = new MediaService();
            $mediaData = $mediaService->getMediaData([
                'link_id' => $param["item_id"],
                'module_id' => $param["module_id"],
                'relation_type' => 'direct',
                'type' => 'thumb'
            ]);
        }

        // 单独判断顶部字段
        if ($param["category"] === "top_field") {
            $resFieldConfig["group"] = "no";
            $resFieldConfig["data"] = $viewService->generateDetailsTopColumnsConfig(
                session("user_id"),
                $param,
                $schemaFieldsConfig
            );

            $resFieldConfig["data"] = array_column($resFieldConfig["data"], null);
            $topFieldResData = [];
            foreach ($resFieldConfig["data"] as $fieldItem) {
                if (array_key_exists($fieldItem["value_show"], $resData)) {
                    $topFieldResData[$fieldItem["value_show"]] = $resData[$fieldItem["value_show"]];
                }
            }

            return ["config" => $resFieldConfig, "data" => $topFieldResData, "media_data" => $mediaData];
        }

        return ["config" => $resFieldConfig, "data" => $resData, "media_data" => $mediaData];
    }

    /**
     * 获取面包屑导航
     * @param $param
     * @return mixed
     */
    public function getModuleBreadcrumb($param)
    {
        $resData = [];

        $entityModel = new EntityModel();

        // 获取module字典数据
        $schemaService = new SchemaService();
        $moduleIdMapData = $schemaService->getModuleMapData("id");

        // 实例化主模块Model
        $modelObj = $this->modelObject;

        // 获取当前数据
        $itemData = $modelObj->findData([
            "filter" => ["id" => $param["item_id"]],
        ]);
        // 区分本身
        $itemData["is_self"] = "yes";
        switch ($param["module_type"]) {
            case "entity":
                $entityListData = $entityModel->selectData([
                    "filter" => ["project_id" => $param["project_id"]],
                    "fields" => "id as item_id,name,module_id,parent_id,parent_module_id"
                ]);

                if (!empty($itemData) && $itemData["parent_id"] > 0) {
                    $resData = $schemaService->getEntityParentModuleData($entityListData["rows"], $itemData["parent_id"]);
                }
                break;
            default:
                switch ($param["module_code"]) {
                    case "base":
                    case "correlation_base":
                        if (!empty($itemData["entity_id"]) && !empty($itemData["entity_module_id"])) {
                            $entityData["is_self"] = "no";
                            $entityInfoData = [
                                "is_self" => "no",
                                "name" => $entityModel->where(["id" => $itemData["entity_id"], "module_id" => $itemData["entity_module_id"]])->getField("name"),
                                "module_id" => $itemData["entity_module_id"],
                                "item_id" => $itemData["entity_id"],
                                "project_id" => $param["project_id"],
                                "module_lang" => L(string_initial_letter($moduleIdMapData[$itemData["entity_module_id"]]["code"], "_")),
                            ];
                            $listData = array_merge($itemData, $entityInfoData);
                            array_push($resData, $listData);
                        }
                        break;
                }
                break;
        }

        $itemData["item_id"] = $itemData["id"];
        array_push($resData, $itemData);

        return $resData;
    }

    /**
     * 保存公共信息
     * @param $param
     * @return array
     */
    public function commonAddItem($param)
    {
        // 实例化主模块Model
        $modelObj = $this->modelObject;
        switch ($param["param"]["module"]) {
            case "tag":
            case "tag_link":
                $addParam = [
                    "name" => $param["value"],
                    "type" => "custom",
                    "color" => "000000"
                ];
                break;
            default:
                $addParam = [];
                break;
        }

        $resData = $modelObj->addItem($addParam);
        if (!$resData) {
            throw_strack_exception($modelObj->getError(), 202010);
        } else {
            return success_response($modelObj->getSuccessMassege(), $resData);
        }
    }
}