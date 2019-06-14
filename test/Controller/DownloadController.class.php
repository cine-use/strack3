<?php
namespace Test\Controller;

use Common\Service\DownloadService;

class DownloadController{

    public function test()
    {
        $download=new DownloadService();
        $resData =  $download->excel();
        var_dump($resData);
        return $resData;
    }
}