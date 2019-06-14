<?php
// +----------------------------------------------------------------------
// | 文件 项目服务
// +----------------------------------------------------------------------
// | 主要服务于文件数据处理
// +----------------------------------------------------------------------
// | 错误编码头 222xxx
// +-----------------------------------------------

namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\DownloadModel;
use Common\Model\EntityModel;
use Common\Model\FileCommitModel;
use Common\Model\FileModel;
use Common\Model\ModuleModel;
use Common\Model\ReviewLinkModel;
use Common\Model\StatusModel;

class FileService
{
    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getFileGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $fileModel = new FileModel();
        $resData = $fileModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getDetailGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $fileModel = new FileModel();
        $resData = $fileModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 记录下载文件
     * @param $fileName
     * @param $path
     * @return array
     */
    public function recordDownloadFile($fileName, $path)
    {
        $downloadModel = new DownloadModel();
        $addData = [
            'name' => $fileName,
            'path' => $path
        ];
        $resData = $downloadModel->addItem($addData);
        if (!$resData) {
            // 添加下载文件失败错误码 002
            throw_strack_exception($downloadModel->getError(), 222002);
        } else {
            // 返回成功数据
            return success_response($downloadModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取下载文件地址
     * @param $id
     * @return array|mixed
     */
    public function getDownloadFilePath($id)
    {
        $downloadModel = new DownloadModel();
        $resData = $downloadModel->findData(["filter" => ['id' => $id]]);
        return $resData;
    }

    /**
     * 获取媒体时间线文件提交数据
     * @param $filter
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function getTimeLineFileCommitData($filter, $param)
    {
        // 获取FileCommit数据
        $fileCommitModel = new FileCommitModel();
        $resData = $fileCommitModel->selectData([
            'filter' => $filter,
            'fields' => 'id,name,version,module_id,link_id',
        ]);

        foreach ($resData["rows"] as &$item) {
            $item = $this->getFormatFileCommitData($item, $param["entity_param"]["file_commit_module_id"]);
        }

        return $resData;
    }

    /**
     * 获取播放列表媒体时间线数据
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function getPlaylistTimeLineData($param)
    {
        // 过滤条件
        $options = [
            "filter" => ["entity_id" => $param["entity_id"], "project_id" => $param["entity_param"]["project_id"]],
            "fields" => "id as review_id,index,file_commit_id as id",
            "order" => "index asc"
        ];

        $reviewLinkModel = new ReviewLinkModel();
        $resData = $reviewLinkModel->selectData($options);

        $fileCommitModel = new FileCommitModel();
        foreach ($resData['rows'] as &$item) {
            $fileCommitData = $fileCommitModel->findData(["filter" => ['id' => $item['id']], "fields" => "name,version,module_id,link_id"]);
            if (!empty($fileCommitData)) {
                $item['name'] = $fileCommitData['name'];
                $item['version'] = $fileCommitData['version'];
                $item['module_id'] = $fileCommitData['module_id'];
                $item['link_id'] = $fileCommitData['link_id'];
            } else {
                $item['name'] = "";
                $item['version'] = 0;
                $item['module_id'] = 0;
                $item['link_id'] = 0;
            }

            $item = $this->getFormatFileCommitData($item, $param["entity_param"]["file_commit_module_id"]);
        }

        // 获取实体名称
        $entityModel = new EntityModel();
        $entityData = $entityModel->where(["id" => $param["entity_id"]])->find();

        // 获取是否关注
        $followService = new FollowService();
        $followStatus = $followService->getItemFollowStatus($param["entity_param"]["review_module_id"], $param["entity_id"]);

        return [
            "total" => $resData["total"],
            "rows" => $resData["rows"],
            "entity_name" => $entityData["name"],
            "entity_id" => $entityData["id"],
            "is_follow" => $followStatus["follow_status"]
        ];
    }

    /**
     * 获取文件提交格式化数据
     * @param $data
     * @param $moduleId
     * @return mixed
     * @throws \Exception
     */
    public function getFormatFileCommitData($data, $moduleId)
    {
        // 获取Module字典数据
        $moduleModel = new ModuleModel();
        $moduleData = $moduleModel->field("id,name,code,type")->select();
        $moduleMapData = array_column($moduleData, null, 'id');

        $statusModel = new StatusModel();
        $statusData = $statusModel->field("id,name,code")->select();
        $statusMapData = array_column($statusData, null, "id");

        $data["version"] = version_format($data["version"]);
        $data["group_md5"] = $data["version"];
        // 获取media数据
        $mediaService = new MediaService();
        try {
            $data["thumb"] = $mediaService->getMediaThumb(["link_id" => $data["id"], 'module_id' => $moduleId]);
            $data["media_data"] = $mediaService->getMediaData(["link_id" => $data["id"], 'module_id' => $moduleId, 'relation_type' => 'direct', 'type' => 'thumb']);
        } catch (\Exception $e) {
            $data["media_data"] = ['has_media' => 'no', 'param' => []];
            $data["thumb"] = "";
        }
        $data["task_info"] = [];

        if ($data["module_id"] > 0) {
            $moduleCode = $moduleMapData[$data["module_id"]]["type"] === "fixed" ? $moduleMapData[$data["module_id"]]["code"] : $moduleMapData[$data["module_id"]]["type"];
            // 获取任务名称
            $class = '\\Common\\Model\\' . string_initial_letter($moduleCode) . 'Model';
            $modelObj = new $class();
            $relationData = $modelObj->findData(['filter' => ['id' => $data['link_id']]]);

            if (!empty($relationData)) {
                // 获取实体信息
                $entityModel = new EntityModel();
                $entityData = $entityModel->findData([
                    "filter" => ['id' => $relationData['entity_id']]
                ]);
                $statusCode = $relationData["status_id"] > 0 ? $statusMapData[$relationData["status_id"]]["code"] : "";

                $data["task_info"] = [
                    [
                        "lang" => L("entity_name"),
                        "value" => $entityData["name"]
                    ],
                    [
                        "lang" => L("module"),
                        "value" => $moduleMapData[$entityData["module_id"]]["name"]
                    ],
                    [
                        "lang" => L("base_name"),
                        "value" => $relationData["name"]
                    ],
                    [
                        "lang" => L("base_code"),
                        "value" => $relationData["code"]
                    ],
                    [
                        "lang" => L("status"),
                        "value" => $statusCode
                    ]
                ];
            }
        }
        $data["uuid_md5"] = md5(create_uuid());

        return $data;
    }

    /**
     * 获取指定审核任务时间线数据
     * @param $param
     * @return array
     * @throws \Exception
     */
    public function getReviewTaskTimeLineData($param)
    {
        $baseModel = new BaseModel();
        $entityId = $baseModel->where(['id' => $param["base_id"]])->getField("entity_id");
        $entityParam = [
            'entity_id' => $entityId,
            'entity_param' => $param["entity_param"]
        ];
        $resData = $this->getPlaylistTimeLineData($entityParam);

        return $resData;
    }
}
