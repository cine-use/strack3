<?php
// +----------------------------------------------------------------------
// | 权限服务服务层
// +----------------------------------------------------------------------
// | 主要服务于权限数据处理
// +----------------------------------------------------------------------
// | 错误编码头 215xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\RoleModel;
use Common\Model\RoleUserModel;

class PermissionService
{
    /**
     * 添加角色
     * @param $param
     * @return array
     */
    public function addAuthRole($param)
    {
        $RoleModel = new RoleModel();
        $resData = $RoleModel->addItem($param);
        if (!$resData) {
            // 添加角色失败错误码 001
            throw_strack_exception($RoleModel->getError(), 215001);
        } else {
            // 返回成功数据
            return success_response($RoleModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 修改角色
     * @param $param
     * @return array
     */
    public function modifyAuthRole($param)
    {
        $RoleModel = new RoleModel();
        $resData = $RoleModel->modifyItem($param);
        if (!$resData) {
            // 修改角色失败错误码 002
            throw_strack_exception($RoleModel->getError(), 215002);
        } else {
            // 返回成功数据
            return success_response($RoleModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除角色
     * @param $param
     * @return array
     */
    public function deleteAuthRole($param)
    {
        $RoleModel = new RoleModel();
        $roleType = $RoleModel->where($param)->getField("type");

        if ($roleType === "system") {
            // 当前角色正在使用失败错误码 003
            throw_strack_exception(L("Auth_Role_System"), 215007);
        } else {
            $roleUserModel = new RoleUserModel();
            $authGroupData = $roleUserModel->findData(['filter' => ['role_id' => $param['id']]]);
            if (!empty($authGroupData)) {
                // 当前角色正在使用失败错误码 003
                throw_strack_exception(L("Auth_Role_Used"), 215003);
            }

            $resData = $RoleModel->deleteItem($param);
            if (!$resData) {
                // 删除角色失败错误码 004
                throw_strack_exception($RoleModel->getError(), 215004);
            } else {
                // 返回成功数据
                return success_response($RoleModel->getSuccessMassege(), $resData);
            }
        }
    }

    /**
     * 获取角色列表
     * @param $param
     * @return mixed
     */
    public function getAuthRoleList($param)
    {
        $filter = json_decode(htmlspecialchars_decode($param["filter"]), true);
        $RoleModel = new RoleModel();
        $options = [
            'filter' => $filter,
            'fields' => 'id as auth_role_id,name,code'
        ];
        $authRoleData = $RoleModel->selectData($options);
        return $authRoleData;
    }
}