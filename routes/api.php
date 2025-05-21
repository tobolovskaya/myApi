<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RollController;

//http://myapi.test/api/roll

Route::get('/roll', [RollController::class, 'index']);