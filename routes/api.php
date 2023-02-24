<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Generator\PeclUuidTimeGenerator;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::resource('message', MessageController::class);

    Route::get('chats/{user}', [ChatController::class, 'index']);
    Route::post('chats/{user}', [ChatController::class, 'store']);

    Route::get('friends', [FriendController::class, 'index']);
    Route::post('friends/{user}', [FriendController::class, 'store']);
    Route::delete('friends/{user}', [FriendController::class, 'destroy']);

    Route::resource('users', UserController::class);

    Route::delete('logout', [AuthController::class, 'logout']);
});