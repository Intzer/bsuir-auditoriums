<?php

use App\Http\Controllers\AuditoriumsController;
use App\Http\Controllers\PathController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuditoriumsController::class, 'index'])->name('auditoriums.index');
Route::get('/auditoriums/{auditorium}', [AuditoriumsController::class, 'show'])->name('auditoriums.show');

Route::get('/path', [PathController::class, 'index'])->name('path.index');

Route::get('/api/v1.0/auditoriums', [AuditoriumsController::class, 'apiAuditoriums']);
