<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientLmController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientAddressController;
use App\Http\Controllers\Api\PatientLmDetailController;
use App\Http\Controllers\Api\PatientDiagnosticController;

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

//Components Routes
Route::group(['auth', 'verified'], function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('/brandpage', 'BrandPage')->name('brandpage');
    Route::inertia('/patientpage', 'PatientPage')->name('patientpage');
    Route::inertia('/orderpage', 'Orders/OrderPage')->name('orderpage');
    Route::inertia('/reportspage', 'Reports/ReportPage')->name('reportspage');
});

//Api Rest Routes
Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {

    //Only for allmethods with apiResource
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('patient_lm', PatientLmController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('address', PatientAddressController::class);
    Route::apiResource('patient_lm_details', PatientLmDetailController::class);
    Route::apiResource('patient_diagnostics', PatientDiagnosticController::class);

    //Only for method get
    Route::get('showlmdetail/{id}', [PatientLmDetailController::class, 'showlmdetail']);
    Route::get('export_patients', [PatientController::class, 'export']);
    Route::get('export_orders', [PatientLmController::class, 'export']);
    Route::get('findOrders/{id}', [PatientLmController::class, 'findOrders']);
    Route::get('address_patient/{id}/{category}', [PatientAddressController::class, 'getAddress']);
    Route::get('diagnostic_patient/{id}', [PatientDiagnosticController::class, 'getDiagnostics']);
    Route::get('getOrdersLm/{dateini}/{dateend}', [PatientLmController::class, 'getOrdersLm']);
    Route::get('getOrdersDetail/{dateini}/{dateend}', [PatientLmController::class, 'getOrdersDetail']);

    //Only for method update&patch
    Route::patch('update_order/{id}', [PatientLmController::class, 'update_order']);
    Route::patch('update_diagnostic/{id}', [PatientDiagnosticController::class, 'update_diagnostic']);
    Route::patch('update_price/{id}', [ProductController::class, 'update_price']);
    Route::patch('update_lmcode/{id}', [PatientLmController::class, 'update_lmcode']);
});

require __DIR__.'/auth.php';
