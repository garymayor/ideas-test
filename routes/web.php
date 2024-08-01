<?php

use Illuminate\Support\Facades\Route;

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::post('/search', [App\Http\Controllers\SearchController::class, 'results'])->name('results');

Route::get('/', function () {
    return view('welcome');
});
 