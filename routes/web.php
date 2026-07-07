<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/notes/search', [NoteController::class, 'search']);
    Route::post('/notes/{id}/share', [NoteController::class,'share']);
    Route::get('/notes/{id}/pdf', [NoteController::class, 'pdf']);
     Route::get('/notes/{id}/history', [NoteController::class, 'history']);
     Route::post('/notes/{id}/restore/{versionId}', [NoteController::class, 'restore']);
    Route::resource('notes', NoteController::class);
});

Route::get('/shared/{token}', [NoteController::class,'shared']);