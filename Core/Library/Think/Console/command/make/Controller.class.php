<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 刘志淳 <chun@engineer.com>
// +----------------------------------------------------------------------

namespace Think\Console\Command\Make;

use Think\Console\Command\Make;
use Think\Console\Input\Option;

class Controller extends Make
{

    protected $type = "Controller";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:controller')
            ->addOption('plain', null, Option::VALUE_NONE, 'Generate an empty controller class.')
            ->setDescription('Create a new resource controller class');
    }

    protected function getStub()
    {
        if ($this->input->getOption('plain')) {
            return __DIR__ . '/stubs/controller.plain.stub';
        }

        return __DIR__ . '/stubs/controller.stub';
    }

    protected function getClassName($name)
    {
        return parent::getClassName($name) . (C('controller_suffix') ? ucfirst(C('url_controller_layer')) : '');
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\Controller';
    }

}
