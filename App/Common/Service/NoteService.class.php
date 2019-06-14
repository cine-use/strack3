<?php
// +----------------------------------------------------------------------
// | Note动态服务服务层
// +----------------------------------------------------------------------
// | 主要服务于Note动态数据处理
// +----------------------------------------------------------------------
// | 错误编码头 212xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\FileCommitModel;
use Common\Model\MemberModel;
use Common\Model\NoteModel;
use Common\Model\TagLinkModel;

class NoteService extends EventService
{
    /**
     * 删除Note数据
     * @param $param
     * @param string $mode 区分是表格删除还是详情页面删除
     * @return array
     */
    public function deleteNote($param, $mode = "details")
    {
        $noteModel = new NoteModel();
        $resData = $noteModel->deleteItem(['id' => ['IN', $param['id']]]);

        try {
            // 删除媒体数据
            $mediaService = new MediaService();
            $mediaService->batchClearMediaThumbnail([
                'link_id' => $param['id'],
                'module_id' => $param['module_id'],
                'mode' => 'batch'
            ]);

            // 删除反馈下tagLink相关数据
            $tagService = new TagService();
            $tagService->deleteTagLink([
                "link_id" => ["IN", $param["id"]],
                "module_id" => $param['module_id']
            ]);
        } catch (\Exception $e) {

        }

        if (!$resData) {
            // 删除Note失败错误码 001
            throw_strack_exception($noteModel->getError(), 212001);
        } else {
            $message = $noteModel->getSuccessMassege();
            if ($mode === "widget_grid" || session("event_from") !== "strack_web") {
                // 返回当新增数据
                return success_response($message, $resData);
            } else {
                // 获取消息返回数据
                $moduleFilter = ['id' => $param['module_id']];
                $this->projectId = array_key_exists('project_id', $param) ? $param['project_id'] : 0;
                $this->message = $message;
                $this->messageFromType = 'note';
                $this->messageOperate = 'delete';
                $this->data = ['id' => $param['id']];
                return $this->afterDelete($this->data, $moduleFilter);
            }
        }
    }

    /**
     * 获取表格数据
     * @param $param
     * @return mixed
     */
    public function getNoteGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $noteModel = new NoteModel();
        $resData = $noteModel->getRelationData($schemaFields);

        return $resData;
    }

    /**
     * 获取单条note信息
     * @param $param
     * @param $moduleId
     * @return mixed
     * @throws \Ws\Http\Exception
     */
    public function getOneNoteData($param, $moduleId)
    {
        $noteModel = new NoteModel();
        $noteData = $noteModel->findData(["filter" => ["id" => $param['note_id']]]);
        $resData = $this->getFormatNoteData($noteData, $moduleId);
        return $resData;
    }

    /**
     * 查询Note列表数据，区分是否是需要置顶数据
     * @param $param
     * @param $moduleId
     * @param string $stick
     * @return array
     * @throws \Ws\Http\Exception
     */
    private function selectNoteListData($param, $moduleId, $stick = "no")
    {
        // 查找关联file commit ids
        $fileCommitModel = new FileCommitModel();
        $fileCommitData = $fileCommitModel->field("id")->where(["link_id" => $param["item_id"], "module_id" => $param["module_id"]])->select();

        if (!empty($fileCommitData)) {
            $fileCommitIds = array_column($fileCommitData, "id");
            $filter = [
                [
                    [
                        "module_id" => $param["module_id"],
                        "link_id" => $param["item_id"]
                    ],
                    [
                        "file_commit_id" => ["IN", join(",", $fileCommitIds)]
                    ],
                    "_logic" => "OR"
                ],
                "stick" => $stick,
                "_logic" => "AND"
            ];
        } else {
            $filter = [
                "module_id" => $param["module_id"],
                "link_id" => $param["item_id"],
                "stick" => $stick
            ];
        }

        // 获取Note列表
        $options = [
            "filter" => $filter,
            "order" => "created desc"
        ];

        if ($stick === "no") {
            $options["page"] = [$param["page_number"], $param["page_size"]];
        }

        $noteModel = new NoteModel();
        $noteData = $noteModel->selectData($options);

        foreach ($noteData["rows"] as &$noteItem) {
            $noteItem = $this->getFormatNoteData($noteItem, $moduleId);
        }

        return $noteData;
    }

    /**
     * 获取Note动态列表数据
     * @param $param
     * @param $moduleId
     * @return array
     * @throws \Ws\Http\Exception
     */
    public function getNoteListData($param, $moduleId)
    {

        // 非置顶 note list
        $noteData = $this->selectNoteListData($param, $moduleId, 'no');

        $userDataInfo = [];
        $stickNoteData = [];
        if ($param["status"] === "new") {

            // 置顶note list
            $stickNoteData = $this->selectNoteListData($param, $moduleId, "yes");

            // 当前用户信息
            $mediaService = new MediaService();
            $userService = new UserService();
            $userDataInfo = $userService->getUserInfo(session("user_id"));
            $userDataInfo['avatar'] = $mediaService->getSpecifySizeThumbPath(['link_id' => session("user_id"), 'module_id' => C("MODULE_ID")["user"]], '90x90');
        }

        return ["user_data" => $userDataInfo, "stick_note_list" => $stickNoteData, "note_list" => $noteData];
    }

    /**
     * 添加Note数据
     * @param $param
     * @param $moduleId
     * @return array
     */
    public function addNote($param, $moduleId)
    {
        $this->requestParam = $param;

        $noteModel = new NoteModel();
        $noteModel->startTrans();
        try {
            // 保存note信息
            $saveData = [
                'type' => $param["type"],
                'module_id' => $param["module_id"],
                'link_id' => $param["item_id"],
                'status_id' => $param["status_id"],
                'stick' => $param["stick"],
                'parent_id' => $param["parent_id"],
                'project_id' => $param["project_id"],
                'text' => $param["text"],
                'file_commit_id' => $param["file_commit_id"]
            ];
            $noteData = $noteModel->addItem($saveData);
            if (!$noteData) {
                throw new \Exception($noteModel->getError());
            } else {
                // 保存media信息
                if (!empty($param["images"])) {
                    $mediaData = $this->saveMedia($param, $noteData, $moduleId);
                    $noteData["media_data"] = $mediaData;
                }

                // 保存tag_link信息
                if (!empty($param["tags"])) {
                    $tagData = $this->saveTag($param, $noteData, $moduleId);
                    $noteData["tag_data"] = $tagData;
                }

                // 保存member信息
                if (!empty($param["at_user_ids"])) {
                    $memberData = $this->saveMember($param, $noteData, $moduleId);
                    $noteData["member_data"] = $memberData;
                }
            }
            $noteModel->commit(); // 提交事物

            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $moduleFilter = ['id' => $moduleId];
                $this->projectId = $param['project_id'];
                $this->message = $noteModel->getSuccessMassege();
                $this->messageFromType = 'note';
                $this->messageOperate = 'add';
                $noteData = $this->getFormatNoteData($noteData, $moduleId);
                return $this->afterAdd($noteData, $moduleFilter);
            } else {
                return success_response($noteModel->getSuccessMassege(), $noteData);
            }
        } catch (\Exception $e) {
            $noteModel->rollback(); // 事物回滚
            // 添加数据失败错误码 002
            throw_strack_exception($e->getMessage(), 212002);
        }
    }

    /**
     * 修改反馈
     * @param $param
     * @param $moduleId
     * @return array
     */
    public function modifyNote($param, $moduleId)
    {
        $this->requestParam = $param;

        $noteModel = new NoteModel();
        $noteModel->startTrans();

        try {
            // 保存note信息
            $updateData = [
                'id' => $param["id"],
                'status_id' => $param["status_id"],
                'stick' => $param["stick"],
                'text' => $param["text"],
                'file_commit_id' => $param["file_commit_id"]
            ];
            $noteData = $noteModel->modifyItem($updateData);

            if (!$noteData) {
                throw new \Exception($noteModel->getError());
            } else {
                // 清空media信息
                if (!empty($param["delete_media_ids"])) {
                    $mediaService = new MediaService();
                    $mediaService->batchClearMediaThumbnail([
                        "link_id" => join(",", $param["delete_media_ids"]),
                        "module_id" => $moduleId,
                        "mode" => "batch",
                        "delete_media_ids" => "yes"
                    ]);
                }

                // 保存media信息
                if (!empty($param["images"])) {
                    $mediaData = $this->saveMedia($param, $noteData, $moduleId);
                    $noteData["media_data"] = $mediaData;
                }

                // 保存tag_link信息
                if (!empty($param["tags"])) {
                    try {
                        $tagService = new TagService();
                        $tagService->deleteTagLink([
                            "link_id" => $param["id"],
                            "module_id" => $moduleId
                        ]);
                    } catch (\Exception $e) {

                    }

                    $tagData = $this->saveTag($param, $noteData, $moduleId);
                    $noteData["tag_data"] = $tagData;
                }

                // 保存member信息
                if (!empty($param["at_user_ids"])) {
                    $memberModel = new MemberModel();
                    $memberModel->deleteItem(["link_id" => $param["id"], "module_id" => $moduleId]);
                    $memberData = $this->saveMember($param, $noteData, $moduleId);
                    $noteData["member_data"] = $memberData;
                }
            }
            $noteModel->commit(); // 提交事物
            if (session("event_from") === "strack_web") {
                // 获取消息返回数据
                $moduleFilter = ['id' => $moduleId];
                $this->projectId = $param['project_id'];
                $this->message = $noteModel->getSuccessMassege();
                $this->messageFromType = 'note';
                $this->messageOperate = 'update';
                $noteData = $this->getFormatNoteData($noteData, $moduleId);
                return $this->afterModify($noteData, $moduleFilter);
            } else {
                return success_response($noteModel->getSuccessMassege(), $noteData);
            }
        } catch (\Exception $e) {
            $noteModel->rollback(); // 事物回滚
            // 修改数据失败错误码 002
            throw_strack_exception($e->getMessage(), 212003);
        }
    }

    /**
     * 格式化note数据
     * @param $data
     * @param $noteModuleId
     * @return mixed
     * @throws \Ws\Http\Exception
     */
    protected function getFormatNoteData($data, $noteModuleId)
    {
        // TODO link_note_ids
        $data["link_note_data"] = [];

        // 格式化note text html
        $data["text"] = htmlspecialchars_decode($data["text"]);

        // 获取 note 媒体附件
        $mediaService = new MediaService();
        $mediasData = $mediaService->getMediaSelectData(["link_id" => $data["id"], "module_id" => $noteModuleId, "type" => "attachment", "relation_type" => "direct"]);
        $data["media_data"] = $mediasData;

        // 获取用户信息
        $userService = new UserService();
        $userData = $userService->getUserInfo($data["created_by"]);

        // 获取用户头像
        $userData['avatar'] = $mediaService->getSpecifySizeThumbPath(['link_id' => $data["created_by"], 'module_id' => C("MODULE_ID")["user"]], '90x90');
        $data["user_data"] = $userData;

        // 获取 note tag 标签
        $tagService = new TagService();
        $data["tag_data"] = $tagService->getTagData(["link_id" => $data["id"], "module_id" => $noteModuleId]);

        if ($data["status_id"] > 0) {
            $statusService = new StatusService();
            $statusFindData = $statusService->getStatusFindData(["id" => $data["status_id"]]);
            $statusData = [
                'name' => $statusFindData["name"],
                'color' => $statusFindData["color"],
            ];
            array_unshift($data["tag_data"], $statusData);
        }

        if ($data["stick"] === "yes") {
            $stickData = [
                'name' => stick_type($data["stick"])['name'],
                'color' => "13CE66",
            ];
            array_unshift($data["tag_data"], $stickData);
        }

        // 获取 note 回复 note 信息
        $data["reply_data"] = [];
        if ($data["parent_id"] > 0) {
            $noteModel = new NoteModel();
            $noteParentData = $noteModel->selectData(["filter" => ["id" => $data["parent_id"]]]);
            $data["reply_data"] = $noteParentData["rows"];
        }

        // 格式化 note 时间
        $data["last_updated"] = date_friendly('', strtotime($data["last_updated"]));

        return $data;
    }

    /**
     * 批量添加note
     * @param $param
     * @param $moduleId
     * @return array
     */
    public function batchAddNote($param, $moduleId)
    {
        $itemIds = explode(",", $param["item_id"]);
        $resData = [];
        foreach ($itemIds as $itemId) {
            $param["item_id"] = $itemId;
            $resData = $this->addNote($param, $moduleId);
        }
        return $resData;
    }

    /**
     * 保存媒体信息
     * @param $param
     * @param $resData
     * @param $moduleId
     * @return array
     * @throws \Ws\Http\Exception
     */
    protected function saveMedia($param, $resData, $moduleId)
    {
        $data = [];
        $mediaService = new MediaService();
        foreach ($param["images"] as $item) {
            $mediaData = [
                'link_id' => $resData["id"],
                'module_id' => $moduleId,
                'media_server' => $param["media_server"],
                'media_data' => $item,
                'mode' => 'multiple',
            ];
            $mediaInfo = $mediaService->saveMediaData($mediaData);
            array_push($data, $mediaInfo["data"]);
        }
        return $data;
    }

    /**
     * 保存标签信息
     * @param $param
     * @param $resData
     * @param $moduleId
     * @return array|bool|mixed
     */
    protected function saveTag($param, $resData, $moduleId)
    {
        $data = [];
        $tagLinkModel = new TagLinkModel();
        $tagArray = explode(",", $param["tags"]);
        foreach ($tagArray as $item) {
            $tagData = [
                'link_id' => $resData["id"],
                'module_id' => $moduleId,
                'tag_id' => $item
            ];
            $tagInfo = $tagLinkModel->addItem($tagData);
            array_push($data, $tagInfo);
        }
        return $data;
    }

    /**
     * 保存成员信息
     * @param $param
     * @param $resData
     * @param $moduleId
     * @return array
     */
    protected function saveMember($param, $resData, $moduleId)
    {
        $memberService = new MemberService();

        // 查询当前这条数据下的member信息
        $options = ["link_id" => $param["item_id"], "module_id" => $param["module_id"], "project_id" => $param["project_id"]];
        $memberUserData = $memberService->getMemberList($options, "user_id");

        // 将at用户和当前member信息放进同一个数组
        $atUserArray = explode(",", $param["at_user_ids"]);
        foreach ($memberUserData["rows"] as $item) {
            array_push($atUserArray, $item["user_id"]);
        }

        // 如果父级id大于0，将当前parent_id这条数据一起追加到被at用户数组中
        if ($param["parent_id"] > 0) {
            $noteModel = new NoteModel();
            $createById = $noteModel->where(["id" => $param["parent_id"]])->getField("created_by");
            array_push($atUserArray, $createById);
        }

        // 将被at用户保证唯一性
        $atUserArray = array_unique($atUserArray);

        // 保存member信息
        $data = [];
        foreach ($atUserArray as $item) {
            $memberData = [
                'link_id' => $resData["id"],
                'module_id' => $moduleId,
                'project_id' => $param["project_id"],
                'type' => "at",
                'user_id' => intval($item),
            ];
            $memberInfo = $memberService->addMember($memberData);
            array_push($data, $memberInfo["data"]);
        }

        return $data;
    }
}