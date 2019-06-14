<?php

namespace Test\Controller;

use Common\Service\DiskService;

class DiskApiController
{
    public function findTest()
    {
        $param = [
            "page" => [],
            "rows" => [
                       "name"    => "",
                       "code"    => "euieuriqwe",
                       "config"  => ["win_path" => "",

                                     "mac_path"   => "",
                                     "linux_path" => "",
                       ],

            ],
        ];

        echo json_encode($param, true);
        $diskService = new DiskService();
        $data= $diskService->getDisksGridData($param);
        dump($data);
    }

    public function addTest()
    {
        $param=[

            "name"=>"3",
            "code"=>"2222",
            "config"  => ["win_path" => "1",

                          "mac_path"   => "2",
                          "linux_path" => "3",
            ]
        ];
        echo json_encode($param, true);
        $diskService = new DiskService();
        $data= $diskService->addDisks($param);
        dump($data);
    }
}