<?php
return [
    "nsq" => [
        "nsqd_addrs" => [
            "39.101.181.211:4150",
        ],
        "lookupd_addrs" => [
            "39.101.181.211:4161",
        ],
        "lookupd_switch" => false,
        "logdir" => "/tmp",
        "auth_secret" => "secret",
        "auth_switch" => false,
    ],
    "topic" => "cy_message_log",
];