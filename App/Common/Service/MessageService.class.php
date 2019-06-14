<?php
// +----------------------------------------------------------------------
// | 事件日志服务层
// +----------------------------------------------------------------------
// | 主要服务于事件日志数据处理
// +----------------------------------------------------------------------
// | 错误编码头 206xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\SmsModel;
use Common\Model\UserModel;
use Ws\Http\Request;
use Ws\Http\Request\Body;
use Overtrue\EasySms\EasySms;

class MessageService
{

    protected $_headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    // 错误信息
    protected $errorMsg = '';

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->errorMsg;
    }

    /**
     * 获取事件服务器配置
     * @return array|mixed
     */
    public function getEventServer()
    {
        // 获取事件服务器配置
        $optionsService = new OptionsService();
        $logServerConfig = $optionsService->getOptionsData("log_settings");

        if (!empty($logServerConfig)) {
            // 获取事件服务器状态
            $getServerStatus = check_http_code($logServerConfig["request_url"]);
            $logServerConfig['status'] = $getServerStatus['http_code'];
            $logServerConfig['connect_time'] = $getServerStatus['connect_time'];
            $logServerConfig['token'] = md5($logServerConfig["access_key"] . $logServerConfig["secret_key"]);
            $logServerConfig["add_url"] = $logServerConfig["request_url"] . "/event/add?sign={$logServerConfig['token']}";
            $logServerConfig["find_url"] = $logServerConfig["request_url"] . "/event/find?sign={$logServerConfig['token']}";
            $logServerConfig["select_url"] = $logServerConfig["request_url"] . "/event/select?sign={$logServerConfig['token']}";
            $logServerConfig["fields_url"] = $logServerConfig["request_url"] . "/event/fields?sign={$logServerConfig['token']}";
        } else {
            // 没有配置事件服务器
            $logServerConfig = [
                'status' => 404
            ];
        }
        return $logServerConfig;
    }

    /**
     * 记录到message服务器
     * @param $data
     * @param $controllerMethod
     * @return bool
     * @throws \Ws\Http\Exception
     */
    protected function postToServer($data, $controllerMethod)
    {
        $logServerConfig = $this->getEventServer();
        if ($logServerConfig["status"] === 200) {
            // 写入到事件服务器
            $http = Request::create();
            $body = Body::json($data);
            $url = $logServerConfig['request_url'] . "/{$controllerMethod}?sign={$logServerConfig['token']}";

            $responseData = $http->post($url, $this->_headers, $body);

            if ($responseData->code === 200) {
                if ($responseData->body->status === 200) {
                    return $responseData->body->data;
                } else {
                    $this->errorMsg = $responseData->body->message;
                    return false;
                }
            } else {
                $this->errorMsg = L('Log_Server_Exception');
                return false;
            }
        } else {
            $this->errorMsg = L('Log_Server_Exception');
            return false;
        }
    }

    /**
     * 新增消息
     * @param $from
     * @param $data
     * @throws \Exception
     */
    public function addMessage($from, $data)
    {
        // 消息记录到Event服务器
        $this->postToServer($data, "message/add");
    }

    /**
     * 获取我的message数据
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getMyMessageList($param)
    {
        $userModel = new UserModel();
        $userUuid = $userModel->where(['id' => fill_created_by()])->getField('uuid');

        $filter = [
            'filter' => [
                'message' => [
                    'user_uuid' => ['-eq', $userUuid]
                ]
            ],
            'order' => [
                'message.created' => 'desc'
            ],
            'page' => [
                'page_size' => $param['rows']
            ]
        ];

        // 获取消息记录
        $messageData = $this->postToServer($filter, "message/select");
        $messageData = object_to_array($messageData);

        $userModuleId = C("MODULE_ID")["user"];
        $mediaService = new MediaService();
        foreach ($messageData['rows'] as &$item) {
            $item['sender'] = json_decode($item['sender'], true);
            $item['member'] = json_decode($item['member'], true);

            // 获取用户名称
            $item['user_name'] = $item['sender']['name'];

            // 获取用户头像
            $item['user_avatar'] = $mediaService->getMediaThumb(['module_id' => $userModuleId, 'link_id' => $item['sender']['id']]);

            // 获取媒体数据
            $item['media_data'] = $mediaService->getMediaSelectData(['module_id' => $item['module_id'], 'link_id' => $item['primary_id']]);

            // 获取成员数据
            $item['member_data'] = json_decode($item['member'], true);

            // 格式化 note 时间
            $item["created"] = date_friendly('', $item["created"]);
        }
        return $messageData;
    }

    /**
     * 获取消息盒子数据
     * @param $param
     * @return bool|mixed
     * @throws \Ws\Http\Exception
     */
    public function getSideInboxData($param)
    {
        $userModel = new UserModel();
        $userUuid = $userModel->where(['id' => session('user_id')])->getField('uuid');

        $messageFilter = [];
        if ($param['tab'] == "at_me") {
            $messageFilter["type"] = ['-eq', 'at'];
        }
        $memberFilter["user_uuid"] = ['-eq', $userUuid];
        $filter = [
            'filter' => [
                'message' => $messageFilter,
                "message_member" => $memberFilter
            ],
            'page' => [
                'page_size' => $param['page_size'],
                'page_number' => $param['page_number'],
            ]
        ];

        // 获取消息记录
        $messageData = $this->postToServer($filter, "message/select");
        if ($messageData !== false) {
            $messageData = object_to_array($messageData);
            $userModuleId = C("MODULE_ID")["user"];
            $mediaService = new MediaService();
            foreach ($messageData['rows'] as &$item) {
                $item['sender'] = json_decode($item['sender'], true);
                $item['content'] = json_decode($item['content'], true);
                $item['user_name'] = $item['sender']['name'];
                $item['user_avatar'] = $mediaService->getMediaThumb(['module_id' => $userModuleId, 'link_id' => $item['sender']['id']]);
                $item['media_data'] = $mediaService->getMediaSelectData(['module_id' => $item['module_id'], 'link_id' => $item['primary_id']]);
                $item['created'] = date_friendly('Y', $item['created']);
            }

            return $messageData;
        } else {
            return ["total" => 0, "rows" => []];
        }
    }


    /**
     * 获取指定用户未读消息数据
     * @param $userId
     * @return array|bool|mixed
     * @throws \Ws\Http\Exception
     */
    public function getUnReadData($userId)
    {
        $userModel = new UserModel();
        $userUuid = $userModel->where(['id' => $userId])->getField('uuid');

        $filter = [
            "filter" => [
                "message_member" => [
                    "user_uuid" => ['-eq', $userUuid],
                    "status" => ['-eq', "unread"]
                ]
            ]
        ];

        // 获取消息记录
        $messageData = $this->postToServer($filter, "message/getUnReadData");
        if ($messageData !== false) {
            return object_to_array($messageData);
        } else {
            return ["total" => 0, "rows" => []];
        }
    }

    /**
     * 获取指定用户未读消息条数
     * @param $userId
     * @return array|mixed
     * @throws \Ws\Http\Exception
     */
    public function getUnReadNumber($userId)
    {
        $userModel = new UserModel();
        $userUuid = $userModel->where(['id' => $userId])->getField('uuid');

        $filter = [
            "filter" => [
                "message_member" => [
                    "user_uuid" => ['-eq', $userUuid],
                    "status" => ['-eq', "unread"]
                ]
            ]
        ];

        // 获取消息记录
        $messageData = $this->postToServer($filter, "message/getUnReadNumber");

        if ($messageData !== false) {
            return object_to_array($messageData);
        } else {
            return ["massage_number" => 0, "last_message_data" => []];
        }
    }

    /**
     * 标记已读消息
     * @param $userId
     * @param $created
     * @return mixed
     * @throws \Ws\Http\Exception
     */
    public function readMessage($userId, $created)
    {
        $userModel = new UserModel();
        $userUuid = $userModel->where(['id' => $userId])->getField('uuid');

        $filter = [
            "filter" => [
                "message_member" => [
                    "user_uuid" => ['-eq', $userUuid],
                    "status" => ['-eq', "unread"],
                    "created" => ['-elt', $created]
                ]
            ]
        ];

        // 获取消息记录
        $resData = $this->postToServer($filter, "message/read");

        if ($resData !== false) {
            return object_to_array($resData);
        } else {
            throw_strack_exception("", 404);
        }
    }

    /**
     * 发送注册短信
     * @param $param
     * @return array
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    public function sendRegisterSMS($param)
    {
        // 判断登录名是否重复
        $checkLoginNameUnique = M("User")->where(["login_name" => $param["login_name"]])->count();
        if ($checkLoginNameUnique > 0) {
            throw_strack_exception(L("User_Login_Name_Repeat"), 404);
        }

        if (!check_tel_number($param["phone"])) {
            // 验证手机号码格式错误
            throw_strack_exception(L("Mobile_Phone_Number_Format_Error"), 404);
        }

        $Verify = new \Think\Verify();
        $checkVerifyCode = $Verify->check($param["system_verify_code"], 'register');
        if (!$checkVerifyCode) {
            // 错误验证码
            throw_strack_exception(L("Verify_Code_Error"), 404);
        }

        // 判断当前手机号码
        $ip = get_client_ip();

        // 判断同一ip一天只能发起注册15次
        if ($this->checkIpRegisterLimit($ip, 15)) {
            throw_strack_exception(L("Register_Too_Frequent"), 404);
        }

        $code = create_sms_code();
        $currentTime = time();
        $deadline = $currentTime + 1800;
        $batch = "{$param["system_verify_code"]}_{$currentTime}";

        $addSMSData = $this->addSMSData([
            'type' => 'register',
            'phone' => $param["phone"],
            'batch' => $batch,
            'ip' => $ip,
            'validate_code' => $code,
            'deadline' => $deadline
        ]);

        $this->sendSMS([
            'phone' => $param["phone"],
            'template' => 'register',
            'code' => $code,
            'content' => "注册码：{$code}",
            'deadline' => 30
        ], 'qcloud');

        return success_response(L("Send_SMS_SC"), ['batch' => $batch, 'sms_id' => $addSMSData["id"]]);
    }

    /**
     * 发送短信
     * @param $param
     * @param $gateway
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function sendSMS($param, $gateway)
    {
        $config = C('SMS');
        $easySms = new EasySms($config);
        try {
            $easySms->send($param["phone"], [
                'content' => $param["content"],
                'template' => $config["template"][$param["template"]],
                'data' => [
                    'code' => $param["code"],
                    'type' => '',
                    'deadline' => $param["deadline"]
                ],
            ], [$gateway]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $e) {
            switch ($gateway) {
                case "qcloud":
                    throw_strack_exception($e->getExceptions()[$gateway]->raw['errmsg'], 404);
                    break;
                default:
                    throw_strack_exception($e->getMessage(), 404);
                    break;
            }
        }
    }

    /**
     * 短信写入到数据库
     * @param $param
     * @return array|bool|mixed
     */
    protected function addSMSData($param)
    {
        $smsModel = new SmsModel();
        $resData = $smsModel->addItem($param);
        if (!$resData) {
            // 写入短信失败
            throw_strack_exception($smsModel->getError(), 404);
        }
        return $resData;
    }

    /**
     * 判断当前IP访问次数是否超过了限制
     * @param $ip
     * @param int $limit
     * @return bool
     */
    protected function checkIpRegisterLimit($ip, $limit = 15)
    {
        $currentDayTime = get_current_day_range(time());
        $filter = [
            'ip' => $ip,
            'created' => ['between', [$currentDayTime["sdate"], $currentDayTime["edate"]]]
        ];
        $smsModel = new SmsModel();
        $countSendNumber = $smsModel->where($filter)->count();
        if ($countSendNumber >= $limit) {
            return true;
        }
        return false;
    }
}