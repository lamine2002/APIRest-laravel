<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use App\Http\Middleware\SecuriseRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->withoutMiddleware([SecuriseRoute::class]);
Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', SecuriseRoute::class]);
Route::apiResource('/student', StudentController::class)->middleware(['auth:sanctum', SecuriseRoute::class]);
Route::post('refresh', [AuthController::class, 'refresh'])->middleware(['auth:sanctum', SecuriseRoute::class]);
