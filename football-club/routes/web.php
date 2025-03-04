<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/places/create', function () {
    return view('places.create');
})->name('places.create');

Route::get('/games/create', function () {
    return view('games.create');
})->name('games.create');

Route::get('/games/edit', function () {
    return view('games.edit');
})->name('games.edit');

Route::get('/competitions/create', function () {
    return view('competitions.create');
})->name('competitions.create');

Route::get('/competitions/{id}/edit', [CompetitionController::class, 'edit'])->name('competitions.edit');

Route::put('/competitions/{id}', [CompetitionController::class, 'update'])->name('competitions.update');


