<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::post('v1/auth/register', [RegisterController::class, 'register']);
Route::post('v1/auth/login', [LoginController::class, 'login']);
Route::post('v1/auth/verify', [VerificationController::class, 'verify']);
/*
Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('register', [
            'as'   => 'api.register',
            'uses' => 'Auth\RegisterController@register',
        ]);
        Route::post('login', [
            'as'   => 'api.login',
            'uses' => 'Auth\LoginController@login',
        ]);
        Route::post('verify', [
            'as'   => 'api.verify',
            'uses' => 'Auth\VerificationController@verify',
        ]);
    });
});*/
