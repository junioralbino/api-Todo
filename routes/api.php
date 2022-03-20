<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

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
Route::get('/unauthenticated', function(){
    return ['error' => 'Usuário não logado!'];
})->name('login');

Route::post('/user', [AuthController::class, 'create']);
Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth', [AuthController::class, 'login']);

Route::get('/ping', function(){
    return [
        'pong' => true
    ];
});

Route::middleware('auth:sanctum')->post('/todo',[ApiController::class, 'createTodo']);
Route::get('/todos',[ApiController::class, 'readAllTodo']);
Route::get('/todo/{id}', [ApiController::class, 'readTodo']);
Route::middleware('auth:sanctum')->put('/todo/{id}', [ApiController::class, 'updateTodo']);
Route::middleware('auth:sanctum')->delete('/todo/{id}', [ApiController::class, 'deleteTodo']);