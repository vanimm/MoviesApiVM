<?php

use App\Http\Controllers\API\MovieController;
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

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'edit'])->name('movie.edit');
Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movie.update');
Route::post('/movies', [MovieController::class, 'store'])->name('movie.store');
Route::delete('/movies/{id}',[MovieController::class,'destroy'])->name('movie.destroy');

Route::get('/api',[MovieController::class,'getApiMovies'])->name('movies.getApiMovies');


