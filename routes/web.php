<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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


Route::post('/login',[LoginController::class,'login'])->name('login');

Route::middleware('auth')->group(function(){

    Route::get('/', [HomeController::class,'home'])->name('home');

    Route::get('persons/search',[PersonController::class,'search'])->name('persons.search');
    
    Route::resources([
        'persons'=> PersonController::class,
        'businesses'=>BusinessController::class
    ]);
    
});

