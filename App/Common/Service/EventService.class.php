<?php
// +----------------------------------------------------------------------
// | 事件服务层
// +----------------------------------------------------------------------
// | 主要服务于服务层事件
// +----------------------------------------------------------------------
// | 错误编码头 xxxxxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Middleware\MessageMiddleware;
use Common\Model\ModuleModel;
use Common\Model\StatusModel;
use Common\Model\UserConfigModel;
use Common\Model\UserModel;

class EventService
{

    // 数据
    protected $data;

    // 消息紧急程度
    protected $emergent = "normal";

    // 邮件模板
    protected $emailTemplate = "item";

    // 项目ID
    protected $projectId = 0;

    // 返回信息
    protected $message = '';

    // 消息类型
    protected $messageType = 'message';

    // 消息来自类型
    protected $messageFromType = '';

    // 事件操作方法
    protected $messageOperate = '';

    // 传入参数
    protected $requestParam = [];

    /**
     * 注册消息
     */
    protected function message()
    {
        MessageMiddleware::register($this->data);
    }

    /**
     * 获取模块数据
     * @param $filter
     * @return mixed
     */
    protected function getModuleData($filter)
    {
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->field("id,type,name,code,icon")
            ->where($filter)
            ->find();
        return $moduleData;
    }

    /**
     * 获取语言类型
     */
    public function getLanguage()
    {
        $userConfigModel = new UserConfigModel();
        $configData = $userConfigModel->findData([
            "filter" => ["user_id" => session("user_id"), "type" => "system"],
            "fields" => "config"
        ]);
        $lang = "zh-cn";
        if (!empty($configData) && array_key_exists("config", $configData)) {
            $lang = array_key_exists("lang", $configData["config"]) ? $configData["config"]["lang"] : "zh-cn";
        }

        return $lang;
    }

    /**
     * 获取发送者数据
     * @return mixed
     */
    protected function getSenderData()
    {
        $createdId = session("user_id");
        $userModel = new UserModel();
        $senderData = $userModel->field("id,login_name,name,email,uuid")
            ->where(["id" => $createdId])
            ->find();
        return $senderData;
    }

    /**
     * 获取接收者数据
     * @param $linkId
     * @param $moduleId
     * @param $moduleCode
     * @return array
     */
    protected function getReceiverData($linkId, $moduleId, $moduleCode)
    {

        $linkIds = strpos($linkId, ",") === false ? $linkId : ['IN', $linkId];

        // 成员数据列表按类型存放
        $memberListData = [];
        $userIdList = [];

        $userModel = new UserModel();
        if ($moduleCode !== "note") {
            $horizontalService = new HorizontalService();
            $relationData = $horizontalService->getHorizontalRelationData([
                "src_link_id" => $linkIds,
                "src_module_id" => $moduleId,
                "dst_module_id" => C("MODULE_ID")["user"]
            ]);

            foreach ($relationData as $relationItem) {
                $variableConfig = json_decode($relationItem["config"], true);

                $userData = $userModel->field("id,login_name,name,email,uuid")->where(["id" => $relationItem["dst_link_id"]])->find();
                $userData["belong_type"] = $variableConfig["code"];

                $memberListData[$relationItem["src_link_id"]][] = $userData;

                // web_socket使用用户id数据
                if (!in_array($userData["id"], $userIdList)) {
                    array_push($userIdList, $userData["id"]);
                }
            }
        } else {
            $memberService = new MemberService();
            $memberList = $memberService->getMemberList(["link_id" => $linkIds, "module_id" => $moduleId], "link_id,user_id,type");
            foreach ($memberList["rows"] as $item) {
                $userData = $userModel->field("id,login_name,name,email,uuid")->where(["id" => $item["user_id"]])->find();
                $userData["belong_type"] = $item["type"];

                $memberListData[$item["link_id"]][] = $userData;

                // web_socket使用用户id数据
                if (!in_array($userData["id"], $userIdList)) {
                    array_push($userIdList, $userData["id"]);
                }
            }
        }

        return ["member_data" => $memberListData, "user_ids" => $userIdList];
    }

    /**
     * 获取消息内容
     * @param $createdBy
     * @param $moduleName
     * @param $updateData
     * @return array
     */
    protected function getMessageContent($createdBy, $moduleName, $updateData)
    {
        $itemName = array_key_exists("name", $updateData) ? $updateData["name"] : "";
        $content = [
            "language" => $this->getLanguage(),
            "operate" => $this->messageOperate,
            "title" => [
                "created_by" => $createdBy,
                "module_name" => L($moduleName),
                "item_name" => $itemName
            ],
            "update_list" => []
        ];
        switch ($this->messageOperate) {
            case "add":
            case "update":
                $updateList = [];
                if ($moduleName == "tag") {
                    $updateData["name"] = $updateData["tag_name"];
                }
                foreach ($updateData as $field => $value) {
                    $fieldForm = explode("_", $field);
                    if (count($fieldForm) > 1 && end($fieldForm) == "id") {
                        $moduleTable = count($fieldForm) > 2 ? "{$fieldForm[0]}_{$fieldForm[1]}" : $fieldForm[0];
                        if (!in_array($moduleTable, ["parent", "workflow", "link", "src_link"]) && !array_key_exists("variable_id", $updateData)) {
                            switch ($moduleTable) {
                                case "entity_module":
                                case "module":
                                case "parent_module":
                                    $moduleData = $this->getModuleData(["id" => $value]);
                                    $valuePush = $moduleData["name"];
                                    break;
                                default:
                                    $modelClassName = '\\Common\\Model\\' . string_initial_letter($moduleTable) . 'Model';
                                    $modelClass = new $modelClassName();
                                    $valuePush = $modelClass->where(["id" => $value])->getField("name");
                                    break;
                            }
                            $value = $valuePush;
                        }
                        $originalField = $fieldForm[0];
                    } else {
                        $originalField = $field;
                    }
                    array_push($updateList, [
                        "field" => $field,
                        "lang" => L($originalField),
                        "value" => $value
                    ]);
                }
                $content["update_list"] = $updateList;
                break;
            case "delete":
                break;
        }

        return $content;
    }

    /**
     * 格式化字段数据
     * @param $updateData
     * @return array|false|string
     */
    protected function formatFieldData($updateData)
    {
        $variableService = new VariableService();
        $variableConfig = $variableService->getVariableConfig($this->requestParam["variable_id"]);
        switch ($this->requestParam["module"]) {
            case "variable":
                return $updateData[$this->requestParam["original_field"]];
            default:
                switch ($this->requestParam["data_source"]) {
                    case "belong_to":
                        $statusModel = new StatusModel();
                        $belongToData = $statusModel->selectData([
                            "filter" => ["id" => $this->requestParam["val"]],
                            "fields" => "id,name,color,icon"
                        ]);
                        return $belongToData;
                    case "horizontal_relationship":
                        // 获取当前水平关联模块信息
                        $dstModuleData = $this->getModuleData([
                            "id" => $updateData["relation_module_id"]
                        ]);

                        $filterData = [
                            "link_data" => explode(",", $this->requestParam["val"]),
                            "project_id" => $this->projectId,
                            "dst_module_id" => $updateData["relation_module_id"],
                        ];

                        if ($dstModuleData["type"] === "entity") {
                            $serviceClass = new EntityService();
                        } else {
                            $serviceClassName = '\\Common\\Service\\' . string_initial_letter($dstModuleData["code"]) . 'Service';
                            $serviceClass = new $serviceClassName();
                        }

                        // 获取当前水平关联数据
                        $horizontalRelationData = $serviceClass->getHRelationSourceData($filterData, [], "");
                        return $horizontalRelationData;
                    default:
                        switch ($this->requestParam["editor"]) {
                            case "combobox":
                                return $variableConfig["combo_list"][$updateData["value"]];
                            case "datebox":
                                return get_format_date($updateData["value"]);
                            case "datetimebox":
                                return get_format_date($updateData["value"], 1);
                            default:
                                return $updateData["value"];
                        }
                }
        }
    }

    /**
     * 生成字段返回数据
     * @param $updateData
     * @return mixed
     */
    protected function generateFieldData($updateData)
    {
        if (array_key_exists("original_field", $this->requestParam)) {
            switch ($this->requestParam["field"]) {
                case "priority":
                    $updateData["priority"] = L(string_initial_letter($updateData["priority"], "_"));
                    $updateData["value_show"] = $updateData["priority"];
                    break;
                case "status":
                    $updateData["status"] = get_user_status($updateData["status"])["name"];
                    $updateData["value_show"] = $updateData["status"];
                    break;
                case "correspond":
                    $updateData["correspond"] = status_corresponds_lang($updateData["correspond"]);
                    $updateData["value_show"] = $updateData["correspond"];
                    break;
                case "public":
                    $updateData["public"] = public_type($updateData["public"])["name"];;
                    $updateData["value_show"] = $updateData["public"];
                    break;
                case "type":
                    switch ($this->requestParam["module"]) {
                        case "action":
                            $updateData["type"] = get_action_type($updateData["type"])["name"];
                            $updateData["value_show"] = $updateData["type"];
                            break;
                        case "note":
                            $updateData["type"] = get_note_type($updateData["type"])["name"];
                            $updateData["value_show"] = $updateData["type"];
                            break;
                        case "tag":
                            $updateData["type"] = tag_type($updateData["type"])["name"];
                            $updateData["value_show"] = $updateData["type"];
                            break;
                    }
                    break;
            }

            // 自定义字段显示value
            if ($this->requestParam["field_type"] === "custom") {
                $updateData["value_show"] = $this->formatFieldData($updateData);
            } else {
                if (strpos($this->requestParam["field"], "_id") !== false) {
                    $moduleField = str_replace("_id", "", $this->requestParam["field"]);
                    if (in_array($moduleField, ["parent", "role"])) {
                        $moduleField = $this->requestParam["module"];
                    }
                    if ($updateData[$this->requestParam["field"]] > 0) {
                        $modelClassName = '\\Common\\Model\\' . string_initial_letter($moduleField) . 'Model';
                        $modelObj = new $modelClassName();
                        $findData = $modelObj->findData(["filter" => ["id" => $updateData[$this->requestParam["field"]]]]);
                        $value = $findData[$this->requestParam["original_field"]];
                    } else {
                        $value = "";
                    }
                    $updateData[$this->requestParam["original_field"]] = $value;
                    $updateData["value_show"] = $value;
                } else {
                    $updateData["value_show"] = $updateData[$this->requestParam["original_field"]];
                }
            }
        }

        return $updateData;
    }

    /**
     * 生成返回数据
     * @param $moduleData
     * @param $updateData
     * @param $messageData
     * @param $userIdList
     * @return array
     */
    protected function generateResponse($moduleData, $updateData, $messageData, $userIdList)
    {
        $responseData = [
            'module_data' => $moduleData,
            'param' => $this->requestParam,
            'type' => $this->messageType,
            'from_type' => $this->messageFromType,
            'operate' => $this->messageOperate,
            'data' => $this->generateFieldData($updateData),
            'message' => $messageData,
            'detail_url' => $this->generateDetailUrl($this->projectId, $moduleData["id"], $updateData["id"]),
            'member' => $userIdList,
            'created' => time()
        ];

        return $responseData;
    }

    /**
     * 生成详情页面链接
     * @param $projectId
     * @param $moduleId
     * @param $itemId
     * @return string
     */
    protected function generateDetailUrl($projectId, $moduleId, $itemId)
    {
        return generate_details_page_url($projectId, $moduleId, $itemId);
    }

    /**
     * 获取message表的数据
     * @param $projectId
     * @param $moduleData
     * @param $updateData
     * @param $messageContent
     * @param $senderData
     * @param $receiverData
     * @return array
     */
    protected function generateMessage($projectId, $moduleData, $updateData, $messageContent, $senderData, $receiverData)
    {
        $messageData = [
            'message' => [
                'operate' => $this->messageOperate,
                'type' => 'at',
                'module_id' => $moduleData['id'],
                'project_id' => $projectId,
                'primary_id' => $updateData['id'],
                'emergent' => $this->emergent,
                'from' => session("event_from"),
                'content' => $messageContent,
                'sender' => $senderData,
                'identity_id' => json_decode(session("page_identity"), true),
                'email_template' => $this->emailTemplate,
                'created_by' => fill_created_by(),
                'created' => time()
            ],
            'member' => $receiverData,
        ];
        return $messageData;
    }


    /**
     * 获取消息数据
     * @param $moduleFilter
     * @param $updateData
     * @return array
     */
    protected function getMessageData($moduleFilter, $updateData)
    {
        // 获取当前模块数据
        $moduleData = $this->getModuleData($moduleFilter);

        // 获取发送者数据
        $senderData = $this->getSenderData();

        // 获取接收者数据
        $receiverData = $this->getReceiverData($updateData["id"], $moduleData["id"], $moduleData["code"]);

        // 获取消息内容
        $messageContent = $this->getMessageContent($senderData["name"], $moduleData["code"], $updateData);

        // 生成返回消息数据
        $responseData = $this->generateResponse($moduleData, $updateData, $messageContent, $receiverData["user_ids"]);

        // 生成消息服务器数据
        $messageData = $this->generateMessage($this->projectId, $moduleData, $updateData, $messageContent, $senderData, $receiverData["member_data"]);

        return ['message_data' => $messageData, 'response_data' => $responseData];
    }

    /**
     * 修改后，消息处理
     * @param $data
     * @param $moduleFilter
     * @return array
     */
    public function afterModify($data, $moduleFilter)
    {
        $this->data = $this->getMessageData($moduleFilter, $data);
        $this->message();
        return success_response($this->message, $this->data['response_data']);
    }

    /**
     * 新增后，消息处理
     * @param $data
     * @param $moduleFilter
     * @return array
     */
    public function afterAdd($data, $moduleFilter)
    {
        $this->data = $this->getMessageData($moduleFilter, $data);
        $this->message();
        return success_response($this->message, $this->data['response_data']);
    }

    /**
     * 删除后，消息处理
     * @param $data
     * @param $moduleFilter
     * @return array
     */
    public function afterDelete($data, $moduleFilter)
    {
        $this->data = $this->getMessageData($moduleFilter, $data);
        $this->message();
        return success_response($this->message, $this->data['response_data']);
    }
}