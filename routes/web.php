<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Payments\PaymentsController;
use App\Http\Controllers\Products\ProductsController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/seed', function () {

    Artisan::call('db:seed', [
        '--class' => 'UserSeeder'
    ]);

    return redirect('/login')->with('success', 'User berhasil dibuat');
})->name('seed');


Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('pages.index');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');




    #INDEXES/CREATE/STORE
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    #EDIT/UPDATE
    Route::get('/categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    #DELETE
    Route::post('/categories/delete/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');


    #INDEXES/CREATE/STORE
    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store');
    #EDIT/UPDATE
    Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductsController::class, 'update'])->name('products.update');
    #DELETE
    Route::post('/products/delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');




    Route::get('/payment', [PaymentsController::class, 'index'])->name('payment');





    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
