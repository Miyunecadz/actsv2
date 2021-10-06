<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

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

Route::get('persons/search',[PersonController::class,'search'])->name('persons.search');
Route::get('persons/search/results',[PersonController::class,'results'])->name('persons.search-results');
Route::resource('persons', PersonController::class)->middleware('auth');
