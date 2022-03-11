<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [LoginController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users',[UserController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/message', [MessageController::class, 'store']);
    Route::post('test', function (Request $request) {
        (new Pusher(config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')))->trigger('my-channel-2', 'my-event', ['message' => $request->message]);
    });
});
