<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\NoteService;
use Common\Service\UserService;

class NoteController extends VerifyController
{

    /**
     * 获取动态Note数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getNoteListData()
    {
        $param = $this->request->param();
        $noteService = new NoteService();
        $moduleId = C("MODULE_ID")["note"];
        $resData = $noteService->getNoteListData($param, $moduleId);
        return json($resData);
    }

    /**
     * 获取一条Note数据
     * @return \Think\Response
     * @throws \Ws\Http\Exception
     */
    public function getOneNoteData()
    {
        $param = $this->request->param();
        $noteService = new NoteService();
        $moduleId = C("MODULE_ID")["note"];
        $resData = $noteService->getOneNoteData($param, $moduleId);
        return json($resData);
    }

    /**
     * 获取 Note Grid 信息
     */
    public function getNoteGridData()
    {
        $param = $this->request->formatGridParam($this->request->param());
        $noteService = new NoteService();
        $resData = $noteService->getNoteGridData($param);
        return json($resData);
    }

    /**
     * 获取可以AT的用户列表
     * @return \Think\Response
     */
    public function getAtUserList()
    {
        $param = $this->request->param();
        $userService = new UserService();
        $resData = $userService->getAtUserList($param["project_id"]);
        return json($resData);
    }

    /**
     * 添加Note数据
     * @return \Think\Response
     */
    public function addNote()
    {
        $param = $this->request->param();
        $noteService = new NoteService();
        $moduleId = C("MODULE_ID")["note"];
        $resData = $noteService->addNote($param, $moduleId);
        return json($resData);
    }

    /**
     * 批量新增Note
     * @return \Think\Response
     */
    public function batchAddNote()
    {
        $param = $this->request->param();
        $noteService = new NoteService();
        $moduleId = C("MODULE_ID")["note"];
        $resData = $noteService->batchAddNote($param, $moduleId);
        return json($resData);
    }

    /**
     * 修改Note数据
     */
    public function modifyNote()
    {
        $param = $this->request->param();
        $noteService = new NoteService();
        $moduleId = C("MODULE_ID")["note"];
        $resData = $noteService->modifyNote($param, $moduleId);
        return json($resData);
    }

    /**
     * 删除Note数据
     * @return \Think\Response
     * @throws \Exception
     */
    public function deleteNote()
    {
        $param = $this->request->param();
        $param = [
            'id' => $param["primary_ids"],
            'module_id' => C("MODULE_ID")["note"],
            'type' => "attachment"
        ];
        $noteService = new NoteService();
        $resData = $noteService->deleteNote($param);
        return json($resData);
    }
}