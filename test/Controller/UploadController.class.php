<?php

namespace Test\Controller;

use Common\Service\UploadService;

class UploadController
{
    public function UploadTest()
    {
        $up = new UploadService();

        $param = [
            'type' => 'video',
        ];


       $up->upload($param);

//        dump($up->getFileName());
//        dump($up->getErrorMsg());

    }

    public function uploadHtml()
    {
        echo '<form action="UploadTest" method="post" enctype="multipart/form-data" >';

        echo ' <input type="text" name="username" value="" /><br>';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';
        echo ' <input type="file" name="file" value=""><br> ';
        echo ' <input type="submit" value="upload" /><br>';
        echo '</form>';
    }

}