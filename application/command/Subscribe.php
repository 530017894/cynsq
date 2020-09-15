<?php

namespace app\command;

use Symfony\Component\Console\Application;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Subscribe extends Command
{
    protected function configure()
    {
        $this->setName('phpnsq:sub')
            ->addArgument("topic",Argument::OPTIONAL,  "The topic you want to subscribe")
            ->addArgument("channel",Argument::OPTIONAL, "The channel you want to subscribe")
            ->setDescription('subscribe new notification.')
            ->setHelp("This command allows you to subscribe notifications...");

    }

    protected function execute(Input $input, Output $output)
    {
        try {
            $application = new Application();

            $application->add(new Nsq(config('nsq.'), null));

            $application->run();
        }catch (\Exception $exception){
            $output->writeln($exception->getMessage());

        }

    	$output->writeln('subscribe');
    }
}
