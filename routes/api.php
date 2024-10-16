<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TagController;
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

Route::prefix('v1/auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('verify', [VerificationController::class, 'verify']);
});

// routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tags', TagController::class);
    Route::apiResource('posts', PostController::class);

    Route::get('posts/trashed', [PostController::class, 'trashed']);
    Route::post('posts/{id}/restore', [PostController::class, 'restore']);

    Route::get('stats', [StatsController::class, 'index']);
});

