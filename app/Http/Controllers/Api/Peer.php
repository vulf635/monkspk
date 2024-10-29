<?php

namespace App\Http\Controllers\Api;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Peers;

class Peer extends \App\Http\Controllers\Controller
{
    public function test(Request $request) : \Illuminate\Http\JsonResponse
    {
        return response()->json(['test' => 'test']);
    }

    public function createOffer(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'iceCandidate' => 'required|string',
        ]);

        do {
            $uniqueCode = $this->generateUniqueCode(); // Генерация 6-значного кода
            $existingCode = Peers::where('code', $uniqueCode)->first(); // Проверка наличия кода в таблице
        } while ($existingCode);

        Peers::create([
            'code' => $uniqueCode,
            'offer' => $request->iceCandidate,
            'session' => '1',
            'application' => '1',
            'answer' => '',
        ]);

        return response()->json(['code' => $uniqueCode]);
    }

    public function getOffer(Request $request): \Illuminate\Http\JsonResponse
    {
        $peer = Peers::where('code', $request->code)->first();

        if ($peer)
            return  response()->json(['offer' => $peer->offer, 'session' => $peer->session]);
        else
            return response()->json(['error' => 'Peer not found'], 404);
    }

    public function setAnswer(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'code' => 'required|string',
            'answer' => 'required|string',
        ]);

        $peer = Peers::where('code', $request->code)->first();

        if ($peer)
        {
            $peer->answer = $request->answer;
            $peer->save();

            // TODO: send answer to peer on websocket

            $test = new \App\MyCustomWebSocketHandler();
            $test->sendTest();

            return response()->json(['answer' => $request->answer]);
        }
        else
            return response()->json(['error' => 'Peer not found'], 404);
    }
    protected function generateUniqueCode(): string
    {
        $prefix = substr(uniqid(), -8); // Получаем последние 8 символов от uniqid()
        $code = substr(str_replace('.', '', $prefix), 0, 6); // Удаляем точки и обрезаем до 6 символов
        return $code;
    }
    
}