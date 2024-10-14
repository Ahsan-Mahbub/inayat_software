<?php

use Illuminate\Support\Facades\Route;
//Other
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SettingController;
//Main
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WattController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TemperatureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'permission'], function(){
    //Profile Update Route
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile-store', [HomeController::class, 'store'])->name('profile.store');
    //Ajax Data Get
    Route::group(['prefix' => 'data-get'], function () {
        Route::get('/account/{id}', [AjaxController::class, 'getAccount']);
        Route::get('/supplier/{id}', [AjaxController::class, 'getSupplier']);
        Route::get('/customer/{id}', [AjaxController::class, 'getCustomer']);
    });
    /*
    |--------------------------------------------------------------------------
    | Main Modules Routes
    |--------------------------------------------------------------------------
    */
    //Category Route
    Route::group(['prefix' => 'category'], function () {
        Route::get('/list', [CategoryController::class, 'index'])->name('category.index');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('edit/{id}', [CategoryController::class, 'edit']);
        Route::post('update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/search', [CategoryController::class, 'search'])->name('category.search');
    });
    //Unit Route
    Route::group(['prefix' => 'unit'], function () {
        Route::get('/list', [UnitController::class, 'index'])->name('unit.index');
        Route::post('store', [UnitController::class, 'store'])->name('unit.store');
        Route::get('edit/{id}', [UnitController::class, 'edit']);
        Route::post('update', [UnitController::class, 'update'])->name('unit.update');
        Route::delete('destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
        Route::get('/search', [UnitController::class, 'search'])->name('unit.search');
    });
    //Watt Route
    Route::group(['prefix' => 'watt'], function () {
        Route::get('/list', [WattController::class, 'index'])->name('watt.index');
        Route::post('store', [WattController::class, 'store'])->name('watt.store');
        Route::get('edit/{id}', [WattController::class, 'edit']);
        Route::post('update', [WattController::class, 'update'])->name('watt.update');
        Route::delete('destroy/{id}', [WattController::class, 'destroy'])->name('watt.destroy');
        Route::get('/search', [WattController::class, 'search'])->name('watt.search');
    });
    //Color Route
    Route::group(['prefix' => 'color'], function () {
        Route::get('/list', [ColorController::class, 'index'])->name('color.index');
        Route::post('store', [ColorController::class, 'store'])->name('color.store');
        Route::get('edit/{id}', [ColorController::class, 'edit']);
        Route::post('update', [ColorController::class, 'update'])->name('color.update');
        Route::delete('destroy/{id}', [ColorController::class, 'destroy'])->name('color.destroy');
        Route::get('/search', [ColorController::class, 'search'])->name('color.search');
    });
    //Temperature Route
    Route::group(['prefix' => 'temperature'], function () {
        Route::get('/list', [TemperatureController::class, 'index'])->name('temperature.index');
        Route::post('store', [TemperatureController::class, 'store'])->name('temperature.store');
        Route::get('edit/{id}', [TemperatureController::class, 'edit']);
        Route::post('update', [TemperatureController::class, 'update'])->name('temperature.update');
        Route::delete('destroy/{id}', [TemperatureController::class, 'destroy'])->name('temperature.destroy');
        Route::get('/search', [TemperatureController::class, 'search'])->name('temperature.search');
    });
    //Product Route
    Route::group(['prefix' => 'product'], function () {
        Route::get('/list', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('store', [ProductController::class, 'store'])->name('product.store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('product.search');
        Route::get('print', [ProductController::class, 'productListPrint'])->name('product.print');
        Route::get('/print-search', [ProductController::class, 'printSearch'])->name('product.print.search');
        Route::get('/export-product', [ProductController::class, 'exportProduct'])->name('product.export');
        Route::get('/export-product-list', [ProductController::class, 'exportProductList'])->name('product.exportlist');
    });
    //Barcode Route
    Route::group(['prefix' => 'barcode'], function () {
        Route::get('/list', [BarcodeController::class, 'index'])->name('barcode.index');
        Route::get('/create', [BarcodeController::class, 'create'])->name('barcode.create');
        Route::post('store', [BarcodeController::class, 'store'])->name('barcode.store');
        Route::post('destroy', [BarcodeController::class, 'destroy'])->name('barcode.destroy');
    });
    //QRCode Route
    Route::group(['prefix' => 'qr-code'], function () {
        Route::get('/list', [QRCodeController::class, 'index'])->name('qr-code.index');
        Route::get('/create', [QRCodeController::class, 'create'])->name('qr-code.create');
        Route::post('store', [QRCodeController::class, 'store'])->name('qr-code.store');
        Route::post('destroy', [QRCodeController::class, 'destroy'])->name('qr-code.destroy');
    });
    //Setting Route
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/index', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/update/{id}', [SettingController::class, 'update'])->name('setting.update');
    });

    // get-all-purchase-data
    Route::get('/get-all-purchase-data', [AjaxController::class, 'getAllPurchaseData'])->name('get-all-purchase-data');
    Route::get('/get-all-category-data', [AjaxController::class, 'getAllCategoryData'])->name('get-all-category-data');
    //Role Route
    Route::group(['prefix' => 'role'], function () {
        Route::get('/list', [RoleController::class, 'index'])->name('role.index');
        Route::post('store', [RoleController::class, 'store'])->name('role.store');
        Route::get('edit/{id}', [RoleController::class, 'edit']);
        Route::post('update', [RoleController::class, 'update'])->name('role.update');
        Route::delete('destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
        Route::get('/search', [RoleController::class, 'search'])->name('role.search');
    });
    //Permission Route
    Route::group(['prefix' => 'permission'], function () {
        Route::get('/list', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });
    //User Route
    Route::group(['prefix' => 'user'], function () {
        Route::get('/list', [UserController::class, 'index'])->name('user.index');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit']);
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::delete('destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/search', [UserController::class, 'search'])->name('user.search');
    });
    //Discount Route
    Route::group(['prefix' => 'discount'], function () {
        Route::get('/list', [DiscountController::class, 'index'])->name('discount.index');
        Route::post('store', [DiscountController::class, 'store'])->name('discount.store');
        Route::get('edit/{id}', [DiscountController::class, 'edit']);
        Route::post('update', [DiscountController::class, 'update'])->name('discount.update');
        Route::delete('destroy/{id}', [DiscountController::class, 'destroy'])->name('discount.destroy');
        Route::get('/search', [DiscountController::class, 'search'])->name('discount.search');
    });
});
