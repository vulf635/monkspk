<?php
namespace App\Controllers\Websocket\Calls;

use App\Classes\Websocket;
use App\Models\Response;

class ConfirmAnswer extends Websocket
{

    public function execute()
    {
        foreach ($this->clients as $client)
        {
            if ($client->socketId == $this->msg['params']['session'])
            {
                $client->send(json_encode(['type' => 'confirm_answer', 'answer' => $this->msg['params']['answer']]));
                return (new Response(200, 'ОК', [
                    'type' => 'confirm_answer',
                    'answer' => $this->msg['params']['answer'],
                ]))->json();
            }
        }
        return (new Response(404, 'Не удалось найти сессию'))->json();
    }
}