<?php


namespace app\command;


use app\admin\service\Es;
use OkStuff\PhpNsq\Stream\Message;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Nsq extends \OkStuff\PhpNsq\Cmd\Subscribe
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $phpnsq = self::$phpnsq;
        $phpnsq->setTopic($input->getArgument("topic"))
            ->setChannel($input->getArgument("channel"))
            ->subscribe($this, function (Message $message) use ($phpnsq, $output) {
                $phpnsq->getLogger()->info("READ", $message->toArray());
                var_dump($message->toArray()["body"]);
                $body = $message->toArray()["body"];
                // todo 插入到es
                Es::instance()->create(json_decode($body,true));
            });
        $this->runLoop();
    }
}