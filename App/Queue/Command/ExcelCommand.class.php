<?php

namespace Queue\Command;

use Think\Console\Command;
use Think\Console\Input;
use Think\Console\Output;

class ExcelCommand extends Command
{
    protected function configure()
    {
        $this->setName('excel')
            ->setDescription('Implementation of excel');
    }

    /**
     * 执行添加
     * @param Input $input
     * @param Output $output
     * @return int|null|void
     */
    protected function execute(Input $input, Output $output)
    {
        print_r($input);
    }
}