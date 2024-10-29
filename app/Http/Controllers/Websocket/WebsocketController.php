<?php

namespace App\Http\Controllers\Websocket;

use App\Classes\Websocket;
use Ratchet\ConnectionInterface;

class WebsocketController
{
    public static function execute(ConnectionInterface $connection,string $msg, array $clients = [])
    {
        if ($msg)
            $msg = json_decode($msg, true);

        if ($msg['request']) {
            $classPath = '\\App\\Websocket\\' . str_replace('/', '\\', $msg['request']);
        }
        else
            throw new \Exception('No request');

        if (!class_exists($classPath))
            throw new \Exception($classPath. 'Class not found');

        $class = new $classPath($msg, $connection, $clients);

        if ($class instanceof Websocket) {
            $class->execute();
        }
    }
}