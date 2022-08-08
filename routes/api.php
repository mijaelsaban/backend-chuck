<?php

use App\Http\Controllers\EmailsController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//1|jqveaQ3WPIND8pDs9Bksg8WhambK9fFGd82tTp4C
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/emails', [EmailsController::class, 'index']);
    Route::post('/emails', [EmailsController::class, 'store']);

    Route::get('/messages', function () {
        return response()->json([
            'email_id' => 1,
            'isSent' => false,
            'content' =>  'this is a joke'
        ]);
    });
});
