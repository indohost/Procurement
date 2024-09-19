<?php

use App\Http\Controllers\Product\CatalogController as ProductCatalogController;
use App\Http\Controllers\Product\ManagementController as ProductManagementController;
use App\Http\Controllers\Vendor\RegistrationController as VendorRegistrationController;
use App\Http\Controllers\Vendor\ReviewController as VendorReviewController;
use Illuminate\Support\Facades\Auth;
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


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes([
    'reset' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Vendors
    |--------------------------------------------------------------------------
    */
    Route::controller(VendorRegistrationController::class)
        ->prefix('vendor-registration')
        ->name('vendor-registration.')
        ->group(function () {
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');

            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update-opened/{id}', 'updateOpened')->name('update-opened');
            Route::post('update/{id}', 'update')->name('update');
        });

    /*
    |--------------------------------------------------------------------------
    | Vendor Reviews
    |--------------------------------------------------------------------------
    */
    Route::controller(VendorReviewController::class)
        ->prefix('vendor-review')
        ->name('vendor-review.')
        ->middleware('permission:menu_review_vendor')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('store/{id}', 'store')->name('store');

            Route::get('show/{id}', 'show')->name('show');
            Route::post('update/{id}', 'update')->name('update');
        });

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::controller(ProductManagementController::class)
        ->prefix('product-management')
        ->name('product-management.')
        ->middleware('permission:menu_product')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');

            Route::get('show/{id}', 'show')->name('show');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');

            Route::delete('destroy/{id}', 'destroy')->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Product Catalogs
    |--------------------------------------------------------------------------
    */
    Route::controller(ProductCatalogController::class)
        ->prefix('product-catalog')
        ->name('product-catalog.')
        ->middleware('permission:menu_product_catalog')
        ->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('show/{id}', 'show')->name('show');
        });
});
