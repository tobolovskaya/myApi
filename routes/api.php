<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


//http://myapi.test/api/roll
Route::get('/roll', [RollController::class, 'index']);

//http://127.0.0.1:8000/api/external
Route::get('/external', [RollController::class, 'external']);

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

//http://127.0.0.1:8000/api/products
Route::apiResource('products', ProductController::class);

//http://127.0.0.1:8000/api/orders
Route::apiResource('orders', OrderController::class);