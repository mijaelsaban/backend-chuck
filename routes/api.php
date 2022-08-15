<?php

use App\Http\Controllers\EmailsController;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/emails', [EmailsController::class, 'index']);
    Route::post('/emails', [EmailsController::class, 'store']);
    Route::put('/emails/{email}', [EmailsController::class, 'update']);

//    Route::get('/messages', MessagesController::class, 'index');
//    Route::post('/messages/{id}', MessagesController::class, 'update');
//    Route::post('/messages', MessagesController::class, 'store');
});
