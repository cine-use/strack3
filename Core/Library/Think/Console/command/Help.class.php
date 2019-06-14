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
use Think\Console\Input\Argument as InputArgument;
use Think\Console\Input\Option as InputOption;
use Think\Console\Output;

class Help extends Command
{

    private $command;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('help')->setDefinition([
            new InputArgument('command_name', InputArgument::OPTIONAL, 'The command name', 'help'),
            new InputOption('raw', null, InputOption::VALUE_NONE, 'To output raw command help'),
        ])->setDescription('Displays help for a command')->setHelp(<<<EOF
The <info>%command.name%</info> command displays help for a given command:

  <info>php %command.full_name% list</info>

To display the list of available commands, please use the <info>list</info> command.
EOF
        );
    }

    /**
     * Sets the command.
     * @param Command $command The command to set
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(Input $input, Output $output)
    {
        if (null === $this->command) {
            $this->command = $this->getConsole()->find($input->getArgument('command_name'));
        }

        $output->describe($this->command, [
            'raw_text' => $input->getOption('raw'),
        ]);

        $this->command = null;
    }
}
