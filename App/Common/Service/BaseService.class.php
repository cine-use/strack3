<?php
// +----------------------------------------------------------------------
// | 基础类型服务层
// +----------------------------------------------------------------------
// | 主要服务于任务相关数据操作
// +----------------------------------------------------------------------
// | 错误编码头 201xxx
// +----------------------------------------------------------------------

namespace Common\Service;

use Common\Model\BaseModel;
use Common\Model\EntityModel;

class BaseService
{
    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getBaseGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $baseModel = new BaseModel();
        $resData = $baseModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取详情页面的表格数据
     * @param $param
     * @return mixed
     */
    public function getDetailGridData($param)
    {
        $schemaService = new SchemaService();
        if (in_array($param['module_type'], ["horizontal_relationship", "be_horizontal_relationship"])) {
            $moduleData = $schemaService->getModuleFindData(["id" => $param["module_id"]]);
            $table = $moduleData["type"] === "entity" ? $moduleData["type"] : $moduleData["code"];
            $moduleCode = $moduleData["code"];
            $horizontalService = new HorizontalService();
            switch ($param['module_type']) {
                case "horizontal_relationship":
                    $dstLinkIds = $horizontalService->getModuleRelationIds([
                        'src_module_id' => $param['parent_module_id'],
                        'src_link_id' => $param['item_id'],
                        'dst_module_id' => $param["module_id"]
                    ], "dst_link_id");
                    $request = [
                        "field" => "id",
                        "value" => join(',', $dstLinkIds),
                        "condition" => "IN",
                        "module_code" => $moduleCode,
                        "table" => string_initial_letter($table)
                    ];
                    array_push($param['filter']['request'], $request);
                    break;
                case "be_horizontal_relationship":
                    $dstLinkIds = $horizontalService->getModuleRelationIds([
                        'src_module_id' => $param['module_id'],
                        'dst_link_id' => $param['item_id'],
                        'dst_module_id' => $param["parent_module_id"]
                    ], "src_link_id");
                    $request = [
                        "field" => "id",
                        "value" => join(',', $dstLinkIds),
                        "condition" => "IN",
                        "module_code" => $moduleCode,
                        "table" => string_initial_letter($table)
                    ];
                    array_push($param['filter']['request'], $request);
                    break;
            }
        } else {
            $moduleCode = "base";
        }

        if ($param["page"] === "details_base") {
            $param['filter']['request'] = [
                [
                    "field" => "entity_id",
                    "value" => $param["item_id"],
                    "condition" => "EQ",
                    "module_code" => "base",
                    "table" => "Base"
                ],
                [
                    "field" => "entity_module_id",
                    "value" => $param["parent_module_id"],
                    "condition" => "EQ",
                    "module_code" => "base",
                    "table" => "Base"
                ]
            ];
        }

        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $modelClassName = '\\Common\\Model\\' . string_initial_letter($moduleCode) . 'Model';
        $modelClass = new $modelClassName();
        $resData = $modelClass->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取审核页面审核任务列表数据
     * @param $param
     * @return array
     */
    public function getReviewTaskList($param)
    {
        // 获取当前页面的实体ID
        $entityModel = new EntityModel();
        $entityData = $entityModel->selectData(['filter' => ["module_id" => $param["review_module_id"], "project_id" => $param["project_id"]], "fields" => "id"]);

        if ($entityData["total"] > 0) {
            $entityIds = array_column($entityData["rows"], "id");

            // 初始化条件
            $options = [
                "filter" => [
                    "entity_id" => ["IN", join(",", $entityIds)],
                    "project_id" => $param["project_id"]
                ],
                "fields" => "id,name,code,project_id,step_id,status_id,priority,created_by,created",
                "order" => "created desc",
                "page" => [$param["page_number"], $param["page_size"]]
            ];

            // 名称搜索
            if (array_key_exists("filter", $param) && !empty($param["filter"])) {
                $options["filter"]["name"] = $param["filter"]["name"];
            }

            // 查询任务数据
            $baseModel = new BaseModel();
            if ($param["type"] === "my") {
                // 获取是我的任务
                $horizontalService = new HorizontalService();
                $taskMemberData = $horizontalService->getHorizontalRelationData([
                    "src_module_id" => C("MODULE_ID")["base"],
                    "dst_module_id" => C("MODULE_ID")["user"],
                    "dst_link_id" => session("user_id"),
                    "code" => "assign",
                ]);
                $linkIds = array_column($taskMemberData, 'src_link_id');

                if (!empty($linkIds)) {
                    $options["filter"]["id"] = ["IN", join(",", $linkIds)];
                    $resData = $baseModel->selectData($options);
                } else {
                    $resData = ["total" => 0, "rows" => []];
                }
            } else {
                $resData = $baseModel->selectData($options);
            }

            $mediaService = new MediaService();
            $userService = new UserService();
            foreach ($resData["rows"] as &$item) {
                $item["thumb"] = $mediaService->getMediaThumb(["link_id" => $item["id"], "module_id" => 4]);
                // 格式化时间分组
                $item["group_md5"] = get_date_group_md5($item["created"]);
                $item["group_name"] = $item["created"];
                $userData = $userService->getUserFindField(["id" => $item["created_by"]], "name");
                $item["created_by"] = !empty($userData) ? $userData["name"] : "";
            }
        } else {
            $resData = ["total" => 0, "rows" => []];
        }

        return $resData;
    }

    /**
     * 删除指定的审核任务
     * @param $param
     * @return array
     */
    public function deleteReviewTask($param)
    {
        $baseModel = new BaseModel();
        $resData = $baseModel->deleteItem(["id" => $param["base_id"]]);
        if (!$resData) {
            // 删除任务失败错误码 002
            throw_strack_exception($baseModel->getError(), 212002);
        } else {
            // 返回成功数据
            return success_response($baseModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 获取水平关联源数据
     * @param $param
     * @param $searchValue
     * @param $mode
     * @return array
     */
    public function getHRelationSourceData($param, $searchValue, $mode)
    {
        if ($mode === "all") {
            $filter = [
                "id" => ["NOT IN", join(",", $param["link_data"])],
                "project_id" => $param["project_id"]
            ];
        } else {
            $filter = [
                "id" => ["IN", join(",", $param["link_data"])],
                "project_id" => $param["project_id"]
            ];
        }

        // 有额外过滤条件
        if (!empty($searchValue)) {
            $filter = [
                $filter,
                [
                    "name" => ["LIKE", "%{$searchValue}%"],
                    "code" => ["LIKE", "%{$searchValue}%"],
                    "_logic" => "OR"
                ],
                "_logic" => "AND"
            ];
        }

        $option = [
            "filter" => $filter,
            "fields" => "id,name,code",
        ];

        if (array_key_exists("pagination", $param)) {
            $option["page"] = [$param["pagination"]["page_number"], $param["pagination"]["page_size"]];
        }

        $baseModel = new BaseModel();
        $horizontalRelationData = $baseModel->selectData($option);

        return $horizontalRelationData;
    }
}