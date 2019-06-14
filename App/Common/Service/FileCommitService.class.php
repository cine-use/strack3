<?php
// +----------------------------------------------------------------------
// | 文件 项目服务
// +----------------------------------------------------------------------
// | 主要服务于文件数据处理
// +----------------------------------------------------------------------
// | 错误编码头 222xxx
// +-----------------------------------------------

namespace Common\Service;

use Common\Model\FileCommitModel;
use Common\Model\FileModel;

class FileCommitService
{
    /**
     * 获取fileCommit数据表格数据
     * @param $param
     * @return mixed
     */
    public function getDetailGridData($param)
    {
        // 获取schema配置
        $viewService = new ViewService();
        $schemaFields = $viewService->getGridQuerySchemaConfig($param);

        // 查询关联模型数据
        $fileCommitModel = new FileCommitModel();
        $resData = $fileCommitModel->getRelationData($schemaFields);

        return $resData;
    }
}
