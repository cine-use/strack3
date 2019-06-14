<?php

namespace Test\Controller;

use Common\Service\CommonService;
use Think\Controller;

class ProjectDiskController extends Controller
{

    public function testSelect()
    {

        $param = '{"filter":{"sort":[],"request":[],"filter_advance":[]},"master":{"module_code":"project_disk","pagination":{"page_size":1,"page_number":1},"fields":"id,project_id,config,uuid"},"relation":[],"project_id":0}';
        $param = json_decode($param, true);
        $resData = (new CommonService("projectDisk"))->relation($param);
        dump($resData);
    }
}