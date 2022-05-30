<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MessagesController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('order')->group(function () {
    Route::post('/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/update', [OrderController::class, 'update'])->name('order.update');
});

Route::prefix('messages')->group(function () {
    Route::post('/send-to-one-client', [MessagesController::class, 'sendToOneClient'])->name('message.send.one.client.create');
});