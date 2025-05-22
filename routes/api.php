<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RollController;
use App\Http\Controllers\UserController;

//http://myapi.test/api/roll
Route::get('/roll', [RollController::class, 'index']);

//http://127.0.0.1:8000/api/status
Route::get('/status', [RollController::class, 'status']);

//http://127.0.0.1:8000/api/store
Route::get('/store', [RollController::class, 'store']);

//http://127.0.0.1:8000/api/users
Route::get('/users', [UserController::class, 'index']);

//http://127.0.0.1:8000/api/users/1
Route::get('/users/{id}', [UserController::class, 'show']);

//http://127.0.0.1:8000/api/users
Route::post('/users', [UserController::class, 'store']);

Route::put('/users/{user}', [UserController::class, 'update']);

Route::delete('/users/{user}', [UserController::class, 'delete']);