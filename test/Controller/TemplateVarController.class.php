<?php
/**
 * Created by PhpStorm.
 * User: mincau
 * Date: 2018/8/7
 * Time: 14:33
 */
namespace Test\Controller;

use Think\Controller;
use Common\Service\TemplateVarService;

class TemplateVarController extends Controller
{
    public function index()
    {
        echo "<br>------------------------add item------------------------------<br>";
        $ser = new TemplateVarService();
        if( $ser->addVar(["name"=>"2", "code"=>"2", "project_id"=>1, "module_id"=>10, "type"=>"strack"])){
            echo "ok<br>";
        }else{
            echo "bad<br>";
        }

        echo "<br>------------------------get item by code------------------------------<br>";
        echo var_dump( $ser->getVar(["filter"=>["code"=>"111"]]));

        echo "<br>------------------------get item by type------------------------------<br>";
        echo var_dump( $ser->getVar(["filter"=>["type"=>"strack"]]));


    }


}