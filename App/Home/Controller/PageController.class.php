<?php

namespace Home\Controller;

use Common\Controller\VerifyController;
use Common\Service\DiskService;

class PageController extends VerifyController
{
    public function cloud_disk()
    {
        // 生成页面唯一信息
        $this->generatePageIdentityID("cloud_disk");

        // 获取云盘
        $diskService = new DiskService();
        $cloudDiskConfig = $diskService->getCloudDiskUrl();
        $this->assign($cloudDiskConfig);

        return $this->display();
    }
}