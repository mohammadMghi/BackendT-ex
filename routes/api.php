<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoveController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\WorkoutController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresht_token', [AuthController::class, 'refreshToken']);

    Route::prefix('package')->group(function () {
        Route::get('list', [PackageController::class, 'list']);
    });

    Route::prefix('workout')->group(function () {
        Route::get('find/{workout_id}', [WorkoutController::class, 'find']);
    });

    Route::prefix('move')->group(function () {
        Route::get('list', [MoveController::class, 'list']);
        Route::get('find/{id}', [MoveController::class, 'find']);
    });

  
});
