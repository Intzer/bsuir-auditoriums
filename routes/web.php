<?php

use App\Http\Controllers\AuditoriumsController;
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