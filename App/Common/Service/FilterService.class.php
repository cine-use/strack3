<?php
// +----------------------------------------------------------------------
// | Filter 过滤条件服务
// +----------------------------------------------------------------------
// | 主要服务于Filter数据处理
// +----------------------------------------------------------------------
// | 错误编码头 220xxx
// +----------------------------------------------------------------------
namespace Common\Service;

use Common\Model\FilterModel;

class FilterService
{
    /**
     * 保存过滤条件
     * @param $param
     * @return array
     */
    public function saveFilter($param)
    {
        $filterModel = new FilterModel();
        $resData = $filterModel->addItem($param);
        if (!$resData) {
            // 保存过滤条件失败错误码 001
            throw_strack_exception($filterModel->getError(), 220001);
        } else {
            // 返回成功数据
            return success_response($filterModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 删除指定过滤条件
     * @param $param
     * @return array
     */
    public function deleteFilter($param)
    {
        $filterModel = new FilterModel();
        $resData = $filterModel->deleteItem($param);
        if (!$resData) {
            // 删除过滤条件失败错误码 002
            throw_strack_exception($filterModel->getError(), 220002);
        } else {
            // 返回成功数据
            return success_response($filterModel->getSuccessMassege(), $resData);
        }
    }

    /**
     * 置顶选择的过滤条件
     * @param $param
     * @return array
     */
    public function stickFilter($param)
    {
        $filterModel = new FilterModel();
        $filterModel->where(['id' => $param['filter_id']])->setField("stick", $param['stick']);
        if ($param['stick'] == "yes") {
            $message = L('Filter_Stick_SC');
        } else {
            $message = L('Filter_UnStick_SC');
        }
        // 返回成功数据
        return success_response($message, $param);
    }

    /**
     * 获取单个过滤条件信息
     * @param $param
     * @return mixed
     */
    public function getFilterSingle($param)
    {
        $filterModel = new FilterModel();
        $configJson = $filterModel->where(["id" => $param['filter_id']])->getField("config");
        return json_decode($configJson, true);
    }

    /**
     * 获取过滤列表
     * @param $userId
     * @param $page
     * @param int $projectId
     * @return array
     */
    public function getFilterList($userId, $page, $projectId = 0)
    {
        // 获取当前用户且为当前页面所有的过滤条件
        $filterModel = new FilterModel();
        $filterPageList = $filterModel->selectData(['filter' => ['page' => $page, 'project_id' => $projectId]]);

        // 循环处理分类
        $filterList = ['stick' => [], 'my' => [], 'public' => []];
        foreach ($filterPageList['rows'] as $filterItem) {
            if ($filterItem["user_id"] == $userId) {
                $filterItem['allow_del'] = true;
            } else {
                $filterItem['allow_del'] = false;
            }
            $filterItem['select'] = false;
            if ($filterItem['stick'] == 'yes') {
                $filterItem['icon'] = 'icon-uniEA02';
                if ($filterItem['user_id'] == $userId) {
                    array_push($filterList['stick'], $filterItem);
                } else {
                    if ($filterItem['public'] === "yes") {
                        array_push($filterList['stick'], $filterItem);
                    }
                }
            } else {
                $filterItem['icon'] = 'icon-uniEA00';
                if ($filterItem['user_id'] == $userId) {
                    array_push($filterList['my'], $filterItem);
                } else {
                    array_push($filterList['public'], $filterItem);
                }
            }
        }
        return $filterList;
    }
}