<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace Think\Console\Command;

use Think\Console\Command;
use Think\Console\Input;
use Think\Console\Input\Option;
use Think\Console\Output;

class Build extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('build')
            ->setDefinition([
                new Option('config', null, Option::VALUE_OPTIONAL, "build.php path"),
                new Option('module', null, Option::VALUE_OPTIONAL, "module name"),
            ])
            ->setDescription('Build Application Dirs');
    }

    protected function execute(Input $input, Output $output)
    {
        if ($input->hasOption('module')) {
            \Think\Build::module($input->getOption('module'));
            $output->writeln("Successed");
            return;
        }

        if ($input->hasOption('config')) {
            $build = include $input->getOption('config');
        } else {
            $build = include APP_PATH . 'build.php';
        }
        if (empty($build)) {
            $output->writeln("Build Config Is Empty");
            return;
        }
        \Think\Build::run($build);
        $output->writeln("Successed");

    }
}
