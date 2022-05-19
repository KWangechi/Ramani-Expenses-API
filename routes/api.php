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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Api\UserController::class, 'logout'])->middleware('auth:sanctum');

//expenses endpoints
Route::middleware(['auth:sanctum'])->prefix('expenses')->group(function () {

    Route::get('/',  [App\Http\Controllers\Api\ExpenseController::class, 'index']);
    Route::post('/create',  [App\Http\Controllers\Api\ExpenseController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\ExpenseController::class, 'show']);
    Route::patch('/{id}',  [App\Http\Controllers\Api\ExpenseController::class, 'update']);
    Route::delete('/{id}',  [App\Http\Controllers\Api\ExpenseController::class, 'destroy']);

});

Route::get('/create_method', [App\Http\Controllers\Api\ExpenseController::class, 'create']);
Route::get('/balance', [App\Http\Controllers\Api\ExpenseController::class, 'getLatestBalance']);
