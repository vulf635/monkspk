<?php
namespace App\Controllers\Websocket\Calls;
use App\Models\Peers;

class DeleteConnection extends Websocket
{
    public function execute()
    {
        foreach ($this->clients as $client)
        {
            if ($client->socketId == $this->msg['params']['session'])
            {
                $client->close();
                Peers::where('code', $this->msg['params']['code'])->delete();
                $client->send(json_encode(['type' => 'delete_connection']));
                return (new Response(200, 'ОК'))->json();
            }
        }
        return (new Response(404, 'Не удалось найти и удалить сессию'))->json();
    }
}