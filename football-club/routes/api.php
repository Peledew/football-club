<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlayerController;
use App\Http\Middleware\AuthTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::apiResource('places', PlaceController::class);
Route::apiResource('clubs', ClubController::class);
Route::apiResource('players', PlayerController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('competitions', CompetitionController::class);
Route::apiResource('performances', PerformanceController::class);

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

