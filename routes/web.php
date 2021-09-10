<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['auth', 'verified'], function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('/brandpage', 'BrandPage')->name('brandpage');
});

Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('products', ProductController::class);
});

require __DIR__.'/auth.php';
