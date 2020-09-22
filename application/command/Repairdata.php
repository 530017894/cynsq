<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use app\api\controller\Repairdata as Repairdatact;

class Repairdata extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('repairdata')->setDefinition(
            [
                new Option('start_time','s',Option::VALUE_OPTIONAL,'kaishishijian'),
                new Option('end_time','e',Option::VALUE_OPTIONAL,'jieshushijian')
            ]
        );
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {

        Repairdatact::search($input->getOption('start_time'),$input->getOption('end_time'));
        Repairdatact::userlog($input->getOption('start_time'),$input->getOption('end_time'));
        Repairdatact::deviceacount($input->getOption('start_time'),$input->getOption('end_time'));
        Repairdatact::areaacount($input->getOption('start_time'),$input->getOption('end_time'));
    	// 指令输出
    	$output->writeln('app\command\repairdata');
    }
}
