<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;


Route::prefix('notes')
    ->name('notes.')
    ->group(function () {
        Route::get('/', [NoteController::class, 'index'])
            ->name('index');

        Route::post('/', [NoteController::class, 'store'])
            ->name('store');

        Route::put('{id}', [NoteController::class, 'update'])
            ->name('update');

        Route::delete('{id}', [NoteController::class, 'destroy'])
            ->name('destroy');
    });
