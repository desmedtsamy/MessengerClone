<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/accept', [ \App\Http\Controllers\RestChatController::class, 'accept' ]);
Route::post('/denided', [ \App\Http\Controllers\RestChatController::class, 'denided' ]);
Route::post('/addfriend', [ \App\Http\Controllers\RestChatController::class, 'addfriend' ]);
Route::get('/friends/{id}', [ \App\Http\Controllers\RestChatController::class, 'friends' ]);
Route::get('/messages/{id}/{friend}', [ \App\Http\Controllers\RestChatController::class, 'messages' ]);
Route::post('/message', [ \App\Http\Controllers\RestChatController::class, 'addMessage' ]);
Route::get('/user/{id}', [ \App\Http\Controllers\RestChatController::class, 'getUser' ]);


