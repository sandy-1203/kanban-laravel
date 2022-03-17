<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ColumnController;
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

Route::prefix('auth')->group(function () {
    Route::post('sign-up', [AuthController::class, 'signUp']);
    Route::post('sign-in', [AuthController::class, 'signIn']);
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('auth')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
    });


    Route::prefix('board')->group(function () {
        Route::get('{id}', [BoardController::class, 'find']);
    });

    Route::prefix('column')->group(function () {
        Route::post('', [ColumnController::class, 'create']);
        Route::post('{id}', [ColumnController::class, 'update']);
        Route::delete('{id}', [ColumnController::class, 'delete']);
    });

    Route::prefix('card')->group(function () {
        Route::post('upsert', [CardController::class, 'upsert']);
        Route::post('{id}/move', [CardController::class, 'move']);
        Route::delete('{id}', [CardController::class, 'delete']);
    });

    Route::get('export-db', [AuthController::class, 'exportDb']);
});
