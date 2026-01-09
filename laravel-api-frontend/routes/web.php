<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SportController::class, 'index'])->name('home.index');
Route::get('/sports', [SportController::class, 'index'])->name('sports.index');
Route::get('/sports/create', [SportController::class, 'create'])->name('sports.create');
Route::post('/sports', [SportController::class, 'store'])->name('sports.store');
Route::delete('/sports/{id}', [SportController::class, 'destroy'])->name('sports.destroy');