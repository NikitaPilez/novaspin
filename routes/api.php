<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthenticateWithJWT;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware(AuthenticateWithJWT::class);
Route::post('/logout', [AuthController::class, 'logout']);
