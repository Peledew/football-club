<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/places/create', function () {
    return view('places.create');
})->name('places.create');

