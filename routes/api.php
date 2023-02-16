<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JWTAuthController;

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::post('logout', [JWTAuthController::class, 'logout']);

    // start article route
    Route::group(['prefix' => 'article'], function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/{slug}', [ArticleController::class, 'show']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::put('/{slug}', [ArticleController::class, 'update']);
        Route::delete('/{slug}', [ArticleController::class, 'delete']);

    });
    // end article route
});


