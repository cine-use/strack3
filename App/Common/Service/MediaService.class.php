<?php
// +----------------------------------------------------------------------
// | Media媒体服务服务层
// +----------------------------------------------------------------------
// | 主要服务于Media媒体数据处理
// +----------------------------------------------------------------------
// | 错误编码头 210xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\EntityModel;
use Common\Model\FileCommitModel;
use Common\Model\MediaModel;
use Common\Model\MediaServerModel;
use Common\Model\ReviewLinkModel;
use Ws\Http\Request;
use Ws\Http\Request\Body;

class MediaService extends EventService
{

    protected $_headers = [
        'Accept' => 'application/json',
        'content-type' => 'application/json'
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
     * 远程请求数据
     * @param $data
     * @param $url
     * @return bool
     * @throws \Ws\Http\Exception
     */
    protected function postData($data, $url)
    {
        $http = Request::create();
        $body = Body::json($data);
        $responseData = $http->post($url, $this->_headers, $body);
        if ($responseData->code === 200) {
            if ($responseData->body->status === 200) {
                return $responseData->body->data;
            } else {
                $this->errorMsg = $responseData->body->message;
                return false;
            }
        } else {
            $this->errorMsg = L('Media_Server_Exception');
            return false;
        }
    }

    /**
     * 上传媒体文件
     * @param $file
     * @return array|bool
     */
    public function uploadMedia($file)
    {
        try {
            $mediaUploadServer = $this->getMediaUploadServer();
            $data = [
                'token' => $mediaUploadServer['token'],
                'size' => '250x140'
            ];
            $http = Request::create();
            $body = Body::multipart($data, [
                'Filedata' => $file
            ]);

            $responseData = $http->post($mediaUploadServer['upload_url'], ['Accept' => 'application/json'], $body);
            if ($responseData->code === 200) {
                if ($responseData->body->status === 200) {
                    $mediaData = object_to_array($responseData->body->data);
                    return ["media_data" => $mediaData, "media_server" => $mediaUploadServer];
                } else {
                    $this->errorMsg = $responseData->body->message;
                    return false;
                }
            } else {
                $this->errorMsg = L('Media_Server_Exception');
                return false;
            }
        } catch (\exception $e) {
            // 没有可用媒体服务器
            $this->errorMsg = L('Media_Server_Exception');
            return false;
        }
    }

    /**
     * 新增媒体数据
     * @param $data
     * @return array
     * @throws \Ws\Http\Exception
     */
    protected function addMediaData($data)
    {
        $this->requestParam = $data;

        $mediaModel = new MediaModel();
        // 添加新的媒体信息
        $resData = $mediaModel->addItem($data);
        if (!$resData) {
            // 添加媒体失败错误码 001
            throw_strack_exception($mediaModel->getError(), 210001);
        } else {
            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $moduleFilter = ['id' => $resData['module_id']];
                $this->message = $mediaModel->getSuccessMassege();
                $this->messageFromType = 'thumb';
                $this->messageOperate = 'add';
                $mediaData = $this->getMediaData(["link_id" => $data["link_id"], "module_id" => $resData["module_id"], "relation_type" => $data["relation_type"], 'type' => $data["type"], "variable_id" => $data["variable_id"]]);
                $mediaData["id"] = $resData["id"];
                $mediaData["value_show"] = $resData["thumb"];
                return $this->afterAdd($mediaData, $moduleFilter);
            } else {
                return success_response($mediaModel->getSuccessMassege(), $resData);
            }
        }
    }

    /**
     * 修改媒体数据
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    protected function modifyMediaData($param)
    {
        $this->requestParam = $param;

        $mediaModel = new MediaModel();
        $mediaId = $mediaModel->where([
            'link_id' => $param['link_id'],
            'module_id' => $param['module_id'],
            'type' => $param['type'],
            'relation_type' => $param['relation_type'],
            'variable_id' => $param['variable_id']
        ])->getField("id");

        if ($mediaId > 0) {
            // 更新已经存在的媒体信息
            $param['id'] = $mediaId;

            // 删除老的缩略图
            $this->clearMediaThumbnail(['id' => $mediaId], 'modify');

            // 修改缩略图数据
            $resData = $mediaModel->modifyItem($param);

            if (!$resData) {
                // 修改媒体失败错误码 002
                throw_strack_exception($mediaModel->getError(), 210002);
            } else {
                if (session("event_from") === "strack_web") {
                    // 获取消息返回数据
                    $moduleFilter = ['id' => $param['module_id']];
                    $this->message = $mediaModel->getSuccessMassege();
                    $this->messageFromType = 'thumb';
                    $this->messageOperate = 'update';
                    $mediaData = $this->getMediaData(["link_id" => $param['link_id'], "module_id" => $param['module_id'], "relation_type" => $param["relation_type"], "type" => $param["type"], "variable_id" => $param["variable_id"]]);
                    $mediaData["id"] = $resData["id"];
                    $mediaData["value_show"] = $resData["thumb"];
                    return $this->afterModify($mediaData, $moduleFilter);
                } else {
                    return success_response($mediaModel->getSuccessMassege(), $resData);
                }
            }
        } else {
            return $this->addMediaData($param);
        }
    }

    /**
     * 添加或者更新media
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function saveMediaData($param)
    {
        // 生成 media data
        $mediaData = $param['media_data'];
        $mediaSize = '';
        $thumbUrl = '';
        switch ($mediaData["type"]) {
            case 'video':
                // 视频保存原始尺寸
                $mediaSize = "{$mediaData["width"]}x{$mediaData["height"]}";
                $thumbUrl = "{$param['media_server']['request_url']}{$mediaData['path']}{$mediaData['md5_name']}.jpg";
                break;
            case 'image':
                // 获取图片上传尺寸
                $mediaSize = $mediaData["size"];
                $sizeArray = explode(',', $mediaSize);
                $minSize = 999999;
                $minSizeString = 'origin';
                foreach ($sizeArray as $sizeItem) {
                    if ($sizeItem !== 'origin' && strpos($sizeItem, 'x') !== false) {
                        if (explode('x', $sizeItem)[0] < $minSize) {
                            $minSizeString = $sizeItem;
                        }
                    }
                }
                $thumbUrl = "{$param['media_server']['request_url']}{$mediaData['path']}{$mediaData['md5_name']}_{$minSizeString}.{$mediaData['ext']}";
                break;
        }

        $relationType = "direct";
        $relationCustomFields = "";
        $variableConfig = [];
        if (array_key_exists("field_type", $param) && $param["field_type"] === "custom") {
            $relationType = "horizontal";
            $variableService = new VariableService();
            $variableConfig = $variableService->getVariableConfig($param["variable_id"]);
            $relationCustomFields = $variableConfig["code"];
        }

        if (!array_key_exists("base_url", $mediaData)) {
            $mediaData["base_url"] = $param['media_server']['request_url'] . $mediaData['path'];
        }
        $addData = [
            'link_id' => $param["link_id"],
            'module_id' => $param["module_id"],
            'media_server_id' => $param["media_server"]['id'],
            'size' => $mediaSize,
            'md5_name' => $mediaData['md5_name'],
            'thumb' => $thumbUrl,
            'relation_type' => $relationType,
            'variable_id' => array_key_exists("variable_id", $param) ? $param["variable_id"] : 0,
            'param' => $mediaData,
            'relation_custom_fields' => $relationCustomFields
        ];

        $resData = [];
        // 判断当前缩略图处理模式
        switch ($param["mode"]) {
            case 'multiple':
                $addData['type'] = 'attachment';
                $resData = $this->addMediaData($addData);
                break;
            case 'batch':
                $addData['type'] = 'thumb';
                // 有多条
                $ids = explode(",", $param["link_id"]);
                foreach ($ids as $id) {
                    $addData['link_id'] = $id;
                    $resData = $this->modifyMediaData($addData);
                }
                break;
            default:
                $addData['type'] = 'thumb';
                $resData = $this->modifyMediaData($addData);
                break;
        }


        // 自定义字段媒体，数据保存到中间表Horizontal
        if (array_key_exists("field_type", $param) && $param["field_type"] === "custom") {
            try {
                // 获取主键（web端和api端格式不一样）
                $primaryId = session("event_from") === "strack_web" ? $resData["data"]["data"]["id"] : $resData["data"]["id"];
                $updateData = [
                    "link_id" => $param['link_id'],
                    "module_id" => $param['module_id'],
                    "value" => $primaryId,
                    "relation_module_id" => $variableConfig["relation_module_id"],
                    "variable_id" => $param['variable_id'],
                ];
                $horizontalService = new HorizontalService();
                $horizontalService->saveHorizontalRelationData($updateData);
            } catch (\Exception $e) {

            }
        }

        return $resData;
    }

    /**
     * 获取指定媒体信息
     * @param $filter
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getMediaData($filter)
    {
        $mediaModel = new MediaModel();
        $mediaItem = $mediaModel->findData(["filter" => $filter]);
        if (!empty($mediaItem)) {
            // 获取媒体服务器信息
            $mediaServerData = $this->getMediaServerItem($mediaItem['media_server_id']);
            $url = $mediaServerData['request_url'] . "/media/get?sign={$mediaServerData['token']}";
            // 获取媒体
            $postResult = $this->postData(['md5_name' => $mediaItem['md5_name']], $url);
            if (!$postResult) {
                return ['has_media' => 'no', 'param' => []];
            } else {
                $mediaItemData = object_to_array($postResult->param);
                $mediaItemData['base_url'] = $mediaServerData['request_url'] . "{$mediaItemData['path']}";
                if ($mediaItemData['type'] === 'image') {
                    $mediaItemData['size'] = explode(',', $mediaItemData['size']);
                }
                return ['has_media' => 'yes', 'param' => $mediaItemData];
            }
        } else {
            return ['has_media' => 'no', 'param' => []];
        }
    }

    /**
     * 直接获取缩略图
     * @param $filter
     * @return string
     */
    public function getMediaThumb($filter)
    {
        $mediaModel = new MediaModel();
        $mediaItem = $mediaModel->findData(["filter" => $filter, 'fields' => 'thumb']);
        return !empty($mediaItem) ? $mediaItem['thumb'] : '';
    }

    /**
     * 获取多条媒体信息
     * @param $filter
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getMediaSelectData($filter)
    {
        // 根据条件获取所有媒体信息
        $mediaModel = new MediaModel();
        $mediaData = $mediaModel->selectData(["filter" => $filter]);

        // 根据media_server_id分组数据
        $mediaSelectData = [];

        // MD5 Name 数据映射字典
        $mediaMd5NameDict = [];

        foreach ($mediaData["rows"] as $mediaItem) {
            $mediaMd5NameDict[$mediaItem["md5_name"]] = $mediaItem;
            if (array_key_exists($mediaItem['media_server_id'], $mediaSelectData)) {
                array_push($mediaSelectData[$mediaItem['media_server_id']], $mediaItem["md5_name"]);
            } else {
                $mediaSelectData[$mediaItem['media_server_id']] = [$mediaItem["md5_name"]];
            }
        }

        $selectMediaData = ['has_media' => 'no', 'param' => []];
        // 批量查询媒体数据
        foreach ($mediaSelectData as $key => $item) {
            $resData = $this->selectMediaData($key, $item);
            if ($resData["has_media"] === 'yes') {
                // 把media id 重新写入媒体数据
                foreach ($resData["param"] as &$mediaItem) {
                    $mediaItem["media_id"] = $mediaMd5NameDict[$mediaItem["md5_name"]]["id"];
                }
                $selectMediaData['param'] = array_merge($selectMediaData['param'], $resData["param"]);
            }

            if (!empty($selectMediaData['param'])) {
                $selectMediaData['has_media'] = "yes";
            }
        }
        return $selectMediaData;
    }

    /**
     * 获取多个媒体信息
     * @param $mediaServiceId
     * @param $md5NameList
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function selectMediaData($mediaServiceId, $md5NameList)
    {
        if (!empty($mediaServiceId) && is_array($md5NameList)) {
            // 获取媒体服务器信息
            $mediaServerData = $this->getMediaServerItem($mediaServiceId);
            $url = $mediaServerData['request_url'] . "/media/select?sign={$mediaServerData['token']}";

            // 获取媒体
            $postResult = $this->postData(['md5_name' => join(",", $md5NameList)], $url);

            if (!$postResult) {
                return ['has_media' => 'no', 'param' => []];
            } else {
                $mediaListData = [];
                foreach ($postResult as $mediaIte) {
                    $mediaItemParam = object_to_array($mediaIte);
                    $mediaItemData = $mediaItemParam["param"];
                    $mediaItemData['base_url'] = $mediaServerData['request_url'] . "{$mediaItemData['path']}";
                    if ($mediaItemData['type'] === 'image') {
                        $mediaItemData['size'] = explode(',', $mediaItemData['size']);
                    }
                    $mediaItemData["media_id"] = $mediaItemParam["id"];
                    array_push($mediaListData, $mediaItemData);
                }
                return ['has_media' => 'yes', 'param' => $mediaListData];
            }
        } else {
            return ['has_media' => 'no', 'param' => []];
        }
    }

    /**
     * 批量清除缩略图
     * @param $param
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function batchClearMediaThumbnail($param)
    {
        if (strpos($param["link_id"], ",") === false && !array_key_exists("mode", $param)) {
            $result = $this->clearMediaThumbnail([
                "link_id" => $param["link_id"],
                "module_id" => $param["module_id"]
            ]);
            if (!$result) {
                throw_strack_exception($this->errorMsg);
            }
        } else {
            // 查找所有媒体
            $mediaModel = new MediaModel();
            if (array_key_exists("delete_media_ids", $param) && $param["delete_media_ids"] == "yes") {
                $filter = [
                    "id" => ["IN", $param["link_id"]],
                ];
            } else {
                $filter = [
                    "link_id" => ["IN", $param["link_id"]],
                    "module_id" => $param["module_id"]
                ];
            }

            // 查找相关媒体信息
            $mediaData = $mediaModel->selectData([
                "filter" => $filter
            ]);

            foreach ($mediaData["rows"] as $mediaItem) {
                $mediaSelectData = $mediaModel->selectData(["filter" => ["md5_name" => $mediaItem["md5_name"]]]);
                if ($mediaSelectData["rows"] == 0) {
                    try {
                        $mediaServerData = $this->getMediaServerItem($mediaItem['media_server_id']);
                        $url = $mediaServerData['request_url'] . "/media/remove?sign={$mediaServerData['token']}";
                        // 清除媒体
                        $this->postData(['md5_name' => $mediaItem['md5_name']], $url);
                    } catch (\Exception $e) {

                    }
                }
                $resData = $mediaModel->where(["id" => $mediaItem["id"]])->delete();
                if (!$resData) {
                    throw_strack_exception($mediaModel->getError());
                }
            }
        }

        return success_response(L("Current_Media_Remove_SC"));
    }

    /**
     * 清除指定媒体缩略图
     * @param $filter
     * @param string $mode
     * @return bool
     * @throws \Ws\Http\Exception
     */
    public function clearMediaThumbnail($filter, $mode = 'delete')
    {
        $mediaModel = new MediaModel();
        unset($filter['mode']);
        $mediaItem = $mediaModel->findData(["filter" => $filter]);
        if (!empty($mediaItem)) {
            $mediaData = $mediaModel->selectData(["filter" => ["md5_name" => $mediaItem['md5_name']]]);
            if ($mediaData["total"] == 0) {
                // 获取媒体服务器信息
                $mediaServerData = $this->getMediaServerItem($mediaItem['media_server_id']);
                $url = $mediaServerData['request_url'] . "/media/remove?sign={$mediaServerData['token']}";
                // 清除媒体
                $postResult = $this->postData(['md5_name' => $mediaItem['md5_name']], $url);
                if (is_bool($postResult)) {
                    return false;
                }
            }

            // 删除指定数据
            if ($mode === 'delete') {
                $mediaModel->where(["id" => $mediaItem["id"]])->delete();
            }
            return true;
        } else {
            $this->errorMsg = L("Entity_No_Available_Media");
            return false;
        }
    }

    /**
     * 获取指定尺寸的媒体缩略图路径
     * @param $filter
     * @param $size
     * @return string
     * @throws \Ws\Http\Exception
     */
    public function getSpecifySizeThumbPath($filter, $size)
    {
        $mediaData = $this->getMediaData($filter);
        if (!empty($mediaData['param'])) {
            $imgSize = 'origin';
            if ($mediaData['param']['type'] === 'image' && in_array($size, $mediaData['param']['size'])) {
                $imgSize = $size;
            }
            return $mediaData['param']['base_url'] . "{$mediaData['param']['md5_name']}_{$imgSize}.{$mediaData['param']['ext']}";
        } else {
            return '';
        }
    }

    /**
     * 新增媒体服务器
     * @param $param
     * @return array
     */
    public function addMediaServer($param)
    {
        $mediaServiceModel = new MediaServerModel();
        $resData = $mediaServiceModel->addItem($param);
        if (!$resData) {
            // 添加媒体服务失败错误码 003
            throw_strack_exception($mediaServiceModel->getError(), 210003);
        } else {
            // 返回成功数据
            return success_response($mediaServiceModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改媒体服务器
     * @param $param
     * @return array
     */
    public function modifyMediaServer($param)
    {
        $mediaServiceModel = new MediaServerModel();
        $resData = $mediaServiceModel->modifyItem($param);
        if (!$resData) {
            // 修改媒体服务失败错误码 004
            throw_strack_exception($mediaServiceModel->getError(), 210004);
        } else {
            // 返回成功数据
            return success_response($mediaServiceModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除媒体服务器
     * @param $param
     * @return array
     */
    public function deleteMediaServer($param)
    {
        $mediaServiceModel = new MediaServerModel();
        $resData = $mediaServiceModel->deleteItem($param);
        if (!$resData) {
            // 删除媒体服务器失败错误码 005
            throw_strack_exception($mediaServiceModel->getError(), 210005);
        } else {
            // 返回成功数据
            return success_response($mediaServiceModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取媒体服务器表格数据
     * @param $param
     * @return mixed
     */
    public function getMediaServerGridData($param)
    {
        $options = [
            'page' => [$param["page"], $param["rows"]]
        ];
        $mediaServiceModel = new MediaServerModel();
        $mediaServiceData = $mediaServiceModel->selectData($options);
        return $mediaServiceData;
    }

    /**
     * 获取媒体服务器状态
     * @return array
     */
    public function getMediaServerStatus()
    {
        // 获取所有系统配置的媒体服务器
        $mediaServiceModel = new MediaServerModel();
        $options = [
            'fields' => 'id,name,request_url,upload_url,access_key,secret_key'
        ];
        $mediaServerData = $mediaServiceModel->selectData($options);
        $mediaServerStatusList = [];
        foreach ($mediaServerData["rows"] as $serverItem) {
            $getServerStatus = check_http_code($serverItem["request_url"]);
            array_push($mediaServerStatusList, [
                'status' => $getServerStatus['http_code'],
                'connect_time' => $getServerStatus['connect_time'],
                'id' => $serverItem['id'],
                'name' => $serverItem['name'],
                'request_url' => $serverItem['request_url'],
                'upload_url' => $serverItem['upload_url'],
                'access_key' => $serverItem['access_key'],
                'secret_key' => $serverItem['secret_key']
            ]);
        }
        return $mediaServerStatusList;
    }

    /**
     * 获取媒体指定上传服务器配置信息
     * @return array|mixed
     */
    public function getMediaUploadServer()
    {
        $mediaServerStatusList = $this->getMediaServerStatus();
        if (!empty($mediaServerStatusList)) {
            // 找到连接最快的媒体服务器
            $fastConnectTime = 99999;
            $fastMediaServer = [];
            foreach ($mediaServerStatusList as $mediaServerItem) {
                if ($mediaServerItem['connect_time'] > 0 && $mediaServerItem['connect_time'] < $fastConnectTime) {
                    $fastConnectTime = $mediaServerItem['connect_time'];
                    $fastMediaServer = $mediaServerItem;
                }
            }
            if (!empty($fastMediaServer)) {
                $token = md5($fastMediaServer["access_key"] . $fastMediaServer["secret_key"]);
                return [
                    'id' => $fastMediaServer['id'],
                    'name' => $fastMediaServer['name'],
                    'request_url' => $fastMediaServer['request_url'],
                    'upload_url' => $fastMediaServer['upload_url'],
                    'token' => $token
                ];
            } else {
                throw_strack_exception(L("Media_Server_Not_Exist"));
            }
        } else {
            throw_strack_exception(L("Media_Server_Not_Exist"));
        }
    }

    /**
     * 获取指定服务器信息
     * @param $mediaServerId
     * @return array
     */
    public function getMediaServerItem($mediaServerId)
    {
        $mediaServiceModel = new MediaServerModel();
        $serverItem = $mediaServiceModel->findData([
            "fields" => 'id,name,upload_url,request_url,access_key,secret_key',
            "filter" => [
                'id' => $mediaServerId
            ]
        ]);
        if (!empty($serverItem)) {
            $getServerStatus = check_http_code($serverItem["request_url"]);
            if ($getServerStatus['connect_time'] > 0) {
                $token = md5($serverItem["access_key"] . $serverItem["secret_key"]);
                return [
                    'id' => $serverItem['id'],
                    'name' => $serverItem['name'],
                    'request_url' => $serverItem['request_url'],
                    'upload_url' => $serverItem['upload_url'],
                    'token' => $token
                ];
            } else {
                throw_strack_exception(L('Appoint_Media_Server_Unavailable'));
            }
        } else {
            throw_strack_exception(L('Appoint_Media_Server_Not_Exist'));
        }
    }

    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getMediaGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $fileCommitModel = new FileCommitModel();
        $resData = $fileCommitModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 保存播放列表
     * @param $param
     * @return array
     */
    public function savePlaylist($param)
    {
        $reviewLinkModel = new ReviewLinkModel();
        $entityModel = new EntityModel();

        // review 审核实体的moduleId
        switch ($param["mode"]) {
            case "add":
                $entityModel->startTrans();
                try {
                    // 保存entity数据
                    $param["entity_data"]["module_id"] = $param["entity_param"]["review_module_id"];
                    $param["entity_data"]["project_id"] = $param["entity_param"]["project_id"];
                    $entityData = $entityModel->addItem($param["entity_data"]);
                    if (!$entityData) {
                        throw new \Exception($entityModel->getError());
                    }
                    // 保存review_link 数据
                    foreach ($param["file_commit_ids"] as $item) {
                        $reviewLinkSave = [
                            'entity_id' => $entityData["id"],
                            'project_id' => $param["entity_param"]["project_id"],
                            'file_commit_id' => $item["id"],
                            'index' => $item["index"],
                        ];
                        $reviewLinkData = $reviewLinkModel->addItem($reviewLinkSave);
                        if (!$reviewLinkData) {
                            throw new \Exception($reviewLinkModel->getError());
                        }
                    }
                    // 批量添加审核任务
                    $param["entity_param"]["module_id"] = $param["entity_param"]["review_module_id"];
                    $taskParam = [
                        'step_ids' => $param["step_ids"],
                        'task_rows' => $param["task_rows"],
                        'entity_param' => $param["entity_param"],
                        'entity_ids' => []
                    ];
                    array_push($taskParam["entity_ids"], ["id" => $entityData["id"], "name" => $entityData["name"]]);
                    $entityService = new EntityService();
                    $entityService->batchSaveEntityBase($taskParam);
                    $entityModel->commit(); // 提交事物
                    // 返回成功数据
                    return success_response($entityModel->getSuccessMassege(), $entityData);
                } catch (\Exception $e) {
                    $entityModel->rollback(); // 事物回滚
                    // 添加数据失败错误码 006
                    throw_strack_exception($e->getMessage(), 210006);
                }
                break;
            case "modify":
                $entityModel->startTrans();
                try {
                    // 修改entity数据
                    $param["entity_data"]["id"] = $param["entity_id"];
                    $entityData = $entityModel->modifyItem($param["entity_data"]);

                    // 删除当前时间线
                    $reviewLinkModel->deleteItem(["entity_id" => $param["entity_id"]]);

                    // 保存review_link 数据
                    foreach ($param["file_commit_ids"] as $item) {
                        $reviewLinkSave = [
                            'entity_id' => $param["entity_id"],
                            'project_id' => $param["entity_param"]["project_id"],
                            'file_commit_id' => $item["id"],
                            'index' => $item["index"],
                        ];
                        $reviewLinkData = $reviewLinkModel->addItem($reviewLinkSave);
                        if (!$reviewLinkData) {
                            throw new \Exception($reviewLinkModel->getError());
                        }
                    }

                    // 批量添加审核任务
                    $param["entity_param"]["module_id"] = $param["entity_param"]["review_module_id"];
                    $param["entity_param"]["entity_id"] = $param["entity_id"];
                    $taskParam = [
                        'step_ids' => $param["step_ids"],
                        'task_rows' => $param["task_rows"],
                        'entity_param' => $param["entity_param"],
                        'entity_ids' => []
                    ];
                    $entityName = $entityModel->where(["id" => $param["entity_id"]])->getField("name");
                    array_push($taskParam["entity_ids"], ["id" => $param["entity_id"], "name" => $entityName]);
                    try {
                        $entityService = new EntityService();
                        $entityService->batchSaveEntityBase($taskParam, "modify");
                    } catch (\Exception $e) {

                    }
                    $entityModel->commit(); // 提交事物
                    // 返回成功数据
                    return success_response(L("Modify_Review_Sc"), $entityData);
                } catch (\Exception $e) {
                    $entityModel->rollback(); // 事物回滚
                    // 修改数据失败错误码 007
                    throw_strack_exception($e->getMessage(), 210007);
                }

                break;
            case "timeline":
                $entityId = intval($param["entity_id"]);
                $reviewLinkModel->startTrans();
                try {
                    // 删除当前时间线
                    $reviewLinkModel->deleteItem(["entity_id" => $param["entity_id"]]);

                    // 保存review_link 数据
                    foreach ($param["file_commit_ids"] as $item) {
                        $reviewLinkSave = [
                            'entity_id' => $entityId,
                            'project_id' => $param["entity_param"]["project_id"],
                            'file_commit_id' => $item["id"],
                            'index' => $item["index"],
                        ];
                        $reviewLinkData = $reviewLinkModel->addItem($reviewLinkSave);
                        if (!$reviewLinkData) {
                            throw new \Exception($reviewLinkModel->getError());
                        }
                    }
                    $reviewLinkModel->commit(); // 提交事物
                    // 返回成功数据
                    return success_response($reviewLinkModel->getSuccessMassege());
                } catch (\Exception $e) {
                    $reviewLinkModel->rollback(); // 事物回滚
                    // 添加数据失败错误码 008
                    throw_strack_exception($e->getMessage(), 210008);
                }
                break;
        }
    }
}