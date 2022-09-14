<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JokeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/ajax')->group(function () {
    Route::prefix('/joke')->group(function () {
        Route::any('/request',[JokeController::class,'request'])->name('ajax.joke.request');
        Route::any('/confirm',[JokeController::class,'confirm'])->name('ajax.joke.confirm');
    });
});
