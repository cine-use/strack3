<?php

namespace Test\Controller;

use ReflectionClass;
use ReflectionMethod;
use Think\Controller;
use Common\Service\AuthService;

class RbacController extends Controller
{
    /**
     * 获取页面权限树
     */
    public function getPageAuthList()
    {
        $page = "home_account_index";
        //$param = 53;

        $authService = new AuthService();

        // 获取指定页面权限
        $authService->setRole(1);
        $authService->setUser(1);


        $param = [
            'source_node' => md5(strtolower("Home/Media/getMediaUploadServer")),
            'referer_page' => 'home_project_create',
            'referer_param' => '53',
            'type' => 'ajax'
        ];

        $visitPermission = $authService->verifyAjaxPermission($param);

        dump($visitPermission);




        $pageRules = $authService->getPageAuthRules("home_project_entity", 56);

        dump($pageRules);


        $authTree = $authService->getPageAuthConfig("home_project_entity", 56);

        dump($authTree);

        die;

        // 获取指定菜单权限
        $menuAuth = $authService->getMenuAuthConfig("account_top_menu");

        dump($menuAuth);

        // 获取指定用户角色信息
        $roleData = $authService->getUserRoleData(1);

        dump($roleData);

        // 获取指定菜单权限
        $menuAuth2 = $authService->getMenuAuthConfig("admin");

        dump($menuAuth2);


        $menuList = ["account_top_menu", "admin_menu"];
        foreach ($menuList as $menuName) {
            // 发送到页面端
            $this->assign($menuName, $authService->getMenuPermission($menuName));
        }
    }

    /**
     * 扫描文件生成路由列表
     */
    public function scanFile()
    {


        //$fp = fopen($langFolder . '/default/' . $colKey . '.php', 'a+b');

        $this->getRoute("Home");
    }

    /**
     * 获取拼接路由
     * @param $moduleName
     * @throws \ReflectionException
     */
    public function getRoute($moduleName)
    {
        $basePath = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . DS . 'APP' . DS;
        $controllerPath = "{$basePath}{$moduleName}/Controller/";
        $controllerList = scandir($controllerPath);
        foreach ($controllerList as $item){
            if(strpos($item,"Controller") !== false){
                $className = str_replace(".class.php", "", $item);
                $class = "\\{$moduleName}\\Controller\\".$className;

                dump($class);

                $ref = new ReflectionClass($class);
                $methods = $ref->getMethods(); //返回所有常量名和值

                foreach ($methods as $method){
                    if('/'.$method["class"] === $class){
                        //$refMethod =  new ReflectionMethod($method["class"], $method["name"]);
                        //dump($refMethod);
                    }
                }


                dump($methods);
            }
        }
    }
}