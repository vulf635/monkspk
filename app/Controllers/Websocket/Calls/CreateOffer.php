<?php
namespace App\Controllers\Websocket\Calls;

use App\Classes\Websocket;
use App\Models\Peers;
use App\Models\WebsocketResponse;

class CreateOffer extends Websocket
{
    public function execute()
    {
        do
        {
            $uniqueCode = $this->generateUniqueCode();
            $existingCode = Peers::where('code', $uniqueCode)->first();
        }
        while ($existingCode);

        Peers::create([
            'code' => $uniqueCode,
            'offer' => $this->msg['params']['offer'],
            'session' => $this->connection->socketId,
            'application' => '1',
            'answer' => '',
        ]);

        $this->connection->send( json_encode([
            'type' => 'create_offer',
            'code' => $uniqueCode,
            'session' => $this->connection->socketId,
        ]) );

        return (new Response(200, 'ОК', [
            'code' => $uniqueCode,
        ]))->json();
    }
    protected function generateUniqueCode(): string
    {
        $prefix = substr(uniqid(), -8);
        return substr(str_replace('.', '', $prefix), 0, 6);
    }
}