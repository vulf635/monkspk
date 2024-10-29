<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post(
    '/peer/create/offer',
    '\App\Http\Controllers\Api\Peer@createOffer'
);
Route::post(
    '/peer/create/answer',
    '\App\Http\Controllers\Api\Peer@getOffer'
);
Route::post(
    '/peer/confirm/answer',
    '\App\Http\Controllers\Api\Peer@setAnswer'
);
Route::post(
    '/peer/websocket',
    function(Request $request) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test.txt', 'test');
        return response()->json(['test' => 'test']);
    }
);


Route::get('/peer/test', [\App\Http\Controllers\Api\Peer::class, 'test']);
Route::post(
    '/peer/test',
    function () {
        return response()->json(['test' => 'test']);
    }
);
