<?php

use App\Http\Controllers\AuditoriumsController;
use App\Http\Controllers\PathController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuditoriumsController::class, 'index'])->name('auditoriums.index');
Route::get('/auditoriums/{auditorium}', [AuditoriumsController::class, 'show'])->name('auditoriums.show');

Route::get('/path', [PathController::class, 'index'])->name('path.index');

Route::get('/api/v1.0/auditoriums', [AuditoriumsController::class, 'apiAuditoriums']);