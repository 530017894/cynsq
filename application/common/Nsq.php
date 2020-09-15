<?php
namespace app\common;

use OkStuff\PhpNsq\PhpNsq;

class Nsq
{
    public function publicToNsq($msg)
    {

        //$config = require __DIR__ . '/../src/config/phpnsq.php';
        $phpnsq = new PhpNsq(config('nsq.'));
        $res = $phpnsq->setTopic(config('nsq.topic'))->publish($msg);
        return $res;

    }
}
