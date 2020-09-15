<?php


namespace app\admin\service;


use Elasticsearch\ClientBuilder;

class Es
{
    private static $instance = null;
    private static $client = null;
    public static $index = 'cy_message_log';
    public static $type = '_doc';

    public function __construct()
    {
        self::$client = ClientBuilder::create()->setHosts(config('es.'))->build();
    }

    public function create($data = [])
    {
        $params = [];
        $params['index'] = self::$index;
        $params['type'] = self::$type;
        $params['body'] = $data;
        self::$client->index($params);
    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}