<?php

namespace Test\Controller;


use Common\Service\SchemaService;
use Think\Controller;

class FieldController extends Controller
{
    public function getFieldConfigDictionary()
    {
        $schemaService = new SchemaService();
        $schemaService->getFieldConfigDictionary();
    }

}