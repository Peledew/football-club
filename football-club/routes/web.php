<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/places/create', function () {
    return view('places.create');
})->name('places.create');

Route::get('/places/{id}/edit', [PlaceController::class, 'edit'])->name('places.edit');
Route::put('/places/{id}', [PlaceController::class, 'update'])->name('places.update');

Route::get('/games/create', function () {
    return view('games.create');
})->name('games.create');

Route::get('/games/{id}/edit', [GameController::class, 'edit'])->name('games.edit');
Route::put('/games/{id}', [GameController::class, 'update'])->name('games.update');

Route::get('/competitions/create', function () {
    return view('competitions.create');
})->name('competitions.create');

Route::get('/competitions/{id}/edit', [CompetitionController::class, 'edit'])->name('competitions.edit');
Route::put('/competitions/{id}', [CompetitionController::class, 'update'])->name('competitions.update');


Route::get('/clubs/create', function () {
    return view('clubs.create');
})->name('clubs.create');

Route::get('/clubs/{id}/edit', [ClubController::class, 'edit'])->name('clubs.edit');
Route::put('/clubs/{id}', [ClubController::class, 'update'])->name('clubs.update');
