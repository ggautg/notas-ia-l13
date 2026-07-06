<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/notes/search', [NoteController::class, 'search']);
    Route::resource('notes', NoteController::class);
});
