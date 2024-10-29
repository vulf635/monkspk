<?php
namespace App;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use BeyondCode\LaravelWebSockets\Apps\App;
use App\Controllers\WebsocketController;

class MyCustomWebSocketHandler implements MessageComponentInterface
{
    protected array $clients = array();

    public function onOpen(ConnectionInterface $connection)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));

        $connection->socketId = $socketId;
        $connection->app = App::findById('12313');

        $this->clients[] = $connection;
    }

    public function onClose(ConnectionInterface $connection)
    {
        // TODO: Implement onClose() method.
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $connection, $msg)
    {
        WebsocketController::execute($connection, $msg, $this->clients);
    }
}