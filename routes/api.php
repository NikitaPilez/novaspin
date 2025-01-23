<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Middleware\AuthenticateWithJWT;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware(AuthenticateWithJWT::class);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/promo-codes/{code}/activate', [PromoCodeController::class, 'activate'])->middleware(AuthenticateWithJWT::class);
