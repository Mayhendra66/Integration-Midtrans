<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);



Route::middleware(['auth'])->group(function(){

    Route::get('/', function () {
        return view('pages.index');
    });

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

});