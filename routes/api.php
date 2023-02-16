<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::post('logout', [JWTAuthController::class, 'logout']);

});


