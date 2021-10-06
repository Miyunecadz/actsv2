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


Route::prefix('persons')->name('persons.')->group(function(){
    Route::get('search',[PersonController::class,'search'])->name('search');
    Route::get('search/results',[PersonController::class,'results'])->name('search-results');
});

Route::resource('persons', PersonController::class)->middleware('auth');
